<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/bootstrap.min.css" >
	<!-- Optional theme -->
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css" >
	<!-- Latest compiled and minified JavaScript -->
	<script type="text/jscript" src="../js/bootstrap.min.js" ></script>
	<link rel=stylesheet href="../css/stylo.css" type="text/css">
	<title>Carga de PDF Protegido</title>
</head>
<body>

<?php  
	require_once "classes/pdf_to_image.php";
	require_once('../conexion/configLogin.php');
	
	$pdf2image = new pdf2image();
	
	$pdf_file = @$_FILES['pdf_file'];
	$page_number = @$_POST['page_number'];
	#El nombreArch es el nombre con el que se guarda en la carpeta
	$nombreArch = $pdf2image->scanear_string($pdf_file['name']);
	
	#Valores para guardar en la BD
	if(isset ($_POST['areas'])){
		$areas= $_POST['areas'];
	} else {
		$areas= NULL;
	}
	
	if (isset($_POST['nombreDoc']))
	{
		#El nombreDoc es el nombre con el que se guarda en la BD
		$nombreDoc=$_POST['nombreDoc'];
	}else {
		$nombreDoc= NULL;
	}
	if (isset($_POST['serie']))
	{
		$serie=$_POST['serie'];
	}else {
		$serie= NULL;
	}
	if (isset($_POST['subSerie']))
	{
		$subSerie=$_POST['subSerie'];
	}else {
		$subSerie= NULL;
	}
	if (isset($_POST['nombreDoc']))
	{
		$nombreDoc=$_POST['nombreDoc'];
	}else {
		$nombreDoc= NULL;
	}
	if (isset($_POST['tipoDocsInt']))
	{
		$tipoDocsInt=$_POST['tipoDocsInt'];
	}else {
		$tipoDocsInt= NULL;
	}
	
	if (isset($_POST['caracterDocs']))
	{
		$caracterDocs=$_POST['caracterDocs'];
	}else {
		$caracterDocs= NULL;
	}
	if (isset($_POST['ao']))
	{
		$ao=$_POST['ao'];
	}else {
		$ao= NULL;
	}
	if (isset($_POST['at']))
	{
		$at=$_POST['at'];
	}else {
		$at= NULL;
	}
	if (isset($_POST['ac']))
	{
		$ac=$_POST['ac'];
	}else {
		$ac= NULL;
	}
	if (isset($_POST['t']))
	{
		$t=$_POST['t'];
	}else {
		$t= NULL;
	}
	if (isset($_POST['l']))
	{
		$l=$_POST['l'];
	}else {
		$l= NULL;
	}
	if (isset($_POST['f']))
	{
		$f=$_POST['f'];
	}else {
		$f= NULL;
	}
	if (isset($_POST['c']))
	{
		$c=$_POST['c'];
	}else {
		$c= NULL;
	}
	if (isset($_POST['a']))
	{
		$a=$_POST['a'];
	}else {
		$a= NULL;
	}
	if (isset($_POST['dispDoc']))
	{
		$dispDoc=$_POST['dispDoc'];
	}else {
		$dispDoc= NULL;
	}
	if (isset($_POST['r']))
	{
		$r=$_POST['r'];
	}else {
		$r= NULL;
	}
	if (isset($_POST['c1']))
	{
		$c1=$_POST['c1'];
	}else {
		$c1= NULL;
	}
	if (isset($_POST['plazo']))
	{
		$plazo=$_POST['plazo'];
	}else {
		$plazo= NULL;
	}	
		
	#si ya tenemos el Arr final lo recibimos aqui
	if (isset($_POST['arrFin']))
	{
		if($_POST['arrFin'] != NULL && $_POST['arrFin'] != '')
		{
			$permisosFin = $_POST['arrFin'];
		}
	}	
	
	 echo '<br>Número de Página: '. $page_number;
	
	if(!empty($pdf_file['name']) && $pdf_file['type']=='application/pdf' && !empty($page_number)){
		if($pdf_file["error"] > 0) {
			echo "!!!--- ERROR ---!!! " . $pdf_file["error"] . "<br />";
			echo '<br/>&nbsp;&nbsp;<input type="button" value="CERRAR" onclick="window.close();" height="75" width="161"></input><br/>';
		}
		else{
			move_uploaded_file($pdf_file['tmp_name'],$_SERVER['DOCUMENT_ROOT'] .'/conectaSQLSRV/visorArchivos/input/' . $nombreArch);
			$destination_file = basename($nombreArch, ".pdf").'.png';
			$nombreArchivo = mt_rand(1, 100).'_'.$destination_file;
			
			#Mandamos llamar la Funcion al doc pdf_to_image.php
			#$result = $pdf2image->convert_pdf_to_image($nombreArch, $page_number, $destination_file);
			$result = $pdf2image->convert_pdf_to_image($nombreArch, $page_number, $nombreArchivo, $areas, $serie, $subSerie, $tipoDocsInt, $nombreDoc, $caracterDocs,$ao, $at, $ac, $t, $l, $f, $c, $a, $dispDoc, $r, $c1, $plazo, $permisosFin, $conexion);
			if($result == 'Success'){
				#Guardamos el archivo recien creado en la BD
				$tipoDocsInt=utf8_decode($tipoDocsInt);
				$nombreDoc=utf8_decode($nombreDoc);
				$caracterDocs = utf8_decode($caracterDocs);
				$dispDoc = utf8_decode($dispDoc);
				
				$queryAddArchivo = "INSERT INTO datosdocumentos (idDocumento, areaDepto, serie, subSerie, tipoDocsIntegran, nombreDocumento, caracterDoc, ao, at, ac, t, l, f, c, a, disposicionDoc, r, c1, plazo, rutaArchivo, estatus, fechaAlta, permisos) 
				VALUES (NULL, '$areas', '$serie', '$subSerie', '$tipoDocsInt', '$nombreDoc', '$caracterDocs','$ao', '$at', '$ac', '$t', '$l', '$f', '$c', '$a', '$dispDoc', '$r', '$c1', '$plazo', 'output/$nombreArchivo', '1',NULL, '$permisosFin')";
				$result0 = mysqli_query($conexion, $queryAddArchivo);
				if(!$result0){
					echo'<span class="auto-style1">!!! ERROR AL REALIZAR INSERCIÓN DEL DOCUMENTO PROTEGIDO!!!</span>';
					echo '<br/>Query Add: '.$queryAddArchivo;
					echo'<br/><input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
					exit;
				} else {
					echo '<br/><span class="auto-style3"><strong>!!!! SE GUARDO EL DOCUMENTO PROTEGIDO CORRECTAMENTE !!!!</strong></span><br>';
					#echo '<br/>Query Add: '.$queryAddArchivo;
					echo'<br/><input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
					exit;
				}

				#echo '<br> !!! ARCHIVO PROTEGIDO CARGADO CORRECTAMENTE: !!!<br>';
				#echo '<br/>&nbsp;&nbsp;<input type="button" value="CERRAR" onclick="window.close();" height="75" width="161"></input><br/>';
				echo '<img src="output/'.$destination_file.'" alt="" />';
			}
			else{
				echo '<br> !!! ARCHIVO PROTEGIDO CARGADO CORRECTAMENTE CON MÁS DE 1 HOJA: !!!<br>';
				echo '<br/>&nbsp;&nbsp;<input type="button" value="CERRAR" onclick="window.close();" height="75" width="161"></input><br/>';
				echo $result;
			}
		}
	}
	
?>
</body>
</html>