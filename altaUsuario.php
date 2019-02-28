<?php
	require_once('conexion/configLogin.php');

	/*if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}*/
	
	if(isset($_REQUEST['addUsr']))
	{
		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		//recuperar las variables
		if (isset($_POST['nombreUsr']))
		{
			$nombreUsr = utf8_decode($_POST['nombreUsr']);
		} else {
			$nombreUsr = NULL;
		}
		if (isset($_POST['passwordUsr']))
		{
			$passwordUsr = utf8_decode($_POST['passwordUsr']);
			//$passwordUsr = strtolower($passwordUsr);
			$passwordUsr = md5($passwordUsr);
		} else {
			$passwordUsr = NULL;
		}
		if (isset($_POST['rolUsr']))
		{
			$rolUsr = $_POST['rolUsr'];
		}else{
			$rolUsr = NULL;
		}
		if (isset($_POST['rolUsr']))
		{
			$idArea = $_POST['idArea'];
		} else {
			$idArea = NULL;
		}
		
		//Revisamos que el nombre de usr no exista
		$usr = "SELECT nombreUsr FROM usuarios WHERE nombreUsr='$nombreUsr'";
		
		$usuarios = mysqli_query($conexion, $usr) or die (mysqli_error($conexion));
        $usr= mysqli_num_rows($usuarios);
		
        if($usr > 0){
        	echo'! ERROR: YA EXISTE EL NOMBRE DE USUARIO "'. $nombreUsr. '", FAVOR DE UTILIZAR OTRO !';
        } else {
			//Hacemos la sentencia de sql
			$sql = "INSERT INTO usuarios (idUsr, nombreUsr, passwordUsr, rolUsr, idArea)
					 VALUES (NULL, '$nombreUsr', '$passwordUsr', '$rolUsr', '$idArea')";
			 								   
			$result = mysqli_query($conexion, $sql);
			if(!$result){
				echo'!ERROR al realizar inserción de datos de nuevo Usuario!';
				echo $sql;
			} else {
				echo '<br/>!!!! SE INSERTARON LOS DATOS DEL USUARIO CORRECTAMENTE!!!!<br>';
				echo '<br/>Query AddUsr: '.$sql;
			}
		}
	}
	/*session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   #echo "Variable de session VACIA!!!!!";
	   //header("location: index.html"); 
	//}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>ALTA DE USUARIO</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />

<style type="text/css">
.auto-style1 {
	font-size: large;
}
</style>

</head>

<body>
	<h1> &nbsp;&nbsp; ALTA DE NUEVO USUARIO </h1>
	Favor de no utilizar caracteres especiales para nombre de Usuario y/o Contraseña: (!"#$%/()=?¡]¿}*+~¨{[-_,.;:ñáéíóú)
	<form method="post">
		<span class="auto-style1">
		<br/>
		&nbsp; Nombre de Usuario:&nbsp; </span>
		&nbsp;<input type="text" id="nombreUsr" name="nombreUsr" autocomplete="off" required style="width: 235px; height: 30px;" />
		<br/><br/>
		<span class="auto-style1">
		&nbsp; Contraseña:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		&nbsp;<input type="text" id="passwordUsr" name="passwordUsr" autocomplete="off" required style="width: 235px; height: 30px;" />
		<br/><br/>
		<span class="auto-style1">
		&nbsp; Rol:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		<select id="rolUsr" name="rolUsr" style="width:230px; height:40px" required class="auto-style1">
		        <option value="">Seleccione:</option>
		        <?php
          			$queryRoles = "SELECT idRol, nombreRol FROM roles WHERE idRol > 0";
          			$roles = mysqli_query($conexion, $queryRoles) or die (mysqli_error($conexion));
          			while ($rol = mysqli_fetch_array($roles)) {
            			echo '<option value="'.$rol[0].'">'.$rol[1].'</option>';
          			}
        		?>
		</select>
		<br/><br/>
		<span class="auto-style1">
		&nbsp; Área:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		<select id="idArea" name="idArea" style="width:330px; height:40px" required class="auto-style1">
		        <option value="">Seleccione:</option>
		        <?php
          			$queryAreas = "SELECT idArea, nombreArea FROM areas WHERE idArea > 0 ORDER BY nombreArea";
          			$areas = mysqli_query($conexion, $queryAreas) or die (mysqli_error($conexion));
          			while ($area = mysqli_fetch_array($areas)) {
            			echo '<option value="'.$area[0].'">'.utf8_encode($area[1]).'</option>';
          			}
        		?>
	</select>
	<input type="hidden" name="rol" value="<?php echo $rol ?>" />
	<br/><br/>
	<!--br/>&nbsp; NOTA: El nombre de usuario y la contraseña <strong>SIEMPRE</strong> 
		se guardan en minúsculas sin importar como son colocados
		<br/><br/-->
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="reset" class="btn btn-info" value="Limpiar Información" style="width: 168px; height: 60px" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" class="btn btn-success" name="addUsr" value="GUARDAR" style="width: 140px; height: 60px" />
	</form>
	<br/>
	<input class="btn btn-danger" name="cerrar" type="button" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" />
</body>

</html>
