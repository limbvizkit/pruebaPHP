<?php 
	$x=NULL;
	$y=NULL;
	$usuario=NULL;

	if(isset($_GET['x'])) {
		$x = $_GET['x'];
	}
	if(isset($_GET['y'])) {
		$y = $_GET['y'];
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>EVENTOS</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body class="left-sidebar">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<div id="header" class="container">

						<!-- Logo -->
					<h1 id="logo">
					<a href="indexDentro.php?x=<?php echo $usuario ?>">Inicio</a>
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
									<li><a href="#">VACACIONES</a></li>
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
			</div>

			<!-- Main -->
				<div class="wrapper">
					<div class="container" id="main">
						<div class="row 150%">
							<div class="4u 12u(narrower)">

								<!-- Sidebar -->
									<section id="sidebar">
										<section>
											<header>
												<h3>COMUNICADOS</h3>
											</header>
											<p>LOS COMUNICADOS PARA EL PERSONAL.</p>
											<ul class="actions">
												<li><a href="no-sidebar.php?x=<?php echo $usuario ?>" class="button">Ver más...</a></li>
											</ul>
										</section>
										<section>
											<a href="#" class="image featured"><img src="images/vacaciones.jpg" alt="" /></a>
											<header>
												<h3>VACACIONES</h3>
											</header>
											<p>Agenda tus vacaciones...</p>
											<ul class="actions">
												<li><a href="right-sidebar.php?x=<?php echo $usuario ?>" class="button">VACACIONES</a></li>
											</ul>
									</section>
							</div>
							<div class="8u 12u(narrower) important(narrower)">

								<!-- Content -->
									<article id="content">
										<header>
											<h2>EVENTOS</h2>
											<p>Calendario de eventos.</p>
										</header>
										<iframe src="https://calendar.google.com/calendar/embed?src=henridunant.rh%40gmail.com&ctz=America%2FMexico_City" style="border: 0" width="800" height="600" frameborder="0" scrolling="no">
										</iframe>
										<a href="#" class="image featured"><img src="images/evento.jpg" alt="" /></a>
										<p>Ut sed tortor luctus, gravida nibh eget, volutpat odio. Proin rhoncus, sapien
										mollis luctus hendrerit, orci dui viverra metus, et cursus nulla mi sed elit. Vestibulum
										condimentum, mauris a mattis vestibulum, urna mauris cursus lorem, eu fringilla lacus
										ante non est. Nullam vitae feugiat libero, eu consequat sem. Proin tincidunt neque
										eros. Duis faucibus blandit ligula, mollis commodo risus sodales at. Sed rutrum et
										turpis vel blandit. Nullam ornare congue massa, at commodo nunc venenatis varius.
										Praesent mollis nisi at vestibulum aliquet. Sed sagittis congue urna ac consectetur.</p>
										<p>Mauris eleifend eleifend felis aliquet ornare. Vestibulum porta velit at elementum
										gravida nibh eget, volutpat odio. Proin rhoncus, sapien
										mollis luctus hendrerit, orci dui viverra metus, et cursus nulla mi sed elit. Vestibulum
										condimentum, mauris a mattis vestibulum, urna mauris cursus lorem, eu fringilla lacus
										ante non est. Nullam vitae feugiat libero, eu consequat sem. Proin tincidunt neque
										eros. Duis faucibus blandit ligula, mollis commodo risus sodales at. Sed rutrum et
										turpis vel blandit. Nullam ornare congue massa, at commodo nunc venenatis varius.
										Praesent mollis nisi at vestibulum aliquet. Sed sagittis congue urna ac consectetur.</p>
										<p>Vestibulum pellentesque posuere lorem non aliquam. Mauris eleifend eleifend
										felis aliquet ornare. Vestibulum porta velit at elementum elementum.</p>
									</article>
							</div>
						</div>
						<div class="row features">
							<section class="4u 12u(narrower) feature">
								<div class="image-wrapper first">
									<a href="#" class="image featured"><img src="images/curso1.jpg" alt="" /></a>
								</div>
								<header>
									<h3>EVENTO 1</h3>
								</header>
								<p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
								vel sem sit dolor neque semper magna lorem ipsum.</p>
								<ul class="actions">
									<li><a href="#" class="button">CURSO</a></li>
								</ul>
							</section>
							<section class="4u 12u(narrower) feature">
								<div class="image-wrapper">
									<a href="#" class="image featured"><img src="images/curso2.jpg" alt="" /></a>
								</div>
								<header>
									<h3>EVENTO 2</h3>
								</header>
								<p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
								vel sem sit dolor neque semper magna lorem ipsum.</p>
								<ul class="actions">
									<li><a href="#" class="button">ASAMBLEA</a></li>
								</ul>
							</section>
							<section class="4u 12u(narrower) feature">
								<div class="image-wrapper">
									<a href="#" class="image featured"><img src="images/curso3.jpg" alt="" height="205" width="200" /></a>
								</div>
								<header>
									<h3>EVENTO 3</h3>
								</header>
								<p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
								vel sem sit dolor neque semper magna lorem ipsum.</p>
								<ul class="actions">
									<li><a href="#" class="button">CARRERA</a></li>
								</ul>
							</section>
						</div>
					</div>
				</div>

			<!-- Footer -->
				<div id="footer-wrapper">
					<div id="footer" class="container">
						<header class="major">
							<h2>CONTACTO</h2>
							<p>Sí tiene alguna duda o sugerencia sobre este portal de Intranet<br>
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
										<li class="icon fa-dribbble"><a href="#"><span class="extra">dribbble.com/</span>untitled</a></li>
									</ul>
									<ul class="divided icons 6u 12u(mobile)">
										<li class="icon fa-instagram"><a href="#"><span class="extra">instagram.com/</span>untitled</a></li>
										<li class="icon fa-youtube"><a href="#"><span class="extra">youtube.com/</span>untitled</a></li>
										<li class="icon fa-pinterest"><a href="#"><span class="extra">pinterest.com/</span>untitled</a></li>
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

			<script type="text/javascript" src="assets/js/jquery.min.js"></script>
			<script type="text/javascript" src="assets/js/jquery.dropotron.min.js"></script>
			<script type="text/javascript" src="assets/js/skel.min.js"></script>
			<script type="text/javascript" src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script type="text/javascript" src="assets/js/main.js"></script>
			
	</body>
</html>