<?php
	$rol=NULL;

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
	   #echo "Variable de session VACIA!!!!!";
	   header("location: index.html"); 
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Resguardos</title>
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
			background-image: url('img/logoNew2Agua.jpg');
		}
	</style>
</head>

<body class="styleBD">
	<div>
	<br/>
	<p class="auto-style1"><img alt="logo" height="150" src="img/logoNew.jpg" width="500b"/></p>
	<p class="auto-style6"><span><strong>SELECCIONAR UNA OPCIÓN</strong></span>
	<br/><br/><br/>
	<a class="btn btn-primary" href="formatoResguardo.php?rol=<?php echo $rol; ?>" style="width: 240px; height: 40px" target="_blank"> ALTA DE NUEVO RESGUARDO </a>
	<br/><br/><br/>
	<a class="btn btn-primary" href="buscarResguardo.php?rol=<?php echo $rol; ?>" style="width: 230px; height: 40px" target="_blank"> BUSQUEDA DE RESGUARDOS </a>
	<br/><br/><br/><br/>
	<input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
	</p>
	</div>
</body>

</html>
