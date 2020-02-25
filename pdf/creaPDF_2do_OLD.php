<?php
	#Desactivamos los avisos de Error
	error_reporting(0);
	#Archivo con la conexion para MYSQL
  	//require_once('../conexion/configRepo.php');
	require_once('../conexion/configMedico.php');
	require_once('../conexion/configLogin.php');
	require('mc_table.php');
	#Archivo para armar el PDF
	include_once('PDF1.php');
	#Consultas POO
	require_once('../conexion/funciones_db.php');
	#Configuracion para colocar día y mes en español
	setlocale(LC_ALL,'');

	function limpiarString($texto)
	{
		$textoLimpio = preg_replace('([^A-Za-zñÑáéíóúÁÉÍÓÚ])', ' ', $texto);
		return $textoLimpio;
	}

/*******************************************************************PDF's de Medicos********************************************************************/
	//Esta parte es la que Genera el PDF NOTA CONSULTA-URGENCIAS
	if($_GET['name'] == 'evalPediatrica') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio'])){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			/*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
			$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
			$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM evaluacionpediatrica WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexion, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		/*if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}*/
		/*$acudeFin = $rowC1['acude'];
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		#Query para sacar los datos del 2do cuadro (Materiales)
		$queryMateriales = "SELECT *
							FROM notaurgtriage
							WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus='1'
							ORDER BY id DESC
							LIMIT 1";
		$idMaterial = mysqli_query($conexionMedico, $queryMateriales) or die (mysqli_error($conexionMedico));
		$rowM = mysqli_fetch_array($idMaterial);
		
		$horaT = null;
		
		if($rowM['acude'] != NULL && $rowM['acude'] != ''){
			$fecha = strtotime($rowM['fecha']);
			$fechaFin = date('d/m/Y',$fecha);

			$horaN1 = new DateTime($rowM['hora']);
			$horaT = $horaN1->format('H:i');

			if($rowM['turno'] == 'M'){
				$turno='MATUTINO';
			} else if($rowM['turno'] == 'V'){
				$turno='VESPERTINO';
			} if($rowM['turno'] == 'N'){
				$turno='NOCTURNO';
			}
			$acudeFin=$rowM['acude'];
		}*/
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."  FECHA: ".$fechaFin."   HORA: ".$horaIC." Hrs","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac));
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el texto de un cell
		/*if($rowM['color']=='AMARILLO'){
			 $pdf->SetTextColor(255,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='ROJO'){
			 $pdf->SetTextColor(255,0,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='VERDE'){
			 $pdf->SetTextColor(0,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		}*/
		 $pdf->SetTextColor(0);
			#Variables
			//Array de cadenas para la cabecera
		/*class cab1
		{
			function cabeza(){*/
				/*$cabecera = array(utf8_decode("                                           NOTA MÉDICA DE CONSULTA-URGENCIAS"),"FECHA: ".$fechaFin."     HORA DE INICIO DE CONSULTA: ".$horaIC." Hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("Domicilio: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("  PERSONA QUE ACOMPAÑA: ".$compa_pac),"ARRIBO EN:  ".$acudeFin);
				*/
				//return $cabecera;
			/*}
		}*/
			#$datosPersona = array($fecha1,$area,$entrega,$recibe);
			#$datosPersona = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));

			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Header($cabecera);
			//$pdf->Ln(5);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('HISTORIA CLÍNICA');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('HISTORIA CLÍNICA'),1, 1 , 'C',true);
		
			$pdf->SetFont('Arial','B',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
			//$pdf->Ln();
			
			$pdf->MultiCell(0,7,utf8_decode("                                                                                Evaluación inicial psicológica pediátrica \nNeonatos y Lactantes no se realizará la evaluación de factores de riesgo psicológico. \nMayores de 6 años."),1, 1 , 'C',true);
			//$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(0,6,utf8_decode("1.- Antecedentes Psiquiátricos en la familia\n").$rowC1['antecedentesPsiquiatricos'],1, 'L');
			$pdf->MultiCell(0,6,utf8_decode("2.- Orientación (Personal, lugar y tiempo)\n            ¿Cómo te llamas? ¿Dónde estás? ¿Qué día es hoy?\n").$rowC1['orientacion'],1, 'L');
			$pdf->MultiCell(0,6,utf8_decode("3.- ¿Alteraciones del sueño?\n").$rowC1['alteracionesSueno'],1, 'L');
			$pdf->MultiCell(0,6,utf8_decode("4.- Alteraciones de alimentación (Comer en exceso o dejar de comer)\n").$rowC1['alteracionesAlimentos'],1, 'L');
			$pdf->MultiCell(0,6,utf8_decode("5.- Vida escolar (Cambios de comportamiento en los ultimos 6 meses)\n").$rowC1['vidaEscolar'],1, 'L');
			$pdf->MultiCell(0,6,utf8_decode("6.- Estado animico\n            ¿Se encuentra aletargado o hiperactivo?\n").$rowC1['estadoAnimico'],1, 'L');
			$pdf->MultiCell(0,6,utf8_decode("7.- Memoria\n            Que repita 3 palabras p.e. Edificio, letras, rojo y las repita al final de la entrevista.\n").$rowC1['memoria'],1, 'L');
			$pdf->MultiCell(0,6,utf8_decode("8.- Lenguaje\n            Explorar si padece algún problema para comunicarse y como se expresa durante la entrevista.\n").$rowC1['lenguaje'],1, 'L');
			//2da Pagina
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('          NOMBRE Y FIRMA:'),0,1,'C');
			$pdf->Ln(10);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'    LIC. ELVI CLARA JARAMILLO SOMERA' ,0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: 9900266',0,1,'C');
			$pdf->Cell(0,7,utf8_decode('      ESPECIALIDAD: TRABAJADORA SOCIAL'),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}

/***************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Escala de Goldberg
	if($_GET['name'] == 'goldberg') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio'])){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			/*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
			$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
			$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM escalagoldberg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexion, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$data = array('1',utf8_decode('¿Se ha sentido muy intranquilo, nervioso o en tensión?'));
		$data2 = array('2',utf8_decode('¿Ha estado muy preocupado por algo?'));
		$data3 = array('3',utf8_decode('¿Se ha sentido muy irritable?'));
		$data4 = array('4',utf8_decode('¿Ha tenido dificultad para relajarse?'));
		
		$intranquilo='';
		if($rowC1['intranquilo'] == '1'){
			array_push($data, "    SI ( X )       NO (    ) ",'       1');
			$pIntranquilo= '1';
		} else {
			array_push($data, "    SI (    )       NO ( X ) ",'       0');
			$pIntranquilo= '0';
		}
		
		$preocupado='';
		if($rowC1['preocupado'] == '1'){
			array_push($data2, "    SI ( X )       NO (    ) ",'       1');
			$pPreocupado= '1';
		} else {
			array_push($data2, "    SI (    )       NO ( X ) ",'       0');
			$pPreocupado= '0';
		}
		$irritable='';
		if($rowC1['irritable'] == '1'){
			array_push($data3, "    SI ( X )       NO (    ) ",'       1');
			$pIrritable= '1';
		} else {
			array_push($data3, "    SI (    )       NO ( X ) ",'       0');
			$pIrritable= '0';
		}
		$relajarse='';
		if($rowC1['relajarse'] == '1'){
			array_push($data4, "    SI ( X )       NO (    ) ",'       1');
			$pRelajarse= '1';
		} else {
			array_push($data4, "    SI (    )       NO ( X ) ",'       0');
			$pRelajarse= '0';
		}
		//Cambiar esta query si el paciente se le hace la misma encuentas en el mismo ingreso add despues del Where AND fechaGuardado
		$querySub1 = "SELECT SUM(intranquilo+preocupado+irritable+relajarse) AS res1, SUM(intranquilo+preocupado+irritable+relajarse+dormir+cabeza+vegetativos+preocupadoSalud+conciliarSueno) AS resT1 FROM escalagoldberg WHERE numeroExpediente= '$expediente' AND folio= '$folio' AND estatus=1";
		$resultS1 = mysqli_query($conexion, $querySub1);
		$rowSub1 = mysqli_fetch_array($resultS1);
		
		$subTot1=$rowSub1['res1'];
		$tot1=$rowSub1['resT1'];
		$data_1 = array('',utf8_decode('                                             (Si hay 2 o más respuestas afirmativas, continuar preguntando)'),'           SUBTOTAL','       '.$subTot1);
		
		$data5 = array('5',utf8_decode('¿Ha dormido mal, ha tenido dificultades para dormir?'));
		$data6 = array('6',utf8_decode('¿Ha tenido dolores de cabeza o nuca?'));
		$data7 = array('7',utf8_decode("¿Ha tenido alguno de los siguientes síntomas: temblores, hormigueos, mareos, sudores, diarrea? (Sintomas vegetativos)"));
		$data8 = array('8',utf8_decode('¿Ha estado preocupado por su salud?'));
		$data9 = array('9',utf8_decode('¿Ha tenido alguna dificultad para conciliar el sueño, para quedarse dormido?'));
		
		$dormir='';
		if($rowC1['dormir'] == '1'){
			array_push($data5, " SI ( X )       NO (    ) ",'       1');
			$pDormir= '1';
		} else {
			array_push($data5, " SI (    )       NO ( X ) ",'       0');
			$pDormir= '0';
		}
		$cabeza='';
		if($rowC1['cabeza'] == '1'){
			array_push($data6, " SI ( X )       NO (    ) ",'       1');
			$pCabeza= '1';
		} else {
			array_push($data6, " SI (    )       NO ( X ) ",'       0');
			$pCabeza= '0';
		}
		$vegetativos='';
		if($rowC1['vegetativos'] == '1'){
			array_push($data7, " SI ( X )       NO (    ) ",'       1');
			$pVegetativos= '1';
		} else {
			array_push($data7, " SI (    )       NO ( X ) ",'       0');
			$pVegetativos= '0';
		}
		$preocupadoSalud='';
		if($rowC1['preocupadoSalud'] == '1'){
			array_push($data8, " SI ( X )       NO (    ) ",'       1');
			$pPreocupadoSalud= '1';
		} else {
			array_push($data8, " SI (    )       NO ( X ) ",'       0');
			$pPreocupadoSalud= '0';
		}
		$conciliarSueno='';
		if($rowC1['conciliarSueno'] == '1'){
			array_push($data9, " SI ( X )       NO (    ) ",'       1');
			$pConciliarSueno= '1';
		} else {
			array_push($data9, " SI (    )       NO ( X ) ",'       0');
			$pConciliarSueno= '0';
		}
		$data_2 = array('',utf8_decode('                                                                                                 Puntuación escala de Ansiedad'),'                TOTAL','       '.$tot1);
		
		//Segunda parte de la hoja
		$data10 = array('1',utf8_decode('¿Se ha sentido con poca energía?'));
		$data11 = array('2',utf8_decode('¿Ha perdido usted su interes por las cosas?'));
		$data12 = array('3',utf8_decode('¿Ha perdido la confianza en sí mismo?'));
		$data13 = array('4',utf8_decode('¿Se ha sentido usted desesperanzado, sin esperanzas?'));
		
		$pocaEnergia='';
		if($rowC1['pocaEnergia'] == '1'){
			array_push($data10, " SI ( X )       NO (    ) ",'       1');
			$pPocaEnergia= '1';
		} else {
			array_push($data10, " SI (    )       NO ( X ) ",'       0');
			$pPocaEnergia= '0';
		}
		$interes='';
		if($rowC1['interes'] == '1'){
			array_push($data11, " SI ( X )       NO (    ) ",'       1');
			$pInteres= '1';
		} else {
			array_push($data11, " SI (    )       NO ( X ) ",'       0');
			$pInteres= '0';
		}
		$confianza='';
		if($rowC1['confianza'] == '1'){
			array_push($data12, " SI ( X )       NO (    ) ",'       1');
			$pConfianza= '1';
		} else {
			array_push($data12, " SI (    )       NO ( X ) ",'       0');
			$pConfianza= '0';
		}
		$desesperanzado='';
		if($rowC1['desesperanzado'] == '1'){
			array_push($data13, " SI ( X )       NO (    ) ",'       1');
			$pDesesperanzado= '1';
		} else {
			array_push($data13, " SI (    )       NO ( X ) ",'       0');
			$pDesesperanzado= '0';
		}
		
		//Cambiar esta query si el paciente se le hace la misma encuentas en el mismo ingreso add despues del Where AND fechaGuardado
		$querySub2 = "SELECT SUM(pocaEnergia+interes+confianza+desesperanzado) AS res2, SUM(pocaEnergia+interes+confianza+desesperanzado+concentrarse+peso+despertando+enlentecido+encontrarse) AS resT2 FROM escalagoldberg WHERE numeroExpediente= '$expediente' AND folio= '$folio' AND estatus=1";
		$resultS2 = mysqli_query($conexion, $querySub2);
		$rowSub2 = mysqli_fetch_array($resultS2);
		
		$subTot2=$rowSub2['res2'];
		$tot2=$rowSub2['resT2'];
		$data_3 = array('',utf8_decode('                                        (Si hay al menos una respuesta afirmativa, continuar preguntando)'),'           SUBTOTAL','       '.$subTot2);
		
		$data14 = array('5',utf8_decode('¿Ha tenido dificultades para concentrarse?'));
		$data15 = array('6',utf8_decode('¿Ha perdido peso? (Ha causa de perdida de apetito)'));
		$data16 = array('7',utf8_decode('¿Se ha estado despertando demasiado temprano?'));
		$data17 = array('8',utf8_decode('¿Se ha sentido usted enlentecido?'));
		$data18 = array('9',utf8_decode('¿Cree usted que ha tenido tendencia encontrarse peor por las mañanas?'));
		
		$concentrarse='';
		if($rowC1['concentrarse'] == '1'){
			array_push($data14, " SI ( X )       NO (    ) ",'       1');
			$pConcentrarse= '1';
		} else {
			array_push($data14, " SI (    )       NO ( X ) ",'       0');
			$pConcentrarse= '0';
		}
		$peso='';
		if($rowC1['peso'] == '1'){
			array_push($data15, " SI ( X )       NO (    ) ",'       1');
			$pPeso= '1';
		} else {
			array_push($data15, " SI (    )       NO ( X ) ",'       0');
			$pPeso= '0';
		}
		$despertando='';
		if($rowC1['despertando'] == '1'){
			array_push($data16, " SI ( X )       NO (    ) ",'       1');
			$pDespertando= '1';
		} else {
			array_push($data16, " SI (    )       NO ( X ) ",'       0');
			$pDespertando= '0';
		}
		$enlentecido='';
		if($rowC1['enlentecido'] == '1'){
			array_push($data17, " SI ( X )       NO (    ) ",'       1');
			$pEnlentecido= '1';
		} else {
			array_push($data17, " SI (    )       NO ( X ) ",'       0');
			$pEnlentecido= '0';
		}
		$encontrarse='';
		if($rowC1['encontrarse'] == '1'){
			array_push($data18, " SI ( X )       NO (    ) ",'       1');
			$pEncontrarse= '1';
		} else {
			array_push($data18, " SI (    )       NO ( X ) ",'       0');
			$pEncontrarse= '0';
		}
		$data_4 = array('',utf8_decode('                                                                                                   Puntuación escala de Depresión'),'                TOTAL','       '.$tot1);
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."  FECHA: ".$fechaFin."   HORA: ".$horaIC." Hrs","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac));
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el texto de un cell
		/*if($rowM['color']=='AMARILLO'){
			 $pdf->SetTextColor(255,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='ROJO'){
			 $pdf->SetTextColor(255,0,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='VERDE'){
			 $pdf->SetTextColor(0,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		}*/
		 $pdf->SetTextColor(0);
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Header($cabecera);
			//$pdf->Ln(5);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('HISTORIA CLÍNICA');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('HISTORIA CLÍNICA'),1, 1 , 'C',true);
		
			$pdf->SetFont('Arial','B',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
			//$pdf->Ln();
			
			$pdf->MultiCell(0,5,utf8_decode("                                                                  ESCALA DE DEPRESIÓN Y ANSIEDAD DE GOLDBERG \n¿Usted ha presentado en las ultimas 2 semanas algunos de los siguientes síntomas?\nEs importante intentar contestar TODAS las preguntas."),1, 1 , 'C',true);
		
			$header = array('No.',utf8_decode('Escala de Ansiedad'),utf8_decode('Respuesta (Si / No)'), utf8_decode('Puntuación'));
			//$data = array('1',utf8_decode('¿Está usted satisfecho con la vida que lleva?'));
		
			$w = array(8, 140, 30, 18);
			
			//$pdf->MultiCell(0,5,utf8_decode("                                                                  ESCALA GERÍATRICA DE YESAVAGE \nLos participantes deben responder por sí o por no con respecto a cómo se sintieron en la ultima semana"),1, 1 , 'C',true);
			// Cabecera
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Datos
			$pdf->SetFont('Arial','',7.3);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data2[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data3[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data4[$x],1,0,'L');
				$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data_1[$x],1,0,'L');
				$pdf->Ln();
			//Segunda parte
		$pdf->SetFont('Arial','',7.3);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data5[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data6[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data7[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data8[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data9[$x],1,0,'L');
				$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data_2[$x],1,0,'L');
				$pdf->Ln();
		
			$pdf->SetFont('Arial','',7.3);
		$pdf->Ln(5);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data10[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data11[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data12[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data13[$x],1,0,'L');
				$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data_3[$x],1,0,'L');
				$pdf->Ln();
		
			$pdf->SetFont('Arial','',7.3);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data14[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data15[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data16[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data17[$x],1,0,'L');
				$pdf->Ln();
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data18[$x],1,0,'L');
				$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],6,$data_4[$x],1,0,'L');
				$pdf->Ln();
			
			//$pdf->SetFillColor(255,255,255);
			/*$pdf->MultiCell(0,5,utf8_decode("Escala de Ansiedad                                                                                   |  Respuesta (Si / No)     |               Puntuación"),1, 'C');
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(0,4,utf8_decode("1.- ¿Se ha sentido muy intranquilo, nervioso o en tensión?                                              ").$intranquilo."                                 ".$pIntranquilo,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("2.- ¿Ha estado muy preocupado por algo?                                                                        ").$preocupado."                                 ".$pPreocupado,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("3.- ¿Se ha sentido muy irritable?                                                                                        ").$irritable."                                 ".$pIrritable,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("4.- ¿Ha tenido dificultad para relajarse?                                                                             ").$relajarse."                                 ".$pRelajarse,1, 'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->MultiCell(0,5,utf8_decode("SUBTOTAL"."                                ".$subTot1."                      \n(Si hay 2 o más respuestas afirmativas, continuar preguntando)                                                        "),1, 'R');
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(0,4,utf8_decode("5.- ¿Ha dormido mal, ha tenido dificultades para dormir?                                                   ").$dormir."                                 ".$pDormir,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("6.- ¿Ha tenido dolores de cabeza o nuca?                                                                          ").$cabeza."                                 ".$pCabeza,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("7.- ¿Ha tenido alguno de los siguientes síntomas: temblores, hormigueos,\nmareos, sudores, diarrea? (Sintomas vegetativos)                                                              ").$vegetativos."                                 ".$pVegetativos,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("8.- ¿Ha estado preocupado por su salud?                                                                           ").$preocupadoSalud."                                 ".$pPreocupadoSalud,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("9.- ¿Ha tenido alguna dificultad para conciliar el sueño, para quedarse dormido?              ").$dormir."                                 ".$pDormir,1, 'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->MultiCell(0,5,utf8_decode("                                                                                                        Puntuación total escala de Ansiedad"."                               ".$tot1),1, 'L');
			//2da Parte
			$pdf->MultiCell(0,5,utf8_decode("Escala de Depresión                                                                                        |  Respuesta (Si / No)     |               Puntuación"),1, 'C');
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(0,4,utf8_decode("1.- ¿Se ha sentido con poca energía?                                                                                   ").$pocaEnergia."                                 ".$pPocaEnergia,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("2.- ¿Ha perdido usted su interes por las cosas?                                                                    ").$interes."                                 ".$pInteres,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("3.- ¿Ha perdido la confianza en sí mismo?                                                                            ").$confianza."                                 ".$pConfianza,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("4.- ¿Se ha sentido usted desesperanzado, sin esperanzas?                                                 ").$desesperanzado."                                 ".$pDesesperanzado,1, 'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->MultiCell(0,5,utf8_decode("SUBTOTAL"."                                ".$subTot2."                 \n(Si hay al menos una respuestas afirmativa, continuar preguntando)                                                        "),1, 'R');
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(0,4,utf8_decode("5.- ¿Ha tenido dificultades para concentrarse?                                                                       ").$concentrarse."                                 ".$pConcentrarse,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("6.- ¿Ha perdido peso? (Ha causa de perdida de apetito)                                                        ").$peso."                                 ".$pPeso,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("7.- ¿Se ha estado despertando demasiado temprano?                                                           ").$despertando."                                 ".$pDespertando,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("8.- ¿Se ha sentido usted enlentecido?                                                                                     ").$enlentecido."                                 ".$pEnlentecido,1, 'L');
			$pdf->MultiCell(0,4,utf8_decode("9.- ¿Cree usted que ha tenido tendencia encontrarse peor por las mañanas?                        ").$encontrarse."                                 ".$pEncontrarse,1, 'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->MultiCell(0,5,utf8_decode("                                                                                                         Puntuación total escala de Depresión"."                                  ".$tot2),1, 'L');*/
			$pdf->Ln(3);
			$pdf->Cell(0,5,utf8_decode('          NOMBRE Y FIRMA:'),0,1,'C');
			$pdf->Ln(10);
			$pdf->Cell(0,5,'_______________________________________',0,1,'C');
			$pdf->Cell(0,5,'    LIC. ELVI CLARA JARAMILLO SOMERA' ,0,1,'C');
			$pdf->Cell(0,5,'CEDULA PROFESIONAL: 9900266',0,1,'C');
			$pdf->Cell(0,5,utf8_decode('      ESPECIALIDAD: TRABAJADORA SOCIAL'),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}

/***************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Escala de YESAVAGE
	if($_GET['name'] == 'yesavage') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio'])){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			/*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
			$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
			$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM escalayesavage WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexion, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$data = array('1',utf8_decode('¿Está usted satisfecho con la vida que lleva?'));
		$data2 = array('2',utf8_decode('¿Ha dejado de hacer las cosas que le gustan?'));
		$data3 = array('3',utf8_decode('¿Siente que si vida está vacía?'));
		$data4 = array('4',utf8_decode('¿Se siente aburrido frecuentemente?'));
		$data5 = array('5',utf8_decode('¿Está de buen ánimo la mayor parte del tiempo?'));
		$data6 = array('6',utf8_decode('¿Está preocupado por que piensa que algo malo le va pasar?'));
		$data7 = array('7',utf8_decode('¿Se siente feliz gran parte de su tiempo?'));
		$data8 = array('8',utf8_decode('¿Siente a menudo que no vale nada?'));
		$data9 = array('9',utf8_decode('¿Prefiere estar sin hacer nada en casa durante el día que salir a la calle?'));
		$data10 = array('10',utf8_decode('¿Piensa que tiene más problemas de memoria que la mayoría de la gente de su edad?'));
		$data11 = array('11',utf8_decode('¿Piensa que es agradable estar vivo?'));
		$data12 = array('12',utf8_decode('¿Siente que vale poco en su actual condición?'));
		$data13 = array('13',utf8_decode('¿Se siente lleno de energía?'));
		$data14 = array('14',utf8_decode('¿Se encuentra sin esperanza por su condición actual?'));
		$data15 = array('15',utf8_decode('¿Piensa que la mayoría de la gente tiene más suerte que usted?'));
		
		$satisfecho='';
		if($rowC1['satisfecho'] == '1'){
			array_push($data, " ( X ) ", " (    ) ");
		} else {
			array_push($data, " (    ) ", " ( X ) ");
		}
		$dejadoCosas='';
		if($rowC1['dejadoCosas'] == '1'){
			array_push($data2, " ( X ) ", " (    ) ");
		} else {
			array_push($data2, " (    )", " ( X ) ");
		}
		$vidaVacia='';
		if($rowC1['vidaVacia'] == '1'){
			array_push($data3, " ( X ) ", " (    ) ");
		} else {
			array_push($data3, " (    ) ", " ( X ) ");
		}
		$aburrido='';
		if($rowC1['aburrido'] == '1'){
			array_push($data4, " ( X ) ", " (    ) ");
		} else {
			array_push($data4, " (    ) ", " ( X ) ");
		}
		$buenAnimo='';
		if($rowC1['buenAnimo'] == '1'){
			array_push($data5, " ( X ) ", " (    ) ");
		} else {
			array_push($data5, " (    ) ", " ( X ) ");
		}
		$maloPasar='';
		if($rowC1['maloPasar'] == '1'){
			array_push($data6, " ( X ) ", " (    ) ");
		} else {
			array_push($data6, " (    ) ", " ( X ) ");
		}
		$feliz='';
		if($rowC1['feliz'] == '1'){
			array_push($data7, " ( X ) ", " (    ) ");
		} else {
			array_push($data7, " (    ) ", " ( X ) ");
		}
		$valeNada='';
		if($rowC1['valeNada'] == '1'){
			array_push($data8, " ( X ) ", " (    ) ");
		} else {
			array_push($data8, " (    ) ", " ( X ) ");
		}
		$salirCalle='';
		if($rowC1['salirCalle'] == '1'){
			array_push($data9, " ( X ) ", " (    ) ");
		} else {
			array_push($data9, " (    ) ", " ( X ) ");
		}
		$memoria='';
		if($rowC1['memoria'] == '1'){
			array_push($data10, " ( X ) ", " (    ) ");
		} else {
			array_push($data10, " (    ) ", " ( X ) ");
		}
		$agradableVivo='';
		if($rowC1['agradableVivo'] == '1'){
			array_push($data11, " ( X ) ", " (    ) ");
		} else {
			array_push($data11, " (    ) ", " ( X ) ");
		}
		$valePoco='';
		if($rowC1['valePoco'] == '1'){
			array_push($data12, " ( X ) ", " (    ) ");
		} else {
			array_push($data12, " (    ) ", " ( X ) ");
		}
		$llenoEnergia='';
		if($rowC1['llenoEnergia'] == '1'){
			array_push($data13, " ( X ) ", " (    ) ");
		} else {
			array_push($data13, " (    ) ", " ( X ) ");
		}
		$sinEsperanza='';
		if($rowC1['sinEsperanza'] == '1'){
			array_push($data14, " ( X ) ", " (    ) ");
		} else {
			array_push($data14, " (    ) ", " ( X ) ");
		}
		$suerte='';
		if($rowC1['suerte'] == '1'){
			array_push($data15, " ( X ) ", " (    ) ");
		} else {
			array_push($data15, " (    ) ", " ( X ) ");
		}
		
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."  FECHA: ".$fechaFin."   HORA: ".$horaIC." Hrs","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac));
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el texto de un cell
		/*if($rowM['color']=='AMARILLO'){
			 $pdf->SetTextColor(255,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='ROJO'){
			 $pdf->SetTextColor(255,0,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='VERDE'){
			 $pdf->SetTextColor(0,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		}*/
		 $pdf->SetTextColor(0);
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Header($cabecera);
			//$pdf->Ln(5);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('HISTORIA CLÍNICA');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('HISTORIA CLÍNICA'),1, 1 , 'C',true);
		
			$pdf->SetFont('Arial','B',10);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
			//$pdf->Ln();
		
			$header = array('No.', 'Preguntas', 'SI', 'NO');
			//$data = array('1',utf8_decode('¿Está usted satisfecho con la vida que lleva?'));
			
		
			$w = array(10, 156, 15, 15);
		
			
			$pdf->MultiCell(0,5,utf8_decode("                                                                  ESCALA GERÍATRICA DE YESAVAGE \nLos participantes deben responder por sí o por no con respecto a cómo se sintieron en la ultima semana"),1, 1 , 'C',true);
			// Cabecera
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();
			// Datos
		
			for($x=0; $x < 8;$x++)
				$pdf->Cell($w[$x],7,$data[$x],1,0,'L');
			$pdf->Ln();
			for($a=0; $a < 8; $a++)
				$pdf->Cell($w[$a],7,$data2[$a],1,0,'L');
			$pdf->Ln();
			for($b=0; $b < 8; $b++)
				$pdf->Cell($w[$b],7,$data3[$b],1,0,'L');
			$pdf->Ln();
			for($c=0; $c < 8; $c++)
				$pdf->Cell($w[$c],7,$data4[$c],1,0,'L');
			$pdf->Ln();
			for($d=0; $d < 8; $d++)
				$pdf->Cell($w[$d],7,$data5[$d],1,0,'L');
			$pdf->Ln();
			for($e=0; $e < 8; $e++)
				$pdf->Cell($w[$e],7,$data6[$e],1,0,'L');
			$pdf->Ln();
			for($f=0; $f < 8; $f++)
				$pdf->Cell($w[$f],7,$data7[$f],1,0,'L');
			$pdf->Ln();
			for($g=0; $g < 8; $g++)
				$pdf->Cell($w[$g],7,$data8[$g],1,0,'L');
			$pdf->Ln();
			for($h=0; $h < 8; $h++)
				$pdf->Cell($w[$h],7,$data9[$h],1,0,'L');
			$pdf->Ln();
			for($i=0; $i < 8; $i++)
				$pdf->Cell($w[$i],7,$data10[$i],1,0,'L');
			$pdf->Ln();
			for($j=0; $j < 8; $j++)
				$pdf->Cell($w[$j],7,$data11[$j],1,0,'L');
			$pdf->Ln();
			for($k=0; $k < 8; $k++)
				$pdf->Cell($w[$k],7,$data12[$k],1,0,'L');
			$pdf->Ln();
			for($l=0; $l < 8; $l++)
				$pdf->Cell($w[$l],7,$data13[$l],1,0,'L');
			$pdf->Ln();
			for($m=0; $m < 8; $m++)
				$pdf->Cell($w[$m],7,$data14[$m],1,0,'L');
			$pdf->Ln();
			for($n=0; $n < 8; $n++)
				$pdf->Cell($w[$n],7,$data15[$n],1,0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(15);
			$pdf->Cell(0,7,utf8_decode('          NOMBRE Y FIRMA:'),0,1,'C');
			$pdf->Ln(10);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'    LIC. ELVI CLARA JARAMILLO SOMERA' ,0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: 9900266',0,1,'C');
			$pdf->Cell(0,7,utf8_decode('      ESPECIALIDAD: TRABAJADORA SOCIAL'),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}

/***************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF FACTORES DE RIESGO SOCIAL
	if($_GET['name'] == 'frs') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio'])){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			/*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
			$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
			$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM factoresriesgosocial WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexion, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$sumaTotal=$rowC1['divorcio']+$rowC1['economica']+$rowC1['muerte']+$rowC1['trabajo']+$rowC1['discapacidad']+$rowC1['legales']+$rowC1['jubilacion']+$rowC1['residencia']+$rowC1['enfermedad']+$rowC1['colegio']+$rowC1['desempleo']+$rowC1['droga']+$rowC1['embarazo'];
		
		$data = array(utf8_decode('Divorcio o separación matrimonial'),$rowC1['divorcio'],utf8_decode(" Cambio de situación Económica"), $rowC1['economica']);
		$data2 = array(utf8_decode('Muerte de un familiar cercano de fecha reciente'),$rowC1['muerte'],utf8_decode(" Cambio de trabajo"), $rowC1['trabajo']);
		$data3 = array(utf8_decode('Discapacidad permanente'),$rowC1['discapacidad'],utf8_decode(" Problemas legales"), $rowC1['legales']);
		$data4 = array(utf8_decode('Jubilación'),$rowC1['jubilacion'],utf8_decode(" Cambio de residencia"), $rowC1['residencia']);
		$data5 = array(utf8_decode('Enfermedad o accidente de un importante miembro de la familia'),$rowC1['enfermedad'],utf8_decode(" Cambio de colegio"), $rowC1['colegio']);
		$data6 = array(utf8_decode('Desempleo'),$rowC1['desempleo'],utf8_decode(" Drogadicción y/o alcoholismo"), $rowC1['droga']);
		$data7 = array(utf8_decode('Embarazo no deseado'),$rowC1['embarazo'],utf8_decode(" Puntuación Total"), $sumaTotal);
		$data8 = array(utf8_decode('Rechazo de transfuciones: '),utf8_decode(" Rechazo al uso de medicamentos: "));
		$data9 = array($rowC1['transfusiones'], $rowC1['medicamentos']);
		$data10 = array(utf8_decode('Rechazo al tipo de alimentación: '),utf8_decode(" Rechazo a ser atendido por algún tipo de género o persona de nuestro hospital: "));
		$data11 = array($rowC1['alimentacion'], $rowC1['genero']);
		$data12 = array('Otro: ', $rowC1['otro']);
		
		//array_push($data, utf8_decode(" Cambio de situación Económica"), $rowC1['economica']);
		
		
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."  FECHA: ".$fechaFin."   HORA: ".$horaIC." Hrs","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac));
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el texto de un cell
		/*if($rowM['color']=='AMARILLO'){
			 $pdf->SetTextColor(255,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='ROJO'){
			 $pdf->SetTextColor(255,0,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		} else if($rowM['color']=='VERDE'){
			 $pdf->SetTextColor(0,255,0);
			 $color=$pdf->Cell(153,165,$rowM['color'],0,1,'C');
		}*/
		 $pdf->SetTextColor(0);
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Header($cabecera);
			//$pdf->Ln(5);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('HISTORIA CLÍNICA');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('HISTORIA CLÍNICA'),1, 1 , 'C',true);
		
			$pdf->SetFont('Arial','B',10);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
			//$pdf->Ln();
		
			//$header = array('No.', 'Preguntas', 'SI', 'NO');
			//$data = array('1',utf8_decode('¿Está usted satisfecho con la vida que lleva?'));
			
		
			$w = array(120, 8, 60, 8);
		
			
			$pdf->MultiCell(0,5,utf8_decode("                                                                                      Factores de riesgo social \n                                                                            (Acontecidos en los últimos 6 meses)"),1, 1 , 'C',true);
			// Cabecera
			//for($i=0;$i<count($header);$i++)
				/*$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();*/
			// Datos
		
			for($x=0; $x < 4;$x++)
				$pdf->Cell($w[$x],7,$data[$x],1,0,'L');
			$pdf->Ln();
			for($a=0; $a < 8; $a++)
				$pdf->Cell($w[$a],7,$data2[$a],1,0,'L');
			$pdf->Ln();
			for($b=0; $b < 8; $b++)
				$pdf->Cell($w[$b],7,$data3[$b],1,0,'L');
			$pdf->Ln();
			for($c=0; $c < 8; $c++)
				$pdf->Cell($w[$c],7,$data4[$c],1,0,'L');
			$pdf->Ln();
			for($d=0; $d < 8; $d++)
				$pdf->Cell($w[$d],7,$data5[$d],1,0,'L');
			$pdf->Ln();
			for($e=0; $e < 8; $e++)
				$pdf->Cell($w[$e],7,$data6[$e],1,0,'L');
			$pdf->Ln();
			for($f=0; $f < 8; $f++)
				$pdf->Cell($w[$f],7,$data7[$f],1,0,'L');
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(0,5,utf8_decode("Interpretación:\n <39 Bajo impacto para su padecimiento actual\n 40 - 90 Moderado impacto para su padecimiento actual\n >90 Alto impacto para su padecimiento actual"), 1,'L');
			$pdf->MultiCell(0,5,utf8_decode("Escala de Evaluación de reajuste social (SRRS) de Holmes y Rahe modificada.\n Fuente: De la Revilla Ahumada Luis, Conceptos e instrumentos de atención familiar. Barcelona. Edit. Doyman; 1994."), 1,'L');
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->MultiCell(0,5,utf8_decode("                           Valores, costumbres y creencias que dificultan el proceso de atención de paciente"),1, 1 , 'C',true);
			$pdf->SetFont('Arial','',10);
			$t = array(98,98);
			for($g=0; $g < 2; $g++)
				$pdf->Cell($t[$g],7,$data8[$g].$data9[$g],1,0,'L');
			$pdf->Ln();
				$pdf->Cell($t[0],7,$data10[0].$data11[0],1,'L');
				$pdf->Cell($t[1],7,$data12[0].$data12[1],1,'L');
			$pdf->Ln();
				$pdf->Multicell($t[1],4,$data10[1].$data11[1],1,'L');
			$pdf->MultiCell(0,5,utf8_decode("Nota: ".$rowC1['nota1']),1,'L');
			$pdf->Ln();
			$pdf->MultiCell(0,5,utf8_decode("                           Evaluación de factores de riesgo psicológicos (Llenar solo el grupo de edad que aplique)"),1, 1 , 'C',true);
			if($rowC1['riesgoPedia']<2){
				if($rowC1['riesgoPedia']==1){
					$pdf->Cell(0,7,utf8_decode("Paciente Pediátrico: \n Se detecta riesgo : \n SI: ( X )  NO: ( )"),1,'L');
				}
				if($rowC1['riesgoPedia']==0){
					$pdf->Cell(0,7,utf8_decode("Paciente Pediátrico: \n Se detecta riesgo : \n SI: (  )  NO: ( X )"),1,'L');
				}
			}
			if($rowC1['riesgoAdulto']<2){
				if($rowC1['riesgoAdulto']==1){
					$pdf->Cell(0,7,utf8_decode("Adulto 18 a 64 años: \n Se detecta riesgo : \n SI: ( X )  NO: ( )") ,1,'L');
				}
				if($rowC1['riesgoAdulto']==0){
					$pdf->Cell(0,7,utf8_decode("Adulto 18 a 64 años: \n Se detecta riesgo : \n SI: (  )  NO: ( X )") ,1,'L');
				}
			}
			if($rowC1['riesgoGeria']<2){
				if($rowC1['riesgoGeria']==1){
					$pdf->Cell(0,7,utf8_decode("Geriátrico 64 años o más: \n Se detecta riesgo : \n SI: ( X )  NO: ( )") ,1,'L');
				}
				if($rowC1['riesgoGeria']==0){
					$pdf->Cell(0,7,utf8_decode("Geriátrico 64 años o más: \n Se detecta riesgo : \n SI: (  )  NO: ( X )") ,1,'L');
				}
			}
			$pdf->Ln();
			$pdf->MultiCell(0,5,utf8_decode("Nota: ".$rowC1['nota2']),1,'L');
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(15);
			$pdf->Cell(0,7,utf8_decode('          NOMBRE Y FIRMA:'),0,1,'C');
			$pdf->Ln(10);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,5,'    LIC. ELVI CLARA JARAMILLO SOMERA' ,0,1,'C');
			$pdf->Cell(0,5,'CEDULA PROFESIONAL: 9900266',0,1,'C');
			$pdf->Cell(0,5,utf8_decode('      ESPECIALIDAD: TRABAJADORA SOCIAL'),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}

/******************************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Nota Trabajo Social
	if($_GET['name'] == 'notats') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio'])){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			/*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
			$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
			$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notatrabajosocial WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexion, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."  FECHA: ".$fechaFin."   HORA: ".$horaIC." Hrs","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac));
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Header($cabecera);
			//$pdf->Ln(5);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('Nota de Treabajo Social');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('Nota de Treabajo Social'),1, 1 , 'C',true);
		
			$pdf->SetFont('Arial','B',10);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
			//$pdf->Ln();
			$pdf->Cell(0,5,utf8_decode("Nota de Trabajo Social"),1, 1 , 'C',true);
			$pdf->SetFont('Arial','',10);
			$long=strlen($rowC1['nota']);
			$cad1 = $rowC1['nota'].' ______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________';
			$cad2 = $rowC1['nota'].' _______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________';
			$pdf->MultiCell(0,5,$long < 150 ? $cad2:$cad1, 1, 'L');
			// Cabecera
			$pdf->Ln(15);
			$pdf->Cell(0,7,utf8_decode('          NOMBRE Y FIRMA:'),0,1,'C');
			$pdf->Ln(10);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'    LIC. ELVI CLARA JARAMILLO SOMERA' ,0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: 9900266',0,1,'C');
			$pdf->Cell(0,7,utf8_decode('      ESPECIALIDAD: TRABAJADORA SOCIAL'),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Consentimiento Ingreso a Urgencias - Urgencias
	if($_GET['name'] == 'consentimientoIu') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			$cuarto_pac = trim($resultado[0][0]['CVE_CUARTO']);
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM consentimientoiuurg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		/*$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);*/
		
		$fecha1 = strtotime($rowC1['fechaIu']);
		$fechaFin1 = date('d/m/Y',$fecha1);
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		$cedula_med = trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%'";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
		$months = array('enero','febrero','marzo','abril','mayo',
				'junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
		$fecha2 = strtotime($rowC1['fecha']);
		$d1 = date('d',$fecha2);
		$m1 = date('m',$fecha2);
		$mi1 = intval($m1);
		$a1 = date('Y',$fecha2);
		
		//Declaramos la cabecera
		//$cabecera = array(utf8_decode('                                                                                 CUERNAVACA, MORELOS A '.$d1.' DE '.$months[$mi1-1].' DEL '.$a1),"EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("NOMBRE DEL PADRE/MADRE O TUTOR: ".$compa_pac ),"NOMBRE DE OTRA PERSONA LEGALMENTE RESPONSABLE : ".$compa_pac);
		
		$pdf = new PDF();
		//$pdf->setCabeza($cabecera);
		//$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		//$pdf->SetFillColor(200,200,200);
		//$pdf->setTitulo('CARTA DE CONSENTIMIENTO INFORMADO PARA INGRESO HOSPITALARIO');
		$pdf->SetXY(60,32);
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA INGRESO A URGENCIAS'),0, 0, 'C');
		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(48);
		$dato1 =utf8_decode('Nombre del Paciente: <b>'.trim($nombre_pac).'</b>');
		$dato2 =utf8_decode('Fecha de Nacimiento: <b>'.trim($fecha_nac_pac).'</b>     Edad: <b>'.$annios.'</b>     Sexo: <b>'.$sexo_pac.'</b>');
		$dato3 =utf8_decode('Nombre del Padre/Madre o Tutor: <b>'.trim($compa_pac).'</b>');
		$dato4 =utf8_decode('Nombre de Otra Persona Legalmente Responsable: <b>'.trim($compa_pac).'</b>');
		
		$pdf->MultiCell(0,4,utf8_decode('Cuernavaca, Morelos a '.$d1.' de '.$months[$mi1-1].' del '.$a1),0,'R');
		$pdf->MultiCell(0,4,$pdf->WriteHTML($dato1),0,'L');
		$pdf->MultiCell(0,4,$pdf->WriteHTML($dato2),0,'L');
		$pdf->MultiCell(0,4,$pdf->WriteHTML($dato3),0,'L');
		$pdf->MultiCell(0,4,$pdf->WriteHTML($dato4),0,'L');
		$pdf->Ln();
		$pdf->MultiCell(0,5,utf8_decode('Yo (nosotros) autorizo el ingreso al Hospital Henri Dunant con el fin de diagnosticar o recibir tratamiento para tratar mi padecimiento actual. Autorizo al Hospital Henri Dunant, a todos los médicos, a todos los asociados, asistentes técnicos y demás proveedores de cuidados de la salud de dicha institución a proporcionar todos los servicios médicos que sean necesarios, así como todos los estudios de laboratorio y gabinete que sean necesarios para mi diagnóstico, con el objetivo de mejorar mi estado de salud. Autorizo para la atención de contingencias y urgencias derivadas del acto autorizado, atendiendo al principio de libertad prescriptiva.'),0,'J');
		$pdf->Ln();
		$pdf->MultiCell(0,5,utf8_decode('Yo (nosotros) entiendo que existen riesgos y probables complicaciones derivados de cualquier atención médica a que pueda ser sometido durante mi estancia en urgencia; también estoy consciente de que la administración de medicamentos, de cualquier índole, puede generar fenómenos alérgicos y/o anafilácticos, sin que ello sea responsabilidad directa o indirecta del médico tratante, de los médicos, de todos los asociados, asistentes técnicos y demás proveedores de cuidados en la salud o del Hospital Henri Dunant. Yo (nosotros) entiendo que no se me proporciona garantía alguna respecto de ningún resultado ni cura. No se garantizan o aseguran los resultados del o los procedimientos o tratamientos a los sea sometido por indicación de médica. El personal médico y demás asistentes se basarán en la información proporcionada por mi persona y/o mi representante para la realización de la historia clínica para determinar el o los procedimientos a practicar o el curso del tratamiento para tratar mi condición. Manifiesto, que he sido informado a mi satisfacción y se me ha ofrecido la oportunidad de formular preguntas.'),0,'J');
		$pdf->Ln();
		$html1 =utf8_decode('Yo (nosotros) estoy informado que está autorización inicial  no  excluye  la  necesidad de recabar después  la  firma correspondiente para procedimientos médicos, quirúrgicos, de diagnóstico y de alto riesgo.  Este consentimiento cumple  con los requisitos establecidos  en  la Ley general de Salud sus reglamentos y normas oficiales, así como los de la Ley de Salud del Estado de Morelos. Con fundamento en el artículo  4to.  De  la  Constitución  Política  de  los Estados  Unidos  Mexicanos, <b>la  Norma Oficial  Mexicana  NOM-004-SSA3-2012  del Expediente  Clínico. Artículos  42,  43,  53,  54,  55,  57  de  la  Ley General  de Salud;  Artículos  29,  46,  76,  78,  80,  81  y  82 del Reglamento de  la Ley General de Salud en materia  de  Prestación de Atención Médica. Artículos  42,  43,  54 de la Ley de Salud del Estado de Morelos.</b>');
		//$html2 =utf8_decode('<b>No se permite el ingreso de medicamentos que requieran red fría o red obscura (termolábiles o termosensibles)</b>');
		$html3 =utf8_decode('<b>En mi presencia han sido llenados o cancelados todos los espacios en blanco que se presenten en este documento</b>');
		$html6 =utf8_decode('<b>Declaración médica:</b> Yo certifico que el  paciente/padre/madre/tutor  u  otra persona legalmente responsable  han sido informados sobre los riesgos y peligros, los beneficios y alternativas de tratamiento según se explico anteriormente, que todas sus preguntas relativas a mi área de experiencia han sido respondidas y que ha otorgado su consentimiento.');
		//$pdf->Ln();
		$pdf->MultiCell(0,4,$pdf->WriteHTML($html1),0,'J');
		$pdf->Ln();
		$pdf->MultiCell(0,12,$pdf->WriteHTML($html3),0,'J');
		
		//Termina hoja1
		//3ra Pagina
		$pdf->Ln(10);
		$pdf->Cell(0,7,'          _______________________________________                    __________________________________________',0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                '.$nombre_pac.'                                        '.$compa_pac),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                     Nombre y firma del paciente                                            Nombre y firma del padre/madre/tutor u otra persona'),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                                                                                                                                        legalmente responsable'),0,1,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,7,'__________________________________________________________________________________________________________',0,1,'C');
		$pdf->Cell(0,10,utf8_decode('Motivo por el que el paciente no puede firmar.'),0,1,'C');
		$pdf->Cell(0,20,'',0,1,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(60,32);
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA INGRESO A URGENCIAS'),0, 0, 'C');
		$pdf->Cell(0,20,'',0,1,'C');
		$pdf->MultiCell(0,20,$pdf->WriteHTML($html6),0,'L');
		//$pdf->Ln();
		
		//$pdf->Ln(10);
		if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(0,5,'',0,0,'L',$pdf->Image($firma_Med,20,null,50,30));
			$pdf->Ln(1);
		} else {
		 	$pdf->Ln(10);
		}
		$pdf->Cell(0,7,'     _______________________________________                                     ______________________________________',0,1,'L');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,5,'         Dr.(a): '.utf8_decode($nombre_med).'                    Nombre y Firma del Testigo',0,1,'L');
		} else {
			$pdf->Cell(0,5,'         Dr.(a): '.$rowC1['nombreMedicoTratante'].'                    Nombre y Firma del Testigo',0,1,'L');
		}
		$pdf->Cell(0,5,utf8_decode('                 Cédula Profesional: ').$cedula_med,0,1,'L');
		//$pdf->Cell(0,7,utf8_decode('               Especialidad: '.$especialidad_med),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('      Nombre, Firma y Cédula Profesional del Médico Tratante'),0,1,'L');
		$pdf->SetFont('Arial','B',9);
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('ESTE DOCUMENTO DEBERÁ SER REDACTADO EN FORMA CLARA, SIN ABREVIATURAS ENMENDADURAS O TACHADURAS.'),0, 0, 'C');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF SOLICITUD PARA LABORATORIO
	if($_GET['name'] == 'laboratorio') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M' || $sexo_pac == 'm') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			$cuarto_pac = trim($resultado[0][0]['CVE_CUARTO']);
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM laboratorio WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['horaSolicitud']);
		$horaIC = $horaN->format('H:i');
		
		$fecha = strtotime($rowC1['fechaSolicitud']);
		$fechaFin1 = date('d/m/Y',$fecha);
		
		/*$fecha1 = strtotime($rowC1['fechaSolicitud']);
		$fechaFin1 = date('d/m/Y',$fecha1);
		
		$hora1 = strtotime($rowC1['horaSolicitud']);
		$$horaIC = date('H:i',$hora1);*/
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedulaT']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		$nombre_med = limpiarString($nombre_med);
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed1[] = $usuario1->medicosCed($rowC1['cedulaS']);
		$nombre_meds = $resultadoMed1[0][0]['DESC_MEDICO'];
	   	$especialidad_meds = $resultadoMed1[0][0]['DESC_ESPEC'];
		$cedula_meds = $resultadoMed1[0][0]['CEDULA_MEDICO'];
		$nombre_meds = limpiarString($nombre_meds);
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio']."     SERVICIO:".$rowC1['servicio'],"FECHA: ".$fechaFin1." hrs","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac."     CAMA:".$$cuarto_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('SOLICITUD DE EXÁMENES DE LABORATORIO');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('SOLICITUD DE EXÁMENES DE LABORATORIO'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',8);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(55);
		$pdf->MultiCell(0,4,"Hora de Solicitud: ".$horaIC ." Hrs",1,'L');
		$pdf->MultiCell(0,4,"Hora de Toma de Muestra:",1,'L');
		$pdf->MultiCell(0,4,"Muestra Tomada por:",1,'L');
		$pdf->MultiCell(0,4,utf8_decode("Número de Punciones:"),1,'L');
		//$pdf->Ln();
		$pdf->Cell(0,6,utf8_decode('Exámenes Solicitados'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,4,$rowC1['examenes'],1,'L');
		
		$pdf->Cell(0,4,utf8_decode('Diagnóstico Presuntivo'),1, 1 ,'C',true);
		$pdf->MultiCell(0,4,$rowC1['diagnostico'],1,'L');
		#PlanQx
		#$pdf->Ln();
	
		$pdf->Ln();
		$pdf->Cell(0,6,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO TRATANTE                                                                            NOMBRE Y FIRMA DEL MÉDICO SOLICITANTE'),0,1,'L');
		$pdf->Ln(9);
		$pdf->Cell(0,6,'_______________________________________                                                                            __________________________________________',0,1,'L');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,1,'     '.utf8_decode($nombre_med),0,1,'L');
		} else {
			$pdf->Cell(0,1,'     '.$rowC1['nombreMedicoTratante'],0,1,'L');
		}
		if($nombre_meds != NULL || $nombre_meds != ''){
			$pdf->Cell(0,1,'                                                                                                                                                               '.utf8_decode($nombre_meds),0,1,'L');
		} else {
			$pdf->Cell(0,1,'                                                                                                                                                                '.$rowC1['nombreMedicoSolicitante'],0,1,'L');
		}
		
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,5,'     CEDULA PROFESIONAL: '.$cedula_med.'                                                                                      CEDULA PROFESIONAL: '.$cedula_meds,0,1,'L');
			$pdf->Cell(0,4,utf8_decode('     ESPECIALIDAD: '.$especialidad_med.'                                                             ESPECIALIDAD: '.$especialidad_meds),0,1,'L');
			//$pdf->Footer('2');
		} else {
			$pdf->Cell(0,5,'     CEDULA PROFESIONAL: '.$cedula_med.'                                                                                                                CEDULA PROFESIONAL: '.$cedula_meds,0,1,'L');
			$pdf->Cell(0,4,utf8_decode('     ESPECIALIDAD: '.$especialidad_med.'                                                                                                                               ESPECIALIDAD: '.$especialidad_meds),0,1,'L');
		}
		
		$pdf->Cell(0,6,'-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'L');
		$pdf->MultiCell(0,4,"Hora de Solicitud: ".$horaIC ." Hrs",1,'L');
		$pdf->MultiCell(0,4,"Hora de Toma de Muestra:",1,'L');
		$pdf->MultiCell(0,4,"Muestra Tomada por:",1,'L');
		$pdf->MultiCell(0,4,utf8_decode("Número de Punciones:"),1,'L');
		//$pdf->Ln();
		$pdf->Cell(0,6,utf8_decode('Exámenes Solicitados'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,4,$rowC1['examenes'],1,'L');
		
		$pdf->Cell(0,6,utf8_decode('Diagnóstico Presuntivo'),1, 1 ,'C',true);
		$pdf->MultiCell(0,4,$rowC1['diagnostico'],1,'L');
		#PlanQx
		#$pdf->Ln();
	
		$pdf->Ln();
		$pdf->Cell(0,6,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO TRATANTE                                                                            NOMBRE Y FIRMA DEL MÉDICO SOLICITANTE'),0,1,'L');
		$pdf->Ln(9);
		$pdf->Cell(0,6,'_______________________________________                                                                            __________________________________________',0,1,'L');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,1,'     '.utf8_decode($nombre_med),0,1,'L');
		} else {
			$pdf->Cell(0,1,'     '.$rowC1['nombreMedicoTratante'],0,1,'L');
		}
		if($nombre_meds != NULL || $nombre_meds != ''){
			$pdf->Cell(0,1,'                                                                                                                                                               '.utf8_decode($nombre_meds),0,1,'L');
		} else {
			$pdf->Cell(0,1,'                                                                                                                                                                '.$rowC1['nombreMedicoSolicitante'],0,1,'L');
		}
		
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,5,'     CEDULA PROFESIONAL: '.$cedula_med.'                                                                                      CEDULA PROFESIONAL: '.$cedula_meds,0,1,'L');
			$pdf->Cell(0,4,utf8_decode('     ESPECIALIDAD: '.$especialidad_med.'                                                             ESPECIALIDAD: '.$especialidad_meds),0,1,'L');
			//$pdf->Footer('2');
		} else {
			$pdf->Cell(0,5,'     CEDULA PROFESIONAL: '.$cedula_med.'                                                                                                                CEDULA PROFESIONAL: '.$cedula_meds,0,1,'L');
			$pdf->Cell(0,4,utf8_decode('     ESPECIALIDAD: '.$especialidad_med.'                                                                                                                               ESPECIALIDAD: '.$especialidad_meds),0,1,'L');
		}
		$pdf->Output(); //Salida al navegador del pdf
	}

/*******************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Receta Medica
	if($_GET['name']=='indicacionesMT') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		#El arreglo esta vacio 
		if (!empty($resultado[0])) {
			$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];
			if($sexo_pac == 'M' || $sexo_pac == 'm') {
				$sexo_pac='MASCULINO';
			} else {
				$sexo_pac='FEMENINO';
			}
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			//$annios = $annios->y;
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			$cuarto_pac = trim($resultado[0][0]['CVE_CUARTO']);
			#Direccion del paciente
			$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
		}
		
		$queryCuadro1 = "SELECT * FROM indicacionesmt WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY id DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		$acudeFin = $rowC1['acude'];
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		$indicaciones = $rowC1['indicaciones'];
		$idMedicamentos = $rowC1['idMedicamentos'];
		$medicamentos = $rowC1['medicamentos'];
		$sal = $rowC1['sal'];
		$existencias = $rowC1['existencias'];
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%'";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
		if($indicaciones != NULL && $indicaciones != ''){
			$arreglado = trim($indicaciones, '[');
			$arreglado1 = trim($arreglado, ']');
			$indicac = explode("},",$arreglado1);

			$arreglado2 = trim($idMedicamentos, '[');
			$arreglado3 = trim($arreglado2, ']');
			$idMedicam = explode(",",$arreglado3);

			$arreglado4 = trim($medicamentos, '[');
			$arreglado5 = trim($arreglado4, ']');
			$medicam = explode(",",$arreglado5);

			$arreglado6 = trim($sal, '[');
			$arreglado7 = trim($arreglado6, ']');
			$salMed = explode("},",$arreglado7);
			
			$arreglado8 = trim($existencias, '[');
			$arreglado9 = trim($arreglado8, ']');
			$existMed = explode("},",$arreglado9);

			$longitud = count($medicam);
		}
		
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"FECHA: ".$fechaFin,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac."     CAMA:".$$cuarto_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setEspacio('TRUE');
		$pdf->setCabeza($cabecera);
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('INDICACIONES MÉDICAS');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('INDICACIONES MÉDICAS'),1, 1 , 'C',true);

		//$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		//$pdf->SetY(60);

		/*$pdf->SetTextColor(0);
		$pdf->SetFillColor(200,200,200);
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('RECETA MÉDICA'),1, 1 , 'C',true);*/
			#Variables
			//Array de cadenas para la cabecera
			/*$cabecera = array("FECHA: ".$fechaFinG,"NOMBRE COMPLETO DEL PACIENTE: ".$rowC1['nombrePac'],"FECHA DE NACIMIENTO: ".$fechaFinN.'   EDAD: '.utf8_decode($annios),"ALERGIAS: ".$rowC1['alergias'],utf8_decode("DIAGNÓSTICO: ").$rowC1['diag']);*/
			
			//$pdf->Header('2');
			//$pdf->tablaSimple2($cabecera); //Método que integra datos
			//$pdf->Ln(5);
			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			
			#Indic
			$pdf->SetY(50);
			$pdf->Ln();
			$pdf->SetFillColor(200,200,200);
			
			$pdf->Cell(0,6,utf8_decode('DIETA'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,5,$rowC1['dieta'],1,'L');
			
			$pdf->Cell(0,6,utf8_decode('MEDIDAS GENERALES'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,5,$rowC1['medidasGral'],1,'L');
		
			$pdf->Cell(0,6,utf8_decode('SOLUCIONES'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,5,$rowC1['soluciones'],1,'L');
		
			$pdf->Cell(0,6,utf8_decode('MEDICAMENTOS Y SUS INDICACIONES'),1, 1 ,'C',true);
			//$subs = substr($horaIndic[0], 10, -2);
		
			//$pdf->MultiCell(0,7,'Tamanio:'.$longitud.' '.'INDICACION 1: '.$subs,1,'L');
			$c = 1;
			for($i=0; $i<$longitud; $i++) {
				$fi = substr($idMedicam[$i+1], 9, -2);
				$hi = substr($medicam[$i],17, -2);
				$reemp = array('"', '}');
				$si = substr(str_replace($reemp,"",$salMed[$i]),6);
				$ei = substr(str_replace($reemp,"", $existMed[$i]), 8);
				$ii = substr(str_replace($reemp,"", $indicac[$i]), 6);
				/*if(strlen($indicac[0]) <= 15) {
					$ii = substr($indicac[$i+1], 10, -2);
				} else {
					$ii = substr($indicac[$i], 10, -2);
				}*/
				//Descomentar si deseamos ver el numero de existencias en la receta
				$existN = NULL;
				/*if($ei != null && $ei != ''){
					$existN = '     Existencias: '.$ei;
				}*/
				
				$pdf->MultiCell(0,5,$c++.' - '.$hi.' '.$si.$existN."\n".$ii,1,'L');
			}
		
			$pdf->Cell(0,6,utf8_decode('LABORATORIOS'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,5,$rowC1['laboratorios'],1,'L');
			$pdf->Cell(0,6,utf8_decode('OTROS'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,5,$rowC1['otros'],1,'L');
		
			$pdf->Ln();
			
			$pdf->Cell(0,6,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO TRATANTE:'),0,1,'C');
			if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
			$pdf->Ln(1);
			} else {
				$pdf->Ln(10);
			}
			$pdf->Cell(0,5,'_______________________________________',0,1,'C');
			$pdf->SetFont('Arial','',8);
			if($nombre_med != NULL || $nombre_med != ''){
				$pdf->Cell(0,5,'                 '.utf8_decode($nombre_med),0,1,'C');
			} else {
				$pdf->Cell(0,5,'                 '.$rowC1['nombreMedicoTratante'],0,1,'C');
			}
			$pdf->Cell(0,5,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,5,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');	
			//$pdf->MultiCell(0,7,$rowC1['indicacion'],1,'L');
			
			$pdf->SetY(-31);
			// Arial italic 8
			$pdf->SetFont('Arial','I',8);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFillColor(160,210,250);
			/* Cell(ancho, alto, txt, border, ln, alineacion)
			 * ancho=0, extiende el ancho de celda hasta el margen de la derecha
			 * alto=10, altura de la celda a 10
			 * txt= Texto a ser impreso dentro de la celda
			 * border=T Pone margen en la posición Top (arriba) de la celda
			 * ln=0 Indica dónde sigue el texto después de llamada a Cell(), en este caso con 0, enseguida de nuestro texto
			 * alineación=C Texto alineado al centro
			 */
			//$pdf->Cell(0,10,utf8_decode('www.henridunant.com.mx Río Pánuco No. 100, Col. Lomas de Los Volcanes C.P. 62350 Cuernavaca, Morelos Tels. 316-7992, 316-0486 y 322-2442'),'T',0,'C',true);
			#Trata
			/*$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('TRATAMIENTO UTILIZÓ:   ').$rowC1['tratUtil'],1, 1 ,'C',true);
			$pdf->MultiCell(0,7,utf8_decode($rowC1['tratUtilTxt']),1,'L');*/
		
			//2da Pagina
			//$pdf->Ln();
			
			$pdf->Output(); //Salida al navegador del pdf
	}
?>