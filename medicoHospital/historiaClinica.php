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
		#1
		if (isset($_POST['hora']))
		{
			$hora=$_POST['hora'];
		}
		if (isset($_POST['tipoInterroga']))
		{
			$tipoInterroga=utf8_decode($_POST['tipoInterroga']);
		}
		if (isset($_POST['edoCivil']))
		{
			$edoCivil=utf8_decode($_POST['edoCivil']);
		}
		if (isset($_POST['ocupacion']))
		{
			$ocupacion=utf8_decode($_POST['ocupacion']);
		}
		if (isset($_POST['lugarOrigen']))
		{
			$lugarOrigen=utf8_decode($_POST['lugarOrigen']);
		}
		if (isset($_POST['escolaridad']))
		{
			$escolaridad=utf8_decode($_POST['escolaridad']);
		}
		if (isset($_POST['religion']))
		{
			$religion=utf8_decode($_POST['religion']);
		}
		if (isset($_POST['grupoRH']))
		{
			$grupoRH=utf8_decode($_POST['grupoRH']);
		}
		if (isset($_POST['antecedentesHeredo']))
		{
			$antecedentesHeredo = utf8_decode($_POST['antecedentesHeredo']);
			$antecedentesHeredo = addslashes($antecedentesHeredo);
		}
		if (isset($_POST['habitacion']))
		{
			$habitacion=utf8_decode($_POST['habitacion']);
			$habitacion = addslashes($habitacion);
		}
		if (isset($_POST['habitos']))
		{
			$habitos=utf8_decode($_POST['habitos']);
			$habitos = addslashes($habitos);
		}
		if (isset($_POST['alimentacion']))
		{
			$alimentacion=utf8_decode($_POST['alimentacion']);
			$alimentacion = addslashes($alimentacion);
		}
		if (isset($_POST['actividadFisica']))
		{
			$actividadFisica = utf8_decode($_POST['actividadFisica']);
			$actividadFisica = addslashes($actividadFisica);
		}
		if (isset($_POST['inmunizaciones']))
		{
			$inmunizaciones=utf8_decode($_POST['inmunizaciones']);
			$inmunizaciones = addslashes($inmunizaciones);
		}
		if (isset($_POST['antecedentesPatologicos']))
		{
			$antecedentesPatologicos=utf8_decode($_POST['antecedentesPatologicos']);
			$antecedentesPatologicos = addslashes($antecedentesPatologicos);
		}
		if (isset($_POST['tabaco']))
		{
			$tabaco=$_POST['tabaco'];
		}
		if (isset($_POST['alcohol']))
		{
			$alcohol=$_POST['alcohol'];
		}
		if (isset($_POST['drogas']))
		{
			$drogas=$_POST['drogas'];
		}
		if (isset($_POST['conciliacionMedicamentos']))
		{
			$conciliacionMedicamentos=utf8_decode($_POST['conciliacionMedicamentos']);
			$conciliacionMedicamentos = addslashes($conciliacionMedicamentos);
		}
		if (isset($_POST['antecedentesGineco']))
		{
			$antecedentesGineco=utf8_decode($_POST['antecedentesGineco']);
			$antecedentesGineco = addslashes($antecedentesGineco);
		}
		if (isset($_POST['antecedentesPediatricos']))
		{
			$antecedentesPediatricos=utf8_decode($_POST['antecedentesPediatricos']);
			$antecedentesPediatricos = addslashes($antecedentesPediatricos);
		}
		
		#2
		if (isset($_POST['padecimientoActual']))
		{
			$padecimientoActual=utf8_decode($_POST['padecimientoActual']);
			$padecimientoActual = addslashes($padecimientoActual);
		}
		if (isset($_POST['sintomas']))
		{
			$sintomas=utf8_decode($_POST['sintomas']);
			$sintomas = addslashes($sintomas);
		}
		if (isset($_POST['respiratorio']))
		{
			$respiratorio=utf8_decode($_POST['respiratorio']);
			$respiratorio = addslashes($respiratorio);
		}
		if (isset($_POST['musculoEsquele']))
		{
			$musculoEsquele=utf8_decode($_POST['musculoEsquele']);
			$musculoEsquele = addslashes($musculoEsquele);
		}
		if (isset($_POST['digestivo']))
		{
			$digestivo=utf8_decode($_POST['digestivo']);
			$digestivo = addslashes($digestivo);
		}
		if (isset($_POST['genital']))
		{
			$genital=utf8_decode($_POST['genital']);
			$genital = addslashes($genital);
		}
		if (isset($_POST['endocrino']))
		{
			$endocrino=utf8_decode($_POST['endocrino']);
			$endocrino = addslashes($endocrino);
		}
		if (isset($_POST['nervioso']))
		{
			$nervioso=utf8_decode($_POST['nervioso']);
			$nervioso = addslashes($nervioso);
		}
		if (isset($_POST['hematologico']))
		{
			$hematologico=utf8_decode($_POST['hematologico']);
			$hematologico = addslashes($hematologico);
		}
		if (isset($_POST['psicologico']))
		{
			$psicologico=utf8_decode($_POST['psicologico']);
			$psicologico = addslashes($psicologico);
		}
		if (isset($_POST['urinario']))
		{
			$urinario=utf8_decode($_POST['urinario']);
			$urinario = addslashes($urinario);
		}
		if (isset($_POST['cardiocirculatorio']))
		{
			$cardiocirculatorio=utf8_decode($_POST['cardiocirculatorio']);
			$cardiocirculatorio = addslashes($cardiocirculatorio);
		}
		if (isset($_POST['pielFaneras']))
		{
			$pielFaneras=utf8_decode($_POST['pielFaneras']);
			$pielFaneras = addslashes($pielFaneras);
		}
		
		#3
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
		if (isset($_POST['peso']))
		{
			$peso=$_POST['peso'];
		}
		if (isset($_POST['talla']))
		{
			$talla=$_POST['talla'];
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
		if (isset($_POST['genitales']))
		{
			$genitales=utf8_decode($_POST['genitales']);
			$genitales=addslashes ($genitales);
		}
		if (isset($_POST['neurologico']))
		{
			$neurologico=utf8_decode($_POST['neurologico']);
			$neurologico=addslashes ($neurologico);
		}
		if (isset($_POST['pielFaneras2']))
		{
			$pielFaneras2=utf8_decode($_POST['pielFaneras2']);
			$pielFaneras2=addslashes ($pielFaneras2);
		}
		if (isset($_POST['columnavertebral']))
		{
			$columnavertebral=utf8_decode($_POST['columnavertebral']);
			$columnavertebral=addslashes ($columnavertebral);
		}
		
		#4
		if (isset($_POST['estudiosGabinete']))
		{
			$estudiosGabinete=utf8_decode($_POST['estudiosGabinete']);
			$estudiosGabinete=addslashes ($estudiosGabinete);
		}
		if (isset($_POST['terapeutica']))
		{
			$terapeutica=utf8_decode($_POST['terapeutica']);
			$terapeutica=addslashes ($terapeutica);
		}
		if (isset($_POST['criteriosEspecializadas']))
		{
			$criteriosEspecializadas=utf8_decode($_POST['criteriosEspecializadas']);
			$criteriosEspecializadas=addslashes ($criteriosEspecializadas);
		}
		if (isset($_POST['educacionEspecial']))
		{
			$educacionEspecial=utf8_decode($_POST['educacionEspecial']);
			$educacionEspecial=addslashes ($educacionEspecial);
		}
		if (isset($_POST['gestionEquipo']))
		{
			$gestionEquipo=utf8_decode($_POST['gestionEquipo']);
			$gestionEquipo=addslashes ($gestionEquipo);
		}
		if (isset($_POST['procesosAdmin']))
		{
			$procesosAdmin=utf8_decode($_POST['procesosAdmin']);
			$procesosAdmin=addslashes ($procesosAdmin);
		}
		if (isset($_POST['diagnostico']))
		{
			$diagnostico=utf8_decode($_POST['diagnostico']);
			$diagnostico=addslashes ($diagnostico);
		}
		if (isset($_POST['pronosticoVida']))
		{
			$pronosticoVida=utf8_decode($_POST['pronosticoVida']);
		}
		if (isset($_POST['pronosticoFuncion']))
		{
			$pronosticoFuncion=utf8_decode($_POST['pronosticoFuncion']);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' 
		'.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsHistClin = "INSERT INTO historiaclinica (id,numeroExpediente,folio,hora,tipoInterroga,edoCivil,ocupacion,lugarOrigen,escolaridad,
						religion,grupoRH,antecedentesHeredo,habitacion,habitos,alimentacion,actividadFisica,inmunizaciones,antecedentesPatologicos,tabaco,alcohol,drogas,
						conciliacionMedicamentos,antecedentesGineco,antecedentesPediatricos,padecimientoActual,sintomas,respiratorio,musculoEsquele,
						digestivo,genital,endocrino,nervioso,hematologico,psicologico,urinario,cardiocirculatorio,pielFaneras,fc,fr,ta,temp,so,glucosa,
						peso,talla,habExt,cabeza,torax,abdomen,extremidades,genitales,neurologico,pielFaneras2,columnavertebral,estudiosGabinete,
						terapeutica,criteriosEspecializadas,educacionEspecial,gestionEquipo,procesosAdmin,diagnostico,pronosticoVida,pronosticoFuncion,
						cedula,usr)
					VALUES (NULL,'$expediente','$folio','$hora','$tipoInterroga','$edoCivil','$ocupacion','$lugarOrigen','$escolaridad',
					'$religion','$grupoRH','$antecedentesHeredo','$habitacion','$habitos','$alimentacion','$actividadFisica','$inmunizaciones',
					'$antecedentesPatologicos','$tabaco','$alcohol','$drogas','$conciliacionMedicamentos','$antecedentesGineco','$antecedentesPediatricos','$padecimientoActual',
					'$sintomas','$respiratorio','$musculoEsquele','$digestivo','$genital','$endocrino','$nervioso','$hematologico','$psicologico',
					'$urinario','$cardiocirculatorio','$pielFaneras','$fc','$fr','$ta','$temp','$so','$glucosa','$peso','$talla','$habExt','$cabeza',
					'$torax','$abdomen','$extremidades','$genitales','$neurologico','$pielFaneras2','$columnavertebral','$estudiosGabinete',
					'$terapeutica','$criteriosEspecializadas','$educacionEspecial','$gestionEquipo','$procesosAdmin','$diagnostico','$pronosticoVida',
					'$pronosticoFuncion','$cedula','$rol')";
		
			$result0 = mysqli_query($conexionMedico, $queryInsHistClin);
			if(!$result0) {
				echo '!<br> ERROR al insertar Historia Clinica! <br>';
				echo 'QUERY: '.$queryInsHistClin;
			} else {
				echo '<br>!!!! SE GUARDO LA HISTORIA CLINICA CORRECTAMENTE!!!!<br>';
				//echo 'QUERY: '.$queryInsHistClin;
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
        <title>HISTORIA CLÍNICA</title>

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
							$queryDocs = "SELECT *
										  FROM notaUrg
										  WHERE numeroExpediente='$expediente' AND folio='$folio'
										  ORDER BY fecha DESC, hora DESC
										  LIMIT 1";
							$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
							
							$padActFin= NULL;
							$habExtFin = NULL;
							$cabezaFin = NULL;
							$toraxFin = NULL;
							$abdomenFin = NULL;
							$extremidadesFin = NULL;
							$genitalesFin = NULL;
							$neuroFin = NULL;
							$pielFin = NULL;
							$columnaFin = NULL;
							while($row = mysqli_fetch_array($docs)){
								$padActFin = $row['interrogatorio'];
								$habExtFin = $row['habExt'];
								$cabezaFin = $row['cabeza'];
								$toraxFin = $row['torax'];
								$abdomenFin = $row['abdomen'];
								$extremidadesFin = $row['extremidades'];
							}
							if($padActFin == NULL || $padActFin == ''){
								$queryDocs = "SELECT *
										  FROM notaUrgchoque
										  WHERE numeroExpediente='$expediente' AND folio='$folio'
										  ORDER BY fecha DESC, hora DESC
										  LIMIT 1";
								$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
							
								while($row = mysqli_fetch_array($docs)){
									$padActFin = $row['interrogatorio'];
									$habExtFin = $row['habExt'];
									$cabezaFin = $row['cabeza'];
									$toraxFin = $row['torax'];
									$abdomenFin = $row['abdomen'];
									$extremidadesFin = $row['extremidades'];
								}
							}
						?>
						<tr>
							<td><?php #echo $fechaFin ?></td>
							<td><?php #echo $horaFin.'hrs' ?></td>
							<td><?php #echo utf8_encode($row['motivo']) ?></td>
							<td><?php #cho $row['ta'].' mmHg' ?></td>
							<td><?php #echo $row['fc'].' min' ?></td>
							<td><?php #echo $row['fr'].' min' ?></td>
							<td><?php #echo $row['temp'].'°C' ?></td>
							<td><?php #echo $row['so'] ?></td>
							<td><?php #echo $row['glucosa'].' mg/dl' ?></td>
							<td><?php #echo $row['peso'].' Kg' ?></td>
							<td><?php #echo $row['talla'].' Mts' ?></td>
							<td><?php #echo $row['color'] ?></td>
						</tr>
					</tbody>
				</table-->
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

                    		<h3>HISTORIA CLÍNICA</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-4">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                    				<p>Datos Personales y Antecedentes</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Padecimiento e Interrogatorio</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                    				<p>Signos Vitales y Exploración Física</p>
                    			</div>
								<!-- Step 3 -->
								
								<!-- Step 4 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>Diagnostico y Tratamiento</p>
                    			</div>
								<!-- Step 4 -->
                    		</div>
							<!-- Form progress -->
                    		
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>DATOS PERSONALES: <span>Paso 1 - 4</span></h4>
								<div class="form-group">
									<label>HORA : <span>*</span></label>
									<input type="time" name="hora" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
                    			    <label>TIPO DE INTERROGATORIO : <span>*</span></label>
                                   <select id="tipoInterroga" name="tipoInterroga" class="form-control required">
										<option value="">Seleccione</option>
										<option value="MIXTO">MIXTO</option>
										<option value="DIRECTO">DIRECTO</option>
										<option value="INDIRECTO">INDIRECTO</option>
									</select>
								</div>
								<div class="form-group col-md-6 col-xs-6">
                    			    <label>ESTADO CIVIL : <span>*</span></label>
                                   <select id="edoCivil" name="edoCivil" class="form-control required">
										<option value="">Seleccione</option>
										<option value="SOLTERO">SOLTERO</option>
										<option value="CASADO">CASADO</option>
										<option value="UNIÓN LIBRE">UNIÓN LIBRE</option>
									   <option value="VIUDO">VIUDO</option>
									</select>
								</div>
								<div class="form-group col-md-6 col-xs-6">
									<label>OCUPACIÓN : <span>*</span></label>
									<input type="text" name="ocupacion" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group col-md-6 col-xs-6">
									<label>LUGAR DE ORIGEN : <span>*</span></label>
									<input type="text" name="lugarOrigen" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group col-md-6 col-xs-6">
									<label> ESCOLARIDAD : <span>*</span></label>
									<input type="text" name="escolaridad" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group col-md-6 col-xs-6">
									<label> RELIGIÓN : <span>*</span></label>
									<input type="text" name="religion" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group col-md-6 col-xs-6">
									<label>GRUPO Y RH : <span>*</span></label>
									<input type="text" name="grupoRH" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
									<h4>ANTECEDENTES:</h4>
                    			    <label>ANTECEDENTES HEREDO FAMILIARES : <span>*</span></label>
                                    <textarea class="form-control required" name="antecedentesHeredo" id="antecedentes" cols="10" rows="3"><?php #echo $antecOld ?></textarea>
                                </div>
								<br/>
								<h5>ANTECEDENTES NO PATOLÓGICOS:</h5>
								<div class="form-group">
                    			    <label>HABITACIÓN : <span>*</span></label>
                                    <textarea class="form-control required" name="habitacion" id="habitacion" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>HÁBITOS : <span>*</span></label>
                                    <textarea class="form-control required" name="habitos" id="habitos" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>ALIMENTACIÓN : <span>*</span></label>
                                    <textarea class="form-control required" name="alimentacion" id="alimentacion" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>ACTIVIDAD FÍSICA : <span>*</span></label>
                                    <textarea class="form-control required" name="actividadFisica" id="actividadFisica" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>INMUNIZACIONES : <span>*</span></label>
                                    <textarea class="form-control required" name="inmunizaciones" id="inmunizaciones" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>ANTECEDENTES PATOLÓGICOS : <span>*</span></label>
                                    <textarea class="form-control required" name="antecedentesPatologicos" id="antecedentesPatologicos" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">                    			    
									<label class="checkbox-inline"> TABACO
									  <input type="checkbox" name="tabaco" style="width: 45px; height: 35px" value="1" >
									</label>
									<label class="checkbox-inline">ALCOHOL
									  <input type="checkbox" name="alcohol" style="width: 45px; height: 35px" value="1">
									</label>
									<label class="checkbox-inline">DROGAS
									  <input type="checkbox" name="drogas" style="width: 45px; height: 35px" value="1"> 
									</label>
                                </div>
								<br>
								 <div class="form-group">
                    			    <label>CONCILIACIÓN DE MEDICAMENTOS AL INGRESO (MEDICAMENTOS, DOSIS, VÍA DE ADMINISTRACIÓN E INTERVALO INCLUIR VITAMINAS Y MINERALES) : <span>*</span></label>
                                    <textarea class="form-control required" name="conciliacionMedicamentos" id="conciliacionMedicamentos" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>ANTECEDENTES GINECO-OBSTÉTRICOS (si procede): </label>
                                    <textarea class="form-control" name="antecedentesGineco" id="antecedentesGineco" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>ANTECEDENTES PEDIÁTRICOS (si procede): </label>
                                    <textarea class="form-control" name="antecedentesPediatricos" id="antecedentesPediatricos" cols="10" rows="3"></textarea>
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
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="width: 55%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>PADECIMIENTO E INTERROGATORIO : <span>Paso 2 - 4</span></h4>
                                <div class="form-group">
                    			    <label>PADECIMIENTO ACTUAL : <span>*</span></label>
									<textarea class="form-control required" name="padecimientoActual" id="padecimientoActual" cols="10" rows="3"> <?php echo $padActFin ?> </textarea>
                                    <!--input type="text" name="habExt" class="form-control" autocomplete="off"-->
                                </div>
								<br/>
								<h5>INTERROGATORIO POR APARATOS Y SISTEMAS</h5>
								<div class="form-group">
                    			    <label>SÍNTOMAS GENERALES : <span>*</span></label>
									<textarea class="form-control required" name="sintomas" id="sintomas" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="cabeza" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>RESPIRATORIO : <span>*</span></label>
									<textarea class="form-control required" name="respiratorio" id="respiratorio" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="torax" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>MÚSCULO-ESQUELETICO : <span>*</span></label>
									<textarea class="form-control required" name="musculoEsquele" id="musculoEsquele" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="abdomen" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>DIGESTIVO : <span>*</span></label>
									<textarea class="form-control required" name="digestivo" id="digestivo" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>GENITAL : <span>*</span></label>
									<textarea class="form-control required" name="genital" id="genital" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>ENDOCRINO : <span>*</span></label>
									<textarea class="form-control required" name="endocrino" id="endocrino" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>NERVIOSO : <span>*</span></label>
									<textarea class="form-control required" name="nervioso" id="nervioso" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>HEMATOLÓGICO : <span>*</span></label>
									<textarea class="form-control required" name="hematologico" id="hematologico" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>PSICOLÓGICOS : <span>*</span></label>
									<textarea class="form-control required" name="psicologico" id="psicologico" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>URINARIO : <span>*</span></label>
									<textarea class="form-control required" name="urinario" id="urinario" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>CARDIOCIRCULATORIO : <span>*</span></label>
									<textarea class="form-control required" name="cardiocirculatorio" id="cardiocirculatorio" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>PIEL Y FANERAS : <span>*</span></label>
									<textarea class="form-control required" name="pielFaneras" id="pielFaneras" cols="10" rows="3"></textarea>
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
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>SIGNOS VITALES Y EXPLORACIÓN FÍSICA : <span>Paso 3 - 4</span></h4>
								<div class="container-fluid">
									<label>SIGNOS VITALES: <span></span></label>
									<div class="row form-inline">
										<div class="form-group col-md-6 col-xs-6">
											<label>FC : <span>*</span></label>
											<input type="text" placeholder="min" name="fc" class="form-control required" value="<?php #echo $fcFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>FR : <span></span>*</label>
											<input type="text" placeholder="min" name="fr" class="form-control required" value="<?php #echo $frFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>T/A : <span>*</span></label>
											<input type="text" name="ta" placeholder="mmHg" class="form-control required" value="<?php #echo $taFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TEMP : <span>*</span></label>
											<input type="text" name="temp" placeholder="°C" class="form-control required" value="<?php #echo $tempFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>SO2 : <span>*</span></label>
											<input type="text" name="so" class="form-control required" value="<?php #echo $soFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>GLUCOSA : <span></span></label>
											<input type="text" name="glucosa" placeholder="mg/dl" class="form-control" value="<?php #echo $glucosaFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>PESO : <span>*</span></label>
											<input type="text" name="peso" placeholder="Kg" class="form-control required" value="<?php #echo $soFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TALLA : <span>*</span></label>
											<input type="text" name="talla" placeholder="mts" class="form-control required" value="<?php #echo $glucosaFin ?>" autocomplete="off">
										</div>
									</div>									
								</div>
								<br/>
                    			<h5>EXPLORACIÓN FÍSICA : </h5>
								<div class="form-group">
                    			    <label>HABITUS EXTERIOR : <span>*</span></label>
									<textarea class="form-control required" name="habExt" id="habExt" cols="10" rows="3"><?php echo $habExtFin ?></textarea>
                                    <!--input type="text" name="cabeza" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>CABEZA : <span>*</span></label>
									<textarea class="form-control required" name="cabeza" id="cabeza" cols="10" rows="3"><?php echo $cabezaFin ?></textarea>
                                    <!--input type="text" name="cabeza" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>TÓRAX : <span>*</span></label>
									<textarea class="form-control required" name="torax" id="torax" cols="10" rows="3"><?php echo $toraxFin ?></textarea>
                                    <!--input type="text" name="torax" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>ABDOMEN : <span>*</span></label>
									<textarea class="form-control required" name="abdomen" id="abdomen" cols="10" rows="3"><?php echo $abdomenFin ?></textarea>
                                    <!--input type="text" name="abdomen" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>EXTREMIDADES : <span>*</span></label>
									<textarea class="form-control required" name="extremidades" id="extremidades" cols="10" rows="3"><?php echo $extremidadesFin ?></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>GENITALES : <span>*</span></label>
									<textarea class="form-control required" name="genitales" id="genitales" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>NEUROLÓGICO : <span>*</span></label>
									<textarea class="form-control required" name="neurologico" id="neurologico" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>PIEL Y FANERAS : <span>*</span></label>
									<textarea class="form-control required" name="pielFaneras2" id="pielFaneras2" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>COLUMNA VERTEBRAL : <span>*</span></label>
									<textarea class="form-control required" name="columnavertebral" id="columnavertebral" cols="10" rows="3"></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 2 -->

							<!-- Form Step 4 -->
                            <fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>DIAGNOSTICO Y TRATAMIENTO<span>Paso 4 - 4</span></h4>
								<div class="form-group">
                    			    <label>ESTUDIOS DE GABINETE Y LABORATORIO : <span></span></label>
                                    <textarea class="form-control" name="estudiosGabinete" id="estudiosGabinete" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>TERAPEUTICA EMPLEADA Y RESULTADOS OBTENIDOS (TRATAMIENTO) : <span>*</span></label>
                                    <textarea class="form-control required" name="terapeutica" id="terapeutica" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>CRITERIOS PARA IDENTIFICAR PACIENTES QUE REQUIEREN EVALUACIONES ESPECIALIZADAS ADICIONALES (Si se requiere alguna recomendación diferente del diagnóstico actual) INFORMAR, REFERIR O SOLICITAR INTERCONSULTA U OTROS : <span>*</span></label>
									<textarea class="form-control required" name="criteriosEspecializadas" id="criteriosEspecializadas" cols="15" rows="3"></textarea>
                                </div>
								<br/>
								<h5>CRITERIOS PARA PLANIFICACIÓN TEMPRANA DEL ALTA : </h5>
								<div class="form-group">
                    			    <label>EDUCACIÓN ESPECIAL : <span>*</span></label>
									<textarea class="form-control required" name="educacionEspecial" id="educacionEspecial" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>GESTIÓN DE EQUIPO A SU EGRESO : <span>*</span></label>
									<textarea class="form-control required" name="gestionEquipo" id="gestionEquipo" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>PROCESOS ADMINISTRATIVOS : <span>*</span></label>
									<textarea class="form-control required" name="procesosAdmin" id="procesosAdmin" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>DIAGNÓSTICO : <span>*</span></label>
									<textarea class="form-control required" name="diagnostico" id="diagnostico" cols="15" rows="3"></textarea>
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
								<!--div class="form-group">
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
									</label-->
									<!--label class="radio-inline">
									  <input type="radio" name="ingresa" id="ingresa" value="TRASLADO"> TRASLADO
									</label-->
									<!--label class="radio-inline">
									  <input type="radio" name="ingresa" value="EGRESO" style="width: 30px; height: 30px">&nbsp;&nbsp; EGRESO
									</label>
                                </div-->
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