﻿<?php
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

	function limpiarString($texto)
	{
		$textoLimpio = preg_replace('([^A-Za-zñÑáéíóúÁÉÍÓÚ])', ' ', $texto);
		return $textoLimpio;
	}

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
		$cedula_med = trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%' AND ESTATUS=1";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
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
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."  FECHA: ".$fechaFin."   HORA: ".$horaIC." Hrs.   TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("Domicilio: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac),"ARRIBO EN:  ".$acudeFin);
		
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
			if($firma_Med != NULL && $firma_Med != ''){
				$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
				$pdf->Ln(1);
			} else {
		 		$pdf->Ln(10);
			}
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
		$cedula_med = trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%' AND ESTATUS=1";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
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
		
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."  FECHA: ".$fechaFin."   HORA: ".$horaIC." Hrs.   TURNO: ".$turno,utf8_decode("NOMBRE: ".$nombre_pac),"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("PROCEDE: ".$obligado_pac),utf8_decode("Domicilio: ".$calle_pac .'  Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac.utf8_decode("       PERSONA QUE ACOMPAÑA: ".$compa_pac),"ARRIBO EN:  ".$rowC1['acude']);
		
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
			if($firma_Med != NULL && $firma_Med != ''){
				$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
				$pdf->Ln(1);
			} else {
		 		$pdf->Ln(10);
			}
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
		$hora1G = new DateTime($rowC1['horaG']);
		$horaNewG = $hora1G->format('H:i');
		
		$cabecera = array("FECHA: ".$fechaFinG."   HORA: ".$horaNewG." hrs.","NOMBRE COMPLETO DEL PACIENTE: ".$rowC1['nPaciente'],"FECHA DE NACIMIENTO: ".$fechaFinN,"ALERGIAS: ".$rowC1['alergias'],utf8_decode("MÉDICO TRATANTE: ").$rowC1['medTratante'],utf8_decode("DIAGNÓSTICO: ").$rowC1['diagnostico']);
		
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
		
		$cabecera = array("EXPEDIENTE: ".$expediente."  FOLIO: ".$folio."   FECHA: ".$fechaFinG,"NOMBRE COMPLETO DEL PACIENTE: ".$rowC1['nombrePac'],"FECHA DE NACIMIENTO: ".$fechaFinN.'   EDAD: '.utf8_decode($annios),"ALERGIAS: ".$rowC1['alergias'],utf8_decode("DIAGNÓSTICO: ").$rowC1['diag']);
		
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
			$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO O PROBLEMAS CLÍNICOS'),1, 1 ,'C',true);
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
	//Esta parte es la que Genera el PDF NOTA DE EVOLUCION
	if($_GET['name'] == 'nevoh') {
		
		$id=NULL;

		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}
		if(isset ($_GET['id']) ){
			$id = $_GET['id'];
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
		$idEvo=NULL;
		if($id != NULL && $id != ''){
			$idEvo= ' AND id='.$id.' ';
		}

		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)

		$queryCuadro1 = "SELECT * FROM notaEvolucionh WHERE numeroExpediente = '$expediente' AND folio= '$folio'".$idEvo." AND estatus=1 ORDER BY id DESC";
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
			$pdf ->MultiCell(0,7,$rowC1['expFisica'],1,'L');
			/*$pdf ->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
			$pdf ->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
			$pdf ->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');*/
			#ResEstudios
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('RESULTADOS Y ANÁLISIS DE ESTUDIOS AUXILIARES DE DIAGNÓSTICO (INCLUIR JUSTIFICACIÓN DE ESTUDIOS SOLICITADOS)'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['estudios'],1,'L');
			#Diag
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO O PROBLEMAS CLÍNICOS'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['diag'],1,'L');
			#Trata			
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('PLAN DE TRATAMIENTO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,$rowC1['tratamientoFin'],1,'L');
			$pdf->Ln();
			$pdf->Cell(0,7,utf8_decode('PRONÓSTICO'),1, 1 ,'C',true);
			$pdf->MultiCell(0,7,utf8_decode('VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
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
		
		$id=NULL;
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}
		if(isset ($_GET['id']) ){
			$id = $_GET['id'];
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
		$idTS=NULL;
		if($id != NULL && $id != ''){
			$idTS= ' AND id='.$id.' ';
		}
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notaTrasladoServ WHERE numeroExpediente = '$expediente' AND folio= '$folio'".$idTS." AND estatus=1 ORDER BY id DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		/*if($rowC1 == NULL){
			$queryCuadro1 = "SELECT * FROM notaTrasladoServh WHERE numeroExpediente = '$expediente' AND folio= '$folio'".$idTS." AND estatus=1 ORDER BY id DESC";
			$result0 = mysqli_query($conexionMedico, $queryCuadro1);
			$rowC1 = mysqli_fetch_array($result0);
		}*/
		
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
		$cedula_med = trim($cedula_med);

		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%' AND ESTATUS=1";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
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
			$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['expFisica'],1,'L');
			/*$pdf ->MultiCell(0,7,'ESTADO MENTAL Y HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
			$pdf ->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
			$pdf ->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
			$pdf ->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');*/
			
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
			//$pdf->Ln(15);
			if($firma_Med != NULL && $firma_Med != ''){
				$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
				$pdf->Ln(1);
			} else {
		 		$pdf->Ln(10);
			}
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF NOTA traslado de servicio Hospital
	if($_GET['name'] == 'ntsh') {
		
		$id=NULL;
		if(isset ($_GET['exp'])){
			$expediente = $_GET['exp'];
		}
		if(isset ($_GET['folio']) ){
			$folio = $_GET['folio'];
		}
		if(isset ($_GET['id']) ){
			$id = $_GET['id'];
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
		$idTS=NULL;
		if($id != NULL && $id != ''){
			$idTS= ' AND id='.$id.' ';
		}
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		/*$queryCuadro1 = "SELECT * FROM notaTrasladoServ WHERE numeroExpediente = '$expediente' AND folio= '$folio'".$idTS." AND estatus=1 ORDER BY id DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		if($rowC1 == NULL){*/
		$queryCuadro1 = "SELECT * FROM notaTrasladoServh WHERE numeroExpediente = '$expediente' AND folio= '$folio'".$idTS." AND estatus=1 ORDER BY id DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		//}
		
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
		$cedula_med = trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);

		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%' AND ESTATUS=1";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
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
			$pdf->Cell(0,7,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 , 'C',true);
			$pdf ->MultiCell(0,7,$rowC1['expFisica'],1,'L');
			/*$pdf ->MultiCell(0,7,'ESTADO MENTAL Y HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
			$pdf ->MultiCell(0,7,'CABEZA: '.$rowC1['cabeza'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
			$pdf ->MultiCell(0,7,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
			$pdf ->MultiCell(0,7,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');*/
			
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
			//$pdf->Ln(15);
			if($firma_Med != NULL && $firma_Med != ''){
				$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
				$pdf->Ln(1);
			} else {
		 		$pdf->Ln(10);
			}
			$pdf->Cell(0,7,'_______________________________________',0,1,'C');
			$pdf->Cell(0,7,'                 '.utf8_decode($nombre_med),0,1,'C');
			$pdf->Cell(0,7,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
			$pdf->Cell(0,7,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
			//$pdf->Footer('2');
			
			$pdf->Output(); //Salida al navegador del pdf
		}
/********************************************************************************************************************************************************/
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
			$ox='OXIGENO';
		}
		
		$desf='';
		if($rowC1['desfibrilador'] == '1'){
			$desf='DESFIBRILADOR';
		}
		
		$venti='';
		if($rowC1['ventilador'] == '1'){
			$venti='VENTILADOR';
		}
		
		$incuba='';
		if($rowC1['incubadora'] == '1'){
			$incuba='INCUBADORA';
		}
		
		$ninguno='';
		if($rowC1['ninguno'] == '1'){
			$ninguno='NINGUNO';
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
		$cedula_med= trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
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
			$pdf->MultiCell(0,7,utf8_decode('ADITAMENTOS ESPECIALES:   '.$ox.'   '.$desf.'   '.$venti.'   '.$inciba.'   '.$ninguno) ,1, 'L');
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
			$pdf ->MultiCell(0,7,'ANTECEDENTES PERSONALES: '.$rowC1['antecedentesPer'],1,'L');
			$pdf ->MultiCell(0,7,'PADECIMIENTO ACTUAL: '.$rowC1['padecimientoAct'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('EXPLORACIÓN FÍSICA: ').$rowC1['expFisica'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('IMPRESIÓN DIAGNOSTICA: ').$rowC1['impresionDiag'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TERAPEUTICA EMPLEADA: ').$rowC1['terapeuticaEmpl'],1,'L');
			$pdf ->MultiCell(0,7,'MOTIVO DE ENVIO: '.$rowC1['motivoEnvio'],1,'L');
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
	//Esta parte es la que Genera el PDF NOTA de referencia y traslado Hospital
	if($_GET['name'] == 'nrth') {
		
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
		$queryCuadro1 = "SELECT * FROM notareferenciatrash WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY id DESC";
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
			$ox='OXIGENO';
		}
		
		$desf='';
		if($rowC1['desfibrilador'] == '1'){
			$desf='DESFIBRILADOR';
		}
		
		$venti='';
		if($rowC1['ventilador'] == '1'){
			$venti='VENTILADOR';
		}
		
		$incuba='';
		if($rowC1['incubadora'] == '1'){
			$incuba='INCUBADORA';
		}
		
		$ninguno='';
		if($rowC1['ninguno'] == '1'){
			$ninguno='NINGUNO';
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
		$cedula_med= trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
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
			//$pdf->MultiCell(0,7,utf8_decode('ADITAMENTOS ESPECIALES:  ( '.$ox.' ) OXIGENO'.'     ( '.$desf.' ) DESFIBRILADOR     ( '.$venti.' ) VENTILADOR     ( '.$inciba.' ) INCUBADORA') ,1, 'L');
			$pdf->MultiCell(0,7,utf8_decode('ADITAMENTOS ESPECIALES:   '.$ox.'   '.$desf.'   '.$venti.'   '.$inciba.'   '.$ninguno) ,1, 'L');
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
			$pdf ->MultiCell(0,7,'ANTECEDENTES PERSONALES: '.$rowC1['antecedentesPer'],1,'L');
			$pdf ->MultiCell(0,7,'PADECIMIENTO ACTUAL: '.$rowC1['padecimientoAct'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('EXPLORACIÓN FÍSICA: ').$rowC1['expFisica'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('IMPRESIÓN DIAGNOSTICA: ').$rowC1['impresionDiag'],1,'L');
			$pdf ->MultiCell(0,7,utf8_decode('TERAPEUTICA EMPLEADA: ').$rowC1['terapeuticaEmpl'],1,'L');
			$pdf ->MultiCell(0,7,'MOTIVO DE ENVIO: '.$rowC1['motivoEnvio'],1,'L');
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
		if(isset ($_GET['id']) ){
			$id = $_GET['id'];
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
		$idPreope=NULL;
		if($id != NULL && $id != ''){
			$idPreope= ' AND id='.$id.' ';
		}
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notapreoperatoria WHERE numeroExpediente = '$expediente' AND folio= '$folio'".$idPreope." AND estatus=1 ORDER BY fechaGuardado DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		//$fecha = strtotime($rowC1['fechaGuardado']);
		$fecha = strtotime($rowC1['fecha']);
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
		$cedula_med = trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%' AND ESTATUS=1";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
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
		if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
			$pdf->Ln(1);
		} else {
		 	$pdf->Ln(10);
		}
		$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,5,'                 '.utf8_decode($nombre_med),0,1,'C');
		} else {
			$pdf->Cell(0,5,'                 '.$rowC1['nombreMedicoTratante'],0,1,'C');
		}
		$pdf->Cell(0,5,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,5,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
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
		$cedula_med= trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%' AND ESTATUS=1";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode("EXPEDIENTE: ").$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio']."     FECHA: ".$fechaFin."     HORA: ".$horaIC.utf8_decode(" hrs.   HABITACIÓN: ").$cuarto_pac,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		//$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',8); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('HISTORIA CLÍNICA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('HISTORIA CLÍNICA'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',7);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		$pdf->Cell(0,6,utf8_decode('TIPO DE INTERROGATORIO: '.$rowC1['tipoInterroga']),1, 1 , 'L',true);
		$pdf->Cell(0,6,utf8_decode('DATOS PERSONALES'),1, 1 , 'C',true);
		$pdf->MultiCell(0,6,'ESTADO CIVIL: '.$rowC1['edoCivil'].utf8_decode('   OCUPACIÓN: ').$rowC1['ocupacion'].'   LUGAR DE ORIGEN: '.$rowC1['lugarOrigen'],1, 'L');
		$pdf->MultiCell(0,6,'ESCOLARIDAD: '.$rowC1['escolaridad'].utf8_decode('     RELIGIÓN: ').$rowC1['religion'].'   GRUPO Y RH: '.$rowC1['grupoRH'],1, 'L');
		#Diagnost
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('ANTECEDENTES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'ANTECEDENTES HEREDO FAMILIARES:  '.$rowC1['antecedentesHeredo'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES NO PATOLÓGICOS :  '),1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Habitación:  ').$rowC1['habitacion'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Hábitos:  ').$rowC1['habitos'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Alimentación:  ').$rowC1['alimentacion'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Actividad Física:  ').$rowC1['actividadFisica'],1,'L');
		$pdf->MultiCell(0,6,'Inmunizaciones:  '.$rowC1['inmunizaciones'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES PATOLÓGICOS:  ').$rowC1['antecedentesPatologicos'],1,'L');
		if($rowC1['alcohol'] == 1 || $rowC1['tabaco'] == 1 || $rowC1['drogas'] == 1){
			$alcohol=NULL;
			$tabaco=NULL;
			$drogas=NULL;
			if($rowC1['alcohol'] == 1){
				$alcohol='ALCOHOL';
			}
			if($rowC1['tabaco'] == 1){
				$tabaco='TABACO';
			}
			if($rowC1['drogas'] == 1){
				$drogas='DROGAS';
			}
			$pdf->MultiCell(0,7,$alcohol.'  '.$tabaco.'  '. $drogas,1,'L');
		}
		$pdf->MultiCell(0,6,utf8_decode('CONCILIACIÓN DE MEDICAMENTOS AL INGRESO (MEDICAMENTOS, DOSIS, VÍA DE ADMINISTRACIÓN E INTERVALO INLCUIR VITAMINAS Y MINERALES):  ').$rowC1['conciliacionMedicamentos'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES GINECO-OBSTÉTRICOS (si procede):  ').$rowC1['antecedentesGineco'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES PEDIÁTRICOS (si procede):  ').$rowC1['antecedentesPediatricos'],1,'L');
		#PlanQx
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('PADECIMIENTO ACTUAL'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,6,$rowC1['padecimientoActual'],1,'L');
		#tipoQx
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('INTERROGATORIO POR APARATOS Y SISTEMAS'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,6,utf8_decode('SÍNTOMAS GENERALES:  ').$rowC1['sintomas'],1,'L');
		$pdf ->MultiCell(0,6,'RESPIRATORIO:  '.$rowC1['respiratorio'],1,'L');
		$pdf ->MultiCell(0,6,utf8_decode('MÚSCULO-ESQUELETICO:  ').$rowC1['musculoEsquele'],1,'L');
		$pdf ->MultiCell(0,6,'DIGESTIVO :  '.$rowC1['digestivo'],1,'L');
		$pdf ->MultiCell(0,6,'GENITAL:  '.$rowC1['genital'],1,'L');
		$pdf ->MultiCell(0,6,'ENDOCRINO:  '.$rowC1['endocrino'],1,'L');
		$pdf ->MultiCell(0,6,'NERVIOSO:  '.$rowC1['nervioso'],1,'L');
		$pdf ->MultiCell(0,6,utf8_decode('HEMATOLÓGICO:  ').$rowC1['hematologico'],1,'L');
		$pdf ->MultiCell(0,6,utf8_decode('PSICOLÓGICOS:  ').$rowC1['psicologico'],1,'L');
		$pdf ->MultiCell(0,6,'URINARIO:  '.$rowC1['urinario'],1,'L');
		$pdf ->MultiCell(0,6,'CARDIOCIRCULATORIO:  '.$rowC1['cardiocirculatorio'],1,'L');
		$pdf ->MultiCell(0,6,'PIEL Y FANERAS:  '.$rowC1['pielFaneras'],1,'L');
		#riesgoQx
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('SIGNOS VITALES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'TA: '.$rowC1['ta'].' mmHg     FC: '.$rowC1['fc'].' lpm     FR: '.$rowC1['fr'].utf8_decode(' lpm     T°: '.$rowC1['temp'].' °C     SO2: ').$rowC1['so'].' %     GLUCOSA: '.$rowC1['glucosa'].' mg/dl     PESO: '.$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' m',1,'L');
		#cuidadosPlanTer
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
		$pdf->MultiCell(0,6,'CABEZA: '.$rowC1['cabeza'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
		$pdf->MultiCell(0,6,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
		$pdf->MultiCell(0,6,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
		$pdf->MultiCell(0,6,'GENITALES: '.$rowC1['genitales'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('NEUROLÓGICO: ').$rowC1['neurologico'],1,'L');
		$pdf->MultiCell(0,6,'PIEL Y FANERAS: '.$rowC1['pielFaneras2'],1,'L');
		$pdf->MultiCell(0,6,'COLUMNA VERTEBRAL: '.$rowC1['columnavertebral'],1,'L');
		#Pronostico
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('DIAGNÓSTICO Y TRATAMIENTO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'ESTUDIOS DE GABINETE Y LABORATORIO: '.$rowC1['estudiosGabinete'],1,'L');
		$pdf->MultiCell(0,6,'TERAPEUTICA EMPLEADA Y RESULTADOS OBTENIDOS (TRATAMIENTO): '.$rowC1['terapeutica'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('CRITERIOS PARA IDENTIFICAR PACIENTES QUE REQUIEREN EVALUACIONES ESPECIALIZADAS ADICIONALES (Si se requiere alguna recomendación diferente del diagnóstico actual) INFORMAR, REFERIR O SOLICITAR INTERCONSULTA U OTROS: ').$rowC1['criteriosEspecializadas'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode("CRITERIOS PARA PLANIFICACIÓN TEMPRANA DEL ALTA: \nEducación especial: ").$rowC1['educacionEspecial']."\n".utf8_decode('Gestión de equipo a su egreso: ').$rowC1['gestionEquipo']."\nProcesos Administrativos: ".$rowC1['procesosAdmin'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('DIAGNÓSTICO: ').$rowC1['diagnostico'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('PRONÓSTICO     VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
		//Termina hoja1
		//2da Pagina
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
		if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
			$pdf->Ln(1);
		} else {
		 	$pdf->Ln(10);
		}
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
		$cedula_med= trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%' AND ESTATUS=1";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode("EXPEDIENTE: ").$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio']."     FECHA: ".$fechaFin."     HORA: ".$horaIC.utf8_decode(" hrs.   HABITACIÓN: ").$cuarto_pac,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,"DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac,"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		 $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',8); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('NOTA DE INGRESO');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('NOTA DE INGRESO'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',7);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		$pdf->Cell(0,6,utf8_decode('TIPO DE INTERROGATORIO: '.$rowC1['tipoInterroga']),1, 1 , 'L',true);
		$pdf->Cell(0,6,utf8_decode('DATOS PERSONALES'),1, 1 , 'C',true);
		$pdf->MultiCell(0,6,'ESTADO CIVIL: '.$rowC1['edoCivil'].utf8_decode('   OCUPACIÓN: ').$rowC1['ocupacion'].'   LUGAR DE ORIGEN: '.$rowC1['lugarOrigen'],1, 'L');
		$pdf->MultiCell(0,6,'ESCOLARIDAD: '.$rowC1['escolaridad'].utf8_decode('     RELIGIÓN: ').$rowC1['religion'].'   GRUPO Y RH: '.$rowC1['grupoRH'],1, 'L');
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('SIGNOS VITALES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'TA: '.$rowC1['ta'].' mmHg     FC: '.$rowC1['fc'].' lpm     FR: '.$rowC1['fr'].utf8_decode(' lpm     T°: '.$rowC1['temp'].' °C     SO2: ').$rowC1['so'].' %     GLUCOSA: '.$rowC1['glucosa'].' mg/dl     PESO: '.$rowC1['peso'].' Kg     TALLA: '.$rowC1['talla'].' m',1,'L');
		#Diagnost
		$pdf->Ln();
		$pdf->Cell(0,6,utf8_decode('ANTECEDENTES'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'ANTECEDENTES HEREDO FAMILIARES:  '.$rowC1['antecedentesHeredo'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES NO PATOLÓGICOS :  '),1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Habitación:  ').$rowC1['habitacion'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Hábitos:  ').$rowC1['habitos'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Alimentación:  ').$rowC1['alimentacion'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('Actividad Física:  ').$rowC1['actividadFisica'],1,'L');
		$pdf->MultiCell(0,6,'Inmunizaciones:  '.$rowC1['inmunizaciones'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES PATOLÓGICOS:  ').$rowC1['antecedentesPatologicos'],1,'L');
		if($rowC1['alcohol'] == 1 || $rowC1['tabaco'] == 1 || $rowC1['drogas'] == 1){
			$alcohol=NULL;
			$tabaco=NULL;
			$drogas=NULL;
			if($rowC1['alcohol'] == 1){
				$alcohol='ALCOHOL';
			}
			if($rowC1['tabaco'] == 1){
				$tabaco='TABACO';
			}
			if($rowC1['drogas'] == 1){
				$drogas='DROGAS';
			}
			$pdf->MultiCell(0,6,$alcohol.'  '.$tabaco.'  '. $drogas,1,'L');
		}
		$pdf->MultiCell(0,6,utf8_decode('CONCILIACIÓN DE MEDICAMENTOS AL INGRESO (MEDICAMENTOS, DOSIS, VÍA DE ADMINISTRACIÓN E INTERVALO INLCUIR VITAMINAS Y MINERALES):  ').$rowC1['conciliacionMedicamentos'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES GINECO-OBSTÉTRICOS (si procede):  ').$rowC1['antecedentesGineco'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('ANTECEDENTES PEDIÁTRICOS (si procede):  ').$rowC1['antecedentesPediatricos'],1,'L');
		#PlanQx
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('PADECIMIENTO ACTUAL'),1, 1 , 'C',true);
		$pdf ->MultiCell(0,6,$rowC1['padecimientoActual'],1,'L');
		#cuidadosPlanTer
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('EXPLORACIÓN FÍSICA'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'HABITUS EXTERIOR: '.$rowC1['habExt'],1,'L');
		$pdf->MultiCell(0,6,'CABEZA: '.$rowC1['cabeza'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('TÓRAX: ').$rowC1['torax'],1,'L');
		$pdf->MultiCell(0,6,'ABDOMEN: '.$rowC1['abdomen'],1,'L');
		$pdf->MultiCell(0,6,'EXTREMIDADES: '.$rowC1['extremidades'],1,'L');
		$pdf->MultiCell(0,6,'GENITALES: '.$rowC1['genitales'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('NEUROLÓGICO: ').$rowC1['neurologico'],1,'L');
		$pdf->MultiCell(0,6,'PIEL Y FANERAS: '.$rowC1['pielFaneras2'],1,'L');
		$pdf->MultiCell(0,6,'COLUMNA VERTEBRAL: '.$rowC1['columnavertebral'],1,'L');
		#Pronostico
		$pdf->Ln(3);
		$pdf->Cell(0,6,utf8_decode('DIAGNÓSTICO Y TRATAMIENTO'),1, 1 ,'C',true);
		$pdf->MultiCell(0,6,'ESTUDIOS DE GABINETE Y LABORATORIO: '.$rowC1['estudiosGabinete'],1,'L');
		$pdf->MultiCell(0,6,'TERAPEUTICA EMPLEADA Y RESULTADOS OBTENIDOS (TRATAMIENTO): '.$rowC1['terapeutica'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('DIAGNÓSTICO: ').$rowC1['diagnostico'],1,'L');
		$pdf->MultiCell(0,6,utf8_decode('PRONÓSTICO     VIDA: ').$rowC1['pronosticoVida'].utf8_decode('     FUNCIÓN: ').$rowC1['pronosticoFuncion'],1,'L');
		//Termina hoja1
		//2da Pagina
		$pdf->Ln();
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO:'),0,1,'C');
		if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
			$pdf->Ln(1);
		} else {
		 	$pdf->Ln(10);
		}
		$pdf->Cell(0,6,'_______________________________________',0,1,'C');
		$pdf->Cell(0,6,'                 '.utf8_decode($nombre_med),0,1,'C');
		$pdf->Cell(0,6,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,6,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
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
			$hr_ingreso_pac = $hr1->format('H:i');
		}
		$turno = NULL;
		$acudeFin = NULL;
		#echo 'LLEGO idResguardo: '.$idResguardo;
		#Query para Sacar los datos del primer Recuadro (Datos Basicos)
		$queryCuadro1 = "SELECT * FROM notaegreso WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		//Fecha y hora de guardado REAL
		$horaN = new DateTime($rowC1['fecha']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fecha']);
		$fechaFin = date('d/m/Y',$fecha);
		
		//Fecha y hora colocada en el formulario
		$fecha2 = strtotime($rowC1['fechaEgreso']);
		$fechaFin2 = date('d/m/Y',$fecha2);
		$horaN1 = new DateTime($rowC1['horaEgreso']);
		$hora1 = $horaN1->format('H:i');
		
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
		$cedula_med=trim($cedula_med);
		$nombre_med = limpiarString($nombre_med);
		
		//Query para sacar la firma del medico segun la cedula colocada
		$queryCedula = "SELECT * FROM hpmedico WHERE CEDULA_MEDICO LIKE '$cedula_med%' OR CEDULA2_MEDICO LIKE '$cedula_med%' OR CEDULA3_MEDICO LIKE '$cedula_med%'";
		$resultCed = mysqli_query($conexionMedico, $queryCedula);
		$rowCedula = mysqli_fetch_array($resultCed);
		
		$firma_Med=$rowCedula['FIRMA'];
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode("EXPEDIENTE: ").$rowC1['numeroExpediente']."     FOLIO:".$rowC1['folio'].utf8_decode('   HABITACIÓN: ').$cuarto_pac,"FECHA: ".$fechaFin2."     HORA: ".$hora1." hrs.","NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
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
		
		$fe1 = $date3->format('Y-m-d');
		$fe2 = date('Y-m-d',$fecha2);
		
		$datetime1 = new DateTime($fe1);
		$datetime2 = new DateTime($fe2);
		$estancia = $datetime1->diff($datetime2);
		$diasEst = $estancia->format('%a');
		
		$pdf->MultiCell(0,7,'FECHA Y HORA DE INGRESO: '.$fecha_ingreso_pac.'  '.$hr_ingreso_pac.'Hrs   FECHA Y HORA DE EGRESO: '.$fechaFin2.'  '.$hora1.utf8_decode('hrs  DÍAS DE ESTANCIA: ').$diasEst,1, 'L');
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
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO: '),0,1,'C');
		$pdf->Ln();
		if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(20,15,'',0,0,'C',$pdf->Image($firma_Med,90,null,55,35));
			$pdf->Ln(1);
		} else {
		 	$pdf->Ln(10);
		}
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
		$nombre_med = limpiarString($nombre_med);
		
		//Declaramos la cabecera
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"FECHA: ".$fechaFin1."     HORA: ".$horaIC." hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
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

/***************************************************************************************************************************************************************************************************/
//Esta parte es la que Genera el PDF Imagenologia Medicos
	if($_GET['name'] == 'imagenologia') {
		
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
		
		if(isset ($_GET['idImagenologia'])){
			$idImagenologia = $_GET['idImagenologia'];
		} else {
			$idImagenologia = NULL;
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
				$calle_pac = trim($resultado[0][0]['DIR_PAC']);
				$col_pac = trim($resultado[0][0]['COL_PAC']);
				$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
				$cp_pac = trim($resultado[0][0]['CP_PAC']);
				$obligado_pac = $resultado[0][0]['OBLI_PAC'];
				$tel_pac = trim($resultado[0][0]['TEL_PAC']);
				$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
			}
		}
		
		$turno = null;
		$acudeFin = NULL;
		
		if($expediente != NULL || $expediente != ''){
			$queryCuadro1 = "SELECT * FROM imagenologia WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND id='$idImagenologia' AND estatus=1 ORDER BY id DESC";
		} else {
			$queryCuadro1 = "SELECT * FROM imagenologia WHERE id='$idImagenologia' AND estatus=1 ORDER BY id DESC";
		}
		
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		$horaFin = date('H:i', $fecha);
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		
		if($rowC1['tiroides'] != NULL &&  $rowC1['tiroides'] != ''){
			$tiroides='X';
		} else {
			$tiroides='';
		}
		if($rowC1['mama'] != NULL &&  $rowC1['mama'] != ''){
			$mama='X';
		} else {
			$mama='';
		}
		if($rowC1['higadoVesiculayPancreas'] != NULL &&  $rowC1['higadoVesiculayPancreas'] != ''){
			$higadoVesiculayPancreas='X';
		} else {
			$higadoVesiculayPancreas='';
		}
		if($rowC1['renal'] != NULL &&  $rowC1['renal'] != ''){
			$renal='X';
		} else {
			$renal='';
		}
		if($rowC1['abdominal'] != NULL &&  $rowC1['abdominal'] != ''){
			$abdominal='X';
		} else {
			$abdominal='';
		}
		if($rowC1['uteroOvariosyVejiga'] != NULL &&  $rowC1['uteroOvariosyVejiga'] != ''){
			$uteroOvariosyVejiga='X';
		} else {
			$uteroOvariosyVejiga='';
		}
		if($rowC1['pelvico'] != NULL &&  $rowC1['pelvico'] != ''){
			$pelvico='X';
		} else {
			$pelvico='';
		}
		if($rowC1['obstetrico'] != NULL &&  $rowC1['obstetrico'] != ''){
			$obstetrico='X';
		} else {
			$obstetrico='';
		}
		if($rowC1['vejigayProstata'] != NULL &&  $rowC1['vejigayProstata'] != ''){
			$vejigayProstata='X';
		} else {
			$vejigayProstata='';
		}
		if($rowC1['tejidosBlandos'] != NULL &&  $rowC1['tejidosBlandos'] != ''){
			$tejidosBlandos='X';
		} else {
			$tejidosBlandos='';
		}
		if($rowC1['transrectal'] != NULL &&  $rowC1['transrectal'] != ''){
			$transrectal='X';
		} else {
			$transrectal='';
		}
		if($rowC1['transvaginal'] != NULL &&  $rowC1['transvaginal'] != ''){
			$transvaginal='X';
		} else {
			$transvaginal='';
		}
		if($rowC1['carotideoBilateral'] != NULL &&  $rowC1['carotideoBilateral'] != ''){
			$carotideoBilateral='X';
		} else {
			$carotideoBilateral='';
		}
		if($rowC1['carotideoBiTxt'] != NULL &&  $rowC1['carotideoBiTxt'] != ''){
			$carotideoBiTxt = $rowC1['carotideoBiTxt'];
		} else {
			$carotideoBiTxt='';
		}
		
		if($rowC1['miembroSuperiorUnilateral'] != NULL &&  $rowC1['miembroSuperiorUnilateral'] != ''){
			$miembroSuperiorUnilateral='X';
		} else {
			$miembroSuperiorUnilateral='';
		}
		if($rowC1['miembroSupUniTxt'] != NULL &&  $rowC1['miembroSupUniTxt'] != ''){
			$miembroSupUniTxt = $rowC1['miembroSupUniTxt'];
		} else {
			$miembroSupUniTxt='';
		}
		if($rowC1['miembroSuperiorBilateral'] != NULL &&  $rowC1['miembroSuperiorBilateral'] != ''){
			$miembroSuperiorBilateral='X';
		} else {
			$miembroSuperiorBilateral='';
		}
		if($rowC1['miembroSupBiTxt'] != NULL &&  $rowC1['miembroSupBiTxt'] != ''){
			$miembroSupBiTxt = $rowC1['miembroSupBiTxt'];
		} else {
			$miembroSupBiTxt='';
		}
		if($rowC1['miembroInferiorUnilateral'] != NULL &&  $rowC1['miembroInferiorUnilateral'] != ''){
			$miembroInferiorUnilateral='X';
		} else {
			$miembroInferiorUnilateral='';
		}
		if($rowC1['miembroInfUniTxt'] != NULL &&  $rowC1['miembroInfUniTxt'] != ''){
			$miembroInfUniTxt = $rowC1['miembroInfUniTxt'];
		} else {
			$miembroInfUniTxt='';
		}
		if($rowC1['miembroInferiorBilateral'] != NULL &&  $rowC1['miembroInferiorBilateral'] != ''){
			$miembroInferiorBilateral='X';
		} else {
			$miembroInferiorBilateral='';
		}
		if($rowC1['miembroInfBiTxt'] != NULL &&  $rowC1['miembroInfBiTxt'] != ''){
			$miembroInfBiTxt = $rowC1['miembroInfBiTxt'];
		} else {
			$miembroInfBiTxt='';
		}
		if($rowC1['higadoHipertensionPortal'] != NULL &&  $rowC1['higadoHipertensionPortal'] != ''){
			$higadoHipertensionPortal='X';
		} else {
			$higadoHipertensionPortal='';
		}
		if($rowC1['higadoPortTxt'] != NULL &&  $rowC1['higadoPortTxt'] != ''){
			$higadoPortTxt = $rowC1['higadoPortTxt'];
		} else {
			$higadoPortTxt='';
		}
		if($rowC1['regionSimple'] != NULL &&  $rowC1['regionSimple'] != ''){
			$regionSimple='X';
		} else {
			$regionSimple='';
		}
		if($rowC1['regionSimp1Txt'] != NULL &&  $rowC1['regionSimp1Txt'] != ''){
			$regionSimp1Txt = $rowC1['regionSimp1Txt'];
		} else {
			$regionSimp1Txt='';
		}
		if($rowC1['regionContrastada'] != NULL &&  $rowC1['regionContrastada'] != ''){
			$regionContrastada='X';
		} else {
			$regionContrastada='';
		}
		if($rowC1['regionContr1Txt'] != NULL &&  $rowC1['regionContr1Txt'] != ''){
			$regionContr1Txt = $rowC1['regionContr1Txt'];
		} else {
			$regionContr1Txt='';
		}
		if($rowC1['cortesSenosParanasales'] != NULL &&  $rowC1['cortesSenosParanasales'] != ''){
			$cortesSenosParanasales = 'X';
		} else {
			$cortesSenosParanasales='';
		}
		if($rowC1['craneoSimple'] != NULL &&  $rowC1['craneoSimple'] != ''){
			$craneoSimple = 'X';
		} else {
			$craneoSimple='';
		}
		if($rowC1['craneoContrastado'] != NULL &&  $rowC1['craneoContrastado'] != ''){
			$craneoContrastado = 'X';
		} else {
			$craneoContrastado='';
		}
		if($rowC1['oidoAxialyCoronal'] != NULL &&  $rowC1['oidoAxialyCoronal'] != ''){
			$oidoAxialyCoronal = 'X';
		} else {
			$oidoAxialyCoronal='';
		}
		if($rowC1['urotac'] != NULL &&  $rowC1['urotac'] != ''){
			$urotac = 'X';
		} else {
			$urotac='';
		}
		if($rowC1['regionesSimples'] != NULL &&  $rowC1['regionesSimples'] != ''){
			$regionesSimples = 'X';
		} else {
			$regionesSimples='';
		}
		if($rowC1['regionesSimp2Txt'] != NULL &&  $rowC1['regionesSimp2Txt'] != ''){
			$regionesSimp2Txt = $rowC1['regionesSimp2Txt'];
		} else {
			$regionesSimp2Txt='';
		}
		if($rowC1['regionesContrastadas'] != NULL &&  $rowC1['regionesContrastadas'] != ''){
			$regionesContrastadas = 'X';
		} else {
			$regionesContrastadas='';
		}
		if($rowC1['regionesContr2Txt'] != NULL &&  $rowC1['regionesContr2Txt'] != ''){
			$regionesContr2Txt = $rowC1['regionesContr2Txt'];
		} else {
			$regionesContr2Txt='';
		}
		if($rowC1['columna'] != NULL &&  $rowC1['columna'] != ''){
			$columna = 'X';
		} else {
			$columna='';
		}
		if($rowC1['columnaTxt'] != NULL &&  $rowC1['columnaTxt'] != ''){
			$columnaTxt = $rowC1['columnaTxt'];
		} else {
			$columnaTxt='';
		}
		if($rowC1['craneo'] != NULL &&  $rowC1['craneo'] != ''){
			$craneo = 'X';
		} else {
			$craneo='';
		}
		if($rowC1['craneoTxt'] != NULL &&  $rowC1['craneoTxt'] != ''){
			$craneoTxt = $rowC1['craneoTxt'];
		} else {
			$craneoTxt='';
		}
		if($rowC1['senosParanasales'] != NULL &&  $rowC1['senosParanasales'] != ''){
			$senosParanasales = 'X';
		} else {
			$senosParanasales='';
		}
		if($rowC1['columnaCervical'] != NULL &&  $rowC1['columnaCervical'] != ''){
			$columnaCervical = 'X';
		} else {
			$columnaCervical='';
		}
		if($rowC1['columnaDorsal'] != NULL &&  $rowC1['columnaDorsal'] != ''){
			$columnaDorsal = 'X';
		} else {
			$columnaDorsal='';
		}
		if($rowC1['columnaLumbar'] != NULL &&  $rowC1['columnaLumbar'] != ''){
			$columnaLumbar = 'X';
		} else {
			$columnaLumbar='';
		}
		if($rowC1['teledeTorax'] != NULL &&  $rowC1['teledeTorax'] != ''){
			$teledeTorax = 'X';
		} else {
			$teledeTorax='';
		}
		if($rowC1['teleTorxTxt'] != NULL &&  $rowC1['teleTorxTxt'] != ''){
			$teleTorxTxt = $rowC1['teleTorxTxt'];
		} else {
			$teleTorxTxt='';
		}
		if($rowC1['toraxOseo'] != NULL &&  $rowC1['toraxOseo'] != ''){
			$toraxOseo = 'X';
		} else {
			$toraxOseo='';
		}
		if($rowC1['toraxOseoTxt'] != NULL &&  $rowC1['toraxOseoTxt'] != ''){
			$toraxOseoTxt = $rowC1['toraxOseoTxt'];
		} else {
			$toraxOseoTxt='';
		}
		if($rowC1['esternon'] != NULL &&  $rowC1['esternon'] != ''){
			$esternon = 'X';
		} else {
			$esternon='';
		}
		if($rowC1['abdomenSimple'] != NULL &&  $rowC1['abdomenSimple'] != ''){
			$abdomenSimple = 'X';
		} else {
			$abdomenSimple='';
		}
		if($rowC1['abdomenSimpTxt'] != NULL &&  $rowC1['abdomenSimpTxt'] != ''){
			$abdomenSimpTxt = $rowC1['abdomenSimpTxt'];
		} else {
			$abdomenSimpTxt='';
		}
		if($rowC1['abdomendePie'] != NULL &&  $rowC1['abdomendePie'] != ''){
			$abdomendePie = 'X';
		} else {
			$abdomendePie='';
		}
		if($rowC1['abdomenPieTxt'] != NULL &&  $rowC1['abdomenPieTxt'] != ''){
			$abdomenPieTxt = $rowC1['abdomenPieTxt'];
		} else {
			$abdomenPieTxt='';
		}
		if($rowC1['serieGastroDuodenal'] != NULL &&  $rowC1['serieGastroDuodenal'] != ''){
			$serieGastroDuodenal = 'X';
		} else {
			$serieGastroDuodenal='';
		}
		if($rowC1['serieGastroTxt'] != NULL &&  $rowC1['serieGastroTxt'] != ''){
			$serieGastroTxt = $rowC1['serieGastroTxt'];
		} else {
			$serieGastroTxt='';
		}
		if($rowC1['colonporEnema'] != NULL &&  $rowC1['colonporEnema'] != ''){
			$colonporEnema = 'X';
		} else {
			$colonporEnema='';
		}
		if($rowC1['colonEnemaTxt'] != NULL &&  $rowC1['colonEnemaTxt'] != ''){
			$colonEnemaTxt = $rowC1['colonEnemaTxt'];
		} else {
			$colonEnemaTxt='';
		}
		if($rowC1['transitoIntestinal'] != NULL &&  $rowC1['transitoIntestinal'] != ''){
			$transitoIntestinal = 'X';
		} else {
			$transitoIntestinal='';
		}
		if($rowC1['transitoIntesTxt'] != NULL &&  $rowC1['transitoIntesTxt'] != ''){
			$transitoIntesTxt = $rowC1['transitoIntesTxt'];
		} else {
			$transitoIntesTxt='';
		}
		if($rowC1['urografiaExcretora'] != NULL &&  $rowC1['urografiaExcretora'] != ''){
			$urografiaExcretora = 'X';
		} else {
			$urografiaExcretora='';
		}
		if($rowC1['urografiaExcrTxt'] != NULL &&  $rowC1['urografiaExcrTxt'] != ''){
			$urografiaExcrTxt = $rowC1['urografiaExcrTxt'];
		} else {
			$urografiaExcrTxt='';
		}
		if($rowC1['cristograma'] != NULL &&  $rowC1['cristograma'] != ''){
			$cristograma = 'X';
		} else {
			$cristograma='';
		}
		if($rowC1['cristogramaTxt'] != NULL &&  $rowC1['cristogramaTxt'] != ''){
			$cristogramaTxt = $rowC1['cristogramaTxt'];
		} else {
			$cristogramaTxt='';
		}
		if($rowC1['perfilograma'] != NULL &&  $rowC1['perfilograma'] != ''){
			$perfilograma = 'X';
		} else {
			$perfilograma='';
		}
		if($rowC1['perfilogramaTxt'] != NULL &&  $rowC1['perfilogramaTxt'] != ''){
			$perfilogramaTxt = $rowC1['perfilogramaTxt'];
		} else {
			$perfilogramaTxt='';
		}
		if($rowC1['watters'] != NULL &&  $rowC1['watters'] != ''){
			$watters = 'X';
		} else {
			$watters='';
		}
		if($rowC1['wattersTxt'] != NULL &&  $rowC1['wattersTxt'] != ''){
			$wattersTxt = $rowC1['wattersTxt'];
		} else {
			$wattersTxt='';
		}
		if($rowC1['articulacionesTemporamandibulares'] != NULL &&  $rowC1['articulacionesTemporamandibulares'] != ''){
			$articulacionesTemporamandibulares = 'X';
		} else {
			$articulacionesTemporamandibulares='';
		}
		if($rowC1['lateraldeCuello'] != NULL &&  $rowC1['lateraldeCuello'] != ''){
			$lateraldeCuello = 'X';
		} else {
			$lateraldeCuello='';
		}
		if($rowC1['edadOsea'] != NULL &&  $rowC1['edadOsea'] != ''){
			$edadOsea = 'X';
		} else {
			$edadOsea='';
		}
		if($rowC1['otros'] != NULL &&  $rowC1['otros'] != ''){
			$ot='X';
		} else {
			$ot='';
		}
		if($rowC1['otrosTxt'] != NULL &&  $rowC1['otrosTxt'] != ''){
			$otros = $rowC1['otrosTxt'];
		} else {
			$otros='';
		}
		//$acudeFin = $rowC1['acude'];
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedula']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		$nombre_med = limpiarString($nombre_med);
		//$cabecera = array(utf8_decode("                                             "),utf8_decode('                                                           "La notificación es voluntaria y no punitiva"'),"Fecha de ocurrencia: ".$fechaFin."     Turno: ".$turno,"Personal que Reporta: ".$rowC1['reporta'],"Servicio: ".$rowC1['servicio']);
		
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"FECHA: ".$fechaFin."     HORA: ".$horaFin." hrs.     TURNO: ".$turno."   SERVICIO: ".$rowC1['servicio'],"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"Tel: ".$tel_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio('TRUE');
		//$pdf=new PDF_MC_Table();
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta

		 $pdf->SetTextColor(0);
			
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('IMAGENOLOGÍA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('IMAGENOLOGÍA'),1, 1 , 'C',true);

		//$pdf->tablaSimple($cabecera); //Método que integra datos
		//$pdf->Ln(10);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(200,200,200);
		$pdf->SetY(55);
		$pdf->Cell(0,7,utf8_decode('ULTRASONOGRAFÍA: '),0, 1 , 'L');
		$pdf->SetFont('Arial','',8);
		//Tratar de hacer una tabla
		$pdf->SetWidths(array(40,50,61,45));
		$pdf->Row(array('( '.$tiroides.' ) Tiroides','( '.$mama.' ) Mama',utf8_decode('( '.$higadoVesiculayPancreas.' ) Hígado, Vesícula y Páncreas'),'( '.$renal.' ) Renal'));
		$pdf->Row(array('( '.$abdominal.' ) Abdominal',utf8_decode('( '.$uteroOvariosyVejiga.' ) Útero, Ovarios y Vejiga'),utf8_decode('( '.$pelvico.' ) Pélvico'),'( '.$obstetrico.utf8_decode(' ) Obstétrico')));
		$pdf->Row(array('( '.$vejigayProstata.' ) Vejiga y Prostata','( '.$tejidosBlandos.' ) Tejidos Blandos','( '.$transrectal.' ) Transrectal','( '.$transvaginal.' ) Transvaginal'));
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(0,7,utf8_decode('DOPPLER COLOR: '),0, 1 , 'L');
		$pdf->SetFont('Arial','',8);
		$pdf->SetWidths(array(66,65,65));
		$pdf->Row(array('( '.$carotideoBilateral.' ) Carotideo Bilateral: '.$carotideoBiTxt,'( '.$miembroSuperiorUnilateral.' ) Miembro Superior Unilateral: '.$miembroSupUniTxt,'( '.$miembroSuperiorBilateral.utf8_decode(' ) Miembro Superior Bilateral: '.$miembroSupBiTxt)));
		$pdf->Row(array('( '.$miembroInferiorUnilateral.' ) Miembro Inferior Unilateral: '.$miembroInfUniTxt,'( '.$miembroInferiorBilateral.' ) Miembro Inferior Bilateral: '.$miembroInfBiTxt,'( '.$higadoHipertensionPortal.utf8_decode(' ) Hígado - Hipertensión Portal: ').$higadoPortTxt));
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(0,7,utf8_decode('TOMOGRAFÍA: '),0, 1 , 'L');
		$pdf->SetFont('Arial','',8);
		$pdf->SetWidths(array(76,75,45));
		$pdf->Row(array('( '.$regionSimple.utf8_decode(' ) 1 Región Simple: ').$regionSimp1Txt,'( '.$regionContrastada.utf8_decode(' ) 1 Región Contrastada: ').$regionContr1Txt,'( '.$craneoSimple.utf8_decode(' ) Cráneo Simple')));
		$pdf->SetWidths(array(41,45,35,75));
		$pdf->Row(array('( '.$craneoContrastado.utf8_decode(' ) Cráneo Contrastado'),'( '.$oidoAxialyCoronal.utf8_decode(' ) Oído Axial y Coronal'),'( '.$urotac.' ) UROTAC',utf8_decode('( '.$regionesSimples.' ) 2 Regiones Simples: ').$regionesSimp2Txt));
		$pdf->SetWidths(array(76,75,45));
		$pdf->Row(array('( '.$regionesContrastadas.utf8_decode(' ) 2 Regiones Contrastada: ').$regionesContr2Txt,'( '.$columna.' ) Columna: '.$columnaTxt,'( '.$cortesSenosParanasales.' ) 8 Cortes Senos Paranasales'));
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(0,7,utf8_decode('RADIOLOGÍA: '),0, 1 , 'L');
		$pdf->SetFont('Arial','',8);
		$pdf->SetWidths(array(26,40,40,45,45));
		$pdf->Row(array('( '.$craneo.utf8_decode(' ) Cráneo: ').$craneoTxt,'( '.$senosParanasales.' ) Senos Paranasales','( '.$columnaCervical.' ) Columna Cervical','( '.$columnaDorsal.' ) Columna Dorsal','( '.$columnaLumbar.' ) Columna Lumbar'));
		$pdf->SetWidths(array(76,75,45));
		$pdf->Row(array('( '.$teledeTorax.utf8_decode(' ) Tele de Tórax').$teleTorxTxt,'( '.$toraxOseo.utf8_decode(' ) Tórax Óseo').$toraxOseoTxt,'( '.$esternon.utf8_decode(' ) Esternón')));
		$pdf->SetWidths(array(66,65,65));
		$pdf->Row(array('( '.$abdomenSimple.utf8_decode(' ) Abdomen Simple: ').$abdomenSimpTxt,'( '.$abdomendePie.utf8_decode(' ) Abdomen de Pie: ').$abdomenPieTxt,'( '.$serieGastroDuodenal.utf8_decode(' ) Serie Gastro-Duodenal: ').$serieGastroTxt));
		$pdf->Row(array('( '.$colonporEnema.utf8_decode(' ) Colon por Enema: ').$colonEnemaTxt,'( '.$transitoIntestinal.utf8_decode(' ) Tránsito Intestinal: ').$transitoIntesTxt,'( '.$urografiaExcretora.utf8_decode(' ) Urografía Excretora: ').$urografiaExcrTxt));
		$pdf->Row(array('( '.$cristograma.utf8_decode(' ) Cistograma: ').$cristogramaTxt,'( '.$perfilograma.utf8_decode(' ) Perfilograma: ').$perfilogramaTxt,'( '.$watters.utf8_decode(' ) Watters: ').$wattersTxt));
		$pdf->SetWidths(array(41,40,30,85));
		$pdf->Row(array('( '.$articulacionesTemporamandibulares.utf8_decode(' ) Articulaciónes Temporamandibulares'),'( '.$lateraldeCuello.utf8_decode(' ) Lateral del Cuello'),'( '.$edadOsea.utf8_decode(' ) Edad Ósea'),'( '.$ot.' ) Otros: '.$otros));
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(0,7,utf8_decode('DATOS CLÍNICOS Y/O INDICACIONES ESPECIALES'),0, 1 , 'L');

		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(0,7,$rowC1['datosClinicos'], 1, 'L');
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),0, 1 , 'L');

		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(0,7,$rowC1['diagnostico'], 1, 'L');
		$pdf->Ln(3);
		$pdf->Cell(0,7,utf8_decode('NOMBRE Y FIRMA DEL MÉDICO TRATANTE:'),0,1,'C');
		$pdf->Ln(5);
		$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		$pdf->SetFont('Arial','',8);
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,5,'                 '.utf8_decode($nombre_med),0,1,'C');
		} else {
			$pdf->Cell(0,5,'                 '.$rowC1['nombreMedicoTratante'],0,1,'C');
		}
		$pdf->Cell(0,5,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,5,utf8_decode('                    ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		
		//$pdf->Footer();
		$pdf->Output(); //Salida al navegador del pdf
	}

/***************************************************************************************************************************************************************************************************/
//Esta parte es la que Genera el PDF Imagenologia Imagen
	if($_GET['name'] == 'imagenologiaImg') {
		
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
		
		if(isset ($_GET['id'])){
			$idImagenologia = $_GET['id'];
		} else {
			$idImagenologia = NULL;
		}
		
		if(isset ($_GET['estudio'])){
			$estudio = substr($_GET['estudio'],0,-2);
			$estudio = urldecode(utf8_decode($estudio));
		} else {
			$estudio = NULL;
		}

		if(isset ($_GET['fechaSoliI'])){
			$fechaSoliI = substr($_GET['fechaSoliI'],0,-3);
			$fechaSoliI = urldecode($fechaSoliI);
			$fechaSoli1 = substr($fechaSoliI,0,10);
			$fechaSoli2 = substr($fechaSoliI,10);
		} else {
			$fechaSoliI = NULL;
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
				$calle_pac = trim($resultado[0][0]['DIR_PAC']);
				$col_pac = trim($resultado[0][0]['COL_PAC']);
				$ciudad_pac = trim($resultado[0][0]['CD_PAC']);
				$cp_pac = trim($resultado[0][0]['CP_PAC']);
				$obligado_pac = $resultado[0][0]['OBLI_PAC'];
				$tel_pac = trim($resultado[0][0]['TEL_PAC']);
				$compa_pac = trim($resultado[0][0]['DATO_OPCIONAL8_PAC']);
			}
		}
		
		$turno = null;
		$acudeFin = NULL;
		
		if($expediente != NULL || $expediente != ''){
			$queryCuadro1 = "SELECT * FROM interpretacionesimagen WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND idImagenologia='$idImagenologia' AND estudio='$estudio' AND estatus=1";
			$queryTxtImg = "SELECT * FROM imagenologia WHERE id='$idImagenologia' AND estatus=1";
		} else {
			$queryCuadro1 = "SELECT * FROM interpretacionesimagen WHERE idImagenologia='$idImagenologia' AND estudio='$estudio' AND estatus=1";
			$queryTxtImg = "SELECT * FROM imagenologia WHERE id='$idImagenologia' AND estatus=1";
		}
		
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$result1 = mysqli_query($conexionMedico, $queryTxtImg);
		$rowC2 = mysqli_fetch_array($result1);
		
		//Vamos a meter TODOS los estudios que tienen texto despues del nombre
		$campo=NULL;
		
		if($estudio == 'Carotideo Bilateral'){
			$campo='carotideoBiTxt';
		}
		if($estudio == 'Miembro Superior Unilateral'){
			$campo='miembroSupUniTxt';
		}
		if($estudio == ' Miembro Superior Bilateral'){
			$campo='miembroSupBiTxt';
		}
		if($estudio == 'Miembro Inferior Unilatera'){
			$campo='miembroInfUniTxt';
		}
		if($estudio == 'Miembro Inferior Bilateral'){
			$campo='miembroInfBiTxt';
		}
		if($estudio == utf8_decode('Hígado - Hipertensión Portal')){
			$campo='higadoPortTxt';
		}
		if($estudio == utf8_decode('1 Región Simple')){
			$campo='regionSimp1Txt';
		}
		if($estudio == utf8_decode('1 Región Contrastada')){
			$campo='regionContr1Txt';
		}
		if($estudio == utf8_decode('2 Regiones Simples')){
			$campo='regionesSimp2Txt';
		}
		if($estudio == utf8_decode('2 Regiones Contrastadas')){
			$campo='regionesContr2Txt';
		}
		if($estudio == 'Columna'){
			$campo='columnaTxt';
		}
		if($estudio == utf8_decode('Cráneo')){
			$campo='craneoTxt';
		}
		if($estudio == utf8_decode('Tele de Tórax')){
			$campo='teleTorxTxt';
		}
		if($estudio == utf8_decode('Tórax Óseo')){
			$campo='toraxOseoTxt';
		}
		if($estudio == 'Abdomen Simple'){
			$campo='abdomenSimpTxt';
		}
		if($estudio == utf8_decode('Abdomen de Pie')){
			$campo='abdomenPieTxt';
		}
		if($estudio == 'Serie Gastro-Duodenal'){
			$campo='serieGastroTxt';
		}
		if($estudio == 'Colon por Enema'){
			$campo='colonEnemaTxt';
		}
		if($estudio == utf8_decode('Tránsito Intestinal')){
			$campo='transitoIntesTxt';
		}
		if($estudio == utf8_decode('Urografía Excretora')){
			$campo='urografiaExcrTxt';
		}
		if($estudio == 'Cistograma'){
			$campo='cristogramaTxt';
		}
		if($estudio == 'Perfilograma'){
			$campo='perfilogramaTxt';
		}
		if($estudio == 'Watters'){
			$campo='wattersTxt';
		}
		if($estudio == 'Otros'){
			$campo='otrosTxt';
		}
		
		$estudioSol;
		if($estudio == 'Otros'){
			$estudioSol = NULL;
		} else {
			$estudioSol = $rowC1['estudio'];
		}
		
		
		
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		$horaFin = date('H:i', $fecha);
		
		if($rowC1['turno'] == 'M'){
			$turno='MATUTINO';
		} else if($rowC1['turno'] == 'V'){
			$turno='VESPERTINO';
		} if($rowC1['turno'] == 'N'){
			$turno='NOCTURNO';
		}
		
		
		//$acudeFin = $rowC1['acude'];
		//Datos para medico segun la Cedula Colocada
		$resultadoMed[] = $usuario1->medicosCed($rowC1['cedulaSolicitante']);
		$nombre_med = $resultadoMed[0][0]['DESC_MEDICO'];
	   	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];
		$cedula_med = $resultadoMed[0][0]['CEDULA_MEDICO'];
		
		//Datos para Imagenologo segun la Cedula Colocada
		$resultadoMedIn[] = $usuario1->medicosCed($rowC1['cedulaInterprete']);
		$nombre_medIn = $resultadoMedIn[0][0]['DESC_MEDICO'];
	   	$especialidad_medIn = $resultadoMedIn[0][0]['DESC_ESPEC'];
		$cedula_medIn = $resultadoMedIn[0][0]['CEDULA_MEDICO'];
		$nombre_med = limpiarString($nombre_med);
		//$cabecera = array(utf8_decode("                                             "),utf8_decode('                                                           "La notificación es voluntaria y no punitiva"'),"Fecha de ocurrencia: ".$fechaFin."     Turno: ".$turno,"Personal que Reporta: ".$rowC1['reporta'],"Servicio: ".$rowC1['servicio']);
		
		$cabecera = array("EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"FECHA: ".$fechaSoli1."     HORA: ".$fechaSoli2." hrs.     TURNO: ".$turno,"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."    EDAD: ".utf8_decode($annios)."    SEXO: ".$sexo_pac."    Tel: ".$tel_pac,utf8_decode("DOMICILIO: ".$calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac),"ESTUDIO SOLICITADO: ".$estudioSol.' '.$rowC2[$campo]);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio('TRUE');
		//$pdf=new PDF_MC_Table();
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta

		 $pdf->SetTextColor(0);
			
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('INTERPRETACIÓN IMAGENOLOGÍA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('INTERPRETACIÓN IMAGENOLOGÍA'),1, 1 , 'C',true);

		//$pdf->tablaSimple($cabecera); //Método que integra datos
		//$pdf->Ln(10);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(200,200,200);
		$pdf->SetY(55);
		$pdf->Cell(0,7,utf8_decode('MÉDICO SOLICITANTE: '),0, 1 , 'L');
		$pdf->SetFont('Arial','',9);
		//Tratar de hacer una tabla
		$pdf->SetFont('Arial','',9);
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,4,'                 '.utf8_decode($nombre_med),0,1,'C');
		} else {
			$pdf->Cell(0,4,'                 '.$rowC1['nombreSolicitante'],0,1,'C');
		}
		$pdf->Cell(0,4,'CEDULA PROFESIONAL: '.$cedula_med,0,1,'C');
		$pdf->Cell(0,4,utf8_decode('                          ESPECIALIDAD: '.$especialidad_med),0,1,'C');
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(200,200,200);
		//$pdf->SetY(55);
		$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO PRESUNTIVO: '),0, 1 , 'L');
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(0,7,$rowC2['diagnostico'], 0, 'L');
		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFillColor(200,200,200);
		$pdf->Cell(0,7,utf8_decode('ESTUDIO(S) REALIZADO(S): '),0, 1 , 'L');
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(0,7,$rowC1['estudioRealizado'], 0, 'L');
		$pdf->Ln(3);
		#$pdf->SetFont('Arial','B',10);
		#$pdf->Cell(0,7,utf8_decode('DATOS CLÍNICOS Y/O INDICACIONES ESPECIALES'),0, 1 , 'L');
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(0,7,utf8_decode('INTERPRETACIÓN:'),0, 1 , 'L');
		$pdf->SetFont('Arial','',11);
		$pdf->MultiCell(0,7,$rowC1['interpretacion'], 1, 'L');
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(0,7,utf8_decode('IMPRESIÓN DIAGNOSTICA:'),0, 1 , 'L');

		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(0,7,$rowC1['impresionDiagnostica'], 1, 'L');
		$pdf->Ln(10);
		$pdf->Cell(0,7,utf8_decode('ATENTAMENTE:'),0,1,'C');
		$pdf->Ln(8);
		//$pdf->Cell(0,7,'_______________________________________',0,1,'C');
		$pdf->SetFont('Arial','',9);
		if($nombre_medIn != NULL || $nombre_medIn != ''){
			if(trim($cedula_medIn) == '1042332'){
				$dr = 'DRA.';
			} else{
				$dr = 'DR.';
			}
			$pdf->Cell(0,5,'                 '.$dr.' '.utf8_decode($nombre_medIn),0,1,'C');
		} else {
			
			$pdf->Cell(0,5,'                 '.$nombre_medIn,0,1,'C');
		}
		$pdf->Cell(0,5,'CEDULA PROFESIONAL: '.$cedula_medIn,0,1,'C');
		$pdf->Cell(0,5,utf8_decode('                    ESPECIALIDAD: '.$especialidad_medIn),0,1,'C');
		if(trim($cedula_medIn) == '1042332'){
			$pdf->Cell(0,5,utf8_decode('RSNA FMRI CIR CMRI ESOR                     '),0,1,'C');
			$pdf->Cell(0,5,utf8_decode('     CEDULA DE ESPECIALIDAD: AECEM 26199'),0,1,'C');
			$pdf->Cell(0,5,utf8_decode('RESPONSABLE SANITARIO SSA             '),0,1,'C');
		}
		
		//$pdf->Footer();
		$pdf->Output(); //Salida al navegador del pdf
	}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF CONSENTIMIENTO INFORMADO PROCEDIMIENTOS QX
	if($_GET['name'] == 'consentimientoQx') {
		
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
		$queryCuadro1 = "SELECT * FROM consentimientoqxurg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$fecha1 = strtotime($rowC1['fechaQx']);
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
		
		$months = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO',
				'JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
		$fecha2 = strtotime($rowC1['fecha']);
		$d1 = date('d',$fecha2);
		$m1 = date('m',$fecha2);
		$mi1 = intval($m1);
		$a1 = date('Y',$fecha2);
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode('                                                                                 CUERNAVACA, MORELOS A '.$d1.' DE '.$months[$mi1-1].' DEL '.$a1),"EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("NOMBRE DEL PADRE/MADRE O TUTOR: ".$compa_pac ),"NOMBRE DE OTRA PERSONA LEGALMENTE RESPONSABLE : ".$compa_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('CARTA DE CONSENTIMIENTO INFORMADO PARA PROCEDIMIENTOS QUIRÚRGICOS');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA PROCEDIMIENTOS QUIRÚRGICOS'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		
		//$pdf->Cell(0,7,'SERVICIO: '.$rowC1['servicio'],1, 1 , 'L',true);
		//$pdf->Cell(0,7,utf8_decode('FECHA DE LA CIRUGÍA'),1, 1 , 'C',true);
		//$pdf->MultiCell(0,7,utf8_decode('Día: '.$d1.'   Mes: '.$months[$mi1-1].'   Año: '.$a1),0, 'L');
		#Diagnost
		//$pdf->Ln();
		//$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),1, 1 ,'C',true);
		$procedimientos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['procedimientos'] != NULL || $rowC1['procedimientos'] != ''){
			$procedimientos = $rowC1['procedimientos'];
		}
		
		$riesgos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['riesgos'] != NULL || $rowC1['riesgos'] != ''){
			$riesgos = $rowC1['riesgos'];
		}
		
		$beneficios = '_____________________________________________________________________________________________________________';
		if($rowC1['beneficios'] != NULL || $rowC1['beneficios'] != ''){
			$beneficios = $rowC1['beneficios'];
		}
		
		$alternativas = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['alternativas'] != NULL || $rowC1['alternativas'] != ''){
			$alternativas = $rowC1['alternativas'];
		}
		
		$html =utf8_decode('Usted como paciente, tiene derecho a estar informado sobre su condición, del o los procedimientos quirúrgicos recomendados, así como los riesgos y peligros que conllevan, a fin de poder tomar una decisión informada  de  someterse o no a los procedimientos.  El objeto de esta carta  de consentimiento no  es asustarle  ni  alarmarle, simplemente, es  con el propósito de  que usted esté mejor informado  para poder otorgar o negar su consentimiento para el o los procedimientos. Este consentimiento cumple con los requisitos establecidos en  la Ley General de Salud, sus reglamentos y normas oficiales, así como los de la Ley de Salud del Estado de Morelos.  Con fundamento  en  el  artículo  4to.  De la Constitución Política de  los Estados  Unidos  Mexicanos, la <b>Norma  Oficial  Mexicana  NOM-004-SSA3-2012 del Expediente  Clínico.  Artículos  42,  43,  53 , 54,  55,  57  de  la Ley General  de  Salud;  Artículos  29,  46,  76, 78,  80, 81  y  82  del  Reglamento de la Ley General de Salud en materia de Prestación de Atención Médica. Artículos 42, 43, 54 de la Ley de Salud del Estado de Morelos.</b>');
		
		$html2 =utf8_decode('<b>SOLICITUD VOLUNTARIA PARA TRATAMIENTO:</b> Yo (nosotros) solicito voluntariamente al Dr.(a): <b>'.trim($nombre_med).'</b> Con Cedula Profesional: <b>'.trim($cedula_med).'</b> como mi médico tratante, todos los asociados, asistentes técnicos y demás proveedores de cuidados de la salud que se consideren necesarios, para tratar mi padecimiento actual que es: <u>').$rowC1['diagnostico'].utf8_decode('</u>, el cual se me ha explicado a satisfacción.');
		
		$html3 =utf8_decode('<b>PROCEDIMIENTOS PLANIFICADOS:</b> Yo (nosotros) entiendo que el o los siguientes procedimientos quirúrgicos están planificados para mí y <b>(OTORGO/NIEGO)</b> y mí consentimiento y autorización de forma voluntaria para estos procedimientos: <u>').$procedimientos.'</u>';
		
		$html4 =utf8_decode('<b>DESCUBRIMIENTO DE OTRAS CONDICIONES MEDICAS:</b> Yo (nosotros) entiendo  que  mí médico puede descubrir otras  o  diferentes condiciones que requieran procedimientos adicionales o distintos a los planificados. Otorgo la autorización a mí médico tratante y a todos los asociados,  asistentes  técnicos  y  demás  proveedores  de  cuidados  de  la  salud  a  realizar cualquier otro procedimiento  que  sea  aconsejable  de acuerdo a su criterio profesional. Así como para la atención de contingencias y urgencias derivadas del acto  autorizado, atendiendo al principio de libertad prescriptiva.<br><br><b>RIESGOS DEL TRATAMIENTO:</b> Yo (nosotros)  entiendo que  la garantía  o  seguridad sobre los resultados  del  procedimiento  no  es absoluta y de que es posible que para algunos casos no pueda curarse la enfermedad. Asimismo, entiendo que hay riesgos  y  peligros relacionados con el o los procedimientos quirúrgicos planificados para mí. Estoy consciente de que en los procedimientos quirúrgicos es común la posibilidad de infección, coágulos de sangre  en  venas  y  pulmones, sangrado  excesivo,  reacciones alérgicas  e  incluso  la muerte. Entiendo que también existen riesgos, en caso de no aceptar el o los procedimientos quirúrgicos relacionados con la progresión  o  empeoramiento  de  mi  condición que incluyen todas las categorías anteriormente mencionadas.  Además, estoy  consciente  de que pueden presentarse los riesgos y peligros listados a continuación, en relación a este procedimiento en particular:
		<br><br><b>RIESGOS ADICIONALES DEL TRATAMIENTO: </b><br><u>').$riesgos.'</u><br><br><b>BENEFICIOS DEL TRATAMIENTO:</b><br> <u>'.$beneficios.'</u><br><br><b>POSIBLES ALTERNATIVAS DE TRATAMIENTO: </b><br><u>'.$alternativas.'</u>';
		
		$html5 =utf8_decode('<b>EL MEDICO ME HA EXPLICADO LOS SIGUIENTES PUNTOS:</b><br>
      - La naturaleza de los cuidados, el tratamiento, los servicios, los medicamentos, las intervenciones o los procedimientos propuestos.<br>
      - Los posibles beneficios, riesgos o afectos secundarios, incluidos posibles problemas relacionados con la recuperación.<br>
      - La probabilidad de alcanzar las metas de cuidados, tratamiento y servicios.<br>
      - Las alternativas razonables a los cuidados, tratamientos y los servicios propuestos.<br>
      - Los riesgos, beneficios y efectos secundarios relevantes relacionados con las alternativas de tratamiento, incluidos los posibles resultados si no se reciben cuidados, tratamiento ni servicios.<br>
      - Los asistentes necesarios para el tratamiento, a fin de realizar las tareas delegadas bajo mi supervisión.<br><br><b>DISPOSICIÓN DEL TEJIDO EXTRAÍDO:</b> Yo (nosotros) <b>(OTORGO/NIEGO)</b> la  autorización  al  Hospital  a  conservar  cualquier  tejido extraído durante  mi  cirugía  o  procedimiento, para la realización del estudio histopatológico, así como para su disposición final cuando así corresponda.<br><br><b>OBSERVACIÓN DEL PROCEDIMIENTO:</b> Yo  (nosotros) <b>(OTORGO/NIEGO)</b>  mi  consentimiento  para  la  admisión  de  observadores  durante  la  cirugía  o  el  procedimiento  con fines de educación médica o de la salud relacionadas.<br><br><b>FOTOGRAFÍAS O FILMACIÓN DEL PROCEDIMIENTO:</b> Yo (nosotros) <b>(OTORGO/NIEGO)</b> mi consentimiento para que se fotografíen o filmen las cirugías o procedimientos que se realicen.
		<br><br><b>OPORTUNIDAD PARA HACER PREGUNTAS:</b> Yo (nosotros) tuve la oportunidad de hacer preguntas acerca de mi condición, las formas alternativas  de  anestesia,  el tratamiento, los riesgos de no seguir el tratamiento,  los  procedimientos  que  se  usarán,  y  los  riesgos  y peligros involucrados. Considero que cuento con la información suficiente para otorgar este consentimiento informado.
		<br><br><b>CERTIFICACIÓN - FORMULACIÓN DE COMPRENSIÓN DEL CONOCIMIENTO:</b> Yo (nosotros) certifico  que  me han  explicado en detalle este consentimiento, que lo he leído o me lo han leído, que los espacios en blanco han sido completados o cancelados, y que entiendo  su  contenido  y acepto los riesgos y  peligros.  Asimismo, entiendo  y  acepto  que  pueden presentarse riesgos  y  peligros adicionales.
		
		<br><br>Yo  (nosotros)  acepto  ser  ingresado  al  Hospital Henri Dunant  con  el  fin  de diagnosticar o recibir tratamiento como lo ha indicado  mi Médico Tratante. Autorizo al Hospital Henri Dunant, a todos los médicos, a todos los asociados, asistentes técnicos y demás proveedores de  cuidados  de  la  salud  de  dicha  institución  a  proporcionar  todos  los  servicios médicos que sean necesarios,  así  como todos  los procedimientos  médicos, quirúrgicos,  o  de  diagnóstico  para  mi  condición. Autorizo también  a  los  médicos,  a  todos  los  asociados, asistentes  técnicos  y  demás proveedores de  cuidados  de  la salud  del Hospital  Henri  Dunant  para  que  lleven  a  cabo  los  actos  y procedimientos en caso de contingencia y urgencias que pudieran presentarse durante la hospitalización.
		
		<br><br>Yo (nosotros) entiendo que existen riesgos derivados de la hospitalización y/o cualquier atención médica; también estoy  consciente que la  administración  de  medicamentos,  de  cualquier  índole,  puede generar  fenómenos  alérgicos  y/o  anafilácticos,  sin  que  ello  sea  responsabilidad directa o indirecta del médico tratante, de los médicos, de todos los asociados, asistentes técnicos y demás proveedores de cuidados en la salud o del Hospital Henri Dunant.
		
		<br><br>Yo (nosotros) entiendo que no se me proporciona garantía alguna respecto de ningún resultado ni cura. No se garantizan o aseguran los resultados del o los procedimientos o tratamientos a los sea sometido por indicación de mi médico tratante.  El personal médico y demás asistentes se basarán en la información proporcionada por mi persona  y/o mi representante para la realización de la historia clínica para determinar el o los procedimientos a practicar o el curso del tratamiento para tratar mi condición.<br><br><b>En mi presencia han sido llenados o cancelados todos los espacios en blanco que se presenten en este documento.</b>');
		
		$html6 =utf8_decode('<b>Declaración médica:</b> Yo certifico que el  paciente/padre/madre/tutor  u otra persona legalmente responsable han sido informados sobre los riesgos y peligros, los beneficios y alternativas de tratamiento según se explico anteriormente, que todas sus preguntas relativas a mi área de experiencia han sido respondidas y que ha otorgado su consentimiento.');
		//$pdf->WriteHTML($html);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html2),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html3),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html4),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html5),0,'L');
		
		//Termina hoja1
		//3ra Pagina
		$pdf->Ln(15);
		$pdf->Cell(0,7,'          _______________________________________                    __________________________________________',0,1,'L');
		$pdf->Cell(0,7,utf8_decode('                '.$nombre_pac.'                                        '.$compa_pac),0,1,'L');
		$pdf->Cell(0,7,utf8_decode('                     Nombre y firma del paciente                                            Nombre y firma del padre/madre/tutor u otra persona'),0,1,'L');
		$pdf->Cell(0,7,utf8_decode('                                                                                                                                        legalmente responsable'),0,1,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,7,'__________________________________________________________________________________________________________',0,1,'C');
		$pdf->Cell(0,7,utf8_decode('Motivo por el que el paciente no puede firmar.'),0,1,'C');
		$pdf->Ln();
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html6),0,'L');
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
			$pdf->Cell(0,7,'            Dr.(a): '.utf8_decode($nombre_med).'                    Nombre y Firma del Testigo',0,1,'L');
		} else {
			$pdf->Cell(0,7,'            Dr.(a): '.$rowC1['nombreMedicoTratante'].'                    Nombre y Firma del Testigo',0,1,'L');
		}
		$pdf->Cell(0,7,utf8_decode('                    Cédula Profesional: ').$cedula_med,0,1,'L');
		//$pdf->Cell(0,7,utf8_decode('               Especialidad: '.$especialidad_med),0,1,'L');
		$pdf->Cell(0,7,utf8_decode('Nombre, Firma y Cédula Profesional del Médico Tratante'),0,1,'L');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Consentimiento Quirurgico
	if($_GET['name'] == 'consentimientoQxH') {
		
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
		$queryCuadro1 = "SELECT * FROM consentimientoqxh WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$fecha1 = strtotime($rowC1['fechaQx']);
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
		
		$months = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO',
				'JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
		$fecha2 = strtotime($rowC1['fecha']);
		$d1 = date('d',$fecha2);
		$m1 = date('m',$fecha2);
		$mi1 = intval($m1);
		$a1 = date('Y',$fecha2);
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode('                                                                                 CUERNAVACA, MORELOS A '.$d1.' DE '.$months[$mi1-1].' DEL '.$a1),"EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("NOMBRE DEL PADRE/MADRE O TUTOR: ".$compa_pac ),"NOMBRE DE OTRA PERSONA LEGALMENTE RESPONSABLE : ".$compa_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('CARTA DE CONSENTIMIENTO INFORMADO PARA PROCEDIMIENTOS QUIRÚRGICOS');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA PROCEDIMIENTOS QUIRÚRGICOS'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		
		//$pdf->Cell(0,7,'SERVICIO: '.$rowC1['servicio'],1, 1 , 'L',true);
		//$pdf->Cell(0,7,utf8_decode('FECHA DE LA CIRUGÍA'),1, 1 , 'C',true);
		//$pdf->MultiCell(0,7,utf8_decode('Día: '.$d1.'   Mes: '.$months[$mi1-1].'   Año: '.$a1),0, 'L');
		#Diagnost
		//$pdf->Ln();
		//$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),1, 1 ,'C',true);
		$procedimientos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['procedimientos'] != NULL || $rowC1['procedimientos'] != ''){
			$procedimientos = $rowC1['procedimientos'];
		}
		
		$riesgos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['riesgos'] != NULL || $rowC1['riesgos'] != ''){
			$riesgos = $rowC1['riesgos'];
		}
		
		$beneficios = '_____________________________________________________________________________________________________________';
		if($rowC1['beneficios'] != NULL || $rowC1['beneficios'] != ''){
			$beneficios = $rowC1['beneficios'];
		}
		
		$alternativas = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['alternativas'] != NULL || $rowC1['alternativas'] != ''){
			$alternativas = $rowC1['alternativas'];
		}
		
		$html =utf8_decode('Usted como paciente, tiene derecho a estar informado sobre su condición, del o los procedimientos quirúrgicos recomendados, así como los riesgos y peligros que conllevan, a fin de poder tomar una decisión informada  de  someterse o no a los procedimientos.  El objeto de esta carta  de consentimiento no  es asustarle  ni  alarmarle, simplemente, es  con el propósito de  que usted esté mejor informado  para poder otorgar o negar su consentimiento para el o los procedimientos. Este consentimiento cumple con los requisitos establecidos en  la Ley General de Salud, sus reglamentos y normas oficiales, así como los de la Ley de Salud del Estado de Morelos.  Con fundamento  en  el  artículo  4to.  De la Constitución Política de  los Estados  Unidos  Mexicanos, la <b>Norma  Oficial  Mexicana  NOM-004-SSA3-2012 del Expediente  Clínico.  Artículos  42,  43,  53 , 54,  55,  57  de  la Ley General  de  Salud;  Artículos  29,  46,  76, 78,  80, 81  y  82  del  Reglamento de la Ley General de Salud en materia de Prestación de Atención Médica. Artículos 42, 43, 54 de la Ley de Salud del Estado de Morelos.</b>');
		
		$html2 =utf8_decode('<b>SOLICITUD VOLUNTARIA PARA TRATAMIENTO:</b> Yo (nosotros) solicito voluntariamente al Dr.(a): <b>'.trim($nombre_med).'</b> Con Cedula Profesional: <b>'.trim($cedula_med).'</b> como mi médico tratante, todos los asociados, asistentes técnicos y demás proveedores de cuidados de la salud que se consideren necesarios, para tratar mi padecimiento actual que es: <u>').$rowC1['diagnostico'].utf8_decode('</u>, el cual se me ha explicado a satisfacción.');
		
		$html3 =utf8_decode('<b>PROCEDIMIENTOS PLANIFICADOS:</b> Yo (nosotros) entiendo que el o los siguientes procedimientos quirúrgicos están planificados para mí y <b>(OTORGO/NIEGO)</b> y mí consentimiento y autorización de forma voluntaria para estos procedimientos: <u>').$procedimientos.'</u>';
		
		$html4 =utf8_decode('<b>DESCUBRIMIENTO DE OTRAS CONDICIONES MEDICAS:</b> Yo (nosotros) entiendo  que  mí médico puede descubrir otras  o  diferentes condiciones que requieran procedimientos adicionales o distintos a los planificados. Otorgo la autorización a mí médico tratante y a todos los asociados,  asistentes  técnicos  y  demás  proveedores  de  cuidados  de  la  salud  a  realizar cualquier otro procedimiento  que  sea  aconsejable  de acuerdo a su criterio profesional. Así como para la atención de contingencias y urgencias derivadas del acto  autorizado, atendiendo al principio de libertad prescriptiva.<br><br><b>RIESGOS DEL TRATAMIENTO:</b> Yo (nosotros)  entiendo que  la garantía  o  seguridad sobre los resultados  del  procedimiento  no  es absoluta y de que es posible que para algunos casos no pueda curarse la enfermedad. Asimismo, entiendo que hay riesgos  y  peligros relacionados con el o los procedimientos quirúrgicos planificados para mí. Estoy consciente de que en los procedimientos quirúrgicos es común la posibilidad de infección, coágulos de sangre  en  venas  y  pulmones, sangrado  excesivo,  reacciones alérgicas  e  incluso  la muerte. Entiendo que también existen riesgos, en caso de no aceptar el o los procedimientos quirúrgicos relacionados con la progresión  o  empeoramiento  de  mi  condición que incluyen todas las categorías anteriormente mencionadas.  Además, estoy  consciente  de que pueden presentarse los riesgos y peligros listados a continuación, en relación a este procedimiento en particular:
		<br><br><b>RIESGOS ADICIONALES DEL TRATAMIENTO: </b><br><u>').$riesgos.'</u><br><br><b>BENEFICIOS DEL TRATAMIENTO:</b><br> <u>'.$beneficios.'</u><br><br><b>POSIBLES ALTERNATIVAS DE TRATAMIENTO: </b><br><u>'.$alternativas.'</u>';
		
		$html5 =utf8_decode('<b>EL MEDICO ME HA EXPLICADO LOS SIGUIENTES PUNTOS:</b><br>
      - La naturaleza de los cuidados, el tratamiento, los servicios, los medicamentos, las intervenciones o los procedimientos propuestos.<br>
      - Los posibles beneficios, riesgos o afectos secundarios, incluidos posibles problemas relacionados con la recuperación.<br>
      - La probabilidad de alcanzar las metas de cuidados, tratamiento y servicios.<br>
      - Las alternativas razonables a los cuidados, tratamientos y los servicios propuestos.<br>
      - Los riesgos, beneficios y efectos secundarios relevantes relacionados con las alternativas de tratamiento, incluidos los posibles resultados si no se reciben cuidados, tratamiento ni servicios.<br>
      - Los asistentes necesarios para el tratamiento, a fin de realizar las tareas delegadas bajo mi supervisión.<br><br><b>DISPOSICIÓN DEL TEJIDO EXTRAÍDO:</b> Yo (nosotros) <b>(OTORGO/NIEGO)</b> la  autorización  al  Hospital  a  conservar  cualquier  tejido extraído durante  mi  cirugía  o  procedimiento, para la realización del estudio histopatológico, así como para su disposición final cuando así corresponda.<br><br><b>OBSERVACIÓN DEL PROCEDIMIENTO:</b> Yo  (nosotros) <b>(OTORGO/NIEGO)</b>  mi  consentimiento  para  la  admisión  de  observadores  durante  la  cirugía  o  el  procedimiento  con fines de educación médica o de la salud relacionadas.<br><br><b>FOTOGRAFÍAS O FILMACIÓN DEL PROCEDIMIENTO:</b> Yo (nosotros) <b>(OTORGO/NIEGO)</b> mi consentimiento para que se fotografíen o filmen las cirugías o procedimientos que se realicen.
		<br><br><b>OPORTUNIDAD PARA HACER PREGUNTAS:</b> Yo (nosotros) tuve la oportunidad de hacer preguntas acerca de mi condición, las formas alternativas  de  anestesia,  el tratamiento, los riesgos de no seguir el tratamiento,  los  procedimientos  que  se  usarán,  y  los  riesgos  y peligros involucrados. Considero que cuento con la información suficiente para otorgar este consentimiento informado.
		<br><br><b>CERTIFICACIÓN - FORMULACIÓN DE COMPRENSIÓN DEL CONOCIMIENTO:</b> Yo (nosotros) certifico  que  me han  explicado en detalle este consentimiento, que lo he leído o me lo han leído, que los espacios en blanco han sido completados o cancelados, y que entiendo  su  contenido  y acepto los riesgos y  peligros.  Asimismo, entiendo  y  acepto  que  pueden presentarse riesgos  y  peligros adicionales.
		
		<br><br>Yo  (nosotros)  acepto  ser  ingresado  al  Hospital Henri Dunant  con  el  fin  de diagnosticar o recibir tratamiento como lo ha indicado  mi Médico Tratante. Autorizo al Hospital Henri Dunant, a todos los médicos, a todos los asociados, asistentes técnicos y demás proveedores de  cuidados  de  la  salud  de  dicha  institución  a  proporcionar  todos  los  servicios médicos que sean necesarios,  así  como todos  los procedimientos  médicos, quirúrgicos,  o  de  diagnóstico  para  mi  condición. Autorizo también  a  los  médicos,  a  todos  los  asociados, asistentes  técnicos  y  demás proveedores de  cuidados  de  la salud  del Hospital  Henri  Dunant  para  que  lleven  a  cabo  los  actos  y procedimientos en caso de contingencia y urgencias que pudieran presentarse durante la hospitalización.
		
		<br><br>Yo (nosotros) entiendo que existen riesgos derivados de la hospitalización y/o cualquier atención médica; también estoy  consciente que la  administración  de  medicamentos,  de  cualquier  índole,  puede generar  fenómenos  alérgicos  y/o  anafilácticos,  sin  que  ello  sea  responsabilidad directa o indirecta del médico tratante, de los médicos, de todos los asociados, asistentes técnicos y demás proveedores de cuidados en la salud o del Hospital Henri Dunant.
		
		<br><br>Yo (nosotros) entiendo que no se me proporciona garantía alguna respecto de ningún resultado ni cura. No se garantizan o aseguran los resultados del o los procedimientos o tratamientos a los sea sometido por indicación de mi médico tratante.  El personal médico y demás asistentes se basarán en la información proporcionada por mi persona  y/o mi representante para la realización de la historia clínica para determinar el o los procedimientos a practicar o el curso del tratamiento para tratar mi condición.<br><br><b>En mi presencia han sido llenados o cancelados todos los espacios en blanco que se presenten en este documento.</b>');
		
		$html6 =utf8_decode('<b>Declaración médica:</b> Yo certifico que el  paciente/padre/madre/tutor  u otra persona legalmente responsable han sido informados sobre los riesgos y peligros, los beneficios y alternativas de tratamiento según se explico anteriormente, que todas sus preguntas relativas a mi área de experiencia han sido respondidas y que ha otorgado su consentimiento.');
		//$pdf->WriteHTML($html);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html2),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html3),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html4),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html5),0,'L');
		
		//Termina hoja1
		//3ra Pagina
		$pdf->Ln(15);
		$pdf->Cell(0,7,'          _______________________________________                    __________________________________________',0,1,'L');
		$pdf->Cell(0,7,utf8_decode('                '.$nombre_pac.'                                        '.$compa_pac),0,1,'L');
		$pdf->Cell(0,7,utf8_decode('                     Nombre y firma del paciente                                            Nombre y firma del padre/madre/tutor u otra persona'),0,1,'L');
		$pdf->Cell(0,7,utf8_decode('                                                                                                                                        legalmente responsable'),0,1,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,7,'__________________________________________________________________________________________________________',0,1,'C');
		$pdf->Cell(0,7,utf8_decode('Motivo por el que el paciente no puede firmar.'),0,1,'C');
		$pdf->Ln();
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html6),0,'L');
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
			$pdf->Cell(0,7,'            Dr.(a): '.utf8_decode($nombre_med).'                    Nombre y Firma del Testigo',0,1,'L');
		} else {
			$pdf->Cell(0,7,'            Dr.(a): '.$rowC1['nombreMedicoTratante'].'                    Nombre y Firma del Testigo',0,1,'L');
		}
		$pdf->Cell(0,7,utf8_decode('                    Cédula Profesional: ').$cedula_med,0,1,'L');
		//$pdf->Cell(0,7,utf8_decode('               Especialidad: '.$especialidad_med),0,1,'L');
		$pdf->Cell(0,7,utf8_decode('Nombre, Firma y Cédula Profesional del Médico Tratante'),0,1,'L');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	} 
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF Consentimiento Ingreso hospi Urgencias
	if($_GET['name'] == 'consentimientoIh') {
		
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
		$queryCuadro1 = "SELECT * FROM consentimientoihurg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		/*$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);*/
		
		$fecha1 = strtotime($rowC1['fechaIh']);
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
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA INGRESO HOSPITALARIO'),0, 0, 'C');
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
		$pdf->MultiCell(0,5,utf8_decode('Yo (nosotros) acepto ser ingresado al Hospital Henri Dunant con el fin de diagnosticar o recibir tratamiento como lo ha indicado mi Médico Tratante. Autorizo al Hospital Henri Dunant, a todos los médicos, a todos los asociados, asistentes técnicos y demás proveedores de cuidados de la salud de dicha institución a proporcionar todos los servicios médicos que sean necesarios, así como todos los procedimientos médicos, quirúrgicos, o de diagnóstico para mi condición con el objetivo de mejorar mi estado de salud. Autorizo también al personal de salud del Hospital Henri Dunant para que lleven a cabo los actos y procedimientos en caso de contingencia y urgencias derivadas del acto autorizado, atendiendo al principio de libertad prescriptiva.'),0,'J');
		$pdf->Ln(3);
		$pdf->MultiCell(0,5,utf8_decode('Yo (nosotros) entiendo que existen riesgos derivados de la hospitalización y/o cualquier atención médica; también estoy consciente de que la administración de medicamentos, de cualquier índole, puede generar fenómenos alérgicos y/o anafilácticos, sin que ello sea responsabilidad directa o indirecta del médico tratante, de los médicos, de todos los asociados, asistentes técnicos y demás proveedores de cuidados en la salud o del Hospital Henri Dunant.'),0,'J');
		$pdf->Ln(3);
		$pdf->MultiCell(0,5,utf8_decode('Yo (nosotros) entiendo que no se me proporciona garantía alguna respecto de ningún resultado ni cura. No se garantizan o aseguran los resultados del o los procedimientos o tratamientos a los que sea sometido por indicación de mi médico tratante. El personal médico y demás asistentes se basarán en la información proporcionada por mi persona y/o mi representante para la realización de la historia clínica para determinar el o los procedimientos a practicar o el curso del tratamiento para tratar mi condición y manifiesto que he sido informado que durante el proceso de atención existe la probabilidad de participación de personal en formación del área no médica que se encuentra bajo la supervisión correspondiente y adecuada. '),0,'J');

		$html1 =utf8_decode('Yo (nosotros) estoy informado que está autorización inicial  no  excluye  la  necesidad de recabar después  la  firma correspondiente para procedimientos médicos, quirúrgicos, de diagnóstico y de alto riesgo.  Este consentimiento cumple  con los requisitos establecidos  en  la Ley general de Salud sus reglamentos y normas oficiales, así como los de la Ley de Salud del Estado de Morelos. Con fundamento en el artículo  4to.  De  la  Constitución  Política  de  los Estados  Unidos  Mexicanos, <b>la  Norma Oficial  Mexicana  NOM-004-SSA3-2012  del Expediente  Clínico. Artículos  42,  43,  53,  54,  55,  57  de  la  Ley General  de Salud;  Artículos  29,  46,  76,  78,  80,  81  y  82 del Reglamento de  la Ley General de Salud en materia  de  Prestación de Atención Médica. Artículos  42,  43,  54 de la Ley de Salud del Estado de Morelos.</b>');
		$html2 =utf8_decode('<b>No se permite el ingreso de medicamentos que requieran red fría o red obscura (termolábiles o termosensibles)</b>');
		$html3 =utf8_decode('<b>En mi presencia han sido llenados o cancelados todos los espacios en blanco que se presenten en este documento</b>');
		$html6 =utf8_decode('<b>Declaración médica:</b> Yo certifico que el  paciente/padre/madre/tutor  u  otra persona legalmente responsable  han sido informados sobre los riesgos y peligros, los beneficios y alternativas de tratamiento según se explico anteriormente, que todas sus preguntas relativas a mi área de experiencia han sido respondidas y que ha otorgado su consentimiento.');
		$pdf->Ln(3);
		$pdf->MultiCell(0,4,$pdf->WriteHTML($html1),0,'J');
		$pdf->Ln(3);
		$pdf->MultiCell(0,4,$pdf->WriteHTML($html2),0,'J');
		$pdf->Ln(3);
		$pdf->MultiCell(0,4,$pdf->WriteHTML($html3),0,'J');
		/*$pdf->MultiCell(0,7,$pdf->WriteHTML($html2),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html3),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html4),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html5),0,'L');*/
		
		//Termina hoja1
		//3ra Pagina
		$pdf->Ln(10);
		$pdf->Cell(0,7,'          _______________________________________                    __________________________________________',0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                '.$nombre_pac.'                                        '.$compa_pac),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                     Nombre y firma del paciente                                            Nombre y firma del padre/madre/tutor u otra persona'),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                                                                                                                                        legalmente responsable'),0,1,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,7,'__________________________________________________________________________________________________________',0,1,'C');
		$pdf->Cell(0,5,utf8_decode('Motivo por el que el paciente no puede firmar.'),0,1,'C');
		$pdf->Cell(0,20,'',0,1,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(60,32);
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA INGRESO HOSPITALARIO'),0, 0, 'C');
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
		$turno1 = '';
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
/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF CONSENTIMIENTO INFORMADO ANESTESIA
	if($_GET['name'] == 'consentimientoAneste') {
		
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
		$queryCuadro1 = "SELECT * FROM consentimientoanesturg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$fecha1 = strtotime($rowC1['fechaQx']);
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
		
		$months = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO',
				'JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
		$fecha2 = strtotime($rowC1['fecha']);
		$d1 = date('d',$fecha2);
		$m1 = date('m',$fecha2);
		$mi1 = intval($m1);
		$a1 = date('Y',$fecha2);
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode('                                                                                 CUERNAVACA, MORELOS A '.$d1.' DE '.$months[$mi1-1].' DEL '.$a1),"EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("NOMBRE DEL PADRE/MADRE O TUTOR: ".$compa_pac ),"NOMBRE DE OTRA PERSONA LEGALMENTE RESPONSABLE : ".$compa_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('CARTA DE CONSENTIMIENTO INFORMADO PARA PROCEDIMIENTO DE ANESTESIA');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA PROCEDIMIENTO DE ANESTESIA'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		
		//$pdf->Cell(0,7,'SERVICIO: '.$rowC1['servicio'],1, 1 , 'L',true);
		//$pdf->Cell(0,7,utf8_decode('FECHA DE LA CIRUGÍA'),1, 1 , 'C',true);
		//$pdf->MultiCell(0,7,utf8_decode('Día: '.$d1.'   Mes: '.$months[$mi1-1].'   Año: '.$a1),0, 'L');
		#Diagnost
		//$pdf->Ln();
		//$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),1, 1 ,'C',true);
		$procedimientos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['procedimientos'] != NULL || $rowC1['procedimientos'] != ''){
			$procedimientos = $rowC1['procedimientos'];
		}
		
		$riesgos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['riesgos'] != NULL || $rowC1['riesgos'] != ''){
			$riesgos = $rowC1['riesgos'];
		}
		
		$beneficios = '_____________________________________________________________________________________________________________';
		if($rowC1['beneficios'] != NULL || $rowC1['beneficios'] != ''){
			$beneficios = $rowC1['beneficios'];
		}
		
		$alternativas = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['alternativas'] != NULL || $rowC1['alternativas'] != ''){
			$alternativas = $rowC1['alternativas'];
		}
		
		$html =utf8_decode('Usted como paciente, tiene derecho a estar informado sobre su condición, del o los procedimientos médicos quirúrgicos y de diagnóstico recomendados, así como los riesgos y peligros que conllevan, a fin  de  poder tomar una decisión informada  de  someterse  o  no  a  los  procedimientos. El objeto  de  esta carta de consentimiento no  es asustarle ni alarmarle, simplemente, es  con el propósito de que usted esté mejor informado  para poder otorgar o negar su consentimiento para el  o  los procedimientos. Este consentimiento cumple  con  los requisitos establecidos en  la Ley General de Salud, sus reglamentos y normas oficiales, así como los  de  la Ley de Salud del Estado de  Morelos. Con fundamento en el artículo 4to. De la Constitución Política de  los Estados Unidos Mexicanos, la <b>Norma  Oficial  Mexicana  NOM-004-SSA3-2012 del Expediente  Clínico.  Artículos  42,  43,  53 , 54,  55,  57  de  la Ley General  de  Salud;  Artículos  29,  46,  76, 78,  80, 81  y  82  del  Reglamento de la Ley General de Salud en materia de Prestación de Atención Médica. Artículos 42, 43, 54 de la Ley de Salud del Estado de Morelos.</b>');
		
		$html2 =utf8_decode('<b>SOLICITUD VOLUNTARIA PARA TRATAMIENTO:</b> Yo (nosotros) solicito voluntariamente al Dr.(a): <b>'.trim($nombre_med).'</b> Con Cedula Profesional: <b>'.trim($cedula_med).'</b> como mi médico tratante, todos los asociados, asistentes técnicos y demás proveedores de cuidados de la salud que se consideren necesarios, para tratar mi padecimiento actual que es: <u>').$rowC1['diagnostico'].utf8_decode('</u>, el cual se me ha explicado a satisfacción.');
		
		/*$html3 =utf8_decode('<b>PROCEDIMIENTOS PLANIFICADOS:</b> Yo (nosotros) entiendo que el o los siguientes procedimientos quirúrgicos están planificados para mí y <b>(OTORGO/NIEGO)</b> y mí consentimiento y autorización de forma voluntaria para estos procedimientos: <u>').$procedimientos.'</u>';*/
		
		$html4 =utf8_decode('<b>EL MEDICO ME HA EXPLICADO LOS SIGUIENTES PUNTOS:</b><br>
      - La naturaleza de los cuidados, el tratamiento, los servicios, los medicamentos, las intervenciones o los procedimientos propuestos.<br>
      - Los posibles beneficios, riesgos o afectos secundarios, incluidos posibles problemas relacionados con la recuperación.<br>
      - La probabilidad de alcanzar las metas de cuidados, tratamiento y servicios.<br>
      - Las alternativas razonables a los cuidados, tratamientos y los servicios propuestos.<br>
      - Los riesgos, beneficios y efectos secundarios relevantes relacionados con las alternativas de tratamiento, incluidos los posibles resultados si no se reciben cuidados, tratamiento ni servicios.<br>
      - Los asistentes necesarios para el tratamiento, a fin de realizar las tareas delegadas bajo mi supervisión.
	  <br><br><b>RIESGOS DE LA ANESTESIA:</b> Yo (nosotros) entiendo  que  la  anestesia implica riesgos  y  peligros adicionales, pero solicito  el  uso de anestésicos para obtener alivio  y  protección contra  el  dolor durante  los procedimientos planificados y adicionales. Estoy consciente de que es posible  que  se  cambie de anestesia sin darme explicación alguna.  Otorgo mi consentimiento en forma voluntaria para el uso de agentes anestésicos. Yo (nosotros)  entiendo  que  el  uso  de  cualquier  anestésico  puede  ocasionar  ciertas complicaciones, incluidos problemas  cardiacos,  respiratorios,  en  el  sistema  nervioso  central,  reacciones al  medicamento  o  incluso  la  muerte. El proceso de intubación durante  la  anestesia general puede presentar lesiones en  las cuerdas vocales, en los labios, los dientes y los ojos. Entiendo que los anestésicos espinales o epidurales también conllevan riesgos que incluyen alteraciones en el sistema nervioso central, la medula espinal  y  la  espalda. Para  las  mujeres  embarazadas,  existen  los  riesgos  y  peligros adicionales  tanto  para la madre  como para el producto.  Mi  médico  me  ha  explicado  tipos  alternativos  de  anestesia,  si  corresponde.  Yo  (nosotros)  entiendo   que   la  sedación momentánea  o  consciente puede progresar  a  sedación profunda  o  anestesia general. Yo (nosotros) entiendo que la anestesia puede incluir  la  colocación  de  monitores invasivos, cuando  así  sea  el  caso,  los  cuales  conllevan  riesgos y complicaciones propios  de la introducción de catéteres invasivos y la necesidad de realizar procedimientos adicionales.
	  <br><br><b>RIESGOS ADICIONALES: </b><br><u>').$riesgos.'</u><br><br><br><b>BENEFICIOS DE LA ANESTESIA:</b><br> <u>'.$beneficios.'</u><br><br><b>POSIBLES ALTERNATIVAS DE TRATAMIENTO: </b><br><u>'.$alternativas.'</u>';
		
		$html5 =utf8_decode('Yo (nosotros) entiendo que existen riesgos derivados de la hospitalización y/o cualquier atención médica; también estoy  consciente que la  administración  de  medicamentos,  de  cualquier  índole,  puede generar  fenómenos  alérgicos  y/o  anafilácticos,  sin  que  ello  sea  responsabilidad directa o indirecta del médico tratante, de los médicos, de todos los asociados, asistentes técnicos y demás proveedores de cuidados en la salud o del Hospital Henri Dunant.
		
		<br><br>Yo (nosotros) entiendo que no se me proporciona garantía alguna respecto de ningún resultado ni cura. No se garantizan o aseguran los resultados del o los procedimientos o tratamientos a los sea sometido por indicación de mi médico tratante.  El personal médico y demás asistentes se basarán en la información proporcionada por mi persona  y/o mi representante para la realización de la historia clínica para determinar el o los procedimientos a practicar o el curso del tratamiento para tratar mi condición.<br><br><b>En mi presencia han sido llenados o cancelados todos los espacios en blanco que se presenten en este documento.</b>');
		
		$html6 =utf8_decode('<b>Declaración médica:</b> Yo certifico que el  paciente/padre/madre/tutor  u otra persona legalmente responsable han sido informados sobre los riesgos y peligros, los beneficios y alternativas de tratamiento según se explico anteriormente, que todas sus preguntas relativas a mi área de experiencia han sido respondidas y que ha otorgado su consentimiento.');
		//$pdf->WriteHTML($html);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html2),0);
		//$pdf->MultiCell(0,7,$pdf->WriteHTML($html3),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html4),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html5),0);
		
		//Termina hoja1
		//3ra Pagina
		$pdf->Ln(15);
		$pdf->Cell(0,7,'          _______________________________________                    __________________________________________',0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                '.$nombre_pac.'                                        '.$compa_pac),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                     Nombre y firma del paciente                                            Nombre y firma del padre/madre/tutor u otra persona'),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                                                                                                                                        legalmente responsable'),0,1,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,5,'__________________________________________________________________________________________________________',0,1,'C');
		$pdf->Cell(0,5,utf8_decode('Motivo por el que el paciente no puede firmar.'),0,1,'C');
		$pdf->Ln();
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html6),0);
		//$pdf->Ln();
		
		//$pdf->Ln(10);
		if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(0,5,'',0,0,'L',$pdf->Image($firma_Med,20,null,50,30));
			$pdf->Ln(1);
		} else {
		 	$pdf->Ln(10);
		}
		$pdf->Cell(0,7,'     _______________________________________                                     ',0,1,'L');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,5,'            Dr.(a): '.utf8_decode($nombre_med).'                    ',0,1,'L');
		} else {
			$pdf->Cell(0,5,'            Dr.(a): '.$rowC1['nombreMedicoTratante'].'                    ',0,1,'L');
		}
		$pdf->Cell(0,5,utf8_decode('                    Cédula Profesional: ').$cedula_med,0,1,'L');
		//$pdf->Cell(0,7,utf8_decode('               Especialidad: '.$especialidad_med),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('Nombre, Firma y Cédula Profesional del Médico Anestesiólogo'),0,1,'L');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}

/********************************************************************************************************************************************************/
	//Esta parte es la que Genera el PDF CONSENTIMIENTO INFORMADO TRANSFUSION
	if($_GET['name'] == 'consentimientoTrans') {
		
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
		$queryCuadro1 = "SELECT * FROM consentimientotransfurg WHERE numeroExpediente = '$expediente' AND folio= '$folio' AND estatus=1 ORDER BY fecha DESC";
		$result0 = mysqli_query($conexionMedico, $queryCuadro1);
		$rowC1 = mysqli_fetch_array($result0);
		
		$horaN = new DateTime($rowC1['fechaGuardado']);
		$horaIC = $horaN->format('H:i');
		$fecha = strtotime($rowC1['fechaGuardado']);
		$fechaFin = date('d/m/Y',$fecha);
		
		$fecha1 = strtotime($rowC1['fechaQx']);
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
		
		$months = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO',
				'JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
		$fecha2 = strtotime($rowC1['fecha']);
		$d1 = date('d',$fecha2);
		$m1 = date('m',$fecha2);
		$mi1 = intval($m1);
		$a1 = date('Y',$fecha2);
		
		//Declaramos la cabecera
		$cabecera = array(utf8_decode('                                                                                 CUERNAVACA, MORELOS A '.$d1.' DE '.$months[$mi1-1].' DEL '.$a1),"EXPEDIENTE: ".$rowC1['numeroExpediente']."   FOLIO: ".$rowC1['folio'],"NOMBRE: ".$nombre_pac,"FECHA DE NACIMIENTO: ".$fecha_nac_pac."          EDAD: ".utf8_decode($annios)."          SEXO: ".$sexo_pac,utf8_decode("NOMBRE DEL PADRE/MADRE O TUTOR: ".$compa_pac ),"NOMBRE DE OTRA PERSONA LEGALMENTE RESPONSABLE : ".$compa_pac);
		
		$pdf = new PDF();
		$pdf->setCabeza($cabecera);
		$pdf->setEspacio("TRUE");
		#$pdf->Header('1');
		$pdf->AddPage('P', 'Letter'); //Vertical, Carta
		//$pdf->SetFont('Arial','B',6); //Arial, negrita, 12 puntos
		
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
		$pdf->SetFillColor(200,200,200);
		$pdf->setTitulo('CARTA DE CONSENTIMIENTO INFORMADO PARA TRANSFUSIÓN');
		$pdf->SetXY(60,12);
		$pdf->Cell(145,7,utf8_decode('CARTA DE CONSENTIMIENTO INFORMADO PARA TRANSFUSIÓN'),1, 1 , 'C',true);

		$pdf->SetFont('Arial','',9);
		//$pdf->Rect(10,70,200,22,'');
		$pdf->SetY(60);
		
		//$pdf->Cell(0,7,'SERVICIO: '.$rowC1['servicio'],1, 1 , 'L',true);
		//$pdf->Cell(0,7,utf8_decode('FECHA DE LA CIRUGÍA'),1, 1 , 'C',true);
		//$pdf->MultiCell(0,7,utf8_decode('Día: '.$d1.'   Mes: '.$months[$mi1-1].'   Año: '.$a1),0, 'L');
		#Diagnost
		//$pdf->Ln();
		//$pdf->Cell(0,7,utf8_decode('DIAGNÓSTICO'),1, 1 ,'C',true);
		$productos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['productos'] != NULL || $rowC1['productos'] != ''){
			$productos = $rowC1['productos'];
		}
		
		$riesgos = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['riesgos'] != NULL || $rowC1['riesgos'] != ''){
			$riesgos = $rowC1['riesgos'];
		}
		
		$beneficios = '_____________________________________________________________________________________________________________';
		if($rowC1['beneficios'] != NULL || $rowC1['beneficios'] != ''){
			$beneficios = $rowC1['beneficios'];
		}
		
		$alternativas = '__________________________________________________________________________________________________________________________________________________________________________________________________________________________';
		if($rowC1['alternativas'] != NULL || $rowC1['alternativas'] != ''){
			$alternativas = $rowC1['alternativas'];
		}
		
		$html =utf8_decode('Usted como paciente, tiene derecho a estar informado sobre su condición, del o los procedimientos médicos quirúrgicos y de diagnóstico recomendados, así como los riesgos y peligros que conllevan, a fin  de  poder tomar una decisión informada  de  someterse  o  no  a  los  procedimientos. El objeto  de  esta carta de consentimiento no  es asustarle ni alarmarle, simplemente, es  con el propósito de que usted esté mejor informado  para poder otorgar o negar su consentimiento para el  o  los procedimientos. Este consentimiento cumple  con  los requisitos establecidos en  la Ley General de Salud, sus reglamentos y normas oficiales, así como los  de  la Ley de Salud del Estado de  Morelos. Con fundamento en el artículo 4to. De la Constitución Política de  los Estados Unidos Mexicanos, la <b>Norma  Oficial  Mexicana  NOM-004-SSA3-2012 del Expediente  Clínico.  Artículos  42,  43,  53 , 54,  55,  57  de  la Ley General  de  Salud;  Artículos  29,  46,  76, 78,  80, 81  y  82  del  Reglamento de la Ley General de Salud en materia de Prestación de Atención Médica. Artículos 42, 43, 54 de la Ley de Salud del Estado de Morelos.</b>');
		
		$html2 =utf8_decode('<b>SOLICITUD VOLUNTARIA PARA TRATAMIENTO:</b> Yo (nosotros) solicito voluntariamente al Dr.(a): <b>'.trim($nombre_med).'</b> Con Cedula Profesional: <b>'.trim($cedula_med).'</b> como mi médico tratante, todos los asociados, asistentes técnicos y demás proveedores de cuidados de la salud que se consideren necesarios, para tratar mi padecimiento actual que es: <u>').$rowC1['diagnostico'].utf8_decode('</u>, el cual se me ha explicado a satisfacción.');
		
		$html3 =utf8_decode('Yo (nosotros) entiendo que la transfusión de componentes sanguíneos es una herramienta terapéutica que puede utilizar el Médico con el objeto de colaborar  en  el tratamiento  y  la  recuperación de  la  salud, la  cual consiste en  la administración por vía endovenosa  de componentes de la sangre, estos pueden ser: Glóbulos Rojos; Plaquetas, Plasma Fresco Congelado y Crioprecipitados.');
		
		$html4 =utf8_decode('Yo (nosotros) Otorgo mí consentimiento  y  autorización  de  forma voluntaria para la utilización de  el/los  componentes(s) sanguíneo(s) solicitado que es(son): ').$rowC1['componentesSang'];
		
		$html5 =utf8_decode('Yo (nosotros) entiendo que, si bien las transfusiones de sangre pueden implicar riesgos, en la actualidad, el suministro de sangre es más seguro  que  nunca.  Me  ha  sido  explicado  el  objetivo que  la  transfusión conlleva  que  es:  La  reposición  de  aquellos componentes sanguíneos  que  son  deficitarios  en  cantidad  o  calidad para el correcto funcionamiento orgánico. Comprendo que los beneficios de la transfusión, conforme a las explicaciones que me dio el médico, son aliviar o mejorar mi estado de salud.');
		
		$html6 =utf8_decode('<b>ACEPTO, CONSIENTO Y AUTORIZO</b> la(s) transfusión(es) de los productos que a continuación se especifican: ').$productos;
		
		$html7 =utf8_decode('Yo (nosotros) declaro que mí médico  me  ha  explicado  que  existe la posibilidad de usar tratamientos alternativos, si corresponde, tales como: Soluciones cristaloides, oxígeno en concentración alta, eritropoyetina, terapia con hierro, autotransfusión, expansores plasmáticos, suplementos dietarios, etc.<br><br><b>INFORMACIÓN PERSONALIZADA</b> (En base a edad, peso y antecedentes)<br><br><b>ALTERNATIVAS</b>: '.$alternativas);
		
		$html8 =utf8_decode('<b>RIESGOS</b><br>Asimismo, entiendo que se pueden presentar los siguientes riesgos y peligros relacionados con la transfusión de sangre  y/o  derivados y que  los  riesgos pueden suceder  en  forma inmediata  o  con posterioridad: (1) moretones  o hinchazón en el sitio en donde se insertó la aguja en la vena; (11) fiebre; (111) reacción alérgica; (IV) reacción a la transfusión, que puede incluir insuficiencia renal, anemia o incluso la muerte; (V) Insuficiencia cardiaca; (VI) hepatitis; (VII) transmisión de SIDA (Síndrome de inmunodeficiencia adquirida); (VIII) VIH; y (IX) enfermedades transmisibles.<br><br><b>BENEFICIOS: </b>'.$beneficios);
		
		$html9 =utf8_decode('<b>OPORTUNIDAD PARA  HACER PREGUNTAS:</b>  Yo  (nosotros)  tuve  la  oportunidad  de  hacer  preguntas  acerca  de  mi  condición  y diagnóstico, sobre el tratamiento con el componente sanguíneo solicitado, y los  riesgos y peligros que el tratamiento conlleva, así como los riesgos  de  no  seguir  el  tratamiento como puede  ser: agravamiento  del  estado actual, estado de choque o incluso la muerte. Mis preguntas fueron contestadas satisfactoriamente.  Considero que cuento con  la información suficiente para otorgar este consentimiento informado.<br>Yo  (nosotros)  declaro  que  se  me  ha  explicado  a  mi  entera satisfacción el o los procedimientos a realizar. Y en mi voluntad y pleno consentimiento  de  la  causa, consiento la transfusión de que se trate. Autorizo al personal de salud para la atención de contingencias y urgencias derivadas del acto autorizado, atendiendo al principio de libertad prescriptiva.<br><br><b>En mi presencia han sido llenados o cancelados todos los espacios en blanco que se presenten en este documento</b>');
		
		$html10 =utf8_decode('<b>Declaración médica:</b> Yo certifico que el  paciente/padre/madre/tutor  u otra persona legalmente responsable han sido informados sobre los riesgos y peligros, los beneficios y alternativas de tratamiento según se explico anteriormente, que todas sus preguntas relativas a mi área de experiencia han sido respondidas y que ha otorgado su consentimiento.');
		//$pdf->WriteHTML($html);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html2),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html3),0,'L');
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html4),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html5),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html6),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html7),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html8),0);
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html9),0);
		
		//Termina hoja1
		//3ra Pagina
		$pdf->Ln(10);
		$pdf->Cell(0,7,'          _______________________________________                    __________________________________________',0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                '.$nombre_pac.'                                        '.$compa_pac),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                     Nombre y firma del paciente                                            Nombre y firma del padre/madre/tutor u otra persona'),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('                                                                                                                                        legalmente responsable'),0,1,'L');
		$pdf->Ln(5);
		$pdf->Cell(0,5,'__________________________________________________________________________________________________________',0,1,'C');
		$pdf->Cell(0,5,utf8_decode('Motivo por el que el paciente no puede firmar.'),0,1,'C');
		$pdf->Ln();
		$pdf->MultiCell(0,7,$pdf->WriteHTML($html10),0);
		//$pdf->Ln();
		
		//$pdf->Ln(10);
		if($firma_Med != NULL && $firma_Med != ''){
			$pdf->Cell(0,5,'',0,0,'L',$pdf->Image($firma_Med,20,null,50,30));
			$pdf->Ln(1);
		} else {
		 	$pdf->Ln(10);
		}
		$pdf->Cell(0,7,'     _______________________________________                                     ',0,1,'L');
		if($nombre_med != NULL || $nombre_med != ''){
			$pdf->Cell(0,5,'            Dr.(a): '.utf8_decode($nombre_med).'                    ',0,1,'L');
		} else {
			$pdf->Cell(0,5,'            Dr.(a): '.$rowC1['nombreMedicoTratante'].'                    ',0,1,'L');
		}
		$pdf->Cell(0,5,utf8_decode('                    Cédula Profesional: ').$cedula_med,0,1,'L');
		//$pdf->Cell(0,7,utf8_decode('               Especialidad: '.$especialidad_med),0,1,'L');
		$pdf->Cell(0,5,utf8_decode('Nombre, Firma y Cédula Profesional del Médico Anestesiólogo'),0,1,'L');
		//$pdf->Footer('2');

		$pdf->Output(); //Salida al navegador del pdf
	}
?>