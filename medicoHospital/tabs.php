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
	
	/*$queryBasicos = 'SELECT habitacion,fechaEgreso,alergias,peso,talla,conciliacion,traeMedicamento, diagnostico,concomitantes,
						 CASE ingresa WHEN "1" THEN "HOSPITAL" ELSE "URGENCIAS" END AS ingresa1, medicamentoCasa, tieneCultivo, cultivo
						 FROM paciente WHERE numeroExpediente='.'"'.$expediente.'" AND (folio = 0 || folio= '.'"'.$folio.'")';
		$idBas = mysqli_query($conexion, $queryBasicos ) or die (mysqli_error($conexion));
		$idbas1 = mysqli_fetch_array($idBas );
		if($idbas1 != NULL){
			$fechaEgresoPac = $idbas1 ['fechaEgreso'];
			$ingresaPac = $idbas1 ['ingresa1'];
			$alergiasPac = $idbas1 ['alergias'];
			$pesoPac = $idbas1 ['peso'];
			$tallaPac = $idbas1 ['talla'];
			$conciliacionPac = $idbas1 ['conciliacion'];
			$traeMedicamentoPac = $idbas1 ['traeMedicamento'];
			$diagnosticoPac = $idbas1 ['diagnostico'];
			$concomitantesPac = $idbas1 ['concomitantes'];
			$casa = $idbas1 ['medicamentoCasa'];
			$cuarto = $idbas1 ['habitacion'];
			$tieneCultivo = $idbas1 ['tieneCultivo'];
			$cultivo = $idbas1 ['cultivo'];
		}*/


	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	#El arreglo esta vacio 
    if (empty($resultado[0])) {
    	#Obtenemos datos de MYSQL si es que existen para el expediente dado
    	/*$queryBasicos1 = "SELECT nombre,numeroExpediente,folio,edad,sexo,diagnostico,medico,especialidad,habitacion,fechaIngreso,
								fechaNacimiento,medicamentoCasa, cultivo
    					  FROM paciente
						  WHERE numeroExpediente LIKE '%$expediente' AND (folio = 0 || folio= '$folio')";
		$idBas1 = mysqli_query($conexion, $queryBasicos1) or die (mysqli_error($conexion));
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
	
		    #$date = $idbas2 ['fechaIngreso']; //HR_ING_PAC
		    #$fecha_ing_pac = $date->format('d-m-Y');
		    
		    #date_create_from_format('d-m-Y',$fecha_nac_pac)->format('Y-m-d')
		    
		    $fecha_ing_pac1 = strtotime($idbas2 ['fechaIngreso']);
		    $fecha_ing_pac = date('d-m-Y',$fecha_ing_pac1);
		    		    
		    #$date2 = $idbas2 ['fechaNacimiento'];
		    #$fecha_nac_pac = $date2->format('d-m-Y');
		    $fecha_nac_pac1 = strtotime($idbas2 ['fechaNacimiento']);
		    $fecha_nac_pac = date('d-m-Y',$fecha_nac_pac1);

		} else {*/
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
	    	echo '&nbsp;&nbsp;<input type="image" src="../img/reg.png" value="REGRESAR" onclick=location.href="javascript:history.back(-1);" height="75" width="161">
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
	
 	$queryNotUr = 'SELECT * FROM historiaclinica WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac.' AND estatus=1' ;
                $nota = mysqli_query($conexionMedico, $queryNotUr) or die (mysqli_error($conexion));
                $rowN = mysqli_fetch_array($nota);
	$desc=null;
	if($rowN!= NULL){
    	$desc = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE HISTORIA CLÍNICA</span>";
	}

	$queryNotUrCh = 'SELECT * FROM notapreoperatoria WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac.' AND estatus=1' ;
                $notaCh = mysqli_query($conexionMedico, $queryNotUrCh) or die (mysqli_error($conexion));
                $rowNCh = mysqli_fetch_array($notaCh);
	$descH=null;
	if($rowNCh!= NULL){
    	$descH = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE NOTA PREOPERATORIA</span>";
	}
	
	$queryReceta = 'SELECT * FROM notaingreso WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac.' AND estatus=1';
                $receta = mysqli_query($conexionMedico, $queryReceta) or die (mysqli_error($conexion));
                $rowR = mysqli_fetch_array($receta);
	$descR=null;
	if($rowR != NULL){
    	$descR = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE NOTA DE INGRESO</span>";
	}
	$queryEvol = 'SELECT * FROM notaEvolucionh WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac .' AND estatus=1';
                $receta = mysqli_query($conexionMedico, $queryEvol) or die (mysqli_error($conexion));
                $rowEv = mysqli_fetch_array($receta);
	$descEv=null;
	if($rowEv != NULL){
    	$descEv = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE NOTA DE EVOLUCIÓN </span>";
	}
	$queryTrasSer = 'SELECT * FROM notaTrasladoServh WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac.' AND estatus=1';
                $ts = mysqli_query($conexionMedico, $queryTrasSer) or die (mysqli_error($conexion));
                $rowTS = mysqli_fetch_array($ts);
	$descTraslServ=null;
	if($rowTS != NULL){
    	$descTraslServ = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE NOTA DE TRASLADO DE SERVICIO </span>";
	}
	$queryRefTrasl = 'SELECT * FROM notaReferenciaTrash WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac.' AND estatus=1';
                $rt = mysqli_query($conexionMedico, $queryRefTrasl) or die (mysqli_error($conexion));
                $rowRT = mysqli_fetch_array($rt);
	$descRefTrasl=null;
	if($rowRT != NULL){
    	$descRefTrasl = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE NOTA DE REFERENCIA Y TRASLADO </span>";
	}
	$queryEgreso = 'SELECT * FROM notaegreso WHERE numeroExpediente='.$expediente_pac.' AND folio='.$folio_pac.' AND estatus=1';
                $egreso = mysqli_query($conexionMedico, $queryEgreso) or die (mysqli_error($conexion));
                $rowE = mysqli_fetch_array($egreso);
	$descE=null;
	if($rowE != NULL){
    	$descE = "<span style='color:red'>ESTE PACIENTE CON EL NÚMERO DE FOLIO SELECCIONADO, YA POSEE NOTA DE EGRESO</span>";
	}

?>

<!DOCTYPE html>
<!-- saved from url=(0062)http://voky.com.ua/showcase/sky-tabs/examples/scheme-blue.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				
		<title>MEDICOS</title>
		
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
				<img alt="logoHD" height="100" width="108" src="../img/logoNew2.jpg" /> FORMATOS HOSPITAL </h1>
		</div>
		<div class="body">
			<!-- tabs -->
			<div class="sky-tabs sky-tabs-pos-top-left sky-tabs-anim-flip sky-tabs-response-to-icons">
				<input type="radio" name="sky-tabs" checked="" id="sky-tab1" class="sky-tab-content-1">
				<label for="sky-tab1"><span><span><i class="fa fa-folder-open-o"></i>DATOS DEL PACIENTE</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab2" class="sky-tab-content-2">
				<label for="sky-tab2"><span><span><i class="fa fa-archive"></i>HISTORIA CLÍNICA</span></span></label>
				<?php if ($rol != 'imarmolejo' && $rol != 'jrada') {?>
				<input type="radio" name="sky-tabs" id="sky-tab3" class="sky-tab-content-3">
				<label for="sky-tab3"><span><span><i class="fa fa-file-text-o"></i>NOTA DE INGRESO</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab4" class="sky-tab-content-4">
				<label for="sky-tab4"><span><span><i class="fa fa-user-md"></i>NOTA PREOPERATORIA</span></span></label>
				<?php } ?>
				<input type="radio" name="sky-tabs" id="sky-tab5" class="sky-tab-content-5">
				<label for="sky-tab5"><span><span><i class="fa fa-bar-chart-o"></i>NOTA DE EVOLUCIÓN=</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab6" class="sky-tab-content-6">
				<label for="sky-tab6"><span><span><i class="fa fa-medkit"></i>NOTA DE TRASLADO DE SERVICIOS=</span></span></label>
				<?php if ($rol != 'imarmolejo' && $rol != 'jrada') {?>
				<input type="radio" name="sky-tabs" id="sky-tab7" class="sky-tab-content-7">
				<label for="sky-tab7"><span><span><i class="fa fa-ambulance"></i>NOTA DE REFERENCIA Y TRASLADO=</span></span></label>
				<?php } ?>
				<input type="radio" name="sky-tabs" id="sky-tab8" class="sky-tab-content-8">
				<label for="sky-tab8"><span><span><i class="fa fa-file-o"></i>NOTA DE EGRESO</span></span></label>
				
				<!--input type="radio" name="sky-tabs" id="sky-tab9" class="sky-tab-content-9">
				<label for="sky-tab9"><span><span><i class="fa fa-file-text-o"></i>NOTA POSTOPERATORIA</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab10" class="sky-tab-content-10">
				<label for="sky-tab10"><span><span><i class="fa fa-file"></i>NOTA PRE-ANESTÉSICA</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab11" class="sky-tab-content-11">
				<label for="sky-tab11"><span><span><i class="fa fa-files-o"></i>NOTA DE REGISTRO ANESTÉSICO</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab12" class="sky-tab-content-12">
				<label for="sky-tab12"><span><span><i class="fa fa-file-text"></i>NOTA POSTANESTÉSICA</span></span></label>
				
				<input type="radio" name="sky-tabs" id="sky-tab13" class="sky-tab-content-13">
				<label for="sky-tab13"><span><span><i class="fa fa-clipboard"></i>NOTA DE EGRESO</span></span></label-->
				
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
							<h1>HISTORIA CLÍNICA</h1>
							<h2><?php echo $desc ?></h2>
							<?php if ($rol != 'imarmolejo' && $rol != 'jrada') {?>
							<p>
								<input type="button" value="Agregar Historia Clínica" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('historiaClinica.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="Generar PDF Historia Clínica" class="btn btn-danger" name="historiaClinica" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=historiaClinica', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="Consultar Historia Clinica" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaHistoriaClin.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
							<?php } else { ?>
							<p>
							<input type="button" value="Generar PDF Historia Clínica" class="btn btn-danger" name="historiaClinica" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=historiaClinica', '_blank').focus()"/>
							</p>
							<?php } ?>
						</div>
					</li>
					
					<li class="sky-tab-content-3">
						<div class="typography">
							<h1>NOTA DE INGRESO</h1>
							<h2><?php echo $descR ?></h2>
							<p>
								<input type="button" value="Agregar Nota de Ingreso" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('notaIngreso.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="Generar PDF de Nota de Ingreso" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=notaIngreso', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="Consultar Notas de Ingreso" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaNotaIngreso.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-4">
						<div class="typography">
							<h1>NOTA PREOPERATORIA</h1>
							<h2><?php echo $descH ?></h2>
							<p>
								<input type="button" value="Agregar Nota Preoperatoria" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('notaPreoperatoria.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="Generar PDF de Nota Preoperatoria" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=preoperatoria', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="Consultar Nota Preoperatoria" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaPreoperatoria.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-5">
						<div class="typography">
							<h1>NOTA DE EVOLUCIÓN</h1>
							<h2><?php echo $descEv ?></h2>
							<?php if ($rol != 'imarmolejo' && $rol != 'jrada') {?>
							<p>
								<input type="button" value="Agregar Nota de Evolución" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('notaEvolucion.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="Generar PDF Nota de Evolución" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=nevoh', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="Consultar Nota de Evolución" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaEvolucion.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
							<?php } else { ?>
								<input type="button" value="Generar PDF Nota de Evolución" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=nevoh', '_blank').focus()"/>
							<?php } ?>
						</div>
					</li>
					
					<li class="sky-tab-content-6">
						<div class="typography">
							<h1>NOTA DE TRASLADO DE SERVICIO</h1>
							<h2><?php echo $descTraslServ ?></h2>
							<?php if ($rol != 'imarmolejo' && $rol != 'jrada') {?>
							<p>
								<input type="button" value="Agregar Nota de Traslado de Servicio" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('notaTraslServ.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="Generar PDF Nota de Traslado de Servicio" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=ntsh', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="Consultar Nota de Traslado de Servicio" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaTraslServ.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
							<?php } else { ?>
								<input type="button" value="Generar PDF Nota de Traslado de Servicio" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=ntsh', '_blank').focus()"/>
							<?php } ?>
						</div>
					</li>
					
					<li class="sky-tab-content-7">
						<div class="typography">
							<h1>NOTA DE REFERENCIA Y TRASLADO</h1>
							<h2><?php echo $descRefTrasl ?></h2>
							<p>
								<input type="button" value="Agregar Nota de Referencia y Traslado" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('notaRefTrasl.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="Generar PDF Nota de Referencia y Traslado" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=nrth', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="Consultar Nota de Referencia y Traslado" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaNotaRefTrasl.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
						</div>
					</li>
					<li class="sky-tab-content-8">
						<div class="typography">
							<h1>NOTA DE EGRESO HOSPITALARIO</h1>
							<h2><?php echo $descE ?></h2>
							<?php if ($rol != 'imarmolejo' && $rol != 'jrada') {?>
							<p>
								<input type="button" value="Agregar Nota de Egreso" class="btn btn-primary" name="lvc" style="height: 50px; width: 300px" onClick="window.open('notaEgreso.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()" />
								<input type="button" value="Generar PDF de Nota de Egreso" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=notaEgreso', '_blank').focus()"/>
							</p>
							<p>
								<input type="button" value="Consultar Notas de Egreso" class="btn btn-info" name="lvc" style="height: 50px; width: 300px"
								onClick="window.open('consultaNotaEgreso.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>', '_blank').focus()"/>
							</p>
							<?php } else { ?>
								<input type="button" value="Generar PDF de Nota de Egreso" class="btn btn-danger" name="lvc" 
									   style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?exp=<?php echo $expediente_pac ?>&folio=<?php echo $folio_pac ?>&name=notaEgreso', '_blank').focus()"/>
							<?php } ?>
						</div>
					</li>
					
					<!--li class="sky-tab-content-9">
						<div class="typography">
							<h1>NOTA POSTOPERATORIA</h1>
							<p>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-10">
						<div class="typography">
							<h1>NOTA PRE-ANESTÉSICA</h1>
							<p>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-11">
						<div class="typography">
							<h1>NOTA DE REGISTRO ANESTÉSICO</h1>
							<p>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-12">
						<div class="typography">
							<h1>NOTA POSTANESTÉSICA</h1>
							<p>
							</p>
						</div>
					</li>
					
					<li class="sky-tab-content-13">
						<div class="typography">
							<h1>NOTA DE EGRESO HOSPITALARIO</h1>
							<p>
							</p>
						</div>
					</li-->
				</ul>
			</div>
			<!--/ tabs -->
			
		</div>
		&nbsp;&nbsp;<input type="image" src="img/regresa.png" value="REGRESAR" onclick=location.href="../medico/index.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" height="90" width="160"/>
</body>
</html>