<html>
	<head>
		<title>Paciente</title>
	</head>
	<body>
		
		<center><h1>Nuevo Paciente</h1></center>

		<form name="nuevo_paciente" method="POST" action="guarda_usuario.php">
			<table width="50%">
				<tr>
					<td width="20"><b>ID</b></td>
					<td width="30"><input type="text" name="id" size="25" /></td>
				</tr>
				<tr>
					<td width="20"><b>Fecha</b></td>
					<td width="30"><input type="text" name="fecha" size="25" /></td>
				</tr>
				<tr>
					<td><b>Hora</b></td>
					<td><input type="text" name="hora" size="25" /></td>
				</tr>
				<tr>
					<td><b>Nombre</b></td>
					<td><input type="text" name="nombre" size="25" /></td>
				</tr>
				<tr>
					<td><b>Cirugía</b></td>
					<td><input type="text" name="cirugia" size="25" /></td>
				</tr>
				<tr>
					<td><b>Cirujano</b></td>
					<td><input type="text" name="cirujano" size="25" /></td>
				</tr>
				<tr>
					<td><b>Anestesiologo</b></td>
					<td><input type="text" name="anestesiologo" size="25" /></td>
				</tr>
				<tr>
					<td colspan="2"><center><input type="submit" name="eviar" value="Registrar" /></center></td>
				</tr>
			</table>
		</form>
	</body>
</html>						