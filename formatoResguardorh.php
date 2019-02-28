<?php
 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía al inicio en el caso de no poseer autorización */
	   header("location: index.html"); 
	}
	$valor = $_SESSION[$rol];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Formato Resguardo</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />

<style type="text/css">
	.auto-style1 {
		border: 2px solid #000000;
		margin:0 auto;
	}
	.auto-style2 {
		text-align: center;
	}
	.auto-style3 {
		font-family: Arial, Helvetica, sans-serif;
		text-align: center;
	}
	.img_sup {
		float:left;
		width:109px;
	}
	.auto-style5 {
		font-family: Arial, Helvetica, sans-serif;
	}
	.auto-style6 {
		margin: 10px 150px;
	}
	.styleBD {
		background-image: url('img/logoNew2Agua.jpg');
	}
</style>
</head>

<body class="styleBD">
	<div class="auto-style2">
		<p class="img_sup">
			<img alt="logo" height="130" src="img/logoNew2.jpg" width="130" class="auto-style6" style="float: left"/>
		</p>
	</div>
	<div class="auto-style3">
		<p>&nbsp;</p>
		<p><strong>
			HOSPITAL HENRI DUNANT, A.C.
			<br/>
			ACTA ALTA Y ENTREGA DE ACTIVOS FIJOS, EQUIPO MENOR Y/O HERRAMIENTAS DE TRABAJO
			</strong>
		</p>
		<br/>
		<span><strong>APLICA:</strong>Cuando el activo fijo, equipo menor y herramienta de trabajo es <u><strong>nuevo o usado</strong></u> y se 
			<br/>ha inventariado, identificándose dentro de un área especificada.
		</span>
		<br/>
		<br/>
	</div>
	<br/>
	<form method="post" action="pdf/creaPDF1rh.php" >
	<div class="auto-style5">
		<table class="auto-style1" style="width: 60%">
			<tr>
				<td> 
					&nbsp;&nbsp;&nbsp; 
					FECHA:&nbsp;<input type="date" id="fecha" name="fecha" style="height: 30px" class="auto-style3" required/> 
					<br/>
					<br/>
					&nbsp;&nbsp;
					ÁREA DE UBICACIÓN DE LOS BIENES: 
					<input type="text" id="area" name="area" style="width: 426px; height: 30px;" required/>
					<br/>
					<br/>
					<span class="auto-style3">&nbsp;&nbsp; ENTREGA: </span> 
					<input type="text" id="entrega" name="entrega" style="width: 639px; height: 30px;" required/>
					<br/>
					<br/>
					<span class="auto-style3">&nbsp;&nbsp; RECÍBE: </span> 
					<input type="text" id="recibe" name="recibe" style="width: 661px; height: 30px;" required/> 
				</td>
			</tr>
		</table>
	</div>
	
	<br/>
		<div class="auto-style3">
			<span>Quien ocupa el cargo de 
			<input type="text" id="cargo" name="cargo" style="width: 270px" required/> y que como responsable adquiere el
			<br/> compromiso de informar cualquier tipo de novedad que suceda con dicho (s) activo (s), como
			<br/> daño, necesidad de mantenimiento preventivo, movimiento a otra oficina, punto o persona; al
			<br/> responsable de los Activos Fijos.</span><br/>
			<br/>
			OBSERVACIONES: <textarea name="observ" id="observaciones" rows="3" style="width: 602px"></textarea>
			<br/>
			<br/>
			<br/>
			<br/>
		</div>
			<div class="text-center">
				<!--a class="btn btn-info" href="addMaterial.php?fecha" style="width: 140px; height: 60px" target="_blank"> Agregar Material </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
				<input class="btn btn-info" name="addMaterial" type="submit" value="Agregar Material" style="height: 60px; width: 166px" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<!--input class="btn btn-success" name="generapdf" type="submit" value="GENERAR PDF" style="height: 60px; width: 166px" /-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
			<br/>
		</div>
	</form>
	</body>
</html>