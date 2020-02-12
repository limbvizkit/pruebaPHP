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
	if (isset($_GET['anios']))
	{
		$anniosInt=$_GET['anios'];
	} else {
		$anniosInt=NULL;
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
		$riesgoPedia=2;
		$riesgoAdulto=2;
		$riesgoGeria=2;

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
		//parte 2
		if (isset($_POST['divorcio']))
		{
			$divorcio=$_POST['divorcio'];
		}
		if (isset($_POST['muerte']))
		{
			$muerte=$_POST['muerte'];
		}
		if (isset($_POST['discapacidad']))
		{
			$discapacidad=$_POST['discapacidad'];
		}
		if (isset($_POST['jubilacion']))
		{
			$jubilacion=$_POST['jubilacion'];
		}
		if (isset($_POST['enfermedad']))
		{
			$enfermedad=$_POST['enfermedad'];
		}
		if (isset($_POST['desempleo']))
		{
			$desempleo=$_POST['desempleo'];
		}
		if (isset($_POST['droga']))
		{
			$droga=$_POST['droga'];
		}
		if (isset($_POST['embarazo']))
		{
			$embarazo=$_POST['embarazo'];
		}
		if (isset($_POST['economica']))
		{
			$economica=$_POST['economica'];
		}
		if (isset($_POST['trabajo']))
		{
			$trabajo=$_POST['trabajo'];
		}
		if (isset($_POST['legales']))
		{
			$legales=$_POST['legales'];
		}
		if (isset($_POST['residencia']))
		{
			$residencia=$_POST['residencia'];
		}
		if (isset($_POST['colegio']))
		{
			$colegio=$_POST['colegio'];
		}
		//parte3
		if (isset($_POST['transfusiones']))
		{
			$transfusiones=utf8_decode($_POST['transfusiones']);
			$transfusiones=addslashes($transfusiones);
		}
		if (isset($_POST['alimentacion']))
		{
			$alimentacion=utf8_decode($_POST['alimentacion']);
			$alimentacion=addslashes($alimentacion);
		}
		if (isset($_POST['medicamentos']))
		{
			$medicamentos=utf8_decode($_POST['medicamentos']);
			$medicamentos=addslashes($medicamentos);
		}
		if (isset($_POST['genero']))
		{
			$genero=utf8_decode($_POST['genero']);
			$genero=addslashes($genero);
		}
		if (isset($_POST['otro']))
		{
			$otro=utf8_decode($_POST['otro']);
			$otro=addslashes($otro);
		}
		if (isset($_POST['nota1']))
		{
			$nota1=utf8_decode($_POST['nota1']);
			$nota1=addslashes($nota1);
		}
		
		if (isset($_POST['riesgoPedia']))
		{
			$riesgoPedia=$_POST['riesgoPedia'];
		}
		if (isset($_POST['riesgoAdulto']))
		{
			$riesgoAdulto=$_POST['riesgoAdulto'];
		}
		if (isset($_POST['riesgoGeria']))
		{
			$riesgoGeria=$_POST['riesgoGeria'];
		}
		
		if (isset($_POST['nota2']))
		{
			$nota2=utf8_decode($_POST['nota2']);
			$nota2=addslashes($nota2);
		}
		
		$queryInsFRS = "INSERT INTO factoresriesgosocial (id,numeroExpediente,folio,divorcio,muerte,discapacidad,jubilacion,enfermedad,desempleo,droga,embarazo,economica,trabajo,legales,residencia,colegio,transfusiones,
							alimentacion,medicamentos,genero,otro,nota1,riesgoPedia,riesgoAdulto,riesgoGeria,nota2,usr)
							VALUES (NULL,'$expediente','$folio','$divorcio','$muerte','$discapacidad','$jubilacion','$enfermedad','$desempleo','$droga','$embarazo','$economica','$trabajo','$legales','$residencia','$colegio',
							'$transfusiones','$alimentacion','$medicamentos','$genero','$otro','$nota1','$riesgoPedia','$riesgoAdulto','$riesgoGeria','$nota2','$rol')";
		$result0 = mysqli_query($conexion, $queryInsFRS);
		if(!$result0) {
			echo '!<br> ERROR al insertar los datos de Factores de Riesgo Social! <br>';
			echo 'QUERY: '.$queryInsFRS;
		} else {
			echo '<br>!!!! SE GUARDARON LOS FACTORES DE RIESGO SOCIAL CORRECTAMENTE !!!!<br>';
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Factores Riesgo Social</title>

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

                    		<h3>FACTORES DE RIESGO SOCIAL</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
                    				<p>Factores de riesgo</p>
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
                    		    <h4>Factores: <span>Paso 1 - 1</span></h4>
								<h3><span>Acontencidos en los utlimos 6 meses </span></h3>
								<div class="form-group">
									<label>Divorcio o separación matrimonial : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="divorcio" value="69" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="divorcio" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Muerte de un familiar cercano de fecha reciente : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="muerte" value="65" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="muerte" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Discapacidad permanente : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="discapacidad" value="63" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="discapacidad" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Jubilación : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="jubilacion" value="53" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="jubilacion" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Enfermedad o accidente de un importante miembro de la familia : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="enfermedad" value="45" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="enfermedad" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Desempleo : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="desempleo" value="44" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="desempleo" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Drogadicción y/o alcoholismo : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="droga" value="44" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="droga" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Embarazo no deseado : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="embarazo" value="40" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="embarazo" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Cambia de situación económica : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="economica" value="38" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="economica" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Cambio de trabajo : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="trabajo" value="36" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="trabajo" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Problemas legales : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="legales" value="29" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="legales" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Cambio de residencia : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="residencia" value="20" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="residencia" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								<div class="form-group">
									<label>Cambio de colegio : <span>*</span></label>
									<br>
									 <label class="radio-inline">
									  <input type="radio" name="colegio" value="20" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="colegio" value="0" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; NO
									</label>
								</div>
								 <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
							</fieldset>
							
							<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>Valores, costumbres y creencias que dificultan el proceso de atención del paciente: <span>Paso 2 - 2</span></h4>
								<div class="form-group">
									<label>Rechazo de transfusiones <span>*</span></label>
									<textarea class="form-control required" name="transfusiones" id="transfusiones" cols="15" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label>Rechazo al tipo de alimentación <span>*</span></label>
									<textarea class="form-control required" name="alimentacion" id="alimentacion" cols="15" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label>Rechazo al uso de medicamentos <span>*</span></label>
									<textarea class="form-control required" name="medicamentos" id="medicamentos" cols="15" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label>Rechazo a ser atendido por algún tipo de género o persona de nuestro hospital <span>*</span></label>
									<textarea class="form-control required" name="genero" id="genero" cols="15" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label>Otro : <span>*</span></label>
									<textarea class="form-control required" name="otro" id="otro" cols="15" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label>Nota : <span>*</span></label>
									<textarea class="form-control required" name="nota1" id="nota1" cols="15" rows="3"></textarea>
								</div>
								
								<h3>Evaluación de factores de riesgo psicológicos:</h3>
								<?php if ($anniosInt >= 6 && $anniosInt < 18 ) {?>
									<h4>Paciente pediátrico:</h4>
									<div class="form-group">
										<label>Se detecta riesgo : <span>*</span></label>
											<br>
										 	<label class="radio-inline">
										  		<input type="radio" name="riesgoPedia" value="1" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
											</label>
											<label class="radio-inline">
										  		<input type="radio" name="riesgoPedia" value="0" style="width: 30px; height: 30px" >&nbsp;&nbsp; NO
											</label>
									</div>
								<?php } ?>
								<?php if ($anniosInt >= 18 && $anniosInt < 65 ) {?>
									<h4>Paciente adulto 18 a 64 años:</h4>
									<div class="form-group">
										<label>Se detecta riesgo (Puntaje 2 o más): <span>*</span></label>
											<br>
										 	<label class="radio-inline">
										  		<input type="radio" name="riesgoAdulto" value="1" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
											</label>
											<label class="radio-inline">
										  		<input type="radio" name="riesgoAdulto" value="0" style="width: 30px; height: 30px" >&nbsp;&nbsp; NO
											</label>
									</div>
								<?php } ?>
								<?php if ($anniosInt > 64 ) {?>
									<h4>Paciente Geriátrico 65 años o más:</h4>
									<div class="form-group">
										<label>Se detecta riesgo : <span>*</span></label>
											<br>
										 	<label class="radio-inline">
										  		<input type="radio" name="riesgoGeria" value="1" style="width: 30px; height: 30px" >&nbsp;&nbsp; SI
											</label>
											<label class="radio-inline">
										  		<input type="radio" name="riesgoGeria" value="0" style="width: 30px; height: 30px" >&nbsp;&nbsp; NO
											</label>
										<br>
										<br>
										<div class="form-group">
										<label>Nota : <span>*</span></label>
										<textarea class="form-control required" name="nota2" id="nota2" cols="15" rows="3"></textarea>
								</div>
									</div>
								<?php } ?>
								
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