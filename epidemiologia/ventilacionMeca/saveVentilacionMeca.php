<?php
require_once('../../conexion/configEpidemio.php');

	if (isset($_POST['idVM']))
	{
		$idVM = $_POST["idVM"];
	} else {
		$idVM = '';
	}

	if (isset($_POST['fechaInst']))
	{
		$fechaInst = $_POST["fechaInst"];
	} else {
		$fechaInst = '';
	}

	if (isset($_POST['fechaFin']))
	{
		$fechaFin = $_POST["fechaFin"];
	} else {
		$fechaFin = '';
	}

	if (isset($_POST['nombreInstalo']))
	{
		$nombreInstalo  = utf8_decode($_POST["nombreInstalo"]);
	} else {
		$nombreInstalo = '';
	}

	if (isset($_POST['verificador']))
	{
		$verificador  = utf8_decode($_POST["verificador"]);
	} else {
		$verificador = '';
	}

	if (isset($_POST['observaciones']))
	{
		$observaciones  = utf8_decode($_POST["observaciones"]);
	} else {
		$observaciones = '';
	}
	
	if(!empty($idVM)){
		$queryUpdDTemp = "UPDATE instalacionvm SET fechaInst = '$fechaInst', fechaFin='$fechaFin', observaciones = '$observaciones' WHERE id='$idVM'";
			$result0 = mysqli_query($conexionEpidemio, $queryUpdDTemp) or die (mysqli_error($conexionEpidemio));
			
		if(!$result0){
			echo'0';
		} else {
			echo '1';
		}
	} else {
		echo '0';
		return false;
	}
?>
