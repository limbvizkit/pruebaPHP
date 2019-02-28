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
		if (isset($_POST['heridaVisible']))
		{
			$heridaVisible=$_POST['heridaVisible'];
		}
		if (isset($_POST['ubicaHerida']))
		{
			$ubicaHerida=utf8_decode($_POST['ubicaHerida']);
		}
			if (isset($_POST['aspectoHerida']))
		{
			$aspectoHerida=utf8_decode($_POST['aspectoHerida']);
		}
		if (isset($_POST['cantidadExudado']))
		{
			$cantidadExudado=utf8_decode($_POST['cantidadExudado']);
		}
		if (isset($_POST['tipoExudado']))
		{
			$tipoExudado=utf8_decode($_POST['tipoExudado']);
		}
		if (isset($_POST['caracteristicasPiel']))
		{
			$caracteristicasPiel=utf8_decode($_POST['caracteristicasPiel']);
		}
		if (isset($_POST['presenciaEdema']))
		{
			$presenciaEdema=utf8_decode($_POST['presenciaEdema']);
		}
		if (isset($_POST['dolor']))
		{
			$dolor=$_POST['dolor'];
		}
		if (isset($_POST['olor']))
		{
			$olor=utf8_decode($_POST['olor']);
		}
		if (isset($_POST['tomaCultivo']))
		{
			$tomaCultivo=utf8_decode($_POST['tomaCultivo']);
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		
		$queryMantoSQ = "INSERT INTO mantosq (id,numeroExpediente,folio,verificador,fechaInst,heridaVisible,ubicaHerida,aspectoHerida,cantidadExudado,
								tipoExudado,caracteristicasPiel,presenciaEdema,dolor,olor,tomaCultivo,observaciones,usr)
						  VALUES (NULL,'$expediente','$folio','$verificador','$fechaInst','$heridaVisible','$ubicaHerida','$aspectoHerida',
							'$cantidadExudado','$tipoExudado','$caracteristicasPiel','$presenciaEdema','$dolor','$olor','$tomaCultivo','$observaciones',
							'$rol')";
			
		$result0 = mysqli_query($conexionEpidemio, $queryMantoSQ);
		if(!$result0) {
			echo '!<br> ERROR al insertar Mantenimiento de Herida Quirúrgica! <br>';
			echo 'QUERY: '.$queryMantoSQ;
		} else {
			echo '<br>!!!! SE GUARDO EL MANTENIMIENTO DE HERIDA QUIRÚRGICA CORRECTAMENTE!!!!<br>';
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MANTENIMIENTO SQ</title>

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
                    		<h3>BUNDLE MANTENIMIENTO DE HERIDAS QUIRÚRGICAS</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLÓGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-wheelchair" aria-hidden="true"></i></div>
                    				<p>ASPECTOS A EVALUAR</p>
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
                                    <input type="text" name="verificador" placeholder="Nombre" autocomplete="off" class="form-control required">
                                </div>																
								<div class="form-group">
                    			    <label>1. HERIDA VISIBLE : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="heridaVisible" value="1" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="heridaVisible" value="0"> NO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2. UBICACIÓN ANATÓMICA DE LA HERIDA : <span>*</span></label>
									<input type="text" name="ubicaHerida" autocomplete="off" class="form-control required">
                                </div>
								
								<div class="form-group">
                    			    <label>3. ASPECTO DE LA HERIDA : <span>*</span></label>
                                    <select id="aspectoHerida" name="aspectoHerida" class="form-control required">
										<option value="">Seleccione</option>
										<option value="Eritomatoso">Eritomatoso</option>
										<option value="Granulatorio">Granulatorio</option>
										<option value="Esfacelado">Esfacelado</option>
										<option value="Necrotico">Necrotico</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>4. CANTIDAD DE EXUDADO : <span>*</span></label>
									 <select id="cantidadExudado" name="cantidadExudado" class="form-control required">
										<option value="">Seleccione</option>
										<option value="Ausente">Ausente</option>
										<option value="Escaso">Escaso</option>
										<option value="Moderado">Moderado</option>
										<option value="Abundante">Abundante</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>5. TIPO DE EXUDADO : <span>*</span></label>
									 <select id="tipoExudado" name="tipoExudado" class="form-control required">
										<option value="">Seleccione</option>
										<option value="seroso">seroso</option>
										<option value="Turbio">Turbio</option>
										<option value="Purulento">Purulento</option>
										<option value="Hemorragico">Hemorragico</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>6. CARACTERISTICAS DE LA PIEL : <span>*</span></label>
									 <select id="caracteristicasPiel" name="caracteristicasPiel" class="form-control required">
										<option value="">Seleccione</option>
										<option value="sana">Sana</option>
										<option value="eritomatosa">Eritomatosa</option>
										<option value="descamada">Descamada</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>7. PRESENCIA DE EDEMA : <span>*</span></label>
									 <select id="presenciaEdema" name="presenciaEdema" class="form-control required">
										<option value="">Seleccione</option>
										<option value="sana">Leve</option>
										<option value="eritomatosa">Moderado</option>
										<option value="descamada">Severo</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>8. DOLOR : <span>*</span></label>
									 <select id="dolor" name="dolor" class="form-control required">
										<option value="">Seleccione</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>9. OLOR : <span>*</span></label>
                                    <input type="text" name="olor" autocomplete="off" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>10. ¿SE TOMA CULTIVO? : <span>*</span></label>
                                    <input type="text" name="tomaCultivo" autocomplete="off" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>OBSERVACIONES : </label>
                                    <br>
                                    <label class="radio-inline">
										<textarea class="form-control" id="observaciones" name="observaciones" rows="3" cols="50"></textarea>
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