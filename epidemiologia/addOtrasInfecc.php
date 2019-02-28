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
		
		$verificador=NULL;
		$infeccion=NULL;
		$inicio=NULL;
		$termino=NULL;
		$fechaObservacion=NULL;
		$observaciones=NULL;
		
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
		if (isset($_POST['infeccion']))
		{
			$infeccion=utf8_decode($_POST['infeccion']);
		}
		if (isset($_POST['inicio']))
		{
			$inicio=$_POST['inicio'];
		}
		if (isset($_POST['termino']))
		{
			$termino=$_POST['termino'];
		}
		if (isset($_POST['fechaObservacion']))
		{
			$fechaObservacion=$_POST['fechaObservacion'];
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		
		$queryInsrOtrasInf = "INSERT INTO pacienteotrasinfecciones (id, numeroExpediente, folio, verificador, infeccion, fechaInicio, fechaObservacion,
		fechaTermino, observaciones, usr) VALUES (NULL, '$expediente', '$folio', '$verificador', '$infeccion', '$inicio', '$fechaObservacion', '$termino','$observaciones', '$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryInsrOtrasInf);
			if(!$result0) {
				echo '!<br> ERROR al realizar inserción de Otras Infecciones! <br>';
				echo 'QUERY: '.$queryInsrOtrasInf;
			} else {
				echo '<br>!!!! SE GUARDARON OTRAS INFECCIONES CORRECTAMENTE!!!!<br>';
			}
		
	}

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OTRAS INFECCIONES</title>
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
                    		<h3>VIGILANCIA DE OTRAS INFECCIONES ASOCIADAS A LA ATENCIÓN DE LA SALUD</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 100%;"></div>
								</div>
								<!-- Step 2 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-bug" aria-hidden="true"></i></div>
                    				<p>OTRAS INFECCIONES</p>
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
                                <h4>OTRAS INFECCIONES : <span>Paso 1 - 1</span></h4>
								<!--div style="clear:both;"></div-->							
                    			    <div class="form-group">
                    			    	<label>NOMBRE DEL VERIFICADOR : <span>*</span></label>
                                    <input type="text" name="verificador" placeholder="Nombre" autocomplete="off" class="form-control required">
                                																		
                                	</div>
								 <div class="form-group">
                    			    	<label>INFECCIÓN : <span>*</span></label>
                                    <input type="text" name="infeccion" placeholder="Nombre de Infección" autocomplete="off" class="form-control required">                                																		
                                	</div>
                                <div class="form-group">
                    			    <label>FECHA DE INICIO : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="date" name="inicio" class="form-control required">
									</label>
                                </div>								
								<div class="form-group">
                    			    <label>FECHA DE OBSERVACIÓN : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="date" name="fechaObservacion" class="form-control required">
									</label>
                                </div>
								<div class="form-group">
                    			    <label>FECHA DE TERMINO : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="date" name="termino" class="form-control">
									</label>
                                </div>
								<div class="form-group">
                    			    <label>OBSERVACIONES :</label>
                                    <br>
                                     <label class="radio-inline">
									  <textarea class="form-control" id="observaciones" name="observaciones" rows="3" cols="50"></textarea>
									</label>
                                </div>
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
								<br/>
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