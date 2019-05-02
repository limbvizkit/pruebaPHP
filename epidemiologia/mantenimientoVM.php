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
		if (isset($_POST['higieneManos']))
		{
			$higieneManos=$_POST['higieneManos'];
		}
		if (isset($_POST['cabezaElev']))
		{
			$cabezaElev=$_POST['cabezaElev'];
		}
			if (isset($_POST['contactoVent']))
		{
			$contactoVent=$_POST['contactoVent'];
		}
		if (isset($_POST['medidasEstn']))
		{
			$medidasEstn=$_POST['medidasEstn'];
		}
		if (isset($_POST['intDiaria']))
		{
			$intDiaria=$_POST['intDiaria'];
		}
		if (isset($_POST['desechRes']))
		{
			$desechRes=$_POST['desechRes'];
		}
		if (isset($_POST['higieneAntisep']))
		{
			$higieneAntisep=$_POST['higieneAntisep'];
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		
		$queryMantoVM = "INSERT INTO mantovm (id,numeroExpediente,folio,verificador,fechaInst,higieneManos,cabezaElev,contactoVent,medidasEstn,intDiaria,
		desechRes,higieneAntisep,observaciones,usr)
		VALUES (NULL, '$expediente', '$folio', '$verificador','$fechaInst','$higieneManos','$cabezaElev','$contactoVent','$medidasEstn','$intDiaria', 
		'$desechRes','$higieneAntisep','$observaciones','$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryMantoVM);
			if(!$result0) {
				echo '!<br> ERROR al insertar Mantenimiento de Ventilación Mecánica! <br>';
				echo 'QUERY: '.$queryMantoVM;
			} else {
				echo '<br>!!!! SE GUARDO EL MANTENIMIENTO DE VENTILACIÓN MECÁNICA CORRECTAMENTE!!!!<br>';
			}
		
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MANTENIMIENTO VM</title>

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
                    		<h3>BUNDLE MANTENIMIENTO DE VENTILACIÓN MECÁNICA</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLÓGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>PASOS</p>
                    			</div>
								<!-- Step 1 -->
                    		</div>
							<!-- Form progress -->
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>PASOS : <span>Paso 1 - 1</span></h4>
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
								<div class="form-group">
                    			    <label>1. HIGIENE DE MANOS EN LOS 5 MOMENTOS : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="higieneManos" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="higieneManos" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="higieneManos" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2. CABEZA ELEVADA >30° : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="cabezaElev" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cabezaElev" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cabezaElev" value="NA"> NO APLICA
									</label>
                                </div>
								
								<div class="form-group">
                    			    <label>3. Realiza la tecnica de higiene de manos antes de tener contacto con el ventilador : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="contactoVent" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="contactoVent" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="contactoVent" value="NA"> NO APLICA
									</label>
                                </div>																
								<div class="form-group">
                    			    <label>4. Utiliza medidas de precaución estandar : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="medidasEstn" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="medidasEstn" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="medidasEstn" value="NA"> NO APLICA
									</label>
                                </div>
								
								<div class="form-group">
                    			    <label>5. Interrupción diaria de sedación y evaluación diaria de sedación : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="intDiaria" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="intDiaria" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="intDiaria" value="NA"> NO APLICA
									</label>
                                </div>								
								<div class="form-group">
                    			    <label>6. Desechar en bolsa roja de residuos peligrosos biológicos infecciosos : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="desechRes" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="desechRes" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="desechRes" value="NA"> NO APLICA
									</label>
                                </div>								
								<div class="form-group">
                    			    <label>7. Higiene oral correcta con un antiseptico : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="higieneAntisep" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="higieneAntisep" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="higieneAntisep" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>OBSERVACIONES : </label>
                                    <br>
                                    <label class="radio-inline">
										<textarea class="form-control" id="observaciones" name="observaciones" rows="1" cols="50"></textarea>	  
									</label>
                                </div>
                               <br>
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">                                    
                                    <button type="submit" name="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->
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