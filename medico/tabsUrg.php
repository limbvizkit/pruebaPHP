<?php
  	header('Content-Type: text/html;charset=utf-8');
  	#Archivo con la conexion para MYSQL
  	require_once('../conexion/config.php');
	require_once('../conexion/configMedico.php');
  	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../conexion/funciones_db.php');
	
	$cuarto=NULL;
  	$fechaEgresoPac=NULL;
	$ingresaPac=NULL;
	$alergiasPac=NULL;
	$pesoPac=NULL;
	$tallaPac=NULL;
	$conciliacionPac=NULL;
	$traeMedicamentoPac=NULL;
	$imcPac = NULL;
	$diagEgr = NULL;

	$casa=NULL;
	$cultivo=NULL;
	$diagnosticoPac=NULL;
	$concomitantesPac=NULL;
	$expediente = NULL;
	$folio = NULL;
	$idMed = NULL;
	$frecuencia=NULL;
	$tipoMed=NULL;
	$viadmon=NULL;
	$dosis=NULL;
	$fechaInicio=NULL;
	$cadcero=NULL;
	$dateD=NULL;
	$hrD=NULL;
	
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['permisos']))
	{
		$permisos=$_GET['permisos'];
	}

?>

<!DOCTYPE html>
<!-- saved from url=(0062)http://voky.com.ua/showcase/sky-tabs/examples/scheme-blue.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				
		<title>URGENCIAS</title>
		
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
			<h1 style="color: aliceblue">
				<img alt="logoHD" height="100" width="108" src="../img/logoNew2.jpg" /> URGENCIAS </h1>
		</div>
		<div class="body">
			<!-- tabs -->
			<div class="sky-tabs sky-tabs-pos-top-left sky-tabs-anim-flip sky-tabs-response-to-icons">
				<input type="radio" name="sky-tabs" checked="" id="sky-tab1" class="sky-tab-content-1">
				<label for="sky-tab1"><span><span><i class="fa fa-th-list"></i>HOJA DE INDICACIONES MÉDICAS</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab2" class="sky-tab-content-2">
				<label for="sky-tab2"><span><span><i class="fa fa-ambulance"></i>NOTA DE URGENCIAS Y CHOQUE</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab2" class="sky-tab-content-2">
				<label for="sky-tab3"><span><span><i class="fa fa-exclamation-triangle"></i>NOTA...</span></span></label>
				
				<ul>
					<li class="sky-tab-content-1">
						<div class="typography">
							<h1>HOJA DE INDICACIONES MÉDICAS</h1>
							<p>
								<input type="button" value="Agregar Indicaciones" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('indicacionesMedicas.php?rol=<?php echo $rol ?>', '_blank').focus()" />
							</p>
							<p>
								<input type="button" value="CONSULTAR HISTÓRICO" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaIndicMed.php?rol=<?php echo $rol ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
				
					<li class="sky-tab-content-2">
						<div class="typography">
							<h1>NOTA DE URGENCIAS Y CHOQUE</h1>
							<p>
								<input type="button" value="Agregar Nota" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('notaUrgenciasCH.php?rol=<?php echo $rol ?>', '_blank').focus()" />
							</p>
							<p>
								<input type="button" value="CONSULTAR HISTÓRICO" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaNotaUrgCh.php?rol=<?php echo $rol ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-3">
						<div class="typography">
							<h1>NOTA...</h1>
							<p>Proximamente</p>
						</div>
					</li>
				</ul>
			</div>
			<!--/ tabs -->
			
		</div>
		&nbsp;&nbsp;<input type="image" src="img/regresa.png" value="REGRESAR" onclick=location.href="../medico/index.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" height="90" width="160"/>
</body>
</html>