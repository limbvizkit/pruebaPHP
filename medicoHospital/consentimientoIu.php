<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configMedico.php');
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
		if (isset($_POST['fecha']))
		{
			$fecha=$_POST['fecha'];
		}
		
		/*if (isset($_POST['diagnostico']))
		{
			$diagnostico=utf8_decode($_POST['diagnostico']);
			$diagnostico=addslashes($diagnostico);
		}
		if (isset($_POST['procedimientos']))
		{
			$procedimientos=utf8_decode($_POST['procedimientos']);
			$procedimientos=addslashes($procedimientos);
		}
		if (isset($_POST['riesgos']))
		{
			$riesgos=utf8_decode($_POST['riesgos']);
			$riesgos=addslashes($riesgos);
		}
		if (isset($_POST['beneficios']))
		{
			$beneficios=utf8_decode($_POST['beneficios']);
			$beneficios=addslashes($beneficios);
		}
		if (isset($_POST['alternativas']))
		{
			$alternativas=utf8_decode($_POST['alternativas']);
			$alternativas=addslashes($alternativas);
		}*/
		if (isset($_POST['nombreMedicoTratante']))
		{
			$nombreMedicoTratante=utf8_decode($_POST['nombreMedicoTratante']);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		
		$queryInsConsenIh = "INSERT INTO consentimientoiuurg (id,numeroExpediente,folio,fechaIu,nombreMedicoTratante,cedula,usr)
							VALUES (NULL,'$expediente','$folio','$fecha','$nombreMedicoTratante','$cedula','$rol')";
		$result0 = mysqli_query($conexionMedico, $queryInsConsenIh);
		if(!$result0) {
			echo '!<br> ERROR al insertar Consentimiento Ingreso Hospital! <br>';
			echo 'QUERY: '.$queryInsConsenIh;
		} else {
			echo '<br>!!!! SE GUARDO EL CONSENTIMIENTO INGRESO A URGENCIAS CORRECTAMENTE !!!!<br>';
		}
		
	}
	

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CONSENTIMIENTO INFORMADO PARA INGRESO A URGENCIAS</title>

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

                    		<h3>CONSENTIMIENTO INFORMADO PARA INGRESO A URGENCIAS</h3>
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
								<div class="form-group">
									<label>FECHA : <span>*</span></label>
									<input type="date" name="fecha" class="form-control required">
								</div>
								<!--div class="form-group">
                    			   <label>TURNO : <span>*</span></label>
                                   <select id="turno" name="turno" class="form-control required">
										<option value="">Seleccione</option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="N">Nocturno</option>
									</select>
								</div-->
								<!--div class="form-group">
									<label>DIAGNOSTICO : <span>*</span></label>
									<textarea class="form-control required" name="diagnostico" id="diagnostico" cols="10" rows="3"><?php //echo $diagFin ?></textarea>
								</div>
								<div class="form-group">
                    			    <label>PROCEDIMIENTOS PLANIFICADOS: </label>
                                    <textarea class="form-control" name="procedimientos" id="procedimientos" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>RIESGOS ADICIONALES DEL TRATAMIENTO: </label>
                                    <textarea class="form-control" name="riesgos" id="riesgos" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>BENEFICIOS DEL TRATAMIENTO: </label>
                                    <textarea class="form-control" name="beneficios" id="beneficios" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>POSIBLES ALTERNATIVAS DE TRATAMIENTO: </label>
                                    <textarea class="form-control" name="alternativas" id="alternativas" cols="10" rows="3"></textarea>
                                </div-->
                               	<div class="form-group">
									<h4>DATOS DEL MÉDICO TRATANTE:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off">
									<br>
									<div id="suggestions1"></div>
								</div>
								<h6>*Si no conoce la cedula del medico tratante colocar el nombre, si ya colocó una cedula no llenar</h6>
								<div class="form-group">
                    			    <label>NOMBRE DEL MEDICO TRATANTE : </label>
                                    <input class="form-control " type="text"  name="nombreMedicoTratante" id="nombreMedicoTratante">
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
		<script type="text/javascript">
		//Funcion para autocomplementar los Medicos
		var id1 = "";
		  $(document).ready(function(e) {
			$('#cedula').bind('input keyup', function(){
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
							id1 = $(this).attr('id1'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medico
							var especialidad = $(this).attr('especialidad');
							var ced = $(this).attr('ced');
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							valor = valor.trim();
							$('#cedula').val(ced);
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
	</script>
		</script>
		
		<!-- Plugin Custom JS -->
        <script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script>
        <!-- Plugin Custom JS -->

    </body>

</html>