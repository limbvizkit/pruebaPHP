<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" >
  <title>Acceso Resultados Laboratorio</title>
  <!--link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script-->

<style type="text/css">
	.auto-style1 {
		text-align: center;
	}
	.auto-style3 {
		color: #FFFFFF;
		font-family: Arial, Helvetica, sans-serif;
		font-size:x-large;
	}
	.auto-style5 {
		text-align: center;
		font-size: medium;
		letter-spacing: normal;
		color: blue;
		font-family: Arial, Helvetica, sans-serif;
	}
</style>
</head>

<body background="img/logoNew2Agua.jpg">

<p class="auto-style1" align="center"><img height="300" src="img/logoNew2.jpg" width="300"></p>

<?php
	ini_set('display_errors', 'On');
	ini_set('display_errors', 1);
	header('Content-Type: text/html;charset=utf-8');
	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configLogin.php');
	
	if(isset($_REQUEST['enviar'])){
		$_SESSION['usuario'] = $_POST['usuario'];
		$_SESSION['password'] = $_POST['password'];
	}
	
	#Recibimos de index.html usr y pass 
	if(isset($_POST['usuario'])) {
		$usuario = utf8_decode($_POST['usuario']);
		$usuario=strtolower($usuario);
	}

	if(isset($_POST['password'])) {
		$passw = utf8_decode($_POST['password']);
	}
	#verificamos que existe en la tabla de usr el usr y pass colocados
	$queryLogin = 'SELECT u.rolUsr, r.permisos, u.idUsr, u.idArea
				   FROM usuarioslab AS u
				   LEFT JOIN roles AS r ON u.rolUsr=r.idRol
				   WHERE nombreUsr="'.$usuario.'" && passwordUsr="'.md5($passw).'"';
	$login = mysqli_query($conexion, $queryLogin ) or die (mysqli_error($conexion));
	$login1 = mysqli_fetch_array($login);
	#Si existe el usr y pass
	if($login1 != NULL){
		$rol = $login1 ['rolUsr'];
		$permisos = $login1 ['permisos'];
		$idUsr = $login1 ['idUsr'];
		$idArea = $login1 ['idArea'];
		
		#verificamos que rol tiene el usuario
		switch ($rol){
			#Si es 1 es SuperAdmin
			case '1':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '1')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
	    		
	    		$_SESSION[$usuario]="administrador";
				header('Location: vistaAdmin_NEW.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
			break;
			#Si es 2 es Medico, Aunque este rol es para cualquiera que quiera ver los documentos
			case '2': //Add un usuario "Consultador" de formatos de Disp. Doc.
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '2')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }

				$_SESSION[$usuario]="medico";
				header('Location: visorArchivos/visorArchivos.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
			break;
			#Si es 3 es para JEFE de Farmacia Clinica
			case '3':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '3')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
				$_SESSION[$usuario]="farmaciaClinica";
				header('Location: vistaFarmacia.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
			break;
			#Si es 4 es para Jefe De Area
			case '4':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '3')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
			    
				$_SESSION[$usuario]="jefeArea";
				header('Location: visorArchivos/indexNew.php?rol='.$usuario.'&permisos='.$permisos.'&incidencia=y');
				exit();
			break;
			#Si es 5 ayudante de Farmacia Clínica
			case '5':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '5')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
			    
				$_SESSION[$usuario]="ayudanteFarmaciaClinica";
				header('Location: vistaFarmacia.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
				break;
			#Si es 6 AtencionClientes
			case '6':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '6')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
			    $_SESSION[$usuario]="altaIncidencias";
				header('Location: vistaAtencionClnt.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
				break;
			    #Si es 7 Resguardos
			case '7':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '7')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
			    $_SESSION[$usuario]="altaResguardo";
				header('Location: resguardos.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
				break;
				#si es 8 es Alta de Quirofano
			case '8':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '8')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
			    $_SESSION[$usuario]="altaQuirofano";
				header('Location: quirofano/index.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
				break;
			#Si es 9 es para Asistente/Auxiliar Cred y Cobranz
			case '9':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '1')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
				$_SESSION[$usuario]="auxiliarAsistenteCreditoCobranza";
				header('Location: visorArchivos/indexNew.php?rol='.$usuario.'&permisos='.$permisos.'&incidencia=n');
				exit();
				break;
			#Si es 10 es para Epidemiologia
			case '10':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '11')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
				$_SESSION[$usuario]="epidemiologia";
				header('Location: epidemiologia/index.php?rol='.$usuario.'&permisos='.$permisos);
				exit();
				break;
				#Si es 11 es para CONSULTA MEDICA
			case '11':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '9')";
			    $queryAL= mysqli_query($conexion, $queryAudLog);
			    if(!$queryAL){
			    	echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
				$_SESSION[$usuario]="consultaMedica";
				header('Location: medico/index.php?rol='.$usuario.'&permisos=3');
				exit();
				break;

			//usuario de Triage
			case '12':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '10')";
				$queryAL= mysqli_query($conexion, $queryAudLog);
				if(!$queryAL){
					echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
					#echo $sql;
				} else {
					echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
					#echo $sql;
				}
				$_SESSION[$usuario]="consultaMedica";
				header('Location: medico/index.php?rol='.$usuario.'&permisos');
				exit();
				break;
			//usuario de Triage
			case '13':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '12')";
				$queryAL= mysqli_query($conexion, $queryAudLog);
				if(!$queryAL){
					echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
					#echo $sql;
				} else {
					echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
					#echo $sql;
				}
				$_SESSION[$usuario]="eventosAdversos";
				header('Location: eventosAdversos/index.php?rol='.$usuario.'&permisos');
				exit();
				break;
				//usuario de Triage
			case '14':
				session_name($usuario);
				session_start();
				$idSesion = session_id();
				$queryAudLog = "INSERT INTO auditorialogin (idLogin, idUsuario, fechaHoraIngreso, sesionId, idSistema)
						VALUES (NULL, '$idUsr', CURRENT_TIMESTAMP, '$idSesion', '13')";
				$queryAL= mysqli_query($conexion, $queryAudLog);
				if(!$queryAL){
					echo "<br/><span style='color:red'> !!!NO SE GUARDO REGISTRO PARA AUDITORIA LOGIN!!! <br/>";
					#echo $sql;
				} else {
					echo "<br/><span style='color:green'> REGISTRO PARA AUDITORIA LOGIN GUARDADO CORRECTAMENTE </span><br/>";
					#echo $sql;
				}
				$_SESSION[$usuario]="laboratorio";
				header('Location: visorEstudios.php?rol='.$usuario.'&permisos');
				exit();
				break;
		#Si Por alguna razón ingresa con usr valido pero no tiene Rol sale lo siguiente
		default:
		echo '<p class="auto-style5" align="center">BIENVENIDO(A) <br>
		<span>AL PARECER NO TIENE UN ROL ASIGANDO, FAVOR DE INFORMAR A SISTEMAS</span><br><br>
		<input type="button" value="SALIR" onClick=location.href="javascript:history.back(-1)" style="width: 137px; height: 44px"></p>
		</body></html>';
		break;
		}
		#No existe el usr y pass o estan mal escritos
	} else {
	    echo '<p class="auto-style5" align="center">!!!ERROR!!! NOMBRE DE USUARIO O PASSWORD INCORRECTO <br><br>';
	    echo "<input type='button' value='VOLVER' onClick=location.href='javascript:history.back(-1);' style='width: 137px; height: 44px'></p>
	    </body></html>";
	    mysqli_close($conexion);
	}
?>