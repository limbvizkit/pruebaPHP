<!DOCTYPE HTML>
<html>
	<head>
		<title>Principal Intranet</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body class="homepage">
		<div id="page-wrapper">
		<!-- Header -->
				<div id="header-wrapper">
					<div id="header" class="container">

<?php
	ini_set('display_errors', 'On');
	ini_set('display_errors', 1);
	header('Content-Type: text/html;charset=utf-8');
	
	#Archivo con la conexion para MYSQL
	require_once('conexion/configLogin.php');
	
	$usuario=NULL;
	$passw=NULL;
	/*if(isset($_REQUEST['enviar']) || isset($_GET['x']) != NULL){
		#Recibimos de index.html usr y pass
		if(isset($_POST['usuario'])) {
			$usuario = $_POST['usuario'];
		}
		if(isset($_POST['password'])) {
			$passw = $_POST['password'];
		}
		
		if(isset($_GET['x'])) {
			$usuario = base64_decode($_GET['x']);
		}
		if(isset($_GET['y'])) {
			$passw =  base64_decode($_GET['y']);
		}
	
		#verificamos que existe en la tabla de usr el usr y pass colocados
		$queryLogin = 'SELECT u.rolUsr, r.permisos, u.idUsr, u.idArea
					   FROM usuarios AS u
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
			$x = base64_encode($usuario);
			$y = base64_encode($passw);
		} else {
		    echo '<section id="hero" class="container">
					<header>
					<h2>!!!ERROR!!! NOMBRE DE USUARIO O CONTRASEÑA INCORRECTA</h2>
					</header>
					<br><br>';
		    echo "<input type='button' class='button' value='VOLVER' onClick=location.href='javascript:history.back(-1);'></p>
		    </body></html>";
		    mysqli_close($conexion);
		    exit;
		}
	} else {
			echo '<section id="hero" class="container">
						<header>
						<h2>FAVOR DE INICIAR SESIÓN</h2>
						</header>
						<br><br>';
			    echo "<input type='button' class='button' value='VOLVER' onClick=location.href='javascript:history.back(-1);'></p>
			    </body></html>";
			    mysqli_close($conexion);
			    exit;
		}*/

?>
				<!-- Logo -->
					<h1 id="logo">
					<a href="#">Inicio</a>
					</h1>
				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li>
								<a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FORMATOS</a>
								<ul>
									<li><a href="#">CAMBIO DE TURNO</a></li>
									<li><a href="#">CUMPLEAÑOS</a></li>
									<li><a href="#">PASE DE SALIDA</a></li>
									<li>
										<a href="#">PERMISOS</a>
										<ul>
											<li><a href="#">SALIR TEMPRANO</a></li>
											<li><a href="#">LLEGAR TARDE</a></li>
											<li><a href="#">ASISTIR A CURSO</a></li>
										</ul>
									</li>
									<li><a href="right-sidebar.php?usr=<?php echo $usuario?>">VACACIONES</a></li>
								</ul>
							</li>
							<li><a href="rhCapacitacion.php">CAPACITACIÓN</a></li>
							<li><a href="left-sidebar.php?usr=<?php echo $usuario ?>">EVENTOS</a></li>
							<li class="break">
								<a href="right-sidebar.php?usr=<?php echo $usuario?>">VACACIONES</a>
							</li>
							<li><a href="no-sidebar.php?usr=<?php echo $usuario?>">COMUNICADOS</a></li>
							<li><a href="index.html">OTROS</a></li>
						</ul>
					</nav>
			</div>

			<!-- Hero -->
			<section id="hero" class="container">
				<h2>Bienvenido(a)<br></h2>
				<header>
				<img alt="logo1" src="img/logoNew2.jpg" height="200" width="200">
					<h2>RECURSOS HUMANOS
					<br>
					HOSPITAL <a href="http://henridunant.com" target="_blank"><strong>HENRI DUNANT</strong></a></h2>
				</header>
				<p><strong>  </strong></p>
				<!-- si queremos un boton para ingresar al intranet desde aqui -->
				<!--form method="post" action="acces.php">
					<input name="usuario" type="hidden"  value="<?php #echo $usuario ?>" >
					<input name="password" type="hidden" value="<?php #echo $passw ?>" >
					<ul class="actions">
						<li>
							<input class="button" type="submit" name="enviar" value="Sistemas Internos">
						</li>
					</ul>
				</form-->
			</section>
		</div>

	<!-- Features 1 -->
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<section class="6u 12u(narrower) feature">
						<div class="image-wrapper first">
							<a href="left-sidebar.php?x=<?php echo $usuario?>" class="image featured first"><img src="images/evento.jpg" alt="" /></a>
						</div>
						<header>
							<h2>EVENTOS</h2>
						</header>
						<p>Consulta los eventos que tendremos proximamente...</p>
						<ul class="actions">
							<li><a href="left-sidebar.php?x=<?php echo $usuario ?>" class="button">Eventos</a></li>
						</ul>
					</section>
					<section class="6u 12u(narrower) feature">
						<div class="image-wrapper">
							<a href="right-sidebar.php?x=<?php echo $usuario ?>" class="image featured"><img src="images/vacaciones2.jpg" alt="" height="345" width="200" /></a>
						</div>
						<header>
							<h2>VACACIONES</h2>
						</header>
						<p>Programa tus vacaciones y llena el formato, todo en línea...</p>
						<ul class="actions">
							<li><a href="right-sidebar.php?x=<?php echo $usuario ?>" class="button">Vacaciones</a></li>
						</ul>
					</section>
				</div>
			</div>
		</div>

	<!-- Promo -->
		<div id="promo-wrapper">
			<section id="promo">
				<h2>COMUNICADOS PARA EL PERSONAL</h2>
				<a href="no-sidebar.php?x=<?php echo $usuario ?>" class="button">CONSULTAR</a>
			</section>
		</div>

	<!-- Features 2 -->
		<!--div class="wrapper">
			<section class="container">
				<header class="major">
					<h2>Sed magna consequat lorem curabitur tempus</h2>
					<p>Elit aliquam vulputate egestas euismod nunc semper vehicula lorem blandit</p>
				</header>
				<div class="row features">
					<section class="4u 12u(narrower) feature">
						<div class="image-wrapper first">
							<a href="#" class="image featured"><img src="img/logo_2.png" alt="" /></a>
						</div>
						<p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
						vel sem sit dolor neque semper magna lorem ipsum.</p>
					</section>
					<section class="4u 12u(narrower) feature">
						<div class="image-wrapper">
							<a href="#" class="image featured"><img src="img/logo_1.png" alt="" /></a>
						</div>
						<p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
						vel sem sit dolor neque semper magna lorem ipsum.</p>
					</section>
					<section class="4u 12u(narrower) feature">
						<div class="image-wrapper">
							<a href="#" class="image featured"><img src="img/logo_3.png" alt="" /></a>
						</div>
						<p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
						vel sem sit dolor neque semper magna lorem ipsum.</p>
					</section>
				</div>
				<ul class="actions major">
					<li><a href="#" class="button">Elevate my awareness</a></li>
				</ul>
			</section>
		</div-->

	<!-- Footer -->
		<div id="footer-wrapper">
			<div id="footer" class="container">
				<header class="major">
					<h2>CONTACTO</h2>
					<p>Sí tiene alguna duda o sugerencia<br>
					Favor de enviar un mensaje.</p>
				</header>
				<div class="row">
					<section class="6u 12u(narrower)">
						<form method="post" action="#">
							<div class="row 50%">
								<div class="6u 12u(mobile)">
									<input name="name" placeholder="Nombre" type="text" />
								</div>
								<div class="6u 12u(mobile)">
									<input name="email" placeholder="E-Mail" type="text" />
								</div>
							</div>
							<div class="row 50%">
								<div class="12u">
									<textarea name="message" placeholder="Mensaje"></textarea>
								</div>
							</div>
							<div class="row 50%">
								<div class="12u">
									<ul class="actions">
										<li><input type="submit" value="Enviar Mensaje" /></li>
										<li><input type="reset" value="Limpiar Formulario" /></li>
									</ul>
								</div>
							</div>
						</form>
					</section>
					<section class="6u 12u(narrower)">
						<div class="row 0%">
							<ul class="divided icons 6u 12u(mobile)">
								<li class="icon fa-twitter"><a href="#"><span class="extra">twitter.com/</span>untitled</a></li>
								<li class="icon fa-facebook"><a href="#"><span class="extra">facebook.com/</span>untitled</a></li>
								<!--li class="icon fa-dribbble"><a href="#"><span class="extra">dribbble.com/</span>untitled</a></li-->
							</ul>
							<ul class="divided icons 6u 12u(mobile)">
								<li class="icon fa-instagram"><a href="#"><span class="extra">instagram.com/</span>untitled</a></li>
								<li class="icon fa-youtube"><a href="#"><span class="extra">youtube.com/</span>untitled</a></li>
								<!--li class="icon fa-pinterest"><a href="#"><span class="extra">pinterest.com/</span>untitled</a></li-->
							</ul>
						</div>
					</section>
				</div>
			</div>
			<div id="copyright" class="container">
				<ul class="menu">
					<li>&copy; Intranet Hospital Henri Dunant. Todos los derechos reservados.</li><li>Design: <a href="http://html5up.net">JDGF</a></li>
				</ul>
			</div>
		</div>
	</div>
		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.dropotron.min.js"></script>
		<script src="assets/js/skel.min.js"></script>
		<script src="assets/js/util.js"></script>
		<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
		<script src="assets/js/main.js"></script>

	</body>
</html>