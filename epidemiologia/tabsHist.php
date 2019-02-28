<?php
  	header('Content-Type: text/html;charset=utf-8');

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
	   // Nos envía a la siguiente dirección en el caso de no poseer autorización 
	   header("location: ../index.html");
	}
?>

<!DOCTYPE html>
<!-- saved from url=(0062)http://voky.com.ua/showcase/sky-tabs/examples/scheme-blue.html -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				
		<title>EPIDEMIOLOGÍA</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		
		<link rel="stylesheet" href="./tabs_files/demo.css">
		<link rel="stylesheet" href="./tabs_files/font-awesome.css">
		<link rel="stylesheet" href="./tabs_files/sky-tabs.css">
		<link rel="stylesheet" href="./tabs_files/sky-tabs-blue.css">
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<!--[if lt IE 9]>
			<link rel="stylesheet" href="css/sky-tabs-ie8.css">
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script src="js/sky-tabs-ie8.js"></script>
		<![endif]-->
	</head>
	
	<body class="bg-blue">
		<div>
			<h1>				
				<img alt="logoHD" height="100" width="108" src="../img/logoNew2.jpg" />
				<strong style="color: beige"> DATOS HISTÓRICOS </strong>
			</h1>
		</div>
		<div class="body">
			<!-- tabs -->
			<div class="sky-tabs sky-tabs-pos-left sky-tabs-anim-flip sky-tabs-response-to-icons">
				<!--input type="radio" name="sky-tabs" checked="" id="sky-tab1" class="sky-tab-content-1">
				<label for="sky-tab1"><span><span><i class="fa fa-folder-open-o"></i>Datos Paciente</span></span></label-->
				
				<input type="radio" name="sky-tabs" checked="" id="sky-tab2" class="sky-tab-content-2">
				<label for="sky-tab2"><span><span><i class="fa fa-eye"></i>Vigilancia y Capacitación</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab3" class="sky-tab-content-3">
				<label for="sky-tab3"><span><span><i class="fa fa-heart"></i>Accesos Vasculares Centrales</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab4" class="sky-tab-content-4">
				<label for="sky-tab4"><span><span><i class="fa fa-heart-o"></i>Accesos Vasculares Periféricos</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab5" class="sky-tab-content-5">
				<label for="sky-tab5"><span><span><i class="fa fa-cog"></i>Ventilación Mecánica</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab6" class="sky-tab-content-6">
				<label for="sky-tab6"><span><span><i class="fa fa-user-md"></i>Sitios Quirúrgicos</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab7" class="sky-tab-content-7">
				<label for="sky-tab7"><span><span><i class="fa fa-stethoscope"></i>Sonda Vesical</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab8" class="sky-tab-content-8">
				<label for="sky-tab8"><span><span><i class="fa fa-bar-chart-o"></i>Temperatura</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab9" class="sky-tab-content-9">
				<label for="sky-tab9"><span><span><i class="fa fa-question-circle"></i>Otras Infecciones</span></span></label>
				
				<!--input type="radio" name="sky-tabs" id="sky-tab8" class="sky-tab-content-8">
				<label for="sky-tab8"><span><span><i class="fa fa-hand-o-up"></i>Correcta Higiene de Manos</span></span></label-->
				
				<ul>
					<li class="sky-tab-content-2">
						<div class="typography">
							<h1>VIGILANCIA Y CAPACITACIÓN</h1>
							<p>
								<form action="excel.php" method = "post">
									<br>									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="form-group">
                    			    	<label>HISTÓRICO EN EXCEL : <span>*</span></label>
										<br>
										<br>
                                    	&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
										&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
										<br>
										<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
										<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
                                	</div>
									
									<br/>
									<br/>
									<input type="hidden" name="nombre" value="VigilanciaYcapacitacion" />
									&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
									<br/>
								</form>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-3">
						<div class="typography">
							<h1>VERIFICACIÓN EN LA INSERCIÓN DE LÍNEAS VASCULARES CENTRALES</h1>
							<table>
								<tr>
									<th>
									<p>
										<form action="excel.php" method = "post">
											<br>									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="form-group">
												<label>HISTÓRICO DE INSTALACIONES EN EXCEL : <span>*</span></label>
												<br>
												<br>
												&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
												&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
												<br>
												<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
												<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
											</div>
											<br/>
											<br/>
											<input type="hidden" name="nombre" value="LineasVascularesCentralesInstHist" />
											&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL INSTALACIONES" style="height: 50px; width: 303px" />
											<br/>
										</form>
									</p>
								</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>
							<!--p>
								<form action="excel.php" method = "post">
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="form-group">
                    			    	<label>HISTÓRICO DE MANTENIMIENTOS EN EXCEL : <span>*</span></label>
										<br>
										<br>
                                    	&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
										&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
										<br>
										<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
										<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
                                	</div>
									<br/>
									<br/>
									<input type="hidden" name="nombre" value="AccesosVascPerMantoHist" />
									&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL MANTENIMIENTOS" style="height: 50px; width: 303px" />
									<br/>
								</form>
							</p-->
							</th>
						</tr>
						</table>
						</div>
					</li>
					
					<li class="sky-tab-content-4">
						<div class="typography">
							<h1>ACCESOS VASCULARES PERIFÉRICOS</h1>
							<table>
								<tr>
									<th>
									<p>
										<form action="excel.php" method = "post">
											<br>									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="form-group">
												<label>HISTÓRICO DE INSTALACIONES EN EXCEL : <span>*</span></label>
												<br>
												<br>
												&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
												&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
												<br>
												<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
												<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
											</div>
											<br/>
											<br/>
											<input type="hidden" name="nombre" value="AccesosVascPerInstHist" />
											&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL INSTALACIONES" style="height: 50px; width: 303px" />
											<br/>
										</form>
									</p>
								</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>
							<p>
								<form action="excel.php" method = "post">
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="form-group">
                    			    	<label>HISTÓRICO DE MANTENIMIENTOS EN EXCEL : <span>*</span></label>
										<br>
										<br>
                                    	&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
										&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
										<br>
										<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
										<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
                                	</div>
									<br/>
									<br/>
									<input type="hidden" name="nombre" value="AccesosVascPerMantoHist" />
									&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL MANTENIMIENTOS" style="height: 50px; width: 303px" />
									<br/>
								</form>
							</p>
							</th>
						</tr>
						</table>
						</div>
					</li>
					
					<li class="sky-tab-content-5">
						<div class="typography">
							<h1>VENTILACIÓN MECÁNICA</h1>
							<table>
								<tr>
									<th>
									<p>
										<form action="excel.php" method = "post">
											<br>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="form-group">
												<label>HISTÓRICO DE INSTALACIONES EN EXCEL : <span>*</span></label>
												<br>
												<br>
												&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
												&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
												<br>
												<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
												<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
											</div>
											<br/>
											<br/>
											<input type="hidden" name="nombre" value="VentilacionMecanicaInstHist" />
											&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL INSTALACIONES" style="height: 50px; width: 303px" />
											<br/>
										</form>
									</p>
								</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>
							<p>
								<form action="excel.php" method = "post">
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="form-group">
                    			    	<label>HISTÓRICO DE MANTENIMIENTOS EN EXCEL : <span>*</span></label>
										<br>
										<br>
                                    	&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
										&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
										<br>
										<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
										<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
                                	</div>
									<br/>
									<br/>
									<input type="hidden" name="nombre" value="VentilacionMecanicaMantoHist" />
									&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL MANTENIMIENTOS" style="height: 50px; width: 303px" />
									<br/>
								</form>
							</p>
							</th>
						</tr>
						</table>
						</div>
					</li>
					
					<li class="sky-tab-content-6">
						<div class="typography">
							<h1>SITIOS QUIRÚRGICOS</h1>
							<table>
								<tr>
									<th>
									<p>
										<form action="excel.php" method = "post">
											<br>									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="form-group">
												<label>HISTÓRICO EN EXCEL : <span>*</span></label>
												<br>
												<br>
												&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
												&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
												<br>
												<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
												<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
											</div>
											<br/>
											<br/>
											<input type="hidden" name="nombre" value="SitiosQuirurgInstHist" />
											&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL SITIOS QUIRÚRGICOS" style="height: 50px; width: 303px" />
											<br/>
										</form>
									</p>
								</th>
						</tr>
						</table>
						</div>
					</li>
					
					<li class="sky-tab-content-7">
						<div class="typography">
							<h1>SONDA VESICAL</h1>
							<table>
								<tr>
									<th>
									<p>
										<form action="excel.php" method = "post">
											<br>									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="form-group">
												<label>HISTÓRICO DE INSTALACIONES EN EXCEL : <span>*</span></label>
												<br>
												<br>
												&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
												&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
												<br>
												<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
												<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
											</div>
											<br/>
											<br/>
											<input type="hidden" name="nombre" value="sondaVesicalInstHist" />
											&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL INSTALACIONES" style="height: 50px; width: 303px" />
											<br/>
										</form>
									</p>
								</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>
							<p>
								<form action="excel.php" method = "post">
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="form-group">
                    			    	<label>HISTÓRICO DE MANTENIMIENTOS EN EXCEL : <span>*</span></label>
										<br>
										<br>
                                    	&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
										&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
										<br>
										<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
										<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
                                	</div>
									<br/>
									<br/>
									<input type="hidden" name="nombre" value="sondaVesicalMantoHist" />
									&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL MANTENIMIENTOS" style="height: 50px; width: 303px" />
									<br/>
								</form>
							</p>
							</th>
						</tr>
						</table>
						</div>
					</li>
					
					<li class="sky-tab-content-8">
						<div class="typography">
							<h1>TEMPERATURA</h1>
							<p>
								<form action="excel.php" method = "post">
									<br>									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="form-group">
                    			    	<label>HISTÓRICO EN EXCEL : <span>*</span></label>
										<br>
										<br>
                                    	&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
										&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
										<br>
										<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
										<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
                                	</div>
									<br/>
									<br/>
									<input type="hidden" name="nombre" value="MedicionesTemperatura" />
									&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
									<br/>
								</form>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-9">
						<div class="typography">
							<h1>VIGILANCIA DE OTRAS INFECCIONES ASOCIADAS A LA ATENCIÓN DE LA SALUD</h1>
							<p>
								<form action="excel.php" method = "post">
									<br>									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="form-group">
                    			    	<label>HISTÓRICO EN EXCEL : <span>*</span></label>
										<br>
										<br>
                                    	&nbsp;&nbsp;<span class="">DEL&nbsp; </span>
										&nbsp;<input type="date" name="fecha1" style="height: 50px; width: 303px" class="form-control" required/>
										<br>
										<span >&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
										<input type="date" name="fecha2" style="height: 50px; width: 303px" class="form-control"required />
                                	</div>
									<br/>
									<br/>
									<input type="hidden" name="nombre" value="OtrasInfecciones" />
									&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
									<br/>
								</form>
							</p>
						</div>
					</li>
				</ul>
			</div>
			<!--/ tabs -->
		</div>
		<br>
		&nbsp;&nbsp;<input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 200px; height: 61px" />
</body>
</html>