<?php
	
 	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* Nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: ../index.html"); 
	}
	$valor = $_SESSION[$rol];
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../css/bootstrap.min.css" >
	<!-- Optional theme -->
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css" >
	<!-- Latest compiled and minified JavaScript -->
	<script type="text/jscript" src="../js/bootstrap.min.js" ></script>
	<link rel=stylesheet href="../css/stylo.css" type="text/css">
<style type="text/css">
	.styleBD {
		background-image: url('../img/1280x768-A.JPG');
	}
	.auto-style3 {
		text-align: center;
		color: green;
		background-color:white;
	}
</style>
	<title>Carga de Archivos</title>
</head>
<body class="styleBD">
<center>
<div class="h">
	<div class="head">
		<h1>IDENTIFICACIÓN DEL DOCUMENTO PROTEGIDO</h1>
		<hr>
		<br>
		<!--form action="" method="post" enctype="multipart/form-data">
		<h1 class="auto-style2">CARGAR ARCHIVO <br>
		(jpg, png, pdf, doc, docx, xls, xlsx)
		</h1>
		<input type="file" class="btn-default btn-block" name="archivo" required>
		<input type="hidden" name="rol" value="<?php echo $rol ?>" >
		<br-->
		<form method="post" action="sigArchivo.php">
			<strong><span>&nbsp; Área o Departamento:</span></strong>
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
            <strong><span>Subserie Documental:</span></strong>
            <br>
            <input type="text" name="subSerie" style="width: 160px" >
            <br>
            <br>
            <strong><span>Nombre del Documento:</span></strong>
            <br>
            <input type="text" name="nombreDoc" style="width: 360px" required>
            <br>
            <br>
            <strong><span>Tipos de Documentos que la Integran:</span></strong>
            <br>
            <textarea name="tipoDocsInt" cols="50" rows="2"></textarea>
            <br>
            <br>
            <strong><span>Carácter de los Documentos:</span></strong>
            <br>
            <input type="text" name="caracterDocs" style="width: 160px" required>
            <br>
            <br>
            <strong><span>Vigencia:</span></strong><br>
            <span> AO(Archivo de Operación):</span>
            <input type="text" name="ao" style="width: 30px; font-size:medium" class="auto-style3" >
            <span>&nbsp;AT(Archivo de Tramite):</span>
            <input type="text" name="at" style="width: 30px" class="auto-style3" >
            <span>&nbsp;AC(Archivo de Concentración):</span>
            <input type="text" name="ac" style="width: 30px" class="auto-style3" >
            <span>&nbsp; T(Total):</span>
            <input type="text" name="t" style="width: 30px" class="auto-style3" > 
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
            <input type="text" name="r" style="width: 30px" class="auto-style3" >
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
			<input type="hidden" name="rol" value="<?php echo $rol ?>" >
			<input class="btn btn-success" type="submit" value="SIGUIENTE" name="siguiente" style="width: 208px; height: 40px">
		</form>
	</div>
	<br>
	</div>
</center>
<br>
<input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >
</body>
</html>