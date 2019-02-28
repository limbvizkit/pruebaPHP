<?php 
	
	require('conexion.php');
	
	$id=$_POST['id'];
	$fecha=$_POST['fecha'];
	$hora=$_POST['hora'];
	$nombre=$_POST['nombre'];
	$cirugia=$_POST['cirugia'];
	$cirujano=$_POST['cirujano'];
	$anestesiologo=$_POST['anestesiologo'];
	
	$query="INSERT INTO datos (id, fecha, hora, nombre, cirugia, cirujano. anestesiologo) VALUES ('$id','$fecha','$hora','$nombre' ,'$cirugia' ,'$cirujano' ,'$anestesiologo')";
	
	$resultado=$mysqli->query($query);
	
?>

<html>
	<head>
		<title>Guardar Paciente</title>
	</head>
	<body>
		<center>	
			
			<?php if($resultado>0){ ?>
				<h1>Paciente  Guardado</h1>
				<?php }else{ ?>
				<h1>Error al Guardar Paciente</h1>		
			<?php	} ?>		
			
			<p></p>	
			
			<a href="index.php">Regresar</a>
			
		</center>
	</body>
	</html>	