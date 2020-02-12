<?php
	//setlocale(LC_ALL,'');
	date_default_timezone_set('America/Mexico_City');
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configMedico.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../conexion/funciones_db.php');
	setlocale(LC_ALL,'');

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
	
	/*$diagFin=NULL;
	$antecedentesFin=NULL;
	$interrogatorioFin=NULL;

	//Query para jalar los datos de la nota de urgencias
	$queryAntec = "SELECT *
				  FROM notaUrg
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		$antecOld= utf8_encode($rowA['antecedentes']);
		$antecedentesFin=addslashes ($antecOld);
		
		$interrogaOld= utf8_encode($rowA['interrogatorio']);
		$interrogatorioFin=addslashes ($interrogaOld);

		$diagOld= utf8_encode($rowA['diag']);
		$diagFin=addslashes ($diagOld);
		
	}*/
	
	if(isset($_REQUEST['enviar']))
	{
		
		$examenes=NULL;
		

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
		if (isset($_POST['fechaSolicitud']))
		{
			$fechaSolicitud=$_POST['fechaSolicitud'];
		}
		if (isset($_POST['horaSolicitud']))
		{
			$horaSolicitud=$_POST['horaSolicitud'];
		}
		if (isset($_POST['servicio']))
		{
			$servicio=utf8_decode($_POST['servicio']);
			$servicio=addslashes($servicio);
		}
		if (isset($_POST['examenes']))
		{
			$examenes=utf8_decode($_POST['examenes']);
			$examenes=addslashes($examenes);
		}
		if (isset($_POST['diagnostico']))
		{
			$diagnostico=utf8_decode($_POST['diagnostico']);
			$diagnostico=addslashes($diagnostico);
		}
		if (isset($_POST['nombreMedicoTratante']))
		{
			$nombreMedicoTratante=utf8_decode($_POST['nombreMedicoTratante']);
		}
		if (isset($_POST['cedulaT']))
		{
			$cedulaT=$_POST['cedulaT'];
		}
		if (isset($_POST['nombreMedicoSolicitante']))
		{
			$nombreMedicoSolicitante=utf8_decode($_POST['nombreMedicoSolicitante']);
		}
		if (isset($_POST['cedulaS']))
		{
			$cedulaS=$_POST['cedulaS'];
		}
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' '.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		//Insertamos en la tabla de imagen el nombre del estudio(id) y si existe txt complementario
		$queryInsLab = "INSERT INTO laboratorio (id,numeroExpediente,folio,fechaSolicitud,horaSolicitud,servicio,examenes,diagnostico,cedulaT,nombreMedicoTratante,cedulaS,nombreMedicoSolicitante,usr)
							VALUES (NULL,'$expediente','$folio','$fechaSolicitud','$horaSolicitud','$servicio','$examenes','$diagnostico','$cedulaT','$nombreMedicoTratante','$cedulaS','$nombreMedicoSolicitante','$rol')";
		$result0 = mysqli_query($conexionMedico, $queryInsLab);
		if(!$result0) {
			echo '!<br> ERROR al insertar Solicitud a LABORATORIO <br>';
			echo 'QUERY: '.$queryInsLab;
		} else {
			echo '<br>!!!! SE GUARDO LA SOLICITUD A LABORATORIO CORRECTAMENTE !!!!<br>';
		}
		
	}
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LABORATORIO</title>

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

    <body onunload="window.opener.location.reload()">
        <!-- main content -->
        <section class="form-box">
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-5 col-lg-10 col-lg-offset-15 col-md-10 col-md-offset-1">
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
                    	<form role="form" action="" method="post">

                    		<h3>SOLICITUD A LABORATORIO</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="3" style="width: 100%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>DATOS</p>
                    			</div>
								<!-- Step 1 -->
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>DATOS: <span>Paso 1 - 1</span></h4>
								<div class="form-group">
									<label>FECHA : <span>*</span></label>
									<input type="date" name="fechaSolicitud" value="<?php echo $fechaActual ?>" class="form-control required">
								</div>
								<div class="form-group">
									<label>HORA : <span>*</span></label>
									<input type="time" name="horaSolicitud"  value="<?php echo $horaActual ?>" class="form-control required">
								</div>
								
								<div class="form-group">
                    			    <label>SERVICIO : <span>*</span></label>
                                    <br>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="UCI" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; UCI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Consulta Externa" style="width: 30px; height: 30px">&nbsp;&nbsp; Consulta Externa
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Urgencias" style="width: 30px; height: 30px" >&nbsp;&nbsp; Urgencias
									</label>
                                    <label class="radio-inline">
									  <input type="radio" name="servicio" value="Hospitalización" style="width: 30px; height: 30px" >&nbsp;&nbsp; Hospitalización
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Transoperatoria" style="width: 30px; height: 30px">&nbsp;&nbsp; Transoperatoria
									</label>
                                </div>
								<div class="form-group">
                    			    <label>EXÁMENES SOLICITADOS: <span>*</span></label>
                                    <textarea class="form-control required" name="examenes" id="examenes" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
									<label>DIAGNÓSTICO PRESUNTIVO: <span>*</span></label>
									<textarea class="form-control required" name="diagnostico" id="diagnostico" cols="10" rows="3"></textarea>
								</div>
                                <div class="form-group">
									<h4>DATOS DEL MÉDICO TRATANTE:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedulaT" type="text" name="cedulaT" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off">
									<br>
									<div id="suggestions1"></div>
								</div>
								<h6>*Si no conoce la cedula del medico tratante colocar el nombre, si ya colocó una cedula no llenar</h6>
								<div class="form-group">
                    			    <label>NOMBRE DEL MEDICO TRATANTE : </label>
                                    <input class="form-control " type="text"  name="nombreMedicoTratante" id="nombreMedicoTratante">
                                </div>
								
								 <div class="form-group">
									<h4>DATOS DEL MÉDICO SOLICITANTE:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedulaS" type="text" name="cedulaS" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off">
									<br>
									<div id="suggestions2"></div>
								</div>
								<h6>*Si no conoce la cedula del medico solicitante colocar el nombre, si ya colocó una cedula no llenar</h6>
								<div class="form-group">
                    			    <label>NOMBRE DEL MEDICO SOLICITANTE : </label>
                                    <input class="form-control " type="text"  name="nombreMedicoSolicitante" id="nombreMedicoSolicitante">
                                </div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>">								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>">
								<input name="folio" type="hidden" value="<?php echo $folio ?>">
                                <div class="form-wizard-buttons">
                                    <button id="add_button" type="submit" name="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>	      
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
		<script type="text/javascript">
		//Funcion para autocomplementar los Medicos
		var id1 = "";
		  $(document).ready(function(e) {
			$('#cedulaT').bind('input keyup', function(){
				//Obtenemos el value del input
				var cedula = $(this).val();
				var dataString0 = 'cedula='+cedula;
				
				var n = dataString0.length;
				if(n > 10){
					var dataString = dataString0;
				} else {
					var dataString = 'cedula=" "';
				}
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "autocompleteDR.php",
		            data: dataString,
		            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
		            //async: false,
		            success: function(data) {
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions1').fadeIn(1000).html(data);
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id1 = $(this).attr('id1'); //id del Medico
							var valor = $(this).attr('data'); //Nombre del Medico
							var especialidad = $(this).attr('especialidad');
							var ced = $(this).attr('ced');
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							valor = valor.trim();
							$('#cedulaT').val(ced);
							//$('#telCirujano').val(tel);
							//$('#emailCirujano').val(email);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions1').fadeOut(1000);
							//Add valor del id del elemento seleccionado
							//$('#idMedic').val(id1);
						});
		            }
		        });
		    });
		});
		var id2 = "";
		  $(document).ready(function(e) {
			$('#cedulaS').bind('input keyup', function(){
				//Obtenemos el value del input
				var cedula = $(this).val();
				var dataString0 = 'cedula='+cedula;
				
				var n = dataString0.length;
				if(n > 10){
					var dataString = dataString0;
				} else {
					var dataString = 'cedula=" "';
				}
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "autocompleteDR.php",
		            data: dataString,
		            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
		            //async: false,
		            success: function(data) {
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions2').fadeIn(1000).html(data);
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id2 = $(this).attr('id1'); //id del Medico
							var valor = $(this).attr('data'); //Nombre del Medico
							var especialidad = $(this).attr('especialidad');
							var ced = $(this).attr('ced');
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							valor = valor.trim();
							$('#cedulaS').val(ced);
							//$('#telCirujano').val(tel);
							//$('#emailCirujano').val(email);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions2').fadeOut(1000);
							//Add valor del id del elemento seleccionado
							//$('#idMedic').val(id1);
						});
		            }
		        });
		    });
		});
			function mostrarOt() {
				 element = document.getElementById("otro");
				check = document.getElementById("otros");
				if (check.checked) {
					element.style.display='block';
				} else {
					element.style.display='none';
				}
			}
		</script>
		
		<!-- Plugin Custom JS -->
        <script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script>
        <!-- Plugin Custom JS -->

    </body>

</html>

<?php
	function eliminar_tildes($cadena){

		//Codificamos la cadena en formato utf8 en caso de que nos de errores
		//$cadena = utf8_encode($cadena);

		//Ahora reemplazamos las letras
		$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
		);

		$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

		$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );

		$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );

		$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

		$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç', '-','_'),
			array('n', 'N', 'c', 'C', '', ''),
			$cadena
		);
		
		$cadena = preg_replace("/[^a-zA-Z\_\-]+/", "", $cadena);

		return $cadena;
	}
?>