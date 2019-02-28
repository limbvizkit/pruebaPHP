<?php
	require "conexion.php";
	
	//recuperar las variables
	#$id=$_POST['id'];
	$fecha=$_POST['fecha'];
	$hora=$_POST['hora'];
	$nombre=$_POST['nombrePaciente'];
	$edad=$_POST['edad'];
	$diagnostico=$_POST['diagnostico'];
	$cirugia=$_POST['cirugia'];
	$instrumental=$_POST['instrumental'];
	$equipo=$_POST['equipo'];
	$descorche=$_POST['descorche'];
	$imagen=$_POST['imagen'];
	$sangre=$_POST['sangre'];
	$patologias=$_POST['patologias'];
	$cirujano=$_POST['cirujano'];
	$ayudante=$_POST['ayudante'];
	$pediatra=$_POST['pediatra'];
	$anestesiologo=$_POST['anestesiologo'];
	$proporciono=$_POST['proporciono'];
	$rol = $_POST['rol'];
	
	/*$date = date_create($fecha);
		#Le cambiamos el formato a la fecha de Y/m/d a d/m/Y
	$fecha = date_format($date, 'd-m-Y');*/
	
	//hacemos la sentencia de sql
	$sql = "INSERT INTO datosnuevosparto (id, fecha, hora, nombrePaciente, edad, diagnostico, cirugia, instrumental, equipo, descorche, imagen, 
				sangre, patologias, cirujano, ayudante, pediatra, anestesiologo, proporciono)
			 VALUES (NULL, '$fecha', '$hora', '$nombre', '$edad', '$diagnostico', '$cirugia', '$instrumental', '$equipo', '$descorche', '$imagen', 
			 			'$sangre', '$patologias',  '$cirujano', '$ayudante', '$pediatra', '$anestesiologo', '$proporciono')";
	 
	/*$sql="INSERT INTO datos VALUES('$id',
	                               '$fecha',
								   '$hora',
								   '$nombre',
								   '$cirugia',
								   '$cirujano',
								   '$anestesiologo')";*/
								   
	//ejecutamos la sentencia de sql
	if ($conn->query($sql)==true) {
		header('location:index.php?rol=$rol');
	}else{
		echo "Error:".$mysql_qry."<br>".$conn->error;
	}$conn->close();

	
?>