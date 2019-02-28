<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
		<title>Formulario De Registro de Pacientes</title>
		<link rel="stylesheet" type="text/css" href="estilo.css">
		<style type="text/css">
		.auto-style1 {
			font-size: medium;
		}
		.auto-style2 {
			font-size: small;
		}
		.auto-style3 {
			text-align: center;
		}
		.autoStyle4 {
			color: #FF0000;
			font-size: medium;
		}
		</style>

<?php
	require "conexion.php";
	$rol=NULL;

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
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   #echo "Variable de session VACIA!!!!!";
	   header("location: index.php"); 
	}
	
	
	if(isset($_REQUEST['addCirugia']))
	{
		//recuperar las variables
		#$id=$_POST['id'];
		$fecha=$_POST['fecha'];
		$hora=$_POST['hora'];
		
		$tipoCir=$_POST['tipoCir'];
		$costeador=$_POST['costeador'];
		$sala=$_POST['sala'];
		$tiempoHr=$_POST['tiempoHr'];
		$tiempoMin=$_POST['tiempoMin'];
		$autorizo=$_POST['autorizo'];
		$descorcheTxt=$_POST['descorcheTxt'];
		
		if(isset ($_POST['transope'])){
			$transope= $_POST['transope'];
		}else {
			$transope= NULL;
		}
		
		$patologo=$_POST['patologo'];
		$tamano=$_POST['tamano'];
		$telCirujano=$_POST['telCirujano'];
		$emailCirujano=$_POST['emailCirujano'];
		$instrumentista=$_POST['instrumentista'];
		
		$enfermera=$_POST['enfermera'];
		$nombre=$_POST['nombrePaciente'];
		$edad=$_POST['edad'];
		$diagnostico=$_POST['diagnostico'];
		$cirugia=$_POST['cirugia'];
		$instrumental=$_POST['instrumental'];
		$equipo=$_POST['equipo'];
		$descorche=$_POST['descorche'];
		$imagen=$_POST['imagen'];
		$sangre=$_POST['sangre'];
		$patologias=$_POST['patologias'];
		$cirujano=$_POST['cirujano'];
		$ayudante=$_POST['ayudante'];
		$pediatra=$_POST['pediatra'];
		$anestesiologo=$_POST['anestesiologo'];
		//$proporciono=$_POST['proporciono'];
		
		//Query para validar si no esta ocupada la Sala en la fecha y hora seleccionada
		require "eliminar/conexion.php";
		$sqlValida = "SELECT * FROM programaCirugia WHERE idSala='$sala' AND '$fecha'=fecha AND '$hora' BETWEEN hrInicio AND hrFin";
		$resultado=$mysqli->query($sqlValida);
		
		if($resultado->num_rows > 0){
				echo "<br/><strong><p class='autoStyle4'>LA SALA ESTA OCUPADA EN LA FECHA Y HORA SELECCIONADAS, FAVOR DE SELECCIONAR OTRA HORA U OTRA SALA </p></strong><br>";
		} else {
			//hacemos la sentencia de sql para guardar la cirugia
			$sqlDN = "INSERT INTO datosnuevos (id, fecha, hora, enfermera, nombrePaciente, edad, diagnostico, cirugia, instrumental, equipo, descorche, imagen, sangre, patologias, cirujano, 
											ayudante, pediatra, anestesiologo, tipoDeCirugia, costeador, sala, tiempoHr, tiempoMin, autorizo, descorcheTxt, transPosOperatorio, 
											patologo, tamano, telCirujano, emailCirujano, instrumentista)
				 VALUES (NULL, '$fecha', '$hora', '$enfermera', '$nombre', '$edad', '$diagnostico', '$cirugia', '$instrumental', '$equipo', '$descorche', '$imagen', '$sangre', '$patologias', 
						 '$cirujano', '$ayudante', '$pediatra', '$anestesiologo', '$tipoCir', '$costeador', '$sala', '$tiempoHr', '$tiempoMin', '$autorizo', '$descorcheTxt', '$transope', 
						 '$patologo', '$tamano', '$telCirujano', '$emailCirujano', '$instrumentista')";
		 								   
			//ejecutamos la sentencia de sqlDN
			if ($conn->query($sqlDN)==true) {
				#Sacamos el id anteriormente guardado
				$sqlMax = "SELECT MAX(id) AS maximo FROM datosnuevos LIMIT 1";
				$resultadoMax=$mysqli->query($sqlMax);
				while($row=$resultadoMax->fetch_assoc()){
					$idCirugia = $row['maximo'];
					#echo $sqlMax."<br>";
					#echo "idCirugia: ".$idCirugia."<br>";
				}
				
				#sacamos los datos para la suma de horas y minutos
				$hr=$tiempoHr;
				$min=$tiempoMin;
				$hrFin= $hr.':'.$min;

				#sacamos la hora final sumandole horas y minutos a la hr inicial
				$sqlHrFin= "SELECT ADDTIME(hora, '$hrFin') AS horaFin FROM datosnuevos WHERE id='$idCirugia' LIMIT 1";
				$resultadoHr=$mysqli->query($sqlHrFin);
				while($row1=$resultadoHr->fetch_assoc()){
					$hrFinal= $row1['horaFin'];
					#echo $sqlHrFin."<br>";
					#echo "HrFinal: ".$hrFinal."<br>";
				}
				#$hrFinal = $resultadoHr->fetch_array(MYSQLI_ASSOC);
				
				
				#Insertamos todos los datos para programacion de Cirugia
				$sqlPC = "INSERT INTO programaCirugia (id, idCirugia, idSala, fecha, hrInicio, hrFin)
								VALUES(NULL, '$idCirugia', '$sala', '$fecha', '$hora', '$hrFinal')";
								
				if ($conn->query($sqlPC)==true) {
					echo '<br><strong>!!!! SE INSERTARON LOS DATOS DE LA PROGRAMACIÓN CORRECTAMENTE!!!!</strong><br>';
				}else{
					echo '!!! Error Programación de Cirugía: '.$sqlPC.'<br>'.$conn->error;
				}
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LA CIRUGÍA CORRECTAMENTE !!!!</strong><br>';
			}else{
				echo '!!! Error Datos de Cirugía: '.$sqlDN.'<br>'.$conn->error;
			}$conn->close();
		}
		
	}
?>

		<script type="text/javascript"> 
			function mostrar0(v){
				if(v == '1'){
					document.getElementById('descorcheTxtVer').style="display:block";
				} else {
					document.getElementById('descorcheTxtVer').style="display:none";
		
				}
			}

			function mostrar(v){
				if(v == '1'){
					document.getElementById('transopeVer').style="display:block";
					document.getElementById('tamanoVer').style="display:block";
				} else {
					document.getElementById('transopeVer').style="display:none";
					document.getElementById('patologoVer').style="display:none";
					document.getElementById('tamanoVer').style="display:none";
				}
			}
			function mostrar1(v1){pediatraVer
				if(v1 == '1'){
					document.getElementById('patologoVer').style="display:block";
				} else {
					document.getElementById('patologoVer').style="display:none";
		
				}
			}
			function mostrar2(v1){instrumentistaVer
				if(v1 == '1'){
					document.getElementById('pediatraVer').style="display:block";
				} else {
					document.getElementById('pediatraVer').style="display:none";
		
				}
			}
			function mostrar3(v1){
				if(v1 == '1'){
					document.getElementById('instrumentistaVer').style="display:block";
				} else {
					document.getElementById('instrumentistaVer').style="display:none";
				}
			}
		</script>
		</head>
	<body>
	  
		<div class="form">
			<div align="center"><img alt="logoHD" src="logo.jpg"></div>
			<form method="post" >
				<!--p>ID</p>
				<label for="id">ID de Cirugía</label>
				<br>
				<input class="box" type="text" name="id" placeholder="id"-->
				<p class="auto-style3">Registro de Cirugías</p>
				<p class="auto-style1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp; Hora*</strong></p>
				
				<label for="fecha"><span class="auto-style2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				Fecha de Cirugía</span></label>
				<label for="hora">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="auto-style2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hora de Cirugía</span></label><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;
				
				<input class="box" type="date" name="fecha" required style="width: 148px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
				
				<input class="box" type="time" name="hora" required style="width: 136px">
				
				&nbsp;<p>Sala de Operaciones*</p>
					<select id="sala" name="sala" style="width:230px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="1"> SALA 1 </option>
				   		<option value="2"> SALA 2 </option>
				   		<option value="3"> SALA 3 </option>
				   		<option value="4"> SALA DE EXPULSIÓN </option>
					</select>&nbsp;&nbsp;&nbsp;
				<a class="btn btn-info" href="salasDisp.php?rol=<?php echo $rol ?>" target="_blank">Disponibilidad de Salas</a>
				
				&nbsp;<p>Tipo de Cirugía*</p>
					<select id="tipoCir" name="tipoCir" style="width:230px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="PROGRAMADA"> PROGRAMADA </option>
				   		<option value="URGENCIA"> URGENCIA </option>
					</select>
				
				&nbsp;<p>Costeador*</p>
					<select id="costeador" name="costeador" style="width:130px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="ASEGURADORA "> ASEGURADORA </option>
				   		<option value="PARTICULAR "> PARTICULAR </option>
					</select>

				&nbsp;<p>Tiempo Quirúrgico Aproximado*</p>
				<input class="box" type="number" name="tiempoHr" style="width: 50px" min="0" max="10" value="0" > Horas&nbsp;&nbsp;&nbsp;
				<input class="box" type="number" name="tiempoMin" style="width: 50px" min="0" max="59" value="0" > Minutos
				
				&nbsp;<p>Enfermera(o) que Programa Cirugía*</p>
				<!--label for="nombre">Nombre del Paciente</label>
				<br-->
				<input class="box" type="text" name="enfermera" placeholder="Nombre Enf." required>
				
				&nbsp;<p>Autorizó*</p>
					<select id="autorizo" name="autorizo" style="width:330px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="Dr. Juan Augusto Miranda Aviles">  Dr. Juan Augusto Miranda Aviles </option>
				   		<option value="Dr. Fernando Carreño De La Rosa"> Dr. Fernando Carreño De La Rosa </option>
						<option value="Ing. Carlos Padilla Morales"> Ing. Carlos Padilla Morales </option>
					</select>

				&nbsp;<p>Nombre del Paciente*</p>
				<input class="box" type="text" name="nombrePaciente" placeholder="Nombre y Apellidos" required>
				
				&nbsp;<p>Edad del Paciente*</p>
				<input class="box" type="number" name="edad" required style="width: 40px"> 
				
				&nbsp;<p>Diagnóstico Preoperatorio*</p>
				<input class="box" type="text" name="diagnostico" placeholder="Diagnóstico" required>
				
				&nbsp;<p>Cirugía a Realizar*</p>
				<input class="box" type="text" name="cirugia" placeholder="Cirugía a realizar" required>
				
				&nbsp;<p>Instrumental o Material Especial (Opcional)</p>
				<input class="box" type="text" name="instrumental" >
				
				&nbsp;<p>Equipo (Opcional)</p>
				<input class="box" type="text" name="equipo" >
				
				&nbsp;<p>Descorche*</p>
				SI<input type="radio" id="descorche" name="descorche" onclick="mostrar0('1')" value="SI" required>
				NO<input type="radio" id="descorche" name="descorche" onclick="mostrar0('2')" value="NO" required>
				
				&nbsp;<p id="descorcheTxtVer" style="display:none">Descorche sobre
					<textarea name="descorcheTxt" id="descorcheTxt" cols="5" rows="2"></textarea>
				</p>

				&nbsp;<p>Imagenología (Opcional)</p>
				<input class="box" type="text" name="imagen" >
				
				&nbsp;<p>Reserva de Sangre (Opcional)</p>
				<input class="box" type="text" name="sangre" >
				
				&nbsp;<p>Muestra de Patologías*</p>
				SI<input type="radio" id="patologias" onclick="mostrar('1')" name="patologias" value="SI" required>
				NO<input type="radio" id="patologias" onclick="mostrar('2')" name="patologias" value="NO" required>
				
				&nbsp;<p id="transopeVer" style="display:none" >
					Transoperatorio<input type="radio" id="transope" onclick="mostrar1('1')" name="transope" value="Transoperatorio" >
					Postoperatorio<input type="radio" id="transope" onclick="mostrar1('2')" name="transope" value="Postoperatorio" >
				</p>
				
				&nbsp;<p id="patologoVer" style="display:none" >Patólogo
					<input class="box" type="text" id="patologo" name="patologo" placeholder="Nombre y Apellidos" >
				</p>
				
				&nbsp;<p id="tamanoVer" style="display:none">Tamaño
					<select id="tamano" name="tamano" style="width:230px; height:40px" >
				        <option value="">Seleccionar</option>
				        <option value="CHICO">  CHICO </option>
				   		<option value="MEDIANO"> MEDIANO </option>
						<option value="GRANDE"> GRANDE </option>
						<option value="EXTRA GRANDE"> EXTRA GRANDE </option>
					</select>
					</p>
				
				&nbsp;<p>Médico Cirujano*</p>
				<input class="box" type="text" name="cirujano" placeholder="Nombre y Apellidos" required>
				
				&nbsp;<p>Teléfono del Médico Cirujano</p>
				<input class="box" type="text" name="telCirujano" >
				
				&nbsp;<p>E-mail del Médico Cirujano</p>
				<input class="box" type="email" name="emailCirujano" >
				
				&nbsp;<p>Médico Ayudante (Opcional)</p>
				<input class="box" type="text" name="ayudante" placeholder="Nombre y Apellidos">
				
				&nbsp;<p>Médico Anestesiólogo*</p>
				<input class="box" type="text" name="anestesiologo" required placeholder="Nombre y Apellidos">
				
				&nbsp;<p>Médico Pediatra*</p>
					SI<input type="radio" id="pediatra1" onclick="mostrar2('1')" name="pediatra1" value="SI" required >
					NO<input type="radio" id="pediatra1" onclick="mostrar2('2')" name="pediatra1" value="NO" required >
				
				&nbsp;<p id="pediatraVer" style="display:none" >
					<input class="box" type="text" name="pediatra" placeholder="Nombre y Apellidos">
				</p>
				
				&nbsp;<p>Médico Instrumentista*</p>
					SI<input type="radio" id="instrumentista1" onclick="mostrar3('1')" name="instrumentista1" value="SI" required >
					NO<input type="radio" id="instrumentista1" onclick="mostrar3('2')" name="instrumentista1" value="NO" required >
				
				&nbsp;<p id="instrumentistaVer" style="display:none" >
					<input class="box" type="text" name="instrumentista" placeholder="Nombre y Apellidos">
				</p>				
				
				<!--&nbsp;<p>Nombre de Quien Proporciono Datos (Opcional)</p>
				<input class="box" type="text" name="proporciono" placeholder="Nombre y Apellidos" -->
				<br>
				<br>
				<br>
				<input type="hidden" name="rol" value="<?php echo $rol ?>">
				<input type="submit" name="addCirugia" value="Guardar Información" >
				<br>
				<br>
				<a class="btn btn-info" href="eliminar/index.php?rol=<?php echo $rol ?>" target="_blank">Eliminar y Modificar Información</a>
				<br>
				<br>
			</form>
			<input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >
		</div>
	</body>
</html>