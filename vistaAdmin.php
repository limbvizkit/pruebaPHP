<?php

	$rol=NULL;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['permisos']))
	{
		$permisos=$_GET['permisos'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   #echo "Variable de session VACIA!!!!!";
	   header("location: index.html"); 
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>vista Admin</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<style type="text/css">
		.auto-style1 {
			text-align: center;
		}
		.auto-style6 {
			text-align: center;
			font-size: medium;
			letter-spacing: normal;
			color: #0000FF;
			font-family: Arial, Helvetica, sans-serif;
		}
		.styleBD {
			background-image: url('img/logoFondodeaguaHenrinuevo.jpg');
		}
	</style>
</head>

	<body class="styleBD">
	<div>
	<br/>
	<p class="auto-style1"><img alt="logo" height="300" src="img/logoNew2.jpg" width="300"/></p>
	<p class="auto-style6"><strong>BIENVENIDO(A) <br/>
	</strong>
	<span> <strong>SELECCIONAR LA PAGINA QUE DESEA VISITAR</strong></span>
	<br/><br/><br/>
	<?php if($rol=='admin'){ ?>
		<a class="btn btn-primary" href="altaUsuario.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> ALTA DE USUARIO </a>
		<br/><br/><br/><br/>
	<?php } ?>
	<a class="btn btn-primary" href="visorArchivos/index.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> CARGA DE ARCHIVOS INTERNOS</a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="visorArchivos/visorArchivos.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> VISOR DE ARCHIVOS INTERNOS</a>
	<!--input class="btn btn-primary" id="cbm" type="button" value="CUADRO BÁSICO DE MEDICAMENTOS" onclick="window.open('visorArchivos/plantillaPDF.php?pdf=CBM2017.jpg&pdf1=N','ventana','width=1300,height=700,menubar=NO,location=NO,titlebar=NO,status=NO');"return="false" style="width: 282px; height: 40px" /-->
	<br/><br/><br/>
	<a class="btn btn-primary" href="visorArchivos/indexNew.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> CARGA DE ARCHIVOS DISP. DOC. </a>
	<!--br/><br/><br/>
	<a class="btn btn-primary" href="visorArchivos/plantillaPDF.php?pdf=CBM2017.jpg&pdf1=N" style="width: 282px; height: 40px" target="_blank"> CUADRO BÁSICO DE MEDICAMENTOS </a-->
	<br/><br/><br/>
	<a class="btn btn-primary" href="visorArchivos/visorArchivosNew.php?rol=<?php echo $rol; ?>" style="width: 220px; height: 40px" target="_blank"> VISOR DE DATOS DISP. DOC. </a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="vistaFarmacia.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" style="width: 250px; height: 40px" target="_blank"> FORMULARIO FARMACIA CLÍNICA </a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="Resguardos.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> RESGUARDOS </a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="vistaAtencionClnt.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> INCIDENCIAS </a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="quirofano/eliminar/index.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> QUIRÓFANO </a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="medico/index.php?rol=<?php echo $rol; ?>&permisos=1" style="width: 250px; height: 40px" target="_blank"> TRIAGE</a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="medico/index.php?rol=<?php echo $rol; ?>&permisos=3" style="width: 250px; height: 40px" target="_blank">CONSULTA MÉDICA</a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="partos/index.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> PARTOS</a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="epidemiologia/index.php?rol=<?php echo $rol; ?>&permisos=1" style="width: 250px; height: 40px" target="_blank"> EPIDEMIOLOGÍA</a>
	<br/><br/><br/><br/>
	<a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 60px" > REGRESAR </a> <a class="btn btn-danger" href="terminarSesion.php?rol=<?php echo $rol; ?>" style="width: 140px; height: 60px" > SALIR </a>
	</p>
	</div>
</body>

</html>
