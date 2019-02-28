<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/bootstrap.min.css" >
<!-- Optional theme -->
<link rel="stylesheet" href="../css/bootstrap-theme.min.css" >
<!-- Latest compiled and minified JavaScript -->
<script type="text/jscript" src="../js/bootstrap.min.js" ></script>
<script type="text/javascript">
	function enviaycierraPDF(){
		document.pdf_file.submit();
	}
	
	function enviaycierraIMG(){
		document.archivo.submit();
	}
</script>
<link rel=stylesheet href="../css/stylo.css" type="text/css">
<title>Carga de Archivo Protegido</title>
<style type="text/css">
	.auto-style1 {
		font-size: medium;
		color: #FF0000;
	}
</style>
</head>
<body >

<?php
	require_once "classes/pdf_to_image.php";
	require_once('../conexion/configLogin.php');
	
	$pdf2image = new pdf2image();
	
	$formatos=array('.jpg','.png','.JPEG','.jpeg');
	$directorio='output';
	$contArchivos=0;
	
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: ../index.html"); 
	}
	
	$arrArreas=NULL;
	if(isset ($_POST['areas'])){
		$areas= $_POST['areas'];
	} else {
		$areas= NULL;
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
	
	if (isset($_POST['permisos']))
	{
		$permisos = $_POST['permisos'];
		if($permisos == 'permisosTodas'){
			$permisos = '0';
		} else if($permisos == 'permisosArea') {
			$permisos = $areas;
		} else {
			$permisos= NULL;
		}
		#Permiso tiene un valor lo asignamos a la variable final
		if($permisos != NULL && $permisos != '')
		{
			$permisosFin = $permisos;
		}
	} else {
		$permisos= NULL;
	}
	if (isset($_POST['permisosAreas']))
	{
		if($_POST['permisosAreas'] != NULL && $_POST['permisosAreas'] != '')
		{
			$permisosAreas = $_POST['permisosAreas'];
			$arrArreas = implode("," , $permisosAreas);
			#Si llega 
			$permisosFin = $arrArreas;
		}
	}else {
		$permisosAreas = NULL;
	}
	
	#si ya tenemos el Arr final lo recibimos aqui en la 2da vuelta
	if (isset($_POST['arrFin']))
	{
		if($_POST['arrFin'] != NULL && $_POST['arrFin'] != '')
		{
			$permisosFin = $_POST['arrFin'];
		}
	}
	
	echo ' !!! LLEGO !!!<br>
				Permisos: '.$permisos.'<br>
				Permisos Areas: '.$arrArreas.'<br>
				Permisos FINAL: '.$permisosFin.'<br>';
	
	if (isset($_POST['subir'])) {
		$nombreArchivo0=$_FILES['archivo']['name'];
		$nombreArchivo=mt_rand(1, 100).'_'.$nombreArchivo0;
		$nombreTmpArchivo=$_FILES['archivo']['tmp_name'];
		$nombreArchivo=$pdf2image->scanear_string($nombreArchivo);
		$ext=substr($nombreArchivo, strrpos($nombreArchivo, '.'));
		if (in_array($ext, $formatos)) {
			if (move_uploaded_file($nombreTmpArchivo, "output/$nombreArchivo")) {
				$tipoDocsInt=utf8_decode($tipoDocsInt);
				$nombreDoc=utf8_decode($nombreDoc);
				$caracterDocs = utf8_decode($caracterDocs);
				$dispDoc = utf8_decode($dispDoc);
				
				$queryAddArchivo = "INSERT INTO datosdocumentos (idDocumento, areaDepto, serie, subSerie, tipoDocsIntegran, nombreDocumento, caracterDoc, ao, at, ac, t, l, f, c, a, disposicionDoc, r, c1, plazo, rutaArchivo, estatus, fechaAlta, permisos) 
				VALUES (NULL, '$areas', '$serie', '$subSerie', '$tipoDocsInt', '$nombreDoc', '$caracterDocs','$ao', '$at', '$ac', '$t', '$l', '$f', '$c', '$a', '$dispDoc', '$r', '$c1', '$plazo', 'output/$nombreArchivo', '1',NULL, '$permisosFin')";
				$result0 = mysqli_query($conexion, $queryAddArchivo);					
					if(!$result0){
						echo'<span class="auto-style1">!!! ERROR AL REALIZAR INSERCIÓN DEL DOCUMENTO!!!</span>';
						echo '<br/>Query Add: '.$queryAddArchivo;
						echo'<br/><input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
						exit;
					} else {
						echo '<br/><span class="auto-style3"><strong>!!!! SE GUARDO EL DOCUMENTO CORRECTAMENTE !!!!</strong></span><br>';
						echo '<br/>Query Add: '.$queryAddArchivo;
						echo'<br/><input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
						exit;
					}
				}else{
					echo "!!! ERROR AL SUBIR EL DOCUMENTO A LA CARPETA OUTPUT/BD FAVOR DE VERIFICAR CON SISTEMAS !!!";
				}
		}else{
			echo '<span class="auto-style1">!!!ERROR!!! FORMATO DE ARCHIVO NO VALIDO SOLO SE ADMITE: jpg, png, jpeg </span>';
		}
	}
?>

<center>
<div class="head">
	<form action="" method="post" enctype="multipart/form-data">
		<h1>Carga de Archivo Protegido</h1>
		<p class="auto-style1">*Solo cargar un archivo a la vez, imagen o PDF</p>
		<h1>CARGAR IMAGEN <br>
		(jpg, png)
		</h1>
		<input type="file" id="archivo" class="btn-default btn-block" name="archivo" required>
		<br>
		<input type="hidden" name="rol" value="<?php echo $rol ?>" >
		<input type="hidden" name="areas" value="<?php echo $areas ?>" >
		<input type="hidden" name="serie" value="<?php echo $serie?>" >
		<input type="hidden" name="subSerie" value="<?php echo $subSerie?>" >
		<input type="hidden" name="nombreDoc" value="<?php echo $nombreDoc?>" >
		<input type="hidden" name="tipoDocsInt" value="<?php echo $tipoDocsInt?>" >
		<input type="hidden" name="caracterDocs" value="<?php echo $caracterDocs?>" >
		<input type="hidden" name="ao" value="<?php echo $ao?>" >
		<input type="hidden" name="at" value="<?php echo $at?>" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" >
		<input type="hidden" name="t" value="<?php echo $t?>" >
		<input type="hidden" name="l" value="<?php echo $l?>" >
		<input type="hidden" name="f" value="<?php echo $f?>" >
		<input type="hidden" name="c" value="<?php echo $c?>" >
		<input type="hidden" name="a" value="<?php echo $a?>" >
		<input type="hidden" name="dispDoc" value="<?php echo $dispDoc?>" >
		<input type="hidden" name="r" value="<?php echo $r?>" >
		<input type="hidden" name="c1" value="<?php echo $c1?>" >
		<input type="hidden" name="plazo" value="<?php echo $plazo?>" >
		<input type="hidden" name="arrFin" value="<?php echo $permisosFin ?>" >
		
		<input type="submit" class="btn btn-info btn-lg btn-block" value="Subir Imagen" onclick="enviaycierraIMG();" name="subir" style="width: 158px; height: 40px">
	</form>
	<hr>
	<h1>CARGAR ARCHIVO PDF</h1>
	<form action="upload.php" method="post" enctype="multipart/form-data" target="_blank">
		<input type="file" id="pdf_file" name="pdf_file" required>
		<div class="form-group">
			<label for="page_number">Número de Pagina(Si desea todas las paginas colocar 1000 en el siguiente campo)</label>
			<input type="number" class="form-control" id="page_number" name="page_number" value="1">
			<label for="page_number">NOTA: Se generará un archivo protegido por cada hoja del archivo PDF cargado</label>
			<input type="hidden" name="rol" value="<?php echo $rol ?>" >
			<input type="hidden" name="areas" value="<?php echo $areas ?>" >
			<input type="hidden" name="serie" value="<?php echo $serie?>" >
			<input type="hidden" name="subSerie" value="<?php echo $subSerie?>" >
			<input type="hidden" name="nombreDoc" value="<?php echo $nombreDoc?>" >
			<input type="hidden" name="tipoDocsInt" value="<?php echo $tipoDocsInt?>" >
			<input type="hidden" name="caracterDocs" value="<?php echo $caracterDocs?>" >
			<input type="hidden" name="ao" value="<?php echo $ao?>" >
			<input type="hidden" name="at" value="<?php echo $at?>" >
			<input type="hidden" name="ac" value="<?php echo $ac?>" >
			<input type="hidden" name="t" value="<?php echo $t?>" >
			<input type="hidden" name="l" value="<?php echo $l?>" >
			<input type="hidden" name="f" value="<?php echo $f?>" >
			<input type="hidden" name="c" value="<?php echo $c?>" >
			<input type="hidden" name="a" value="<?php echo $a?>" >
			<input type="hidden" name="dispDoc" value="<?php echo $dispDoc?>" >
			<input type="hidden" name="r" value="<?php echo $r?>" >
			<input type="hidden" name="c1" value="<?php echo $c1?>" >
			<input type="hidden" name="plazo" value="<?php echo $plazo?>" >
			<input type="hidden" name="arrFin" value="<?php echo $permisosFin ?>" >
		
		</div>
		<input type="submit" class="btn btn-info btn-lg btn-block" value="Subir PDF" onclick="enviaycierraPDF();" name="subir" style="width: 125px; height: 40px">
	</form>
</div>
</center>
<br>
<input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >
</body>
</html>