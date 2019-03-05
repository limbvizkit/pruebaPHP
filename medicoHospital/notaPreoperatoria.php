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

	$fcFin=NULL;
	$frFin=NULL;
	$taFin=NULL;
	$tempFin=NULL;
	$soFin=NULL;
	$glucosaFin=NULL;
	$habExtFin=NULL;
	$cabezaFin=NULL;
	$toraxFin=NULL;
	$abdomenFin=NULL;
	$extremidadesFin=NULL;
	$tratamientoFin=NULL;
	$diagFin=NULL;
	$nombre_pac =NULL;
	$antecedentesFin=NULL;
	$interrogatorioFin=NULL;
	$acudeFin=NULL;

	//Query para jalar los datos de la consulta medica
	$queryAntec = "SELECT *
				  FROM notaUrgchoque
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'				  
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		$antecOld= utf8_encode($rowA['antecedentes']);
		$antecedentesFin=addslashes ($antecOld);
		
		$interrogaOld= utf8_encode($rowA['interrogatorio']);
		$interrogatorioFin=addslashes ($interrogaOld);
		
		$fcFin=$rowA['fc'];
		$frFin=$rowA['fr'];
		$taFin=$rowA['ta'];
		$tempFin=$rowA['temp'];
		$soFin=$rowA['so'];
		$glucosaFin=$rowA['glucosa'];
		
		$habExtOld= utf8_encode($rowA['habExt']);
		$habExtFin=addslashes ($habExtOld);
		
		$cabezaOld= utf8_encode($rowA['cabeza']);
		$cabezaFin=addslashes ($cabezaOld);

		$toraxOld= utf8_encode($rowA['torax']);
		$toraxFin=addslashes ($toraxOld);
		
		$abdomenOld= utf8_encode($rowA['abdomen']);
		$abdomenFin=addslashes ($abdomenOld);

		$extremidadesOld= utf8_encode($rowA['extremidades']);
		$extremidadesFin=addslashes ($extremidadesOld);

		$tratamientoOld= utf8_encode($rowA['tratamientoFin']);
		$tratamientoFin=addslashes ($tratamientoOld);

		$diagOld= utf8_encode($rowA['diag']);
		$diagFin=addslashes ($diagOld);
		$acudeFin=$rowA['acude'];
		
	}
	
	if(isset($_REQUEST['enviar']))
	{
		$bhc=NULL;
		$qs=NULL;
		$tpt=NULL;
		$rx=NULL;
		$tac=NULL;
		$rm=NULL;
		$us=NULL;

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
		
		if (isset($_POST['servicio']))
		{
			$servicio=utf8_decode($_POST['servicio']);
			$servicio=addslashes($servicio);
		}
		if (isset($_POST['fecha']))
		{
			$fecha=$_POST['fecha'];
		}
		/*if (isset($_POST['hora']))
		{
			$hora=$_POST['hora'];
		}*/
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		
		if (isset($_POST['diagnostico']))
		{
			$diagnostico=utf8_decode($_POST['diagnostico']);
			$diagnostico=addslashes($diagnostico);
		}
		if (isset($_POST['planQx']))
		{
			$planQx=utf8_decode($_POST['planQx']);
			$planQx=addslashes($planQx);
		}
		if (isset($_POST['tipoIntervencionQx']))
		{
			$tipoIntervencionQx=utf8_decode($_POST['tipoIntervencionQx']);
			$tipoIntervencionQx=addslashes($tipoIntervencionQx);
		}
		
		#2		
		if (isset($_POST['riesgoQx']))
		{
			$riesgoQx=utf8_decode($_POST['riesgoQx']);
			$riesgoQx=addslashes($riesgoQx);
		}
		if (isset($_POST['cuidadosTerapeuticos']))
		{
			$cuidadosTerapeuticos=utf8_decode($_POST['cuidadosTerapeuticos']);
			$cuidadosTerapeuticos=addslashes($cuidadosTerapeuticos);
		}
		if (isset($_POST['pronosticoVida']))
		{
			$pronosticoVida=utf8_decode($_POST['pronosticoVida']);
		}
		if (isset($_POST['pronosticoFuncion']))
		{
			$pronosticoFuncion=utf8_decode($_POST['pronosticoFuncion']);
		}
		if (isset($_POST['nombreMedicoTratante']))
		{
			$nombreMedicoTratante=utf8_decode($_POST['nombreMedicoTratante']);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' '.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsPreopera = "INSERT INTO notapreoperatoria (id,numeroExpediente,folio,servicio,fecha,turno,diagnostico,planQx,tipoIntervencionQx,riesgoQx,
									cuidadosTerapeuticos,pronosticoVida,pronosticoFuncion,nombreMedicoTratante,cedula,usr)
							VALUES (NULL,'$expediente','$folio','$servicio','$fecha','$turno','$diagnostico','$planQx','$tipoIntervencionQx','$riesgoQx',
									'$cuidadosTerapeuticos','$pronosticoVida','$pronosticoFuncion','$nombreMedicoTratante','$cedula','$rol')";
		$result0 = mysqli_query($conexionMedico, $queryInsPreopera);
		if(!$result0) {
			echo '!<br> ERROR al insertar Nota Preoperatoria! <br>';
			echo 'QUERY: '.$queryInsPreopera;
		} else {
			echo '<br>!!!! SE GUARDO LA NOTA PREOPERATORIA CORRECTAMENTE !!!!<br>';
		}
		
	}
	

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NOTA PREOPERATORIA</title>

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

                    		<h3>NOTA PREOPERATORIA</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-3">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="3" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Antecedentes</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 4 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>Intervención Quirurgica y Pronóstico</p>
                    			</div>
								<!-- Step 4 -->
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
                    		    <h4>ANTECEDENTES: <span>Paso 1 - 2</span></h4>
								<div class="form-group">
                    			    <label>SERVICIO : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="servicio" value="Hospitalización" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; Hospitalización
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Urgencias" style="width: 30px; height: 30px">&nbsp;&nbsp; Urgencias
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Corta Estancia" style="width: 30px; height: 30px">&nbsp;&nbsp; Corta Estancia
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Terapia Intensiva" style="width: 30px; height: 30px">&nbsp;&nbsp; Terapia Intensiva
									</label>
                                </div>
								<div class="form-group">
									<label>FECHA DE LA CIRUGÍA : <span>*</span></label>
									<input type="date" name="fecha" class="form-control required">
								</div>
								<!--div class="form-group">
									<label>HORA DE LA CIRUGÍA : <span>*</span></label>
									<input type="time" name="hora" class="form-control required" autocomplete="off">
								</div-->
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
									<label>DIAGNOSTICO : <span>*</span></label>
									<textarea class="form-control required" name="diagnostico" id="diagnostico" cols="10" rows="3"><?php echo $diagFin ?></textarea>
								</div>
								<div class="form-group">
                    			    <label>PLAN QUIRÚRGICO : <span>*</span></label>
                                    <textarea class="form-control required" name="planQx" id="planQx" cols="10" rows="3"></textarea>
                                </div>
								
								 <div class="form-group">
                    			    <label>TIPO DE INTERVENCIÓN QUIRÚRGICA : <span>*</span></label>
									 <select id="tipoIntervencionQx required" name="tipoIntervencionQx" class="form-control required">
										<option value="">Seleccione</option>
										<option value="Electiva">Electiva</option>
										<option value="Urgente">Urgente</option>
									</select>
                                </div>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->
							<!-- Form Step 4 -->
							<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>INTERVENCIÓN QUIRURGICA Y PRONOSTICO : <span>Paso 2 - 2</span></h4>
								<div style="clear:both;"></div>
								<div class="form-group">
                    			    <label>RIESGO QUIRURGICO : </label>
                                    <textarea class="form-control" name="riesgoQx" id="riesgoQx" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>CUIDADOS Y PLAN TERAPÉUTICO PREOPERATORIOS : <span>*</span></label>
                                    <textarea class="form-control required" name="cuidadosTerapeuticos" id="cuidadosTerapeuticos" cols="10" rows="3"></textarea>
                                </div>
								<h4>PRONÓSTICO : </h4>
								<div class="form-group">
                    			    <label>VIDA : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="pronosticoVida" value="BUENO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; BUENO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoVida" value="MALO" style="width: 30px; height: 30px">&nbsp;&nbsp; MALO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoVida" value="RESERVADO" style="width: 30px; height: 30px">&nbsp;&nbsp; RESERVADO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>FUNCIÓN : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="pronosticoFuncion" value="BUENO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; BUENO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoFuncion" value="MALO" style="width: 30px; height: 30px">&nbsp;&nbsp; MALO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="pronosticoFuncion" value="RESERVADO" style="width: 30px; height: 30px">&nbsp;&nbsp; RESERVADO
									</label>
                                </div>
								<div class="form-group">
									<h4>DATOS DEL MÉDICO TRATANTE:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off" required>
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
									<button type="button"  class="btn btn-previous">Anterior</button>
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