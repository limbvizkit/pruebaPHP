

<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>PARTOS</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
	<link href="../css/bootstrap.min.css" rel="stylesheet" >
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	

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
		.suggest-element {
			width:100%;
			cursor:pointer;
			background-color: #ECECEC;
		    margin-top: 1px;
		    padding-bottom: 5px;
		    padding: 5px;
			float:left;
		}
		
		.suggest-element:hover {
			background-color:#999999;
			color:#FFFFFF;
		}
		
		#suggestions {
			width:425px;
			height:165px;
			overflow: auto;
		}
		
		#suggestions .item{
		    float: left;
		    width: 396px;
		}
		
		#suggestions1 {
			width:425px;
			height:165px;
			overflow: auto;
		}
		
		#suggestions1 .item{
		    float: left;
		    width: 396px;
		}
		
		#result {
			background-color: #EDEDED;
		    clear: both;
		    color: #999999;
		    margin-bottom: 10px;
		    padding: 5px;
		    width: 500px;
		}
	</style>

<?php
	header('Content-Type: text/html;charset=utf-8');
	require "conexion.php";
	require_once('../conexion/funciones_db.php');
	
	$usuario1 = new FuncionesDB();
	
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
		
	$valor = $_SESSION[$rol];
	
	if(isset($_REQUEST['addCirugia']))
	{
		//recuperar las variables
		#$id=$_POST['id'];
		$fecha=$_POST['fecha'];
		//$hora=$_POST['hora'];
		
		$tipoCir=$_POST['tipoCir'];
		$costeador=$_POST['costeador'];
		$sala=$_POST['sala'];
		/*$tiempoHr=$_POST['tiempoHr'];
		$tiempoMin=$_POST['tiempoMin'];*/
		//$autorizo=utf8_decode($_POST['autorizo']);
		//$descorcheTxt=$_POST['descorcheTxt'];
		
		if(isset ($_POST['transope'])){
			$transope= $_POST['transope'];
		}else {
			$transope= NULL;
		}
		
		//$patologo=$_POST['patologo'];
		//$tamano=$_POST['tamano'];
		//$telCirujano=$_POST['telCirujano'];
		//$emailCirujano=$_POST['emailCirujano'];
		//$instrumentista=$_POST['instrumentista'];
		
		//$enfermera=utf8_decode($_POST['enfermera']);
		$nombre=$_POST['nombrePaciente'];
		$edad=$_POST['edad'];
		//$diagnostico=$_POST['diagnostico'];
		//$cirugia=$_POST['cirugia'];
		//$instrumental=$_POST['instrumental'];
		//$equipo=$_POST['equipo'];
		//$descorche=$_POST['descorche'];
		//$imagen=$_POST['imagen'];
		//$sangre=$_POST['sangre'];
		//$patologias=$_POST['patologias'];
		$cirujano=$_POST['cirujano'];
		//$ayudante=$_POST['ayudante'];
		//$pediatra=$_POST['pediatra'];
		//$anestesiologo=$_POST['anestesiologo'];
		//$nombrePrograma=$_POST['nombrePrograma'];
		//$telPrograma=$_POST['telPrograma'];
		//$emailPrograma=$_POST['emailPrograma'];
		//$confirma=$_POST['confirma'];
		/*if($confirma == 'SI'){
			$confirma = '1'; //Confirmada
		} else {
			$confirma = '2'; //NO confirmada
		}*/
		
		#vamos a recibir los datos de material o equipo especial
		/*if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = urldecode($_POST['ListaPro']); //decodifico el JSON
			//echo 'LLEGOOOO: '.$acturl;
			if($acturl == '[]'){
	        	$acturl = NULL;
	        }
	        $productos = json_decode($acturl, true);*/
        	//$separado1 = implode(",", $productos);
        	//var_dump($productos);
	        //echo 'FINAL1: '.$separado1;
	        /*foreach ($productos  as $pro) {
	        	echo ' DENTRO: '.$pro->idInst;
	            $misProductos = array('nombre['.$n++.']' => $pro->idInst);
	        }*/
       // }
        
        /*if(isset ($_POST['ListaPro2']) && $_POST['ListaPro2'] != NULL){
			$acturl2 = urldecode($_POST['ListaPro2']); //decodifico el JSON
			//echo 'LLEGOOOO2: '.$acturl2;
			if($acturl2 == '[]'){
	        	$acturl2 = NULL;
	        }
	        $productos2 = json_decode($acturl2, true);*/
        	//$separado2 = implode(",", $productos2);
        	//var_dump($productos2);
	        //echo 'FINAL2: '.$separado2;
	
	        /*foreach ($productos2  as $pro2) {
	        	echo ' DENTRO2: '.$pro2->cantidad;
	            $misProductos2 = array('cantidad['.$c++.']' => $pro2->cantidad);
	        }*/
        //}
		
		//Query para validar si no esta ocupada la Sala en la fecha y hora seleccionada
		require "eliminar/conexion.php";
		/*$sqlValida = "SELECT * FROM programaparto WHERE idSala='$sala' AND '$fecha'=fecha AND '$hora' BETWEEN hrInicio AND hrFin";
		$resultado=$mysqli->query($sqlValida);
		
		if($resultado->num_rows > 0){
				echo "<br/><strong><p class='autoStyle4'>LA SALA ESTA OCUPADA EN LA FECHA Y HORA SELECCIONADAS, FAVOR DE SELECCIONAR OTRA HORA U OTRA SALA </p></strong><br>";
		} else {*/
			//hacemos la sentencia de sql para guardar la cirugia
		$usr = 'Desconocido';
		if($rol == 'gdiaz'){
			$usr = 'Gabriela Díaz';
		}
		if($rol == 'jcastaneda'){
			$usr = 'Janeth Castañeda';
		}
			$sqlDN = "INSERT INTO datosnuevosparto (id,fecha,hora,enfermera,nombrePaciente,edad,diagnostico,cirugia,equipo,descorche,imagen,sangre,
						patologias, cirujano,ayudante, pediatra, anestesiologo, tipoDeCirugia, costeador, sala, tiempoHr, tiempoMin, autorizo,
						descorcheTxt, transPosOperatorio,patologo, tamano, telCirujano, emailCirujano, instrumentista, materialEsp, cantidadMaterialEsp,
						nombrePrograma,	telPrograma, correoPrograma, estatusCirugia)
				 VALUES (NULL,'$fecha','00:00','$usr','$nombre','$edad',NULL,'$tipoCir',NULL,NULL, NULL, NULL,NULL,'$cirujano', NULL,NULL,NULL,
				 '$tipoCir','$costeador', '$sala', NULL,NULL, NULL,NULL, '$transope',NULL, NULL, NULL, NULL,NULL, NULL, NULL,NULL,NULL, NULL, '1')";
		
			//ejecutamos la sentencia de sqlDN
			if ($conn->query($sqlDN)==true) {
				#Sacamos el id anteriormente guardado
				$sqlMax = "SELECT MAX(id) AS maximo FROM datosnuevosparto LIMIT 1";
				
				$resultadoMax=$mysqli->query($sqlMax);
				while($row=$resultadoMax->fetch_assoc()){
					$idCirugia = $row['maximo'];
					#echo $sqlMax."<br>";
					#echo "idCirugia: ".$idCirugia."<br>";
				}
				//Guardamos el dato del urs que programo la cirugia
				$sqlExtra = "INSERT INTO extrasparto (id,  usrAlta, idcirugia)
				 VALUES (NULL, '$rol', '$idCirugia')";
				//ejecutamos la sentencia de sqlExtra
				if ($conn->query($sqlExtra)==true) {
					echo '<br><strong>!!!! SE INSERTARON LOS DATOS EXTRA CORRECTAMENTE !!!!</strong><br>';
					$sqlMaxExt = "SELECT MAX(id) AS maximo FROM extrasparto LIMIT 1";
				
					$resultadoMaxExt=$mysqli->query($sqlMaxExt);
					while($row=$resultadoMaxExt->fetch_assoc()){
						$idExtr = $row['maximo'];
					}
					$sqlDNExt = "UPDATE datosnuevosparto SET datosExtra='$idExtr' WHERE id='$idCirugia'";
					$resultadoExt=$mysqli->query($sqlDNExt);
						if($resultadoExt > 0){
							echo " <br><strong>Se actualizo dato Extra de Cirugía correctamente </strong>";
						} else {
							echo "<br><strong>Error al actualizar Dato Extra de Cirugía</strong> ";
						}
				} else {
					echo '<br><strong>!!!! ERROR AL INSERTAR LOS DATOS EXTRA !!!!</strong><br>';
				}
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LA CIRUGÍA CORRECTAMENTE !!!!</strong><br>';
			}else{
				echo '!!! Error Datos de Cirugía: '.$sqlDN.'<br>'.$conn->error;
			}$conn->close();
		//}
	}
?>
</head>
	<body style="background-image: url(../img/logoNew2Agua.jpg)">
		<div class="form" style="width: 900px">
			<div align="center"><img alt="logoHD" src="../img/logoNew2.jpg" width="200" height="200"></div>
			<div class="bg-info">
			<form action="" method="post">
				<p class="auto-style3">Registro de PARTOS</p>
				<p class="auto-style1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					FECHA*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</strong></p>
				
				<label for="fecha"><span class="auto-style2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				Fecha Probable de Parto</span></label>
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;
				
				<input class="box" type="date" name="fecha" required style="width: 148px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
				
				<!--input class="box" type="time" name="hora" required style="width: 136px"-->
				
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Lugar de la Operación*</p>
					<select class="form-control" id="sala" name="sala" style="width:230px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="QUIRÓFANO"> QUIRÓFANO </option>
				   		<option value="HABITACIÓN"> HABITACIÓN </option>
					</select>
				<!--a class="btn btn-info" href="salasDisp.php?rol=<?php #echo $rol ?>" target="_blank">Disponibilidad de Salas</a-->
				
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Tipo de Cirugía*</p>
					<select class="form-control" id="tipoCir" name="tipoCir" style="width:230px; height:40px" required >
						<option value=""> seleccionar </option>
				        <option value="CESÁREA">CESÁREA</option>
						<option value="PARTO NATURAL">PARTO NATURAL</option>
					</select>
				
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Costeador*</p>
					<select class="form-control" id="costeador" name="costeador" style="width:200px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="ASEGURADORA "> ASEGURADORA </option>
				   		<option value="PARTICULAR "> PARTICULAR </option>
						<option value="SE DESCONOCE "> SE DESCONOCE </option>
					</select>
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Nombre del Paciente*</p>
				<input class="form-control" type="text" name="nombrePaciente" placeholder="Nombre y Apellidos" autocomplete="off" required>
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Edad del Paciente(Opcional)</p>
				<input class="form-control" type="number" name="edad" style="width: 60px" autocomplete="off">
				<div class="form-group">
					&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Médico Tratante*</p>
					<input class="form-control" id="cirujano" type="text" name="cirujano" accept-charset="utf-8" placeholder="Nombre y Apellidos" autocomplete="off" required>
					<br>
						<!--div id="suggestions1"></div-->
				</div>
				<br>
				<!--input type="hidden" id="ListaPro" name="ListaPro" value="" >
				<input type="hidden" id="ListaPro2" name="ListaPro2" value="" -->
				<input type="hidden" name="rol" value="<?php echo $rol ?>" >
				<input class="btn btn-success" onclick="creaArr();" type="submit" name="addCirugia" value="Guardar Información" >
				<br>
				<br>
			</form>
			</div>
		<br>
		<br>
		<a class="btn btn-primary" style="width: 187px; height: 44px" href="../partos/eliminar/index.php?rol=<?php echo $rol ?>" target="_blank">Modificar/Cancelar Parto</a>
		<br>
		<br>
		<?php 
		if( $valor == 'administrador'){
			echo '<p class="auto-style5" > <input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 137px; height: 44px" /></p>'; 
		} else if( $rol == 'gdiaz'|| $rol == 'jcastaneda'){
			echo '<p class="auto-style5" ><a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 60px" > REGRESAR </a></p>';
		}else{
			echo '<p class="auto-style5" > <input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" /></p>';
		}
	?>
		</div>
	</body>
</html>