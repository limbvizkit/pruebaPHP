<?php
	#Desactivamos los avisos de Error
	error_reporting(0);
	#Archivo con la conexion para MYSQL
  	require_once('../conexion/configRepo.php');
	require_once('../conexion/configMedico.php');
	require('mc_table.php');
  	#Archivo para armar el PDF
	include_once('PDF.php');
	#Consultas POO
	require_once('../conexion/funciones_db.php');
	#Configuracion para colocar día y mes en español
	setlocale(LC_ALL,'');
	
	$fecha1 = NULL;
	if(isset ($_POST['fecha']) && !empty($_POST["fecha"])){
		$fecha = $_POST['fecha'];
		$dia = date_create_from_format('Y-m-d',$fecha)->format('d');
		$mes = date_create_from_format('Y-m-d',$fecha)->format('m');
		$anio = date_create_from_format('Y-m-d',$fecha)->format('Y');
		#$fecha = date_create_from_format('Y-m-d',$fecha)->format('d-m-Y');
		$fecha1 = strftime('%A, %d de %B de %Y',mktime(0,0,0,$mes,$dia,$anio));
		$fecha1 = $fecha1;
	}else {
		$fecha= NULL;
	}
	
	if(isset ($_POST['area'])){
		$area= utf8_decode($_POST['area']);
	} else {
		$area= NULL;
	}
	
	if(isset ($_POST['entrega'])){
		$entrega= utf8_decode($_POST['entrega']);
	} else {
		$entrega= NULL;
	}
	
	if(isset ($_POST['recibe'])){
		$recibe= utf8_decode($_POST['recibe']);
	} else {
		$recibe= NULL;
	}
	
	if(isset ($_POST['cargo'])){
		$cargo= utf8_decode($_POST['cargo']);
	} else {
		$cargo= NULL;
	}
	
	if(isset ($_POST['observ'])){
		$observ= utf8_decode($_POST['observ']);
	} else {
		$observ= NULL;
	}
			
	if(isset($_REQUEST['addMaterial']))
	{
		if(isset ($_POST['idResguardo'])){
			$idResguardo= $_POST['idResguardo'];
		} else {
			#$rand=$anio.$mes.$dia.rand();
			#Para generar el idResguardo tomamos el año mes y dia actual y le agregamos 1 numero aleatorio entre 0 y 99
			$idResguardo = $anio.$mes.$dia.mt_rand(0, 99);
		}
		
		$queryAddResguardo = "INSERT INTO resguardos (idResguardo, fechaResguardo, fechaTextual, area, entrega, recibe, cargo, observaciones) 
							VALUES ('$idResguardo', '$fecha', '$fecha1', '$area', '$entrega', '$recibe', '$cargo', '$observ')";
			$result0 = mysqli_query($conexion, $queryAddResguardo);
				
			if(!$result0){
				echo '! ERROR AL REALIZAR INSERCIÓN DE DATOS PARA RESGUARDO!';
				echo '<br/>Query Add: '.$queryAddResguardo;
				exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DEL RESGUARDO CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query Add: '.$queryAddResguardo;
			}
	}
	
	if(isset($_REQUEST['guardar']))
	{
		if(isset ($_POST['cantidad'])){
			$cantidad= $_POST['cantidad'];
		} else {
			$cantidad= NULL;
		}
		
		if(isset ($_POST['unidad'])){
			$unidad= $_POST['unidad'];
		} else {
			$unidad= NULL;
		}
	
		if(isset ($_POST['tipo'])){
			$tipo= utf8_decode($_POST['tipo']);
		} else {
			$tipo= NULL;
		}
		
		if(isset ($_POST['descripcion'])){
			$descripcion= utf8_decode($_POST['descripcion']);
		} else {
			$descripcion= NULL;
		}
		
		if(isset ($_POST['serie'])){
			$serie= utf8_decode($_POST['serie']);
		} else {
			$serie= NULL;
		}
		
		if(isset ($_POST['marca'])){
			$marca= utf8_decode($_POST['marca']);
		} else {
			$marca= NULL;
		}
		
		if(isset ($_POST['modelo'])){
			$modelo= utf8_decode($_POST['modelo']);
		} else {
			$modelo= NULL;
		}
		
		if(isset ($_POST['idResguardo']) && !empty($_POST["idResguardo"])){
			$idResguardo= $_POST['idResguardo'];
			
			$queryAddMaterial = "INSERT INTO materiaresguardo (idMaterial,idResguardo,cantidad,unidad,tipoActivo,descActivo,numSerie,marca,modelo,
			idImagen)	VALUES (NULL, '$idResguardo', '$cantidad', '$unidad', '$tipo', '$descripcion', '$serie', '$marca', '$modelo', NULL)";
			$result0 = mysqli_query($conexion, $queryAddMaterial);
				
			if(!$result0){
				echo'! ERROR AL REALIZAR INSERCIÓN DE DATOS PARA MATERIAL!';
				echo '<br/>Query Add: '.$queryAddMaterial;
				exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DEL MATERIAL CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query Add: '.$queryAddMaterial;
			}
		} else {
			$idResguardo = NULL;
		}
	}
	
	#Para eliminar un material
	if(isset($_GET['idMaterial']) && !empty($_GET["idMaterial"])){
		$idMaterial = $_GET['idMaterial'];
		$idResguardo= $_GET['idResguardo'];
		$fecha= $_GET['fecha'];
		$fecha1= $_GET['fecha1'];
		$area= $_GET['area'];
		$entrega= $_GET['entrega'];
		$recibe= $_GET['recibe'];
		$cargo= $_GET['cargo'];
		$observ= $_GET['observ'];
		
		$queryDelMaterial = "UPDATE materiaresguardo SET estatus='0' WHERE idMaterial = $idMaterial";
			$result1 = mysqli_query($conexion, $queryDelMaterial);
				
			if(!$result1){
				echo'! ERROR AL REALIZAR BORRADO DE DATOS PARA MATERIAL!';
				echo '<br/>Query Add: '.$queryDelMaterial;
				exit;
			} else {
				echo '<br/><strong>!!!! SE ELIMINO EL MATERIAL CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query Add: '.$queryAddMaterial;
			}
	}
	
	if(isset($_REQUEST['guardar']) || isset($_REQUEST['addMaterial']) || (isset($_GET['idMaterial']) && !empty($_GET["idMaterial"])) || (isset ($_GET['idResguar']) && !empty($_GET["idResguar"])) ){
		
		if(isset ($_GET['idResguar'])){
			$idResguardo = $_GET['idResguar'];
		}
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>AgregarMaterial</title>
	<link rel="stylesheet" href="../css/bootstrap1.min.css" />
	<style type="text/css">
		.auto-style3 {
			font-family: Arial, Helvetica, sans-serif;
			text-align: center;
		}
		.auto-style4 {
		border: 1px solid #000000;
		text-align: center;
		}
		.auto-style5 {
			border: 3px solid #000000;
		}
		</style>
		<script type="text/javascript">
			function confirmSubmit()
			{
				var agree=confirm("¿Está seguro de eliminar este registro? !!!EL PROCESO ES IRREVERSIBLE!!!");
				if (agree){
				 	return true ;
				}else{
				 	return false ;
				}
			}
		</script>

	</head>
	
	<body  background="../img/logoNew2Agua.jpg">
		<div class="auto-style3">
			<span> <br />
			ACTIVO(S) FIJO(S), EQUIPO MENOR Y/O HERRAMIENTA(S) DE TRABAJO.</span>
		</div>
		<br/>
		<table style="width: 100%">
			<th style="width: 45px" class="auto-style5">No.</th>
			<th style="width: 81px" class="auto-style5">CANTIDAD</th>
			<th style="width: 64px" class="auto-style5">UNIDAD</th>
			<th class="auto-style5">&nbsp;&nbsp;TIPO DE ACTIVO</th>
			<th class="auto-style5">&nbsp;&nbsp;DESCRIPCIÓN <br/>&nbsp;&nbsp;DE ACTIVO</th>
			<th class="auto-style5">&nbsp;&nbsp;NO. SERIE</th>
			<th class="auto-style5">&nbsp;&nbsp;MARCA</th>
			<th class="auto-style5">&nbsp;&nbsp;MODELO</th>
			<th class="auto-style5">&nbsp;&nbsp;IMAGEN</th>
			<th class="auto-style5">&nbsp;&nbsp;OPCIONES</th>';
			
			$queryMateriales = "SELECT idMaterial,idResguardo,cantidad,unidad,tipoActivo,descActivo,numSerie,marca,modelo,idImagen
							FROM materiaresguardo
							WHERE idResguardo= '$idResguardo' AND estatus=1";
			$idMaterial = mysqli_query($conexion, $queryMateriales) or die (mysqli_error($conexion));
			$c=1;
			while($row = mysqli_fetch_array($idMaterial)){
				echo '<tr>
						<td class="auto-style4">'.$c++.'</td>
						<td class="auto-style4">'.$row[2].'</td>
						<td class="auto-style4">'.$row['unidad'].'</td>
						<td class="auto-style4">'.$row['tipoActivo'].'</td>
						<td class="auto-style4">'.utf8_encode($row['descActivo']).'</td>
						<td class="auto-style4">'.$row['numSerie'].'</td>
						<td class="auto-style4">'.utf8_encode($row['marca']).'</td>
						<td class="auto-style4">'.utf8_encode($row['modelo']).'</td>
						<td class="auto-style4">';
						if($row['idImagen'] != NULL && $row['idImagen'] != ''){
							echo $row['idImagen'];
						}else{	
							echo'	<form enctype="multipart/form-data" action="uploader.php" method="post" target="_blank">
									<input name="idMater" type="hidden" value="'.$row[0].'" />
									<input name="uploadedfile" type="file" />
									<input type="submit" value="Subir imagen" />
									<strong> Subir imagenes de maximo 800 X 800 <br /> Solo se permiten imagenes .jpg </strong>
								</form>';
					}
					echo '</td>
					<td class="auto-style4">
					 &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmit()" href="creaPDF1.php?idMaterial='.$row[0].'&idResguardo='.$idResguardo.'" />ELIMINAR </a></td>
						</tr>';
			}
		echo '</table>
			<br />
			<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br />
			<form method="post" action="creaPDF1.php">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CANTIDAD: </strong><input type="number" id="cantidad" name="cantidad" style="width: 81px" required/>
				<strong>&nbsp;UNIDAD(pza, caja, etc): </strong>
				<input type="text" id="unidad" name="unidad" style="width: 101px" required/>&nbsp;
				<strong>TIPO DE ACTIVO: </strong>
				<input type="text" id="tipo" name="tipo" style="width: 298px" required/> <br />
				<br />
				&nbsp; <strong>&nbsp;&nbsp;&nbsp;&nbsp; DESCRIPCIÓN DE ACTIVO: </strong>
				<input type="text" id="descripcion" name="descripcion" style="width: 577px" required/>
				<br />
				<br />
				&nbsp; <strong>&nbsp;&nbsp;&nbsp;&nbsp; NÚMERO DE SERIE: </strong>
				<input type="text" id="serie" name="serie" style="width: 161px" required/>&nbsp;
				<strong>MARCA: </strong> 
				<input type="text" id="marca" name="marca" style="width: 170px" required/>&nbsp;
				<strong>MODELO:</strong> 
				<input type="text" id="modelo" name="modelo" style="width: 140px" required/><br />
				<br />
				<br />
				<input name="fecha" type="hidden" value="'.$fecha.'" />
				<input name="fecha1 " type="hidden" value="'.$fecha1.'" />
				<input name="area" type="hidden" value="'.$area.'" />
				<input name="entrega" type="hidden" value="'.$entrega.'" />
				<input name="recibe" type="hidden" value="'.$recibe.'" />
				<input name="cargo" type="hidden" value="'.$cargo.'" />
				<input name="observ" type="hidden" value="'.$observ.'" />
				<input name="idResguardo" type="hidden" value="'.$idResguardo.'" />
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn btn-success" name="guardar" type="submit" value="GUARDAR" style="height: 60px; width: 166px" />
			</form>
		<br/>
		<form method="post" action="creaPDF1.php" target="_blank">
			<input name="fecha" type="hidden" value="'.$fecha.'" />
			<input name="fecha1 " type="hidden" value="'.$fecha1.'" />
			<input name="area" type="hidden" value="'.$area.'" />
			<input name="entrega" type="hidden" value="'.$entrega.'" />
			<input name="recibe" type="hidden" value="'.$recibe.'" />
			<input name="cargo" type="hidden" value="'.$cargo.'" />
			<input name="observ" type="hidden" value="'.$observ.'" />
			<input name="idResguardo" type="hidden" value="'.$idResguardo.'" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-primary" name="generapdf" type="submit" value="GENERAR PDF" style="height: 60px; width: 166px" />
		</form>
		<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>
	</body>
	</html>';
 }
/******************************************************************************************************************************************************/
//Esta parte es la que Genera el PDF
if(isset($_REQUEST['generapdf']) || (isset ($_GET['idResguardo']) && !empty($_GET["idResguardo"]))) {
	$idResguardo = NULL;
	if(isset ($_POST['idResguardo'])){
		$idResguardo = $_POST['idResguardo'];
	}
	if(isset ($_GET['idResguardo']) ){
		$idResguardo = $_GET['idResguardo'];
	} 
	
	#echo 'LLEGO idResguardo: '.$idResguardo;
	#Query para Sacar los datos del primer Recuadro (Datos Basicos)
	$queryCuadro1 = "SELECT * FROM resguardos WHERE idResguardo = $idResguardo";
	$result0 = mysqli_query($conexion, $queryCuadro1);
	$rowC1 = mysqli_fetch_array($result0);
	
	#Query para sacar los datos del 2do cuadro (Materiales)
	$queryMateriales = "SELECT idMaterial,idResguardo,cantidad,unidad,tipoActivo,descActivo,numSerie,marca,modelo,idImagen
						FROM materiaresguardo
						WHERE idResguardo= '$idResguardo' AND estatus=1";
	$idMaterial = mysqli_query($conexion, $queryMateriales) or die (mysqli_error($conexion));
	$mater = array();
	while($rowM = mysqli_fetch_array($idMaterial)){
		$mater[] = ($rowM);
	}
		#Variables
		//Array de cadenas para la cabecera
	    $cabecera = array("FECHA:",utf8_decode("ÁREA DE UBICACIÓN DE LOS BIENES:"),"ENTREGA:",utf8_decode("RECÍBE"));
	    #$datosPersona = array($fecha1,$area,$entrega,$recibe);
	    $datosPersona = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));
	 
	    $pdf = new PDF();
	    $pdf->AddPage('P', 'Letter'); //Vertical, Carta
	    $pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
		//$pdf->Header('1');
	    //imprimimos un texto
	    $pdf->MultiCell(0,5,utf8_decode('APLICA: Cuando el activo fijo, equipo menor y herramienta de trabajo es NUEVO O USADO y se ha inventariado, identificándose dentro de un área especificada.'));
		#$pdf->Cell(0,7,utf8_decode('identificándose dentro de un área especificada.'),0, 0, 'L');
	    
	    $pdf->tabla($cabecera,$datosPersona); //Método que integra a cabecera y datos
	    $pdf->Ln();
	    $pdf->SetFont('Arial','',12);
	    $pdf->MultiCell(0,5,utf8_decode('Por medio de la presente, se hace entrega formal del (los) siguiente(s) ACTIVO(S) FIJO(S), EQUIPO MENOR Y/O HERRAMIENTA(S) DE TRABAJO.'));
	    #$pdf->Cell(4,7,'HERRAMIENTA(S) DE TRABAJO.',0,1,'L');
	    
	    $cabecera2 = array("CANT/U","TIPO DE ACTIVO",utf8_decode("DESCRIPCIÓN DE ACTIVO"),"SERIE","MARCA","MODELO","IMG");
	    $materiales = array(utf8_encode($rowC1[2]),utf8_encode($rowC1[3]),utf8_encode($rowC1[4]),utf8_encode($rowC1[5]));
	 	$pdf->otraTabla($cabecera2,$mater);
	 	
	 	$pdf->SetFont('Arial','',12);
	 	$pdf->Ln(5);
	 	$pdf ->MultiCell(0,5,'Quien ocupa el cargo de "'.$rowC1[6].'" y que como responsable adquieres el compromiso de informar cualquier tipo de novedad que suceda con dicho(s) activo(s), como'. utf8_decode(' daño').', necesidad de mantenimiento preventivo, movimiento a otra oficina, punto o persona; al responsable de los Activos Fijos.');
	    $pdf->Ln(5);
	    #Observaciones
		$pdf->Cell(0,7,'OBSERVACIONES: ',0, 1 , 'L');
		$pdf->Ln(1);
		##Observaciones de la BD
	 	$pdf ->MultiCell(0,5,$rowC1[7]);
	 	$pdf->Ln(10);
	 	$pdf->Cell(0,7,'FIRMAN:',0,1,'L');
	 	$pdf->Ln(10);
	 	$pdf->Cell(0,7,'___________________________                  ____________________________',0,1,'C');
	 	$pdf->Cell(0,7,utf8_decode('M.C.C. Juan Diego Gómez Fierros                  Quien Recibe Nombre y Firma'),0,1,'C');
	 	$pdf->Cell(0,7,utf8_decode('Jefe de Tecnología de la Información                                                                           '),0,1,'C');
	
	    $pdf->Output(); //Salida al navegador del pdf
    }


?>