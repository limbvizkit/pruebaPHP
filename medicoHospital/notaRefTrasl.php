<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configMedico.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../conexion/funciones_db.php');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['exp']))
	{
		$expediente=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	
	$nombre_pac =NULL;
	$fcFin=NULL;
	$frFin=NULL;
	$taFin=NULL;
	$tempFin=NULL;
	
	$pesoFin=NULL;
	$tallaFin=NULL;
	$turnoFin=NULL;
	$turnoFinLetra=NULL;
	$acudeFin=NULL;
	$antecOld=NULL;
	$fechaFin=NULL;
	//Query para jalar los datos de la consulta medica
	/*$queryAntec = "SELECT *
				  FROM notaUrgchoque
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		
		$fcFin=$rowA['fc'];
		$frFin=$rowA['fr'];
		$taFin=$rowA['ta'];
		$tempFin=$rowA['temp'];
		$turnoFin=$rowA['turno'];
		$fechaFin =substr($rowA['fecha'],0,10);
		//$fechaFin = $fechaFin0->format('Y-m-d');
		
		if($turnoFin == 'M'){
			$turnoFinLetra='MATUTINO';
		} else if($turnoFin == 'V'){
			$turnoFinLetra='VESPERTINO';
		} if($turnoFin == 'N'){
			$turnoFinLetra='NOCTURNO';
		}
		
		$diagOld= utf8_encode($rowA['diag']);
		$diagFin=addslashes ($diagOld);
		
	}
	if($fcFin== NULL || $fcFin == ''){
		$queryAntec = "SELECT *
				  FROM notaUrg
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
				  LIMIT 1";

		$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));

		while($rowA = mysqli_fetch_array($antec)){
			$fcFin=$rowA['fc'];
			$frFin=$rowA['fr'];
			$taFin=$rowA['ta'];
			$tempFin=$rowA['temp'];
			$turnoFin=$rowA['turno'];
			$fechaFin =substr($rowA['fecha'],0,10);
			//$fechaFin = $fechaFin0->format('Y-m-d');

			if($turnoFin == 'M'){
				$turnoFinLetra='MATUTINO';
			} else if($turnoFin == 'V'){
				$turnoFinLetra='VESPERTINO';
			} if($turnoFin == 'N'){
				$turnoFinLetra='NOCTURNO';
			}

			$diagOld= utf8_encode($rowA['diag']);
			$diagFin=addslashes ($diagOld);
		}
	}
	//Precargar datos de Indicaciones
	$indicaciones = NULL;
	$longitud = NULL;
	$queryIndic = "SELECT *
				  FROM indicacionesmedicas
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
				  LIMIT 1";

		$indic = mysqli_query($conexionMedico, $queryIndic) or die (mysqli_error($conexionMedico));

		while($rowI = mysqli_fetch_array($indic)){
			$indicaciones=utf8_encode($rowI['indicacion']);
			$fechaI=$rowI['fechaInd'];
			$horaI=$rowI['horaInd'];
		}
		if($indicaciones != NULL && $indicaciones != ''){
			$arreglado = trim($indicaciones, '[');
			$arreglado1 = trim($arreglado, ']');

			$indicac = explode(",",$arreglado1);

			$arreglado2 = trim($fechaI, '[');
			$arreglado3 = trim($arreglado2, ']');

			$fechaIndic = explode(",",$arreglado3);

			$arreglado4 = trim($horaI, '[');
			$arreglado5 = trim($arreglado4, ']');

			$horaIndic = explode(",",$arreglado5);
			$longitud = count($horaIndic);
		}*/

	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
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
	$obligado_pac = $resultado[0][0]['OBLI_PAC'];
 	$date2 = $resultado[0][0]['NACIO_PA'];
	//Sacar Edad Precisa en años o Meses
	$hoy = new DateTime();
	$anniosO = $hoy->diff($date2);
	//$annios = $annios->y;
	$annios = $anniosO->format('%y Año(s)');
	$anniosBool = $anniosO->format('%y');
	if($anniosBool == '0'){
		$annios = $anniosO->format('%m Mes(es)');
	}

	if(isset($_REQUEST['enviar']))
	{
		$oxi=NULL;
		$desfri=NULL;
		$incuba=NULL;
		$estable=NULL;
		
		if (isset($_POST['expediente']))
		{
			$expediente=$_POST['expediente'];
		}
		if (isset($_POST['folio']))
		{
			$folio=$_POST['folio'];
		}
		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		
		if (isset($_POST['fecha']))
		{
			$fecha=$_POST['fecha'];
		}
		if (isset($_POST['hora']))
		{
			$hora=$_POST['hora'];
		}
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['servicio']))
		{
			$servicio = utf8_decode($_POST['servicio']);
			$servicio = addslashes($servicio);
		}
		if (isset($_POST['tipoTraslado']))
		{
			$tipoTraslado=$_POST['tipoTraslado'];
		}
		if (isset($_POST['ambulanciaTecno']))
		{
			$ambulanciaTecno=$_POST['ambulanciaTecno'];
		}
		if (isset($_POST['tipoPaciente']))
		{
			$tipoPaciente=$_POST['tipoPaciente'];
		}
		if (isset($_POST['oxi']))
		{
			$oxi=$_POST['oxi'];
		} else {
			$oxi=NULL;
		}
		if (isset($_POST['desfri']))
		{
			$desfri=$_POST['desfri'];
		} else {
			$desfri=NULL;
		}
		if (isset($_POST['venti']))
		{
			$venti=$_POST['venti'];
		} else {
			$venti= NULL;
		}
		if (isset($_POST['incuba']))
		{
			$incuba=$_POST['incuba'];
		} else {
			$incuba=NULL;
		}
		if (isset($_POST['receptor']))
		{
			$receptor=$_POST['receptor'];
		} else {
			$receptor=NULL;
		}
		
		if (isset($_POST['otroReceptor']))
		{
			$otroReceptor = utf8_decode($_POST['otroReceptor']);
			$otroReceptor = addslashes($otroReceptor);
		}
		if (isset($_POST['fc']))
		{
			$fc=$_POST['fc'];
		}
		if (isset($_POST['fr']))
		{
			$fr=$_POST['fr'];
		}
		if (isset($_POST['ta']))
		{
			$ta=$_POST['ta'];
		}
		if (isset($_POST['temp']))
		{
			$temp=$_POST['temp'];
		}		
		if (isset($_POST['peso']))
		{
			$peso=$_POST['peso'];
		}
		if (isset($_POST['talla']))
		{
			$talla=$_POST['talla'];
		}
		if (isset($_POST['motivoEnvio']))
		{
			$motivoEnvio=utf8_decode($_POST['motivoEnvio']);
			$motivoEnvio = addslashes($motivoEnvio);
		}
		if (isset($_POST['impresionDiag']))
		{
			$impresionDiag=utf8_decode($_POST['impresionDiag']);
			$impresionDiag = addslashes($impresionDiag);
		}
		if (isset($_POST['terapeuticaEmpl']))
		{
			$terapeuticaEmpl=utf8_decode($_POST['terapeuticaEmpl']);
			$terapeuticaEmpl = addslashes($terapeuticaEmpl);
		}
		if (isset($_POST['cedulaMedEntrega']))
		{
			$cedulaMedEntrega=$_POST['cedulaMedEntrega'];
		}
		if (isset($_POST['fechaExt']))
		{
			$fechaExt=$_POST['fechaExt'];
		}
		if (isset($_POST['horaExt']))
		{
			$horaExt=$_POST['horaExt'];
		}
		if (isset($_POST['turnoExt']))
		{
			$turnoExt=$_POST['turnoExt'];
		}
		if (isset($_POST['estable']))
		{
			$estable=$_POST['estable'];
		}
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' 
		'.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsUrg = "INSERT INTO notaReferenciaTrash (id,numeroExpediente,folio,fecha,hora,turno,servicio,tipoTraslado,ambulanciaTecno,tipoPaciente,
						oxigeno,desfibrilador,ventilador,incubadora,receptor,otroReceptor,fc,fr,ta,temp,peso,talla,motivoEnvio,impresionDiag,
						terapeuticaEmpl,cedulaMedEntrega,fechaExt,horaExt,estable,turnoExt,usr)
						VALUES (NULL,'$expediente','$folio','$fecha','$hora','$turno','$servicio','$tipoTraslado','$ambulanciaTecno','$tipoPaciente',
						'$oxi','$desfri','$venti','$incuba','$receptor','$otroReceptor','$fc','$fr','$ta','$temp','$peso','$talla','$motivoEnvio',
						'$impresionDiag','$terapeuticaEmpl','$cedulaMedEntrega','$fechaExt','$horaExt','$estable','$turnoExt','$rol')";
		
			$result0 = mysqli_query($conexionMedico, $queryInsUrg);
			if(!$result0) {
				echo '!<br> ERROR al insertar Nota de Referencia Traslado! <br>';
				echo 'QUERY: '.$queryInsUrg;
			} else {
				echo '<br>!!!! SE GUARDO LA NOTA DE REFERENCIA Y TRASLADO CORRECTAMENTE!!!!<br>';
			}
	}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NOTA REFERENCIA</title>

        <!-- Google Font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<!-- BootStrap Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/bootstrap/css/bootstrap.min.css"-->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
		<!-- Font-Awesome Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/font-awesome/css/font-awesome.min.css"-->
		<link rel="stylesheet" href="./tabs_files/font-awesome.css">
		
		<!-- Plugin Custom Stylesheet -->
		<link rel="stylesheet" href="css/form-wizard-blue.css">
		<link href="css/switcher.css" rel="stylesheet">
		<!--*****
		If you need to change the form color then you have to just change the CSS file name!! Do it very simply, like as "form-wizard-red.css" for make it red color. Our template other colors name is there ( black, blue, red, pink, purple, teal, green, yellow, orange, brown, cyan, lime ). Replace the name and make it awesome!!!
		*****-->
    </head>

    <body>
        <!-- main content -->
        <section class="form-box">
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th style="text-align: center">DATOS PACIENTE</th>
					</tr>
					</thead>
			</table>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th>EXPEDIENTE</th>
						<th>FOLIO</th>
						<th>NOMBRE</th>
						<th>EDAD</th>
						<th>SEXO</th>
						<th>PROCEDE</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $expediente_pac ?></td>
							<td><?php echo $folio_pac ?></td>
							<td><?php echo utf8_encode($nombre_pac) ?></td>
							<td><?php echo $annios ?></td>
							<td><?php echo $sexo_pac ?></td>
							<td><?php echo $obligado_pac ?></td>
						</tr>
					</tbody>
				</table>
			<br>
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-13 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
					
                    	<form role="form" action="" method="post">

                    		<h3>NOTA DE REFERENCIA Y TRASLADO</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-3">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-medkit" aria-hidden="true"></i></div>
                    				<p>Servicio y Traslado</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-folder-open-o" aria-hidden="true"></i></div>
                    				<p>Datos Clínicos</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-ambulance" aria-hidden="true"></i></div>
                    				<p>Médico y Ambulancia</p>
                    			</div>
								<!-- Step 3 -->
								
								<!-- Step 4 -->
								<!--div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>Evolución y Pronóstico</p>
                    			</div-->
								<!-- Step 4 -->
                    		</div>
							<!-- Form progress -->
                    		
							
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>SERVICIO Y TRASLADO: <span>Paso 1 - 3</span></h4>
								<div class="form-group">
                    			    <label>FECHA : <span>*</span></label>
                                    <input type="date" name="fecha" value="<?php echo $fechaFin ?>" class="form-control required">
                                </div>
								<div class="form-group">
									<label>HORA : <span>*</span></label>
									<input type="time" name="hora" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>TURNO : <span>*</span></label>
								   <select id="turno" name="turno" class="form-control required">
										<option value="">Seleccione</option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="N">Nocturno</option>
									</select>
								</div>
								<div class="form-group">
                    			    <label>SERVICIO : <span>*</span></label>
									<select id="servicio" name="servicio" class="form-control required">
										<option value="">Seleccione</option>
										<option value="Hospitalización">Hospitalización</option>
										<option value="Urgencias">Urgencias</option>
										<option value="Corta Estancia">Corta Estancia</option>
										<option value="UCIA">UCIA</option>
										<option value="UCIPyN">UCIPyN</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>TIPO DE TRASLADO: <span>*</span></label>
									<br>
									<label class="radio-inline">
									  <input type="radio" name="tipoTraslado" value="TRASLADO DEFINITIVO" style="width: 30px; height: 30px" checked="checked"> &nbsp;&nbsp;TRASLADO DEFINITIVO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoTraslado" value="TRASLADO TRANSITORIO" style="width: 30px; height: 30px">&nbsp;&nbsp; TRASLADO TRANSITORIO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>REQUIERE AMBULANCIA DE ALTA TECNOLOGÍA: <span>*</span></label>
									<br>
									<label class="radio-inline">
									  <input type="radio" name="ambulanciaTecno" value="1" style="width: 30px; height: 30px" checked="checked"> &nbsp;&nbsp;SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="ambulanciaTecno" value="0" style="width: 30px; height: 30px">&nbsp;&nbsp; NO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>TIPO DE PACIENTE: <span>*</span></label>
									<br>
									<label class="radio-inline">
									  <input type="radio" name="tipoPaciente" value="CRITICO" style="width: 30px; height: 30px" checked="checked"> &nbsp;&nbsp;CRITICO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoPaciente" value="NO CRITICO" style="width: 30px; height: 30px">&nbsp;&nbsp; NO CRITICO
									</label>
                                </div>
								<br>
								<div class="form-group">
                    			    <label>ADITAMENTOS ESPECIALES : <span>*</span></label>
									<br>
									<label class="checkbox-inline"> OXIGENO
									  <input type="checkbox" name="oxi" style="width: 45px; height: 35px" value="1" >
									</label>
									<label class="checkbox-inline">DESFIBRILADOR
									  <input type="checkbox" name="desfri" style="width: 45px; height: 35px" value="1">
									</label>
									<label class="checkbox-inline">VENTILADOR
									  <input type="checkbox" name="venti" style="width: 45px; height: 35px" value="1"> 
									</label>
									<label class="checkbox-inline"> INCUBADORA
									  <input type="checkbox" name="incuba" style="width: 45px; height: 35px" value="1"> 
									</label>
                                </div>
								<br>
								<br>
								<div class="form-group">
                    			    <label>ESTABLECIMIENTO RECEPTOR  : <span>*</span></label>
									 <select id="receptor" name="receptor" onchange="verOtro(this.form)" class="form-control required">
										<option value="">Seleccione</option>
										<option value="IMSS">IMSS</option>
										<option value="ISSSTE">ISSSTE</option>
										<option value="HOSPITAL G. PARRES">HOSPITAL G. PARRES</option>
										 <option value="HOSPITAL SECRETARIA DE SALUD">HOSPITAL SECRETARIA DE SALUD</option>
										 <option value="HOSPITAL MORELOS">HOSPITAL MORELOS</option>
										 <option value="INSTITUTO MEXICANO DE TRANSPLANTES">INSTITUTO MEXICANO DE TRANSPLANTES</option>
										 <option value="HOSPITAL SAN DIEGO">HOSPITAL SAN DIEGO</option>
										 <option value="MEDICA SUR">MEDICA SUR</option>
										 <option value="HOSPITAL ANGELES">HOSPITAL ANGELES</option>
										 <option value="CARDICA">CARDICA</option>
										 <option value="IMAGEN MEDICA">IMAGEN MEDICA</option>
										 <option value="LABORATORIOS CHOPO">LABORATORIOS CHOPO</option>
										 <option value="LABORATORIOS POLAB">LABORATORIOS POLAB</option>
										 <option value="OTROS">OTROS</option>
									</select>
                                </div>
								<br>
								<div id="otro" style="display:none">
									<div class="form-group">
										<label>NOMBRE DEL OTRO ESTABLECIMIENTO RECEPTOR: <span>*</span></label>										
										<input class="form-control" type="text" name="otroReceptor" placeholder="Colocar Nombre" autocomplete="off">
										<br>
									</div>
								</div>
								<br/>

                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->

							<!-- Form Step 2 -->
                            <fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>DATOS CLÍNICOS : <span>Paso 2 - 3</span></h4>
								<div class="container-fluid">
									<label>SIGNOS VITALES: <span></span></label>
									<div class="row form-inline">
										<div class="form-group col-md-6 col-xs-6">
											<label>FC : <span>*</span></label>
											<input type="text" placeholder="min" name="fc" class="form-control required" value="<?php echo $fcFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>FR : <span></span>*</label>
											<input type="text" placeholder="min" name="fr" class="form-control required" value="<?php echo $frFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>T/A : <span>*</span></label>
											<input type="text" name="ta" placeholder="mmHg" class="form-control required" value="<?php echo $taFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TEMP : <span>*</span></label>
											<input type="text" name="temp" placeholder="°C" class="form-control required" value="<?php echo $tempFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>PESO (Kg) : <span></span></label>
											<input type="number" step="0.01" name="peso" class="form-control" value="<?php echo $pesoFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TALLA (Mts) : <span></span></label>
											<input type="number" step="0.01" name="talla" class="form-control" value="<?php echo $tallaFin ?>" autocomplete="off">
										</div>
									</div>
								</div>
								
								<div class="form-group">
                    			    <label>MOTIVO DE ENVIO : <span>*</span></label>
									<textarea class="form-control required" name="motivoEnvio" id="motivoEnvio" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>IMPRESIÓN DIAGNOSTICA : <span>*</span></label>
									<textarea class="form-control required" name="impresionDiag" id="impresionDiag" cols="10" rows="3"><?php echo $diagFin ?></textarea>
                                </div>
								<div class="form-group">
                    			    <label>TERAPÉUTICA EMPLEADA : <span>*</span></label>
									<textarea class="form-control required" name="terapeuticaEmpl" id="terapeuticaEmpl" cols="10" rows="3"><?php
										for($i=0; $i<$longitud; $i++){
												$fi = substr($fechaIndic[$i+1], 11, -2);
												$hi = substr($horaIndic[$i],10, -2);
												if(strlen($indicac[0]) <= 15) {
													$ii = substr($indicac[$i+1], 10, -2);
												} else {
													$ii = substr($indicac[$i], 10, -2);
												}
												echo $fi.' - '.$hi.'hrs.';
												echo "\r\n";
												echo $ii;
											if($i+1<$longitud){
												echo "\r\n";
											}
												
										}
										?>
									</textarea>
                                </div>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 2 -->

							<!-- Form Step 3 -->
                            <fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
								<h4>MÉDICO Y AMBULACIA : <span>Paso 3 - 3</span></h4>
								<div class="form-group">
                    			    <label>CÉDULA MÉDICO QUE ENTREGA AL PACIENTE: <span>*</span></label>
									<!--input type="text" name="cedulaMedEntrega" class="form-control required" autocomplete="off"-->
									<input class="form-control" id="cedulaMedEntrega" type="text" name="cedulaMedEntrega" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off" required>
									<br>
									<div id="suggestions1"></div>
                                </div>
								<div class="form-group">
                    			    <label>PACIENTE QUE REGRESA AL HOSPITAL HENRI DUNANT DESPUÉS DE REALIZAR ESTUDIO EXTERNO : <span>*</span></label>
									<br>
									<label class="radio-inline">
									  <input type="radio" name="regresa" onclick="mostrar0('2')" value="0" style="width: 30px; height: 30px" checked="checked"> &nbsp;&nbsp;NO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="regresa" onclick="mostrar0('1')" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
                                </div>
								<div id="final" style="display:none">
									<div class="form-group">
										<label>FECHA : <span></span></label>
										<input type="date" name="fechaExt" class="form-control">
									</div>
									<div class="form-group">
										<label>HORA : <span></span></label>
										<input type="time" name="horaExt" class="form-control" autocomplete="off">
									</div>
									<div class="form-group">
										<label>TURNO : <span></span></label>
									   <select id="turnoExt" name="turnoExt" class="form-control">
											<option value=""></option>
											<option value="M">Matutino</option>
											<option value="V">Vespertino</option>
											<option value="N">Nocturno</option>
										</select>
									</div>
									<div class="form-group">
										<label>SE RECIBE AL PACIENTE ESTABLE : <span></span></label>
										<br>
										<label class="radio-inline">
										  <input type="radio" name="estable" value="1" style="width: 30px; height: 30px"> &nbsp;&nbsp;SI
										</label>
										<label class="radio-inline">
										  <input type="radio" name="estable" value="0" style="width: 30px; height: 30px">&nbsp;&nbsp; NO
										</label>
									</div>
								</div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">
									<button type="button"  class="btn btn-previous">Anterior</button>
                                    <button type="submit" name="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 3 -->
                    	</form>
						</div>
						<!-- Form Wizard -->
                    </div>
                </div>
            </div>
			<input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 137px; height: 44px" />
        </section>
		<!-- main content -->

        <!-- Jquery JS -->
        <script src="../js/jquery-1.11.1.min.js"></script>
		<!-- bootStrap JS -->
		<script src="../js/bootstrap.min.js"></script>
		
		
		<!-- Plugin Custom JS -->
        <script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script>
        <!-- Plugin Custom JS -->
		<script type="text/javascript">
		var id1 = "";
		  	$(document).ready(function(e) {
			$('#cedulaMedEntrega').bind('input keyup', function(){
				//Obtenemos el value del input
				var cedula = $(this).val();
				var dataString0 = 'cedula='+cedula;
				
				var n = dataString0.length;
				if(n > 10){
					var dataString = dataString0;
				} else {
					var dataString = 'cedula=" "';
				}
				
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "autocompleteDR.php",
		            data: dataString,
		            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
		            //async: false,
		            success: function(data) {
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions1').fadeIn(1000).html(data);
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id1 = $(this).attr('id1'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medico
							var especialidad = $(this).attr('especialidad');
							var ced = $(this).attr('ced');
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							valor = valor.trim();
							$('#cedulaMedEntrega').val(ced);
							//$('#telCirujano').val(tel);
							//$('#emailCirujano').val(email);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions1').fadeOut(1000);
							//Add valor del id del elemento seleccionado
							//$('#idMedic').val(id1);
						});
		            }
		        });
		    });
		});
		</script>
			
		<script type="text/javascript">
			function mostrar0(v){
				if(v == '1'){
					document.getElementById('final').style="display:block";					
				} else {
					document.getElementById('final').style="display:none";
				}
			}
			
			//Mostrar recuadro si se selecc OTROS
			function verOtro(e){
				var valr = e.receptor.options[e.receptor.selectedIndex].value;
				if( valr == "OTROS") {
					document.getElementById("otro").style="display:block";
				}else{
					document.getElementById("otro").style="display:none";
				}
			}
			
		</script>

    </body>

</html>