<?php

	$rol=NULL;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['permisos']))
	{
		$permisos=$_GET['permisos'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   #echo "Variable de session VACIA!!!!!";
	   header("location: index.html");
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>vista Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		
		<link rel="stylesheet" href="tabs_files/demo.css" />
		<link rel="stylesheet" href="tabs_files/font-awesome.css" />
		<link rel="stylesheet" href="tabs_files/sky-tabs.css" />
		<link rel="stylesheet" href="tabs_files/sky-tabs-blue.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
	<style type="text/css">
		.auto-style1 {
			text-align: center;
		}
		.auto-style6 {
			text-align: center;
			font-size: x-large;
			letter-spacing: normal;
			color: #020539;
			font-family: Arial, Helvetica, sans-serif;
		}
		.styleBD {
			background-image: url('img/1280x768-A.JPG');
		}
	</style>
</head>

<body class="bg-blue">
	<div>
	<p class="auto-style1"><img alt="logo" height="300" src="img/logoNew.jpg" width="900"/></p>
	<p class="auto-style6"><strong>BIENVENIDO(A) AL SISTEMA DE INTRANET 
	<br/>
	<span> SELECCIONAR UNA DE LAS SIGUIENTES CATEGORIAS: </strong></span></p>
	<div class="body">
	<!-- tabs -->
		<div class="sky-tabs sky-tabs-pos-left sky-tabs-anim-flip sky-tabs-response-to-icons">
			<?php if($rol == 'admin') { ?>
				<input type="radio" name="sky-tabs" checked="" id="sky-tab1" class="sky-tab-content-1">
				<label for="sky-tab1"><span><span><i class="fa fa-eye"></i>ADMIN</span></span></label>
			<?php } ?>
			<input type="radio" name="sky-tabs" id="sky-tab2" class="sky-tab-content-2">
			<label for="sky-tab2"><span><span><i class="fa fa-folder-open-o"></i>ARCHIVOS</span></span></label>

			<input type="radio" name="sky-tabs" id="sky-tab3" class="sky-tab-content-3">
			<label for="sky-tab3"><span><span><i class="fa fa-medkit"></i>FARMACIA CLÍNICA</span></span></label>

			<input type="radio" name="sky-tabs" id="sky-tab4" class="sky-tab-content-4">
			<label for="sky-tab4"><span><span><i class="fa fa-lock"></i>RESGUARDOS</span></span></label>

			<input type="radio" name="sky-tabs" id="sky-tab5" class="sky-tab-content-5">
			<label for="sky-tab5"><span><span><i class="fa fa-exclamation-triangle"></i>INCIDENCIAS</span></span></label>

			<input type="radio" name="sky-tabs" id="sky-tab6" class="sky-tab-content-6">
			<label for="sky-tab6"><span><span><i class="fa fa-stethoscope"></i>QUIROFANO/PARTOS</span></span></label>

			<input type="radio" name="sky-tabs" id="sky-tab7" class="sky-tab-content-7">
			<label for="sky-tab7"><span><span><i class="fa fa-user-md"></i>MÉDICOS</span></span></label>

			<input type="radio" name="sky-tabs" id="sky-tab8" class="sky-tab-content-8">
			<label for="sky-tab8"><span><span><i class="fa fa-bug"></i>EPIDEMIOLOGÍA</span></span></label>
			
			<input type="radio" name="sky-tabs" id="sky-tab9" class="sky-tab-content-9">
			<label for="sky-tab9"><span><span><i class="fa fa-flask"></i>LABORATORIO</span></span></label>

			<ul>
				<li class="sky-tab-content-1">
					<div class="typography">
						<h1>ADMINISTRADOR</h1>
						<p>
							<br/>
							<?php if($rol=='admin'){ ?>
								<a class="btn btn-default" href="altaUsuario.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> ALTA DE USUARIO </a>
								<a class="btn btn-default" href="listaUsuario.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> LISTA DE USUARIOS </a>
							<?php } ?>
							<br/>
						</p>
					</div>
				</li>

				<li class="sky-tab-content-2">
					<div class="typography">
						<h1>ARCHIVOS INTERNOS Y DISPOSICIÓN DOCUMENTAL</h1>
						<table>
							<tr>
								<th>
									<p>
									<h4>ARCHIVOS INTERNOS :</h4>
									<br><br>
									<a class="btn btn-default" href="visorArchivos/index.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> CARGA DE ARCHIVOS INTERNOS</a>
									<br><br>
									<a class="btn btn-default" href="visorArchivos/visorArchivos.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> VISOR DE ARCHIVOS INTERNOS</a>
									<br/>
									</p>
								</th>
								<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th>
									<p>											
									<h4>ARCHIVOS DISPOSICIÓN DOCUMENTAL :</h4>
									<br><br>
									<a class="btn btn-default" href="visorArchivos/indexNew.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> CARGA DE ARCHIVOS DISP. DOC. </a>
									<br/><br/>
									<a class="btn btn-default" href="visorArchivos/visorArchivosNew.php?rol=<?php echo $rol; ?>" style="width: 220px; height: 40px" target="_blank"> VISOR DE DATOS DISP. DOC. </a>
									</p>
								</th>
							</tr>
						</table>
					</div>
				</li>

				<li class="sky-tab-content-3">
					<div class="typography">
						<h1>FARMACIA CLÍNICA</h1>
						<p>
							<a class="btn btn-default" href="vistaFarmacia.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" style="width: 250px; height: 40px" target="_blank"> FORMULARIO FARMACIA CLÍNICA </a>
						</p>
					</div>
				</li>

				<li class="sky-tab-content-4">
					<div class="typography">
						<h1>RESGUARDOS</h1>
						<p>
							<a class="btn btn-default" href="Resguardos.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> RESGUARDOS </a>
							<a class="btn btn-default" href="Resguardosrh.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> RESGUARDOS RH </a>
						</p>
					</div>
				</li>

				<li class="sky-tab-content-5">
					<div class="typography">
						<h1>INCIDENCIAS ATENCIÓN A CLIENTES</h1>
						<p>
							<a class="btn btn-default" href="vistaAtencionClnt.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> INCIDENCIAS </a>
						</p>
					</div>
				</li>

				<li class="sky-tab-content-6">
					<div class="typography">
						<h1>REGISTRO DE QUIRÓFANO Y PARTOS</h1>
						<table>
							<tr>
								<th>
								<p>
								<h4>QUIRÓFANO :</h4>
									<br><br>
								<a class="btn btn-default" href="quirofano/eliminar/index.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> SISTEMA DE QUIRÓFANO </a>																			
								</p>
							</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>
								<p>
								<h4>PARTOS :</h4>
								<br><br>
								<a class="btn btn-default" href="partos/index.php?rol=<?php echo $rol; ?>" style="width: 250px; height: 40px" target="_blank"> SISTEMA DE PARTOS</a>
								</p>
							</th>
						</tr>
					</table>
					</div>
				</li>

				<li class="sky-tab-content-7">
					<div class="typography">
						<h1>MÉDICOS Y TRIAGE</h1>
						<table>
							<tr>
								<th>
									<p>
									<h4>TRIAGE :</h4>
									<br><br>
									<a class="btn btn-default" href="medico/index.php?rol=<?php echo $rol; ?>&permisos=1" style="width: 250px; height: 40px" target="_blank"> TRIAGE</a>
									</p>
								</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>
								<p>											
								<h4>MÉDICOS :</h4>
								<br><br>
								<a class="btn btn-default" href="medico/index.php?rol=<?php echo $rol; ?>&permisos=3" style="width: 250px; height: 40px" target="_blank">CONSULTA MÉDICA</a>
								<br><br>
								<a class="btn btn-default" href="eventosAdversos/index.php?rol=<?php echo $rol; ?>&permisos=3" style="width: 250px; height: 40px" target="_blank">EVENTOS ADVERSOS</a>
								</p>
							</th>
						</tr>
					</table>
					</div>
				</li>

				<li class="sky-tab-content-8">
					<div class="typography">
						<h1>EPIDEMIOLOGÍA</h1>
						<p>
							<a class="btn btn-default" href="epidemiologia/index.php?rol=<?php echo $rol; ?>&permisos=1" style="width: 250px; height: 40px" target="_blank"> SISTEMA DE EPIDEMIOLOGÍA</a>
						</p>
					</div>
				</li>
				<li class="sky-tab-content-9">
					<div class="typography">
						<h1>LABORATORIO</h1>
						<p>
							<a class="btn btn-default" href="laboratorio/adminDoc.php?rol=<?php echo $rol; ?>&permisos=1" style="width: 250px; height: 40px" target="_blank"> RESULTADOS DE LABORATORIO</a>
						</p>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<br/><br/><br/><br/>
	<a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 60px" > REGRESAR </a>
	<a class="btn btn-danger" href="terminarSesion.php?rol=<?php echo $rol; ?>" style="width: 140px; height: 60px" > SALIR </a>
	</div>
</body>

</html>
