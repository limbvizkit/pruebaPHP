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
		<title>CAPACITACIÓN</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--link href="css/bootstrap.min.css" rel="stylesheet" media="screen"-->
		
		<style type="text/css">
			body {
				padding-top: 0px;
			}
			#carousel {
				margin: 0 auto;
				width: 400px;
				height: 390px;
				padding: 0;
				overflow: scroll;
				border: 2px solid #999;
			}
			#carousel ul {
				list-style: none;
				width: 1500px;
				margin: 0;
				padding: 0;
				position: relative;
			}
			#carousel li {
				display: inline;
				float: left;
			}
			.textholder {
				text-align: left;
				font-size: small;
				padding: 6px;
				-moz-border-radius: 6px 6px 0 0;
				-webkit-border-top-left-radius: 6px;
				-webkit-border-top-right-radius: 6px;
			}
			 .fullscreen-bg__video {
			  position: absolute;
			  top: 1;
			  right: 1;
			  width: 30%;
			  height: 30%;
			}
		</style>
	</head>
	<body class="no-sidebar">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<div id="header" class="container">

						<!-- Logo -->
					<h1 id="logo">
					<a href="indexDentro.php?x=<?php echo $x?>&&y=<?php echo $y ?>">Inicio</a>
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
							<li><a href="#">CAPACITACIÓN</a></li>
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

						<!-- Content -->
							<article id="content">
								<header>
									<h2>CAPACITACIÓN</h2>
									<p>Cursos de capacitación/inducción.</p>
									<div id="vid">
									<video width="55%" id="reproductor" controls></video>
									<br>
									<label  id="info" style="visibility: hidden;"></label>
									</br>
								</div>
								</header>
								<!--a href="#" class="image featured"><img src="img/1280x768-A.JPG" alt="" /></a-->
								<p>Nos hemos consolidado como el mejor Hospital privado del Estado y el único que se ha mantenido en el proceso de certificación y re certificación ante el Consejo de Salubridad General.</p>
								<p>Nuestro compromiso es ofrecer servicios de calidad, confort y confianza, en forma oportuna y eficiente.</p>
								<p>Por ello, hemos ampliado y renovado nuestras instalaciones, invertido en equipamiento de alta tecnología e incrementado nuestros servicios con una sola finalidad: Mantenernos en una constante innovación para satisfacer las nuevas demandas de nuestros pacientes.</p>
							</article>
					<iframe src="https://docs.google.com/presentation/d/e/2PACX-1vTtOyhHvQ11K48qQp5wQ00N5gOK2aGPk1IGwztsxmVGMuD_5rsLIhZs2X-VBWT7PboVTx_VEAaRB3hd/embed?start=false&loop=false&delayms=15000" frameborder="0" width="960" height="749" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>

						<div class="row features">
							<section class="4u 12u(narrower) feature">
								<div class="image-wrapper first">
									<a href="https://www.extendoffice.com/es/documents/excel/5013-excel-populate-outlook-calendar.html" class="image featured" target="_blank"><img src="images/outlook.jpg" alt="" /></a>
								</div>
								<header>
									<h3>Outlook</h3>
								</header>
								<p>Importar/Exportar agendas, contactos y más...</p>
								<ul class="actions">
									<li><a href="https://www.extendoffice.com/es/documents/excel/5013-excel-populate-outlook-calendar.html" target="_blank"class="button">Ver más...</a></li>
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
			<script type="text/javascript" src="js/bootstrap.min.js"></script>
			<script type="text/javascript" src="assets/js/jquery.dropotron.min.js"></script>
			<script type="text/javascript" src="assets/js/skel.min.js"></script>
			<script type="text/javascript" src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script type="text/javascript" src="assets/js/main.js"></script>

			<script type="text/javascript" src="js/jquery.infinitecarousel.js"></script>
			<script type="text/javascript">
			$(function(){
				$('#carousel').infiniteCarousel({
					displayTime: 6000,
					textholderHeight : .25
				});
			});
				window.onload = function playlist(){
					var reproductor = document.getElementById("reproductor"),
					videos = ["new"],
					info = document.getElementById("info");

					info.innerHTML = "Vídeo: " + videos[0];
					reproductor.src = videos[0] + ".mp4";
					reproductor.play();

					reproductor.addEventListener("ended", function() {
						var nombreActual = info.innerHTML.split(": ")[1];
						var actual = videos.indexOf(nombreActual);
						this.src = (actual == videos.length - 1 ? videos[0] : videos[actual + 1]) + ".mp4";
						info.innerHTML = "Vídeo: " + videos[actual + 1];
						this.play();
					}, false);
			}
			</script>
	</body>
</html>