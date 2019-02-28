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
		
		if (isset($_POST['verificador']))
		{
			$verificador=utf8_decode($_POST['verificador']);
		}
		if (isset($_POST['fechaInst']))
		{
			$fechaInst=$_POST['fechaInst'];
		}
		if (isset($_POST['identPac']))
		{
			$identPac=$_POST['identPac'];
		}
		if (isset($_POST['infoPac']))
		{
			$infoPac=$_POST['infoPac'];
		}
		if (isset($_POST['higieneManPac']))
		{
			$higieneManPac=$_POST['higieneManPac'];
		}
		if (isset($_POST['condicionesPac']))
		{
			$condicionesPac=$_POST['condicionesPac'];
		}
		if (isset($_POST['permeaPac']))
		{
			$permeaPac=$_POST['permeaPac'];
		}
		if (isset($_POST['apositoPac']))
		{
			$apositoPac=$_POST['apositoPac'];
		}
		if (isset($_POST['solucionesPac']))
		{
			$solucionesPac=$_POST['solucionesPac'];
		}
		if (isset($_POST['infusionPac']))
		{
			$infusionPac=$_POST['infusionPac'];
		}
		if (isset($_POST['puertosPac']))
		{
			$puertosPac=$_POST['puertosPac'];
		}
		if (isset($_POST['viaPac']))
		{
			$viaPac=$_POST['viaPac'];
		}
		if (isset($_POST['formatosPac']))
		{
			$formatosPac=$_POST['formatosPac'];
		}
		if (isset($_POST['retiraPac']))
		{
			$retiraPac=$_POST['retiraPac'];
		}
		
		$queryMantoAVP = "INSERT INTO mantoavp (id,numeroExpediente,folio,verificador,fechaInst,identPac,infoPac,higieneManPac,condicionesPac,
		permeaPac,apositoPac,solucionesPac,infusionPac,puertosPac,viaPac,formatosPac,retirarPac,usr)
		VALUES (NULL, '$expediente', '$folio', '$verificador','$fechaInst','$identPac','$infoPac','$higieneManPac','$condicionesPac', 
		'$permeaPac','$apositoPac','$solucionesPac','$infusionPac','$puertosPac','$viaPac','$formatosPac','$retiraPac','$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryMantoAVP);
			if(!$result0) {
				echo '!<br> ERROR al insertar Mantenimiento de AVP! <br>';
				echo 'QUERY: '.$queryMantoAVP;
			} else {
				echo '<br>!!!! SE GUARDO EL MANTENIMIENTO DE AVP CORRECTAMENTE!!!!<br>';
			}
		
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MANTENIMIENTO AVP</title>

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
						<div class="form-wizard form-header-stylist form-body-stylist">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
						
                    	<form role="form" action="" method="post">
                    		<h3>BUNDLE MANTENIMIENTO DE CATÉTER PERIFÉRICO</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLÓGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Revisión 1</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-clipboard" aria-hidden="true"></i></div>
                    				<p>Revisión 2</p>
                    			</div>
								<!-- Step 2 -->
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
                    		    <h4>REVISIÓN 1: <span>Paso 1 - 2</span></h4>
								<div class="form-group">
                    			    <label>FECHA : <span>*</span></label>
                                    <input type="date" name="fechaInst" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>NOMBRE DEL VERIFICADOR : <span>*</span></label>
                                    <input type="text" name="verificador" placeholder="Nombre" autocomplete="off" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>INDENTIFICO AL PACIENTE CORRECTAMENTE : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="identPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="identPac" value="0"> NO CUMPLE
									</label>
                                </div>
								<div class="form-group">
                    			    <label>INFORMO AL PACIENTE O FAMILIARES SOBRE EL PROCESO A REALIZAR : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="infoPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="infoPac" value="0"> NO CUMPLE
									</label>
                                </div>
								<div class="form-group">
                    			    <label>REALIZO HIGIENE DE MANOS ANTES DE LA MANIPULACIÓN DEL SITIO DE INSERCIÓN DEL CATÉTER : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="higieneManPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="higieneManPac" value="0"> NO CUMPLE
									</label>
                                </div>
								<div class="form-group">
                    			    <label>VALORA CONDICIONES DEL ACCESO VENOSO PARA IDENTIFICAR OPORTUNAMENTE SIGNOS DE INFECCIÓN : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="condicionesPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="condicionesPac" value="0"> NO CUMPLE
									</label>
                                </div>
								<div class="form-group">
                    			    <label>VERIFICA PERMEABILIDAD DEL CATÉTER CON TÉCNICA ASÉPTICA : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="permeaPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="permeaPac" value="0"> NO CUMPLE
									</label>
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
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>REVISIÓN 2: <span>Paso 2 - 2</span></h4>
								<div style="clear:both;"></div>
								<div class="form-group">
                    			    <label>REEMPLAZO APÓSITO DE ACUERDO A NORMATIVA ESTABLECIDA : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="apositoPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="apositoPac" value="0"> NO CUMPLE
									</label>
                                </div>
                    			<div class="form-group">
                    			    <label>CAMBIO SOLUCIONES Y EQUIPOS DE ACUERDO A LA NORMATIVIDAD : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="solucionesPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="solucionesPac" value="0"> NO CUMPLE
									</label>									
                                </div>
                                <div class="form-group">
                    			    <label>MANTIENE EL SISTEMA DE INFUSIÓN CERRADO Y EVITA DESCONEXIONES INNECESARIAS : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="infusionPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="infusionPac" value="0"> NO CUMPLE
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>DESINFECTA LOS PUERTOS Y CONEXIONES ANTES DE MANIPULARLOS : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="puertosPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="puertosPac" value="0"> NO CUMPLE
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>DESINFECTA LA VÍA VENOSA DESPUÉS DE LA ADMINISTRACIÓN DE MEDICAMENTOS O HEMODERIVADOS DE ACUERDO AL PROTOCOLO : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="viaPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="viaPac" value="0"> NO CUMPLE
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>REGISTRA EN FORMATOS ESTABLECIDOS LAS ACCIONES REALIZADAS : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="formatosPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="formatosPac" value="0"> NO CUMPLE
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>RETIRA EL CATETER PREVIA INDICACIÓN MÉDICA O ANTE LA PRESENCIA DE UNA COMPLICACIÓN : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="retiraPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="retiraPac" value="0"> NO CUMPLE
									</label>									
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