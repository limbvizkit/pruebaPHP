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
	
//vamos a ver si podemos separar con Expediente y sin Expediente
$nombre_pac = NULL;
$fec_nacPac = NULL;
$hab_pac = NULL;
if($expediente != NULL || trim($expediente) != '') {
	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	$expediente_pac = trim($resultado[0][0]['NO_EXP_PAC']);
	$folio_pac = $resultado[0][0]['FOLIO_PAC'];
	$edad_pac = $resultado[0][0]['EDAD_PAC'];
   	$sexo_pac = $resultado[0][0]['SEXO_PAC'];
	$hab_pac = $resultado[0][0]['CVE_CUARTO'];

	if($sexo_pac == 'M'){
		$sexo_pac='MASCULINO';
	} else {
		$sexo_pac='FEMENINO';
	}

	$obligado_pac = $resultado[0][0]['OBLI_PAC'];
 	$date2 = $resultado[0][0]['NACIO_PA'];
	$fec_nacPac=$date2->format('d/m/Y');
	//Sacar Edad Precisa en años o Meses
	$hoy = new DateTime();
	$anniosO = $hoy->diff($date2);
	//$annios = $annios->y;
	$annios = $anniosO->format('%y Año(s)');
	$anniosBool = $anniosO->format('%y');
	if($anniosBool == '0') {
		$annios = $anniosO->format('%m Mes(es)');
	}
}

	$tipoEvento=NULL;
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
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		
		if (isset($_POST['servicio']))
		{
			$servicio=utf8_decode($_POST['servicio']);
			$servicio=addslashes ($servicio);
		}		
		if (isset($_POST['servicioTxt']))
		{
			$servicioTxt=utf8_decode($_POST['servicioTxt']);
			$servicioTxt=addslashes($servicioTxt);
		}
		if (isset($_POST['tipoEvento']))
		{
			$tipoEvento=utf8_decode($_POST['tipoEvento']);
			$tipoEvento = addslashes($tipoEvento);
		}		
		if (isset($_POST['habitacion']))
		{
			$habitacion=utf8_decode($_POST['habitacion']);
			$habitacion = addslashes($habitacion);
		}
		if (isset($_POST['paciente']))
		{
			$paciente=utf8_decode($_POST['paciente']);
			$paciente=addslashes($paciente);
		}
		if (isset($_POST['nacimientoPaciente']))
		{
			$nacimientoPaciente=utf8_decode($_POST['nacimientoPaciente']);
			$nacimientoPaciente=addslashes($nacimientoPaciente);
		}
		if (isset($_POST['fechaOcurrio']))
		{
			$fechaOcurrio=utf8_decode($_POST['fechaOcurrio']);
			$fechaOcurrio=addslashes($fechaOcurrio);
		}
		if (isset($_POST['evento']))
		{
			$evento=utf8_decode($_POST['evento']);
			$evento = addslashes($evento);
		}
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' 
		'.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsAdv = "INSERT INTO eventoAdverso(id,numeroExpediente,folio,fecha,turno,servicio,servicioTxt,tipoEvento,habitacion,paciente,nacimientoPaciente,fechaOcurrio,evento,usr)
					VALUES (NULL,'$expediente','$folio','$fecha','$turno','$servicio','$servicioTxt','$tipoEvento','$habitacion','$paciente',
					'$nacimientoPaciente','$fechaOcurrio','$evento','$rol')";
		
			$result0 = mysqli_query($conexionMedico, $queryInsAdv);
			if(!$result0) {
				echo '!<br> ERROR al insertar Evento Adverso! <br>';
				echo 'QUERY: '.$queryInsAdv;
			} else {
				echo '<br>!!!! SE GUARDO EL EVENTO ADVERSO CORRECTAMENTE!!!!<br>';
			}
	}
	/*$fcFin=NULL;
	$frFin=NULL;
	$taFin=NULL;
	$tempFin=NULL;
	$soFin=NULL;
	$glucosaFin=NULL;
	$turnoFin=NULL;
	$turnoFinLetra=NULL;
	$acudeFin=NULL;
	$antecOld=NULL;

	//Query para ver si ya tiene Anteedentes personales
	$queryAntec = "SELECT *
				  FROM notaUrg
				  WHERE numeroExpediente='$expediente' AND estatus='1'
				  ORDER BY fecha DESC
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		$antecOld= utf8_encode($rowA['antecedentes']);
		$antecOld=addslashes ($antecOld);
	}*/
	$fechaActual=date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EVENTO ADVERSO</title>

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
			<?php if($expediente != NULL || trim($expediente) != '') { ?>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th style="text-align: center">DATOS DEL PACIENTE</th>
					</tr>
					</thead>
			</table>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th>EXPEDIENTE</th>
						<th>FOLIO</th>
						<th>NOMBRE</th>
						<th>FECHA NACIMIENTO</th>
						<th>EDAD</th>
						<th>SEXO</th>
						<th>PROCEDE</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $expediente_pac ?></td>
							<td><?php echo $folio_pac ?></td>
							<td><?php echo utf8_encode($nombre_pac) ?></td>
							<td><?php echo $fec_nacPac  ?></td>
							<td><?php echo $annios  ?></td>
							<td><?php echo $sexo_pac ?></td>
							<td><?php echo $obligado_pac ?></td>
						</tr>
					</tbody>
				</table>
			<br>			
			<br>
			<?php } ?>
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

                    		<h3>NOTIFICACIÓN DE EVENTO ADVERSO</h3>
                    		<p></p>
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.5" data-number-of-steps="4" style="width: 12.5%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>BÁSICOS</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-random" aria-hidden="true"></i></div>
                    				<p>DESCRIPCIÓN DEL EVENTO ADVERSO</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<!--div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-frown-o" aria-hidden="true"></i></div>
                    				<p>ERROR DE MEDICACIÓN</p>
                    			</div-->
								<!-- Step 3 -->
                    		</div>
							<!-- Form progress -->
                    		
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<h4>
									La intención de este formulario es recopilar información de las <strong>CUASIFALLAS, EVENTOS ADVERSOS y EVENTOS CENTINELA</strong> de nuestro hospital.
									<br/>
									<br/>
									La notificación es <strong>ANÓNIMA Y NO PUNITIVA.</strong>
								</h4>
								<!-- Progress Bar -->
								<div class="form-group">
									<label>FECHA EN QUE REALIZA EL REPORTE : <span>*</span></label>
									<input type="date" name="fecha" value="<?php echo $fechaActual ?>" class="form-control required" >
								</div>
								<div class="form-group">
									<label>TURNO DONDE OCURRIÓ EL INCIDENTE : <span>*</span></label>
								   <select id="turno" name="turno" class="form-control">
										<option value="">Seleccionar</option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="NA">Nocturno A</option>
									    <option value="NB">Nocturno B</option>
									    <option value="JA">Jornada Acumulada</option>
									</select>
								</div>
								<!--div class="form-group">
                    			    <label>PERSONAL QUE REPORTA : <span>*</span></label>
                                   <input type="text" placeholder="Nombre o Puesto" name="reporta" class="form-control required" autocomplete="off">
                                </div-->
								<div class="form-group">
                    			    <label>SERVICIO DONDE OCURRIO EL INCIDENTE : <span>*</span></label>
									<br/>                                   <label class="radio-inline">
									  <input type="radio" name="servicio" value="Hospitalización" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; Hospitalización
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Consulta externa" style="width: 30px; height: 30px">&nbsp;&nbsp; Consulta externa
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Urgencias" style="width: 30px; height: 30px">&nbsp;&nbsp; Urgencias
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Quirófano"  style="width: 30px; height: 30px">&nbsp;&nbsp; Quirófano
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Farmacia" style="width: 30px; height: 30px">&nbsp;&nbsp; Farmacia
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Nutrición" style="width: 30px; height: 30px">&nbsp;&nbsp; Nutrición
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Laboratorio" style="width: 30px; height: 30px">&nbsp;&nbsp; Laboratorio
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Imagenología" style="width: 30px; height: 30px">&nbsp;&nbsp; Imagenología
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Litotricia" style="width: 30px; height: 30px">&nbsp;&nbsp; Litotricia
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Endoscopia" style="width: 30px; height: 30px">&nbsp;&nbsp; Endoscopia
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Otro" id="ot" value="OTRO" onClick="mostrarOt()" style="width: 30px; height: 30px">&nbsp;&nbsp; OTRO
									</label>
									<p><strong><br></strong></p>
									<div id="otro" style="display:none">
										<div class="form-group" style="height: 100px">
											<input type="text" placeholder="Nombre del Servicio" name="servicioTxt" id="otros" class="form-control" autocomplete="off">
											<!--textarea class="form-control" name="otros" id="otros" cols="10" rows="3"></textarea-->
										</div>
									</div>
                                </div>
								 <!--div class="form-group">
                    			    <label>DIAGNÓSTICO DEL PACIENTE : <span></span></label>
									<textarea class="form-control" name="diag" id="diag" cols="10" rows="3"></textarea>
                                </div-->
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
                                <h3>DESCRIPCIÓN DEL EVENTO ADVERSO : <span>Paso 2 - 2</span></h3>
								<h4>
									Tipos de Eventos adversos<br />
									<strong>-->	EVENTO CENTINELA:</strong> Es un incidente que alcanza al paciente causándole la muerte o un daño irreparable.
									<br />
									<strong>-->	EVENTO ADVERSO:</strong> Es un incidente que alcanza al paciente, pero no le causa ningún daño irreparable ni muerte.
									<br />
									<strong>-->	CUASIFALLA:</strong> Es un incidente que no alcanza al paciente.
									<br />
								</h4>
								<div class="form-group">
                    			    <label>TIPO DE INCIDENTE QUE SE REPORTA : <span>*</span></label>
                                    <br>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Cuasifalla" style="width: 30px; height: 30px">&nbsp;&nbsp; Cuasifalla
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Evento Adverso" style="width: 30px; height: 30px">&nbsp;&nbsp;Evento Adverso
									</label>
                                    <label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Evento Centinela" style="width: 30px; height: 30px" >&nbsp;&nbsp; Evento Centinela
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="Error De Medicación" style="width: 30px; height: 30px">&nbsp;&nbsp; Error De Medicación
									</label>
									<label class="radio-inline">
									  <input type="radio" name="tipoEvento" value="RAM" style="width: 30px; height: 30px">&nbsp;&nbsp; RAM. (Reacción Adversa a Medicamentos)
									</label>
                                </div>
								<br/>
                                <div class="form-group">
                    			    <label>NÚMERO DE HABITACIÓN DONDE SE PRESENTO EL INCIDENTE : </label>
									<!--textarea class="form-control required" name="evento" id="habExt" cols="10" rows="3"></textarea-->
                                    <input type="text" name="habitacion" class="form-control" value="<?php echo $hab_pac ?>" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>NOMBRE DEL PACIENTE INVOLUCRADO EN EL INCIDENTE : </label>
									<!--textarea class="form-control required" name="como" id="cabeza" cols="10" rows="3"></textarea-->
                                    <input type="text" name="paciente" class="form-control" value="<?php echo $nombre_pac ?>" autocomplete="off">
                                </div>
								<div class="form-group">
                    			    <label>FECHA DE NACIMIENTO DEL PACIENTE INVOLUCRADO EN EL INCIDENTE : </label>
									<!--textarea class="form-control required" name="porQue" id="torax" cols="10" rows="3"></textarea-->
                                    <input type="text" name="nacimientoPaciente" class="form-control" value="<?php echo $fec_nacPac ?>" autocomplete="off">
                                </div>
								<div class="form-group">
									<label>FECHA EN LA QUE OCURRIÓ EL INCIDENTE: </label>
									<input type="date" name="fechaOcurrio" class="form-control">
								</div>
								<div class="form-group">
                    			    <label>CUÉNTENOS LO QUE HA PASADO: <span>*</span> </label>
									<textarea class="form-control required" name="evento" id="evento" cols="10" rows="3"></textarea>
                                </div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">
									<button type="button"  class="btn btn-previous">Anterior</button>
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
		<script type="text/javascript">
			function mostrar(v){
				if(v == '1'){
					document.getElementById('errorMed').style="display:block";
				} else {
					document.getElementById('errorMed').style="display:none";
				}
			}

			function mostrarOt() {
				 element = document.getElementById("otro");
				check = document.getElementById("ot");
				if (check.checked) {
					element.style.display='block';
				} else {
					element.style.display='none';
				}
			}
	</script>
    </body>

</html>