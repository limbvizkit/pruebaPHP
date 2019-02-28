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
	$direccion_pac = $resultado[0][0]['DIR_PAC'].'  Col. '.$resultado[0][0]['COL_PAC'].' C.P. '.$resultado[0][0]['CP_PAC'].' '.$resultado[0][0]['CD_PAC'];
		
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

	$val='0';
	if(isset($_REQUEST['enviar']))
	{
		$tabaquismo=NULL;
		$alcohol=NULL;
		$otras=NULL;
		
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
		
		if (isset($_POST['motivoEgreso']))
		{
			$motivoEgreso=utf8_decode($_POST['motivoEgreso']);
			$motivoEgreso=addslashes ($motivoEgreso);
		}
		if (isset($_POST['fechaEgreso']))
		{
			$fechaEgreso=$_POST['fechaEgreso'];
		}
		if (isset($_POST['horaEgreso']))
		{
			$horaEgreso=$_POST['horaEgreso'];
		}
		if (isset($_POST['diagnosticoIngreso']))
		{
			$diagnosticoIngreso=utf8_decode($_POST['diagnosticoIngreso']);
			$diagnosticoIngreso=addslashes ($diagnosticoIngreso);
		}
		if (isset($_POST['diagnosticoEgreso']))
		{
			$diagnosticoEgreso=utf8_decode($_POST['diagnosticoEgreso']);
			$diagnosticoEgreso=addslashes ($diagnosticoEgreso);
		}
		if (isset($_POST['resumenEvolucion']))
		{
			$resumenEvolucion=utf8_decode($_POST['resumenEvolucion']);
			$resumenEvolucion=addslashes ($resumenEvolucion);
		}
		if (isset($_POST['manejoTratamiento']))
		{
			$manejoTratamiento=utf8_decode($_POST['manejoTratamiento']);
			$manejoTratamiento=addslashes ($manejoTratamiento);
		}
		if (isset($_POST['problemasClinicos']))
		{
			$problemasClinicos=utf8_decode($_POST['problemasClinicos']);
			$problemasClinicos=addslashes ($problemasClinicos);
		}
		if (isset($_POST['tratamientoFarmaco']))
		{
			$tratamientoFarmaco=$_POST['tratamientoFarmaco'];
		}
		if (isset($_POST['describirTratamiento']))
		{
			$describirTratamiento=utf8_decode($_POST['describirTratamiento']);
			$describirTratamiento=addslashes ($describirTratamiento);
		}
		if (isset($_POST['recomendacionesVigilancia']))
		{
			$recomendacionesVigilancia=utf8_decode($_POST['recomendacionesVigilancia']);
			$recomendacionesVigilancia=addslashes ($recomendacionesVigilancia);
		}
		if (isset($_POST['tabaquismo']))
		{
			$tabaquismo=$_POST['tabaquismo'];
		}
		if (isset($_POST['alcohol']))
		{
			$alcohol=$_POST['alcohol'];
		}
		if (isset($_POST['otras']))
		{
			$otras=$_POST['otras'];
		}
		if (isset($_POST['diagnosticos']))
		{
			$diagnosticos=utf8_decode($_POST['diagnosticos']);
			$diagnosticos=addslashes ($diagnosticos);
		}
		if (isset($_POST['pronosticoVida']))
		{
			$pronosticoVida=utf8_decode($_POST['pronosticoVida']);
		}
		if (isset($_POST['pronosticoFuncion']))
		{
			$pronosticoFuncion=utf8_decode($_POST['pronosticoFuncion']);
		}
		if (isset($_POST['nombreMedicoTratante']))
		{
			$nombreMedicoTratante=utf8_decode($_POST['nombreMedicoTratante']);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		
		
		$acturl=NULL;
		$acturl2=NULL;
		$acturl3=NULL;
		$acturl4=NULL;
		$acturl5=NULL;
		$acturl6=NULL;
		
		#vamos a recibir los datos del listado de Indicaciones
		if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = utf8_decode(urldecode($_POST['ListaPro'])); //decodifico el JSON
			//echo 'LLEGOOOO: '.$acturl;
			if($acturl == '[]'){
	        	$acturl = NULL;
	        }
        }
		
		if(isset ($_POST['ListaPro2']) && $_POST['ListaPro2'] != NULL){
			$acturl2 = urldecode($_POST['ListaPro2']); //decodifico el JSON
			//echo 'LLEGOOOO2: '.$acturl2;
			if($acturl2 == '[]'){
	        	$acturl2 = NULL;
	        }
		}
			
        if(isset ($_POST['ListaPro3']) && $_POST['ListaPro3'] != NULL){
			$acturl3 = utf8_decode(urldecode($_POST['ListaPro3'])); //decodifico el JSON
			//$acturl3=addslashes($acturl3);
			if($acturl3 == '[]'){
	        	$acturl3 = NULL;
	        }
		}
		
		if(isset ($_POST['ListaPro4']) && $_POST['ListaPro4'] != NULL){
			$acturl4 = utf8_decode(urldecode($_POST['ListaPro4'])); //decodifico el JSON
			if($acturl4 == '[]'){
	        	$acturl4 = NULL;
	        }
		}
		
		if(isset ($_POST['ListaPro5']) && $_POST['ListaPro5'] != NULL){
			$acturl5 = utf8_decode(urldecode($_POST['ListaPro5'])); //decodifico el JSON
			if($acturl5 == '[]'){
	        	$acturl5 = NULL;
	        }
		}
		
		if(isset ($_POST['ListaPro6']) && $_POST['ListaPro6'] != NULL){
			$acturl6 = utf8_decode(urldecode($_POST['ListaPro6'])); //decodifico el JSON
			if($acturl6 == '[]'){
	        	$acturl6 = NULL;
	        }
		}
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' 
		'.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsNotaEgre = "INSERT INTO notaegreso (id,numeroExpediente,folio,motivoEgreso,fechaEgreso,horaEgreso,diagnosticoIngreso,diagnosticoEgreso,
									resumenEvolucion,manejoTratamiento,problemasClinicos,tratamientoFarmaco,describirTratamiento,idMedicamentos,
									medicamentos,dosis,via,intervalo,dias,recomendacionesVigilancia,tabaquismo,alcohol,otras,diagnosticos,pronosticoVida,
									pronosticoFuncion,nombreMedicoTratante,cedula,usr)
						VALUES (NULL,'$expediente','$folio','$motivoEgreso','$fechaEgreso','$horaEgreso','$diagnosticoIngreso','$diagnosticoEgreso',
						'$resumenEvolucion','$manejoTratamiento','$problemasClinicos','$tratamientoFarmaco','$describirTratamiento','$acturl2','$acturl',
						'$acturl3','$acturl4','$acturl5','$acturl6','$recomendacionesVigilancia','$tabaquismo','$alcohol','$otras','$diagnosticos',
						'$pronosticoVida','$pronosticoFuncion','$nombreMedicoTratante','$cedula','$rol')";
		
			$result0 = mysqli_query($conexionMedico, $queryInsNotaEgre);
			if(!$result0) {
				echo '!<br> ERROR al insertar Nota Egreso! <br>';
				echo 'QUERY: '.$queryInsNotaEgre;
			} else {
				echo '<br>!!!! SE GUARDO LA NOTA DE EGRESO CORRECTAMENTE!!!!<br>';
				#echo 'QUERY: '.$queryInsNotaEgre;
			}
	}

	$fcFin=NULL;
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
		$antecOld = utf8_encode($rowA['antecedentes']);
		$antecOld = addslashes ($antecOld);
	}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NOTA DE EGRESO</title>

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
						<th>DIRECCIÓN</th>
					</tr>
				</thead>
					<tbody>
						<tr>
							<td><?php echo $expediente_pac ?></td>
							<td><?php echo $folio_pac ?></td>
							<td><?php echo utf8_encode($nombre_pac) ?></td>
							<td><?php echo $annios  ?></td>
							<td><?php echo $sexo_pac ?></td>
							<td><?php echo $direccion_pac ?></td>
						</tr>
					</tbody>
				</table>
			<br>
			<!--table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th style="text-align: center">TRIAGE</th>
					</tr>
					</thead>
			</table>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th>FECHA</th>
						<th>HORA</th>
						<th>MOTIVO</th>
						<th>TA</th>
						<th>FC</th>
						<th>FR</th>
						<th>TEMP.</th>
						<th>SatO2</th>
						<th>GLUCOSA</th>
						<th>PESO</th>
						<th>TALLA</th>
						<th>COLOR</th>
					</tr>
					</thead>
					<tbody>
						<?php
							/*$queryDocs = "SELECT *
										  FROM notaUrgTriage 
										  WHERE numeroExpediente='$expediente' AND folio='$folio'
										  ORDER BY fecha DESC, hora DESC
										  LIMIT 1";
							$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
							$c=1;
							while($row = mysqli_fetch_array($docs)){
								$fcFin= $row['fc'];
								$frFin= $row['fr'];
								$taFin=$row['ta'];
								$tempFin=$row['temp'];
								$soFin=$row['so'];
								$turnoFin=$row['turno'];
								$acudeFin=$row['acude'];
								$glucosaFin=$row['glucosa'];
								
								if($row['turno'] == 'M'){
									$turnoFinLetra='MATUTINO';
								} else if($row['turno'] == 'V'){
									$turnoFinLetra='VESPERTINO';
								} if($row['turno'] == 'N'){
									$turnoFinLetra='NOCTURNO';
								}
								
								$fecha = strtotime($row['fecha']);
								$fechaFin = date('d/m/Y',$fecha);

								$hora = strtotime($row['hora']);
								$horaFin = date('H:i',$hora);
						?>
						<tr>
							<td><?php echo $fechaFin ?></td>
							<td><?php echo $horaFin.'hrs' ?></td>
							<td><?php echo utf8_encode($row['motivo']) ?></td>
							<td><?php echo $row['ta'].' mmHg' ?></td>
							<td><?php echo $row['fc'].' min' ?></td>
							<td><?php echo $row['fr'].' min' ?></td>
							<td><?php echo $row['temp'].'°C' ?></td>
							<td><?php echo $row['so'] ?></td>
							<td><?php echo $row['glucosa'].' mg/dl' ?></td>
							<td><?php echo $row['peso'].' Kg' ?></td>
							<td><?php echo $row['talla'].' Mts' ?></td>
							<td><?php echo $row['color'] ?></td>
							<?php }*/ ?>
						</tr>
					</tbody>
				</table-->
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-15 col-lg-offset-13 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
					
                    	<form role="form" action="" method="post">

                    		<h3>NOTA DE EGRESO HOSPITALARIO</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-3">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50.25" data-number-of-steps="2" style="width: 50.25%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                    				<p>DATOS DE EGRESO </p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>TRATAMIENTO Y RECOMENDACIONES</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<!--div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                    				<p>Exploración Física</p>
                    			</div-->
								<!-- Step 3 -->
								
								<!-- Step 4 -->
								<!--div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>Diagnostico y Tratamiento</p>
                    			</div-->
								<!-- Step 4 -->
                    		</div>
							<!-- Form progress -->
                    		
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>DATOS DE EGRESO: <span> Paso 1 - 2 </span></h4>
								<div class="form-group">
                    			    <label>MOTIVO DE EGRESO : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="motivoEgreso" value="Mejoría" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; Mejoría
									</label>
									<label class="radio-inline">
									  <input type="radio" name="motivoEgreso" value="Alta Voluntaria" style="width: 30px; height: 30px">&nbsp;&nbsp; Alta Voluntaria
									</label>
									<label class="radio-inline">
									  <input type="radio" name="motivoEgreso" value="Traslado" style="width: 30px; height: 30px">&nbsp;&nbsp; Traslado
									</label>
									<label class="radio-inline">
									  <input type="radio" name="motivoEgreso" value="Defunción" style="width: 30px; height: 30px">&nbsp;&nbsp; Defunción
									</label>
                                </div>
								<div class="form-group">
									<label>FECHA DE EGRESO : <span>*</span></label>
									<input type="date" name="fechaEgreso" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>HORA DE EGRESO : <span>*</span></label>
									<input type="time" name="horaEgreso" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
                    			    <label>DIAGNÓSTICO DE INGRESO: <span>*</span></label>
                                    <textarea class="form-control required" name="diagnosticoIngreso" id="habitacion" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>DIAGNÓSTICO DE EGRESO: <span>*</span></label>
                                    <textarea class="form-control required" name="diagnosticoEgreso" id="habitacion" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>RESUMEN DE LA EVOLUCIÓN Y ESTADO ACTUAL: <span>*</span></label>
                                    <textarea class="form-control required" name="resumenEvolucion" id="habitacion" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>MANEJO Y TRATAMIENTO HOSPITALARIO: <span>*</span></label>
                                    <textarea class="form-control required" name="manejoTratamiento" id="habitacion" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>PROBLEMAS CLÍNICOS PENDIENTES: <span>*</span></label>
                                    <textarea class="form-control required" name="problemasClinicos" id="habitacion" cols="10" rows="3"></textarea>
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
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>TRATAMIENTO Y RECOMENDACIONES: <span>Paso 2 - 2</span></h4>
								<div class="form-group">
                    			    <label>EGRESA CON TRATAMIENTO FARMACOLÓGICO : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="tratamientoFarmaco" value="SI" onclick="mostrar0('1')" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tratamientoFarmaco" value="NO" onclick="mostrar0('0')" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
                                </div>
								
								<div id="final" style="display:none">
									<div class="form-group">
										<label>DESCRIBIR TRATAMIENTO: </label>
										<textarea class="form-control" name="describirTratamiento" id="describirTratamiento" cols="10" rows="3"></textarea>
									</div>
									<div class="form-group">
									<h3>MEDICAMENTOS</h3>
										<label>NOMBRE DEL MÉDICAMENTO : <span>* (Medicamentos en rojo ALTO RIESGO)</span></label>
										<input type="text" name="medicamento" id="service" class="form-control" autocomplete="off">
										<input type="hidden" size="10" id="idMed" name="idMed" accept-charset="utf-8" >
										<input id="sal" name="sal" type="hidden" accept-charset="utf-8" >
										<input id="exist" name="exist" type="hidden" >

										<!--div style="height: 200px"-->
											<div id="suggestions" style="height: 180px; overflow: auto" ></div>
										<!--/div-->
										<br>
										<label> DOSIS : <span>*</span></label>
										<textarea class="form-control" name="indicacion" id="indicacion" cols="10" rows="3"></textarea>
										<label> VÍA : <span>*</span></label>
										<textarea class="form-control" name="via" id="via" cols="10" rows="3"></textarea>
										<label> INTERVALO : <span>*</span></label>
										<textarea class="form-control" name="intervalo" id="intervalo" cols="10" rows="3"></textarea>
										<label> DÍAS : <span>*</span></label>
										<textarea class="form-control" name="dias" id="dias" cols="10" rows="3"></textarea>

										<br>
										<button id="adicionar" class="btn btn-success" type="button">Agregar Medicamento</button>
									</div>

									<p>Medicamentos Agregados:
									  <div id="adicionados"></div>
									</p>
									<table id="mytable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Medicamento</th>
											<th>Dosis</th>
											<th>Vía</th>
											<th>Intervalo</th>
											<th>Días</th>
											<th>Eliminar</th>
										</tr>
									  </thead>
									  <tbody id="ProSelected">
									</tbody>
									</table>
								</div>
								<br/>
								<div class="form-group">
                    			    <label>RECOMENDACIONES PARA LA VIGILANCIA AMBULATORIA : <span>*</span></label>
                                    <textarea class="form-control required" name="recomendacionesVigilancia" id="recomendacionesVigilancia" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>ATENCIÓN DE FACTORES DE RIESGO : <span>*</span></label>
									<br>
									<label class="checkbox-inline"> TABAQUISMO
									  <input type="checkbox" name="tabaquismo" style="width: 45px; height: 35px" value="1" >
									</label>
									<label class="checkbox-inline">ALCOHOLISMO
									  <input type="checkbox" name="alcohol" style="width: 45px; height: 35px" value="1">
									</label>
									<label class="checkbox-inline">OTRAS ADICCIONES
									  <input type="checkbox" name="otras" style="width: 45px; height: 35px" value="1"> 
									</label>
                                </div>
								<br/>
								<h4>PRONÓSTICO : </h4>
								<div class="form-group">
                    			    <label>VIDA : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="pronosticoVida" value="BUENO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; BUENO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoVida" value="MALO" style="width: 30px; height: 30px">&nbsp;&nbsp; MALO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoVida" value="RESERVADO" style="width: 30px; height: 30px">&nbsp;&nbsp; RESERVADO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>FUNCIÓN : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="pronosticoFuncion" value="BUENO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; BUENO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoFuncion" value="MALO" style="width: 30px; height: 30px">&nbsp;&nbsp; MALO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoFuncion" value="RESERVADO" style="width: 30px; height: 30px">&nbsp;&nbsp; RESERVADO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>EN CASO DE DEFUNCIÓN, ANOTAR LOS DIAGNÓSTICOS :</label>
									<textarea class="form-control" name="diagnosticos" id="diagnosticos" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
									<h4>DATOS DEL MÉDICO:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off" required>
									<br>
									<div id="suggestions1"></div>
								</div>
								<h6>*Si no conoce la cedula del medico tratante colocar el nombre, si ya colocó una cedula no llenar</h6>
								<div class="form-group">
                    			    <label>NOMBRE DEL MEDICO TRATANTE : </label>
                                    <input class="form-control " type="text"  name="nombreMedicoTratante" id="nombreMedicoTratante">
                                </div>
								<br/>
								<input type="hidden" id="ListaPro" name="ListaPro" value="" >
								<input type="hidden" id="ListaPro2" name="ListaPro2" value="">
								<input type="hidden" id="ListaPro3" name="ListaPro3" value="" >
								<input type="hidden" id="ListaPro4" name="ListaPro4" value="" >
								<input type="hidden" id="ListaPro5" name="ListaPro5" value="" >
								<input type="hidden" id="ListaPro6" name="ListaPro6" value="" >
							
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">
									<button type="button"  class="btn btn-previous">Anterior</button>
                                    <button type="submit" name="enviar" onclick="creaArr();" class="btn btn-submit" >Guardar</button>
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
			//funcion para mostrar/ocultar la captura de medicamentos
			function mostrar0(v){
				if(v == '1'){
					document.getElementById('final').style="display:block";					
				} else {
					document.getElementById('final').style="display:none";
				}
			}
			
		//Funcion para autocomplementar los Medicos
		var id1 = "";
		  $(document).ready(function(e) {
			$('#cedula').bind('input keyup', function(){
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
							$('#cedula').val(ced);
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
	<!--LO DE LOS MEDICAMENTOS-->
	<script type="text/javascript">
			var c=0;//contador para asignar id al boton que borrara la fila
		
			//Funcion para acomodar la fecha de AAAA-MM-DD a DD/MM/AAAA
			/*function convertDateFormat(string) {
				var info = string.split('-').reverse().join('/');
        		return info;
			}*/
		    	
		 $(document).ready(function() {
			//obtenemos el valor de los input
			$('#adicionar').click(function() {
			  	var indicacion = document.getElementById("indicacion").value;
			  	indicacion = indicacion.trim();
				document.getElementById("indicacion").value='';
				
				var via = document.getElementById("via").value;
			  	via = via.trim();
				document.getElementById("via").value='';
				
				var intervalo = document.getElementById("intervalo").value;
			  	intervalo = intervalo.trim();
				document.getElementById("intervalo").value='';
				
				var dias = document.getElementById("dias").value;
			  	dias = dias.trim();
				document.getElementById("dias").value='';
				
				var medicamento = document.getElementById("service").value;
			  	medicamento = medicamento.trim();
				document.getElementById("service").value='';
				
				var existencias = document.getElementById("exist").value;
			  	existencias = existencias.trim();
				document.getElementById("exist").value='';
				
				var medId = document.getElementById("idMed").value;
			  	medId = medId.trim();
				document.getElementById("idMed").value='';
				
				var salN = document.getElementById("sal").value;
			  	salN = salN.trim();
				document.getElementById("sal").value='';
				
				/*var horaIndicacion = document.getElementById("horaIndicacion").value;
			  	horaIndicacion = horaIndicacion.trim();*/
			  //var cantidad = document.getElementById("cantidad").value;
			  //var i = 1; //contador para asignar id al boton que borrara la fila
			  c++;
			  //var fila = '<tr>';
			  var fila = '<tr class="item"> <td><input id="nMedicamento' + c + '" name="nMedicamento[' + c + ']" type="text" style="width: 350px; height: 28px" value="'+medicamento+'" /></td> ';
			  //fila = fila + '<td> <input id="hIndic[' + c + ']" name="hIndic[' + c + ']" type="time" value="'+horaIndicacion+'" /></td>';
			  //fila = fila + '<td><textarea id="nIndicacion' + c + '" name="nIndicacion[' + c + ']">'+indicacion+'</textarea></td> ';
			  fila = fila + '<td><input id="nIndicacion' + c + '" name="nIndicacion[' + c + ']" type="text" style="width: 100px; height: 28px" value="'+indicacion+'"</td> ';
			  fila = fila + '<td><input id="nVia' + c + '" name="nVia[' + c + ']" type="text" style="width: 100px; height: 28px" value="'+via+'"</td> ';
			  fila = fila + '<td><input id="nIntervalo' + c + '" name="nIntervalo[' + c + ']" type="text" style="width: 100px; height: 28px" value="'+intervalo+'"</td> ';
			  fila = fila + '<td><input id="nDias' + c + '" name="nDias[' + c + ']" type="text" style="width: 100px; height: 28px" value="'+dias+'"</td> ';
			  //fila = fila + '<td><input id="nExist' + c + '" name="nExist[' + c + ']" type="text" style="width: 50px; height: 28px" value="'+existencias+'" disabled /> <input id="idMed' + c + '" name="idMed[' + c + ']" type="hidden" value="'+medId+'" /> <input id="nSal' + c + '" name="nSal[' + c + ']" type="hidden" value="'+salN+'" /> </td> ';
			  fila = fila + '<td><button type="button" name="remove" id="' + c + '" class="btn btn-danger btn_remove">Quitar</button></td> </tr>';
		  	  //'<tr id="row' + i + '"><td>indicacion + '</td><td>' + cantidad + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
			  $('#ProSelected').append(fila);
			  $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
			  var nFilas = $("#mytable tr").length;
			  $("#adicionados").append(nFilas - 1);
			  //le resto 1 para no contar la fila del header
			  document.getElementById("service").value = "";
			  document.getElementById("indicacion").value = "";
			  document.getElementById("via").value = "";
			  document.getElementById("intervalo").value = "";
			  document.getElementById("dias").value = "";
			  document.getElementById("service").focus();
		  });
		  
		$(document).on('click', '.btn_remove', function() {
		  var button_id = $(this).attr("id");
		    //cuando da click obtenemos el id del boton
		    //$('#row' + button_id + '').remove(); //borra la fila
		    $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
            if ($('#ProSelected tr.item').length == 0)
                $('#ProSelected .no-item').slideDown(300);

		    //limpia el para que vuelva a contar las filas de la tabla
		    $("#adicionados").text("");
		    var nFilas = $("#mytable tr").length;
		    $("#adicionados").append(nFilas - 1);
		  });
		});
		
		function creaArr(){
			var ip = [];
			var ip2 = [];
			var ip3 = [];
			var ip4 = [];
			var ip5 = [];
			var ip6 = [];
			
			$('input[name^="nMedicamento"]').each(function() {
		   	 //alert($(this).val());
		   	 ip.push({ medicamentoI : $(this).val().trim() });
			});
			var ipt=JSON.stringify(ip);
			$('#ListaPro').val(encodeURIComponent(ipt));
        	//document.getElementById("valores").innerHTML = ipt;
        	
			$('input[name^="idMed"]').each(function() {
		   	 //alert($(this).val());
		   	 ip2.push({ medI : $(this).val() });
			});
			var ipt2=JSON.stringify(ip2);
			$('#ListaPro2').val(encodeURIComponent(ipt2));
        	//document.getElementById("valores").innerHTML = ipt;
			
			$('input[name^="nIndicacion"]').each(function() {//indicacion textarea nIndicacion
		   	 //alert($(this).val());
		   	 ip3.push({ nameI : $(this).val() });
			});
			var ipt3=JSON.stringify(ip3);
			$('#ListaPro3').val(encodeURIComponent(ipt3));
			
			$('input[name^="nVia"]').each(function() {
		   	 //alert($(this).val());
		   	 ip4.push({ viaI : $(this).val() }); //salI
			});
			var ipt4=JSON.stringify(ip4);
			$('#ListaPro4').val(encodeURIComponent(ipt4));
			
			$('input[name^="nIntervalo"]').each(function() {
		   	 //alert($(this).val());
		   	 ip5.push({ intervaloI : $(this).val() }); //existI
			});
			var ipt5=JSON.stringify(ip5);
			$('#ListaPro5').val(encodeURIComponent(ipt5));
			
			$('input[name^="nDias"]').each(function() {
		   	 //alert($(this).val());
		   	 ip6.push({ diasI : $(this).val() });
			});
			var ipt6=JSON.stringify(ip6);
			$('#ListaPro6').val(encodeURIComponent(ipt6));
		}
		//Funcion para autocomplemento del campo de Medicamentos
		var id = "";
		$(document).ready(function(e) {
			//Al escribr dentro del input con id="service"
			//$('#service').keypress(function(){
			//$('#service').on('keydown', (function(){
			//$('#service').keydown(function(){
			//$('#service').keyup(function(){
			$('#service').bind('input keyup', function(){
				//Obtenemos el value del input
				var service = $(this).val();
				var dataString0 = 'service='+service;
				var n = dataString0.length;
				if(n > 11){
					var dataString = dataString0;
				} else {
					var dataString = 'service=" "';
				}
				//Le pasamos el valor del input al ajax
				$.ajax({
					type: "POST",
					url: "autocomplete.php",
					data: dataString,
					//Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
					//async: false,
					success: function(data){
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions').fadeIn(1000).html(data);
						//$('#suggestions')
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id = $(this).attr('id'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medicamento
							var sal = $(this).attr('sal'); //Nombre de la Sal
							var exist = $(this).attr('exist');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							$('#service').val(valor);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions').fadeOut(100);
							//$('#result').html('<p>Has seleccionado el '+id+' '+$('#'+id).attr('data')+'</p>');
							//Add valor del id del elemento seleccionado
							$('#idMed').val(id);
							$('#sal').val(sal);
							$('#exist').val(exist);
						});
					}
				});
			});
		});
	</script>

    </body>

</html>