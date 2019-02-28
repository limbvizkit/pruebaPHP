<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Habitaciones</title>
<!--link rel="stylesheet" href="css/bootstrap.min.css" /-->
<title>Incidencias Fechas</title>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
<script type="text/javascript" src="js/datatables.min.js"></script>

<script type="text/jscript" src="js/bootstrap.min.js" >	</script>
<link rel="stylesheet" href="css/tabAz.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />

<style type="text/css">
.auto-style1 {
	text-align: center;
	font-size: medium;
}
</style>

</head>

<?php
	setlocale(LC_ALL,'');
	date_default_timezone_set("America/Mexico_City");
	require_once('conexion/configLogin.php');
	
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
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
	
	$queryArea = "SELECT u.idArea, a.nombreArea FROM usuarios as u
				LEFT JOIN areas as a ON u.idArea=a.idArea
				WHERE u.nombreUsr = '$rol'";
				
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];
	$areaName = utf8_encode($area[1]);
	$fechaGet = date('d/m/Y');
	
	#query de habitaciones con incidencias sin cerrar (Habitaciones 'ocupadas')
	$queryHabOcup = "SELECT h1.idHabitacion
					FROM habitaciones AS h1
					LEFT JOIN incidencias AS i1 ON i1.idHabitacion=h1.idHabitacion
					WHERE NOT ISNULL(fechaAlta) && ISNULL(fechaSolucion)
					ORDER BY numeroHabitacion";

	$HabOcu = mysqli_query($conexion, $queryHabOcup) or die (mysqli_error($conexion));
	#$row0 = mysqli_fetch_array($HabOcu);
	
	$rows=array();
	while($row0 = mysqli_fetch_array($HabOcu)){
		$rows[] = $row0[0];
	}
	
	/*foreach($rows as $rowo){
		echo "IDHab: $rowo[0] <br /> \n";
	}
	echo "Tamaño del arreglo: ".count($rows);*/
	
	 mysqli_free_result($HabOcu);
?>

<body style="background-image: url(img/logoNew2Agua.jpg)">
	<br/>
	<h1><strong><span style="font-size:large">&nbsp;&nbsp; Estatus de las Habitaciones <br /> &nbsp;&nbsp;<?php echo $fechaGet ?></span></strong></h1>
	<br/>
		<hr/>
		<div class="datagrid">
		<table id="simple1">
		<thead>
         <tr>
			<th class="text-center" style="width: 98px">&nbsp;ID.&nbsp;</th>
			<th class="text-center" style="width: 230px">&nbsp;NÚMERO DE HABITACIÓN&nbsp;</th>
			<th class="text-center">&nbsp;TIPO DE HABITACIÓN&nbsp;</th>
			<th class="text-center">&nbsp;ESTATUS DE HABITACIÓN&nbsp;</th>
		 </tr>
     	</thead>
      	<tbody>
			<?php
				$queryHistHab = "SELECT idHabitacion, numeroHabitacion, tipoHabitacion
									FROM habitaciones
									WHERE idHabitacion > 0
									ORDER BY idHabitacion";
			$idHistHab = mysqli_query($conexion, $queryHistHab) or die (mysqli_error($conexion));
			$c = 1;
			while($row = mysqli_fetch_array($idHistHab)){
				if($c%2==0){
					$clas = 'class="alt"';
				} else {
					$clas = '';
				}
				
				if (in_array($row[0], $rows)) {
					$color='red';
				} else {
					$color='';	
				}
	 						
				?>
					<tr <?php echo $clas ?> >
						<!--td><?php echo $c++ ?></td-->
						<td class="auto-style1" style="width: 98px; color:<?php echo $color ?>"><?php echo $row[0] ?></td>
						<td class="auto-style1" style="width: 230px; color:<?php echo $color ?>"><a href="historicoHabitacion.php?rol=<?php echo $rol ?>&&habitacion=<?php echo $row[1]?>"> <?php echo $row[1] ?> </a></td>
						<td class="auto-style1" style="color:<?php echo $color ?>"> <?php echo utf8_encode($row[2]) ?></td>
						<td class="auto-style1" style="color:<?php echo $color ?>">
							<?php
								if (in_array($row[0], $rows)) {
									echo " HABITACIÓN OCUPADA/INCIDENCIA";
								} else {
									echo " HABITACIÓN LIBRE";	
								}
	 						?>
						</td>
					</tr>
		<?php } ?>
		</tbody>
		</table></div>
		
		<br/> <br/>
		 <input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
		 <br/>

</body>

</html>
