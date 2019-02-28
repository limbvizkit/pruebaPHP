<?php
  	header('Content-Type: text/html;charset=UTF-8');
  	require_once('conexion/config.php');
  	
  	if(isset($_REQUEST['enviarMedicamento']))
	{
		if(isset ($_POST['expediente'])){
			$expediente = $_POST['expediente'];
		}else {
			$expediente = NULL;
		}
		
		if(isset ($_POST['folio'])){
			$folio = $_POST['folio'];
		}else {
			$folio = NULL;
		}
		
		if(isset ($_POST['nomPac'])){
			$nomPac = $_POST['nomPac'];
		}else {
			$nomPac = NULL;
		}
		
		if(isset ($_POST['tipoMed'])){
			$tipoMed= $_POST['tipoMed'];
		}else {
			$tipoMed= NULL;
		}

		if(isset ($_POST['idMed'])){
			$idMed = $_POST['idMed'];
			if($idMed == '' || idMed == NULL){
				$idMed = mt_rand();
			}
		}else {
			$idMed = mt_rand();
		}

		if(isset ($_POST['medicamento'])){
			$medicamento = $_POST['medicamento'];
			$medicamento = trim($medicamento);
		}else {
			$medicamento= NULL;
		}
		
		if(isset ($_POST['idSal'])){
			$idSal = $_POST['idSal'];
		}else {
			$idSal = NULL;
		}
		
		if(isset ($_POST['sal'])){
			$sal = $_POST['sal'];
			$sal = trim($sal);
		}else {
			$sal= NULL;
		}
		
		if(isset ($_POST['otro'])){
			$otro = utf8_decode($_POST['otro']);
		}else {
			$otro= NULL;
		}
		
		if(isset ($_POST['fechaIni'])){
			$fechaIni= $_POST['fechaIni'];
		}else {
			$fechaIni= NULL;
		}

		if(isset ($_POST['dosis'])){
			$dosis= $_POST['dosis'];
		}else {
			$dosis= NULL;
		}
		
		if(isset ($_POST['viadmon'])){
			$viadmon= $_POST['viadmon'];
		}else {
			$viadmon= NULL;
		}
		
		if(isset ($_POST['otroVia'])){
			$otraVia= utf8_decode($_POST['otroVia']);
		}else {
			$otraVia= NULL;
		}
		
		if(isset ($_POST['frecuencia'])){
			$frecuencia= $_POST['frecuencia'];
		}else {
			$frecuencia= NULL;
		}
		
		if(isset ($_POST['otroFrec'])){
			$otroFrec= utf8_decode($_POST['otroFrec']);
		}else {
			$otroFrec= NULL;
		}
		
		$queryExp ="SELECT COUNT(*) AS conteo FROM paciente WHERE numeroExpediente='$expediente'";
		$resultExp = mysqli_query($conexion, $queryExp);
	 	$conteo0 = mysqli_fetch_array($resultExp);
	 	$conteo = $conteo0['conteo'];
	 	
			$query = "INSERT INTO medpacientes (id, numeroExpediente, folio, tipoMedicamento, nombreOtroTipo, fechaInicio, idMedicamento, nombreMedicamento, idSal, sal,
							dosis, idViaAdmon, otraVia, frecuencia, otraFrecuencia,  idRevision)
						VALUES (NULL, '$expediente', '$folio', '$tipoMed', '$otro', '$fechaIni', '$idMed', '$medicamento', '$idSal', '$sal', '$dosis', '$viadmon', '$otraVia', '$frecuencia', '$otroFrec', NULL)";
			$result = mysqli_query($conexion, $query);
			if(!$result){
				echo'!!ERROR AL GUARDAR MEDICAMENTOS!!';
				echo 'Consulta con Error => '.$query;
			} else {
				echo '<br>!!!! SE GUARDARON LOS DATOS DEL MEDICAMENTO CORRECTAMENTE!!!!<br>';
				#echo echo "QUERY: ".$query;
			}
		mysqli_free_result($resultExp);
		mysqli_close($conexion);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>GuardaMedicamento</title>
</head>
<body>
	<?php 
	if($conteo != '0'){
		echo ' DATOS COLOCADOS PARA PACIENTE: '.$expediente.' '.$nomPac.
		#'<br> QUERY: '.$query.
		'<br> Folio: '.$folio.
		'<br> Tipo de Medicamento: '.$tipoMed.
		'<br> medicamento: '.$medicamento.
		'<br> NombreOTRO (Opcional): '.$otro.
		'<br> Dosis: '.$dosis.
		'<br> vía de Admon: '.$viadmon.
		'<br> Otra vía de Admon (Opcional): '.$otraVia.
		'<br> Frecuencia: '.$frecuencia.
		'<br> Otra Frecuencia (Opcional): '.$otroFrec.
		'<br> Fecha de Inicio: '.$fechaIni;
	} else {
		echo "<span style='color:red'>!!!! No existe Número de Expediente favor de dar de alta DATOS BÁSICOS !!!</span>";
	}
	#'<br> Hora de Consumo: '.$hrConsumo;
	#'<br><br> QUERY: '.$query;
	?>
	<input name="cerrar" type="button" onclick="window.close();" value="SALIR" />
</body>

</html>
