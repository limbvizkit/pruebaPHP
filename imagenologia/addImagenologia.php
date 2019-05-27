<?php
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
	if (isset($_GET['estudio']))
	{
		$estudio=$_GET['estudio'];
		$estudio = urldecode($estudio);
	} else {
		$estudio=NULL;
	}
	if (isset($_GET['id']))
	{
		$id=$_GET['id'];
	} else {
		$id=NULL;
	}

	
	$diagFin=NULL;
	$antecedentesFin=NULL;
	$interrogatorioFin=NULL;

	//Query para jalar los datos de la nota de urgencias
	$queryAntec = "SELECT *
				  FROM imagenologia
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND id='$id' AND estatus='1'
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		$cedulaMedSol = $rowA['cedula'];
		$nombreMedSol = utf8_encode($rowA['nombreMedicoTratante']);
		/*$antecOld= utf8_encode($rowA['antecedentes']);
		$antecedentesFin=addslashes ($antecOld);*/
	}

	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	$expediente_pac = trim($resultado[0][0]['NO_EXP_PAC']);
	$folio_pac = $resultado[0][0]['FOLIO_PAC'];
	$edad_pac = $resultado[0][0]['EDAD_PAC'];
   	$sexo_pac = $resultado[0][0]['SEXO_PAC'];
	if($sexo_pac == 'M'){
		$sexo_pac='MASCULINO';
	} else {
		$sexo_pac='FEMENINO';
	}
	//$medico_pac = $resultado[0][0]['DESC_MEDICO'];
 	$date2 = $resultado[0][0]['NACIO_PA'];	
	//Sacar Edad Precisa en años o Meses
	$hoy = new DateTime();
	$anniosO = $hoy->diff($date2);
	//$annios = $annios->y;
	$annios = $anniosO->format('%y Año(s)');
	$anniosBool = $anniosO->format('%y');
	if($anniosBool == '0'){
		$annios = $anniosO->format('%m Mes(es)');
	}

	//Datos para medico segun la Cedula Colocada
	$resultadoMed[] = $usuario1->medicosCed($cedulaMedSol);
	$medico_pac = $resultadoMed[0][0]['DESC_MEDICO'];
	$especialidad_med = $resultadoMed[0][0]['DESC_ESPEC'];

	
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
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
		}
		if (isset($_POST['cedulaSolicitante']))
		{
			$cedulaSolicitante=$_POST['cedulaSolicitante'];
		}
		
		if (isset($_POST['servicio']))
		{
			$servicio=utf8_decode($_POST['servicio']);
			$servicio=addslashes($servicio);
		}
		
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['estudio']))
		{
			$estudio = utf8_decode($_POST['estudio']);
			
			if(substr($estudio,0,-1) == '0'){
				$estudio_1 = str_replace("0","1",$estudio);
			} else {
				$estudio_1 = str_replace("2","1",$estudio);
			}
			
			$estudio_2 = substr($estudio,0,-2);
		}
		if (isset($_POST['interpretacion']))
		{
			$interpretacion=utf8_decode($_POST['interpretacion']);
			$interpretacion=addslashes($interpretacion);
		}
		if (isset($_POST['impresionDiagnostica']))
		{
			$impresionDiagnostica=utf8_decode($_POST['impresionDiagnostica']);
			$impresionDiagnostica=addslashes($impresionDiagnostica);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		if (isset($_POST['nombreMedSol']))
		{
			$nombreMedSol=utf8_decode($_POST['nombreMedSol']);
			$nombreMedSol=addslashes($nombreMedSol);
		}
		/*var_dump(utf8_encode($estudio));
		var_dump($estudio_1);
		var_dump($estudio_2);*/
		$prueba = eliminar_tildes(utf8_encode($estudio));
		//var_dump($prueba);
		$prueba = lcfirst($prueba);
		//var_dump($prueba);
		//echo $prueba;

		$queryUpdIndicMed = "UPDATE imagenologia SET $prueba='$estudio_1' WHERE id='$id'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdIndicMed) or die (mysqli_error($conexionMedico));
		
		if(!$result0){
			echo '!<br> ERROR al ACTUALIZAR DATO DE IMAGENOLOGÍA <br>';
			echo $queryUpdIndicMed;
		} else {
			//Insertamos en la tabla de imagen el nombre del estudio(id) y si existe txt complementario
			$queryInsImagen = "INSERT INTO interpretacionesimagen (id,idImagenologia,numeroExpediente,folio,turno,estudio,interpretacion,impresionDiagnostica,nombreSolicitante,cedulaSolicitante,cedulaInterprete,usr)
								VALUES (NULL,'$id','$expediente','$folio','$turno','$estudio_2','$interpretacion','$impresionDiagnostica','$nombreMedSol','$cedulaSolicitante','$cedula','$rol')";
			$result0 = mysqli_query($conexionMedico, $queryInsImagen);
			if(!$result0) {
				echo '!<br> ERROR al insertar INTERPRETACIÓN DE IMAGENOLOGÍA <br>';
				echo 'QUERY: '.$queryInsImagen;
			} else {
				echo '<br>!!!! SE GUARDO LA INTERPRETACIÓN DE IMAGENOLOGÍA CORRECTAMENTE !!!!<br>';
			}
		}
	}
	

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ADD-IMAGENOLOGÍA</title>

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
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th style="text-align: center">DATOS PACIENTE</th>
					</tr>
					</thead>
			</table>
			<table style="width:80%" border="2px solid black" align="center" background="../img/logoNew.jpg">
				<thead>
					<tr>
						<th>EXPEDIENTE</th>
						<th>FOLIO</th>
						<th>NOMBRE</th>
						<th>EDAD</th>
						<th>SEXO</th>
						<th>MEDICO SOLICITANTE</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $expediente ?></td>
							<td><?php echo $folio ?></td>
							<td><?php echo utf8_encode($nombre_pac) ?></td>
							<td><?php echo $annios ?></td>
							<td><?php echo $sexo_pac ?></td>
							<td><?php echo $medico_pac ?></td>
						</tr>
					</tbody>
				</table>
			<br>
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-5 col-lg-12 col-lg-offset-15 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
						<?php 
							$prueba = eliminar_tildes('Hígado, Vesícula y Páncreas_0');
							$prueba = lcfirst($prueba);
							echo $prueba;
						?>
                    	<form role="form" action="" method="post">

                    		<h3>INTERPRETACIÓN DE IMAGENOLOGÍA</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 100%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>INTERPRETACIÓN</p>
                    			</div>
								<!-- Step 1 -->
								
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
                    			   <label>TURNO : <span>*</span></label>
                                   <select id="turno" name="turno" class="form-control required">
										<option value="">Seleccione</option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="N">Nocturno</option>
									</select>
								</div>
								
								<div class="form-group">
                    			    <label>DATOS DE LA INTERPRETACIÓN: <span>*</span></label>
                                    <textarea class="form-control required" name="interpretacion" id="interpretacion" cols="50" rows="50"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>IMPRESIÓN DIAGNOSTICA: <span>*</span></label>
                                    <textarea class="form-control required" name="impresionDiagnostica" id="impresionDiagnostica" cols="50" rows="50"></textarea>
                                </div>
								<div class="form-group">
									<h4>DATOS DEL MÉDICO QUE INTERPRETA:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off" required>
									<br>
									<div id="suggestions1"></div>
								</div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>">								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>">
								<input name="folio" type="hidden" value="<?php echo $folio ?>">
								<input name="id" type="hidden" value="<?php echo $id ?>">
								<input name="cedulaSolicitante" type="hidden" value="<?php echo $cedulaMedSol ?>">
								<input name="estudio" type="hidden" value="<?php echo $estudio ?>">
								<input name="nombreMedSol" type="hidden" value="<?php echo $nombreMedSol ?>">
								
                                <div class="form-wizard-buttons">
                                    <button id="add_button" type="submit" name="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->
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