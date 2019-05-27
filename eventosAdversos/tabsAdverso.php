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
	//GET
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['permisos']))
	{
		$permisos=$_GET['permisos'];
	}
	//POST
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	if (isset($_POST['permisos']))
	{
		$permisos=$_POST['permisos'];
	}

	if (isset($_POST['expediente']))
	{
		$expediente=$_POST['expediente'];
	}
	if (isset($_POST['folio']))
	{
		$folio=$_POST['folio'];
	}

	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	#El arreglo esta vacio 
    if (empty($resultado[0])) {
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
			<title>Formulario Farmacia</title>
			<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
			<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
			<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
			</head>
			<body><strong>NO EXISTEN DATOS PARA EL EXPEDIENTE COLOCADO</strong> <br><br>';
		echo '&nbsp;&nbsp;<input type="image" src="img/reg.png" value="REGRESAR" onclick=location.href="javascript:history.back(-1);" height="75" width="161">
		<table style="width: 100%">
		</body></html>';
		exit();
    } else { #El arreglo NO esta vacio, asignamos una variables a los valores recibidos
	    $nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	    $expediente_pac = trim($resultado[0][0]['NO_EXP_PAC']);
	    $folio_pac = $resultado[0][0]['FOLIO_PAC'];
	    $edad_pac = $resultado[0][0]['EDAD_PAC'];
   	    $sexo_pac = $resultado[0][0]['SEXO_PAC'];
		if($sexo_pac == 'M'){
			$sexo_pac='MASCULINO';
		} else {
			$sexo_pac='FEMENINO';
		}
   	    $diag_ingreso_pac = $resultado[0][0]['MOTIV_ING_PAC'];
		$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];
   	    $nombre_med = $resultado[0][0]['DESC_MEDICO'];
   	    $especialidad_med = $resultado[0][0]['DESC_ESPEC'];
   	    if($cuarto == NULL || trim($cuarto) == '') {
	   	    $cuarto = $resultado[0][0]['CVE_CUARTO'];
		}
	    $date = $resultado[0][0]['FEC_ING_PAC']; //HR_ING_PAC
	    $fecha_ing_pac = $date->format('d/m/Y');
	    $hrI = $resultado[0][0]['HR_ING_PAC'];
	    $hrsI = $hrI->format('H');
   	    $minI = $hrI->format('i');
	    $hrIngreso = $hrsI.':'.$minI;
		if($resultado[0][0]['FEC_SAL']!= NULL && $resultado[0][0]['FEC_SAL'] !='' ){
		    $date1 = $resultado[0][0]['FEC_SAL'];
		    $fecha_sal_pac = $date1->format('d/m/Y');
		    
			#Vamos a sacar los dias que estuvo el paciente en hospitalización
			$datetime1 = date_create($date->format('Y-m-d'));
			$datetime2 = date_create($date1->format('Y-m-d'));
			$interval = date_diff($datetime1, $datetime2);
			$intervalo = $interval->format('%a día(s)');
	    } else {
	    	$fecha_sal_pac = NULL;
			$intervalo = '';
	    }
	    if($fechaEgresoPac == NULL || $fechaEgresoPac == '' || $fechaEgresoPac='0000-00-00'){
	    	$fechaEgresoPac= $fecha_sal_pac;
	    }
	    
	    $date2 = $resultado[0][0]['NACIO_PA'];
	    $fecha_nac_pac = $date2->format('d/m/Y');
	    $dia_nac_pac = $date2->format(' d ');
	    $mes_nac_pac = $date2->format(' m ');
	    $anio_nac_pac = $date2->format(' Y ');
		
		//$fecha_nac_pac_otro = $date2->format('Y/m/d');
		//$cumpleAn = new DateTime($fecha_nac_pac_otro);
		$hoy = new DateTime();
		$anniosO = $hoy->diff($date2);
		//$annios = $annios->y;
		$annios = $anniosO->format('%y Año(s)');
		$anniosBool = $anniosO->format('%y');
		if($anniosBool == '0'){
			$annios = $anniosO->format('%m Mes(es)');
		}
		
		#Direccion del paciente
		$calle_pac = $resultado[0][0]['DIR_PAC'];
		$col_pac = $resultado[0][0]['COL_PAC'];
		$ciudad_pac = $resultado[0][0]['CD_PAC'];
		$cp_pac = $resultado[0][0]['CP_PAC'];
		$obligado_pac = $resultado[0][0]['OBLI_PAC'];
		$tel_pac = $resultado[0][0]['TEL_PAC'];
		$compa_pac = $resultado[0][0]['DATO_OPCIONAL8_PAC'];
	}
	/*$excel="EXPEDIENTE: ".$expediente_pac." FOLIO: ".$folio_pac." PACIENTE: ".$nombre_pac."\n FECHA INICIO\tNOMBRE\tDOSIS\tVÍA DE ADMON.\tFRECUENCIA\tDÍA CONSUMO\tHR. CONSUMO\tTIPO DE MEDICAMENTO\n";*/
	#$medicinas[] = $usuario1->medicamento();
	$expediente=trim($expediente);
	$queryAdverso = 'SELECT * FROM eventoadverso WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac.' AND estatus=1' ;
                $nota = mysqli_query($conexionMedico, $queryAdverso) or die (mysqli_error($conexion));
                $rowN = mysqli_fetch_array($nota);
	$desc=null;
	if($rowN!= NULL){
    	$desc = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE NOTIFICACIÓN DE EVENTOS ADVERSOS</span>";
	}

?>

<!DOCTYPE html>
<!-- saved from url=(0062)http://voky.com.ua/showcase/sky-tabs/examples/scheme-blue.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				
		<title>EVENTOS ADVERSOS</title>
		
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
				<img alt="logoHD" height="100" width="108" src="../img/logoNew2.jpg" /> NOTIFICACIONES </h1>
		</div>
		<div class="body">
			<!-- tabs -->
			<div class="sky-tabs sky-tabs-pos-top-left sky-tabs-anim-flip sky-tabs-response-to-icons">
				<input type="radio" name="sky-tabs" checked="" id="sky-tab1" class="sky-tab-content-1">
				<label for="sky-tab1"><span><span><i class="fa fa-folder-open-o"></i>DATOS PACIENTE</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab2" class="sky-tab-content-2">
				<label for="sky-tab2"><span><span><i class="fa fa-exclamation-circle"></i>NOTIFICACIÓN EVENTOS ADVERSOS</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab3" class="sky-tab-content-3">
				<label for="sky-tab3"><span><span><i class="fa fa-ambulance"></i>NOTA...</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab4" class="sky-tab-content-4">
				<label for="sky-tab4"><span><span><i class="fa fa-tablet"></i>NOTA...</span></span></label>
				
				<ul>
					<li class="sky-tab-content-1">
						<div class="typography">
							<h1>DATOS GENERALES DEL PACIENTE</h1>
							<br/>
							<p>
								<strong> NÚMERO DE EXPEDIENTE:&nbsp; </strong><?php echo $expediente_pac ?>
								<strong>&nbsp;&nbsp;NÚMERO DE FOLIO:&nbsp; </strong><?php echo $folio_pac ?>
							</p>
							<p>
								<strong> NOMBRE DEL PACIENTE:&nbsp;</strong> <?php echo utf8_encode($nombre_pac) ?>&nbsp;&nbsp;
								<strong> FECHA DE NACIMIENTO:&nbsp;</strong><?php echo $fecha_nac_pac ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<strong> SEXO:&nbsp;&nbsp;</strong><?php echo $sexo_pac ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<strong> EDAD:&nbsp;&nbsp;</strong><?php echo $annios ?> &nbsp;&nbsp;&nbsp;&nbsp;
								<br/>
								<strong> PROCEDE:&nbsp;&nbsp;</strong><?php echo $obligado_pac ?>  &nbsp;&nbsp;&nbsp;&nbsp;
								<strong> DOMICILIO:&nbsp;&nbsp;</strong><?php echo $calle_pac .' Col. '.$col_pac.' '.$cp_pac.' '.$ciudad_pac ?> &nbsp;&nbsp;&nbsp;&nbsp;
								<strong> TEL:&nbsp;&nbsp;</strong><?php echo $tel_pac ?> &nbsp;&nbsp;&nbsp;&nbsp;
								<br/>
								<br/>
								<strong> PERSONA QUE LO ACOMPAÑA:&nbsp;&nbsp;</strong><?php echo $compa_pac ?> &nbsp;&nbsp;&nbsp;&nbsp;
							</p>
							<p>
								<strong> FECHA DE INGRESO:&nbsp;</strong> <?php echo $fecha_ing_pac ?> &nbsp;&nbsp;&nbsp;&nbsp;
								<strong> HORA DE INGRESO:&nbsp;</strong> <?php echo $hrIngreso.' Hrs' ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<strong> FECHA EGRESO:&nbsp;</strong> <?php echo $fechaEgresoPac ?>&nbsp;&nbsp;&nbsp;&nbsp;
							</p>
						</div>
					</li>
					<li class="sky-tab-content-2">
						<div class="typography">
							<h1>NOTIFICACIÓN DE EVENTOS ADVERSOS</h1>
							<h2><?php #echo $desc ?></h2>
							<p>
								<input type="button" value="AGREGAR NOTIFICACIÓN" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('eventoAdverso.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
							</p>
							<?php if($rol=='administrador'){ ?>
							<p>
								<input type="button" value="Generar PDF DE EVENTO ADVERSO" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=adverso', '_blank').focus()"/>
								<input type="button" value="MODIFICAR DATOS" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaAdversos.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
							<?php } ?>
						</div>
					</li>
				
					<li class="sky-tab-content-3">
						<div class="typography">
							<h1>NOTA...</h1>
							<p>Proximamente</p>
						</div>
					</li>
					
					<li class="sky-tab-content-4">
						<div class="typography">
							<h1>NOTA...</h1>
							<p>Proximamente</p>
						</div>
					</li>
				</ul>
			</div>
			<!--/ tabs -->
			
		</div>
		&nbsp;&nbsp;<input type="image" src="img/regresa.png" value="REGRESAR" onclick=location.href="../eventosAdversos/index.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" height="90" width="160"/>
</body>
</html>