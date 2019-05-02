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
		if (isset($_POST['nivelPac']))
		{
			$nivelPac=$_POST['nivelPac'];
		}
		if (isset($_POST['rebasaPac']))
		{
			$rebasaPac=$_POST['rebasaPac'];
		}
		if (isset($_POST['pisoPac']))
		{
			$pisoPac=$_POST['pisoPac'];
		}
		if (isset($_POST['mujerPac']))
		{
			$mujerPac=$_POST['mujerPac'];
		}
		if (isset($_POST['hombrePac']))
		{
			$hombrePac=$_POST['hombrePac'];
		}
		if (isset($_POST['instaloPac']))
		{
			$instaloPac=$_POST['instaloPac'];
		}
		if (isset($_POST['drenajePac']))
		{
			$drenajePac=$_POST['drenajePac'];
		}
		if (isset($_POST['fluirPac']))
		{
			$fluirPac=$_POST['fluirPac'];
		}
		if (isset($_POST['fugasPac']))
		{
			$fugasPac=$_POST['fugasPac'];
		}
		if (isset($_POST['barandalesPac']))
		{
			$barandalesPac=$_POST['barandalesPac'];
		}
		if (isset($_POST['cultivoPac']))
		{
			$cultivoPac=$_POST['cultivoPac'];
		}
		if (isset($_POST['febrilesPac']))
		{
			$febrilesPac=$_POST['febrilesPac'];
		}
		if (isset($_POST['uretralPac']))
		{
			$uretralPac=$_POST['uretralPac'];
		}
		if (isset($_POST['orinaPac']))
		{
			$orinaPac=$_POST['orinaPac'];
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		
		$queryMantoAVP = "INSERT INTO mantosv (id,numeroExpediente,folio,verificador,fechaInst,nivelPac,rebasaPac,pisoPac,mujerPac,
		hombrePac,instaloPac,drenajePac,fluirPac,fugasPac,barandalesPac,cultivoPac,febrilesPac,uretralPac,orinaPac,observaciones,usr)
		VALUES (NULL, '$expediente', '$folio', '$verificador','$fechaInst','$nivelPac','$rebasaPac','$pisoPac','$mujerPac', 
		'$hombrePac','$instaloPac','$drenajePac','$fluirPac','$fugasPac','$barandalesPac','$cultivoPac','$febrilesPac','$uretralPac','$orinaPac',
		'$observaciones','$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryMantoAVP);
			if(!$result0) {
				echo '!<br> ERROR al insertar Mantenimiento de Sonda Vesical! <br>';
				echo 'QUERY: '.$queryMantoAVP;
			} else {
				echo '<br>!!!! SE GUARDO EL MANTENIMIENTO DE SONDA VESICAL CORRECTAMENTE!!!!<br>';
			}
		
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MANTENIMIENTO SV</title>

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
                    		<h3>BUNDLE MANTENIMIENTO DE SONDA VESICAL INSTALADA</h3>
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
                                    <!--input type="text" name="verificador" placeholder="Nombre" autocomplete="off" class="form-control required"-->
									<select id="verificador" name="verificador" class="form-control required">
										<option value="">Seleccione</option>
										<option value="Gudmaro Mauricio Carvajal Reyes">Mauricio</option>
										<option value="Alexa Sánchez Solano">Alexa</option>
									</select>
                                </div>
								
								<h4>A. La bolsa colectora se mantiene por debajo del nivel de la vejiga (REVISAR QUE LA BOLSA RECOLECTORA)</h4>
								<div class="form-group">
                    			    <label>1. Se mantiene por debajo del nivel de la vejiga independientemente de la posición : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="nivelPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="nivelPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="nivelPac" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2. No rebasa más del 75% de la capacidad de la misma : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="rebasaPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="rebasaPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="rebasaPac" value="NA"> NO APLICA
									</label>
                                </div>
								
								<div class="form-group">
                    			    <label>3. No está colocada sobre el piso, superficie sucia o cualquier otro recipiente : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="pisoPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pisoPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pisoPac" value="NA"> NO APLICA
									</label>
                                </div>
								
								<h4>B. El catéter está fijado de acuerdo al sexo del paciente (permitiendo la movilidad del paciente sin obstruir la permeabilidad de la sonda y no hay tracción de la misma) (VERIFIQUE FIJACIÓN DE LA SONDA)</h4>
								<div class="form-group">
                    			    <label>4. Mujeres cara interna del muslo : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="mujerPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="mujerPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="mujerPac" value="NA"> NO APLICA
									</label>
                                </div>
								
								<div class="form-group">
                    			    <label>5. Hombres cara antero lateral superior del muslo : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="hombrePac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="hombrePac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="hombrePac" value="NA"> NO APLICA
									</label>
                                </div>
								<h4>C. La sonda se encuentra con membrete de identificación (MEMBRETE DEBE TENER ESCRITO COMO MÍNIMO)</h4>
								<div class="form-group">
                    			    <label>6. Fecha de instalación. Nombre completo de quién instaló la sonda : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="instaloPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="instaloPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="instaloPac" value="NA"> NO APLICA
									</label>
                                </div>
								<h4>D. El sistema de drenaje se mantiene permanentemente conectado</h4>
								<div class="form-group">
                    			    <label>7. Se mantiene conectado el sistema de drenaje : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="drenajePac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="drenajePac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="drenajePac" value="NA"> NO APLICA
									</label>
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
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>REVISIÓN 2: <span>Paso 2 - 2</span></h4>
								<div style="clear:both;"></div>
								
								<h4>E. Se registran datos referentes al funcionamiento de sonda y tubo drenaje. (OBSERVAR Y VERIFICAR QUE ESTE REGISTRADO EN NOTAS DE ENFERMERÍA)</h4>
								<div class="form-group">
                    			    <label>8. Sonda y tubo de drenaje permite fluir orina libremente : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="fluirPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="fluirPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="fluirPac" value="NA"> NO APLICA
									</label>
                                </div>								
                    			<div class="form-group">
                    			    <label>9. Que no existan fisuras, ni fugas : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="fugasPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="fugasPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="fugasPac" value="NA"> NO APLICA
									</label>
                                </div>
                                <div class="form-group">
                    			    <label>10. Que no estén pinzadas, torcidas, acodados colapsados presionados (barandales cama) : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="barandalesPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="barandalesPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="barandalesPac" value="NA"> NO APLICA
									</label>
                                </div>
								
								<h4>F. Repara ausencia o presencia de signos y síntomas que evidencien Infección de tracto urinario. (VERIFICAR NOTAS DE ENFERMERÍA, MÉDICOS Y/O LABORATORIO)</h4>
								<div class="form-group">
                    			    <label>11. Cuenta con cultivo antes de colocación de sonda y cada 5 días a partir de la fecha de instalación : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="cultivoPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cultivoPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cultivoPac" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>12. Picos febriles, dolor supra púbico o en flanco</label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="febrilesPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="febrilesPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="febrilesPac" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>13. Área peri uretral secreción, prurito, inflamación, etc. : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="uretralPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="uretralPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="uretralPac" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>14. Características macroscópicas de orina, turbia, hematuria, sedimento, entre otro</label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="orinaPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="orinaPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="orinaPac" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>OBSERVACIONES : </label>
                                    <br>
                                    <label class="radio-inline">
										<textarea class="form-control" id="observaciones" name="observaciones" rows="1" cols="50"></textarea>	  
									</label>
                                </div>
								
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