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
	} else {
		$expediente=NULL;
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	} else {
		$folio=NULL;
	}
	
//vamos a ver si podemos separar con Expediente y sin Expediente
if($expediente != NULL || trim($expediente) != '') {
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
	$fec_nacPac=$date2->format('d/m/Y');
	//Sacar Edad Precisa en años o Meses
	$hoy = new DateTime();
	$anniosO = $hoy->diff($date2);
	//$annios = $annios->y;
	$annios = $anniosO->format('%y Año(s)');
	$anniosBool = $anniosO->format('%y');
	if($anniosBool == '0') {
		$annios = $anniosO->format('%m Mes(es)');
	}
}

	if(isset($_REQUEST['enviar']))
	{
		$aim=NULL;
		$cidt=NULL;
		$ciam=NULL;
		$dim=NULL;
		$eii=NULL;
		$fimar=NULL;
		$mcmc=NULL;
		$licim=NULL;
		$fma=NULL;
		$manp=NULL;
		$fdvpam=NULL;
		$frmec=NULL;
		$ficp=NULL;
		$ampi=NULL;
		$amnp=NULL;
		$omisionMed=NULL;
		$ami=NULL;
		$presInc=NULL;
		$transInc=NULL;
		$prepInc=NULL;
		$dispoInc=NULL;
		$tai=NULL;
		$vai=NULL;
		$adpi=NULL;
		$dti=NULL;
		$hai=NULL;
		$ifi=NULL;
		$vii=NULL;
		$ot=NULL;

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
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['reporta']))
		{
			$reporta=utf8_decode($_POST['reporta']);
			$reporta=addslashes ($reporta);
		}
		if (isset($_POST['servicio']))
		{
			$servicio=utf8_decode($_POST['servicio']);
			$servicio=addslashes ($servicio);
		}		
		if (isset($_POST['diag']))
		{
			$diag=utf8_decode($_POST['diag']);
			$diag=addslashes ($diag);
		}
		if (isset($_POST['tipoEvento']))
		{
			$tipoEvento=utf8_decode($_POST['tipoEvento']);
			$tipoEvento = addslashes($tipoEvento);
		}		
		if (isset($_POST['relacionado']))
		{
			$relacionado=$_POST['relacionado'];
		}
		if (isset($_POST['alcanzoPac']))
		{
			$alcanzoPac=$_POST['alcanzoPac'];
		}
		if (isset($_POST['danioPac']))
		{
			$danioPac=$_POST['danioPac'];
		}
		if (isset($_POST['evento']))
		{
			$evento=utf8_decode($_POST['evento']);
			$evento = addslashes($evento);
		}
		if (isset($_POST['como']))
		{
			$como=utf8_decode($_POST['como']);
			$como = addslashes($como);
		}
		if (isset($_POST['porQue']))
		{
			$porQue=utf8_decode($_POST['porQue']);
			$porQue=addslashes($porQue);
		}
		if (isset($_POST['medicamento']))
		{
			$medicamento=utf8_decode($_POST['medicamento']);
			$medicamento=addslashes($medicamento);
		}
		if (isset($_POST['generico']))
		{
			$generico=utf8_decode($_POST['generico']);
			$generico=addslashes($generico);
		}
		if (isset($_POST['presentacion']))
		{
			$presentacion=utf8_decode($_POST['presentacion']);
			$presentacion=addslashes($presentacion);
		}
		if (isset($_POST['dosis']))
		{
			$dosis=utf8_decode($_POST['dosis']);
			$dosis=addslashes($dosis);
		}
		if (isset($_POST['viaAdmin']))
		{
			$viaAdmin=utf8_decode($_POST['viaAdmin']);
			$viaAdmin=addslashes($viaAdmin);
		}
		if (isset($_POST['intervalo']))
		{
			$intervalo=utf8_decode($_POST['intervalo']);
			$intervalo=addslashes($intervalo);
		}
		if (isset($_POST['aim']))
		{
			$aim=$_POST['aim'];
		}
		if (isset($_POST['cidt']))
		{
			$cidt=$_POST['cidt'];
		}
		if (isset($_POST['ciam']))
		{
			$ciam=$_POST['ciam'];
		}
		if (isset($_POST['dim']))
		{
			$dim=$_POST['dim'];
		}
		if (isset($_POST['eii']))
		{
			$eii=$_POST['eii'];
		}
		if (isset($_POST['fimar']))
		{
			$fimar=$_POST['fimar'];
		}
		if (isset($_POST['mcmc']))
		{
			$mcmc=$_POST['mcmc'];
		}
		if (isset($_POST['licim']))
		{
			$licim=$_POST['licim'];
		}
		if (isset($_POST['fma']))
		{
			$fma=$_POST['fma'];
		}
		if (isset($_POST['manp']))
		{
			$manp=$_POST['manp'];
		}
		if (isset($_POST['fdvpam']))
		{
			$fdvpam=$_POST['fdvpam'];
		}
		if (isset($_POST['frmec']))
		{
			$frmec=$_POST['frmec'];
		}
		if (isset($_POST['ficp']))
		{
			$ficp=$_POST['ficp'];
		}
		if (isset($_POST['ampi']))
		{
			$ampi=$_POST['ampi'];
		}
		if (isset($_POST['amnp']))
		{
			$amnp=$_POST['amnp'];
		}
		if (isset($_POST['omisionMed']))
		{
			$omisionMed=$_POST['omisionMed'];
		}
		if (isset($_POST['ami']))
		{
			$ami=$_POST['ami'];
		}
		if (isset($_POST['presInc']))
		{
			$presInc=$_POST['presInc'];
		}
		if (isset($_POST['transInc']))
		{
			$transInc=$_POST['transInc'];
		}
		if (isset($_POST['prepInc']))
		{
			$prepInc=$_POST['prepInc'];
		}
		if (isset($_POST['dispoInc']))
		{
			$dispoInc=$_POST['dispoInc'];
		}
		if (isset($_POST['tai']))
		{
			$tai=$_POST['tai'];
		}
		if (isset($_POST['vai']))
		{
			$vai=$_POST['vai'];
		}
		if (isset($_POST['adpi']))
		{
			$adpi=$_POST['adpi'];
		}
		if (isset($_POST['dti']))
		{
			$dti=$_POST['dti'];
		}
		if (isset($_POST['hai']))
		{
			$hai=$_POST['hai'];
		}
		if (isset($_POST['ifi']))
		{
			$ifi=$_POST['ifi'];
		}
		if (isset($_POST['vii']))
		{
			$vii=$_POST['vii'];
		}
		if (isset($_POST['ot']))
		{
			$ot=$_POST['ot'];
		}
		if (isset($_POST['otros']))
		{
			$otros=utf8_decode($_POST['otros']);
			$otros=addslashes($otros);
		}
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' 
		'.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsAdv = "INSERT INTO eventoAdverso(id,numeroExpediente,folio,fecha,turno,reporta,servicio,diag,tipoEvento,relacionado,alcanzoPac,danioPac,
							evento,como,porQue,medicamento,generico,presentacion,dosis,viaAdmin,intervalo,aim,cidt,ciam,dim,eii,fimar,mcmc,licim,fma,manp,
							fdvpam,frmec,ficp,ampi,amnp,omisionMed,ami,presInc,transInc,prepInc,dispoInc,tai,vai,adpi,dti,hai,ifi,vii,ot,otros,usr)
					VALUES (NULL,'$expediente','$folio','$fecha','$turno','$reporta','$servicio','$diag','$tipoEvento','$relacionado','$alcanzoPac',
					'$danioPac','$evento','$como','$porQue','$medicamento','$generico','$presentacion','$dosis','$viaAdmin','$intervalo','$aim',
					'$cidt','$ciam','$dim','$eii','$fimar','$mcmc','$licim','$fma','$manp','$fdvpam','$frmec','$ficp','$ampi','$amnp','$omisionMed',
					'$ami','$presInc','$transInc','$prepInc','$dispoInc','$tai','$vai','$adpi','$dti','$hai','$ifi','$vii','$ot','$otros','$rol')";
		
			$result0 = mysqli_query($conexionMedico, $queryInsAdv);
			if(!$result0) {
				echo '!<br> ERROR al insertar Evento Adverso! <br>';
				echo 'QUERY: '.$queryInsAdv;
			} else {
				echo '<br>!!!! SE GUARDO EL EVENTO ADVERSO CORRECTAMENTE!!!!<br>';
			}
	}
	/*$fcFin=NULL;
	$frFin=NULL;
	$taFin=NULL;
	$tempFin=NULL;
	$soFin=NULL;
	$glucosaFin=NULL;
	$turnoFin=NULL;
	$turnoFinLetra=NULL;
	$acudeFin=NULL;
	$antecOld=NULL;

	//Query para ver si ya tiene Anteedentes personales
	$queryAntec = "SELECT *
				  FROM notaUrg
				  WHERE numeroExpediente='$expediente' AND estatus='1'
				  ORDER BY fecha DESC
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		$antecOld= utf8_encode($rowA['antecedentes']);
		$antecOld=addslashes ($antecOld);
	}*/

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EVENTO ADVERSO</title>

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
			<?php if($expediente != NULL || trim($expediente) != '') { ?>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th style="text-align: center">DATOS DEL PACIENTE</th>
					</tr>
					</thead>
			</table>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th>EXPEDIENTE</th>
						<th>FOLIO</th>
						<th>NOMBRE</th>
						<th>FECHA NACIMIENTO</th>
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
							<td><?php echo $fec_nacPac  ?></td>
							<td><?php echo $annios  ?></td>
							<td><?php echo $sexo_pac ?></td>
							<td><?php echo $obligado_pac ?></td>
						</tr>
					</tbody>
				</table>
			<br>			
			<br>
			<?php } ?>
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

                    		<h3>NOTIFICACIÓN DE EVENTO ADVERSO</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-3">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>BÁSICOS</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-random" aria-hidden="true"></i></div>
                    				<p>DESCRIPCIÓN DEL EVENTO ADVERSO</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-frown-o" aria-hidden="true"></i></div>
                    				<p>ERROR DE MEDICACIÓN</p>
                    			</div>
								<!-- Step 3 -->
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
                    		    <h4>BÁSICOS: <span>Paso 1 - 3</span></h4>
								<div class="form-group">
									<label>FECHA DE OCURRENCIA : <span>*</span></label>
									<input type="date" name="fecha" class="form-control required" >
								</div>
								<div class="form-group">
									<label>TURNO : <span>*</span></label>
								   <select id="turno" name="turno" class="form-control required">
										<option value="">Seleccionar</option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="N">Nocturno</option>
									</select>
								</div>
								<div class="form-group">
                    			    <label>PERSONAL QUE REPORTA : <span>*</span></label>
                                   <input type="text" placeholder="Nombre o Puesto" name="reporta" class="form-control required" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>SERVICIO : <span>*</span></label>
									<input type="text" placeholder="Nombre del Servicio" name="servicio" class="form-control required" autocomplete="off">
                                </div>
								 <div class="form-group">
                    			    <label>DIAGNÓSTICO DEL PACIENTE : <span></span></label>
									<textarea class="form-control" name="diag" id="diag" cols="10" rows="3"></textarea>
                                </div>
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
                                <h3>DESCRIPCIÓN DEL EVENTO ADVERSO : <span>Paso 2 - 3</span></h3>
								<h4>
									Tipos de Eventos adversos<br />
									<strong>-->	EVENTO CENTINELA:</strong> Incidencia inesperada que ocurre durante la atención médica en la que se produce la muerte o una lesión física o psíquica grave, o existe riesgo de que se produzca. Las lesiones graves incluyen específicamente la pérdida de una extremidad o una función.
									<br />
									<strong>-->	EVENTO ADVERSO:</strong> Incidentes desfavorables, fallas terapéuticas, lesiones iatrogénicas u otros sucesos adversos relacionados directamente con la atención o los servicios prestados en el hospital. Pueden ser consecuencia de actos de comisión o de omisión.
									<br />
									<strong>-->	CUASIFALLA:</strong> (También mencionada como casi falla) Error que se detecta antes de que llegue al paciente.
									<br />
									<strong>-->	ERROR DE MEDICACIÓN:</strong> Todo evento prevenible que pueda causar o dar lugar a un uso incorrecto de la medicación o a daño al paciente mientras la medicación está bajo el control del profesional sanitario, el paciente o el consumidor.
									<br />
									<strong>-->	RAM:</strong> Reacción Adversa a Medicamentos. Cualquier respuesta al uso de un medicamento en dosis normales que sea nociva.
								</h4>
								<div class="form-group">
                    			    <label>a) TIPO DE EVENTO : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Centinela" onclick="mostrar('2')" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; Centinela
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Adverso" onclick="mostrar('2')" style="width: 30px; height: 30px">&nbsp;&nbsp; Adverso
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Cuasifalla" onclick="mostrar('2')" style="width: 30px; height: 30px">&nbsp;&nbsp; Cuasifalla
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Error De Medicación" onclick="mostrar('1')" style="width: 30px; height: 30px">&nbsp;&nbsp; Error De Medicación
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="RAM" onclick="mostrar('2')" style="width: 30px; height: 30px">&nbsp;&nbsp; RAM
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="OTRO" onclick="mostrar('2')" style="width: 30px; height: 30px">&nbsp;&nbsp; OTRO
									</label>
                                </div>
								<div class="form-group">
                    			    <label> b) ¿El evento adverso está relacionado a medicamentos? : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="relacionado" value="SI" onclick="mostrar('1')" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="relacionado" value="NO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
                                </div>
								<div class="form-group">
                    			    <label> c) ¿Alcanzó el error al paciente? : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="alcanzoPac" value="SI" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="alcanzoPac" value="NO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
                                </div>
								<div class="form-group">
                    			    <label> d) ¿Causó daño al paciente? : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="danioPac" value="SI" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="danioPac" value="NO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
                                </div>
								<br/>
                                <div class="form-group">
                    			    <label>e) ¿Cuál fue el evento? : <span>*</span></label>
									<textarea class="form-control required" name="evento" id="habExt" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="habExt" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>f) ¿Cómo pasó? : <span>*</span></label>
									<textarea class="form-control required" name="como" id="cabeza" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="cabeza" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>g) ¿Por qué pasó? : <span>*</span></label>
									<textarea class="form-control required" name="porQue" id="torax" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="torax" class="form-control" autocomplete="off"-->
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
                                <h4>ERROR DE MEDICACIÓN <span>Paso 3 - 3</span></h4>
								<h4>
									Solo se llena si se trata de un error de Medicación
								</h4>
								<div id="errorMed" style="display:none">
								<div class="form-group">
                    			    <label>NOMBRE DEL MEDICAMENTO : <span>*</span></label>
									<input type="text" name="medicamento" class="form-control" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>NOMBRE GENERICO : <span>*</span></label>
									<input type="text" name="generico" class="form-control" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>PRESENTACIÓN : <span>*</span></label>
									<input type="text" name="presentacion" class="form-control" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>DOSIS : <span>*</span></label>
									<input type="text" name="dosis" class="form-control" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>VÍA DE ADMINISTRACIÓN : <span>*</span></label>
									<input type="text" name="viaAdmin" class="form-control" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>INTERVALO : <span>*</span></label>
									<input type="text" name="intervalo" class="form-control" autocomplete="off">
                                </div>
								
								<div class="form-group">
									<table style="width:100%" border="2px solid black" align="center" >
									<tbody>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="aim" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Adquisición incorrecta del medicamento</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="cidt" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												<br/>Condiciones inadecuadas durante el transporte</label>
											</td>
											<td>
												<input type="checkbox" name="ciam" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												<br/>Condiciones inadecuadas en el almacenamiento del medicamento</label>
											</td>
										</tr>

										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="dim" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Dispensación incorrecta de medicamento</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="eii" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Etiquetado incompleto o incorrecto</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="fimar" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Falta de identificación de medicamentos de alto riesgo</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="mcmc" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Medicamento caducado/malas condiciones</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="licim" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Letra ilegible y confusa en la indicación medica</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="fma" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Falta de notificación de alergias</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="manp" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Medicamento con aspecto y/o nombre parecido</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="fdvpam" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Falta de doble verificación de preparación y administración de los medicamentos</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="frmec" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Falta de registro de los medicamentos en expediente clínico</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="ficp" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Falta de identificación correcta del paciente</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="ampi" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Se administra el medicamento a un paciente incorrecto</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="amnp" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Se administra un medicamento no prescrito</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="omisionMed" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Omisión de un medicamento</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="ami" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Se administra un medicamento incorrecto</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="presInc" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Prescripción incompleta</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="transInc" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Transcripción incompleta</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="prepInc" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Preparación incorrecta</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="dispoInc" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Dispositivo incorrecto</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="tai" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Técnica de administración incorrecta</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="vai" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Vía de administración incorrecta</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="adpi" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Se administra una dosis o potencia incorrecta</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="dti" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Duración del tratamiento incorrecto</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="hai" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Hora de administración incorrecta</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="ifi" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Intervalo de frecuencia incorrecto</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="vii" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Velocidad de infusión incorrecta</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="ot" id="ot" onchange="mostrarOt()" style="width: 45px; height: 35px" value="1" >
											</td>
											<td>
												Otros especificar:</label>
											</td>
										</tr>
									</tbody>
									</table>
									</div>
									<div id="otro" style="display:none">
										<div class="form-group" style="height: 100px">
											<textarea class="form-control" name="otros" id="otros" cols="10" rows="3"></textarea>
										</div>
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
			function mostrar(v){
				if(v == '1'){
					document.getElementById('errorMed').style="display:block";
				} else {
					document.getElementById('errorMed').style="display:none";
				}
			}

			function mostrarOt() {
				 element = document.getElementById("otro");
				check = document.getElementById("ot");
				if (check.checked) {
					element.style.display='block';
				} else {
					element.style.display='none';
				}
			}
	</script>
    </body>

</html>