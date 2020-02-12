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
		
		
		if (isset($_POST['satisfecho']))
		{
			$satisfecho=$_POST['satisfecho'];
		}
		if (isset($_POST['dejadoCosas']))
		{
			$dejadoCosas=$_POST['dejadoCosas'];
		}
		if (isset($_POST['vidaVacia']))
		{
			$vidaVacia=$_POST['vidaVacia'];
		}
		if (isset($_POST['aburrido']))
		{
			$aburrido=$_POST['aburrido'];
		}
		if (isset($_POST['buenAnimo']))
		{
			$buenAnimo=$_POST['buenAnimo'];
		}
		if (isset($_POST['maloPasar']))
		{
			$maloPasar=$_POST['maloPasar'];
		}
		if (isset($_POST['feliz']))
		{
			$feliz=$_POST['feliz'];
		}
		if (isset($_POST['valeNada']))
		{
			$valeNada=$_POST['valeNada'];
		}
		if (isset($_POST['salirCalle']))
		{
			$salirCalle=$_POST['salirCalle'];
		}
		if (isset($_POST['memoria']))
		{
			$memoria=$_POST['memoria'];
		}
		if (isset($_POST['agradableVivo']))
		{
			$agradableVivo=$_POST['agradableVivo'];
		}
		if (isset($_POST['valePoco']))
		{
			$valePoco=$_POST['valePoco'];
		}
		if (isset($_POST['llenoEnergia']))
		{
			$llenoEnergia=$_POST['llenoEnergia'];
		}
		if (isset($_POST['sinEsperanza']))
		{
			$sinEsperanza=$_POST['sinEsperanza'];
		}
		if (isset($_POST['suerte']))
		{
			$suerte=$_POST['suerte'];
		}
		
		
		
		$queryInsEscYesa = "INSERT INTO escalayesavage (id,numeroExpediente,folio,satisfecho,dejadoCosas,vidaVacia,aburrido,buenAnimo,maloPasar,feliz,valeNada,salirCalle,memoria,agradableVivo,valePoco,llenoEnergia,
							sinEsperanza,suerte,usr)
							VALUES (NULL,'$expediente','$folio','$satisfecho','$dejadoCosas','$vidaVacia','$aburrido','$buenAnimo','$maloPasar','$feliz','$valeNada','$salirCalle','$memoria','$agradableVivo','$valePoco',
							'$llenoEnergia','$sinEsperanza','$suerte','$rol')";
		$result0 = mysqli_query($conexion, $queryInsEscYesa);
		if(!$result0) {
			echo '!<br> ERROR al insertar los datos de la Escala de Yesavage! <br>';
			echo 'QUERY: '.$queryInsEscYesa;
		} else {
			echo '<br>!!!! SE GUARDO LA ESCALA DE YESAVAGE CORRECTAMENTE !!!!<br>';
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Escala Yesavage</title>

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

                    		<h3>ESCALA GERIÁTRICA DE YESAVAGE</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Escala de Yesavage</p>
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
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>Preguntas: <span>Paso 1 - 1</span></h4>
								<h3><span>Los participantes deben responder por sí o por no con respecto a cómo se sintieron en la última semana</span></h3>
								<div class="form-group">
									<label>1.- ¿Está usted satisfecho con la vida que lleva? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="satisfecho" value="1" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="satisfecho" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
									
								</div>
								<div class="form-group">
									<label>2.- ¿Ha dejado de hacer las cosas que le gustan? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="dejadoCosas" value="1" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="dejadoCosas" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>3.- ¿Siente que su vida está vacía? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="vidaVacia" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="vidaVacia" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>4.- ¿Se siente aburrido frecuentemente? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="aburrido" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="aburrido" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>5.- ¿Está de buen ánimo la mayor parte del tiempo? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="buenAnimo" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="buenAnimo" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>6.- ¿Está preocupado porque piensa que algo malo le va pasar? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="maloPasar" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="maloPasar" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>7.- ¿Se siente feliz gran parte de su tiempo? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="feliz" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="feliz" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>8.- ¿Siente a menudo que no vale nada? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="valeNada" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="valeNada" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>9.- ¿Prefiere estar sin hacer nada en casa durante el día que salir a la calle? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="salirCalle" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="salirCalle" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>10.- ¿Piensa que tiene más problemas de memoria que la mayoría de la gente de su edad? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="memoria" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="memoria" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>11.- ¿Piensa que es agradable estar vivo? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="agradableVivo" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="agradableVivo" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>12.- ¿Siente que vale poco en su actual condición? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="valePoco" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="valePoco" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>13.- ¿Se siente lleno de energía? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="llenoEnergia" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="llenoEnergia" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>14.- ¿Se encuentra sin esperanza por su condición actual? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="sinEsperanza" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sinEsperanza" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>15.- ¿Piensa que la mayoría de la gente tiene más suerte que usted? <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="suerte" value="1" style="width: 30px; height: 30px">&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="suerte" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
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