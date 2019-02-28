<html>
	<head>
		<title>Cancelar Parto</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous" />
	</head>
	<body background="../../img/logoFondodeaguaHenrinuevo.jpg">
<?php 
	
	require('conexion.php');
	require('../../conexion/configLogin.php');
	
	if (isset($_GET['id']))
	{
		$id=$_GET['id'];
	}
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}

	if(isset($_REQUEST['cancelar']))
	{
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
		}
		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		if (isset($_POST['usrAutoriza']))
		{
			$usrAutoriza=utf8_decode($_POST['usrAutoriza']);
		}
		
		$query2="DELETE FROM programaparto WHERE idCirugia='$id'";
		$resultado2=$mysqli->query($query2);
		
		if($resultado2 > 0){
			//Si se elimino la programación entonces cambiamos el estatus a la cirugia a CANCELADA
			//$query="DELETE FROM datosnuevos WHERE id='$id'";	
			$query="UPDATE datosnuevosparto SET estatusCirugia='4' WHERE id='$id'";	
			$resultado=$mysqli->query($query);
			if($resultado > 0){
				echo "<h1> Se Cancelo El Parto </h1>";
				//Nombre de usr que cancela la cirugia
				$queryExtr="UPDATE extrasparto SET usrCancela='$rol', usrAutoriza='$usrAutoriza', observaciones='$observaciones' WHERE idCirugia='$id'";	
				$resultadoExt=$mysqli->query($queryExtr);
				if($resultadoExt > 0){
					echo "<h2> Se agregó dato Extra correctamente </h2>";
				} else {
					printf("Error: %s\n", $mysqli->error);
					echo "<h2> !Error! al agregar Dato Extra </h2>";
				}
			} else {
				printf("Error: %s\n", $mysqli->error);
				echo "<h3> !Error! al Cancelar el Parto </h3>";
			}
			echo "<h1> Se Elimino Registro de Programa Parto </h1>";
		}else{ 
			printf("!Error!: %s\n", $mysqli->error);
			echo "<h1> !Error! al Eliminar Registro de Programa Parto </h1>";
		}
		echo '<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>';
		exit;
	}

?>

		<div align="center"><img alt="logoHD" src="logo.jpg"></div>
		<center>
			<form method="post">
				<h1>Cancelar PARTO</h1>
				<p><strong>Favor de llenar los siguientes campos</strong></p>
				<br>
				<p><strong>Observaciones/Motivo de la cancelación*</strong></p>
				<textarea name="observaciones" id="observaciones" cols="80" rows="3" required></textarea>
				<br>
				<p><strong>Nombre de Usuario o Persona que autoriza*</strong></p>
				<!--input type="text" name="usrAutoriza" style="width: 350px; height: 40px" required-->
				
				<select class="form-control" id="usrAutoriza" name="usrAutoriza" style="width:430px; height:40px" required >
				    <option value="">Seleccionar</option>
					<?php
					$queryUsrAut = "SELECT u.nombreUsr, du.nombre
								FROM usuarios AS u
								LEFT JOIN datosusuario AS du ON u.idUsr=du.idUsuario
								WHERE u.idArea=15 AND NOT ISNULL(du.nombre)";
					$result0 = mysqli_query($conexion, $queryUsrAut) or die (mysqli_error($conexion));
					while($row = mysqli_fetch_array($result0)) {
					?>
						<option value="<?php echo $row['nombreUsr'].' '.$row['nombre']?>"> <?php echo $row['nombre']?> </option>
					<?php }	?>
				</select>
				<br>
				<br>
				<input type="hidden" name="id" value="<?php echo $id ?>" >
				<input type="hidden" name="rol" value="<?php echo $rol ?>" >
				<input type="submit" name="cancelar" class="btn btn-primary" value="ACEPTAR" >
				<br >
			</form>
			<p></p>
			<a class="btn btn-danger" href="javascript:history.back()">Regresar</a>
		</center>
	</body>
</html>