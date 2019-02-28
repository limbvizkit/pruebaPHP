<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configEpidemio.php');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}	

	if(isset($_REQUEST['enviar']))
	{
		$verificador=NULL;
		$fechaVerif=NULL;
		$turno=NULL;
		$ubicacion=NULL;
		$habitacion=NULL;
		$otro=NULL;
		$jabon=NULL;
		$gel=NULL;
		$toallas=NULL;
		$cincoMomentos=NULL;
		$tecnicaCorr=NULL;
		$mecanismoDisp=NULL;
		$solCerrados=NULL;
		$goteoProd=NULL;
		$libreProd=NULL;
		$superficieProd=NULL;
		$etiquetaProd=NULL;
		$jabonClorhex=NULL;
		$sustanciaActiva=NULL;
		$gelClorhex=NULL;
		$avisoServGral=NULL;
		$observaciones=NULL;
		
		if (isset($_POST['verificador']))
		{
			$verificador=utf8_decode($_POST['verificador']);
		}
		if (isset($_POST['fechaVerif']))
		{
			$fechaVerif=$_POST['fechaVerif'];
		}
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		/*Extras del listado de hubicacion*/
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
		/**************************************/
		if (isset($_POST['jabon']))
		{
			$jabon=$_POST['jabon'];
		}
		if (isset($_POST['gel']))
		{
			$gel=$_POST['gel'];
		}
		if (isset($_POST['toallas']))
		{
			$toallas=$_POST['toallas'];
		}
		if (isset($_POST['cincoMomentos']))
		{
			$cincoMomentos=$_POST['cincoMomentos'];
		}
		if (isset($_POST['tecnicaCorr']))
		{
			$tecnicaCorr=$_POST['tecnicaCorr'];
		}
		if (isset($_POST['mecanismoDisp']))
		{
			$mecanismoDisp=$_POST['mecanismoDisp'];
		}
		if (isset($_POST['solCerrados']))
		{
			$solCerrados=$_POST['solCerrados'];
		}
		if (isset($_POST['goteoProd']))
		{
			$goteoProd=$_POST['goteoProd'];
		}
		if (isset($_POST['libreProd']))
		{
			$libreProd=$_POST['libreProd'];
		}
		if (isset($_POST['superficieProd']))
		{
			$superficieProd=$_POST['superficieProd'];
		}
		if (isset($_POST['etiquetaProd']))
		{
			$etiquetaProd=$_POST['etiquetaProd'];
		}
		if (isset($_POST['jabonClorhex']))
		{
			$jabonClorhex=$_POST['jabonClorhex'];
		}
		if (isset($_POST['sustanciaActiva']))
		{
			$sustanciaActiva=$_POST['sustanciaActiva'];
		}
		if (isset($_POST['gelClorhex']))
		{
			$gelClorhex=$_POST['gelClorhex'];
		}
		if (isset($_POST['avisoServGral']))
		{
			$avisoServGral=$_POST['avisoServGral'];
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		
		$queryConsHigMan = "INSERT INTO consumiblesHigieneManos (id,verificador,fechaVerificacion,turno,localizacion,habitacion,locOtros,suficienteJabon,
				suficienteGel,suficienteToallas,senal5Momentos,senalTecnicaManos,mecanismoFuncional,solucionCerrados,libreDerramesGoteo,
				librePolvoManchas,superficieLibrePolvo,etiquetaIdentif,jabonClorhexidina,alcoholEtilico,gelAlcoholClorhexidina,avisoServGral,
				observaciones,usr) VALUES (NULL, '$verificador', '$fechaVerif', '$turno', '$ubicacion', '$habitacion', '$otro', '$jabon', '$gel',
				'$toallas','$cincoMomentos','$tecnicaCorr','$mecanismoDisp','$solCerrados','$goteoProd','$libreProd','$superficieProd','$etiquetaProd',
				'$jabonClorhex','$sustanciaActiva','$gelClorhex','$avisoServGral','$observaciones','$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryConsHigMan);
			if(!$result0) {
				echo '!<br> ERROR al realizar inserción de consumibles Higiene de Manos! <br>';
				echo 'QUERY: '.$queryConsHigMan;
			} else {
				echo '<br>!!!! SE GUARDARON CONSUMIBLES HIGIENE DE MANOS CORRECTAMENTE!!!!<br>';
				#echo 'QUERY: '.$queryConsHigMan;
			}
	}

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HIGIENE MANOS</title>
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
							<input name="rol" type="hidden" value="<?php echo $rol ?>" >
                    		<h3>Cédula para la verificación de estructura y consumibles para la higiene de manos 1.1</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>DATOS GENERALES</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-check-square-o" aria-hidden="true"></i></div>
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
                                    <input type="text" name="verificador" placeholder="Nombre" autocomplete="off" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>FECHA DE VERIFICACIÓN : <span>*</span></label>
                                    <input type="date" name="fechaVerif" class="form-control required">
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
                    			    <label>LOCALIZACIÓN DEL DISPOSITIVO : </label>
                                    <select id="ubicacion" name="ubicacion" class="form-control"  onchange="verOtro(this.form)">
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
                                   	 	<input type="number" name="habitacion" placeholder="No. Habitación" min="100" max="250" autocomplete="off" class="form-control">
                                	</div>
									<div id="divOtro" class="form-group" style="display:none">
                    			    	<label>OTRO :</label>
                                   	 	<input type="text" name="otro" placeholder="Indique Lugar" autocomplete="off" class="form-control">
                                	</div>
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
								<h4>1. ABASTECIMIENTO</h4>
								<div class="form-group">
                    			    <label>1.1 El dispositivo tiene suficiente cantidad de jabón : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="jabon" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="jabon" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="jabon" value="NA"> NO APLICA
									</label>									
                                </div>
                    			<div class="form-group">
                    			    <label>1.2 El dispositivo tiene suficiente cantidad de gel-alcohol : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="gel" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="gel" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="gel" value="NA"> NO APLICA
									</label>
                                </div>
                                <div class="form-group">
                    			    <label>1.3 El dispositivo tiene suficiente cantidad de toallas para el secado de manos : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="toallas" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="toallas" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="toallas" value="NA"> NO APLICA
									</label>
                                </div>
								<h4>2. SEÑALIZACIÓN</h4>
								<div class="form-group">
                    			    <label>2.1 Cuenta con señalización sobre los 5 momentos de la higiene de manos : </label>
                                    <br>
                                     <label class="radio-inline">
									  <input type="radio" name="cincoMomentos" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cincoMomentos" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cincoMomentos" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2.2 Cuenta con señalización sobre la técnica correcta de la higiene de manos :</label>
                                    <br>
                                     <label class="radio-inline">
									  <input type="radio" name="tecnicaCorr" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tecnicaCorr" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tecnicaCorr" value="NA"> NO APLICA
									</label>									
                                </div>
								<h4>3. FUNCIONALIDAD DEL DISPOSITIVO</h4>
								<div class="form-group">
                    			    <label>3.1 El mecanismo del dispositivo está funcional y despacha satisfactoriamente el producto : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="mecanismoDisp" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="mecanismoDisp" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="mecanismoDisp" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>3.2 El dispositivo cuenta con sistemas de solución cerrados : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="solCerrados" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="solCerrados" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="solCerrados" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>3.3 Se encuentra libre de derrames, goteo de producto : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="goteoProd" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="goteoProd" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="goteoProd" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>3.4 Está libre de polvo, suciedad, manchas y/o residuo del producto : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="libreProd" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="libreProd" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="libreProd" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>3.5 La superficie donde está instalado el dispositivo está libre de polvo, suciedad, manchas y/o residuo del producto : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="superficieProd" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="superficieProd" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="superficieProd" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>3.6 Cuenta con etiqueta que identifique el producto que contiene : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="etiquetaProd" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="etiquetaProd" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="etiquetaProd" value="NA"> NO APLICA
									</label>									
                                </div>
								<h4>4. USO ADECUADO DE SOLUCIONES PARA LA HIGIENE DE MANOS</h4>
								<div class="form-group">
                    			    <label>4.1 Si es un área crítica utiliza jabón con clorhexidina al 4% : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="jabonClorhex" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="jabonClorhex" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="jabonClorhex" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>4.2 El alcohol gel tiene por sustancia activa alcohol etílico al 70% o equivalente : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="sustanciaActiva" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sustanciaActiva" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sustanciaActiva" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>4.3 Si es un área crítica utiliza gel-alcohol al 70% con clorhexidina al 4% : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="gelClorhex" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="gelClorhex" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="gelClorhex" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>AVISO A SERVICIOS GENERALES : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="avisoServGral" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="avisoServGral" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="avisoServGral" value="NA"> NO APLICA
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
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="submit" name="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 2 -->
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