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
		if (isset($_POST['fechaFin']))
		{
			$fechaFin=$_POST['fechaFin'];
		}
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['ubicacion']))
		{
			$ubicacion=utf8_decode($_POST['ubicacion']);
		}
		if (isset($_POST['habitacion']))
		{
			$habitacion=$_POST['habitacion'];
		}
		if (isset($_POST['otro']))
		{
			$otro=utf8_decode($_POST['otro']);
		}
		if (isset($_POST['instalo']))
		{
			$instalo=$_POST['instalo'];
		}
		if (isset($_POST['nombInstalo']))
		{
			$nombInstalo=utf8_decode($_POST['nombInstalo']);
		}
		
		if (isset($_POST['indicPac']))
		{
			$indicPac=$_POST['indicPac'];
		}
		if (isset($_POST['manosPac']))
		{
			$manosPac=$_POST['manosPac'];
		}
		if (isset($_POST['barreraPac']))
		{
			$barreraPac=$_POST['barreraPac'];
		}
		if (isset($_POST['elevaPac']))
		{
			$elevaPac=$_POST['elevaPac'];
		}
		if (isset($_POST['oralPac']))
		{
			$oralPac=$_POST['oralPac'];
		}
		if (isset($_POST['extubaPac']))
		{
			$extubaPac=$_POST['extubaPac'];
		}
		if (isset($_POST['sedacionPac']))
		{
			$sedacionPac=$_POST['sedacionPac'];
		}
		if (isset($_POST['endotraPac']))
		{
			$endotraPac=$_POST['endotraPac'];
		}
		if (isset($_POST['canulaPac']))
		{
			$canulaPac=$_POST['canulaPac'];
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		
		$queryInsrSv = "INSERT INTO instalacionvm (id,numeroExpediente,folio,verificador,fechaInst,fechaFin,turno,ubicacion,otraUbic,habitacion,
		personaInstalo,nombreInstalo,indicPac,manosPac,barreraPac,elevaPac,oralPac,extubaPac,sedacionPac,endotraPac,canulaPac,observaciones,usr)
		VALUES (NULL, '$expediente', '$folio', '$verificador', '$fechaInst','$fechaFin','$turno', '$ubicacion', '$otro', '$habitacion', '$instalo', '$nombInstalo',
		'$indicPac','$manosPac', '$barreraPac','$elevaPac','$oralPac','$extubaPac','$sedacionPac','$endotraPac','$canulaPac','$observaciones', '$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryInsrSv);
			if(!$result0) {
				echo '!<br> ERROR al realizar inserción de Instalacion de Ventilación Mecánica! <br>';
				echo 'QUERY: '.$queryInsrSv;
			} else {
				echo '<br>!!!! SE GUARDO LA INSTALACION DE VENTILACIÓN MECÁNICA CORRECTAMENTE!!!!<br>';
			}
		
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>INSTALACIÓN VM</title>

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
				var valr = e.ubicacion.options[e.ubicacion.selectedIndex].value;
				if( valr == "OTRO") {
					document.getElementById("divOtro").style="display:block;";
					document.getElementById("divHab").style="display:none;";
				}else if( valr == "HAB"){
					document.getElementById("divHab").style="display:block;";
					document.getElementById("divOtro").style="display:none;";
				} else {
					document.getElementById("divOtro").style="display:none;";
					document.getElementById("divHab").style="display:none;";
				}
			}
		</script>

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
                    		<h3>PROGRAMA DE PREVENCIÓN DE NEUMONÍAS ASOCIADAS A VENTILACIÓN MECÁNICA</h3>
                    		<p>PAQUETE BUNDLE PARA PREVENCIÓN DE N.A.V.M</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                    				<p>DATOS GENERALES</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-check" aria-hidden="true"></i></div>
                    				<p>CRITERIOS DE VERIFICACIÓN</p>
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
                    		    <h4>DATOS GENERALES : <span>Paso 1 - 2</span></h4>
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
                    			    <label>FECHA DE INSTALACIÓN : <span>*</span></label>
                                    <input type="date" name="fechaInst" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>FECHA DE TÉRMINO :</label>
                                    <input type="date" name="fechaFin" class="form-control">
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
                    			    <label>UBICACIÓN : </label>
                                    <select id="ubicacion" name="ubicacion" class="form-control" onchange="verOtro(this.form)">
										<option value="">Seleccione</option>
										<option value="UR">Urgencias</option>
										<option value="E1">Edificio 1</option>
										<option value="E2A">Edificio 2 Planta Alta</option>
										<option value="E2B">Edificio 2 Planta Baja</option>
										<option value="LAB">Laboratorio</option>
										<option value="CU">Cuneros</option>
										<option value="UCI">Unidad de Terapia Intensiva</option>
										<option value="QX">Quirófano</option>
										<option value="CE">Área de consulta externa</option>
										<option value="HAB">Habitación</option>
										<option value="OTRO">Otro</option>
									</select>
								<div id="divHab" class="form-group" style="display:none">
                    				<label>NÚMERO DE HABITACIÓN : </label>
                                  	<input type="number" id="habitacion" name="habitacion" autocomplete="off" placeholder="No. Habitación" min="100" max="250" class="form-control">
                                </div>
								<div id="divOtro" class="form-group" style="display:none">
                    			   	<label>OTRO :</label>
                                 	<input type="text" id="otro" name="otro" placeholder="Indique Lugar" autocomplete="off" class="form-control">
                                </div>
                                </div>
								<div class="form-group">
                    			    <label>PERSONA QUE INSTALÓ : <span>*</span></label>
                                   <select id="instalo" name="instalo" class="form-control required">
										<option value="">Seleccione</option>
										<option value="1">ENFERMERA(O)</option>
										<option value="5">MÉDICO(A) GUARDIA</option>
										<option value="20">ESTUDIANTE ENFERMERIA</option>
									   <option value="7">LABORATORISTA</option>
									   <option value="6">MÉDICO ESPECIALISTA</option>
									   <option value="4">TEC. INHALOTERAPIA</option>
									   <option value="21">PARAMÉDICO</option>
									</select>
                                </div>
								<div class="form-group">
                    			    <label>NOMBRE QUIEN INSTALO : <span>*</span></label>
                                    <input type="text" name="nombInstalo" placeholder="Nombre Instalo" autocomplete="off" class="form-control required">
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
                                <h4>CRITERIOS DE VERIFICACIÓN : <span>Paso 2 - 2</span></h4>
								<div style="clear:both;"></div>
								<div class="form-group">
                    			    <label>0. VERIFICÓ LA INDICACIÓN DE VENTILACIÓN MECÁNICA EN EL EXPEDIENTE : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="indicPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="indicPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="indicPac" value="NA"> NO APLICA
									</label>
                                </div>
                    			<div class="form-group">
                    			    <label>1. APLICÓ LA TÉCNICA DE HIGIENE DE MANOS : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="manosPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="manosPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="manosPac" value="NA"> NO APLICA
									</label>									
                                </div>
                                <div class="form-group">
                    			    <label>2. VERIFICÓ LA UTILIZACIÓN DE BARRERA DE MÁXIMA PROTECCIÓN DURANTE LA INSTALACIÓN (guantes,cubrebocas,bata,gorro) : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="barreraPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="barreraPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="barreraPac" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>3. VERIFICÓ LA ELEVACIÓN DE LA CABEZA DEL PACIENTE SOBRE LA CAMA DE 30° A 40°, EN NEONATOS 10° A 15° : </label>
                                    <br>
                                     <label class="radio-inline">
									  <input type="radio" name="elevaPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="elevaPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="elevaPac" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>4. EFECTUAR HIGIENE DE CAVIDAD ORAL USANDO CLORHEXIDINA :</label>
                                    <br>
                                     <label class="radio-inline">
									  <input type="radio" name="oralPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="oralPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="oralPac" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>5. VERIFICÓ LA POSIBILIDAD DE EXTUBACIÓN : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="extubaPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="extubaPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="extubaPac" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>6. VERIFICÓ LA DISMINUCIÓN TRANSITORIA DE LA SEDACIÓN PROGRAMADA : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="sedacionPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sedacionPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sedacionPac" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>7. VERIFICÓ LA ASPIRACIÓN ENDOTRAQUEAL AL PACIENTE : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="endotraPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="endotraPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="endotraPac" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>8. VERIFICÓ LA MEDICIÓN DE LA PRESIÓN DEL GLOBO DE CANULA ENDOTRAQUEAL : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="canulaPac" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="canulaPac" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="canulaPac" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>OBSERVACIONES : </label>
                                    <br>
                                    <label class="radio-inline">
										<textarea class="form-control" id="observaciones" name="observaciones" rows="3" cols="50"></textarea>									  
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