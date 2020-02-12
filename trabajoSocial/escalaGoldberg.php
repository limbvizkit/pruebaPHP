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
		
		
		if (isset($_POST['intranquilo']))
		{
			$intranquilo=$_POST['intranquilo'];
		}
		if (isset($_POST['preocupado']))
		{
			$preocupado=$_POST['preocupado'];
		}
		if (isset($_POST['irritable']))
		{
			$irritable=$_POST['irritable'];
		}
		if (isset($_POST['relajarse']))
		{
			$relajarse=$_POST['relajarse'];
		}
		if (isset($_POST['dormir']))
		{
			$dormir=$_POST['dormir'];
		}
		if (isset($_POST['cabeza']))
		{
			$cabeza=$_POST['cabeza'];
		}
		if (isset($_POST['vegetativos']))
		{
			$vegetativos=$_POST['vegetativos'];
		}
		if (isset($_POST['preocupadoSalud']))
		{
			$preocupadoSalud=$_POST['preocupadoSalud'];
		}
		if (isset($_POST['conciliarSueno']))
		{
			$conciliarSueno=$_POST['conciliarSueno'];
		}
		if (isset($_POST['pocaEnergia']))
		{
			$pocaEnergia=$_POST['pocaEnergia'];
		}
		if (isset($_POST['interes']))
		{
			$interes=$_POST['interes'];
		}
		if (isset($_POST['confianza']))
		{
			$confianza=$_POST['confianza'];
		}
		if (isset($_POST['desesperanzado']))
		{
			$desesperanzado=$_POST['desesperanzado'];
		}
		if (isset($_POST['concentrarse']))
		{
			$concentrarse=$_POST['concentrarse'];
		}
		if (isset($_POST['peso']))
		{
			$peso=$_POST['peso'];
		}
		if (isset($_POST['despertando']))
		{
			$despertando=$_POST['despertando'];
		}
		if (isset($_POST['enlentecido']))
		{
			$enlentecido=$_POST['enlentecido'];
		}
		if (isset($_POST['encontrarse']))
		{
			$encontrarse=$_POST['encontrarse'];
		}
		
		
		$queryInsEscGold = "INSERT INTO escalagoldberg (id,numeroExpediente,folio,intranquilo,preocupado,irritable,relajarse,dormir,cabeza,vegetativos,preocupadoSalud,conciliarSueno,pocaEnergia,interes,confianza,
												desesperanzado,concentrarse,peso,despertando,enlentecido,encontrarse,usr)
							VALUES (NULL,'$expediente','$folio','$intranquilo','$preocupado','$irritable','$relajarse','$dormir','$cabeza','$vegetativos','$preocupadoSalud','$conciliarSueno','$pocaEnergia','$interes',
							'$confianza','$desesperanzado','$concentrarse','$peso','$despertando','$enlentecido','$encontrarse','$rol')";
		$result0 = mysqli_query($conexion, $queryInsEscGold);
		if(!$result0) {
			echo '!<br> ERROR al insertar los datos de la Escala de Goldberg! <br>';
			echo 'QUERY: '.$queryInsEscGold;
		} else {
			echo '<br>!!!! SE GUARDO LA ESCALA DE GOLDBERG CORRECTAMENTE !!!!<br>';
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Escala Goldberg</title>

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

                    		<h3>ESCALA DE DEPRESIÓN Y ANSIEDAD DE GOLDBERG</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Escala de Ansiedad</p>
                    			</div>
								<!-- Step 1 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-random" aria-hidden="true"></i></div>
                    				<p>Escala de depresión</p>
                    			</div>
								<!-- Step 4 -->
								<!--div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>Intervención Quirurgica y Pronóstico</p>
                    			</div-->
								<!-- Step 4 -->
                    		</div>
							<!-- Form progress -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>Escala de ansiedad: <span>Paso 1 - 2</span></h4>
								<h3><span>¿Usted a presentado en las ultimas 2 semanas algunos de los siguientes síntomas?<br>Es importante intentar contestar TODAS las preguntas.</span></h3>
								<div class="form-group">
									<label>1.- ¿Se ha sentido muy intranquilo, nervioso o en tensión? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="intranquilo" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="intranquilo" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>2.- ¿Ha estado muy preocupado por algo? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="preocupado" value="1" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="preocupado" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>3.- ¿Se ha sentido muy irritable? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="irritable" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="irritable" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>4.- ¿Ha tenido dificultad para relajarse? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="relajarse" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="relajarse" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								 <h4>(Si hay 2 o más respuestas afirmativas, continuar preguntando)</h4>
								
								<div class="form-group">
									<label>5.- ¿Ha dormido mal, ha tenido dificultades para dormir? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="dormir" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="dormir" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>6.- ¿Ha tenido dolores de cabeza o nuca? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="cabeza" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cabeza" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>7.- ¿Ha tenido alguno de los siguientes síntomas: temblores, hormigueos, mareos, sudores, diarrea? (Sintomas vegetativos) <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="vegetativos" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="vegetativos" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>8.- ¿Ha estado preocupado por su salud? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="preocupadoSalud" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="preocupadoSalud" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>9.- ¿Ha tenido alguna dificultad para conciliar el sueño, para quedarse dormido? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="conciliarSueno" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="conciliarSueno" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								 <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>Escala de Depresión: <span>Paso 2 - 2</span></h4>
								<div class="form-group">
									<label>1.- ¿Se ha sentido con poca energía? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="pocaEnergia" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pocaEnergia" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>2.- ¿Ha perdido usted su interés por las cosas? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="interes" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="interes" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>3.- ¿Ha perdido la confianza en sí mismo? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="confianza" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="confianza" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>4.- ¿Se ha sentido usted desesperanzado, sin esperanzas? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="desesperanzado" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="desesperanzado" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								 <h4>(Si hay al menos una respuestas afirmativas, continuar preguntando)</h4>
								<div class="form-group">
									<label>5.- ¿Ha tenido dificultades para concentrarse? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="concentrarse" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="concentrarse" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>6.- ¿Ha perdido peso? (Ha causa de falta de apetito) <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="peso" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="peso" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>7.- ¿Se ha estado despertando demasiado temprano? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="despertando" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="despertando" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>8.- ¿Se ha sentido usted enlentecido? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="enlentecido" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="enlentecido" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>9.- ¿Cree usted que ha tenido tendencia a encontrarse peor por las mañanas? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="encontrarse" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="encontrarse" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>">								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>">
								<input name="folio" type="hidden" value="<?php echo $folio ?>">
                                <div class="form-wizard-buttons">
									<button type="button" class="btn btn-previous">Anterior</button>
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