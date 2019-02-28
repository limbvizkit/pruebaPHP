<?php
  	header('Content-Type: text/html;charset=utf-8');
  	#Archivo con la conexion para MYSQL
  	require_once('../conexion/config.php');
	require_once('../conexion/configEpidemio.php');
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
	$imc=NULL;
	$diagEgr=NULL;

	$casa=NULL;
	$cultivo=NULL;
	$diagnosticoPac=NULL;
	$concomitantesPac=NULL;
	$expediente = NULL;
	$folio=NULL;
	$idMed=NULL;
	$frecuencia=NULL;
	$tipoMed=NULL;
	$viadmon=NULL;
	$dosis=NULL;
	$fechaInicio=NULL;
	$cadcero=NULL;
	$dateD=NULL;
	$hrD=NULL;
	
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
	
	if(isset($_REQUEST['enviarBasicos']))
	{
		if (isset($_POST['cuarto']))
		{
			$cuarto=$_POST['cuarto'];
		}
		if (isset($_POST['nombre_pac']))
		{
			$nombre_pac=$_POST['nombre_pac'];
		}
		if (isset($_POST['fecha_nac_pac']))
		{
			$fecha_nac_pac=$_POST['fecha_nac_pac'];
		}
		if (isset($_POST['sexo_pac']))
		{
			$sexo_pac=$_POST['sexo_pac'];
		}
		if (isset($_POST['edad_pac']))
		{
			$edad_pac=$_POST['edad_pac'];
		}
		if (isset($_POST['imc']))
		{
			$imc=$_POST['imc'];
		}
		if (isset($_POST['pesoEpidio']))
		{
			$pesoEpidio=$_POST['pesoEpidio'];
		}
		if (isset($_POST['tallaEpidio']))
		{
			$tallaEpidio=$_POST['tallaEpidio'];
		}
		if (isset($_POST['nombre_med']))
		{
			$nombre_med=$_POST['nombre_med'];
		}
		if (isset($_POST['cedula_med']))
		{
			$cedula_med=$_POST['cedula_med'];
		}
		if (isset($_POST['especialidad_med']))
		{
			$especialidadMed1 = $_POST['especialidad_med'];
			$string = htmlentities($especialidadMed1, null, 'utf-8');
            $stringEM = str_replace("&nbsp;", "", $string);
		}
		if (isset($_POST['fecha_ing_pac']))
		{
			$fecha_ing_pac=$_POST['fecha_ing_pac'];
		}
		if (isset($_POST['hrIngreso']))
		{
			$hrIngreso=$_POST['hrIngreso'];
		}
		if (isset($_POST['fechaEgresoPac']))
		{
			$fechaEgresoPac=$_POST['fechaEgresoPac'];
		}
		if (isset($_POST['intervalo']))
		{
			$intervalo=$_POST['intervalo'];
		}
		if (isset($_POST['diagnosticoPac']))
		{
			$diagnosticoPac=utf8_decode($_POST['diagnosticoPac']);
		}		
		if (isset($_POST['diagEgr']))
		{
			$diagEgr=utf8_decode($_POST['diagEgr']);
		}
		
			#Verificamos si este numero de Expediente ya tiene Datos básicos
		$queryDatosBasic = "SELECT numeroExpediente, folio FROM pacienteepidio WHERE numeroExpediente = '$expediente' 
								AND (folio = 0 || folio = '$folio')";
		$idDB = mysqli_query($conexionEpidemio, $queryDatosBasic) or die (mysqli_error($conexionEpidemio));
		$idDB1 = mysqli_fetch_array($idDB);
		$idDBFin = $idDB1 ['numeroExpediente'];
		
		#Ya tiene Datos básicos entonces es actualizacion
		if($idDBFin != NULL){
			$queryUpdDB = "UPDATE pacienteepidio SET peso = '$pesoEpidio', imc='$imc', talla = '$tallaEpidio', diagnosticoIngreso = '$diagnosticoPac',
				diagnosticoEgreso='$diagEgr', usr= '$rol'
			  	WHERE numeroExpediente = '$expediente' AND (folio = 0 || folio= '$folio')";
			$result0 = mysqli_query($conexionEpidemio, $queryUpdDB) or die (mysqli_error($conexionEpidemio));
			
			if(!$result0){
				echo'! ERROR al realizar actualización de DATOS BÁSICOS!';
				echo '<br/>Query UPD: '.$queryUpdDB;
			} else {
				echo '<br/>!!!! SE ACTUALIZARON LOS DATOS BÁSICOS CORRECTAMENTE!!!!<br>';
				#echo '<br/>Query UPD: '.$queryUpdDB;
				echo '&nbsp;&nbsp;<input type="image" src="../img/reg.png" value="REGRESAR" onclick=location.href="javascript:history.back(-1)"; location.reload();" height="75" width="161"></input><table style="width: 100%">';
				exit;
			}
		} else {#No tiene datos basicos entonces es nueva insercion
			#Guardamos todos los valores recibidos en MySQL
			$queryInsrBasic = "INSERT INTO pacienteepidio (numeroExpediente, folio, habitacion, fechaIngreso, horaIngreso, fechaEgreso, dias, nombre, edad, sexo, fechaNacimiento, peso, talla, imc, medico, cedula, especialidad, diagnosticoIngreso, diagnosticoEgreso, usr) VALUES ('$expediente', '$folio', '$cuarto', '$fecha_ing_pac', '$hrIngreso', '$fechaEgresoPac', '$intervalo', '$nombre_pac', '$edad_pac', '$sexo_pac', '$fecha_nac_pac', '$pesoEpidio', '$tallaEpidio', '$imc', '$nombre_med', '$cedula_med', '$stringEM', '$diagnosticoPac', '$diagEgr', '$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryInsrBasic);
			if(!$result0) {
				echo '!<br> ERROR al realizar inserción de datos Básicos! <br>';
				echo 'QUERY: '.$queryInsrBasic;
			} else {
				echo '<br>!!!! SE GUARDARON LOS DATOS BÁSICOS CORRECTAMENTE!!!!<br>';
			}
		}
		
	}
	
	$queryBasicos = 'SELECT habitacion,fechaEgreso,peso,talla, diagnosticoIngreso, imc,diagnosticoEgreso
						 FROM pacienteepidio WHERE numeroExpediente='.'"'.$expediente.'" AND (folio = 0 || folio= '.'"'.$folio.'")';
		$idBas = mysqli_query($conexionEpidemio, $queryBasicos ) or die (mysqli_error($conexionEpidemio));
		$idbas1 = mysqli_fetch_array($idBas );
		if($idbas1 != NULL){
			$fechaEgresoPac = $idbas1 ['fechaEgreso'];
			$pesoPac = $idbas1 ['peso'];
			$tallaPac = $idbas1 ['talla'];						
			$diagnosticoPac = $idbas1 ['diagnosticoIngreso'];			
			$cuarto = $idbas1 ['habitacion'];
			$imc = $idbas1 ['imc'];
			$diagEgr = $idbas1 ['diagnosticoEgreso'];
		}


	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	#El arreglo esta vacio 
    if (empty($resultado[0])) {
    	#Obtenemos datos de MYSQL si es que existen para el expediente dado
    	$queryBasicos1 = "SELECT nombre,numeroExpediente,folio,edad,sexo,diagnostico,medico,especialidad,habitacion,fechaIngreso,
								fechaNacimiento,medicamentoCasa,imc,diagnosticoEgreso
    					  FROM pacienteepidio
						  WHERE numeroExpediente LIKE '%$expediente' AND (folio = 0 || folio= '$folio')";
		$idBas1 = mysqli_query($conexionEpidemio, $queryBasicos1) or die (mysqli_error($conexionEpidemio));
		$idbas2 = mysqli_fetch_array($idBas1);
		
		if($idbas2 != NULL) {
			$nombre_pac = utf8_decode($idbas2 ['nombre']); #tambien puede ser $idbas2[0]
		    $expediente_pac = trim($idbas2 ['numeroExpediente']);
		    $folio_pac = $idbas2 ['folio'];
		    $edad_pac = $idbas2 ['edad'];
	   	    $sexo_pac = $idbas2 ['sexo'];
	   	    $diag_ingreso_pac = $idbas2 ['diagnostico'];
	   	    $nombre_med = $idbas2 ['medico'];
	   	    $especialidad_med = $idbas2 ['especialidad'];
	   	    $cuarto = $idbas2 ['habitacion'];
	   	    $casa = $idbas2 ['medicamentoCasa'];	   	   
			$imc = $idbas2 ['imc'];
			$diagEgr = $idbas2 ['diagnosticoEgreso'];
	
		    #$date = $idbas2 ['fechaIngreso']; //HR_ING_PAC
		    #$fecha_ing_pac = $date->format('d-m-Y');
		    
		    #date_create_from_format('d-m-Y',$fecha_nac_pac)->format('Y-m-d')
		    
		    $fecha_ing_pac1 = strtotime($idbas2 ['fechaIngreso']);
		    $fecha_ing_pac = date('d-m-Y',$fecha_ing_pac1);
		    		    
		    #$date2 = $idbas2 ['fechaNacimiento'];
		    #$fecha_nac_pac = $date2->format('d-m-Y');
		    $fecha_nac_pac1 = strtotime($idbas2 ['fechaNacimiento']);
		    $fecha_nac_pac = date('d-m-Y',$fecha_nac_pac1);

		} else {
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
    	}
    } else { #El arreglo NO esta vacio, asignamos una variables a los valores recibidos
	    $nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	    $expediente_pac = trim($resultado[0][0]['NO_EXP_PAC']);
	    $folio_pac = $resultado[0][0]['FOLIO_PAC'];
	    $edad_pac = $resultado[0][0]['EDAD_PAC'];
   	    $sexo_pac = $resultado[0][0]['SEXO_PAC'];
   	    $diag_ingreso_pac = $resultado[0][0]['MOTIV_ING_PAC'];
		$cedula_med = $resultado[0][0]['CEDULA_MEDICO'];	
   	    $nombre_med = $resultado[0][0]['DESC_MEDICO'];
   	    $especialidad_med = $resultado[0][0]['DESC_ESPEC'];
   	    if($cuarto == NULL || trim($cuarto) == ''){
	   	    $cuarto = $resultado[0][0]['CVE_CUARTO'];
		}
	    $date = $resultado[0][0]['FEC_ING_PAC']; //HR_ING_PAC
	    $fecha_ing_pac = $date->format('d/m/Y');
	   /* $dia_ing_pac = $date->format(' d ');
	    $mes_ing_pac = $date->format(' m ');
	    $anio_ing_pac = $date->format(' Y ');*/
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
		
		$hoy = new DateTime();
		$anniosO = $hoy->diff($date2);
		//$annios = $annios->y;
		$annios = $anniosO->format('%y Año(s)');
		$anniosBool = $anniosO->format('%y');
		if($anniosBool == '0'){
			$annios = $anniosO->format('%m Mes(es)');
		}
	}
	/*$excel="EXPEDIENTE: ".$expediente_pac." FOLIO: ".$folio_pac." PACIENTE: ".$nombre_pac."\n FECHA INICIO\tNOMBRE\tDOSIS\tVÍA DE ADMON.\tFRECUENCIA\tDÍA CONSUMO\tHR. CONSUMO\tTIPO DE MEDICAMENTO\n";*/
	#$medicinas[] = $usuario1->medicamento();
	$expediente=trim($expediente);
	
	$queryvigcap = 'SELECT * FROM vigilanciacapacitacion WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $vigcap1 = mysqli_query($conexionEpidemio, $queryvigcap) or die (mysqli_error($conexion));
                $rowvigcap = mysqli_fetch_array($vigcap1);
	$vigcap=null;
	if($rowvigcap!= NULL){
    	$vigcap = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE VIGILANCIA Y CAPACITACIÓN</span>";
	}
 	$querylvc = 'SELECT * FROM instalacionlvc WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $lvc1 = mysqli_query($conexionEpidemio, $querylvc) or die (mysqli_error($conexion));
                $rowlvc = mysqli_fetch_array($lvc1);
	$lvc=null;
	if($rowlvc!= NULL){
    	$lvc = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE INSTALACIÓN DE LÍNEAS VASCULARES CENTRALES</span>";
	}
	$queryavp = 'SELECT * FROM instalacionavp WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $avp1 = mysqli_query($conexionEpidemio, $queryavp) or die (mysqli_error($conexion));
                $rowavp = mysqli_fetch_array($avp1);
	$queryavpM = 'SELECT * FROM mantoavp WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $avp2 = mysqli_query($conexionEpidemio, $queryavpM) or die (mysqli_error($conexion));
                $rowavpM = mysqli_fetch_array($avp2);
	$avpI=null;
	if($rowavp!= NULL){
    	$avpI = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE INSTALACIÓN DE ACCESOS VASCULARES PERIFÉRICOS</span>";
	}
	$avpM=null;
	if($rowavpM!= NULL){
    	$avpM = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE MANTENIMIENTO DE ACCESOS VASCULARES PERIFÉRICOS</span>";
	}

	$queryvm = 'SELECT * FROM instalacionvm WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $vm1 = mysqli_query($conexionEpidemio, $queryvm) or die (mysqli_error($conexion));
                $rowvm = mysqli_fetch_array($vm1);
	$queryvmM = 'SELECT * FROM mantovm WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $vm2 = mysqli_query($conexionEpidemio, $queryvmM) or die (mysqli_error($conexion));
                $rowvmM = mysqli_fetch_array($vm2);
	$vmI=null;
	if($rowvm!= NULL){
    	$vmI = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE INSTALACIÓN DE VENTILACIÓN MECÁNICA</span>";
	}
	$vmM=null;
	if($rowvmM!= NULL){
    	$vmM = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE MANTENIMIENTO DE VENTILACIÓN MECÁNICA</span>";
	}

	$querysq = 'SELECT * FROM instalacionsq WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $sq1 = mysqli_query($conexionEpidemio, $querysq) or die (mysqli_error($conexion));
                $rowsq = mysqli_fetch_array($sq1);
	$sq=null;
	if($rowsq!= NULL){
    	$sq = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE INSTALACIÓN DE SITIOS QUIRÚRGICOS</span>";
	}

	$querysv = 'SELECT * FROM instalacionsv WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $sv1 = mysqli_query($conexionEpidemio, $querysv) or die (mysqli_error($conexion));
                $rowsv = mysqli_fetch_array($sv1);
	$svI=null;
	if($rowsv!= NULL){
    	$svI = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE INSTALACIÓN DE SONDA VESICAL</span>";
	}
	$querysvM = 'SELECT * FROM mantosv WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $sv2 = mysqli_query($conexionEpidemio, $querysvM) or die (mysqli_error($conexion));
                $rowsvM = mysqli_fetch_array($sv2);
	$svM=null;
	if($rowsvM!= NULL){
    	$svM = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE MANTENIMIENTO DE SONDA VESICAL</span>";
	}
	$querysTemp = 'SELECT * FROM pacientetemperatura WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $temp2 = mysqli_query($conexionEpidemio, $querysTemp) or die (mysqli_error($conexion));
                $rowsTemp = mysqli_fetch_array($temp2);
	$temp=null;
	if($rowsTemp!= NULL){
    	$temp = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE TOMA DE TEMPERATURA</span>";
	}
	$querysOtras = 'SELECT * FROM pacienteotrasinfecciones WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac;
                $otras2 = mysqli_query($conexionEpidemio, $querysOtras) or die (mysqli_error($conexion));
                $rowsOtras = mysqli_fetch_array($otras2);
	$otras=null;
	if($rowsOtras!= NULL){
    	$otras = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE OTRAS INFECCIONES</span>";
	}

?>

<!DOCTYPE html>
<!-- saved from url=(0062)http://voky.com.ua/showcase/sky-tabs/examples/scheme-blue.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				
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
				<strong style="color: beige"> SEGUIMIENTO A FACTORES DE RIESGO </strong>
			</h1>
		</div>
		<div class="body">
			<!-- tabs -->
			<div class="sky-tabs sky-tabs-pos-top-left sky-tabs-anim-flip sky-tabs-response-to-icons">
				<input type="radio" name="sky-tabs" checked="" id="sky-tab1" class="sky-tab-content-1">
				<label for="sky-tab1"><span><span><i class="fa fa-folder-open-o"></i>Datos Paciente</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab2" class="sky-tab-content-2">
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
					<li class="sky-tab-content-1">
						<form role="form" action="" method="post">
						<div class="typography">
							<h1>DATOS GENERALES DEL PACIENTE</h1>							
							<br/>
							<p>
								<strong> NÚMERO DE EXPEDIENTE:&nbsp; </strong><?php echo $expediente_pac ?>
								<input name="expediente_pac" type="hidden" value="<?php echo $expediente_pac ?>" >
								<strong>&nbsp;&nbsp;NÚMERO DE FOLIO:&nbsp; </strong><?php echo $folio_pac ?>
								<input name="folio_pac" type="hidden" value="<?php echo $folio_pac ?>" >
								<strong>&nbsp;&nbsp;HABITACIÓN:</strong>&nbsp;<?php echo $cuarto ?>
								<input name="cuarto" type="hidden" value="<?php echo $cuarto ?>" >
							</p>
							<p>
								<strong> NOMBRE DEL PACIENTE:&nbsp;</strong> <?php echo utf8_encode($nombre_pac) ?>&nbsp;&nbsp;
								<input name="nombre_pac" type="hidden" value="<?php echo utf8_encode($nombre_pac) ?>" >
								<strong> FECHA DE NACIMIENTO:&nbsp;</strong><?php echo $fecha_nac_pac?>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="fecha_nac_pac" type="hidden" value="<?php echo date_create_from_format('d/m/Y',$fecha_nac_pac)->format('Y-m-d') ?>" />
								<strong> SEXO:&nbsp;&nbsp;</strong><?php echo $sexo_pac ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="sexo_pac" type="hidden" value="<?php echo $sexo_pac ?>" >
								<strong> EDAD:&nbsp;&nbsp;</strong><?php echo $annios ?> &nbsp;&nbsp;&nbsp;&nbsp;
								<input name="edad_pac" type="hidden" value="<?php echo $edad_pac ?>" >
								<br/>
								<strong> PESO:&nbsp;&nbsp;</strong>
								<input id="show_DiagEgr" name="pesoEpidio" style="width: 70px; height: 30px; border: ridge" type="number" min="0" step="0.01" value="<?php echo $pesoPac ?>" />Kgs.&nbsp;&nbsp;&nbsp;&nbsp;
								<strong> TALLA:&nbsp;&nbsp;</strong>
								<input id="show_DiagEgr" name="tallaEpidio" style="width: 60px; height: 30px; border: ridge" type="number" min="0" step="0.01" value="<?php echo $tallaPac ?>" />Cms.&nbsp;&nbsp;&nbsp;&nbsp;
								<strong> IMC:&nbsp;&nbsp;</strong>
								<input id="show_imc" name="imc" style="width: 80px; height: 30px; border: ridge" type="text" placeholder="Colocar IMC" maxlength="7" value="<?php echo $imc ?>" autocomplete="off"/>
							</p>
							<p>
								<strong> MEDICO TRATANTE:&nbsp;</strong> <?php echo utf8_encode($nombre_med) ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="nombre_med" type="hidden" value="<?php echo utf8_encode($nombre_med) ?>" >
								<strong> CEDULA MEDICO:&nbsp;</strong> <?php echo $cedula_med ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="cedula_med" type="hidden" value="<?php echo $cedula_med ?>" >
								<strong> ESPECIALIDAD:&nbsp;</strong> <?php echo $especialidad_med ?>
								<input name="especialidad_med" type="hidden" value="<?php echo $especialidad_med ?>" >
							</p>
							<p>
								<strong> FECHA DE INGRESO:&nbsp;</strong> <?php echo $fecha_ing_pac ?> &nbsp;&nbsp;&nbsp;&nbsp;
								<input name="fecha_ing_pac" type="hidden" value="<?php echo date_create_from_format('d/m/Y',$fecha_ing_pac)->format('Y-m-d') ?>" />
								<strong> HORA DE INGRESO:&nbsp;</strong> <?php echo $hrIngreso.' Hrs' ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="hrIngreso" type="hidden" value="<?php echo $hrIngreso ?>" >
								<strong> FECHA EGRESO:&nbsp;</strong> <?php echo $fechaEgresoPac ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input name="fechaEgresoPac" type="hidden" value="<?php 
									if($fechaEgresoPac != NULL && $fechaEgresoPac != ''){
										$fechaEgresoPac = date_create_from_format('d/m/Y',$fechaEgresoPac)->format('Y-m-d');
									} else {
										$fechaEgresoPac =NULL;
									}
									echo  $fechaEgresoPac; ?>" />
								<strong> DÍAS:&nbsp;</strong> <?php echo $intervalo ?>
								<input name="intervalo" type="hidden" value="<?php echo $intervalo ?>" >
								<br />
								<strong> DIAGNÓSTICO DE INGRESO:&nbsp;</strong>
								<input id="show_DiagIngr" name="diagnosticoPac" style="width: 300px; height: 30px; border: ridge" type="text" placeholder="Colocar Diagnóstico De Ingreso" autocomplete="off" value="<?php echo utf8_encode($diagnosticoPac) ?>" />
																
								<strong> DIAGNÓSTICO DE EGRESO:&nbsp;</strong>
								<input id="show_DiagEgr" name="diagEgr" style="width: 390px; height: 30px; border: ridge" type="text" placeholder="Colocar Diagnóstico De Egreso" autocomplete="off" value="<?php echo utf8_encode($diagEgr) ?>" />
							</p>
							<input name="rol" type="hidden" value="<?php echo $rol ?>" >
							<input name="permisos" type="hidden" value="<?php echo $permisos ?>" >
							<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
							<input name="folio" type="hidden" value="<?php echo $folio ?>" >
							<p>
								<input type="Submit" class="btn btn-success" name="enviarBasicos" value="GUARDAR">
							</p>
						</div>
						</form>
						<br>
						<input class="btn btn-info" id="btnLab" type="button" value="DATOS DE LABORATORIO" onclick="window.open('../datosLaboratorio.php?epidemio=si&expediente=<?php echo $expediente ?>&folio=<?php echo $folio ?>&nomPac=<?php echo urlencode(utf8_encode($nombre_pac))?>','ventana','width=840,height=680,scrollbars=YES,menubar=NO,resizable=NO,titlebar=NO,status=NO');"return false style="width: 225px; height: 40px"/>
					</li>
					
					<li class="sky-tab-content-2">
						<div class="typography">
							<h1>VIGILANCIA Y CAPACITACIÓN</h1>
							<h2><?php echo $vigcap ?></h2>
							<p>
								<input type="button" value="CAPTURAR DATOS" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('vigilancia.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
							</p>
							<p>
								<input type="button" value="CONSULTAR HISTORICO" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('vigilancia/consultaVigilancia.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-3">
						<div class="typography">
							<h1>VERIFICACIÓN EN LA INSERCIÓN DE LÍNEAS VASCULARES CENTRALES</h1>
							<h2><?php echo $lvc ?></h2>
							<p>
								<input type="button" value="INSTALACIÓN" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('instalacionLVC.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="HISTORICO DE INSTALACIONES" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=AccesosVascCentrInst&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-4">
						<div class="typography">
							<h1>ACCESOS VASCULARES PERIFÉRICOS</h1>
							<p>
								<h2><?php echo $avpI ?></h2>
								<input type="button" value="INSTALACIÓN" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" 
									   onClick="window.open('instalacionAVP.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE INSTALACIONES" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=AccesosVascPerInst&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
							<p>
								<h2><?php echo $avpM ?></h2>
								<input type="button" value="MANTENIMIENTO" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" 
									   onClick="window.open('mantenimientoAVP.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE MANTENIMIENTOS" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=AccesosVascPerManto&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-5">
						<div class="typography">
							<h1>VENTILACIÓN MECÁNICA</h1>
							<p>
								<h2><?php echo $vmI ?></h2>
								<input type="button" value="INSTALACIÓN" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" 
									   onClick="window.open('instalacionVM.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE INSTALACIONES" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=VentilacionMecanicaInst&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
							<p>
								<h2><?php echo $vmM ?></h2>
								<input type="button" value="MANTENIMIENTO" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" 
									   onClick="window.open('mantenimientoVM.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE MANTENIMIENTOS" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=VentilacionMecanicaManto&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-6">
						<div class="typography">
							<h1>SITIOS QUIRÚRGICOS</h1>
							<h2><?php echo $sq ?></h2>
							<p>
								<input type="button" value="INSTALACIÓN" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" 
									   onClick="window.open('instalacionSQ.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE INSTALACIONES" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=SitiosQuirurgInst&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
							<p>
								<h2><?php echo $vmM ?></h2>
								<input type="button" value="MANTENIMIENTO" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" 
									   onClick="window.open('mantenimientoSQ.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE MANTENIMIENTOS" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=SitiosQuirurgManto&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-7">
						<div class="typography">
							<h1>SONDA VESICAL</h1>
							<h2><?php echo $svI ?></h2>
							<p>
								<input type="button" value="INSTALACIÓN" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px"
									   onClick="window.open('instalacionSV.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE INSTALACIONES" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=SondaVesicalInst&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
							<p>
								<h2><?php echo $svM ?></h2>
								<input type="button" value="MANTENIMIENTO" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('mantenimientoSV.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
								<input type="button" value="HISTORICO DE MANTENIMIENTOS" class="btn btn-success" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('excel.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&nombre=SondaVesicalManto&sexo=<?php echo $sexo_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-8">
						<div class="typography">
							<h1>TEMPERATURA</h1>
							<h2><?php echo $temp ?></h2>
							<p>
								<input type="button" value="TOMAR MEDICIÓN" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('addTemperatura.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="CONSULTAR MEDICIÓNES" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaTemperatura.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-9">
						<div class="typography">
							<h1>VIGILANCIA DE OTRAS INFECCIONES ASOCIADAS A LA ATENCIÓN DE LA SALUD</h1>
							<h2><?php echo $otras ?></h2>
							<p>
								<input type="button" value="CAPTURAR DATOS" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('addOtrasInfecc.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="CONSULTAR OTRAS INFECCIONES" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('otrasInfecciones/consultaOtrasInfecciones.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
				</ul>
			</div>
			<!--/ tabs -->
			
		</div>
		&nbsp;&nbsp;<input type="image" src="img/regresa.png" value="REGRESAR" onclick=location.href="../epidemiologia/index.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" height="90" width="160"/>
</body>
</html>