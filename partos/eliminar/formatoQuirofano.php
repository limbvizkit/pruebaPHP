<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Ver_Modificar</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous" />
<!-- en html5 no necesitas indicar el cierre de la etiqueta -->
</head>
<body background="../../img/logoFondodeaguaHenrinuevo.jpg">

<?php 
	require_once('conexion.php');
	require_once '../../rtf/lib/PHPRtfLite.php';
	require __DIR__ . '/creaPDF/vendor/autoload.php';
	use \CloudConvert\Api;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	
	session_name($rol);
	session_start();
	
	#echo 'ROL: '.$rol;
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: index.html");
	}
	
	if (isset($_GET['id']))
	{
		$id=$_GET['id'];
	}
	
	
	// registers PHPRtfLite autoloader (spl)
	PHPRtfLite::registerAutoloader();
		
	// rtf document instance
	$rtf = new PHPRtfLite();
		
	// add section
	$sect = $rtf->addSection();
		
	//Fuentes y colores de fuente
	$font = new PHPRtfLite_Font(18, 'Calibri');
	$fontAW = new PHPRtfLite_Font(10, 'Arial','#FFFFFF');
	$fontAB = new PHPRtfLite_Font(10, 'Arial','#08088A');
	$fontA = new PHPRtfLite_Font(10, 'Arial');
	
	$border = new PHPRtfLite_Border(
	    $rtf,                                       // PHPRtfLite instance
	    new PHPRtfLite_Border_Format(1, '#000000'), // left border: 1pt, green color
	    new PHPRtfLite_Border_Format(1, '#000000'), // top border: 1pt, yellow color
	    new PHPRtfLite_Border_Format(1, '#000000'), // right border: 1pt, red color
	    new PHPRtfLite_Border_Format(1, '#000000')  // bottom border: 1pt, blue color
	);
	
	//TXT Align Right
	$parFormatRight = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
	//TXT Align Center
	$parFormatCenter = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
	//TXT normal
	$parFormat = new PHPRtfLite_ParFormat();
	$parFormat->setBorder($border);

	// add header
	$header = $sect->addHeader();
	
	// add table
	$table = $header->addTable();
	$table->addRows(1);
	$table->addColumnsList(array(2,2,2,2,2,2,2));
	
	//Logo Henri Nuevo
	$cell_1 = $table->getCell(1, 1);
	$image_1 = $cell_1->addImage('../../img/logo_1.png');
	// image width 2cm and height 2cm
	$image_1->setWidth(2);
	$image_1->setHeight(2);	
	
	// add table_2
	/*$table_2 = $sect->addTable();
	$table_2->addRows(1);
	#ancho de las columnas
	//$table_2->addColumnsList(array(1,1.5,2,2,2,1.5,4,3));
	$table_2->addColumnsList(array(2,3,2,5,3));

	
	#Bordes de la tabla
	$border = new PHPRtfLite_Border(
	    $rtf,                                       // PHPRtfLite instance
	    new PHPRtfLite_Border_Format(1, '#000000'), // left border: 1pt, green color
	    new PHPRtfLite_Border_Format(1, '#000000'), // top border: 1pt, yellow color
	    new PHPRtfLite_Border_Format(1, '#000000'), // right border: 1pt, red color
	    new PHPRtfLite_Border_Format(1, '#000000')  // bottom border: 1pt, blue color
	);
	#Aplicamos los bordes a las celdas
	$table_2->setBorderForCellRange($border, 1,1, 1,2);
	$table_2->setBorderForCellRange($border, 1,3, 1,4);
	$table_2->setBorderForCellRange($border, 1,5);
	#$table_2->setBorderForCellRange($border, 1,7, 1,8);
	
	#Aplicamos color de fondo a la celdas de la 1ra fila(Titulos)
	$table_2->setBackgroundForCellRange('#08088A', 1, 1, 1, 2);
	$table_2->setBackgroundForCellRange('#08088A', 1, 3, 1, 4);
	$table_2->setBackgroundForCellRange('#08088A', 1, 5);
	#$table_2->setBackgroundForCellRange('#08088A', 1, 7, 1, 8);
	
	#Colocamos los valores en las celdas de la 1ra fila(Titulos)
	#$table_2->writeToCell(1, 1, '<b> Num. </b>', $fontAW, $parFormatCenter);
	#$table_2->writeToCell(1, 2, '<b> FECHA </b>', $fontAW, $parFormatCenter);
	$table_2->writeToCell(1, 1, '<b> HABITACIÓN </b>', $fontAW , $parFormatCenter);
	#$table_2->writeToCell(1, 4, '<b> ÁREA REPORTA </b>', $fontAW, $parFormatCenter);
	$table_2->writeToCell(1, 2, '<b> ÁREA RESPONSABLE </b>', $fontAW, $parFormatCenter);
	$table_2->writeToCell(1, 3, '<b> RESUELTO </b>', $fontAW, $parFormatCenter);
	$table_2->writeToCell(1, 4, '<b> REPORTE </b>', $fontAW ,$parFormatCenter);
	$table_2->writeToCell(1, 5, '<b> SOLUCIÓN </b>', $fontAW ,$parFormatCenter);*/
	
	//Hacemos la consulta para llenar la tabla
	/*$queryInciDia0 = "SELECT fechaAlta, a1.nombreArea, a2.nombreArea, reporte, solucion, resuelto, fechaSolucion, h.numeroHabitacion, h.tipoHabitacion, i.idIncidencia
			FROM incidencias as i
			LEFT JOIN areas as a1 ON i.idAreaReporta = a1.idArea
			LEFT JOIN areas as a2 ON i.idAreaResponsable = a2.idArea
			LEFT JOIN habitaciones as h ON i.idHabitacion = h.idHabitacion
			WHERE ((idAreaReporta = '$areaFin' AND (idAreaResponsable != '$areaFin' OR ISNULL(idAreaResponsable))) OR $areaFin = '0') 
			AND (i.estatus != 3 || fechaAlta BETWEEN '$fechaIni 00:00:00' AND '$fechaFin 23:59:59')
			ORDER BY h.numeroHabitacion";
		$idInciDia0 = mysqli_query($conexion, $queryInciDia0) or die (mysqli_error($conexion));*/
		
		$query="SELECT * FROM datosnuevosparto WHERE id='$id'";

		$resultado=$mysqli->query($query);
			
		while($row = mysqli_fetch_array($resultado)){
			//Agregamos una nueva fila
			//$table_2->addRows(1);
			
			if($row['fecha'] != NULL){
				$date1 = date_create_from_format('Y-m-d',$row['fecha'])->format('d/m/Y');
			} else {
				$date1 = NULL;
			}
			if($row['hora'] != NULL){
				$date2 = date_create_from_format('H:i:s',$row['hora'])->format('H:i:s');
			} else {
				$date2 = NULL;
			}
			
			if($row['sala'] == 1){
				$sala = "SALA 1";
			} else 
			if($row['sala'] == 2){
				$sala = "SALA 2";
			} else 
			if($row['sala'] == 3){
				$sala = "SALA 3";
			} else 
			if($row['sala'] == 4){
				$sala = "SALA DE EXPULSIÓN";
			}
			
			if($row['estatusCirugia'] == 1){
				$estatus = "CONFIRMADA";
			} else 
			if($row['estatusCirugia'] == 2){
				$estatus = "NO CONFIRMADA";
			} else 
			if($row['estatusCirugia'] == 3){
				$estatus = "REALIZADA/CONCLUIDA";
			} else 
			if($row['estatusCirugia'] == 4){
				$estatus = "CANCELADA";
			} 
			
			// write text
			$sect->writeText('                      HOJA DE REGISTRO DE PARTO', $font);
			$sect->writeText('<br /><br />');
			$sect->writeText('FECHA DE PARTO: '.$date1.'                       HORA DE PARTO: '.$date2.' hrs.', $fontA);
			$sect->writeText('<br /><br />');
			$sect->writeText('<strong>NÚMERO DE CONTROL:</strong>  '.$row['id'], $fontA, $parFormat);
			$sect->writeText('<br />');
			$sect->writeText('<strong>ESTATUS DE CIRUGÍA:</strong>  '.$estatus, $fontA, $parFormat);
			$sect->writeText('<br />');
			if($row['fechaOriginal'] != NULL && $row['fechaOriginal'] != ''){
				$dateDifer = date_create_from_format('Y-m-d',$row['fechaOriginal'])->format('d/m/Y');
				$sect->writeText('<strong>DIFERIDA DE LA FECHA:</strong>  '.$dateDifer, $fontA, $parFormat);
				$sect->writeText('<br />');
			}
			$sect->writeText('<strong>SALA DE CIRUGÍA:</strong>  '.$sala, $fontA, $parFormat);
			//$sect->writeText('<br />');
			
			$sect->writeText('<strong>TIPO DE CIRUGÍA:</strong>  '.$row['tipoDeCirugia'], $fontA, $parFormat);
			//$sect->writeText('<br />');

			$sect->writeText('<strong>COSTEADOR:</strong>  '.$row['costeador'], $fontA, $parFormat);
			//$sect->writeText('<br />');
			
			$sect->writeText('<strong>TIEMPO APROXIMADO DE CIRUGÍA:</strong>  '.$row['tiempoHr'].' Hora(s)  '.$row['tiempoMin'].' Minuto(s)', $fontA, $parFormat);
			//$sect->writeText('<br />');

			$sect->writeText('<strong>ENF. QUE PROGRAMA CIRUGÍA:</strong>  '.utf8_encode($row['enfermera']), $fontA, $parFormat);
			$sect->writeText('<br />');
			
			$sect->writeText('<strong>NOMBRE DEL PACIENTE:</strong>  '.utf8_encode($row['nombrePaciente']), $fontA, $parFormat);
			//$sect->writeText('<br />');
			if($row['edad'] > 0 && $row['edad'] != ''){
				$sect->writeText('<strong>EDAD DEL PACIENTE:</strong>  '.$row['edad'].' años', $fontA, $parFormat);
			}
			$sect->writeText('<br />');
			$sect->writeText('<strong>DIAGNÓSTICO PREOPERATORIO:</strong>  '.utf8_encode($row['diagnostico']), $fontA, $parFormat);
			//$sect->writeText('<br />');
			
			$sect->writeText('<strong>CIRUGÍA A REALIZAR:</strong>  '.utf8_encode($row['cirugia']), $fontA, $parFormat);
			$sect->writeText('<br />');
			
			if($row['materialEsp'] != NULL && $row['materialEsp'] != ''){
				$sect->writeText('<strong>INSTRUMENTAL/MATERIAL ESPECIAL:</strong>', $fontA, $parFormat);
				$sect->writeText('<br />');
				
				$material = json_decode(utf8_encode($row['materialEsp']),true);
				$longitud = count($material);
				$cantidad = json_decode($row['cantidadMaterialEsp'],true);
				
				for($i=0; $i<$longitud; $i++){
					$sect->writeText(' + '.$material[$i]["idInst"].' = '.$cantidad[$i]["cantidad"], $fontA, $parFormat);
				}
				$sect->writeText('<br />');
			}
			
			if($row['equipo'] != NULL && $row['equipo'] != ''){
				$sect->writeText('<strong>EQUIPO:</strong>  '.utf8_encode($row['equipo']), $fontA, $parFormat);
				$sect->writeText('<br />');
			}
			$sect->writeText('<strong>DESCORCHE:</strong>  '.utf8_encode($row['descorche']), $fontA, $parFormat);
			//$sect->writeText('<br />');
			if($row['descorcheTxt'] != NULL && $row['descorcheTxt'] != ''){
				$sect->writeText('<strong>DESCORCHE SOBRE:</strong>  '.utf8_encode($row['descorcheTxt']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['autorizo'] != NULL && $row['autorizo'] != ''){
				$sect->writeText('<strong>DESCORCHE AUTORIZADO POR:</strong>  '.utf8_encode($row['autorizo']), $fontA, $parFormat);
				$sect->writeText('<br />');
			}
			if($row['imagen'] != NULL && $row['imagen'] != ''){
				$sect->writeText('<strong>IMAGENOLOGÍA:</strong>  '.utf8_encode($row['imagen']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['sangre'] != NULL && $row['sangre'] != ''){
				$sect->writeText('<strong>RESERVA DE SANGRE:</strong>  '.utf8_encode($row['sangre']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			$sect->writeText('<strong>MUESTRA DE PATOLOGÍAS:</strong>  '.utf8_encode($row['patologias']), $fontA, $parFormat);
			//$sect->writeText('<br />');
			if($row['transPosOperatorio'] != NULL && $row['transPosOperatorio'] != ''){
				$sect->writeText('<strong>TOMA DE PATOLOGÍAS:</strong>  '.utf8_encode($row['transPosOperatorio']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['patologo'] != NULL && $row['patologo'] != ''){
				$sect->writeText('<strong>PATÓLOGO:</strong>  '.utf8_encode($row['patologo']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['tamano'] != NULL && $row['tamano'] != ''){
				$sect->writeText('<strong>TAMAÑO DE LA MUESTRA:</strong>  '.utf8_encode($row['tamano']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			$sect->writeText('<br />');
			$sect->writeText('<strong>NOMBRE DEL CIRUJANO:</strong>  '.utf8_encode($row['cirujano']), $fontA, $parFormat);
			//$sect->writeText('<br />');
			
			if($row['telCirujano'] != NULL && $row['telCirujano'] != ''){
				$sect->writeText('<strong>TELÉFONO DEL CIRUJANO:</strong>  '.$row['telCirujano'], $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['emailCirujano'] != NULL && $row['emailCirujano'] != ''){
				$sect->writeText('<strong>E-MAIL DEL CIRUJANO:</strong>  '.utf8_encode($row['emailCirujano']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['instrumentista'] != NULL && $row['instrumentista'] != ''){
				$sect->writeText('<strong>NOMBRE DEL INSTRUMENTISTA:</strong>  '.utf8_encode($row['instrumentista']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['anestesiologo'] != NULL && $row['anestesiologo'] != ''){
				$sect->writeText('<strong>NOMBRE DEL ANESTESIÓLOGO:</strong>  '.utf8_encode($row['anestesiologo']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['ayudante'] != NULL && $row['ayudante'] != ''){
				$sect->writeText('<strong>NOMBRE DEL AYUDANTE:</strong>  '.utf8_encode($row['ayudante']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['pediatra'] != NULL && $row['pediatra'] != ''){
				$sect->writeText('<strong>NOMBRE DEL PEDIATRA:</strong>  '.utf8_encode($row['pediatra']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['nombrePrograma'] != NULL && $row['nombrePrograma'] != ''){
				$sect->writeText('<strong>NOMBRE DE QUIEN PROGRAMA CIRUGÍA:</strong>  '.utf8_encode($row['nombrePrograma']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['telPrograma'] != NULL && $row['telPrograma'] != ''){
				$sect->writeText('<strong>TELÉFONO DE QUIEN PROGRAMA CIRUGÍA:</strong>  '.$row['telPrograma'], $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
			if($row['correoPrograma'] != NULL && $row['correoPrograma'] != ''){
				$sect->writeText('<strong>CORREO DE QUIEN PROGRAMA CIRUGÍA:</strong>  '.utf8_encode($row['correoPrograma']), $fontA, $parFormat);
				//$sect->writeText('<br />');
			}
						
			#Le ponemos bordes a las celdas de la nueva fila
			/*$table_2->setBorderForCellRange($border, $col,1, $col,2);
			$table_2->setBorderForCellRange($border, $col,3, $col,4);
			$table_2->setBorderForCellRange($border, $col,5);
			#$table_2->setBorderForCellRange($border, $col,7, $col,8);
			
			#Colocamos los valores en las celdas de la nueva fila
			#$table_2->writeToCell($col, 1, $d++, $fontA, $parFormatCenter);
			#$table_2->writeToCell($col, 2, $date1, $fontA, $parFormatCenter);
			$table_2->writeToCell($col, 1, $row0[7], $fontA, $parFormatCenter);
			#$table_2->writeToCell($col, 4, utf8_encode($row[1]), $fontAB, $parFormatCenter);
			$table_2->writeToCell($col, 2, utf8_encode($row0[2]), $fontAB, $parFormatCenter);
			$table_2->writeToCell($col, 3, utf8_encode($row0[5]), $fontA, $parFormatCenter);
			$table_2->writeToCell($col, 4, utf8_encode($row0[3]), $fontAB, $parFormatCenter);
			$table_2->writeToCell($col, 5, utf8_encode($row0[4]), $fontA, $parFormatCenter);
			$col++;*/
		}
		
	// write text
	//$sect->writeText('<br /><br /><br />');
	/*$sect->writeText('_______________                  _______________________              ______________________
'.$nombreUsr.'                      T.E. José Alfredo Salgado M.             Gerardo Jaimes Vázquez                                             
Atención al Cliente                       Mantenimiento                     Servicios Generales                       
Trabajo reportado                  Enterado para realizar trabajo           Enterado para realizar trabajo',
 $font, new PHPRtfLite_ParFormat());*/
	
	// guardamos el documento rtf como quirofano.rtf (Si ya existe lo sobreescribe)
	$rtf->save('parto.rtf');
	
	//Creamos el PDF del RTF
	$api = new Api("F1mCjAZMl83tAfLpzoYXGbShr52hLSocTEm3c4wDgnCBKvQ2o_beWj5nu1_w4JAyeVw-cnbVCm6-W2htVHPwtg");
 
	$api->convert([
		"inputformat" => "rtf",
		"outputformat" => "pdf",
		"input" => "upload",
		"file" => fopen('C:\xampp\htdocs\conectaSQLSRV\partos\eliminar\parto.rtf', 'r'),
	])
	->wait()
	->download('parto.pdf');
	
	////////////////////////////////////////////////Aqui creamos el PDF para enviar al DOC////////////////////////////////////////////////////////
	// Registers PHPRtfLite autoloader (spl)
	//PHPRtfLite::registerAutoloader();
		
	// rtf document instance
	$rtf1 = new PHPRtfLite();
		
	// Add section
	$sect1 = $rtf1->addSection();
		
	//Fuentes y colores de fuente
	$font1 = new PHPRtfLite_Font(18, 'Calibri');
	$fontAW1 = new PHPRtfLite_Font(10, 'Arial','#FFFFFF');
	$fontAB1 = new PHPRtfLite_Font(10, 'Arial','#08088A');
	$fontA1 = new PHPRtfLite_Font(10, 'Arial');
	
	$border1 = new PHPRtfLite_Border(
	    $rtf1,                                       // PHPRtfLite instance
	    new PHPRtfLite_Border_Format(1, '#000000'), // left border: 1pt, green color
	    new PHPRtfLite_Border_Format(1, '#000000'), // top border: 1pt, yellow color
	    new PHPRtfLite_Border_Format(1, '#000000'), // right border: 1pt, red color
	    new PHPRtfLite_Border_Format(1, '#000000')  // bottom border: 1pt, blue color
	);
	
	//TXT Align Right
	$parFormatRight1 = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
	//TXT Align Center
	$parFormatCenter1 = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
	//TXT normal
	$parFormat1 = new PHPRtfLite_ParFormat();
	$parFormat1->setBorder($border1);

	// add header
	$header1 = $sect1->addHeader();
	
	// add table
	$table1 = $header1->addTable();
	$table1->addRows(1);
	$table1->addColumnsList(array(2,2,2,2,2,2,2));
	
	//Logo Henri Nuevo
	$cell_11 = $table1->getCell(1, 1);
	$image_11 = $cell_11->addImage('../../img/logo_1.png');
	// image width 2cm and height 2cm
	$image_11->setWidth(2);
	$image_11->setHeight(2);	
		
	$query1="SELECT * FROM datosnuevosparto WHERE id='$id'";

	$resultado1=$mysqli->query($query1);

	while($row1 = mysqli_fetch_array($resultado1)){
		//Agregamos una nueva fila
		//$table_2->addRows(1);

		if($row1['fecha'] != NULL){
			$date11 = date_create_from_format('Y-m-d',$row1['fecha'])->format('d/m/Y');
		} else {
			$date11 = NULL;
		}
		if($row1['hora'] != NULL){
			$date21 = date_create_from_format('H:i:s',$row1['hora'])->format('H:i:s');
		} else {
			$date21 = NULL;
		}

		if($row1['sala'] == 1){
			$sala1 = "SALA 1";
		} else 
		if($row1['sala'] == 2){
			$sala1 = "SALA 2";
		} else 
		if($row1['sala'] == 3){
			$sala1 = "SALA 3";
		} else 
		if($row1['sala'] == 4){
			$sala1 = "SALA DE EXPULSIÓN";
		}

		if($row1['estatusCirugia'] == 1){
			$estatus1 = "CONFIRMADA";
		} else 
		if($row1['estatusCirugia'] == 2){
			$estatus1 = "NO CONFIRMADA";
		} else 
		if($row1['estatusCirugia'] == 3){
			$estatus1 = "REALIZADA/CONCLUIDA";
		} else 
		if($row1['estatusCirugia'] == 4){
			$estatus1 = "CANCELADA";
		} 

		// write text
		$sect1->writeText('                      HOJA DE REGISTRO DE PARTO', $font1);
		$sect1->writeText('<br /><br />');
		$sect1->writeText('FECHA DE PARTO: '.$date11.'                       HORA DE CIRUGÍA: '.$date21.' hrs.', $fontA1);
		$sect1->writeText('<br /><br />');
		$sect1->writeText('<strong>NÚMERO DE CONTROL:</strong>  '.$row1['id'], $fontA1, $parFormat1);
		$sect1->writeText('<br />');
		$sect1->writeText('<strong>ESTATUS DE CIRUGÍA:</strong>  '.$estatus1, $fontA1, $parFormat1);
		$sect1->writeText('<br />');
		if($row1['fechaOriginal'] != NULL && $row1['fechaOriginal'] != ''){
				$dateDifer1 = date_create_from_format('Y-m-d',$row1['fechaOriginal'])->format('d/m/Y');
				$sect1->writeText('<strong>DIFERIDA DE LA FECHA:</strong>  '.$dateDifer1, $fontA1, $parFormat1);
				$sect1->writeText('<br />');
			}
		$sect1->writeText('<strong>ENF. QUE PROGRAMA CIRUGÍA:</strong>  '.utf8_encode($row1['enfermera']), $fontA1, $parFormat1);
		$sect1->writeText('<br />');
		$sect1->writeText('<strong>NOMBRE DEL PACIENTE:</strong>  '.utf8_encode($row1['nombrePaciente']), $fontA1, $parFormat1);
		
		if($row['edad'] > 0 && $row['edad'] != ''){
			$sect1->writeText('<br />');
			$sect1->writeText('<strong>EDAD DEL PACIENTE:</strong>  '.$row1['edad'].' años', $fontA1, $parFormat1);
		}
		$sect1->writeText('<br />');
		$sect1->writeText('<strong>DIAGNÓSTICO PREOPERATORIO:</strong>  '.utf8_encode($row1['diagnostico']), $fontA1, $parFormat1);
		$sect1->writeText('<br />');
		$sect1->writeText('<strong>CIRUGÍA A REALIZAR:</strong>  '.utf8_encode($row1['cirugia']), $fontA1, $parFormat1);
		$sect1->writeText('<br />');
		if($row1['materialEsp'] != NULL && $row1['materialEsp'] != ''){
			$sect1->writeText('<strong>INSTRUMENTAL/MATERIAL ESPECIAL:</strong>', $fontA1, $parFormat1);
			$sect1->writeText('<br />');

			$material1 = json_decode(utf8_encode($row1['materialEsp']),true);
			$longitud1 = count($material1);
			$cantidad1 = json_decode($row1['cantidadMaterialEsp'],true);

			for($i=0; $i<$longitud; $i++){
				$sect1->writeText(' + '.$material1[$i]["idInst"].' = '.$cantidad1[$i]["cantidad"], $fontA1, $parFormat1);
			}
			$sect1->writeText('<br />');
		}

		if($row1['equipo'] != NULL && $row1['equipo'] != ''){
			$sect1->writeText('<strong>EQUIPO:</strong>  '.utf8_encode($row1['equipo']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}
		$sect1->writeText('<strong>DESCORCHE:</strong>  '.utf8_encode($row1['descorche']), $fontA1, $parFormat1);
		$sect1->writeText('<br />');
		if($row1['descorcheTxt'] != NULL && $row1['descorcheTxt'] != ''){
			$sect1->writeText('<strong>DESCORCHE SOBRE:</strong>  '.utf8_encode($row1['descorcheTxt']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}
		/*if($row1['autorizo'] != NULL && $row1['autorizo'] != ''){
			$sect1->writeText('<strong>DESCORCHE AUTORIZADO POR:</strong>  '.utf8_encode($row1['autorizo']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}*/
		if($row1['imagen'] != NULL && $row1['imagen'] != ''){
			$sect1->writeText('<strong>IMAGENOLOGÍA:</strong>  '.utf8_encode($row1['imagen']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}
		if($row1['sangre'] != NULL && $row1['sangre'] != ''){
			$sect1->writeText('<strong>RESERVA DE SANGRE:</strong>  '.utf8_encode($row1['sangre']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}
		/*$sect->writeText('<strong>MUESTRA DE PATOLOGÍAS:</strong>  '.utf8_encode($row['patologias']), $fontA, $parFormat);
		//$sect->writeText('<br />');
		if($row['transPosOperatorio'] != NULL && $row['transPosOperatorio'] != ''){
			$sect->writeText('<strong>TOMA DE PATOLOGÍAS:</strong>  '.utf8_encode($row['transPosOperatorio']), $fontA, $parFormat);
			//$sect->writeText('<br />');
		}
		if($row['patologo'] != NULL && $row['patologo'] != ''){
			$sect->writeText('<strong>PATÓLOGO:</strong>  '.utf8_encode($row['patologo']), $fontA, $parFormat);
			//$sect->writeText('<br />');
		}
		if($row['tamano'] != NULL && $row['tamano'] != ''){
			$sect->writeText('<strong>TAMAÑO DE LA MUESTRA:</strong>  '.utf8_encode($row['tamano']), $fontA, $parFormat);
			//$sect->writeText('<br />');
		}
		$sect->writeText('<br />');*/
		$sect1->writeText('<strong>NOMBRE DEL CIRUJANO:</strong>  '.utf8_encode($row1['cirujano']), $fontA1, $parFormat1);
		$sect1->writeText('<br />');

		/*if($row['telCirujano'] != NULL && $row['telCirujano'] != ''){
			$sect->writeText('<strong>TELÉFONO DEL CIRUJANO:</strong>  '.$row['telCirujano'], $fontA, $parFormat);
			//$sect->writeText('<br />');
		}
		if($row['emailCirujano'] != NULL && $row['emailCirujano'] != ''){
			$sect->writeText('<strong>E-MAIL DEL CIRUJANO:</strong>  '.utf8_encode($row['emailCirujano']), $fontA, $parFormat);
			//$sect->writeText('<br />');
		}
		if($row['instrumentista'] != NULL && $row['instrumentista'] != ''){
			$sect->writeText('<strong>NOMBRE DEL INSTRUMENTISTA:</strong>  '.utf8_encode($row['instrumentista']), $fontA, $parFormat);
			//$sect->writeText('<br />');
		}*/
		if($row1['ayudante'] != NULL && $row1['ayudante'] != ''){
			$sect1->writeText('<strong>NOMBRE DEL AYUDANTE:</strong>  '.utf8_encode($row1['ayudante']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}
		if($row1['pediatra'] != NULL && $row1['pediatra'] != ''){
			$sect1->writeText('<strong>NOMBRE DEL PEDIATRA:</strong>  '.utf8_encode($row1['pediatra']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}
		if($row1['anestesiologo'] != NULL && $row1['anestesiologo'] != ''){
			$sect1->writeText('<strong>NOMBRE DEL ANESTESIÓLOGO:</strong>  '.utf8_encode($row1['anestesiologo']), $fontA1, $parFormat1);
			$sect1->writeText('<br />');
		}
		
		
		/*if($row['nombrePrograma'] != NULL && $row['nombrePrograma'] != ''){
			$sect->writeText('<strong>NOMBRE DE QUIEN PROGRAMA CIRUGÍA:</strong>  '.utf8_encode($row['nombrePrograma']), $fontA, $parFormat);
			//$sect->writeText('<br />');
		}
		if($row['telPrograma'] != NULL && $row['telPrograma'] != ''){
			$sect->writeText('<strong>TELÉFONO DE QUIEN PROGRAMA CIRUGÍA:</strong>  '.$row['telPrograma'], $fontA, $parFormat);
			//$sect->writeText('<br />');
		}
		if($row['correoPrograma'] != NULL && $row['correoPrograma'] != ''){
			$sect->writeText('<strong>CORREO DE QUIEN PROGRAMA CIRUGÍA:</strong>  '.utf8_encode($row['correoPrograma']), $fontA, $parFormat);
			//$sect->writeText('<br />');
		}*/		
	}
	
	// guardamos el documento rtf como quirofano.rtf (Si ya existe lo sobreescribe)
	$rtf1->save('partoMini.rtf');
	
	//Creamos el PDF del RTF
	$api1 = new Api("F1mCjAZMl83tAfLpzoYXGbShr52hLSocTEm3c4wDgnCBKvQ2o_beWj5nu1_w4JAyeVw-cnbVCm6-W2htVHPwtg");
 
	$api1->convert([
		"inputformat" => "rtf",
		"outputformat" => "pdf",
		"input" => "upload",
		"file" => fopen('C:\xampp\htdocs\conectaSQLSRV\partos\eliminar\partoMini.rtf', 'r'),
	])
	->wait()
	->download('partoMini.pdf');
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	#Ponemos un boton para poder descargar el primer documento
	echo '<br/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="quirofano.pdf" target="_blank"><b>Descargar Documento</b></a><br/><br/>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a  class="btn btn-info" href="javascript:history.back()">Regresar</a>';
	exit;

?>

</body>
</html>