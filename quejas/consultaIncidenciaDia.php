<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Incidencias Día</title>
	<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
	<script type="text/jscript" src="../js/bootstrap.min.js" >	</script>
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/datatables.min.css" />
	<script type="text/javascript" src="../js/datatables.min.js"></script>
	<script type="text/javascript">
		function blqCeldas(c){
			document.getElementById("solucion"+c).disabled=false;
			document.getElementById("resuelto"+c).disabled=false;
			document.getElementById("checkboxInci"+c).disabled=false;
			document.getElementById("descr"+c).disabled=false;
			document.getElementById("persona"+c).disabled=false;
			document.getElementById("btnGrd"+c).disabled=false;
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#simple').dataTable({
				"language": {
	    	        "lengthMenu": "Mostrar _MENU_ Filas",
	    	        "zeroRecords": "Sin Resultados - Intente otra frase",
	    	        "info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE INCIDENCIAS _MAX_",
	    	        "infoEmpty": "Sin Archivos",
	    	        "infoFiltered": "(Total _TOTAL_ filas)",
	    	        "sSearch":"Buscar",
	    	        "paginate": {
	    			  	"next": "Siguiente",
	    			 	"sPrevious":"Anterior"
	    			}
	    	    }
	    	});
		});
	</script>
	<link rel="stylesheet" href="../css/tabAz.css" />

	<style type="text/css">
		.auto-style1 {
			background-color: #FFFFFF;
		}
		.auto-style2 {
			text-align: center;
			background-color: #FFFFFF;
		}
	</style>
	</head>
	
<?php
	setlocale(LC_ALL,'');
	date_default_timezone_set("America/Mexico_City");
	require_once('../conexion/configLogin.php');
	require_once '../rtf/lib/PHPRtfLite.php';

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
	$valor = $_SESSION[$rol];
	
	$queryArea = "SELECT u.idArea, a.nombreArea, d.nombre
				FROM usuarios as u
				LEFT JOIN areas as a ON u.idArea=a.idArea
				LEFT JOIN datosusuario AS d ON u.idUsr=d.idUsuario
				WHERE u.nombreUsr = '$rol'";
				
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];
	$areaName = utf8_encode($area[1]);
	$fechaGet = date('Y-m-d');
	$nombreUsr = utf8_encode($area[2]);
		
	if (isset($_GET['f']))
	{
		$f = $_GET['f'];
		$fechaIni = $f." "."00:00:00";
		$fechaFin = $f." "."23:59:59";
		
		$fechaHoy = 'Incidencias del Día'.' '.date('d/m/Y');
		$mostrarOpc=FALSE;
	} else {
		$fechaIni = NULL;
		$fechaFin = NULL;
		
		$fechaHoy = 'Incidencias Abiertas a la Fecha'.' '.date('d/m/Y');
		$mostrarOpc=TRUE;
	}
	
	#if (isset($_POST['updIncidencia'])) {
	if(isset ($_POST['solucion'])){
	
		$solucion= utf8_decode(trim($_POST['solucion'])); 
		
		if(isset ($_POST['fechaIni'])){
			$fechaIni= $_POST['fechaIni'];
		}
		if(isset ($_POST['fechaFin'])){
			$fechaFin= $_POST['fechaFin'];
		}
		if(isset ($_POST['resuelto'])){
			$resuelto= $_POST['resuelto'];
		} else {
			$resuelto= NULL;
		}
		if(isset ($_POST['descr'])){
			$descr= utf8_decode(trim($_POST['descr']));
		} else {
			$descr= NULL;
		}
		
		if(isset ($_POST['persona'])){
			$persona= utf8_decode(trim($_POST['persona']));
		} else {
			$persona= NULL;
		}

		if(isset($_POST["checkbox"])) {
			#Si se marco el checkBox le asignamos a la variable el valor seleccionado
			$idIncidencia = implode(",", $_POST['checkbox']);
		}
		#Si se presiona resolver desde el area reportada no se resuelve la incidencia :o se queda como "REVISION", si se presiona desde al area q reporta si se resuelve ;) y queda como "RESUELTO"
		if(isset ($_POST['resolver'])){
			$resolver= $_POST['resolver'];
			if($resolver == 'SI'){
				$estatus = '3';
				if($resuelto == 'SI'){
					$fechaSol = 'CURRENT_TIMESTAMP';
				} else {
					$fechaSol = 'NULL';
					$estatus = '1';
				}
			} else {
				$estatus = '2';
				$fechaSol = 'NULL';
			}
		}
		
		$queryHistIncidencia = "INSERT INTO historicoIncidencias (idHistorico, idIncidencia, fechaHistorico,  solucion, resuelto, estatus, reporte, personaRes, usr) 
							VALUES (NULL, '$idIncidencia', CURRENT_TIMESTAMP, '$solucion', '$resuelto', '$estatus', '$descr', '$persona', '$rol')";
		$result = mysqli_query($conexion, $queryHistIncidencia);
		if(!$result){
			echo'! ERROR al realizar inserción de datos Hist Incidencia!';
			echo $queryHistIncidencia;
		} else {
			echo '<br/>!!!! SE INSERTARON LOS DATOS DEL HISTORICO INCIDENCIA CORRECTAMENTE!!!!<br>';
			#echo '<br/>Query HistIncid: '.$queryHistIncidencia;
		}

		
		$queryUpdIncidencia = "UPDATE incidencias SET reporte='$descr', solucion='$solucion', resuelto='$resuelto', fechaSolucion=$fechaSol, personaRes='$persona', estatus='$estatus' WHERE idIncidencia='$idIncidencia'";
		$result0 = mysqli_query($conexion, $queryUpdIncidencia);
		
		if(!$result0){
			echo'! ERROR al realizar inserción de datos UPD Incidencia!';
			echo $queryUpdIncidencia;
		} else {
			echo '<br/>!!!! SE ACTUALIZARON LOS DATOS DE LA INCIDENCIA CORRECTAMENTE!!!!<br>';
			#echo '<br/>Query UPD: '.$queryUpdIncidencia;
		}
	}
	//Todo la siguiente condicion es para generar un archivo WORD para uso de Atencion a clientes
	if (isset($_GET['word']))
	{
		// registers PHPRtfLite autoloader (spl)
		PHPRtfLite::registerAutoloader();
		
		// rtf document instance
		$rtf = new PHPRtfLite();
		
		// add section
		$sect = $rtf->addSection();
		
		//Fuentes y colores de fuente
		$font = new PHPRtfLite_Font(9, 'Calibri');
		$fontAW = new PHPRtfLite_Font(6, 'Arial','#FFFFFF');
		$fontAB = new PHPRtfLite_Font(6, 'Arial','#08088A');
		$fontA = new PHPRtfLite_Font(6, 'Arial');
		
		//TXT Align Right
		$parFormatRight = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
		//TXT Align Center
		$parFormatCenter = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);

		// add header
		$header = $sect->addHeader();
		
		// add table
		$table = $header->addTable();
		$table->addRows(1);
		$table->addColumnsList(array(2,2,2,2,2,2,2));
		
		//Logo Henri Nuevo
		$cell_1 = $table->getCell(1, 1);
		$image_1 = $cell_1->addImage('../img/logoNew2.jpg');
		// image width 2cm and height 2cm
		$image_1->setWidth(2);
		$image_1->setHeight(2);
		
		//Logo Henri Old
		/*$cell_2 = $table->getCell(1, 7);
		$image_2 = $cell_2->addImage('img/oldHD.jpg');
		// image width 2cm and height 2cm
		$image_2->setWidth(2);
		$image_2->setHeight(2);*/
		
		// write text
		$sect->writeText('<br />');
		$sect->writeText('Cuernavaca, Mor. A '.utf8_encode(strftime('%d de %B de %Y')), $font, $parFormatRight);
		$sect->writeText('<br />');
		$sect->writeText('Check list del día '.utf8_encode(strftime('%d de %B')).' de las habitaciones vacías a las 00:00 h', $font, new PHPRtfLite_ParFormat());
		$sect->writeText('<br />');
		
		// add table_2
		$table_2 = $sect->addTable();
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
		$table_2->writeToCell(1, 5, '<b> SOLUCIÓN </b>', $fontAW ,$parFormatCenter);
		
		//Hacemos la consulta para llenar la tabla
		$queryInciDia0 = "SELECT fechaAlta, a1.nombreArea, a2.nombreArea, reporte, solucion, resuelto, fechaSolucion, h.numeroHabitacion, h.tipoHabitacion, i.idIncidencia
				FROM incidencias as i
				LEFT JOIN areas as a1 ON i.idAreaReporta = a1.idArea
				LEFT JOIN areas as a2 ON i.idAreaResponsable = a2.idArea
				LEFT JOIN habitaciones as h ON i.idHabitacion = h.idHabitacion
				WHERE ((idAreaReporta = '$areaFin' AND (idAreaResponsable != '$areaFin' OR ISNULL(idAreaResponsable) OR reporte != 'Habitación Ocupada')) OR $areaFin = '0') 
				AND (i.estatus != 3 || fechaAlta BETWEEN '$fechaIni' AND '$fechaFin')
				ORDER BY h.numeroHabitacion";
			$idInciDia0 = mysqli_query($conexion, $queryInciDia0) or die (mysqli_error($conexion));
			$d = 1;
			$col = 2;
			while($row0 = mysqli_fetch_array($idInciDia0)){
				//Agregamos una nueva fila
				$table_2->addRows(1);
				
				if($row0[0] != NULL){
					$date1 = date_create_from_format('Y-m-d H:i:s',$row0[0])->format('d/m/Y H:i:s');
				} else {
					$date1 = NULL;
				}
				if($row0[6] != NULL){
					$date2 = date_create_from_format('Y-m-d H:i:s',$row0[6])->format('d/m/Y H:i:s');
				} else {
					$date2 = NULL;
				}
				if(utf8_encode($row0[3]) != 'Habitación Ocupada'){
					#Le ponemos bordes a las celdas de la nueva fila
					$table_2->setBorderForCellRange($border, $col,1, $col,2);
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
					$col++;
				}
			}
			
		// write text
		$sect->writeText('<br /><br /><br />');
		//$sect->writeText($queryInciDia0);
		$sect->writeText('_______________                  _______________________              ______________________
'.$nombreUsr.'                      T.E. José Alfredo Salgado M.             Lic. Victor Barajas                                             
Atención al Cliente                       Mantenimiento                     Servicios Generales                       
Trabajo reportado                  Enterado para realizar trabajo           Enterado para realizar trabajo',
     $font, new PHPRtfLite_ParFormat());
		
		// guardamos el documento rtf como checList.rtf (Si ya existe lo sobreescribe)
		$rtf->save('checkList.rtf');
		
		#Ponemos un boton para poder descargar el documento
		echo '&nbsp;&nbsp;<br/><a class="btn btn-primary" href="checkList.rtf"><b>Descargar Documento</b></a><br/><br/>
			  &nbsp;&nbsp;<input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />';
		exit;
	}
	
	#echo $fechaIni." ".$fechaFin." ".$areaFin;
?>
	
	<body style="background-image: url(../img/logoNew2Agua.jpg)" >
	<br/>
	<strong><span style="font-size:large">&nbsp;&nbsp; <?php echo $fechaHoy ?>
	<br/>
	<strong>&nbsp;&nbsp; Área: <?php echo $areaName ?></strong>
	</span></strong>
		<hr/>
		<strong>&nbsp;NOTAS: Aunque no aparezcan en el listado siguiente las incidencias abiertas en fechas anteriores, al Generar el Reporte estas aparecerán. <br />
		&nbsp;Se debe resolver 1 incidencia a la vez.
		<br />
		<br />
		&nbsp;Pasos para resolver una incidencia: <br />
		&nbsp;1.- Presionar el botón RESOLVER de la fila con la incidencia a resolver <br />
		&nbsp;2.- Marcar el recuadro de la columna Res. <br />
		&nbsp;3.- Colocar texto en el campo SOLUCIÓN(opcional) <br />
		&nbsp;4.- Colocar el nombre de la PERSONA QUE RESOLVIÓ(opcional) <br />
		&nbsp;5.- Seleccionar "SI" en las opciones de la columna RESUELTO <br />
		&nbsp;6.- Presionar el botón GUARDAR
		</strong><br /><br />
		Codigo de colores para incidencias:
		<br/> <span style='color:red'> Rojo:</span> No solucionada, <span style='color:yellow;background: black'>Amarillo:</span> Revisión, <span style='color:lime;background:black'>Verde:</span> Solucionada(Falta Revisión)
		<div class="datagrid">
		<form method="post" action="consultaIncidenciaDia.php">
		<table id="simple">
		 <thead>
          <tr>
          <?php if($mostrarOpc){ ?>
				<th class="auto-style2">&nbsp;Res.&nbsp;</th>
			<?php } ?>
			<th class="auto-style2">&nbsp;No.&nbsp;</th>
			<th class="auto-style2">&nbsp;HABITACIÓN&nbsp;</th>
			<th class="auto-style2">&nbsp;TIPO HABITACIÓN&nbsp;</th>
			<th class="auto-style2">&nbsp;REPORTE&nbsp;</th>
			<th class="auto-style2">&nbsp;FECHA DE ALTA&nbsp;</th>
			<th class="auto-style2">&nbsp;ÁREA REPORTA&nbsp;</th>
			<th class="auto-style2">&nbsp;ÁREA RESPONSABLE&nbsp;</th>
			<th class="auto-style2">&nbsp;SOLUCIÓN&nbsp;</th>
			<th class="auto-style2">&nbsp;PERSONA QUE RESOLVIÓ&nbsp;</th>
			<th class="auto-style2">&nbsp;RESUELTO&nbsp;</th>
			<?php if(!$mostrarOpc){ ?>
				<th class="auto-style2">&nbsp;FECHA DE SOLUCIÓN&nbsp;</th>
			<?php } ?>
			<?php if($mostrarOpc){ ?>
				<th class="auto-style2">&nbsp;OPCIONES&nbsp;</th>
			<?php } ?>
			</tr>
     	</thead>
      	<tbody>
			<?php
			$and='';
			if($areaFin == '15' || $areaFin == '38'){
				$and= " OR $areaFin IN(15,38) AND i.reporte LIKE '%Ocupada%'";
			}
				if($fechaIni != NULL){
					$queryInciDia = "SELECT fechaAlta, a1.nombreArea, a2.nombreArea, reporte, solucion, resuelto, fechaSolucion, h.numeroHabitacion, h.tipoHabitacion, i.idIncidencia, i.idAreaResponsable, i.estatus, i.idAreaReporta, i.personaRes
							FROM incidencias as i
							LEFT JOIN areas as a1 ON i.idAreaReporta = a1.idArea
							LEFT JOIN areas as a2 ON i.idAreaResponsable = a2.idArea
							LEFT JOIN habitaciones as h ON i.idHabitacion = h.idHabitacion
							WHERE (fechaAlta BETWEEN '$fechaIni' AND '$fechaFin' OR fechaSolucion BETWEEN '$fechaIni' AND '$fechaFin') AND (idAreaReporta = '$areaFin' OR $areaFin = '0'
							$and)
							ORDER BY fechaAlta";
				} else {
					$queryInciDia = "SELECT fechaAlta, a1.nombreArea, a2.nombreArea, reporte, solucion, resuelto, fechaSolucion, h.numeroHabitacion, h.tipoHabitacion, i.idIncidencia, i.idAreaResponsable, i.estatus, i.idAreaReporta, i.personaRes
							FROM incidencias as i
							LEFT JOIN areas as a1 ON i.idAreaReporta = a1.idArea
							LEFT JOIN areas as a2 ON i.idAreaResponsable = a2.idArea
							LEFT JOIN habitaciones as h ON i.idHabitacion = h.idHabitacion
							WHERE fechaSolucion IS NULL AND (i.idAreaReporta = '$areaFin' OR $areaFin = '0' OR i.idAreaResponsable = '$areaFin'
							$and)
							ORDER BY fechaAlta";
				}
			$idInciDia = mysqli_query($conexion, $queryInciDia) or die (mysqli_error($conexion));
			#echo $queryInciDia;
			#$numero = mysqli_num_rows($idInciDia);
			#echo  '  NUMEROOOO!!! '.$numero;
			$c = 1;
			while($row = mysqli_fetch_array($idInciDia)){
			if($row[0] != NULL){
				$date1 = date_create_from_format('Y-m-d H:i:s',$row[0])->format('d/m/Y H:i:s');
			} else {
				$date1 = NULL;
			}
			if($row[6] != NULL){
				$date2 = date_create_from_format('Y-m-d H:i:s',$row[6])->format('d/m/Y H:i:s');
			} else {
				$date2 = NULL;
			}
			if($c%2==0){
				$clas = 'class="alt"';
			} else {
				$clas = '';
			}
			?>
			<!--form method="post" action="consultaIncidenciaDia.php"-->
				<tr <?php echo $clas ?>>
					<?php if($mostrarOpc){ ?>
					    <td class="auto-style2"><input name="checkbox[]" type="checkbox" id="checkboxInci<?php echo $row[9] ?>" value="<?php echo $row[9] ?>" style="width: 40px; height: 35px" disabled /></td>
				    <?php } ?>
				    <?php if($row['estatus'] == '1') { ?>
						<td style="text-align: center;color:red"><?php echo $c++ ?></td>
					<?php } if($row['estatus'] == '2' && $row['idAreaReporta'] != $areaFin) { ?>
						<td style="text-align: center;background-color: black;color:lime"><?php echo $c++ ?></td>
					<?php } if($row['estatus'] == '2' && $row['idAreaReporta'] == $areaFin) { ?>
						<td style="text-align: center;background-color: black;color:yellow"><?php echo $c++ ?></td>
					<?php } if($row['estatus'] == '3') { ?>
						<td class="auto-style2"><?php echo $c++ ?></td>
					<?php } ?>
					<td class="auto-style2"><?php echo $row[7] ?></td>
					<td class="auto-style2"><?php echo  utf8_encode($row[8]) ?></td>
					
					<td class="auto-style2">
						<?php if($row[10] != $areaFin || $row[12] == $areaFin) { #Esta condicion es si el area Responsable de Resolver es diferente al area del usr q ingresó 
																				# pero el area que levanto la incidencia es la misma que debe resolver :s ?>
							<textarea id="descr<?php echo trim($row[9]) ?>" name="descr" cols="30" rows="4" disabled > <?php echo  utf8_encode($row[3]) ?> </textarea>
						<?php } else { ?>
								<textarea id="descr<?php echo trim($row[9]) ?>" name="descr" cols="30" rows="4" disabled readonly> <?php echo  utf8_encode($row[3]) ?> </textarea>
						<?php } ?>
					</td>
					<td class="auto-style2"><?php echo $date1 ?></td>
					<td class="auto-style2"><?php echo utf8_encode($row[1]) ?></td>
					<td class="auto-style2"><?php echo utf8_encode($row[2]) ?></td>					
					<td class="auto-style2">
						<textarea id="solucion<?php echo trim($row[9]) ?>" name="solucion" cols="20" rows="2" disabled > <?php echo  utf8_encode($row[4]) ?> </textarea>
						<!--input id="solucion<?php echo $row[9] ?>" name="solucion" type="text" value="<?php echo  utf8_encode($row[4]) ?>" disabled style="width: 60px" /--> 
					</td>
					<td class="auto-style2">
						<textarea id="persona<?php echo trim($row[9]) ?>" name="persona" cols="20" rows="2" disabled > <?php echo  utf8_encode($row[13]) ?> </textarea> 
					</td>
					<td class="auto-style1"> &nbsp;&nbsp;
						<select id="resuelto<?php echo $row[9] ?>" name="resuelto" disabled>
							<option value="<?php echo $row[5] ?>"> <?php echo $row[5] ?></option>
						    <!--option value="OK"> OK </option-->
						    <option value="SI"> SI </option>
						    <option value="NO"> NO </option>
						</select>
					</td>
					<?php if(!$mostrarOpc){ ?>
						<td class="auto-style2"><?php echo $date2 ?></td>
					<?php } ?>
					<input name="rol" type="hidden" value="<?php echo $rol ?>" />
					<input name="fechaIni" type="hidden" value="<?php echo $fechaIni ?>" />
					<input name="fechaFin" type="hidden" value="<?php echo $fechaFin ?>" />
					<?php 
						if($mostrarOpc){
							if($row[10] != $areaFin || $row[12] == $areaFin) { ?>
								<input name="resolver" type="hidden" value="SI" />
								 <td class="auto-style1">&nbsp;&nbsp;<a class="btn btn-info" onclick="blqCeldas(<?php echo $row[9] ?>)" >RESOLVER</a>
									&nbsp;&nbsp;<input class="btn btn-success" id="btnGrd<?php echo $row[9] ?>" type="Submit" name="updIncidencia" value="GUARDAR" disabled />
								</td>
							<?php } else { echo '<input name="resolver" type="hidden" value="NO" />
										<td class="auto-style1">&nbsp;&nbsp;<a class="btn btn-info" onclick="blqCeldas('.$row[9].')" >RESOLVER</a>
										&nbsp;&nbsp;<input class="btn btn-success" id="btnGrd'.$row[9].'" type="Submit" name="updIncidencia" value="GUARDAR" disabled />';
								 }
						}
					} ?>
				</tr>
				</tbody>
		</table>
		</form>
		</div>
		<br/> <br/>
		<?php 
			if($fechaIni != NULL){ ?>
			<a class="btn btn-primary" style="width: 130px; height: 60px" href="consultaIncidenciaDia.php?rol=<?php echo $rol ?>&&f=<?php echo $fechaGet ?>&&word=s" target="_blank">Generar Reporte</a>
		<?php }?>
		 <input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
		 <br/>
	</body>
</html>