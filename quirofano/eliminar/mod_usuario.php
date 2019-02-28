<?php 
	
	require('conexion.php');
	
	$id=$_POST['id'];
	$fecha=$_POST['fecha'];
	$hora=$_POST['hora'];
	$nombre=$_POST['nombre'];
	$cirugia=$_POST['cirugia'];
	$cirujano=$_POST['cirujano'];
	$anestesiologo=$_POST['anestesiologo'];
	
	$query="UPDATE datos SET id='$id', fecha='$fecha', hora='$hora', nombre='$nombre', cirugia='$cirugia', cirujano='$cirujano', anestesiologo='$anestesiologo' WHERE id='$id'";
	
	$resultado=$mysqli->query($query);
	
?>

<html>
	<head>
		<title>Modificar Paciente</title>
	</head>
	
	<body>
		<center>
			
			<?php 
				if($resultado>0){
				?>
				
				<h1>Paciente Modificado</h1>
				
					<?php 	}else{ ?>
				
				<h1>Error al Modificar Paciente</h1>
				
			<?php	} ?>
			
			<p></p>	
			
			<a href="index.php">Regresar</a>
			
		</center>
	</body>
</html>
				
				