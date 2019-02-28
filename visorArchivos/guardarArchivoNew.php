<?php
	require_once('../conexion/configLogin.php');
	
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
	
	if (isset($_POST['subir'])) {
		$arrArreas=NULL;
						
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
		/*if (isset($_POST['subSerie']))
		{
			$subSerie=$_POST['subSerie'];
		}else {
			$subSerie= NULL;
		}*/
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
			$caracterDocs=$_POST['caracterDocs'];
		}else {
			$caracterDocs= NULL;
		}
		if (isset($_POST['vigencia']))
		{
			$vigencia= $_POST['vigencia'];
		}else {
			$vigencia= NULL;
		}
		if (isset($_POST['ao']))
		{
			if($_POST['ao'] != NULL && $_POST['ao'] != ''){
				$ao = $_POST['ao'];
			} else {
				$ao = '0';
			}
		}
		if (isset($_POST['at']))
		{
			if($_POST['at'] != NULL && $_POST['at'] != ''){
				$at = $_POST['at'];
			} else {
				$at = '0';
			}
		}
		if (isset($_POST['ac']))
		{
			if($_POST['ac'] != NULL && $_POST['ac'] != ''){
				$ac= $_POST['ac'];
			} else {
				$ac= '0';
			}
		}
		if (isset($_POST['t']))
		{
			if($_POST['t'] != NULL && $_POST['t'] != ''){
				$t= $_POST['t'];
			} else {
				$t= '0';
			}
		}
		if (isset($_POST['l']))
		{
			if($_POST['l'] != NULL && $_POST['l'] != ''){
				$l= $_POST['l'];
			} else {
				$l= '0';
			}
		}
		if (isset($_POST['f']))
		{
			if($_POST['f'] != NULL && $_POST['f'] != ''){
				$f= $_POST['f'];
			} else {
				$f= '0';
			}
		}
		if (isset($_POST['c']))
		{
			if($_POST['c'] != NULL && $_POST['c'] != ''){
				$c= $_POST['c'];
			} else {
				$c= '0';
			}
		}
		if (isset($_POST['a']))
		{
			if($_POST['a'] != NULL && $_POST['a'] != ''){
				$a= $_POST['a'];
			} else {
				$a= '0';
			}
		}
		if (isset($_POST['dispDoc']))
		{
			$dispDoc = $_POST['dispDoc'];
		}else {
			$dispDoc = NULL;
		}
		if (isset($_POST['r']))
		{
			if($_POST['r'] != NULL && $_POST['r'] != ''){
				$r= $_POST['r'];
			} else {
				$r= '0';
			}
		}
		if (isset($_POST['c1']))
		{
			if($_POST['c1'] != NULL && $_POST['c1'] != ''){
				$c1= $_POST['c1'];
			} else {
				$c1= '0';
			}
		}
		/*if (isset($_POST['plazo']))
		{
			$plazo=$_POST['plazo'];
		}else {
			$plazo= NULL;
		}*/
		if (isset($_POST['observaciones']))
		{
			$observaciones = utf8_decode($_POST['observaciones']);
		}else {
			$observaciones= NULL;
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
		
		#Query para generar el autoincrementable de la serie para la subserie
		$querySubserie = "SELECT COUNT(*) FROM datosdocumentosNew WHERE serie = '$serie' AND areaDepto = '$areas'";
		$result = mysqli_query($conexion, $querySubserie);
		$row = mysqli_fetch_array($result);
		$conteo=$row[0]+1;
		
		#Query's para generar el codigo de area+serie+subserie
		$querySiglA = "SELECT siglasArea FROM areas WHERE idArea = '$areas'";
		$result1 = mysqli_query($conexion, $querySiglA);
		$row0 = mysqli_fetch_array($result1);
		
		#Query's para generar el codigo de area+serie+subserie
		$querySiglS = "SELECT siglasSerie FROM seriedocumental WHERE idSerieDoc = '$serie'";
		$result2 = mysqli_query($conexion, $querySiglS);
		$row1 = mysqli_fetch_array($result2);
		
		$codigo = $row0[0].'-'.$row1[0].'-'.$conteo;
		
		echo ' !!! LLEGO !!!<br>
		Permisos: '.$permisos.'<br>
		Permisos Areas: '.$arrArreas.'<br>
		Serie: '.$serie.'<br>
		Conteo Subserie : '.$conteo.'<br>
		Codigo: '.$codigo.'<br>
		';
		
		$queryAddArchivo = "INSERT INTO datosdocumentosNew (idDocumento, codigo, areaDepto, serie, subSerie, tipoDocsIntegran, nombreDocumento, caracterDoc, vigencia, ao, at, ac, t, l, f, c, a, disposicionDoc, r, c1, observaciones, estatus, fechaAlta, permisos) 
			VALUES (NULL, '$codigo', '$areas', '$serie', '$conteo', '$tipoDocsInt', '$nombreDoc', '$caracterDocs', '$vigencia', '$ao', '$at', '$ac', '$t', '$l', '$f', '$c', '$a', '$dispDoc', '$r', '$c1', '$observaciones', '1', NULL, '$permisosFin')";
		$result0 = mysqli_query($conexion, $queryAddArchivo);
			
		if(!$result0){
			echo'<span class="auto-style1">!!! ERROR AL REALIZAR INSERCIÓN DE DATOS DEL DOCUMENTO!!!</span>';
			echo '<br/>Query Add: '.$queryAddArchivo;
			exit;
		} else {
			echo '<br/><span class="auto-style3"><strong>!!!! SE GUARDARON LOS DATOS DEL DOCUMENTO CORRECTAMENTE !!!!</strong></span><br>';
			echo '<br/>Query Add: '.$queryAddArchivo;
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
            .auto-style3 {
				font-weight: bold;
				font-size: medium;
			}
        </style>
        <!--script type="text/javascript">
			function ShowSubserie()
			{
			/* Para obtener el valor */
			var cod = document.getElementById("serie").value;
			alert(cod);
			 
			/* Para obtener el texto */
			var combo = document.getElementById("serie");
			var selected = combo.options[combo.selectedIndex].text;
			alert(selected);
			}
		</script-->
    	<title>Carga de Archivos</title>
	</head>
    <body class="styleBD">
        <center>
            <div class="h">
                <div class="head">
                    <h1>IDENTIFICACIÓN DEL DOCUMENTO</h1>
                    <form action="guardarArchivoNew.php" method="post" >
                        <input type="hidden" name="rol" value="<?php echo $rol ?>">
                        <br>
                        <strong><span>Área, Departamento/Servicio:</span></strong>
                        <select id="areas" name="areas" style="width:380px; height:40px" required>
					        <option value="">Seleccione:</option>
					        <option value="15"> ADMISIÓN </option>
					        <option value="10"> ALMACEN </option>
					        <option value="38"> ATENCIÓN A CLIENTES </option>
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
							<option value="8"> MÉDICA </option>
							<option value="30"> QUIROFANO </option>
							<option value="31"> RAYOS X </option>
							<option value="7"> RECURSOS HUMANOS </option>
							<option value="21"> SERVICIOS GENERALES </option>
							<option value="1"> TECNOLOGÍA DE LA INFORMACIÓN </option>							
							<option value="22"> TERAPIA INTENSIVA </option>
							<option value="33"> UCIPyN </option>
							<option value="23"> ULTRASONIDO </option>
							<option value="34"> URGENCIAS </option>
							<option value="35"> VIDEOENDOSCOPIA </option>
						</select>
                        <br>
                        <br>
                        <strong><span>Serie Documental:</span></strong><br>
                        <select id="serie" onchange="ShowSubserie();" name="serie" style="width:380px; height:40px" required>
					        <option value="">Seleccione:</option>
					        <option value="1"> Sistema de Gestión de Calidad </option>
					        <option value="2"> Expediente Clínico </option>
					   	</select>
					   	<?php 
                        	
                        ?>
                        <br>
                        <br>
                        <strong><span>Subserie Documental:</span></strong><br>
                        <span>*Se genera internamente autoincrementable</span>
                        <!--input type="text" name="subSerie" style="width: 160px" -->
                        <br>
                        <br>
                        <strong><span>Nombre del Documento:</span></strong><br>
                        <input type="text" name="nombreDoc" style="width: 400px" required>
                        <br>
                        <br>
                        <strong><span>Tipos de Documentos que la Integran:</span></strong><br>
                        <textarea name="tipoDocsInt" cols="50" rows="2"></textarea>
                        <br>
                        <br>
                        <strong><span>Carácter de los Documentos:</span></strong>
                        <br>
                        <select id="caracterDocs" name="caracterDocs" style="width:200px; height:40px" required>
					        <option value="">Seleccione:</option>
					        <option value="1"> ARCHIVO DIGITAL </option>
					        <option value="2"> ARCHIVO FÍSICO </option>
					   	</select>
                        <br>
                        <br>
                        <strong><span>Plazo de Vigencia:</span></strong>
                        <br>
                        <select id="vigencia" name="vigencia" style="width:300px; height:40px">
					        <option value="">Seleccione:</option>
					        <option value="1"> HASTA VIGENCIA </option>
					        <option value="2"> HASTA RESOLUCIÓN </option>
					        <option value="3"> VIGENCIA INDETERMINADA </option>
					   	</select>
                        <br>
                        <br>
                        <span> AO(Archivo de Operación):</span>
                        <input type="number" name="ao" style="width: 40px; font-size:medium" class="auto-style3" >
                        <span>&nbsp;AT(Archivo de Tramite):</span>
                        <input type="number" name="at" style="width: 40px" class="auto-style3" >
                        <span>&nbsp;AC(Archivo de Concentración):</span>
                        <input type="number" name="ac" style="width: 40px" class="auto-style3" >
                        <span>&nbsp; T(Total):</span>
                        <input type="number" name="t" style="width: 50px" class="auto-style3" > 
                        <span>
                        <strong>&nbsp;<br><br>Valor Documental:</strong>
                        <br>
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
                        <strong><span>Disposición Documental:</span></strong>
                        <br>
                        <select id="dispDoc" name="dispDoc" style="width:360px; height:40px" required>
					        <option value="">Seleccione:</option>
					        <option value="1"> ARCHIVO HISTORICO </option>
					        <option value="2"> BAJA DEFINITIVA </option>
					        <option value="3"> CONSERVACIÓN POR MUESTREO </option>
					   	</select>
                        <br>
                        <br>
                        <strong><span>Consulta y Plazo de Conservación:</span></strong><br>
                        <span>R(Periodo de Conservacion):</span>
                        <input type="number" name="r" style="width: 40px" class="auto-style3" >
                         <span>&nbsp; C(Información Confidencial):</span>
                        <input type="checkbox" name="c1" style="width: 20px; height: 20px;" value="1" class="auto-style3" >
                        <!--span>&nbsp; Plazo:</span>
                        <input type="text" name="plazo" style="width: 30px" class="auto-style3" -->
                        <br>
                        <br>
                        <strong><span>OBSERVACIONES:</span></strong><br>
                        <textarea name="observaciones" cols="50" rows="2"></textarea>
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
							<option value="8"> MÉDICA </option>
							<option value="30"> QUIRÓFANO </option>
							<option value="31"> RAYOS X </option>
							<option value="7"> RECURSOS HUMANOS </option>
							<option value="21"> SERVICIOS GENERALES </option>
							<option value="1"> TECNOLOGÍA DE LA INFORMACIÓN </option>							
							<option value="22"> TERAPIA INTENSIVA </option>
							<option value="33"> UCIPyN </option>
							<option value="23"> ULTRASONIDO </option>
							<option value="34"> URGENCIAS </option>
							<option value="35"> VIDEOENDOSCOPIA </option>
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
