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
		
		if (isset($_POST['metas']))
		{
			$metas=$_POST['metas'];
		}
		if (isset($_POST['vigilancia']))
		{
			$vigilancia=utf8_decode($_POST['vigilancia']);
		}
		if (isset($_POST['visitaDia']))
		{
			$visitaDia=$_POST['visitaDia'];
		}
		if (isset($_POST['visitaHora']))
		{
			$visitaHora=$_POST['visitaHora'];
		}
		if (isset($_POST['inmuno']))
		{
			$inmuno=$_POST['inmuno'];
		}
		if (isset($_POST['comorbilidad']))
		{
			$comorbilidad=utf8_decode($_POST['comorbilidad']);
		}
		if (isset($_POST['aislamiento']))
		{
			$aislamiento=utf8_decode($_POST['aislamiento']);
		}
		if (isset($_POST['padecimiento']))
		{
			$padecimiento=utf8_decode($_POST['padecimiento']);
		}
		if (isset($_POST['notas']))
		{
			$notas=utf8_decode($_POST['notas']);
		}
		
		$queryInsrVig = "INSERT INTO vigilanciacapacitacion (id,numeroExpediente,folio,metaInternacional,vigilanciaRPBI,fechaVisita,horaVisita,
		inmunocomprometido,comorbilidad,aislamiento,padecimientoAct,notas,usr) VALUES (NULL, '$expediente', '$folio', '$metas', '$vigilancia',
		'$visitaDia', '$visitaHora', '$inmuno', '$comorbilidad', '$aislamiento', '$padecimiento', '$notas', '$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryInsrVig);
			if(!$result0) {
				echo '!<br> ERROR al realizar inserción de Vigilancia! <br>';
				echo 'QUERY: '.$queryInsrVig;
			} else {
				echo '<br>!!!! SE GUARDO LA VIGILANCIA CORRECTAMENTE!!!!<br>';
			}
		
	}

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VIGILANCIA Y CAPACITACIÓN</title>
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
                    		<h3>VIGILANCIA Y CAPACITACIÓN</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 100%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<!--div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>DATOS GENERALES</p>
                    			</div-->
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-check-square-o" aria-hidden="true"></i></div>
                    				<p>DATOS</p>
                    			</div>
								<!-- Step 2 -->
                    		</div>
							<!-- Form progress -->
                    		
							
							<!-- Form Step 1 -->
                    		<!--fieldset>
								<!-- Progress Bar -->
								<!--div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <!--h4>DATOS GENERALES : <span>Paso 1 - 2</span></h4>
								<div class="form-group">
                    			    <label>NOMBRE DEL VERIFICADOR : <span>*</span></label>
                                    <input type="text" name="verificador" placeholder="Nombre" class="form-control required">
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
                                   	 	<input type="number" id="habitacion" name="habitacion" placeholder="No. Habitación" min="100" max="250" class="form-control">
                                	</div>
									<div id="divOtro" class="form-group" style="display:none">
                    			    	<label>OTRO :</label>
                                   	 	<input type="text" id="otro" name="otro" placeholder="Indique Lugar" class="form-control">
                                	</div>
                                </div>															
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset-->
							<!-- Form Step 1 -->

							<!-- Form Step 2 -->
							<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>DATOS : <span>Paso 1 - 1</span></h4>
								<div style="clear:both;"></div>								
								<div class="form-group">
                    			    <label>META INTERNACIONAL 5 : <span>*</span></label>
									<br>
                                    <label class="radio-inline">
									  <input type="number" name="metas" class="form-control required">
									</label>																		
                                </div>
                    			<div class="form-group">
                    			    <label>VIGILANCIA DE RPBI : <span>*</span></label>
									<br>
                                    <label class="radio-inline">
									  <input type="text" name="vigilancia" autocomplete="off" class="form-control required">
									</label>
                                </div>
                                <div class="form-group">
                    			    <label>FECHA DE VISITA : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="date" name="visitaDia" class="form-control required">
									</label>
                                </div>
								<div class="form-group">
                    			    <label>HORA DE VISITA : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="time" name="visitaHora" class="form-control required">
									</label>
                                </div>								
								<div class="form-group">
                    			    <label>INMUNOCOMPROMETIDO : </label>
                                    <br>
                                     <label class="radio-inline">
									  <input type="radio" name="inmuno" value="si" checked="checked"> SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="inmuno" value="no"> NO
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>COMORBILIDAD :</label>
                                    <br>
                                     <label class="radio-inline">
									  <textarea class="form-control" id="comorbilidad" name="comorbilidad" rows="3" cols="50"></textarea>
									</label>
                                </div>
								<div class="form-group">
                    			    <label>AISLAMIENTO :</label>
                                    <br>
                                     <label class="radio-inline">
									  <textarea class="form-control" id="aislamiento" name="aislamiento" rows="3" cols="50"></textarea>
									</label>
                                </div>
								<div class="form-group">
                    			    <label>PADECIMIENTO ACTUAL :</label>
                                    <br>
                                     <label class="radio-inline">
									  <textarea class="form-control" id="padecimiento" name="padecimiento" rows="3" cols="50"></textarea>
									</label>
                                </div>
								<div class="form-group">
                    			    <label>NOTAS :</label>
                                    <br>
                                     <label class="radio-inline">
									  <textarea class="form-control" id="notas" name="notas" rows="3" cols="50"></textarea>
									</label>
                                </div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">
                                    <!--button type="button" class="btn btn-previous">Anterior</button-->
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