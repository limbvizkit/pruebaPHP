<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configEpidemio.php');

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
		
		if (isset($_POST['subClav']))
		{
			$subClav=$_POST['subClav'];
		}
		if (isset($_POST['yugular']))
		{
			$yugular=$_POST['yugular'];
		}
		if (isset($_POST['basilica']))
		{
			$basilica=$_POST['basilica'];
		}
		if (isset($_POST['femoral']))
		{
			$femoral=$_POST['femoral'];
		}
		if (isset($_POST['anestesia']))
		{
			$anestesia=utf8_decode($_POST['anestesia']);
		}
		if (isset($_POST['lumen']))
		{
			$lumen=utf8_decode($_POST['lumen']);
		}
		if (isset($_POST['reinst']))
		{
			$reinst=$_POST['reinst'];
		}
		if (isset($_POST['nInstala']))
		{
			$nInstala=utf8_decode($_POST['nInstala']);
		}
		if (isset($_POST['instala']))
		{
			$instala=$_POST['instala'];
		}
		if (isset($_POST['otraEsp']))
		{
			$otraEsp=utf8_decode($_POST['otraEsp']);
		}
		if (isset($_POST['nAsistente']))
		{
			$nAsistente=utf8_decode($_POST['nAsistente']);
		}
		if (isset($_POST['superviso']))
		{
			$superviso=utf8_decode($_POST['superviso']);
		}
		if (isset($_POST['consInf']))
		{
			$consInf=$_POST['consInf'];
		}		
		if (isset($_POST['consInfObs']))
		{
			$consInfObs=utf8_decode($_POST['consInfObs']);
		}
		if (isset($_POST['posCorr']))
		{
			$posCorr=$_POST['posCorr'];
		}
		if (isset($_POST['posCorrObs']))
		{
			$posCorrObs=utf8_decode($_POST['posCorrObs']);
		}
		if (isset($_POST['operador']))
		{
			$operador=$_POST['operador'];
		}
		if (isset($_POST['operadorObs']))
		{
			$operadorObs=utf8_decode($_POST['operadorObs']);
		}
		if (isset($_POST['ayudante']))
		{
			$ayudante=$_POST['ayudante'];
		}
		if (isset($_POST['ayudanteObs']))
		{
			$ayudanteObs=utf8_decode($_POST['ayudanteObs']);
		}
		if (isset($_POST['asepsia']))
		{
			$asepsia=$_POST['asepsia'];
		}
		if (isset($_POST['asepsiaObs']))
		{
			$asepsiaObs=utf8_decode($_POST['asepsiaObs']);
		}
		if (isset($_POST['antiseptico']))
		{
			$antiseptico=$_POST['antiseptico'];
		}
		if (isset($_POST['antisepticoObs']))
		{
			$antisepticoObs=utf8_decode($_POST['antisepticoObs']);
		}
		if (isset($_POST['tecnica']))
		{
			$tecnica=$_POST['tecnica'];
		}
		if (isset($_POST['tecnicaObs']))
		{
			$tecnicaObs=utf8_decode($_POST['tecnicaObs']);
		}
		if (isset($_POST['manos']))
		{
			$manos=$_POST['manos'];
		}
		if (isset($_POST['manosObs']))
		{
			$manosObs=utf8_decode($_POST['manosObs']);
		}
		if (isset($_POST['clorehixidina']))
		{
			$clorehixidina=$_POST['clorehixidina'];
		}
		if (isset($_POST['clorehixidinaObs']))
		{
			$clorehixidinaObs=utf8_decode($_POST['clorehixidinaObs']);
		}
		if (isset($_POST['cateter']))
		{
			$cateter=$_POST['cateter'];
		}
		if (isset($_POST['cateterObs']))
		{
			$cateterObs=utf8_decode($_POST['cateterObs']);
		}
		if (isset($_POST['femorales']))
		{
			$femorales=$_POST['femorales'];
		}
		if (isset($_POST['femoralesObs']))
		{
			$femoralesObs=utf8_decode($_POST['femoralesObs']);
		}
		if (isset($_POST['viasIn']))
		{
			$viasIn=$_POST['viasIn'];
		}
		if (isset($_POST['viasInObs']))
		{
			$viasInObs=utf8_decode($_POST['viasInObs']);
		}
		if (isset($_POST['restosSangre']))
		{
			$restosSangre=$_POST['restosSangre'];
		}
		if (isset($_POST['restosSangreObs']))
		{
			$restosSangreObs=utf8_decode($_POST['restosSangreObs']);
		}
		if (isset($_POST['sutura']))
		{
			$sutura=$_POST['sutura'];
		}
		if (isset($_POST['suturaObs']))
		{
			$suturaObs=utf8_decode($_POST['suturaObs']);
		}
		if (isset($_POST['aposito']))
		{
			$aposito=$_POST['aposito'];
		}
		if (isset($_POST['apositoObs']))
		{
			$apositoObs=utf8_decode($_POST['apositoObs']);
		}
		if (isset($_POST['radiografia']))
		{
			$radiografia=$_POST['radiografia'];
		}
		if (isset($_POST['radiografiaObs']))
		{
			$radiografiaObs=utf8_decode($_POST['radiografiaObs']);
		}
		
		if (isset($_POST['complicacion']))
		{
			$complicacion=utf8_decode($_POST['complicacion']);
		}
		if (isset($_POST['como']))
		{
			$como=utf8_decode($_POST['como']);
		}
		if (isset($_POST['duracion']))
		{
			$duracion=utf8_decode($_POST['duracion']);
		}
		if (isset($_POST['fechaInst']))
		{
			$fechaInst=$_POST['fechaInst'];
		}
		if (isset($_POST['fechaRetiro']))
		{
			$fechaRetiro=$_POST['fechaRetiro'];
		}		
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}

		$queryInsrLVC = "INSERT INTO instalacionlvc (id,numeroExpediente,folio,subClav,yugular,basilica,femoral,anestesia,lumen,reinst,nInstala,instala,
		otraEsp,nAsistente,superviso,consInf,consInfObs,posCorr,posCorrObs,operador,operadorObs,ayudante,ayudanteObs,asepsia,asepsiaObs,antiseptico,
		antisepticoObs,tecnica,tecnicaObs,manos,manosObs,clorehixidina,clorehixidinaObs,cateter,cateterObs,femorales,femoralesObs,viasIn,
		viasInObs,restosSangre,restosSangreObs,sutura,suturaObs,aposito,apositoObs,radiografia,radiografiaObs,complicacion,como,duracion,fechaInst,
		fechaRetiro,observaciones,usr)
		VALUES (NULL, '$expediente', '$folio', '$subClav', '$yugular','$basilica', '$femoral', '$anestesia', '$lumen', '$reinst', '$nInstala',
		'$instala','$otraEsp', '$nAsistente','$superviso','$consInf','$consInfObs','$posCorr','$posCorrObs','$operador','$operadorObs','$ayudante',
		'$ayudanteObs','$asepsia','$asepsiaObs','$antiseptico','$antisepticoObs','$tecnica','$tecnicaObs','$manos','$manosObs','$clorehixidina',
		'$clorehixidinaObs','$cateter','$cateterObs','$femorales','$femoralesObs','$viasIn','$viasInObs','$restosSangre','$restosSangreObs','$sutura',
		'$suturaObs','$aposito','$apositoObs','$radiografia','$radiografiaObs','$complicacion','$como','$duracion','$fechaInst','$fechaRetiro',
		'$observaciones', '$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryInsrLVC);
			if(!$result0) {
				echo '!<br> ERROR al realizar inserción de Instalacion de LVC! <br>';
				echo 'QUERY: '.$queryInsrLVC;
			} else {
				echo '<br>!!!! SE GUARDO LA INSTALACION DE LVC CORRECTAMENTE!!!!<br>';
			}
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>INSTALACIÓN LVC</title>

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
		<script type="text/javascript">
			//Mostrar recuadro si se selecc Otro o Habitacion
			function verOtro(e){
				if(e == 1){
					document.getElementById("otraEsp").style="display:block;";					
				} else {
					document.getElementById("otraEsp").style="display:none;";					
				}
			}
		</script>

        <!-- main content -->
        <section class="form-box">
            <div class="container">
			
			  <!--div class="row swicher">
				<div class="col-md-12">
					<h2 class="switcher-title">Switch Form Wizard Color</h2>
					<button type="button" id="blue" class="btn btn-color">Blue</button>
					<button type="button" id="black" class="btn btn-color">black</button>
					<button type="button" id="red" class="btn btn-color">red</button>
					<button type="button" id="pink" class="btn btn-color">pink</button>
					<button type="button" id="purple" class="btn btn-color">purple</button>
					<button type="button" id="teal" class="btn btn-color">teal</button>
					<button type="button" id="green" class="btn btn-color">green</button>
					<button type="button" id="yellow" class="btn btn-color">yellow</button>
					<button type="button" id="orange" class="btn btn-color">orange</button>
					<button type="button" id="brown" class="btn btn-color">brown</button>
					<button type="button" id="cyan" class="btn btn-color">cyan</button>
					<button type="button" id="lime" class="btn btn-color">lime</button>
				</div>
			  </div-->
			  
			  
			  <!--div class="row swicher">
				<div class="col-md-5">
					<h2 class="switcher-title">Switch Form Wizard Header Style</h2>
					<button type="button" id="classic" class="btn btn-color">classic</button>
					<button type="button" id="modarn" class="btn btn-color">modarn</button>
					<button type="button" id="stylist" class="btn btn-color">stylist</button>
				</div>
				
				<div class="col-md-5 col-md-offset-2">
					<h2 class="switcher-title">Switch Form Input Element Style</h2>
					<button type="button" id="classicform" class="btn btn-color">classic</button>
					<button type="button" id="materialform" class="btn btn-color">material</button>
					<button type="button" id="stylistform" class="btn btn-color">stylist</button>
				</div>
			  </div-->
                
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-stylist">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
						
                    	<form role="form" action="" method="post">

                    		<h3>VERIFICACIÓN EN LA INSERCIÓN DE LÍNEAS VASCULARES CENTRALES</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLÓGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-4">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Inserción</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-clipboard" aria-hidden="true"></i></div>
                    				<p>Fundamentales</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-cogs" aria-hidden="true"></i></div>
                    				<p>Durante el Procedimiento</p>
                    			</div>
								<!-- Step 3 -->
								
								<!-- Step 4 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
                    				<p>Despues del Procedimiento</p>
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
                    		    <h4>Inserción: <span>Paso 1 - 4</span></h4>
								<div class="form-group">
                    			    <label>SUBCLAVIA : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="subClav" value="Derecha" checked="checked"> Derecha
									</label>
									<label class="radio-inline">
									  <input type="radio" name="subClav" value="Izquierda"> Izquierda
									</label>
                                </div>
								<div class="form-group">
                    			    <label>YUGULAR : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="yugular" value="Derecha" checked="checked"> Derecha
									</label>
									<label class="radio-inline">
									  <input type="radio" name="yugular" value="Izquierda"> Izquierda
									</label>
                                </div>
								<div class="form-group">
                    			    <label>BASILICA : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="basilica" value="Derecha" checked="checked"> Derecha
									</label>
									<label class="radio-inline">
									  <input type="radio" name="basilica" value="Izquierda"> Izquierda
									</label>
                                </div>
								<div class="form-group">
                    			    <label>FEMORAL : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="femoral" value="Derecha" checked="checked"> Derecha
									</label>
									<label class="radio-inline">
									  <input type="radio" name="femoral" value="Izquierda"> Izquierda
									</label>
                                </div>
								<div class="form-group">
                    			    <label>ANESTESIA : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="anestesia" value="General" checked="checked"> General
									</label>
									<label class="radio-inline">
									  <input type="radio" name="anestesia" value="Local"> Local
									</label>
									<label class="radio-inline">
									  <input type="radio" name="anestesia" value="Sedación"> Sedación
									</label>
                                </div>
								<div class="form-group">
                    			    <label>NUM. LUMEN : <span>*</span></label>
                                    <input type="text" name="lumen" placeholder="Num Lumen" autocomplete="off" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>REINSTALACIÓN : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="reinst" value="SI" > SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="reinst" value="NO" checked="checked"> NO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>QUIEN INSTALA: <span>*</span></label>
                                    <input type="text" name="nInstala" placeholder="Nombre" autocomplete="off" class="form-control required">
									 <label class="radio-inline">
									  <input type="radio" name="instala" value="CIRUJANO" checked="checked" onClick="verOtro(0)"> CIRUJANO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="instala" value="INTENSIVISTA" onClick="verOtro(0)"> INTENSIVISTA
									</label>
									<label class="radio-inline">
									  <input type="radio" name="instala" value="OTRA" onClick="verOtro(1)"> OTRA ESPECIALIDAD
									</label>
									<input type="text" name="otraEsp" id="otraEsp" placeholder="Nombre Otra Especialidad" autocomplete="off" style="display: none" class="form-control">
                                </div>
								 <div class="form-group">
                    			    <label>ASISTENTE :</label>
                                    <input type="text" name="nAsistente" placeholder="Nombre Asistente" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>SUPERVISO :</label>
                                    <input type="text" name="superviso" placeholder="Nombre Supervisor" autocomplete="off" class="form-control">
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
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>FUNDAMENTALES : <span>Paso 2 - 4</span></h4>
								<p>
									Se requiere de un mínimo de 5 procedimiento supervisados, tantos torácicos como femorales (10 en total) si un médico coloca con éxito 5 vías en un único lugar, solo se le considera independientemente para realizar el procedimiento en ese lugar. Enfermera asiste en la colocación de la vía es la encargada de llenar la lista de comprobación.
								</p>
								<p>
									En caso de desviación en cualquiera de los pasos fundamentales el supervisor, notificará inmediatamente a quien está realizando el procedimiento (operador) y se detendrá de inmediato hasta que se haya corregido
								</p>
								<p>
									Si es necesario una corrección marque en la casilla SI, CON AVISO y anote en el campo OBSERVACIONES la corrección realizada, si procede.
								</p>
								<div class="form-group">
                    			    <label>Consentimiento informado al paciente : <span>*</span></label>
									<br/>
									 <label class="radio-inline">
									  <input type="radio" name="consInf" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="consInf" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="consInfObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								
								<div class="form-group">
                    			    <label>Posicion correcta del paciente para el procedimiento de acuerdo al sitio señalado : <span>*</span></label><br/>
                                    <label class="radio-inline">
									  <input type="radio" name="posCorr" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="posCorr" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="posCorrObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								
                                <div class="form-group">
                    			    <label>Operador utilizar: gorro, mascarilla, bata, guantes esteriles proteccion ocular : <span>*</span></label><br/>
                                   <label class="radio-inline">
									  <input type="radio" name="operador" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="operador" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="operadorObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								
								<div class="form-group">
                    			    <label>Ayudantes: gorro, mascarilla : <span>*</span></label>
									<br/>
                                     <label class="radio-inline">
									  <input type="radio" name="ayudante" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="ayudante" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="ayudanteObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								
								<div class="form-group">
                    			    <label>Asepsia de la piel con clorhexidina alcoholica al 2% en mayores de 2 meses : <span>*</span></label>
                                    <br/>
                                     <label class="radio-inline">
									  <input type="radio" name="asepsia" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="asepsia" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="asepsiaObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>Espero a que seque el antiséptico : <span>*</span></label>
                                    <br/>
                                     <label class="radio-inline">
									  <input type="radio" name="antiseptico" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="antiseptico" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="antisepticoObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>Utilizo técnica aseptica para cubrir al paciente de pies a cabeza : </label>
                                    <br/>
                                     <label class="radio-inline">
									  <input type="radio" name="tecnica" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tecnica" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="tecnicaObs" placeholder="observaciones" autocomplete="off" class="form-control">
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
                                <h4>DURANTE EL PROCEDIMIENTO: <span>Paso 3 - 4</span></h4>
								<div class="form-group">
                    			    <label>LAVADO DE MANOS, DURANTE LOS 5 MOMENTOS : <span>*</span></label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="manos" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="manos" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="manosObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                    			    <label>ASEPSIA DE LA PIEL CON CLOREHIXIDINA ALCOHOLICA AL 2% EN MAYORES DE 2 MESES : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="clorehixidina" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="clorehixidina" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="clorehixidinaObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>BARRERA MAXIMA DURANTE LA INSTALACIÓN DEL CATETER : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="cateter" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cateter" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="cateterObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>EVITAR ACCESOS FEMORALES : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="femorales" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="femorales" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="femoralesObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>RETIRAR LAS VIAS INNECESARIAS : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="viasIn" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="viasIn" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="viasInObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>LIMPIO CON CLORHEXIDINA LOS RESTOS DE SANGRE EN EL LUGAR DE LA INSERCIÓN : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="restosSangre" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="restosSangre" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="restosSangreObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>SE FIJO CATETER CON MATERIAL DE SUTURA : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="sutura" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sutura" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="suturaObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>COLOCO APOSITO SEMIPERMEABLE ESTERIL PARA CUBRIR CATETER : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="aposito" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="aposito" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="apositoObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>CORROBORA LA POSICION DEL CATETER MEDIANTE RADIOGRAFIA : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="radiografia" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="radiografia" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="radiografiaObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<!--div class="container-fluid">
								<div class="row form-inline">
								<div class="form-group col-md-3 col-xs-3">
									<label>Joining Date: </label>
								</div>
								<div class="form-group col-md-3 col-xs-3">
									<label>Day: </label>
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
								<br/>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 3 -->
							
							<!-- Form Step 4 -->
							<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>DESPUES DEL PROCEDIMIENTO: <span>Paso 4 - 4</span></h4>
								<div style="clear:both;"></div>
								<div class="form-group">
                    			    <label>MANEJO POR PERSONAL CAPACITADO: <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="personalCapac" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="personalCapac" value="SI CON AVISO"> SI CON AVISO
									</label>
                                    <input type="text" name="personalCapacObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
                    			<div class="form-group">
                    			    <label>BAÑO CON CLOREXIDINA EN MAYORES DE 2 MESES : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="banio" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="banio" value="SI CON AVISO"> SI CON AVISO
									</label>
									<input type="text" name="banioObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                    			    <label>CURACION EN BUEN ESTADO: <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="curacion" value="SI" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="curacion" value="SI CON AVISO"> SI CON AVISO
									</label>
									<input type="text" name="curacionObs" placeholder="observaciones" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>SE PRESENTO ALGUNA COMPLICACIÓN : <span>*</span></label>
                                    <input type="text" name="complicacion" placeholder="complicacion" autocomplete="off" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>¿CÓMO SE SOLUCIONO? : </label>
                                    <input type="text" name="como" autocomplete="off" class="form-control">
                                </div><div class="form-group">
                    			    <label>DURACIÓN DEL PROCEDIMIENTO : </label>
                                    <input type="text" name="duracion" autocomplete="off" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>FECHA DE INSTALACIÓN : <span>*</span></label>
                                    <input type="date" name="fechaInst" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>FECHA DE RETIRO : </label>
                                    <input type="date" name="fechaRetiro" class="form-control">
                                </div>
								<div class="form-group">
                    			    <label>OBSERVACIONES : <span></span></label>
									<textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="1"></textarea>
                                </div>
								<!--div class="container-fluid">
								<div class="row form-inline">
								<div class="form-group col-md-6 col-xs-6">
									<label>Card Number: <span>*</span></label>
                                    <input type="text" name="Card Number" placeholder="Card Number" class="form-control required">
								</div>
								<div class="form-group col-md-6 col-xs-6">
									<label>CVC: <span>*</span></label>
                                    <input type="text" name="CVC" placeholder="CVC" class="form-control required">
								</div>
                                </div>
								</div>
								<br/-->
								<!--div class="container-fluid">
								<div class="row form-inline">
								<div class="form-group col-md-3 col-xs-3">
									<label>Expiry Date: </label>
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
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="submit" name="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 4 -->
                    	
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

    </body>

</html>