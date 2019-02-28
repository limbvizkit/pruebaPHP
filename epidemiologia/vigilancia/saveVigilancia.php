<?php
require_once('../../conexion/configEpidemio.php');

	if (isset($_POST['idVig']))
	{
		$idVig  = $_POST["idVig"];
	} else {
		$idVig = '';
	}

	if (isset($_POST['fechaV']))
	{
		$fechaV  = $_POST["fechaV"];
	} else {
		$fechaV = '';
	}

	if (isset($_POST['horaV']))
	{
		$horaV  = $_POST["horaV"];
	} else {
		$horaV = '';
	}

	if (isset($_POST['meta']))
	{
		$meta  = $_POST["meta"];
	} else {
		$meta = '';
	}

	if (isset($_POST['vigRPBI']))
	{
		$vigRPBI   = utf8_decode($_POST["vigRPBI"]);
	} else {
		$vigRPBI  = '';
	}

	if (isset($_POST['inmuno']))
	{
		$inmuno  = utf8_decode($_POST["inmuno"]);
	} else {
		$inmuno = '';
	}

	if (isset($_POST['comor']))
	{
		$comor  = utf8_decode($_POST["comor"]);
	} else {
		$comor = '';
	}

	if (isset($_POST['aisla']))
	{
		$aisla  = utf8_decode($_POST["aisla"]);
	} else {
		$aisla = '';
	}

	if (isset($_POST['padAct']))
	{
		$padAct  = utf8_decode($_POST["padAct"]);
	} else {
		$padAct = '';
	}

	if (isset($_POST['notas']))
	{
		$notas  = utf8_decode($_POST["notas"]);
	} else {
		$notas = '';
	}
	
	if(!empty($fechaV)){
		$queryUpdVig = "UPDATE vigilanciacapacitacion SET metaInternacional = '$meta', vigilanciaRPBI='$vigRPBI', fechaVisita='$fechaV', 
							horaVisita = '$horaV', inmunocomprometido = '$inmuno', comorbilidad='$comor', aislamiento = '$aisla',
							padecimientoAct = '$padAct', notas = '$notas'
							WHERE id='$idVig'";
		$result0 = mysqli_query($conexionEpidemio, $queryUpdVig) or die (mysqli_error($conexionEpidemio));
			
		if(!$result0){
			echo'0';
			//echo $queryUpdVig;
		} else {
			echo '1';
			//echo $queryUpdVig;
		}
	} else {
		echo '0';
		return false;
	}
?>
