<?php
	$directorio='output';
	$contArchivos=0;
	 	
 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: index.html"); 
	}
	$valor = $_SESSION[$rol];
?>
<!DOCTYPE html>
<html>
<head>
<title>visorArchivos</title>
<style type="text/css">
	.styleBD {
		background-image: url('img/1280x768-A.JPG');
	}
</style>
<link rel=stylesheet href="../css/stylo.css" type="text/css">
</head>

<body class="styleBD" >
<center>
<div class="h">
	<div class="head">
		<h1>ARCHIVOS EXISTENTES</h1>
	</div>
	<br>
	<?php 
	if ($dir=opendir($directorio)) {
		while ($archiv = readdir($dir)) {
			if ($archiv!='.'&& $archiv!='..') {
				$contArchivos++;
				echo 'ARCHIVO: <strong>'.substr($archiv, 0, strpos($archiv,".")).'</strong><br/>';
				echo '<input class="btn btn-success" id="btnLab" type="button" value="ABRIR" onclick="window.open(\'plantillaPDF.php?pdf='.$archiv.'&pdf1=N\',\'ventana\',\'width=1400,height=1000,scrollbars=YES,menubar=NO,resizable=NO,titlebar=NO,status=NO\');"return="false" style="width: 125px; height: 40px"/><br/><br>';
			}
		}
		echo "Total de archivos: <strong> $contArchivos </strong> <br><br>";
		#echo '<input class="btn btn-success" id="btnLab" type="button" value="LASA2017.png" onclick="window.open(\'plantillaPDF.php?pdf=LASA2017.png&pdf1=N\',\'ventana\',\'width=1400,height=800,scrollbars=NO,menubar=NO,resizable=NO,titlebar=NO,status=NO\');"return="false" style="width: 225px; height: 40px"/><br/>';
	}
	if( $valor == 'administrador'){
		echo '<input class="btn btn-danger" name="cerrar" type="button" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
	}else{
		echo '<input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >';
	}
	?>
</div>
</center>
</body>
</html>