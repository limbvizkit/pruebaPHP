<?php
	require_once('../conexion/configLogin.php');

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
	   header("location: ../index.html"); 
	}
	$valor = $_SESSION[$rol];
	
	$queryArea = "SELECT u.idArea, a.nombreArea FROM usuarios as u
				LEFT JOIN areas as a ON u.idArea=a.idArea
				WHERE u.nombreUsr = '$rol'";
				
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];
	$areaName = utf8_encode($area[1]);
	
	$fechaGet = date('Y-m-d');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>QUEJAS</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
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
			background-image: url('../img/logoNew2Agua.jpg');
		}
	</style>
</head>

<body class="styleBD">
	<div>
		<p class="auto-style1"><img src="../img/logoNew2.jpg" height="200" width="200">
		<h1 class="auto-style6"><strong>SISTEMA DE ALTA/SEGUIMIENTO DE FELICITACIONES, QUEJAS Y SUGERENCIAS (FQS)<strong></h1></p>
	<center>
	<br/>
	
	<p class="auto-style6"><span><strong>SELECCIONAR UNA OPCIÓN</strong></span></p>
	<br/><br/>
	<a class="btn btn-primary" href="formIncidencia.php?rol=<?php echo $rol; ?>" style="width: 240px; height: 40px" target="_blank"> ALTA DE FQS </a>

	<a class="btn btn-primary" style="width: 260px; height: 40px" href="consultaIncidenciaDia.php?rol=<?php echo $rol ?>&&f=<?php echo $fechaGet ?>" target="_blank">CONSULTAR FQS DEL DÍA</a>

	<a class="btn btn-primary" href="consultaIncidenciaDia.php?rol=<?php echo $rol; ?>" style="width: 230px; height: 40px" target="_blank"> QUEJAS POR RESOLVER </a>
	<br/><br/><br/>
	<hr />
	<form action="consultaIncidenciasFechas.php" method = "post" target="_blank">
		<strong><span>FQS por Fechas de Alta</span>
		<br/><br/>
		<span>DEL&nbsp; </span>
		&nbsp;<input type="date" name="fecha1" style="height: 40px" required />
		<span>&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
		<input type="date" name="fecha2" style="height: 40px" required />
		</strong>
		<br/>
		<br/>
		<input type="hidden" name="rol" value="<?php echo $rol ?>" />
		<input id="btIncidFechas" class="btn-primary" type="submit" value = "CONSULTAR" style="height: 50px; width: 200px" />
		<br/>
	</form>
		<?php if($areaFin == '15' || $areaFin == '38' || $areaFin == '5' || $areaFin == '21' || $areaFin == '0') { ?>
	<hr />
	<form action="historicoHabitacion.php" method = "post" target="_blank">
		<strong><span><br />Histórico de Incidencias por Habitación </span>
		<br/><br/>
		<span>HABITACIÓN&nbsp; </span>
		&nbsp;<input type="number" name="habitacion" style="height: 50px; width:50px" value="100" required />
		</strong>
		<br/>
		<br/>
		<input type="hidden" name="rol" value="<?php echo $rol ?>" />
		<input id="btHistHab" class="btn-primary" type="submit" value = "HISTORICO" style="height: 50px; width: 200px" />
		<br/>
	</form>
	<hr />
	<!--form action="habitaciones.php" method = "post" target="_blank">
		<strong><span><br />Estatus de las Habitaciones </span></strong>
		<br/>
		<br/>
		<input type="hidden" name="rol" value="<?php echo $rol ?>" />
		<input id="btHistHab" class="btn-primary" type="submit" value = "HABITACIONES" style="height: 50px; width: 200px" />
		<br/>
	</form-->
		<?php } ?>
	<?php
	   echo '<hr/>
				<p>
				<span><strong> OTROS SISTEMAS</strong></span>
				<br/>
				Nota: Si ingresa a otro sistema se saldrá de la pantalla actual <br /><br />';
		if( $rol == 'gdiaz' || $rol == 'jcastaneda'){
			echo '<br/><br/>
	   		<a class="btn btn-primary" href="partos/index.php?rol='.$rol.'&permisos=0" style="width: 250px; height: 40px"> PARTOS </a>';
		}
		echo '<br/><br/><br/>';
	?>

	<br/><br/><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 41px" > REGRESAR </a>
	
	<?php
		if( $valor == 'administrador'){
			echo '<input class="btn btn-danger" name="cerrar" type="button" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
		}else{
			echo '<input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >';
		}
	?>
	</p>
	</center>
</div>
</body>

</html>
