<?php
	
	require('conexion.php');
	
	$id=$_GET['id'];
	
	$query="SELECT id, fecha, hora, nombre, cirugia, cirujano, anestesiologo FROM datos WHERE id='$id'";
	
	$resultado=$mysqli->query($query);
	
	$row=$resultado->fetch_assoc();
	
?>

<html>
	<head>
		<title>Pacientes</title>
	</head>
	<body>
		
		<center><h1>Modificar Paciente</h1></center>
		
		<form name="modificar_usuario" method="POST" action="mod_usuario.php">
			
			<table width="50%">
				<tr>
					<td><b>ID</b></td>
					<td><input type="id" name="hora" size="25" value="<?php echo $row['id']; ?>" /></td>
				</tr>
				<tr>
					<td><b>Hora</b></td>
					<td><input type="hora" name="hora" size="25" value="<?php echo $row['hora']; ?>" /></td>
				</tr>
				<tr>
					<td><b>Nombre</b></td>
					<td><input type="text" name="email" size="25" value="<?php echo $row['nombre']; ?>" /></td>
				</tr>
				<tr>
					<td><b>Cirugia</b></td>
					<td><input type="text" name="cirugia" size="25" value="<?php echo $row['cirugia']; ?>" /></td>
				</tr>
				<tr>
					<td><b>Cirujano</b></td>
					<td><input type="text" name="cirujano" size="25" value="<?php echo $row['cirujano']; ?>" /></td>
				</tr>
				<tr>
					<td><b>Anestesiologo</b></td>
					<td><input type="text" name="anestesiologo" size="25" value="<?php echo $row['anestesiologo']; ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><center><input type="submit" name="Guardar" value="Guardar" /></center></td>
				</tr>
			</table>
		</form>
	</body>
</html>	
