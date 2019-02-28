<?php
	require_once('conexion/configLogin.php');
	
	$_SESSION = array();

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	} else {
		echo "!!!!!NO LLEGO ROOOL!!!!!";
		#header("location: index.html");
	}
	session_name($rol);
	session_start();
	$idSesion = session_id();
	/* comprobamos que un usuario registrado es el que accede al archivo, 
	sino no tendría sentido que pasara por este archivo */
	if (!isset($_SESSION[$rol])) 
	{
	    header("location: index.html"); 
	}
	
	#Guardamos el cierre de sesion para auditoria
	#verificamos que existe en la tabla de usr el usr colocado
	$queryLogin = 'SELECT u.rolUsr, r.permisos, u.idUsr
				   FROM usuarios AS u
				   LEFT JOIN roles AS r ON u.rolUsr=r.idRol
				   WHERE nombreUsr="'.$rol.'"';
	$login = mysqli_query($conexion, $queryLogin ) or die (mysqli_error($conexion));
	$login1 = mysqli_fetch_array($login);
	#Si existe el usr
	if($login1 != NULL){
		#$rol = $login1 ['rolUsr'];
		#$permisos = $login1 ['permisos'];
		$idUsr = $login1 ['idUsr'];
		
		$queryAudCerr = "INSERT INTO auditoriacerrarsesion (idCerrarSesion, idUsuario, fechaHoraSalida, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '1')";
	    $queryASC= mysqli_query($conexion, $queryAudCerr);
	    if(!$queryASC){
	    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA CERRAR SESION!!! <br/>";
	    	echo $queryAudCerr;
	    } else {
	    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA CERRAR SESION, GUARDADO CORRECTAMENTE </span><br/>";
	    	#echo $queryAudCerr;
	    }
	}
	
	/* usamos la función session_unset() para liberar la variable 
	de sesión que se encuentra registrada*/
	#session_unset($_SESSION[$rol]);
	
	#Con esto eliminamos el id sesion para matar bien muerta la sesion x_x
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"] );
	}
	
	// Destruye la información de la sesión
	session_destroy();
	 
	//volvemos a la página principal
	header("location: index.html");

?>