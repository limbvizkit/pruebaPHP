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
		if (isset($_POST['antecedentes']))
		{
			$antecedentes = utf8_decode($_POST['antecedentes']);
			$antecedentes = addslashes($antecedentes);
		}
		/*if (isset($_POST['tratamiento']))
		{
			$tratamiento=utf8_decode($_POST['tratamiento']);
		}*/
		if (isset($_POST['interrogatorio']))
		{
			$interrogatorio=utf8_decode($_POST['interrogatorio']);
			$interrogatorio = addslashes($interrogatorio);
		}
		#2
		if (isset($_POST['hora']))
		{
			$hora=$_POST['hora'];
		}
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['acude']))
		{
			$acude=$_POST['acude'];
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
		if (isset($_POST['so']))
		{
			$so=$_POST['so'];
		}
		if (isset($_POST['glucosa']))
		{
			$glucosa=$_POST['glucosa'];
		}
		if (isset($_POST['habExt']))
		{
			$habExt=utf8_decode($_POST['habExt']);
			$habExt = addslashes($habExt);
		}
		if (isset($_POST['cabeza']))
		{
			$cabeza=utf8_decode($_POST['cabeza']);
			$cabeza = addslashes($cabeza);
		}
		if (isset($_POST['torax']))
		{
			$torax=utf8_decode($_POST['torax']);
			$torax=addslashes($torax);
		}
		if (isset($_POST['abdomen']))
		{
			$abdomen=utf8_decode($_POST['abdomen']);
			$abdomen=addslashes ($abdomen);
		}
		if (isset($_POST['extremidades']))
		{
			$extremidades=utf8_decode($_POST['extremidades']);
			$extremidades=addslashes ($extremidades);
		}
		#3
		if (isset($_POST['diag']))
		{
			$diag=utf8_decode($_POST['diag']);
			$diag=addslashes ($diag);
		}
		if (isset($_POST['tratamientoFin']))
		{
			$tratamientoFin=utf8_decode($_POST['tratamientoFin']);
			$tratamientoFin=addslashes($tratamientoFin);
		}
		if (isset($_POST['pronosticoVida']))
		{
			$pronosticoVida=utf8_decode($_POST['pronosticoVida']);
		}
		if (isset($_POST['pronosticoFuncion']))
		{
			$pronosticoFuncion=utf8_decode($_POST['pronosticoFuncion']);
		}
		if (isset($_POST['horaFin']))
		{
			$horaFin=$_POST['horaFin'];
		}
		if (isset($_POST['resEst']))
		{
			$resEst=utf8_decode($_POST['resEst']);
			$resEst=addslashes ($resEst);
		}
		if (isset($_POST['ingresa']))
		{
			$ingresa=utf8_decode($_POST['ingresa']);
			$ingresa=addslashes($ingresa);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		/*if (isset($_POST['especialidad']))
		{
			$especialidad=utf8_decode($_POST['especialidad']);
		}*/
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' 
		'.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsUrg = "INSERT INTO notaUrg (id,numeroExpediente,folio,antecedentes,interrogatorio,hora,fc,fr,ta,temp,so,glucosa,habExt,cabeza,torax,
						abdomen,extremidades,resEst,diag,tratamientoFin,pronosticoVida,pronosticoFuncion,horaFin,turno,acude,ingresa,cedula,usr)
					VALUES (NULL,'$expediente','$folio','$antecedentes','$interrogatorio','$hora','$fc','$fr','$ta','$temp','$so','$glucosa','$habExt',
					'$cabeza','$torax','$abdomen','$extremidades','$resEst','$diag','$tratamientoFin','$pronosticoVida','$pronosticoFuncion',
					'$horaFin','$turno','$acude','$ingresa','$cedula','$rol')";
		
			$result0 = mysqli_query($conexionMedico, $queryInsUrg);
			if(!$result0) {
				echo '!<br> ERROR al insertar Nota de Urgencias! <br>';
				echo 'QUERY: '.$queryInsUrg;
			} else {
				echo '<br>!!!! SE GUARDO LA NOTA DE URGENCIAS CORRECTAMENTE!!!!<br>';
				if($ingresa != 'EGRESO'){
					$val='1';
				}
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
		$antecOld= utf8_encode($rowA['antecedentes']);
		$antecOld=addslashes ($antecOld);
	}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NOTA URGENCIAS</title>

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

    <body onload="mostrarVent(<?php echo $val ?>)">		
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
							<td><?php echo $annios  ?></td>
							<td><?php echo $sexo_pac ?></td>
							<td><?php echo $obligado_pac ?></td>
						</tr>
					</tbody>
				</table>
			<br>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
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
							$queryDocs = "SELECT *
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
							<?php } ?>
						</tr>
					</tbody>
				</table>
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
					
                    	<form role="form" action="" method="post">

                    		<h3>NOTA MEDICA DE CONSULTA-URGENCIAS</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-3">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Antecedentes</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                    				<p>Exploración</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-flask" aria-hidden="true"></i></div>
                    				<p>Diagnósticos</p>
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
                    		    <h4>ANTECEDENTES: <span>Paso 1 - 3</span></h4>
								<div class="form-group">
									<label>HORA DE INICIO DE CONSULTA : <span>*</span></label>
									<input type="time" name="hora" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>TURNO : <span>*</span></label>
								   <select id="turno" name="turno" class="form-control required">
										<option value="<?php echo $turnoFin ?>"><?php echo $turnoFinLetra ?></option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="N">Nocturno</option>
									</select>
								</div>
								<div class="form-group">
									<label>FORMA EN QUE ACUDE : <span>*</span></label>
								   <select id="acude" name="acude" class="form-control required">
										<option value="<?php echo $acudeFin ?>"><?php echo $acudeFin ?></option>
										<option value="AMBULANCIA">Ambulancia</option>
										<option value="CAMINANDO">Caminando</option>
										<option value="BRAZOS">Brazos</option>
									   <option value="SILLA DE RUEDAS">Silla de Ruedas</option>
									</select>
								</div>
								<div class="form-group">
                    			    <label>ANTECEDENTES PERSONALES : <span>*</span></label>
                                    <textarea class="form-control required" name="antecedentes" id="antecedentes" cols="10" rows="3"><?php echo $antecOld ?></textarea>
                                </div>
								
								 <!--div class="form-group">
                    			    <label>TRATAMIENTO (CONCILIACIÓN DE MEDICAMENTOS) : <span></span></label>
                                    <textarea class="form-control" name="tratamiento" id="tratamiento" cols="10" rows="3"></textarea>
                                </div-->
								
								<div class="form-group">
                    			    <label>INTERROGATORIO : <span>*</span></label>
									<textarea class="form-control required" name="interrogatorio" id="interrogatorio" cols="10" rows="3"></textarea>
                                </div>
								<!--div class="container-fluid">
								<div class="row form-inline">
								<div class="form-group col-md-3 col-xs-3">
                                    <label>Date Of Birth: </label>
								</div>
								<div class="form-group col-md-3 col-xs-3">
									<label>Date: </label>
                                    <select class="form-control">
									  <option>01</option>
									  <option>02</option>
									  <option>03</option>
									  <option>04</option>
									  <option>05</option>
									</select>
								</div>
								<div class="form-group col-md-3 col-xs-3">
									<label>Month: </label>
                                    <select class="form-control">
									  <option>Jan</option>
									  <option>Feb</option>
									  <option>Mar</option>
									  <option>Apr</option>
									  <option>May</option>
									</select>
								</div>
								<div class="form-group col-md-3 col-xs-3">
									<label>Year: </label>
                                    <select class="form-control">
									  <option>2017</option>
									  <option>2018</option>
									  <option>2019</option>
									  <option>2020</option>
									  <option>2021</option>
									</select>
								</div>
                                </div>
								</div-->
								<!--div class="form-group">
                    			    <label>Maratial Status: </label>
                                    <select class="form-control">
										<option value="">Select Status ...</option>
										<option value="Married">Married</option>
										<option value="Divorced">Divorced</option>
										<option value="Un-Married">Un-Married</option>
										<option value="Widowed">Widowed</option>
									</select>
                                </div>
                                
								<div class="form-group">
                    			    <label>Password: <span>*</span></label>
                                    <input type="password" name="Password" placeholder="User Password" class="form-control required">
                                </div-->
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
                                <h4>EXPLORACIÓN FISICA : <span>Paso 2 - 3</span></h4>
								<div class="container-fluid">
									<label>SIGNOS VITALES: <span></span></label>
									<div class="row form-inline">
										<!--div class="form-group col-md-6 col-xs-6">
											<label>HORA : <span>*</span></label>
											<input type="time" name="hora" class="form-control required" autocomplete="off">
										</div-->
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
											<label>SO2 : <span>*</span></label>
											<input type="text" name="so" class="form-control required" value="<?php echo $soFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>GLUCOSA : <span></span></label>
											<input type="text" name="glucosa" placeholder="mg/dl" class="form-control" value="<?php echo $glucosaFin ?>" autocomplete="off">
										</div>
									</div>									
								</div>
								<br/>
								<!--div class="form-group">
                    			    <label>VALORACIÓN NEUROLÓGICA : <span></span></label><br/>
                                    <div class="container-fluid">
									<div class="row form-inline">
										<div class="form-group col-md-6 col-xs-6">
											<label>RESPUESTA OCULAR : <span></span></label>
											<input type="text" name="respOcul" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>RESPUESTA VERBAL : <span></span></label>
											<input type="text" name="respVerb" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>RESPUESTA MOTORIA : <span></span></label>
											<input type="text" name="respMot" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TOTAL : <span></span></label>
											<input type="text" name="total" class="form-control" autocomplete="off">
										</div>
									</div>
								</div>
                                </div-->
                                <div class="form-group">
                    			    <label>ESTADO MENTAL Y HABITUS EXTERIOR : <span>*</span></label>
									<textarea class="form-control required" name="habExt" id="habExt" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="habExt" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>CABEZA : <span>*</span></label>
									<textarea class="form-control required" name="cabeza" id="cabeza" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="cabeza" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>TÓRAX : <span>*</span></label>
									<textarea class="form-control required" name="torax" id="torax" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="torax" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>ABDOMEN : <span>*</span></label>
									<textarea class="form-control required" name="abdomen" id="abdomen" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="abdomen" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>EXTREMIDADES : <span>*</span></label>
									<textarea class="form-control required" name="extremidades" id="extremidades" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
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
                                <h4><span>Paso 3 - 3</span></h4>
								<div class="form-group">
                    			    <label>RESULTADOS DE ESTUDIOS : <span></span></label>
                                    <textarea class="form-control" name="resEst" id="resEst" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>DIAGNÓSTICOS : <span>*</span></label>
                                    <textarea class="form-control required" name="diag" id="diag" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>TRATAMIENTO : <span>*</span></label>
									<textarea class="form-control required" name="tratamientoFin" id="tratamientoFin" cols="15" rows="3"></textarea>
                                </div>
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
									<label>HORA DE FIN DE CONSULTA : <span>*</span></label>
									<input type="time" name="horaFin" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
                    			    <label>INGRESA A : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="ingresa" value="HOSPITALIZACIÓN" style="width: 30px; height: 30px" checked="checked"> &nbsp;&nbsp;HOSPITALIZACIÓN
									</label>
									<label class="radio-inline">
									  <input type="radio" name="ingresa" value="UCI" style="width: 30px; height: 30px">&nbsp;&nbsp; UCI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="ingresa"alue="UCIPYN" style="width: 30px; height: 30px">&nbsp;&nbsp; UCIPYN
									</label>									
									<label class="radio-inline">
									  <input type="radio" name="ingresa" value="QUIRÓFANO" style="width: 30px; height: 30px">&nbsp;&nbsp; QUIRÓFANO
									</label>
									<!--label class="radio-inline">
									  <input type="radio" name="ingresa" id="ingresa" value="TRASLADO"> TRASLADO
									</label-->
									<label class="radio-inline">
									  <input type="radio" name="ingresa" value="EGRESO" style="width: 30px; height: 30px">&nbsp;&nbsp; EGRESO
									</label>
                                </div>
								<!--div class="form-group">
									<h4>DATOS DEL MÉDICO:</h4>
                    			    <label>CEDULA PROFESIONAL : <span>*</span></label>
									<input type="text" name="cedula" class="form-control required" autocomplete="off">
                                </div-->
								<div class="form-group">
									<h4>DATOS DEL MÉDICO:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off" required>
									<br>
									<div id="suggestions1"></div>
								</div>								
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">
									<button type="button"  class="btn btn-previous">Anterior</button>
                                    <button type="submit" name="enviar" class="btn btn-submit" >Guardar</button>
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
		function mostrarVent(s){
				if(s == '1'){
					window.open('notaTraslServ.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente?>&folio=<?php echo $folio ?>', '_blank');
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
    </body>

</html>