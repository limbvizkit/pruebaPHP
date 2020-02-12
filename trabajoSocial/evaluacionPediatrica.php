<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configLogin.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../conexion/funciones_db.php');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['exp']))
	{
		$expediente=$_GET['exp'];
	} else {
		$expediente=NULL;
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	} else {
		$folio=NULL;
	}

	
	//$diagFin=NULL;
	$nombre_pac =NULL;

	//Query para jalar los datos de la consulta medica
	/*$queryAntec = "SELECT *
				  FROM notaUrg
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'				  
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		$diagOld= utf8_encode($rowA['diag']);
		$diagFin=addslashes ($diagOld);
	}*/
	
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
		
		
		if (isset($_POST['antecedentesPsiquiatricos']))
		{
			$antecedentesPsiquiatricos=utf8_decode($_POST['antecedentesPsiquiatricos']);
		}
		if (isset($_POST['orientacion']))
		{
			$orientacion=utf8_decode($_POST['orientacion']);
		}
		if (isset($_POST['alteracionesSueno']))
		{
			$alteracionesSueno=utf8_decode($_POST['alteracionesSueno']);
		}
		if (isset($_POST['alteracionesAlimentos']))
		{
			$alteracionesAlimentos=utf8_decode($_POST['alteracionesAlimentos']);
		}
		if (isset($_POST['vidaEscolar']))
		{
			$vidaEscolar=utf8_decode($_POST['vidaEscolar']);
		}
		if (isset($_POST['estadoAnimico']))
		{
			$estadoAnimico=utf8_decode($_POST['estadoAnimico']);
		}
		if (isset($_POST['memoria']))
		{
			$memoria=utf8_decode($_POST['memoria']);
		}
		if (isset($_POST['lenguaje']))
		{
			$lenguaje=utf8_decode($_POST['lenguaje']);
		}
		
		$queryInsEvPed = "INSERT INTO evaluacionpediatrica (id,numeroExpediente,folio,antecedentesPsiquiatricos,orientacion,alteracionesSueno,alteracionesAlimentos,vidaEscolar,estadoAnimico,memoria,lenguaje,usr)
							VALUES (NULL,'$expediente','$folio','$antecedentesPsiquiatricos','$orientacion','$alteracionesSueno','$alteracionesAlimentos','$vidaEscolar','$estadoAnimico','$memoria','$lenguaje','$rol')";
		$result0 = mysqli_query($conexion, $queryInsEvPed);
		if(!$result0) {
			echo '!<br> ERROR al insertar los datos de la Evaluación Inicial Psicológica Pediátrica! <br>';
			echo 'QUERY: '.$queryInsEvPed;
		} else {
			echo '<br>!!!! SE GUARDO LA EVALUACIÓN INICIAL PSICOLÓGICA PEDIÁTRICA CORRECTAMENTE !!!!<br>';
		}
		
	}
	

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Evaluación Psicológica pediatrica</title>

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

                    		<h3>EVALUACIÓN INICAL PSICOLÓGICA PEDIÁTRICA</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 100%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>DATOS</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 4 -->
								<!--div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>Intervención Quirurgica y Pronóstico</p>
                    			</div-->
								<!-- Step 4 -->
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
                    		    <h4>DATOS: <span>Paso 1 - 1</span></h4>
								<h3><span>Neonatos y lactantes no se realizará la evaluación de factores de riesgo psicológico. Mayores de 6 años</span></h3>
								<div class="form-group">
									<label>1.- Antecedentes Psiquiátricos en la familia : <span>*</span></label>
									<input type="text" name="antecedentesPsiquiatricos" class="form-control required">
								</div>
								<div class="form-group">
									<label>2.- Orientación (Persona, lugar y tiempo) :<br> ¿Cómo te llamas? ¿Dónde estás? ¿Qué día es hoy? <span>*</span></label>
									<input type="text" name="orientacion" class="form-control required">
								</div>
								<div class="form-group">
									<label>3.- ¿Alteraciones del sueño? <span>*</span></label>
									<input type="text" name="alteracionesSueno" class="form-control required">
								</div>
								<div class="form-group">
									<label>4.- ¿Alteraciones de alimentación? (Comer en exceso o dejar de comer) <span>*</span></label>
									<input type="text" name="alteracionesAlimentos" class="form-control required">
								</div>
								<div class="form-group">
									<label>5.- Vida escolar (Cambios de comportamiento en los últimos 6 meses) <span>*</span></label>
									<input type="text" name="vidaEscolar" class="form-control required">
								</div>
								<div class="form-group">
									<label>6.- Estado anímico :<br> ¿Se encuentra aletargado o hiperactivo? <span>*</span></label>
									<input type="text" name="estadoAnimico" class="form-control required">
								</div>
								<div class="form-group">
									<label>7.- Memoria :<br> Que repita 3 palabras p.ej. Edificio, letras, rojo y las repita al final de la entrevista. <span>*</span></label>
									<input type="text" name="memoria" class="form-control required">
								</div>
								<div class="form-group">
									<label>8.- Lenguaje :<br> Explorar si padece algún problema para comunicarse y como se expresa durante la entrevista. <span>*</span></label>
									<input type="text" name="lenguaje" class="form-control required">
								</div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>">								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>">
								<input name="folio" type="hidden" value="<?php echo $folio ?>">
                                <div class="form-wizard-buttons">
                                    <button id="add_button" type="submit" name="enviar" class="btn btn-submit">Guardar</button>
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