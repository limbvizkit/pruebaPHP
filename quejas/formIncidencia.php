<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Formulario FQS</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
	function mostrarInt() {
		check = document.getElementById("bien");
		check1 = document.getElementById("ocupada");
		if (check.checked || check1.checked) {
			$('#descr').removeAttr("required");
			$('#sol').removeAttr("required");
			$('#res').removeAttr("required");
		} else {
			$('#descr').prop("required", true);
			$('#sol').prop("required", true);
			$('#res').prop("required", true);
	   }
	}
</script>

<?php
require_once('../conexion/configLogin.php');

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía al inicio en el caso de no poseer autorización */
	   header("location: ../index.html");
	}
	$valor = $_SESSION[$rol];
	
	$queryArea = "SELECT u.idArea, a.nombreArea FROM usuarios as u
				LEFT JOIN areas as a ON u.idArea=a.idArea
				WHERE u.nombreUsr = '$rol'";
				
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];
	$areaName = utf8_encode($area[1]);
	
	/*$habtObl = '';
	if($rol == 'gdiaz' || $rol == 'jcastaneda' || $rol == 'jvazquez')
	{
		$habtObl = 'required';
	}*/
	
	$fechaFin = date('d/m/Y');
	$fechaGet = date('Y-m-d');
	$fecha= 'CURRENT_TIMESTAMP';
	
	if (isset($_POST['addIncidencial'])) {
		$fechaSol = 'NULL';
		$estatus = '1';
						
		if(isset ($_POST['areaAlta'])){
			$areaAlta= $_POST['areaAlta'];
		} else {
			$areaAlta= NULL;
		}
		
		if(isset ($_POST['fecha'])){
			$fecha= $_POST['fecha'];
			$fecha = "'".$fecha."'";
			if($fecha == NULL || $fecha == ''){
				$fecha= 'CURRENT_TIMESTAMP';
			}
		} else {
			$fecha= 'CURRENT_TIMESTAMP';
		}
		
		if(isset ($_POST['areaResp'])){
			$areaResp= $_POST['areaResp'];
			#if($areaResp == 'NA'){
			#	$areaResp = NULL;
			#}
		} else {
			$areaResp= NULL;
		}
		if(isset ($_POST['habitacion'])){
			$habitacion0 = $_POST['habitacion'];
			if($habitacion0 != NULL && $habitacion0 != ''){
				$queryHab = "SELECT idHabitacion FROM habitaciones WHERE numeroHabitacion = '$habitacion0'";
				$hb = mysqli_query($conexion, $queryHab);
				$hab = mysqli_fetch_array($hb);
				$habitacion = $hab[0];
			} else {
				$habitacion = 0;
			}
		} else {
			$habitacion = 0;
		}
		if(isset ($_POST['descr'])){
			$descr= utf8_decode(trim($_POST['descr']));
		} else {
			$descr= NULL;
		}
		if(isset ($_POST['sol'])){
			$sol= utf8_decode(trim($_POST['sol']));
		} else {
			$sol= NULL;
		}
		if(isset ($_POST['res'])){
			$res= $_POST['res'];
			if($res == 'SI'){
				$estatus = '3';
				$fechaSol = 'CURRENT_TIMESTAMP';
			}
		} else {
			$res= NULL;
		}
		#Se marca el recuadro de todo bien
		if(isset ($_POST['bien'])){
			$bien= $_POST['bien'];
			if($bien == 'Todo bien'){
				$descr = 'Todo bien';
				$sol = 'Todo bien';
				$res = 'SI';
				$areaResp = 'NULL';
				$fechaSol = 'CURRENT_TIMESTAMP';
				$estatus = '3';
			}
			#Se marca el recuadro de Hab Ocupada
		} else  {
			$bien= NULL;
		}
		
		if(isset ($_POST['ocupada'])){
			$bien= $_POST['ocupada'];
			if($bien == 'Ocupada'){
				$descr = utf8_decode('Habitación Ocupada');
				$sol = 'No Aplica';
				$res = 'NO';
				#$areaResp = '38';
				#$fechaSol = 'CURRENT_TIMESTAMP';
				#$estatus = '3';
			}
		}
		
		/*echo ' Se guardo la Incidencia de manera correcta<br>
		areaAlta: '.$areaAlta.'<br>
		areaResp: '.$areaResp.'<br>
		areaResp: '.$areaResp.'<br>
		habitacion: '.$habitacion.'<br>
		descr: '.$descr.'<br>
		sol: '.$sol.'<br>
		res: '.$res.'<br>
		';*/
		
		$queryAddIncidencia = "INSERT INTO incidencias (idIncidencia, fechaAlta, idAreaReporta, idAreaResponsable, reporte, solucion, resuelto, idHabitacion, fechaSolucion, estatus) 
							VALUES (NULL, $fecha,'$areaAlta', $areaResp, '$descr', '$sol', '$res', '$habitacion', $fechaSol, '$estatus')";
		$result0 = mysqli_query($conexion, $queryAddIncidencia);
			
		if(!$result0){
			echo'<span class="auto-style3">!!! ERROR AL REALIZAR ALTA DE INCIDENCIA!!!</span>';
			echo '<br/>Query Add: '.$queryAddIncidencia;
			echo'<br/> <br/> <input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />';
			exit;
		} else {
			echo '<br/><span class="auto-style3"><strong>!!!! SE GUARDO LA INCIDENCIA CORRECTAMENTE !!!!</strong></span><br>';
			#echo '<br/>Query Add: '.$queryAddIncidencia;
		}

	}
?>
	<style type="text/css">
		.auto-style1 {
			border: 2px solid #000000;
			margin:0 auto;
	background-color: #FFFFFF;
}
		.auto-style2 {
			text-align: center;
		}
		.auto-style3 {
			font-family: Arial, Helvetica, sans-serif;
			text-align: center;
		}
		.img_sup {
			float:left;
			width:109px;
		}
		.auto-style5 {
			font-family: Arial, Helvetica, sans-serif;
		}
		.auto-style6 {
			margin: 10px 150px;
		}
	
		.auto-style7 {
			font-size: large;
		}
		
		.styleBD {
			background-image: url('../img/logoNew2Agua.jpg');
		}
	
	</style>
	</head>
	
	<body class="styleBD">
	<div class="auto-style2">
		<p class="img_sup">
			<img alt="logo" v src="../img/logoNew2.jpg" width="120" class="auto-style6" style="float: left"/>
		</p>
	</div>
	<div class="auto-style3">
		<p>&nbsp;</p>
		<p class="auto-style7"><strong>
			Formulario para Alta de FQS
			</strong>
		</p>
		<br/>
		<span><span class="auto-style7">Favor de llenar los siguientes campos
		</span>
		</span>
		<span class="auto-style7">
		<br/>
		</span>
		<br/>
	</div>
	<br/>
	<form method="post" action="formIncidencia.php">
		<input type="hidden" name="rol" value="<?php echo $rol ?>"/>
		<div class="auto-style5">
			<table class="auto-style1" style="width: 60%">
				<tr>
					<td> 
						<br/>
						<?php #if ($rol == 'admin'){ ?>
							&nbsp; FECHA:&nbsp;
							<input type="date" id="fecha" name="fecha" style="height: 30px" class="auto-style3" required />
						<?php# } else { ?>
							<!-- &nbsp; FECHA:&nbsp;<?php #echo $fechaFin ?>-->
						<?php #} ?>
						<br/>
						<br/>
						&nbsp; TIPO DE REPORTE:
						<select id="areaAlta" name="areaAlta" style="width:500px; height:30px" required>
						        <option value="">Seleccione:</option>
						        <option value="1"> FELICITACIÓN </option>
						        <option value="2"> QUEJA </option>
						        <option value="3"> SUGERENCIA </option>
							</select>
						<br/>
						<br/>
						&nbsp; FELICITACIÓN, QUEJA Y/O SUGERENCIA:<br/>
						&nbsp;<textarea id="descr" name="descr" cols="90" rows="3" required></textarea>
						<!--input type="text" id="descr" name="descr" style="width: 700px; height: 30px;" /--> 
						<br/> 
						<br/>
						&nbsp; CLASIFICACIÓN:
						<select id="areaAlta" name="areaAlta" style="width:500px; height:30px" required>
						        <option value="">Seleccione:</option>
								<option value="NA"> NO APLICA </option>
						        <option value="1"> ACTITUD </option>
						        <option value="2"> ALIMENTOS </option>
						        <option value="3"> ATENCIÓN </option>
							 	<option value="4"> CAMAS </option>
								<option value="5"> CAPACITACIÓN </option>
								<option value="6"> COMUNICACIÓN </option>
								<option value="7"> COSTOS </option>
								<option value="8"> DIFUSIÓN </option>
								<option value="9"> ENTRETENIMIENTO </option>
								<option value="10"> EQUIPOS </option>
								<option value="11"> ESPECIAL </option>
								<option value="12"> ESTACIONAMIENTO </option>
							 	<option value="13"> INFORMACIÓN </option>
								<option value="14"> INSTALACIONES </option>
								<option value="15"> LIMPIEZA </option>
								<option value="16"> MANTENIMIENTO </option>
								<option value="17"> MEDICAMENTO </option>
								<option value="18"> MOBILIARIO </option>
								<option value="19"> PAQUETES </option>
								<option value="20"> PERSONA AJENA </option>
								<option value="21"> PERSONAL </option>
								<option value="22"> PLAGA </option>
								<option value="23"> ROPA </option>
								<option value="24"> RUIDO </option>
								<option value="25"> SEÑALAMIENTOS </option>
								<option value="26"> SUGERENCIA </option>
								<option value="27"> TIEMPO DE ESPERA </option>
								<option value="28"> TIEMPO ASEGURADORA </option>
								<option value="29"> VIGILANCIA </option>
							</select>
						<br/>
						<br/>
						&nbsp; ÁREA QUE ENCUESTA:
						<select id="areaAlta" name="areaAlta" style="width:500px; height:30px" required>
						        <option value="">Seleccione:</option>
						        <option value="1"> CAFETERÍA </option>
						        <option value="2"> CONSULTA </option>
						        <option value="3"> HOSPITALIZACIÓN </option>
						        <option value="4"> IMAGENOLOGÍA </option>
						        <option value="5"> LABORATORIO </option>
						        <option value="6"> NUTRICIÓN </option>
						        <option value="7"> TERAPIA </option>
						        <option value="8"> URGENCIAS </option>
							</select>
						<br/>
						<br/>
						&nbsp; HABITACIÓN / TURNO: 
						<select id="areaResp" name="areaResp" style="width:500px; height:30px" required>
						        <option value="">Seleccione:</option>
						        <option value="NA"> NO APLICA </option>
						        <option value="TM"> TURNO MATUTINO </option>
						        <option value="TV"> TURNO VESPERTINO </option>
						        <option value="TN"> TURNO NOCTURNO </option>
								<option value="TI"> T.I. </option>
						        <option value="UCI"> UCI </option>
						        <option value="101"> HAB 101 </option>
						        <option value="102"> HAB 102 </option>
								<option value="103"> HAB 103 </option>
						        <option value="104"> HAB 104 </option>
								<option value="105"> HAB 105 </option>
						        <option value="106"> HAB 106 </option>
								<option value="107"> HAB 107 </option>
						        <option value="108"> HAB 108 </option>
								<option value="109"> HAB 109 </option>
						        <option value="110"> HAB 110 </option>
								<option value="111"> HAB 111 </option>
						        <option value="112"> HAB 112 </option>
								<option value="113"> HAB 113 </option>
						        <option value="114"> HAB 114 </option>
								<option value="115"> HAB 115 </option>
						        <option value="116"> HAB 116 </option>
								<option value="117"> HAB 117 </option>
						        <option value="118"> HAB 118 </option>
								<option value="119"> HAB 119 </option>
						        <option value="120"> HAB 120 </option>
								<option value="201"> HAB 201 </option>
								<option value="202"> HAB 202 </option>
								<option value="203"> HAB 203 </option>
								<option value="204"> HAB 204 </option>
								<option value="205"> HAB 205 </option>
								<option value="206"> HAB 206 </option>
								<option value="207"> HAB 207 </option>
								<option value="208"> HAB 208 </option>
								<option value="209"> HAB 209 </option>
								<option value="210"> HAB 210 </option>
								<option value="211"> HAB 211 </option>
								<option value="212"> HAB 212 </option>
								<option value="213"> HAB 213 </option>
								<option value="214"> HAB 214 </option>
								<option value="215"> HAB 215 </option>
							</select>
						<br/>
						<br/>
						&nbsp; ÁREA(S) RESPONSABLE(S):
						<select id="areaResp" name="areaResp[]" multiple="multiple" style="width:400px; height:300px" required>
						        <option value="">Seleccione:</option>
						        <option value="NA"> NO APLICA </option>
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
								<option value="37"> DIRECCIÓN COMERCIAL </option>
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
								<option value="39"> ROPERÍA </option>
								<option value="21"> SERVICIOS GENERALES </option>
								<option value="1"> TECNOLOGÍA DE LA INFORMACIÓN </option>
								<option value="22"> TERAPIA INTENSIVA </option>
								<option value="33"> UCIPyN </option>
								<option value="23"> ULTRASONIDO </option>
								<option value="34"> URGENCIAS </option>
								<option value="35"> VIDEOENDOSCOPIA </option>
							</select>
						<br/>
						<br/>
						&nbsp; PERSONA(S) INDICADA(S):
						<!--input type="number" id="habitacion" name="habitacion" style="width: 90px; height: 30px;" <?php #echo $habtObl ?>/-->
						<input type="text" id="nHabitacion" name="nHabitacion" style="width: 400px; height: 30px;">
						<br/>
						<br/>
						&nbsp; SEGUIMIENTO:<br/>
						&nbsp;<textarea id="seguimiento" name="seguimiento" cols="90" rows="3" required></textarea>
						<!--input type="text" id="descr" name="descr" style="width: 700px; height: 30px;" /--> 
						<br/> 
						<br/>
						&nbsp; ESTRATEGIA:<br/>
						&nbsp;<textarea id="estrategia" name="estrategia" cols="90" rows="3" required></textarea>
						<!--input type="text" id="descr" name="descr" style="width: 700px; height: 30px;" /--> 
						<br/>
						<br/>
						&nbsp; ESTATUS:
						<select id="areaAlta" name="areaAlta" style="width:500px; height:30px" required>
						    <option value="">Seleccione:</option>
						    <option value="1"> EMITIDA </option>
						    <option value="2"> CON SEGUIMIENTO </option>
						    <option value="3"> CON ESTRATEGIA </option>
							<option value="4"> CERRADA </option>
						</select>
						<br/>
						<br/>
					</td>
				</tr>
			</table>
		</div>
		<br/>
		<div class="text-center">			
			<input class="btn btn-success" name="addIncidencial" type="submit" value="Agregar Incidencia" style="height: 60px; width: 166px" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<!--a class="btn btn-primary" style="width: 230px; height: 60px" href="consultaIncidenciaDia.php?rol=<?php #echo $rol ?>&&f=<?php #echo $fechaGet ?>" target="_blank">Consultar Incidencias del Día</a-->
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
			<br/>
	 	</div>
	</form>
	</body>
</html>