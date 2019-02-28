<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configEpidemio.php');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}

	if(isset($_REQUEST['enviar']))
	{
		
		$verificador=NULL;
		$fechaVerif=NULL;
		$ubicacion=NULL;
		$habitacion=NULL;
		$otro=NULL;
		$catProf=NULL;
		$otroCat=NULL;
		$turno=NULL;
		$tipoHig=NULL;
		$sexo=NULL;
		$momento1=NULL;
		$momento2=NULL;
		$momento3=NULL;
		$momento4=NULL;
		$momento5=NULL;
		$alhajas=NULL;
		$sanita=NULL;
		$mojarManos=NULL;
		$frotarManos=NULL;
		$frotarDorsos=NULL;
		$frotarPalma=NULL;
		$doblarDedos=NULL;
		$frotarPulgares=NULL;
		$frotarPuntas=NULL;
		$enjuagar=NULL;
		$secarManos=NULL;
		$cerrarLlave=NULL;
		$llevaGuantes=NULL;
		$observaciones=NULL;
		
		if (isset($_POST['verificador']))
		{
			$verificador=utf8_decode($_POST['verificador']);
		}
		if (isset($_POST['fechaVerif']))
		{
			$fechaVerif=$_POST['fechaVerif'];
		}		
		/*Extras del listado de hubicacion*/
		if (isset($_POST['ubicacion']))
		{
			$ubicacion=$_POST['ubicacion'];
		}
		if (isset($_POST['habitacion']))
		{
			$habitacion=$_POST['habitacion'];
		}
		if (isset($_POST['otro']))
		{
			$otro=utf8_decode($_POST['otro']);
		}
		/**************************************/
		/*Extras del listado de profesionista*/
		if (isset($_POST['catProf']))
		{
			$catProf=$_POST['catProf'];
		}
		if (isset($_POST['otroCat']))
		{
			$otroCat=utf8_decode($_POST['otroCat']);
		}
		/************************************/
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['tipoHig']))
		{
			$tipoHig=$_POST['tipoHig'];
		}		
		if (isset($_POST['sexo']))
		{
			$sexo=$_POST['sexo'];
		}		
		if (isset($_POST['momento1']))
		{
			$momento1=$_POST['momento1'];
		}
		if (isset($_POST['momento2']))
		{
			$momento2=$_POST['momento2'];
		}
		if (isset($_POST['momento3']))
		{
			$momento3=$_POST['momento3'];
		}
		if (isset($_POST['momento4']))
		{
			$momento4=$_POST['momento4'];
		}
		if (isset($_POST['momento5']))
		{
			$momento5=$_POST['momento5'];
		}		
		if (isset($_POST['alhajas']))
		{
			$alhajas=$_POST['alhajas'];
		}
		if (isset($_POST['sanita']))
		{
			$sanita=$_POST['sanita'];
		}
		if (isset($_POST['mojarManos']))
		{
			$mojarManos=$_POST['mojarManos'];
		}
		if (isset($_POST['frotarManos']))
		{
			$frotarManos=$_POST['frotarManos'];
		}
		if (isset($_POST['frotarDorsos']))
		{
			$frotarDorsos=$_POST['frotarDorsos'];
		}
		if (isset($_POST['frotarPalma']))
		{
			$frotarPalma=$_POST['frotarPalma'];
		}
		if (isset($_POST['doblarDedos']))
		{
			$doblarDedos=$_POST['doblarDedos'];
		}
		if (isset($_POST['frotarPulgares']))
		{
			$frotarPulgares=$_POST['frotarPulgares'];
		}
		if (isset($_POST['frotarPuntas']))
		{
			$frotarPuntas=$_POST['frotarPuntas'];
		}
		if (isset($_POST['enjuagar']))
		{
			$enjuagar=$_POST['enjuagar'];
		}
		if (isset($_POST['secarManos']))
		{
			$secarManos=$_POST['secarManos'];
		}
		if (isset($_POST['cerrarLlave']))
		{
			$cerrarLlave=$_POST['cerrarLlave'];
		}
		if (isset($_POST['llevaGuantes']))
		{
			$llevaGuantes=$_POST['llevaGuantes'];
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones=utf8_decode($_POST['observaciones']);
		}
		
		$queryTecHigMan = "INSERT INTO tecnicahigienemanos (id,verificador,fechaVerif,localizacion,habitacion,locOtros,catProfesional,catOtros,turno,
		tipoHigiene,sexo,antesContactoPaciente,antesTareaAseptica,despuesContactoEntorno,despuesContactoPaciente,despuesContactoFluidos,retirarAlhajas,
		prepararPapel,mojarManos,frotarPalmas,frotarDorsoPalmas,frotarPalmaPalma,frotarNudillos,frotarPulgares,frotarPuntasDedos,enjuagarConAgua,
		secarManos,cerrarLlave,llevaGuantes,observaciones,usr) VALUES (NULL, '$verificador','$fechaVerif','$ubicacion','$habitacion','$otro','$catProf',
		'$otroCat','$turno','$tipoHig','$sexo','$momento1','$momento2','$momento3','$momento4','$momento5','$alhajas','$sanita','$mojarManos',
		'$frotarManos','$frotarDorsos','$frotarPalma','$doblarDedos','$frotarPulgares','$frotarPuntas','$enjuagar','$secarManos','$cerrarLlave',
		'$llevaGuantes','$observaciones','$rol')";
			
			$result0 = mysqli_query($conexionEpidemio, $queryTecHigMan);
			if(!$result0) {
				echo '!<br> !!ERROR!! al realizar inserción de técnica Higiene de Manos! <br>';
				echo 'QUERY: '.$queryTecHigMan;
			} else {
				echo '<br>!!!! SE GUARDO TÉCNICA HIGIENE DE MANOS CORRECTAMENTE!!!!<br>';
				#echo 'QUERY: '.queryTecHigMan;
			}
		
	}

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TÉCNICA HIGIENE MANOS</title>
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
		<script type="text/javascript">
			//Mostrar recuadro si se selecc Otro o Habitacion
			function verOtro(e){
				var valr = e.ubicacion.options[e.ubicacion.selectedIndex].value;
				if( valr == "OTRO") {
					document.getElementById("divOtro").style="display:block;";
					document.getElementById("divHab").style="display:none;";
				}else if( valr == "HAB"){
					document.getElementById("divHab").style="display:block;";
					document.getElementById("divOtro").style="display:none;";
				} else {
					document.getElementById("divOtro").style="display:none;";
					document.getElementById("divHab").style="display:none;";
				}
			}
			
			function verOtroCat(e){
				var valr = e.catProf.options[e.catProf.selectedIndex].value;
				if( valr == "19") {
					document.getElementById("divOtroCat").style="display:block;";
				} else {
					document.getElementById("divOtroCat").style="display:none;";
				}
			}
						
		</script>
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
							<input name="rol" type="hidden" value="<?php echo $rol ?>" >
                    		<h3>Cédula para la verificación de técnica correcta de higiene de manos 1.0</h3>
                    		<p>UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA</p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-2">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-eye" aria-hidden="true"></i></div>
                    				<p>IDENTIFICACIÓN DE LA OBSERVACIÓN</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-medkit" aria-hidden="true"></i></div>
                    				<p>MEDIDAS DE PROTECCIÓN GENERAL</p>
                    			</div>
								<!-- Step 2 -->
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
                    		    <h4>IDENTIFICACIÓN DE LA OBSERVACIÓN : <span>Paso 1 - 2</span></h4>
								<div class="form-group">
                    			    <label>NOMBRE DEL VERIFICADOR : <span>*</span></label>
                                    <input type="text" name="verificador" placeholder="Nombre" autocomplete="off" class="form-control required">
                                </div>
								<div class="form-group">
                    			    <label>FECHA DE VERIFICACIÓN : <span>*</span></label>
                                    <input type="date" name="fechaVerif" class="form-control required">
                                </div>								
								<h4>1. Identificación de la observación</h4>
								<div class="form-group">
                    			    <label>1.1 LOCALIZACIÓN DE LA OBSERVACIÓN : </label>
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
                                   	 	<input type="number" id="habitacion" name="habitacion" placeholder="No. Habitación" autocomplete="off" min="100" max="250" class="form-control">
                                	</div>
									<div id="divOtro" class="form-group" style="display:none">
                    			    	<label>OTRO :</label>
                                   	 	<input type="text" id="otro" name="otro" placeholder="Indique Lugar" autocomplete="off" class="form-control">
                                	</div>
                                </div>	
								<div class="form-group">
                    			    <label>1.2 CATEGORÍA PROFESIONAL : </label>
                                    <select id="catProf" name="catProf" class="form-control"  onchange="verOtroCat(this.form)">
										<option value="">Seleccione</option>
										<option value="1">ENFERMERA(O)</option>
										<option value="2">REPRESENTANTE MÉDICO</option>
										<option value="3">JEFE DE SERVICIO</option>
										<option value="4">TEC. INHALOTERAPIA</option>
										<option value="5">MÉDICO GUARDIA</option>
										<option value="6">MÉDICO ESPECIALISTA</option>
										<option value="7">TEC. LABORATORISTA</option>
										<option value="8">SERV. GENERALES</option>
										<option value="9">ATENCIÓN A CLIENTES</option>
										<option value="10">TEC. URGENCIAS MÉDICAS</option>
										<option value="11">COCINA</option>
										<option value="12">COMPRAS</option>
										<option value="13">VISITANTES</option>
										<option value="14">FARMACIA</option>
										<option value="15">MANTENIMIENTO</option>
										<option value="16">PROVEDOR EXTERNO</option>
										<option value="17">ADMISIÓN</option>
										<option value="18">CAMILLERO</option>
										<option value="19">OTRO</option>
									</select>									
									<div id="divOtroCat" class="form-group" style="display:none">
                    			    	<label>OTRO :</label>
                                   	 	<input type="text" id="otroCat" name="otroCat" placeholder="Indique Categoría" class="form-control">
                                	</div>
                                </div>
								<div class="form-group">
                    			    <label>1.3 TURNO : <span>*</span></label>
									
                                   <select id="turno" name="turno" class="form-control required">
										<option value="">Seleccione</option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="N">Nocturno</option>
									</select>
								</div>
								<div class="form-group">
                    			    <label>1.4 TIPO DE HIGIENE : <span>*</span></label>									
                                   <select id="tipoHig" name="tipoHig" class="form-control required">
										<option value="">Seleccione</option>
										<option value="1">LAVADO</option>
										<option value="2">FRICCIÓN</option>
									</select>
								</div>
								<div class="form-group">
                    			    <label>1.5 SEXO : <span>*</span></label>									
                                   <select id="sexo" name="sexo" class="form-control required">
										<option value="">Seleccione</option>
										<option value="M">MASCULINO</option>
										<option value="F">FEMENINO</option>
									</select>
								</div>
								<h4>MOMENTO DE LAVADO DE MANOS</h4>
								<div class="form-group">
                    			    <label>1. ANTES DE TENER CONTACTO CON EL PACIENTE : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="momento1" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento1" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento1" value="NA"> NO APLICA
									</label>
                                </div>
                    			<div class="form-group">
                    			    <label>2. ANTES DE REALIZAR ALGUNA TAREA ASEPTICA  : </label>
									<br>
                                      <label class="radio-inline">
									  <input type="radio" name="momento2" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento2" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento2" value="NA"> NO APLICA
									</label>
                                </div>
                                <div class="form-group">
                    			    <label>3. DESPUES DE TENER CONTACTO CON EL ENTORNO DEL PACIENTE : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="momento3" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento3" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento3" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>4. DESPUES DE TENER CONTACTO CON EL PACIENTE : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="momento4" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento4" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento4" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>5. DESPUES DE TENER CONTACTO CON FLUIDOS DEL PACIENTE  : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="momento5" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento5" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="momento5" value="NA"> NO APLICA
									</label>
                                </div>
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
                                <h4>MEDIDAS DE PROTECCIÓN GENERAL : <span>Paso 2 - 2</span></h4>
								<div style="clear:both;"></div>
								<div class="form-group">
                    			    <label>2.1 Retirar alhajas : </label>
                                    <br>
                                     <label class="radio-inline">
									  <input type="radio" name="alhajas" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="alhajas" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="alhajas" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2.2 Preparar el papel o sanita :</label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="sanita" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sanita" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="sanita" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>2.3 Mojar las manos y aplicar jabón o aplicar alcohol gel : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="mojarManos" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="mojarManos" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="mojarManos" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>2.4 Frotar las palmas en froma circular : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="frotarManos" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarManos" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarManos" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2.5 Frotar los dorsos de las palmas entrelanzando los dedos : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="frotarDorsos" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarDorsos" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarDorsos" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2.6 Frotar palma contra palma entrelanzando los dedos : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="frotarPalma" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarPalma" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarPalma" value="NA"> NO APLICA
									</label>								
                                </div>
								<div class="form-group">
                    			    <label>2.7 Doblar los dedos de ambas manos y frotar los nudillos con la manos contralateral : </label>
                                    <label class="radio-inline">
									  <input type="radio" name="doblarDedos" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="doblarDedos" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="doblarDedos" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2.8 Frotar pulgares con movimientos circulares : </label>
									<br>
                                    <label class="radio-inline">
									  <input type="radio" name="frotarPulgares" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarPulgares" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarPulgares" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>2.9 Frotar las puntas de los dedos contra la mano contraria : </label>
									<br/>
                                    <label class="radio-inline">
									  <input type="radio" name="frotarPuntas" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarPuntas" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="frotarPuntas" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">									
                    			    <label>2.10 Enjuagar con agua corriente : </label>
									<br>
                                     <label class="radio-inline">
									  <input type="radio" name="enjuagar" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="enjuagar" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="enjuagar" value="NA"> NO APLICA
									</label>									
                                </div>
								<div class="form-group">
                    			    <label>2.11 Secar manos con sanita o papel desechable desde la punta de la manos haceia la muñeca : </label>
									<br>
                                     <label class="radio-inline">
									  <input type="radio" name="secarManos" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="secarManos" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="secarManos" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2.12 Cerrar la llave con la sanita : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="cerrarLlave" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cerrarLlave" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="cerrarLlave" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>2.13 Llevaba guantes se omitio la higiene de manos : </label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="llevaGuantes" value="1" checked="checked"> CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="llevaGuantes" value="0"> NO CUMPLE
									</label>
									<label class="radio-inline">
									  <input type="radio" name="llevaGuantes" value="NA"> NO APLICA
									</label>
                                </div>
								<div class="form-group">
                    			    <label>OBSERVACIONES : </label>
                                    <br>
                                    <label class="radio-inline">
										<textarea class="form-control" id="observaciones" name="observaciones" rows="3" cols="50"></textarea>	  
									</label>
                                </div>
								<!--div class="container-fluid">
								<div class="row form-inline">
								<div class="form-group col-md-6 col-xs-6">
									<label>Card Number: <span>*</span></label>
                                    <input type="text" name="Card Number" placeholder="Card Number" class="form-control required">
								</div>
								<div class="form-group col-md-6 col-xs-6">
									<label>CVC: <span>*</span></label>
                                    <input type="text" name="CVC" placeholder="CVC" class="form-control required">
								</div>
                                </div>
								</div>
								<br/-->
								<!--div class="container-fluid">
								<div class="row form-inline">
								<div class="form-group col-md-3 col-xs-3">
									<label>Expiry Date: </label>
								</div>
								<div class="form-group col-md-3 col-xs-3">
									<label>Month: </label>
                                    <select class="form-control">
									  <option>Jan</option>
									  <option>Feb</option>
									  <option>Mar</option>
									  <option>Apr</option>
									  <option>May</option>
									</select>
								</div>
								<div class="form-group col-md-3 col-xs-3">
									<label>Year: </label>
                                    <select class="form-control">
									  <option>2017</option>
									  <option>2018</option>
									  <option>2019</option>
									  <option>2020</option>
									  <option>2021</option>
									</select>
								</div>
                                </div>
								</div-->
								<br/>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
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