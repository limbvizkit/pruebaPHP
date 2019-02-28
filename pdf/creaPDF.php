<?php
	#Desactivamos los avisos de Error
	error_reporting(0);
	#Archivo con la conexion para MYSQL
  	require_once('../conexion/configRepo.php');
	require_once('../conexion/configMedico.php');
	require('mc_table.php');
	#Archivo para armar el PDF
	include_once('PDF1.php');
	#Consultas POO
	require_once('../conexion/funciones_db.php');
	#Configuracion para colocar día y mes en español
	setlocale(LC_ALL,'');

/*******************************************************************PDF's de Medicos********************************************************************/
	//Esta parte es la que Genera el PDF NOTA CONSULTA-URGENCIAS
	if($_GET['name'] == 'ncu') {
		
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
		$queryCuadro1 = "SELECT * FROM notaurg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
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
		}
		
		//Declaramos la cabecera
		$cabecera = array("FECHA: ".$fechaFin."          HORA DE INICIO DE CONSULTA: ".$horaIC." Hrs.          TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("Domicilio: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac),"ARRIBO EN:  ".$acudeFin);
		
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
			$pdf->setTitulo('NOTA MÉDICA DE CONSULTA-URGENCIAS');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('NOTA MÉDICA DE CONSULTA-URGENCIAS'),1, 1 , 'C',true);
		
			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
			//$pdf->Ln();
			
			$pdf->Cell(0,7,'TRIAGE ',1, 1 , 'C',true);
			//$pdf->SetFillColor(255,255,255);
			$pdf->MultiCell(0,7,'HORA: '.$horaT.utf8_decode(' Hrs    Motivo de la Atención: ').$rowM['motivo'],0, 'L');
			$pdf->MultiCell(0,7,'TA:'.$rowM['ta'].' mmHg     FC: '.$rowM['fc'].' min     FR: '.$rowM['fr'].' min     Temp.: '.$rowM['temp'].utf8_decode('°C     SatO2: ').$rowM['so'],0, 'L');
			$pdf->MultiCell(0,7,'PESO: '.$rowM['peso'].' Kg     TALLA: '.$rowM['talla'].' Mts    COLOR:  '.$rowM['color'].utf8_decode('   REALIZÓ: ').$rowM['realizo'],0, 'L');
			//$pdf->Rect(10,95,200,10,'');
			//$pdf->Rect(10,105,200,20,'');
			//$pdf->Ln();
			#ANTECED PERS
			$pdf->Cell(0,7,'ANTECEDENTES PERSONALES: ',1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['antecedentes'],0,'L');
		 	//$pdf->Rect(10,125,200,10,'');
			/*$pdf->Ln(5);
			$pdf->MultiCell(0,7,'TRATAMIENTO (CONCILIACION DE MEDICAMENTOS): '.$rowC1['tratamiento'],1, 'L');*/
			#Pad act
			$pdf->Ln(5);
			$pdf->Cell(0,7,'INTERROGATORIO',1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,'PADECIMIENTO ACTUAL: '.$rowC1['interrogatorio'],0,'L');
			#Interrog
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 , 'C',true);
			$pdf->MultiCell(0,7,'SIGNOS VITALES: HORA: '.$horaIC.' Hrs.  FC: '.$rowC1['fc'].' min  FR: '.$rowC1['fr'].' min  T/A:'.$rowC1['ta'].' mmHg  TEMP: '.$rowC1['temp'].utf8_decode('°C  SO2: ').$rowC1['so'],1,'L');
			#Multicell es por si se llena la linea da un salto automaticamente
			$pdf ->MultiCell(0,7,'ESTADO MENTAL Y HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
			$pdf ->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
			$pdf ->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
			$pdf ->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
			#ResEstudios
			$pdf->Ln();
			$pdf->Cell(0,7,'RESULTADOS DE ESTUDIOS',1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['resEst'],0,'L');
			#Diag
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICOS'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['diag'],0,'L');
		
			#Trata			
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('TRATAMIENTO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['tratamientoFin'],0,'L');
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('PRONÓSTICO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,utf8_decode('VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'].'      Ingresa a: '.$rowC1['ingresa'],0,'L');
			//Termina hoja1
			//2da Pagina
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}

/******************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA CONSULTA Y CHOQUE
	if($_GET['name']=='ncch') {
		
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
			$nombre_pac = $resultado[0][0]['NOMBRE'];
			$edad_pac = $resultado[0][0]['EDAD_PAC'];
			$sexo_pac = $resultado[0][0]['SEXO_PAC'];

			if($sexo_pac == 'M'){
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

		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notaurgchoque WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus='1' ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		
		$horaS = new DateTime($rowC1['horaSol']);
		$horaSol = $horaS->format('H:i');
		
		$horaA = new DateTime($rowC1['horaAcud']);
		$horaAcud = $horaA->format('H:i');
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		/*$queryMateriales = "SELECT *
							FROM notaurgtriage
							WHERE numeroExpediente = '$expediente' AND folio= '$folio'
							ORDER BY fecha DESC, hora DESC
							LIMIT 1";
		$idMaterial = mysqli_query($conexionMedico, $queryMateriales) or die (mysqli_error($conexionMedico));
		$rowM = mysqli_fetch_array($idMaterial);
		$turno = null;
		
		$fecha = strtotime($rowM['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$horaN1 = new DateTime($rowM['hora']);
		$horaT = $horaN1->format('H:i');*/				
		
		$cabecera = array("FECHA: ".$fechaFin."          HORA DE INICIO DE CONSULTA: ".$horaIC." Hrs.          TURNO: ".$turno,utf8_decode("NOMBRE: ".$nombre_pac),"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("Domicilio: ".$calle_pac .'  Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac),"ARRIBO EN:  ".$rowC1['acude']);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el teto de un cell
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
			/*$cabecera = array(utf8_decode("                                NOTA INICIAL DE  SERVICIO DE URGENCIAS Y CHOQUE"),"FECHA: ".$fechaFin."     HORA DE INICIO DE CONSULTA: ".$horaIC." Hrs.     TURNO: ".$turno,utf8_decode("NOMBRE: ".$nombre_pac),"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("Domicilio: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("  PERSONA QUE ACOMPAÑA: ".$compa_pac),"ARRIBO EN:  ".$rowC1['acude']);*/
			#$datosPersona = array($fecha1,$area,$entrega,$recibe);
			#$datosPersona = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));

			
			//imprimimos un texto
			#$pdf->MultiCell(0,5,utf8_decode('APLICA: Cuando el activo fijo, equipo menor y herramienta de trabajo es NUEVO O USADO y se ha inventariado, identificándose dentro de un área especificada.'));
			#$pdf->Cell(0,7,utf8_decode('identificándose dentro de un área especificada.'),0, 0, 'L');
			//$pdf->Header('2');
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('NOTA INICIAL DE  SERVICIO DE URGENCIAS Y CHOQUE');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('NOTA INICIAL DE  SERVICIO DE URGENCIAS Y CHOQUE'),1, 1 , 'C',true);

			//$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
		
			//$pdf->Ln(5);
			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetFillColor(200,200,200);
			/*$pdf->Cell(0,7,'TRIAGE ',1, 1 , 'C',true);
			//$pdf->SetFillColor(255,255,255);
			$pdf->MultiCell(0,7,'HORA: '.$horaT.utf8_decode(' Hrs    Motivo de la Atención: ').$rowM['motivo'],0, 'L');
			$pdf->MultiCell(0,7,'TA:'.$rowM['ta'].' mmHg     FC: '.$rowM['fc'].' min     FR: '.$rowM['fr'].' min     Temp.: '.$rowM['temp'].utf8_decode('°C     SatO2: ').$rowM['so'],0, 'L');
			$pdf->MultiCell(0,7,'PESO: '.$rowM['peso'].' Kg     TALLA: '.$rowM['talla'].' Mts    COLOR:  '.$rowM['color'].utf8_decode('   REALIZÓ: ').$rowM['realizo'],0, 'L');*/
			//$pdf->Rect(10,95,200,10,'');
			//$pdf->Rect(10,105,200,20,'');
			//$pdf->Ln();
			#ANTECED PERS
			$pdf->Cell(0,7,'ANTECEDENTES PERSONALES: ',1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['antecedentes'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TRATAMIENTO (CONCILIACIÓN DE MEDICAMENTOS): ').$rowC1['tratamiento'],1,'L');
			
		 	//$pdf->Rect(10,125,200,10,'');
			/*$pdf->Ln(5);
			$pdf->MultiCell(0,7,'TRATAMIENTO (CONCILIACION DE MEDICAMENTOS): '.$rowC1['tratamiento'],1, 'L');*/
			#Pad act
			$pdf->Ln(5);
			$pdf->Cell(0,7,'INTERROGATORIO',1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,'PADECIMIENTO ACTUAL: '.$rowC1['interrogatorio'],1,'L');
			#Interrog
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 , 'C',true);
			$pdf->MultiCell(0,7,'SIGNOS VITALES: HORA: '.$horaIC.' Hrs.  FC: '.$rowC1['fc'].' min  FR: '.$rowC1['fr'].' min  T/A:'.$rowC1['ta'].' mmHg  TEMP: '.$rowC1['temp'].utf8_decode('°C  SO2: ').$rowC1['so'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('                                                                                           VALORACIÓN NEUROLÓGICA:                                                              ').'RESPUESTA OCULAR: '.$rowC1['respOcul'].'   RESPUESTA VERBAL: '.$rowC1['respVerb'].'   RESPUESTA MOTORA: '.$rowC1['respMot'].'   TOTAL: '.$rowC1['totalValNeu'],1,'L');
		
			#Multicell es por si se llena la linea da un salto automaticamente
			$pdf ->MultiCell(0,7,'ESTADO MENTAL Y HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
			$pdf ->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
			$pdf ->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
			$pdf ->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
			#ResEstudios
			/*$pdf->Ln();
			$pdf->Cell(0,7,'RESULTADOS DE ESTUDIOS',1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['resEst'],0,'L');*/
			#Paraclinicos
			$pdf->Ln();
			$bhc = $rowC1['bhc']==1 ? 'SI':'NO';
			$qs = $rowC1['qs']==1 ? 'SI':'NO';
			$tpt = $rowC1['tpt']==1 ? 'SI':'NO';
			$rx = $rowC1['rx']==1 ? 'SI':'NO';
			$tac = $rowC1['tac']==1 ? 'SI':'NO';
			$rm = $rowC1['rm']==1 ? 'SI':'NO';
			$us = $rowC1['us']==1 ? 'SI':'NO';
			
			$pdf->Cell(0,7,utf8_decode('PARACLÍNICOS  BHC: ').$bhc.'   QS: '.$qs.'   TPT: '.$tpt.'   RX: '.$rx.'   TAC: '.$tac.utf8_decode('   RESONANCIA MAGNÉTICA: ').$rm.'   ULTRASONIDO: '.$us,1, 1 ,'C',true);
			$pdf->MultiCell(0,7,utf8_decode('Interpretación de Estudios Paraclínicos: ').$rowC1['paraclin'],1,'L');
			
			#Diag
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICOS'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['diag'],1,'L');
			
			#Trata
			/*$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('TRATAMIENTO UTILIZÓ:   ').$rowC1['tratUtil'],1, 1 ,'C',true);
			$pdf->MultiCell(0,7,utf8_decode($rowC1['tratUtilTxt']),1,'L');*/


			#interconsul
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('INTERCONSULTA:   ').$rowC1['interconsulta'],1, 1 ,'C',true);
			$pdf->MultiCell(0,7,'HORA DE SOLICITUD: '.$horaSol.' hrs.   ESPECIALIDAD: '.$rowC1['especialidad'],1,'L');
			
			#Pronostico
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('PRONÓSTICO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,'VIDA: '.$rowC1['vida'].utf8_decode('  FUNCIÓN: '.$rowC1['funcion']).'   Ingresa a: '.$rowC1['ingresa'],1,'L');
			//Termina hoja1
			//2da Pagina
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
	}
/*******************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Indicaciones Médicas
	if($_GET['name']=='indm') {
		
		if(isset ($_GET['idIndicMed'])){
			$idIndicMed = $_GET['idIndicMed'];
		}
		/*if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}*/
		
		
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM indicacionesmedicas WHERE id = '$idIndicMed'";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$fecha = date_create($rowC1['fNacimiento']);
		$fechaFinN = date_format($fecha, 'd/m/Y');
		
		$fecha1G = date_create($rowC1['fechaG']);
		$fechaFinG = date_format($fecha1G, 'd/m/Y');
		$indicaciones = $rowC1['indicacion'];
		$fechaI = $rowC1['fechaInd'];
		$horaI = $rowC1['horaInd'];
		$cedula = $rowC1['cedula'];
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($cedula);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		$universidad_med = $resultadoMed[0][0]['UNIVERSIDAD_CEDULA_MEDICO'];
		
		if($indicaciones != NULL && $indicaciones != ''){
				//$pdf->MultiCell(0,7,'SI if 1',1,'L');
				//var_dump(json_decode($indicaciones,true));
				$arreglado = trim($indicaciones, '[');
				$arreglado1 = trim($arreglado, ']');
				
				$indicac = explode("},",$arreglado1);
				//$indicac = json_decode($arr, true);
				//$longitud = count($indicac);
			
				//$arr = is_array($ar) ? 'ARRAY':'NO ES';
				$arreglado2 = trim($fechaI, '[');
				$arreglado3 = trim($arreglado2, ']');
			
				$fechaIndic = explode(",",$arreglado3);
			
				$arreglado4 = trim($horaI, '[');
				$arreglado5 = trim($arreglado4, ']');
			
				$horaIndic = explode(",",$arreglado5);
				$longitud = count($horaIndic);
					
				//$fechaIndic = json_decode($rowC1['fechaInd'],true);
				//echo '<br>Fecha : '.$fechaIndic[1]['fechaI'];

				//var_dump(json_decode($horaInd,true));
				//$horaIndic = json_decode($rowC1['horaInd'],true);

				/*echo '<br>HORA OTRO: '.$fechaInd;
				echo 'HORA: '.$horaIndic[1]['horaI'];*/
				//$pdf->MultiCell(0,7,'Conteo:'.$longitud,1,'L');
		}
		/*$hora1G = new DateTime($rowC1['hora']);
		$horaNewG = $hora1G->format('H:i');*/
		
		$cabecera = array("FECHA: ".$fechaFinG."  HORA: ".$rowC1['horaG']." hrs.","NOMBRE COMPLETO DEL PACIENTE: ".$rowC1['nPaciente'],"FECHA DE NACIMIENTO: ".$fechaFinN,"ALERGIAS: ".$rowC1['alergias'],utf8_decode("MÉDICO TRATANTE: ").$rowC1['medTratante'],utf8_decode("DIAGNÓSTICO: ").$rowC1['diagnostico']);
		
		$pdf = new PDF();
		$pdf->setEspacio('TRUE');
		$pdf->setCabeza($cabecera);
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos

		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('HOJA DE INDICACIONES MÉDICAS');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('HOJA DE INDICACIONES MÉDICAS'),1, 1 , 'C',true);

		//$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		//$pdf->SetY(60);

		/*$pdf->SetTextColor(0);
		$pdf->SetFillColor(200,200,200);
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('HOJA DE INDICACIONES MÉDICAS'),1, 1 , 'C',true);*/
			#Variables
			//Array de cadenas para la cabecera
			/*$cabecera = array("FECHA: ".$fechaFinG."  HORA: ".$rowC1['horaG']." hrs.","NOMBRE COMPLETO DEL PACIENTE: ".$rowC1['nPaciente'],"FECHA DE NACIMIENTO: ".$fechaFinN,"ALERGIAS: ".$rowC1['alergias'],utf8_decode("MÉDICO TRATANTE: ").$rowC1['medTratante'],utf8_decode("DIAGNÓSTICO: ").$rowC1['diagnostico']);*/
			
			//$pdf->Header('2');
			//$pdf->tablaSimple2($cabecera); //Método que integra datos
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			
			$pdf->SetY(60);
			#Indic
			$pdf->Ln();
			$pdf->SetFillColor(200,200,200);
			$pdf->Cell(0,7,utf8_decode('INDICACIONES MÉDICAS'),1, 1 ,'C',true);
			$subs = substr($horaIndic[0], 10, -2);
		
			//$pdf->MultiCell(0,7,'Tamanio:'.$longitud.' '.'INDICACION 1: '.$subs,1,'L');
		
			for($i=0; $i<$longitud; $i++){
				$fi = substr($fechaIndic[$i+1], 11, -2);
				$hi = substr($horaIndic[$i],10, -2);
				if(strlen($indicac[0]) <= 15){
					$ii = substr($indicac[$i+1], 10, -2);
				} else {
					$ii = substr($indicac[$i], 10, -2);
				}
				$pdf->MultiCell(0,7,$fi.' - '.$hi.'hrs.   '."\n".$ii,1,'L');
			}
		
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		
		
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
			/*$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'                                                                 ___________________________________________',0,1,'L');
			$pdf->Cell(0,7,utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('ESPECIALIDAD: '.$especialidad_med),0,1,'C');*/			
			
			$pdf->Output(); //Salida al navegador del pdf
	}
/*******************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Triage por día
	if($_POST['name']=='triage') {
		
		//if(isset($_POST['fecha1'])){
		$fecha1 = $_POST['fecha1'];
		//}
		$fecha0 = date_create($fecha1);
		$fechaFin0 = date_format($fecha0, 'd/m/Y');
		
		$pdf = new PDF();
		#$pdf->Header('1');
		$pdf->AddPage('L', 'Legal'); //Horizontal, Carta
		$pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos

		$pdf->SetTextColor(0);
		$pdf->SetFillColor(200,200,200);
		$pdf->Cell(0,7,utf8_decode('REPORTE DE TRIAGE DEL '.$fechaFin0),1, 1 , 'C',true);
			#Variables
		$pdf->SetFont('Arial','',7); //Arial, normal, 6 puntos
		$cabecera = array("No.","Exp.","Nombre del Paciente","Hora Ini","Hora Fin","Turno","Acude","Motivo","TA","FC","FR","Temp","SO","Glucosa","Peso","Talla","Color","Realizo");
		
		$queryCuadro1 = "SELECT id, numeroExpediente, folio, hora, horaFin, turno, acude, motivo, ta, fc, fr, temp, so, glucosa, peso, talla, 
						 color, realizo
							FROM notaurgtriage
							WHERE fecha = '$fecha1' AND estatus='1'
							ORDER BY hora";
		
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$triage = array();
		$c=1;
		//$rowC1 = mysqli_fetch_array($result0);
		while($row = mysqli_fetch_array($result0)){
			$triage[] = ($row);
			
			$expediente=$row['numeroExpediente'];
			$folio=$row['folio'];
			//Otros Campos
		
			/*$fecha = date_create($rowC1['fecha']);
			$fechaFin = date_format($fecha, 'd/m/Y');*/

			$hora1G = new DateTime($rowC1['hora']);
			$horaNew = $hora1G->format('H:i');

			$turno=$row['turno'];
			
			//Array de cadenas para la cabecera
			//$datos = array($c++,$expediente,'asdfd',$horaNew."h.",$row['turno'],$row['acude'],$row['motivo'],$row['ta'],$row['fc'],$row['fr'],$row['temp'],$row['so'],$row['peso'],$row['talla'],$row['color'],$row['realizo']);
		}
			//$pdf->Header('2');
			//$pdf->tablaSimple2($cabecera); //Método que integra datos
			$pdf->BasicTable($cabecera,$triage);
			//$pdf->Ln(5);
			//$pdf->SetFont('Arial','',9);
			//$pdf->Footer('2');
			$pdf->Output(); //Salida al navegador del pdf
	}

/*******************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Receta Medica
	if($_GET['name']=='receta') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}
		
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM receta WHERE numeroExpediente = '$expediente' AND folio='$folio' AND estatus='1' ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$nPac= utf8_decode($rowC1['nombrePac']);
		$fecha = date_create($rowC1['fechaNacimiento']);
		$fechaFinN = date_format($fecha, 'd/m/Y');
		
		$date2 = $fecha;
	    $fecha_nac_pac = $date2->format('d/m/Y');
		$hoy = new DateTime();
		$anniosO = $hoy->diff($date2);
		$annios = $anniosO->format('%y Año(s)');
		$anniosBool = $anniosO->format('%y');
		if($anniosBool == '0'){
			$annios = $anniosO->format('%m Mes(es)');
		}
		
		$diagnostico = utf8_decode($rowC1['diag']);
		$alergias = utf8_decode($rowC1['alergias']);
		$nMed = utf8_decode($rowC1['nombreMed']);
		$cedula = $rowC1['cedula'];
		$univMed = utf8_decode($rowC1['universidad']);
		$fecha1G = date_create($rowC1['fecha']);
		$fechaFinG = date_format($fecha1G, 'd/m/Y');
		
		$indicaciones = $rowC1['indicaciones'];
		$idMedicamentos = $rowC1['idMedicamentos'];
		$medicamentos = $rowC1['medicamentos'];
		$sal = $rowC1['sal'];
		$existencias = $rowC1['existencias'];
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		$usuario1 = new FuncionesDB();
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($cedula);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		$universidad_med = $resultadoMed[0][0]['UNIVERSIDAD_CEDULA_MEDICO'];
		
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
		
		$cabecera = array("FECHA: ".$fechaFinG,"NOMBRE COMPLETO DEL PACIENTE: ".$rowC1['nombrePac'],"FECHA DE NACIMIENTO: ".$fechaFinN.'   EDAD: '.utf8_decode($annios),"ALERGIAS: ".$rowC1['alergias'],utf8_decode("DIAGNÓSTICO: ").$rowC1['diag']);
		
		$pdf = new PDF();
		$pdf->setEspacio('TRUE');
		$pdf->setCabeza($cabecera);
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('RECETA MÉDICA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('RECETA MÉDICA'),1, 1 , 'C',true);

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
			$pdf->Cell(0,7,utf8_decode('MEDICAMENTOS/INDICACIONES'),1, 1 ,'C',true);
			//$subs = substr($horaIndic[0], 10, -2);
		
			//$pdf->MultiCell(0,7,'Tamanio:'.$longitud.' '.'INDICACION 1: '.$subs,1,'L');
			$c = 1;
			for($i=0; $i<$longitud; $i++) {
				$fi = substr($idMedicam[$i+1], 9, -2);
				$hi = substr($medicam[$i],17, -2);
				$reemp = array('"', '}');
				$si = substr(str_replace($reemp,"",$salMed[$i]),6);
				$ei = substr(str_replace($reemp,"", $existMed[$i]), 8);
				$ii = substr(str_replace($reemp,"", $indicac[$i+1]), 7);
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
				
				$pdf->MultiCell(0,7,$c++.' - '.$hi.' '.$si.$existN."\n".$ii,1,'L');
			}
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,'                                                 UNIVERSIDAD : '.$universidad_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');	
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

/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA DE EVOLUCION
	if($_GET['name'] == 'nevo') {
		
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
			/*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
			$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
			$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
			
			//Colocar habitacion del paciente si es que tiene
			$cuarto_pac = trim($resultado[0][0]['CVE_CUARTO']);
			$habitacion_pac=NULL;
			if($cuarto_pac != NULL && $cuarto_pac != ''){
				$habitacion_pac=utf8_decode("   HABITACIÓN: ").$cuarto_pac;
			}
			
			$date2 = $resultado[0][0]['NACIO_PA'];
			$fecha_nac_pac = $date2->format('d/m/Y');
			$hoy = new DateTime();
			$anniosO = $hoy->diff($date2);
			$annios = $anniosO->format('%y Año(s)');
			$anniosBool = $anniosO->format('%y');
			if($anniosBool == '0'){
				$annios = $anniosO->format('%m Mes(es)');
			}
			#Direccion del paciente
			/*$calle_pac = trim($resultado[0][0]['DIR_PAC']);
			$col_pac = trim($resultado[0][0]['COL_PAC']);
			$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
			$cp_pac = trim($resultado[0][0]['CP_PAC']);
			$obligado_pac = $resultado[0][0]['OBLI_PAC'];
			$tel_pac = trim($resultado[0][0]['TEL_PAC']);
			$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);*/
		}
		$turno = null;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notaEvolucion WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY id DESC";
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
		
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'].$habitacion_pac."   SERVICIO: ".$rowC1['servicio'],"FECHA: ".$fechaFin."          HORA: ".$horaIC." Hrs.          TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,"DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac,"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		//$pdf->setEspacio(60);
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el teto de un cell
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
			/*$cabecera = array(utf8_decode("                                                             NOTA DE EVOLUCIÓN"),"SERVICIO: ".$rowC1['servicio'],"FECHA: ".$fechaFin."     HORA: ".$horaIC." Hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac);*/
			#$datosPersona = array($fecha1,$area,$entrega,$recibe);
			#$datosPersona = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));

			
			//imprimimos un texto
			#$pdf->MultiCell(0,5,utf8_decode('APLICA: Cuando el activo fijo, equipo menor y herramienta de trabajo es NUEVO O USADO y se ha inventariado, identificándose dentro de un área especificada.'));
			#$pdf->Cell(0,7,utf8_decode('identificándose dentro de un área especificada.'),0, 0, 'L');
			//$pdf->Header('2');
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Ln(15);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('NOTA DE EVOLUCIÓN');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('NOTA DE EVOLUCIÓN'),1, 1 , 'C',true);

			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
		
			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetFillColor(200,200,200);
			$pdf->Cell(0,7,'SIGNOS VITALES ',1, 1 , 'C',true);
			//$pdf->SetFillColor(255,255,255);
			$pdf->MultiCell(0,7,'TA:'.$rowC1['ta'].' mmHg    FC: '.$rowC1['fc'].' min    FR: '.$rowC1['fr'].' min    Temp.: '.$rowC1['temp'].utf8_decode('°C    SatO2: ').$rowC1['so'].'%    GLUCOSA: '.$rowC1['glucosa'].' mg/dl    PESO: '.$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' Mts ',1, 'L');
			//$pdf->MultiCell(0,7,'PESO: '.$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' Mts ',0, 'L');
			//$pdf->Rect(10,95,200,10,'');
			//$pdf->Rect(10,105,200,20,'');
			$pdf->Ln();
			#ANTECED PERS
			$pdf->Cell(0,7,utf8_decode('EVOLUCIÓN: '),1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['evolucion'],1,'L');
		 	//$pdf->Rect(10,125,200,10,'');
			/*$pdf->Ln(5);
			$pdf->MultiCell(0,7,'TRATAMIENTO (CONCILIACION DE MEDICAMENTOS): '.$rowC1['tratamiento'],1, 'L');*/
			#Pad act
			/*$pdf->Ln(5);
			$pdf->Cell(0,7,'INTERROGATORIO',1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,'PADECIMIENTO ACTUAL: '.$rowC1['interrogatorio'],0,'L');*/
			#Interrog
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 , 'C',true);
			//$pdf->MultiCell(0,7,'SIGNOS VITALES: HORA: '.$horaIC.' Hrs.  FC: '.$rowC1['fc'].' min  FR: '.$rowC1['fr'].' min  T/A:'.$rowC1['ta'].' mmHg  TEMP: '.$rowC1['temp'].utf8_decode('°C  SO2: ').$rowC1['so'],1,'L');
			#Multicell es por si se llena la linea da un salto automaticamente
			$pdf ->MultiCell(0,7,'ESTADO MENTAL Y HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
			$pdf ->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
			$pdf ->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
			$pdf ->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
			#ResEstudios
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('RESULTADOS Y ANÁLISIS DE ESTUDIOS AUXILIARES DE DIAGNÓSTICO (INCLUIR JUSTIFICACIÓN DE ESTUDIOS SOLICITADOS)'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['estudios'],1,'L');
			#Diag
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['diag'],1,'L');
			#Trata			
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('PLAN DE TRATAMIENTO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['tratamientoFin'],1,'L');
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('PRONÓSTICO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,utf8_decode('VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion']. '     Ingresa a: '.$rowC1['ingresa'],1,'L');
			//Termina hoja1
			//2da Pagina
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}

/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA traslado de servicio
	if($_GET['name'] == 'nts') {
		
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
	    /*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
		$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
	    $date2 = $resultado[0][0]['NACIO_PA'];
	    $fecha_nac_pac = $date2->format('d/m/Y');
		$hoy = new DateTime();
		$anniosO = $hoy->diff($date2);
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
		$turno = null;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notaTrasladoServ WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY id DESC";
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
		//$acudeFin = $rowC1['acude'];
		//Colocar habitacion del paciente si es que tiene
		$cuarto_pac = trim($resultado[0][0]['CVE_CUARTO']);
		$habitacion_pac=NULL;
		if($cuarto_pac != NULL && $cuarto_pac != ''){
			$habitacion_pac=utf8_decode("   HABITACIÓN: ").$cuarto_pac;
		}
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'].$habitacion_pac,"FECHA: ".$fechaFin."          HORA: ".$horaIC." Hrs.          TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,"DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac,"Tel: ".$tel_pac);
		//$cabecera = array("FECHA: ".$fechaFin."     HORA: ".$horaIC." Hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac,"","","","");
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el teto de un cell
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
			/*$cabecera = array(utf8_decode("                                                      NOTA DE TRASLADO DE SERVICIO"),"FECHA: ".$fechaFin."     HORA: ".$horaIC." Hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac);*/
			#$datosPersona = array($fecha1,$area,$entrega,$recibe);
			#$datosPersona = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));

			
			//imprimimos un texto
			#$pdf->MultiCell(0,5,utf8_decode('APLICA: Cuando el activo fijo, equipo menor y herramienta de trabajo es NUEVO O USADO y se ha inventariado, identificándose dentro de un área especificada.'));
			#$pdf->Cell(0,7,utf8_decode('identificándose dentro de un área especificada.'),0, 0, 'L');
			//$pdf->Header('2');
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Ln(1);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('NOTA DE TRASLADO DE SERVICIO');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('NOTA DE TRASLADO DE SERVICIO'),1, 1 , 'C',true);

			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
		
			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetFillColor(200,200,200);
			$pdf->Cell(0,7,'MOTIVO DE TRANSFERENCIA: '.$rowC1['motivoTransferencia'],1, 1 , 'L',true);
			$pdf->Cell(0,7,'SERVICIO ACTUAL: '.$rowC1['servicioActual'],1, 1 , 'L',true);
			$pdf->Cell(0,7,'SERVICIO AL QUE SE TRASLADA: '.$rowC1['servicioTraslada'],1, 1 , 'L',true);
			$pdf->Ln();
			$pdf->Cell(0,7,'SIGNOS VITALES ',1, 1 , 'C',true);
			//$pdf->SetFillColor(255,255,255);
			$pdf->MultiCell(0,7,'TA:'.$rowC1['ta'].' mmHg     FC: '.$rowC1['fc'].' min     FR: '.$rowC1['fr'].' min    Temp.: '.$rowC1['temp'].utf8_decode('°C     PESO: ').$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' Mts ',1, 'L');
			//$pdf->MultiCell(0,7,'PESO: '.$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' Mts ',0, 'L');
			//$pdf->Rect(10,95,200,10,'');
			//$pdf->Rect(10,105,200,20,'');			
			/*$pdf->Ln(5);
			$pdf->MultiCell(0,7,'TRATAMIENTO (CONCILIACION DE MEDICAMENTOS): '.$rowC1['tratamiento'],1, 'L');*/
			#Pad act
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('RESUMEN DE PADECIMIENTO ACTUAL (INCLUIR ESTADO ACTUAL AL MOMENTO DE CAMBIO DE ÁREA)'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,'PADECIMIENTO ACTUAL: '.$rowC1['interrogatorio'],1,'L');
			#Interrog
			/*$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 , 'C',true);*/
			//$pdf->MultiCell(0,7,'SIGNOS VITALES: HORA: '.$horaIC.' Hrs.  FC: '.$rowC1['fc'].' min  FR: '.$rowC1['fr'].' min  T/A:'.$rowC1['ta'].' mmHg  TEMP: '.$rowC1['temp'].utf8_decode('°C  SO2: ').$rowC1['so'],1,'L');
			#Multicell es por si se llena la linea da un salto automaticamente
			$pdf ->MultiCell(0,7,'ESTADO MENTAL Y HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
			$pdf ->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
			$pdf ->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
			$pdf ->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
			
			#Diag
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('ESTUDIOS DE GABINETE Y LABORATORIO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['estudiosGabyLab'],1,'L');
		
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('TERAPÉUTICA EMPLEADA Y/O PROCEDIMIENTOS REALIZADOS'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['terapeuticayProcedimientos'],1,'L');
			//Termina hoja1
			//2da Pagina
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA de referencia y traslado
	if($_GET['name'] == 'nrt') {
		
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
	    /*$nombre_med = $resultado[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultado[0][0]['DESC_ESPEC'];
		$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];*/
	    $date2 = $resultado[0][0]['NACIO_PA'];
	    $fecha_nac_pac = $date2->format('d/m/Y');
		$hoy = new DateTime();
		$anniosO = $hoy->diff($date2);
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
		$turno = null;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notareferenciatras WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY id DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$horaNext = new DateTime($rowC1['horaExt']);
		$horaICext = $horaNext->format('H:i');
		$fechaext = strtotime($rowC1['fechaExt']);
		$fechaFinext = date('d/m/Y',$fechaext);
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		
		$trasladoD='';
		$trasladoT='';
		
		if($rowC1['tipoTraslado'] == 'TRASLADO DEFINITIVO'){
			$trasladoD='X';
		} else {
			$trasladoT='X';
		}
		
		if($rowC1['ambulanciaTecno'] == '1'){
			$ambTS='X';
		} else {
			$ambTN='X';
		}
		
		if($rowC1['tipoPaciente'] == 'CRITICO'){
			$pacCriS='X';
		} else {
			$pacCriN='X';
		}
		
		$ox='';
		if($rowC1['oxigeno'] == '1'){
			$ox='X';
		}
		
		$desf='';
		if($rowC1['desfibrilador'] == '1'){
			$desf='X';
		}
		
		$venti='';
		if($rowC1['ventilador'] == '1'){
			$venti='X';
		}
		
		$incuba='';
		if($rowC1['incubadora'] == '1'){
			$incuba='X';
		}
		
		$imss='';
		$issste='';
		$parr='';
		$ss='';
		$hmore='';
		$imt='';
		$sdie='';
		$sur='';
		$angel='';
		$cardica='';
		$imed='';
		$chopo='';
		$polab='';
		$otros='';
		
		if($rowC1['receptor'] == 'IMSS'){
			$imss='X';
		} else if($rowC1['receptor'] == 'ISSTE'){
			$issste='X';
		} else if($rowC1['receptor'] == 'HOSPITAL G. PARRES'){
			$parr='X';
		} else if($rowC1['receptor'] == 'HOSPITAL SECRETARIA DE SALUD'){
			$ss='X';
		}else if($rowC1['receptor'] == 'HOSPITAL MORELOS'){
			$hmore='X';
		}else if($rowC1['receptor'] == 'INSTITUTO MEXICANO DE TRANSPLANTES'){
			$imt='X';
		}else if($rowC1['receptor'] == 'HOSPITAL SAN DIEGO'){
			$sdie='X';
		}else if($rowC1['receptor'] == 'MEDICA SUR'){
			$sur='X';
		}else if($rowC1['receptor'] == 'HOSPITAL ANGELES'){
			$angel='X';
		}else if($rowC1['receptor'] == 'CARDICA'){
			$cardica='X';
		}else if($rowC1['receptor'] == 'IMAGEN MEDICA'){
			$imed='X';
		}else if($rowC1['receptor'] == 'LABORATORIOS CHOPO'){
			$chopo='X';
		}else if($rowC1['receptor'] == 'LABORATORIOS POLAB'){
			$polab='X';
		}else if($rowC1['receptor'] == 'OTROS'){
			$otros='X';
		}
		
		$externoS='';
		$externoN='';
		
		if($rowC1['turnoExt'] != NULL && $rowC1['turnoExt'] != ''){			
			$externoS='X';
		} else {
			$externoN='X';
		}
		
		if($rowC1['turnoExt'] == 'M'){
			$turnoExt='MATUTINO';
		} else if($rowC1['turnoExt'] == 'V'){
			$turnoExt='VESPERTINO';
		} else if($rowC1['turnoExt'] == 'N'){
			$turnoExt='NOCTURNO';
		}
		
		$estableS='';
		$extableN='';
		
		$rowC1['estable'] == '1' ? $estableS='X' : $estableN='X';
		//$acudeFin = $rowC1['acude'];
		
		//Colocar habitacion del paciente si es que tiene
		$cuarto_pac = trim($resultado[0][0]['CVE_CUARTO']);
		$habitacion_pac=NULL;
		if($cuarto_pac != NULL && $cuarto_pac != ''){
			$habitacion_pac=utf8_decode("   HABITACIÓN: ").$cuarto_pac;
		}
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'].$habitacion_pac,"FECHA: ".$fechaFin."          HORA: ".$horaIC." Hrs.          TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,"DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac,"Tel: ".$tel_pac);
		//$cabecera = array("SERVICIO: ".$rowC1['servicio']."          FECHA: ".$fechaFin."          HORA: ".$horaIC." Hrs.          TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,"","","","");
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el teto de un cell
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
			/*$cabecera = array(utf8_decode("                                                  NOTA DE REFERENCIA Y TRASLADO"),"SERVICIO: ".$rowC1['servicio']."     FECHA: ".$fechaFin."     HORA: ".$horaIC." Hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."     EDAD: ".utf8_decode($annios)."     SEXO: ".$sexo_pac);*/
			#$datosPersona = array($fecha1,$area,$entrega,$recibe);
			#$datosPersona = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));

			
			//imprimimos un texto
			#$pdf->MultiCell(0,5,utf8_decode('APLICA: Cuando el activo fijo, equipo menor y herramienta de trabajo es NUEVO O USADO y se ha inventariado, identificándose dentro de un área especificada.'));
			#$pdf->Cell(0,7,utf8_decode('identificándose dentro de un área especificada.'),0, 0, 'L');
			//$pdf->Header('2');
			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Ln(20);
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('NOTA DE REFERENCIA Y TRASLADO');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('NOTA DE REFERENCIA Y TRASLADO'),1, 1 , 'C',true);

			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetY(60);
		
			$pdf->SetFont('Arial','',9);
			//$pdf->Rect(10,70,200,22,'');
			$pdf->SetFillColor(200,200,200);
			$pdf->Cell(0,7,'SERVICIO',1, 1 , 'C',true);
			$pdf->MultiCell(0,7,$rowC1['servicio'] ,1, 'L');
			$pdf->Ln();
			$pdf->Cell(0,7,'TIPO DE TRASLADO',1, 1 , 'C',true);
			$pdf->MultiCell(0,7,'( '.$trasladoD.' ) TRASLADO DEFINITIVO'.'     ( '.$trasladoT.' ) TRASLADO TRANSITORIO' ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('REQUIERE AMBULANCIA DE ALTA TECNOLOGÍA: ( '.$ambTS.' ) SI'.'     ( '.$ambTN.' ) NO     *TIPO DE PACIENTE: ( '.$pacCriS.' ) CRITICO     ( '.$pacCriN.' ) NO CRITICO') ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('ADITAMENTOS ESPECIALES:  ( '.$ox.' ) OXIGENO'.'     ( '.$desf.' ) DESFIBRILADOR     ( '.$venti.' ) VENTILADOR     ( '.$inciba.' ) INCUBADORA') ,1, 'L');
			$pdf->Ln();
			$pdf->Cell(0,7,'ESTABLECIMIENTO QUE ENVIA ',1, 1 , 'C',true);
			$pdf->MultiCell(0,7,utf8_decode('°  ').$rowC1['envia'] ,1, 'L');
			$pdf->Ln();
			$pdf->Cell(0,7,'ESTABLECIMIENTO RECEPTOR ',1, 1 , 'C',true);
			$pdf->MultiCell(0,7,'( '.$imss.' ) IMSS    ( '.$issste.' ) ISSSTE    ( '.$parr.' ) HOSPITAL G. PARRES    ( '.$ss.' ) HOSPITAL SECRETARIA DE SALUD    ( '.$hmore.' ) HOSPITAL MORELOS'."\n".'( '.$imt.' ) INSTITUTO MEXICANO DE TRANSPLANTES    ( '.$sdie.' ) HOSPITAL SAN DIEGO    ( '.$sur.' ) MEDICA SUR    ( '.$angel.' ) HOSPITAL ANGELES'."\n".'( '.$cardica.' ) CARDICA    ( '.$imed.' ) IMAGEN MEDICA    ( '.$chopo.' ) LABORATORIOS CHOPO    ( '.$polab.' ) LABORATORIOS POLAB'."\n".'( '.$otros.' ) OTRO:  '.$rowC1['otroReceptor'] ,1, 'L');
			$pdf->Ln();
			$pdf->Cell(0,7,'SIGNOS VITALES ',1, 1 , 'C',true);
			//$pdf->SetFillColor(255,255,255);
			$pdf->MultiCell(0,7,'TA:'.$rowC1['ta'].' mmHg     FC: '.$rowC1['fc'].' min     FR: '.$rowC1['fr'].' min    Temp.: '.$rowC1['temp'].utf8_decode('°C     PESO: ').$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' Mts ',1, 'L');			
			#Pad act
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('RESUMEN CLÍNICO'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,'MOTIVO DE ENVIO: '.$rowC1['motivoEnvio'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('IMPRESIÓN DIAGNOSTICA: ').$rowC1['impresionDiag'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TERAPEUTICA EMPLEADA: ').$rowC1['terapeuticaEmpl'],1,'L');
			//2da Pagina
			$pdf->Ln();
			$pdf->MultiCell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO QUE ENTREGA AL PACIENTE'),1,1,'L');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
			$pdf->MultiCell(0,7,utf8_decode('NOMBRE Y FIRMA DEL RESPONSABLE DE AMBULANCIA QUE RECIBE AL AL PACIENTE'),1,1,'R');
			$pdf->Ln(15);
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                                                                         CEDULA PROFESIONAL: ',0,1,'L');
			$pdf->Ln();
			$pdf->MultiCell(0,7,utf8_decode('PACIENTE QUE REGRESA AL HOSPITAL HENRI DUNANT DESPUÉS DE REALIZAR ESTUDIO EXTERNO: ( '.$externoS.' )SI    ( '.$externoN.' ) NO'),1,1,'L');
		if($externoS == 'X'){
			$pdf->MultiCell(0,7,'FECHA: '.$fechaFinext.'   HORA: '.$horaICext.' hrs.   SE RECIBE AL PACIENTE ESTABLE: ( '.$estableS.' ) SI   ( '.$estableN.' ) NO   TURNO: '.$turnoExt,1,1,'L');
		}
			$pdf->Output(); //Salida al navegador del pdf
		}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF EVENTO ADVERSO
	if($_GET['name'] == 'adverso') {
		
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		} else{
			$expediente=NULL;
		}
		
		if(isset ($_GET['folio'])){
			$folio = $_GET['folio'];
		} else {
			$folio=NULL;
		}
		
		if(isset ($_GET['idEvAdverso'])){
			$idEvAdverso = $_GET['idEvAdverso'];
		} else {
			$idEvAdverso=NULL;
		}
		
		if($expediente != NULL || $expediente != ''){
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
				$annios = $anniosO->format('%y Año(s)');
				$anniosBool = $anniosO->format('%y');
				if($anniosBool == '0'){
					$annios = $anniosO->format('%m Mes(es)');
				}
				#Direccion del paciente
				/*$calle_pac = trim($resultado[0][0]['DIR_PAC']);
				$col_pac = trim($resultado[0][0]['COL_PAC']);
				$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
				$cp_pac = trim($resultado[0][0]['CP_PAC']);
				$obligado_pac = $resultado[0][0]['OBLI_PAC'];
				$tel_pac = trim($resultado[0][0]['TEL_PAC']);
				$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);*/
			}
		}
		
		$turno = null;
		$acudeFin = NULL;
		
		if($expediente != NULL || $expediente != ''){
			$queryCuadro1 = "SELECT * FROM eventoAdverso WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY id DESC";
		} else {
			$queryCuadro1 = "SELECT * FROM eventoAdverso WHERE id='$idEvAdverso' AND estatus=1 ORDER BY id DESC";
		}
		
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		
		if($rowC1['tipoEvento'] == 'Centinela'){
			$centinela='X';
		} else if($rowC1['tipoEvento'] == 'Adverso'){
			$adverso='X';
		} else if($rowC1['tipoEvento'] == 'Cuasifalla'){
			$cuasi='X';
		} else if(utf8_encode($rowC1['tipoEvento']) == 'Error De Medicación'){
			$errMed='X';
		}else if($rowC1['tipoEvento'] == 'RAM'){
			$ram='X';
		}else if($rowC1['tipoEvento'] == 'OTRO'){
			$otro='X';
		}
		
		if($rowC1['relacionado'] == 'SI'){
			$relSi='X';
		} else {
			$relNo='X';
		}
		if($rowC1['alcanzoPac'] == 'SI'){
			$alcSi='X';
		} else {
			$alcNo='X';
		}
		if($rowC1['danioPac'] == 'SI'){
			$danSi='X';
		} else {
			$danNo='X';
		}
		
		if($rowC1['aim'] == '1'){
			$aim='X';
		} else {
			$aim='';
		}
		if($rowC1['fdvpam'] == '1'){
			$fdvpam='X';
		} else {
			$fdvpam='';
		}
		if($rowC1['dispoInc'] == '1'){
			$dispoInc='X';
		} else {
			$dispoInc='';
		}
		if($rowC1['cidt'] == '1'){
			$cidt='X';
		} else {
			$cidt='';
		}
		if($rowC1['ciam'] == '1'){
			$ciam='X';
		} else {
			$ciam='';
		}
		if($rowC1['dim'] == '1'){
			$dim='X';
		} else {
			$dim='';
		}
		if($rowC1['eii'] == '1'){
			$eii='X';
		} else {
			$eii='';
		}
		if($rowC1['fimar'] == '1'){
			$fimar='X';
		} else {
			$fimar='';
		}
		if($rowC1['mcmc'] == '1'){
			$mcmc='X';
		} else {
			$mcmc='';
		}
		if($rowC1['licim'] == '1'){
			$licim='X';
		} else {
			$licim='';
		}
		if($rowC1['fma'] == '1'){
			$fma='X';
		} else {
			$fma='';
		}
		if($rowC1['manp'] == '1'){
			$manp='X';
		} else {
			$manp='';
		}
		if($rowC1['frmec'] == '1'){
			$frmec='X';
		} else {
			$frmec='';
		}
		if($rowC1['ficp'] == '1'){
			$ficp='X';
		} else {
			$ficp='';
		}
		if($rowC1['ampi'] == '1'){
			$ampi='X';
		} else {
			$ampi='';
		}
		if($rowC1['amnp'] == '1'){
			$amnp='X';
		} else {
			$amnp='';
		}
		if($rowC1['omisionMed'] == '1'){
			$omisionMed='X';
		} else {
			$omisionMed='';
		}
		if($rowC1['ami'] == '1'){
			$ami='X';
		} else {
			$ami='';
		}
		if($rowC1['presInc'] == '1'){
			$presInc='X';
		} else {
			$presInc='';
		}
		if($rowC1['transInc'] == '1'){
			$transInc='X';
		} else {
			$transInc='';
		}
		if($rowC1['prepInc'] == '1'){
			$prepInc='X';
		} else {
			$prepInc='';
		}
		if($rowC1['tai'] == '1'){
			$tai='X';
		} else {
			$tai='';
		}
		if($rowC1['vai'] == '1'){
			$vai='X';
		} else {
			$vai='';
		}
		if($rowC1['adpi'] == '1'){
			$adpi='X';
		} else {
			$adpi='';
		}
		if($rowC1['dti'] == '1'){
			$dti='X';
		} else {
			$dti='';
		}
		if($rowC1['hai'] == '1'){
			$hai='X';
		} else {
			$hai='';
		}
		if($rowC1['ifi'] == '1'){
			$ifi='X';
		} else {
			$ifi='';
		}
		if($rowC1['vii'] == '1'){
			$vii='X';
		} else {
			$vii='';
		}
		if($rowC1['ot'] == '1'){
			$ot='X';
		} else {
			$ot='';
		}
		//$acudeFin = $rowC1['acude'];
		//Datos para medico segun la Cedula Colocada
		/*$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];*/
		$cabecera = array(utf8_decode("                                             "),utf8_decode('                                                           "La notificación es voluntaria y no punitiva"'),"Fecha de ocurrencia: ".$fechaFin."     Turno: ".$turno,"Personal que Reporta: ".$rowC1['reporta'],"Servicio: ".$rowC1['servicio']);
		
		$pdf = new PDF();		
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio('TRUE');
		//$pdf=new PDF_MC_Table();
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
		
		//Estas lineas es para poner color al el teto de un cell
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
			/*$cabecera = array(utf8_decode("                                             "),utf8_decode('                                                           "La notificación es voluntaria y no punitiva"'),"Fecha de ocurrencia: ".$fechaFin."     Turno: ".$turno,"Personal que Reporta: ".$rowC1['reporta'],"Servicio: ".$rowC1['servicio']);*/
			#$datosPersona = array($fecha1,$area,$entrega,$recibe);
			#$datosPersona = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));
			//imprimimos un texto
			#$pdf->MultiCell(0,5,utf8_decode('APLICA: Cuando el activo fijo, equipo menor y herramienta de trabajo es NUEVO O USADO y se ha inventariado, identificándose dentro de un área especificada.'));
			#$pdf->Cell(0,7,utf8_decode('identificándose dentro de un área especificada.'),0, 0, 'L');
			//$pdf->Header('3');
			$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
			$pdf->SetFillColor(200,200,200);
			$pdf->setTitulo('FORMATO DE NOTIFICACIÓN DE EVENTOS ADVERSOS');
			$pdf->SetXY(60,12);
			$pdf->Cell(145,7,utf8_decode('FORMATO DE NOTIFICACIÓN DE EVENTOS ADVERSOS'),1, 1 , 'C',true);

			//$pdf->tablaSimple($cabecera); //Método que integra datos
			//$pdf->Ln(10);
			$pdf->SetFont('Arial','B',9);
			$pdf->SetFillColor(200,200,200);
			$pdf->SetY(55);
			$pdf->Cell(0,7,'I.     DATOS DEL PACIENTE: ',0, 1 , 'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(0,7,'Nombre del paciente: '.$nombre_pac, 1, 1 , 'L');
			$pdf->Cell(0,7,'Fecha de nacimiento: '.$fecha_nac_pac.'     No. Expediente: '.$expediente.'     Edad: '.utf8_decode($annios).'     Sexo: '.$sexo_pac, 1, 1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('Diagnóstico: ').$rowC1['diag'], 1, 'L');
			$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(0,7,utf8_decode('II.     DESCRIPCIÓN DEL EVENTO ADVERSO: '),0, 1 , 'L');
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(0,7,'a)	Tipo de evento:  Centinela ( '.$centinela.' )     Adverso ( '.$adverso.' )     Cuasifalla ( '.$cuasi.utf8_decode(' )     Error de Medicación ( ').$errMed.' )     RAM ( '.$ram.' )    OTRO ( '.$otro.' )' ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('b)	¿El evento adverso está relacionado a medicamentos?   No ( '.$relNo.' )     Sí ( ').$relSi.' )' ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('c)	¿Alcanzó el error al paciente?   No ( '.$alcNo.' )     Sí ( ').$alcSi.' )' ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('d)	¿Causó daño al paciente?   No ( '.$danNo.' )     Sí ( ').$danSi.' )' ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('e)	¿Cuál fue el evento?   ').$rowC1['evento'] ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('f)	¿Cómo pasó?   ').$rowC1['como'] ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('g)	¿Por qué pasó?   ').$rowC1['porQue'] ,1, 'L');
			$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(0,7,utf8_decode('III.     Llenar éste aparatado únicamente si se trata de un error de Medicación '),0, 1 , 'L');
			$pdf->Cell(0,7,utf8_decode('Si el incidente es un error de medicación, señale qué tipo de error es:'), 1, 1 , 'L');
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(0,7,'Nombre del medicamento:   '.$rowC1['medicamento'].utf8_decode('         Nombre genérico:   ').$rowC1['generico'] ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('Presentación:   ').$rowC1['presentacion'].'         Dosis:   '.$rowC1['dosis'] ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('Vía de Administración:   ').$rowC1['viaAdmin'].'         Intervalo:   '.$rowC1['intervalo'] ,1, 'L');
			
			//Tratar de hacer una tabla    		
			$pdf->SetWidths(array(65,70,61));
			$pdf->Row(array(utf8_decode('( '.$aim.' ) Adquisición incorrecta del medicamento'),utf8_decode('( '.$fdvpam.' ) Falta de doble verificación de preparación y administración de los medicamentos'),utf8_decode('( '.$dispoInc.' ) Dispositivo incorrecto')));
		
			$pdf->Row(array('( '.$cidt.' ) Condiciones inadecuadas durante el transporte',utf8_decode('( '.$frmec.' ) Falta de registro de los medicamentos en expediente clínico'),utf8_decode('( '.$tai.' ) Técnica de administración incorrecta')));
		
			$pdf->Row(array('( '.$ciam.' ) Condiciones inadecuadas en el almacenamiento del medicamento',utf8_decode('( '.$ficp.' ) Falta de identificación correcta del paciente'),utf8_decode('( '.$vai.' ) Vía de administración incorrecta')));
		
			$pdf->Row(array(utf8_decode('( '.$dim.' ) Dispensación incorrecta de medicamento'),'( '.$ampi.' ) Se administra el medicamento a un paciente incorrecto','( '.$adpi.' ) Se administra una dosis o potencia incorrecta'));
			
			$pdf->Row(array('( '.$eii.' ) Etiquetado incompleto o incorrecto','( '.$amnp.' ) Se administra un medicamento no prescrito',utf8_decode('( '.$dti.' ) Duración del tratamiento incorrecto')));
		
			$pdf->Row(array(utf8_decode('( '.$fimar.' ) Falta de identificación de medicamentos de alto riesgo'),utf8_decode('( '.$omisionMed.' ) Omisión de un medicamento'),utf8_decode('( '.$hai.' ) Hora de administración incorrecta')));
		
			$pdf->Row(array('( '.$mcmc.' ) Medicamento caducado/malas condiciones','( '.$ami.' ) Se administra un medicamento incorrecto',utf8_decode('( '.$ifi.' ) Intervalo de frecuencia incorrecto')));
		
			$pdf->Row(array(utf8_decode('( '.$licim.' ) Letra ilegible y confusa en la indicación medica'),utf8_decode('( '.$presInc.' ) Prescripción incompleta'),utf8_decode('( '.$vii.' ) Velocidad de infusión incorrecta')));
		
			$pdf->Row(array(utf8_decode('( '.$fma.' ) Falta de notificación de alergias'),utf8_decode('( '.$transInc.' ) Transcripción incompleta'),'( '.$ot.' ) Otros especificar:'));
			
			$pdf->Row(array('( '.$manp.' ) Medicamento con aspecto y/o nombre parecido',utf8_decode('( '.$prepInc.' ) Preparación incorrecta'),$rowC1['otros']));
		
			$pdf->Ln();
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,7,'Tipos de Eventos adversos',0, 1 , 'L');
			
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(0,7,utf8_decode('      *EVENTO CENTINELA: Incidencia inesperada que ocurre durante la atención médica en la que se produce la muerte o una lesión física o psíquica grave, o existe riesgo de que se produzca. Las lesiones graves incluyen específicamente la pérdida de una extremidad o una función.'), 0, 1 , 'L');
			$pdf->MultiCell(0,7,utf8_decode('      *EVENTO ADVERSO: Incidentes desfavorables, fallas terapéuticas, lesiones iatrogénicas u otros sucesos adversos relacionados directamente con la atención o los servicios prestados en el hospital. Pueden ser consecuencia de actos de comisión o de omisión.'), 0, 1 , 'L');
			$pdf->MultiCell(0,7,utf8_decode('      *CUASIFALLA: (También mencionada como casi falla) Error que se detecta antes de que llegue al paciente.'), 0, 1 , 'L');
			$pdf->MultiCell(0,7,utf8_decode('      *ERROR DE MEDICACIÓN: Todo evento prevenible que pueda causar o dar lugar a un uso incorrecto de la medicación o a daño al paciente mientras la medicación está bajo el control del profesional sanitario, el paciente o el consumidor.'), 0, 1 , 'L');
			$pdf->MultiCell(0,7,utf8_decode('      *RAM: Reacción Adversa a Medicamentos. Cualquier respuesta al uso de un medicamento en dosis normales que sea nociva.'), 0, 1 , 'L');
			//$pdf->Footer();
			$pdf->Output(); //Salida al navegador del pdf
		}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA PREOPERATORIA Hospital
	if($_GET['name'] == 'preoperatoria') {
		
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
		$queryCuadro1 = "SELECT * FROM notapreoperatoria WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$fecha1 = strtotime($rowC1['fecha']);
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
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'].$habitacion_pac.utf8_decode("   HABITACIÓN: ").$cuarto_pac,"FECHA: ".$fechaFin."     HORA: ".$horaIC." hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('NOTA PREOPERATORIA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('NOTA PREOPERATORIA'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		$months = array('Enero','Febrero','Marzo','Abril','Mayo',
				'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$fecha2 = strtotime($rowC1['fecha']);
		$d1 = date('d',$fecha2);
		$m1 = date('m',$fecha2);
		$mi1 = intval($m1);
		$a1 = date('Y',$fecha2);
		
		$pdf->Cell(0,7,'SERVICIO: '.$rowC1['servicio'],1, 1 , 'L',true);
		$pdf->Cell(0,7,utf8_decode('FECHA DE LA CIRUGÍA'),1, 1 , 'C',true);
		$pdf->MultiCell(0,7,utf8_decode('Día: '.$d1.'   Mes: '.$months[$mi1-1].'   Año: '.$a1),1, 'L');
		#Diagnost
		//$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,$rowC1['diagnostico'],1,'L');
		#PlanQx
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('PLAN QUIRÚRGICO'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,$rowC1['planQx'],1,'L');
		#tipoQx
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('TIPO DE INTERVENCIÓN QUIRÚRGICA'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,$rowC1['tipoIntervencionQx'],1,'L');
		#riesgoQx			
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('RIESGO QUIRÚRGICO'),1, 1 ,'C',true);
		if($rowC1['riesgoQx']==NULL || $rowC1['riesgoQx'] == ''){
			$pdf->MultiCell(0,7,'',1,'L');
			$pdf->MultiCell(0,7,'',1,'L');
			$pdf->MultiCell(0,7,'',1,'L');
		} else {
			$pdf->MultiCell(0,7,$rowC1['riesgoQx'],1,'L');
			
		}
		#cuidadosPlanTer
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('CUIDADOS Y PLAN TERAPÉUTICO PREOPERATORIOS'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,$rowC1['cuidadosTerapeuticos'],1,'L');
		#Pronostico
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('PRONÓSTICO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,utf8_decode('VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
		//Termina hoja1
		//2da Pagina
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO TRATANTE:'),0,1,'C');
		$pdf->Ln(15);
		$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
		} else {
			$pdf->Cell(0,7,'                 '.$rowC1['nombreMedicoTratante'],0,1,'C');
		}
		$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}
/********************************************************************************************************************************************************/
//Esta parte es la que Genera el PDF HISTORIA CLINICA
	if($_GET['name'] == 'historiaClinica') {
		
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
		$queryCuadro1 = "SELECT * FROM historiaclinica WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode("EXPEDIENTE: ").$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio']."     FECHA: ".$fechaFin."     HORA: ".$horaIC." hrs.","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('HISTORIA CLÍNICA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('HISTORIA CLÍNICA'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		$pdf->Cell(0,7,utf8_decode('TIPO DE INTERROGATORIO: '.$rowC1['tipoInterroga']),1, 1 , 'L',true);
		$pdf->Cell(0,7,utf8_decode('DATOS PERSONALES'),1, 1 , 'C',true);
		$pdf->MultiCell(0,7,'ESTADO CIVIL: '.$rowC1['edoCivil'].utf8_decode('   OCUPACIÓN: ').$rowC1['ocupacion'].'   LUGAR DE ORIGEN: '.$rowC1['lugarOrigen'],1, 'L');
		$pdf->MultiCell(0,7,'ESCOLARIDAD: '.$rowC1['escolaridad'].utf8_decode('     RELIGIÓN: ').$rowC1['religion'].'   GRUPO Y RH: '.$rowC1['grupoRH'],1, 'L');
		#Diagnost
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('ANTECEDENTES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'ANTECEDENTES HEREDO FAMILIARES:  '.$rowC1['antecedentesHeredo'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES NO PATOLÓGICOS :  '),1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Habitación:  ').$rowC1['habitacion'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Hábitos:  ').$rowC1['habitos'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Alimentación:  ').$rowC1['alimentacion'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Actividad Física:  ').$rowC1['actividadFisica'],1,'L');
		$pdf->MultiCell(0,7,'Inmunizaciones:  '.$rowC1['inmunizaciones'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES PATOLÓGICOS:  ').$rowC1['antecedentesPatologicos'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('CONCILIACIÓN DE MEDICAMENTOS AL INGRESO (MEDICAMENTOS, DOSIS, VÍA DE ADMINISTRACIÓN E INTERVALO INLCUIR VITAMINAS Y MINERALES):  ').$rowC1['conciliacionMedicamentos'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES GINECO-OBSTÉTRICOS (si procede):  ').$rowC1['antecedentesGineco'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES PEDIÁTRICOS (si procede):  ').$rowC1['antecedentesPediatricos'],1,'L');
		#PlanQx
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('PADECIMIENTO ACTUAL'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,$rowC1['padecimientoActual'],1,'L');
		#tipoQx
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('INTERROGATORIO POR APARATOS Y SISTEMAS'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,utf8_decode('SÍNTOMAS GENERALES:  ').$rowC1['sintomas'],1,'L');
		$pdf ->MultiCell(0,7,'RESPIRATORIO:  '.$rowC1['respiratorio'],1,'L');
		$pdf ->MultiCell(0,7,utf8_decode('MÚSCULO-ESQUELETICO:  ').$rowC1['musculoEsquele'],1,'L');
		$pdf ->MultiCell(0,7,'DIGESTIVO :  '.$rowC1['digestivo'],1,'L');
		$pdf ->MultiCell(0,7,'GENITAL:  '.$rowC1['genital'],1,'L');
		$pdf ->MultiCell(0,7,'ENDOCRINO:  '.$rowC1['endocrino'],1,'L');
		$pdf ->MultiCell(0,7,'NERVIOSO:  '.$rowC1['nervioso'],1,'L');
		$pdf ->MultiCell(0,7,utf8_decode('HEMATOLÓGICO:  ').$rowC1['hematologico'],1,'L');
		$pdf ->MultiCell(0,7,utf8_decode('PSICOLÓGICOS:  ').$rowC1['psicologico'],1,'L');
		$pdf ->MultiCell(0,7,'URINARIO:  '.$rowC1['urinario'],1,'L');
		$pdf ->MultiCell(0,7,'CARDIOCIRCULATORIO:  '.$rowC1['cardiocirculatorio'],1,'L');
		$pdf ->MultiCell(0,7,'PIEL Y FANERAS:  '.$rowC1['pielFaneras'],1,'L');
		#riesgoQx
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('SIGNOS VITALES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'TA: '.$rowC1['ta'].' mmHg     FC: '.$rowC1['fc'].' lpm     FR: '.$rowC1['fr'].utf8_decode(' lpm     T°: '.$rowC1['temp'].' °C     SO2: ').$rowC1['so'].' %     GLUCOSA: '.$rowC1['glucosa'].' mg/dl     PESO: '.$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' m',1,'L');
		#cuidadosPlanTer
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
		$pdf->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
		$pdf->MultiCell(0,7,'CUELLO: '.$rowC1['cuello'],1,'L');
		$pdf->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
		$pdf->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
		$pdf->MultiCell(0,7,'GENITALES: '.$rowC1['genitales'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('NEUROLÓGICO: ').$rowC1['neurologico'],1,'L');
		$pdf->MultiCell(0,7,'PIEL Y FANERAS: '.$rowC1['pielFaneras2'],1,'L');
		$pdf->MultiCell(0,7,'COLUMNA VERTEBRAL: '.$rowC1['columnavertebral'],1,'L');
		#Pronostico
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO Y TRATAMIENTO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'ESTUDIOS DE GABINETE Y LABORATORIO: '.$rowC1['estudiosGabinete'],1,'L');
		$pdf->MultiCell(0,7,'TERAPEUTICA EMPLEADA Y RESULTADOS OBTENIDOS (TRATAMIENTO): '.$rowC1['terapeutica'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('CRITERIOS PARA IDENTIFICAR PACIENTES QUE REQUIEREN EVALUACIONES ESPECIALIZADAS ADICIONALES (Si se requiere alguna recomendación diferente del diagnóstico actual) INFORMAR, REFERIR O SOLICITAR INTERCONSULTA U OTROS: ').$rowC1['criteriosEspecializadas'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode("CRITERIOS PARA PLANIFICACIÓN TEMPRANA DEL ALTA: \nEducación especial: ").$rowC1['educacionEspecial']."\n".utf8_decode('Gestión de equipo a su egreso: ').$rowC1['gestionEquipo']."\nProcesos Administrativos: ".$rowC1['procesosAdmin'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('DIAGNÓSTICO: ').$rowC1['diagnostico'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('PRONÓSTICO     VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
		//Termina hoja1
		//2da Pagina
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
		$pdf->Ln(15);
		$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
		$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA DE INGRESO
	if($_GET['name'] == 'notaIngreso') {
		
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
		$queryCuadro1 = "SELECT * FROM notaingreso WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['hora']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode("EXPEDIENTE: ").$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio']."     FECHA: ".$fechaFin."     HORA: ".$horaIC." hrs.","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,"DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac,"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('NOTA DE INGRESO');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('NOTA DE INGRESO'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		$pdf->Cell(0,7,utf8_decode('TIPO DE INTERROGATORIO: '.$rowC1['tipoInterroga']),1, 1 , 'L',true);
		$pdf->Cell(0,7,utf8_decode('DATOS PERSONALES'),1, 1 , 'C',true);
		$pdf->MultiCell(0,7,'ESTADO CIVIL: '.$rowC1['edoCivil'].utf8_decode('   OCUPACIÓN: ').$rowC1['ocupacion'].'   LUGAR DE ORIGEN: '.$rowC1['lugarOrigen'],1, 'L');
		$pdf->MultiCell(0,7,'ESCOLARIDAD: '.$rowC1['escolaridad'].utf8_decode('     RELIGIÓN: ').$rowC1['religion'].'   GRUPO Y RH: '.$rowC1['grupoRH'],1, 'L');
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('SIGNOS VITALES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'TA: '.$rowC1['ta'].' mmHg     FC: '.$rowC1['fc'].' lpm     FR: '.$rowC1['fr'].utf8_decode(' lpm     T°: '.$rowC1['temp'].' °C     SO2: ').$rowC1['so'].' %     GLUCOSA: '.$rowC1['glucosa'].' mg/dl     PESO: '.$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' m',1,'L');
		#Diagnost
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('ANTECEDENTES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'ANTECEDENTES HEREDO FAMILIARES:  '.$rowC1['antecedentesHeredo'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES NO PATOLÓGICOS :  '),1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Habitación:  ').$rowC1['habitacion'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Hábitos:  ').$rowC1['habitos'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Alimentación:  ').$rowC1['alimentacion'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('Actividad Física:  ').$rowC1['actividadFisica'],1,'L');
		$pdf->MultiCell(0,7,'Inmunizaciones:  '.$rowC1['inmunizaciones'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES PATOLÓGICOS:  ').$rowC1['antecedentesPatologicos'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('CONCILIACIÓN DE MEDICAMENTOS AL INGRESO (MEDICAMENTOS, DOSIS, VÍA DE ADMINISTRACIÓN E INTERVALO INLCUIR VITAMINAS Y MINERALES):  ').$rowC1['conciliacionMedicamentos'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES GINECO-OBSTÉTRICOS (si procede):  ').$rowC1['antecedentesGineco'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('ANTECEDENTES PEDIÁTRICOS (si procede):  ').$rowC1['antecedentesPediatricos'],1,'L');
		#PlanQx
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('PADECIMIENTO ACTUAL'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,$rowC1['padecimientoActual'],1,'L');
		#cuidadosPlanTer
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
		$pdf->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
		$pdf->MultiCell(0,7,'CUELLO: '.$rowC1['cuello'],1,'L');
		$pdf->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
		$pdf->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
		$pdf->MultiCell(0,7,'GENITALES: '.$rowC1['genitales'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('NEUROLÓGICO: ').$rowC1['neurologico'],1,'L');
		$pdf->MultiCell(0,7,'PIEL Y FANERAS: '.$rowC1['pielFaneras2'],1,'L');
		$pdf->MultiCell(0,7,'COLUMNA VERTEBRAL: '.$rowC1['columnavertebral'],1,'L');
		#Pronostico
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO Y TRATAMIENTO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,'ESTUDIOS DE GABINETE Y LABORATORIO: '.$rowC1['estudiosGabinete'],1,'L');
		$pdf->MultiCell(0,7,'TERAPEUTICA EMPLEADA Y RESULTADOS OBTENIDOS (TRATAMIENTO): '.$rowC1['terapeutica'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('DIAGNÓSTICO: ').$rowC1['diagnostico'],1,'L');
		$pdf->MultiCell(0,7,utf8_decode('PRONÓSTICO     VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
		//Termina hoja1
		//2da Pagina
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
		$pdf->Ln(15);
		$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
		$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}
/********************************************************************************************************************************************************/
//Esta parte es la que Genera el PDF NOTA DE EGRESO
	if($_GET['name'] == 'notaEgreso') {
		
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
				
			$date3 = $resultado[0][0]['FEC_ING_PAC'];
			$fecha_ingreso_pac = $date3->format('d/m/Y');
			
			$hr1 = $resultado[0][0]['HR_ING_PAC'];
			$hr_ingreso_pac = $hr1->format('d/m/Y');
		}
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notaegreso WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fecha']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$medicamentos = $rowC1['medicamentos'];
		$dosis = $rowC1['dosis'];
		$via = $rowC1['via'];
		$intervalo = $rowC1['intervalo'];
		$dias = $rowC1['dias'];
		
		if($medicamentos != NULL && $medicamentos != ''){
			$arreglado = trim($medicamentos, '[');
			$arreglado1 = trim($arreglado, ']');
			$medicam = explode("},",$arreglado1);

			$arreglado2 = trim($dosis, '[');
			$arreglado3 = trim($arreglado2, ']');
			$dosi = explode(",",$arreglado3);

			$arreglado4 = trim($via, '[');
			$arreglado5 = trim($arreglado4, ']');
			$vi = explode(",",$arreglado5);

			$arreglado6 = trim($intervalo, '[');
			$arreglado7 = trim($arreglado6, ']');
			$interval = explode("},",$arreglado7);

			$arreglado8 = trim($dias, '[');
			$arreglado9 = trim($arreglado8, ']');
			$dia = explode("},",$arreglado9);

			$longitud = count($medicam);
		}
		
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode("EXPEDIENTE: ").$rowC1['numeroExpediente']."     FOLIO:".$rowC1['folio'].utf8_decode('   HABITACIÓN: ').$cuarto_pac,"FECHA: ".$fechaFin."     HORA: ".$horaIC." hrs.","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('NOTA DE EGRESO HOSPITALARIO');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('NOTA DE EGRESO HOSPITALARIO'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		$pdf->Cell(0,7,'MOTIVO DE EGRESO: '.$rowC1['motivoEgreso'],1, 1 , 'L',true);
		#$pdf->Cell(0,7,utf8_decode('DATOS PERSONALES'),1, 1 , 'C',true);
		
		$fecha2 = strtotime($rowC1['fechaEgreso']);
		$fechaFin2 = date('d/m/Y',$fecha2);
		$horaN1 = new DateTime($rowC1['horaEgreso']);
		$hora1 = $horaN1->format('H:i');
		
		$pdf->MultiCell(0,7,'FECHA DE INGRESO: '.$fecha_ingreso_pac.'   FECHA Y HORA DE EGRESO: '.$fechaFin2.' '.$hora1.' Hrs.',1, 'L');
		$pdf->MultiCell(0,7,utf8_decode('DIAGNÓSTICO DE INGRESO: ').$rowC1['diagnosticoIngreso'],1, 'L');
		$pdf->MultiCell(0,7,utf8_decode('DIAGNÓSTICO DE EGRESO: ').$rowC1['diagnosticoEgreso'],1, 'L');
		
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('RESUMEN DE LA EVOLUCIÓN Y ESTADO ACTUAL'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,$rowC1['resumenEvolucion'],1,'L');
		#Diagnost
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('MANEJO Y TRATAMIENTO HOSPITALARIO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,$rowC1['manejoTratamiento'],1,'L');
		#PlanQx
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('PROBLEMAS CLÍNICOS PENDIENTES'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,$rowC1['problemasClinicos'],1,'L');
		#cuidadosPlanTer
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('TRATAMIENTO A SU EGRESO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,utf8_decode('EGRESA CON TRATAMIENTO FARMACOLÓGICO: ').$rowC1['tratamientoFarmaco'],1,'L');
		if($rowC1['tratamientoFarmaco'] == 'SI'){
			$pdf->MultiCell(0,7,'DESCRIBIR TRATAMIENTO: '.$rowC1['describirTratamiento'],1,'L');
			$pdf->MultiCell(0,7,'MEDICAMENTO: ',1,'C');
			$c = 1;
			for($i=0; $i<$longitud; $i++) {
				$fi = substr($idMedicam[$i+1], 9, -2);
				$hi = substr($medicam[$i],17, -2);
				$reemp = array('"', '}');
				$si = substr(str_replace($reemp,"", $dosi[$i]),7);
				$ei = substr(str_replace($reemp,"", $vi[$i]), 6);
				$ii = substr(str_replace($reemp,"", $interval[$i]), 12);
				$di = substr(str_replace($reemp,"", $dia[$i]), 7);
				//Descomentar si deseamos ver el numero de existencias en la receta
				$existN = NULL;
				/*if($ei != null && $ei != ''){
					$existN = '     Existencias: '.$ei;
				}*/
				
				$pdf->MultiCell(0,7,$c++.' - '.$hi.'   Dosis: '.$si.utf8_decode('   Vía: ').$ei.'   Intervalo: '.$ii.utf8_decode('   Días: ').$di,1,'L');
			}
			
		}
		#Pronostico
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('RECOMENDACIONES PARA LA VIGILANCIA AMBULATORIA'),1, 1 ,'C',true);
		$pdf ->MultiCell(0,7,$rowC1['recomendacionesVigilancia'],1,'L');
		#
		$pdf->Ln();
		if($rowC1['tabaquismo'] == '1'){
			$tab='X';
		} else {
			$tab='';
		}
		
		if($rowC1['alcohol'] == '1'){
			$alcoh='X';
		} else {
			$alcoh='';
		}
		
		if($rowC1['otras'] == '1'){
			$otr='X';
		} else {
			$otr='';
		}
		
		$pdf->Cell(0,7,utf8_decode('ATENCIÓN DE FACTORES DE RIESGO'),1, 1 ,'C',true);
		$pdf ->MultiCell(0,7,'TABAQUISMO ( '.$tab.' )     ALCOHOLISMO ( '.$alcoh.' )     OTRAS ADICCIONES ( '.$otr.' )',1,'L');
		$pdf->MultiCell(0,7,utf8_decode('PRONÓSTICO     VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
		#
		if($rowC1['diagnosticos']!= NULL && $rowC1['diagnosticos']!=''){
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('EN CASO DE DEFUNCIÓN, ANOTAR LOS DIAGNÓSTICOS'),1, 1 ,'C',true);
			$pdf ->MultiCell(0,7,$rowC1['diagnosticos'],1,'L');
		}
		//2da Pagina
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
		$pdf->Ln(15);
		$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
		} else {
			$pdf->Cell(0,7,'                 '.$rowC1['nombreMedicoTratante'],0,1,'C');
		}
		$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		$pdf->Cell(0,7,utf8_decode('Este documento deberá ser redactado en forma clara, sin abreviaturas, enmendaduras o tachaduras.'),0,1,'C');
		
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA PREOPERATORIA URGENCIAS
	if($_GET['name'] == 'preoperatoriaUrg') {
		
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
		$queryCuadro1 = "SELECT * FROM notapreoperatoriaurg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$fecha1 = strtotime($rowC1['fecha']);
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
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"FECHA: ".$fechaFin."     HORA: ".$horaIC." hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('NOTA PREOPERATORIA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('NOTA PREOPERATORIA'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		$months = array('Enero','Febrero','Marzo','Abril','Mayo',
				'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$fecha2 = strtotime($rowC1['fecha']);
		$d1 = date('d',$fecha2);
		$m1 = date('m',$fecha2);
		$mi1 = intval($m1);
		$a1 = date('Y',$fecha2);
		
		$pdf->Cell(0,7,'SERVICIO: '.$rowC1['servicio'],1, 1 , 'L',true);
		$pdf->Cell(0,7,utf8_decode('FECHA DE LA CIRUGÍA'),1, 1 , 'C',true);
		$pdf->MultiCell(0,7,utf8_decode('Día: '.$d1.'   Mes: '.$months[$mi1-1].'   Año: '.$a1),1, 'L');
		#Diagnost
		//$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,$rowC1['diagnostico'],1,'L');
		#PlanQx
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('PLAN QUIRÚRGICO'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,$rowC1['planQx'],1,'L');
		#tipoQx
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('TIPO DE INTERVENCIÓN QUIRÚRGICA'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,7,$rowC1['tipoIntervencionQx'],1,'L');
		#riesgoQx			
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('RIESGO QUIRÚRGICO'),1, 1 ,'C',true);
		if($rowC1['riesgoQx']==NULL || $rowC1['riesgoQx'] == ''){
			$pdf->MultiCell(0,7,'',1,'L');
			$pdf->MultiCell(0,7,'',1,'L');
			$pdf->MultiCell(0,7,'',1,'L');
		} else {
			$pdf->MultiCell(0,7,$rowC1['riesgoQx'],1,'L');
		}
		#cuidadosPlanTer
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('CUIDADOS Y PLAN TERAPÉUTICO PREOPERATORIOS'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,$rowC1['cuidadosTerapeuticos'],1,'L');
		#Pronostico
		#$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('PRONÓSTICO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,7,utf8_decode('VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
		//Termina hoja1
		//2da Pagina
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO TRATANTE:'),0,1,'C');
		$pdf->Ln(15);
		$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
		} else {
			$pdf->Cell(0,7,'                 '.$rowC1['nombreMedicoTratante'],0,1,'C');
		}
		$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}

?>