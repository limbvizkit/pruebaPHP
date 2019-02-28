<?php
	require_once "classes/pdf_to_image.php";
	require_once('../conexion/configLogin.php');
	
	$nombreArchivo = NULL;
 	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: ../index.html");
	}
	$valor = $_SESSION[$rol];
	
	$pdf2image = new pdf2image();
	
	$formatos=array('.pdf','.doc','.docx','.xls','.xlsx','.jpg','.png');
	$directorio='output';
	$contArchivos=0;
	
	if (isset($_POST['subir'])) {
		$arrArreas=NULL;
		
		$nombreArchivo0=$_FILES['archivo']['name'];
		$nombreArchivo=mt_rand(1, 100).'_'.$nombreArchivo0;
		$nombreTmpArchivo=$_FILES['archivo']['tmp_name'];
		#echo "<br> NOMBRE_ARCH_ANTS: ".$nombreArchivo;
		#Le quitamos caracteres extraños al nombre del archivo
		$nombreArchivo = $pdf2image->scanear_string(utf8_decode($nombreArchivo));
		#echo "<br> NOMBRE_ARCH_DESP: ".$nombreArchivo;
		#Sacamos el substring de la extension
		$ext=substr($nombreArchivo, strrpos($nombreArchivo, '.'));
		#Verificamos que el archivo q se intenta subir tiene extension valida
		if (in_array($ext, $formatos)) {
			if (move_uploaded_file($nombreTmpArchivo, "output/$nombreArchivo")) {
				
				if(isset ($_POST['areas'])){
					$areas= $_POST['areas'];
				} else {
					$areas= NULL;
				}
				if (isset($_POST['serie']))
				{
					$serie=$_POST['serie'];
				}else {
					$serie= NULL;
				}
				if (isset($_POST['subSerie']))
				{
					$subSerie=$_POST['subSerie'];
				}else {
					$subSerie= NULL;
				}
				if (isset($_POST['nombreDoc']))
				{
					$nombreDoc=utf8_decode($_POST['nombreDoc']);
				}else {
					$nombreDoc= NULL;
				}
				if (isset($_POST['tipoDocsInt']))
				{
					$tipoDocsInt=utf8_decode($_POST['tipoDocsInt']);
				}else {
					$tipoDocsInt= NULL;
				}
				
				if (isset($_POST['caracterDocs']))
				{
					$caracterDocs=utf8_decode($_POST['caracterDocs']);
				}else {
					$caracterDocs= NULL;
				}
				if (isset($_POST['ao']))
				{
					$ao=$_POST['ao'];
				}else {
					$ao= NULL;
				}
				if (isset($_POST['at']))
				{
					$at=$_POST['at'];
				}else {
					$at= NULL;
				}
				if (isset($_POST['ac']))
				{
					$ac=$_POST['ac'];
				}else {
					$ac= NULL;
				}
				if (isset($_POST['t']))
				{
					$t=$_POST['t'];
				}else {
					$t= NULL;
				}
				if (isset($_POST['l']))
				{
					$l=$_POST['l'];
				}else {
					$l= NULL;
				}
				if (isset($_POST['f']))
				{
					$f=$_POST['f'];
				}else {
					$f= NULL;
				}
				if (isset($_POST['c']))
				{
					$c=$_POST['c'];
				}else {
					$c= NULL;
				}
				if (isset($_POST['a']))
				{
					$a=$_POST['a'];
				}else {
					$a= NULL;
				}
				if (isset($_POST['dispDoc']))
				{
					$dispDoc=utf8_decode($_POST['dispDoc']);
				}else {
					$dispDoc= NULL;
				}
				if (isset($_POST['r']))
				{
					$r=$_POST['r'];
				}else {
					$r= NULL;
				}
				if (isset($_POST['c1']))
				{
					$c1=$_POST['c1'];
				}else {
					$c1= NULL;
				}
				if (isset($_POST['plazo']))
				{
					$plazo=$_POST['plazo'];
				}else {
					$plazo= NULL;
				}
				if (isset($_POST['permisos']))
				{
					$permisos = $_POST['permisos'];
					if($permisos == 'permisosTodas'){
						$permisos = '0';
					} else if($permisos == 'permisosArea') {
						$permisos = $areas;
					} else {
						$permisos= NULL;
					}
					#Permiso tiene un valor lo asignamos a la variable final
					if($permisos != NULL && $permisos != '')
					{
						$permisosFin = $permisos;
					}
				} else {
					$permisos= NULL;
				}
				if (isset($_POST['permisosAreas']))
				{
					if($_POST['permisosAreas'] != NULL && $_POST['permisosAreas'] != '')
					{
						$permisosAreas = $_POST['permisosAreas'];
						$arrArreas = implode("," , $permisosAreas);
						#Si llega 
						$permisosFin = $arrArreas;
					}
				}else {
					$permisosAreas = NULL;
				}
								
				echo ' !!! LLEGO !!!<br>
				Permisos: '.$permisos.'<br>
				Permisos Areas: '.$arrArreas.'<br>';
				
				$queryAddArchivo = "INSERT INTO datosdocumentos (idDocumento, areaDepto, serie, subSerie, tipoDocsIntegran, nombreDocumento, caracterDoc, ao, at, ac, t, l, f, c, a, disposicionDoc, r, c1, plazo, rutaArchivo, estatus, fechaAlta, permisos) 
					VALUES (NULL, '$areas', '$serie', '$subSerie', '$tipoDocsInt', '$nombreDoc', '$caracterDocs','$ao', '$at', '$ac', '$t', '$l', '$f', '$c', '$a', '$dispDoc', '$r', '$c1', '$plazo', 'output/$nombreArchivo', '1',NULL, '$permisosFin')";
				$result0 = mysqli_query($conexion, $queryAddArchivo);
					
				if(!$result0){
					echo'<span class="auto-style1">!!! ERROR AL REALIZAR INSERCIÓN DEL DOCUMENTO!!!</span>';
					echo '<br/>Query Add: '.$queryAddArchivo;
					exit;
				} else {
					echo '<br/><span class="auto-style3"><strong>!!!! SE GUARDO EL DOCUMENTO CORRECTAMENTE !!!!</strong></span><br>';
					echo '<br/>Query Add: '.$queryAddArchivo;
				}
			}else{
				echo "!!! ERROR AL SUBIR EL DOCUMENTO A LA CARPETA OUTPUT/BD FAVOR DE VERIFICAR CON SISTEMAS !!!";
			}
		}else{
			echo '<span class="auto-style1">!!!ERROR!!! FORMATO DE ARCHIVO NO VALIDO SOLO SE ADMITE: pdf, doc, docx, xls y xlsx </span>';
		}
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="../css/bootstrap.min.css" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script type="text/jscript" src="../js/bootstrap.min.js" crossorigin="anonymous"></script>
        <link rel=stylesheet href="../css/stylo.css" type="text/css">
        <style type="text/css">
            .styleBD {
                background-image: url('../img/1280x768-A.JPG');
            }
            .auto-style2 {
                font-size: x-large;
            }
            .auto-style3 {
				font-weight: bold;
				font-size: medium;
			}
        </style>
    	<title>Carga de Archivos</title>
	</head>
    <body class="styleBD">
        <center>
            <div class="h">
                <div class="head">
                    <h1>IDENTIFICACIÓN DEL DOCUMENTO</h1>
                    <form action="" method="post" enctype="multipart/form-data">
                        <h1 class="auto-style2">CARGAR ARCHIVO <br> (pdf, doc, docx, xls, xlsx, imagenes*)
                        </h1>
                        <input type="file" class="btn-default btn-block" name="archivo" required>
                        <input type="hidden" name="rol" value="<?php echo $rol ?>">
                        <br>
                        <strong><span>Área o Sección:</span></strong>
                        <select id="areas" name="areas" style="width:380px; height:40px" required>
					        <option value="">Seleccione:</option>
					        <option value="15"> ADMISIÓN </option>
					        <option value="10"> ALMACEN </option>
					        <option value="27"> BANCO DE SANGRE </option>
					        <option value="2"> BIOESTADÍSTICA Y CALIDAD </option>
					        <option value="16"> CAFETERÍA Y NUTRICIÓN </option>
					        <option value="32"> CAJA </option>
					        <option value="6"> COBRANZA </option>
					        <option value="12"> COMPRAS </option>
					        <option value="9"> CONTABILIDAD </option>
					        <option value="13"> CONTROL INTERNO </option>
					        <option value="14"> COORDINACIÓN MEDICA </option>
					        <option value="26"> CUNEROS </option>
					        <option value="24"> DIRECCIÓN FINANCIERA </option>
							<option value="25"> DIRECCIÓN GENERAL </option>
					        <option value="17"> ENFERMERÍA </option>
							<option value="18"> EPIDEMIOLOGÍA </option>
							<option value="3"> FARMACIA </option>
							<option value="4"> FARMACIA CLÍNICA </option>
							<option value="28"> IMAGENOLOGÍA </option>
							<option value="34"> INHALOTERAPIA </option>
							<option value="11"> INVESTIGACIÓN </option>
							<option value="19"> LABORATORIO </option>
							<option value="29"> LITOTRICIA </option>
							<option value="5"> MANTENIMIENTO </option>
							<option value="20"> MARKETING </option>
							<option value="30"> QUIROFANO </option>
							<option value="31"> RAYOS X </option>
							<option value="7"> RECURSOS HUMANOS </option>
							<option value="21"> SERVICIOS GENERALES </option>
							<option value="1"> TECNOLOGIA DE LA INFORMACIÓN </option>							
							<option value="22"> TERAPIA INTENSIVA </option>
							<option value="33"> UCIPyN </option>
							<option value="23"> ULTRASONIDO </option>
							<option value="34"> URGENCIAS </option>
							<option value="33"> VIEOENDOSCOPIA </option>
						</select>
                        <br>
                        <br>
                        <strong><span>Serie Documental:</span></strong><br>
                        <input type="text" name="serie" style="width: 160px" >
                        <br>
                        <br>
                        <strong><span>Subserie Documental:</span></strong><br>
                        <input type="text" name="subSerie" style="width: 160px" >
                        <br>
                        <br>
                        <strong><span>Nombre del Documento:</span></strong><br>
                        <input type="text" name="nombreDoc" style="width: 360px" required>
                        <br>
                        <br>
                        <strong><span>Tipos de Documentos que la Integran:</span></strong><br>
                        <textarea name="tipoDocsInt" cols="50" rows="2"></textarea>
                        <br>
                        <br>
                        <strong><span>Carácter de los Documentos:</span></strong><br>
                        <input type="text" name="caracterDocs" style="width: 160px" required>
                        <br>
                        <br>
                        <strong><span>Vigencia:</span></strong><br>
                        <span> AO(Archivo de Operación):</span>
                        <input type="number" name="ao" style="width: 40px; font-size:medium" class="auto-style3" >
                        <span>&nbsp;AT(Archivo de Tramite):</span>
                        <input type="number" name="at" style="width: 40px" class="auto-style3" >
                        <span>&nbsp;AC(Archivo de Concentración):</span>
                        <input type="number" name="ac" style="width: 40px" class="auto-style3" >
                        <span>&nbsp; T(Total):</span>
                        <input type="number" name="t" style="width: 50px" class="auto-style3" > 
                        <span>
                        <strong>&nbsp;<br><br>Valor Documental:
                        <br></strong>
                        L(Valor Legal):</span>
                        <input type="checkbox" name="l" style="width: 20px; height: 20px;" value="1" class="auto-style3" >
                        <span>&nbsp;F(Valor Fiscal):</span>
                        <input type="checkbox" name="f" style="width: 20px; height: 20px;" value="1" class="auto-style3" >
                        <span>&nbsp;C(Contable):</span>
                        <input type="checkbox" name="c" style="width: 20px; height: 20px;" value="1" class="auto-style3" >
                        <span>&nbsp;A(Valor Administrativo):</span>
                        <input type="checkbox" name="a" style="width: 20px; height: 20px;" value="1" class="auto-style3" >
                        <br>
                        <br>
                        <strong><span>Disposición Documental:</span></strong><br>
                        <textarea name="dispDoc" cols="50" rows="2"></textarea>
                        <br>
                        <br>
                        <strong><span>Consulta y Plazo de Reserva:</span></strong><br>
                        <span>R(Periodo de Reserva):</span>
                        <input type="text" name="r" style="width: 40px" class="auto-style3" >
                         <span>&nbsp; C(Información Confidencial):</span>
                        <input type="checkbox" name="c1" style="width: 20px; height: 20px;" value="1" class="auto-style3" >
                         <span>&nbsp; Plazo:</span>
                        <input type="text" name="plazo" style="width: 30px" class="auto-style3" >
                        <br>
						<br>
						<span>&nbsp; <strong>Permisos para este Documento:<br></strong>
						Todas las Areas:</span>
                        <input type="radio" name="permisos" value="permisosTodas" style="width: 36px; height: 26px;" >
                        Area Principal:                         
                        <input type="radio" name="permisos" value="permisosArea" style="width: 36px; height: 26px;" ><br>
                        <br>
                        Areas Seleccionadas:
                         <select id="permisosAreas" name="permisosAreas[]" multiple="multiple" style="width:380px; height:209px">					   
					        <option value="15"> ADMISIÓN </option>
					        <option value="10"> ALMACEN </option>
					        <option value="27"> BANCO DE SANGRE </option>
					        <option value="2"> BIOESTADÍSTICA Y CALIDAD </option>
					        <option value="16"> CAFETERÍA Y NUTRICIÓN </option>
					        <option value="32"> CAJA </option>
					        <option value="6"> COBRANZA </option>
					        <option value="12"> COMPRAS </option>
					        <option value="9"> CONTABILIDAD </option>
					        <option value="13"> CONTROL INTERNO </option>
					        <option value="14"> COORDINACIÓN MEDICA </option>
					        <option value="26"> CUNEROS </option>
					        <option value="24"> DIRECCIÓN FINANCIERA </option>
							<option value="25"> DIRECCIÓN GENERAL </option>
					        <option value="17"> ENFERMERÍA </option>
							<option value="18"> EPIDEMIOLOGÍA </option>
							<option value="3"> FARMACIA </option>
							<option value="4"> FARMACIA CLÍNICA </option>
							<option value="28"> IMAGENOLOGÍA </option>
							<option value="34"> INHALOTERAPIA </option>
							<option value="11"> INVESTIGACIÓN </option>
							<option value="19"> LABORATORIO </option>
							<option value="29"> LITOTRICIA </option>
							<option value="5"> MANTENIMIENTO </option>
							<option value="20"> MARKETING </option>
							<option value="30"> QUIROFANO </option>
							<option value="31"> RAYOS X </option>
							<option value="7"> RECURSOS HUMANOS </option>
							<option value="21"> SERVICIOS GENERALES </option>
							<option value="1"> TECNOLOGIA DE LA INFORMACIÓN </option>							
							<option value="22"> TERAPIA INTENSIVA </option>
							<option value="33"> UCIPyN </option>
							<option value="23"> ULTRASONIDO </option>
							<option value="34"> URGENCIAS </option>
							<option value="33"> VIEOENDOSCOPIA </option>
						</select>
                        <br>
						<br>
                        <input type="hidden" name="rol" value="<?php echo $rol ?>">
                        <input class="btn btn-success" type="submit" value="GUARDAR DATOS" name="subir" style="width: 208px; height: 40px">
                        <!--input class="btn btn-success" type="submit" name="guardaArch" value="GUARDAR"-->
                    </form>
                </div>
                <br>
            </div>

        </center>
        <br>
        <input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px">
    </body>

    </html>
