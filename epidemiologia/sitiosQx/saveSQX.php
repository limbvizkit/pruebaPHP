<?php
require_once('../../conexion/configEpidemio.php');

	if (isset($_POST['idSQ']))
	{
		$idSQ = $_POST["idSQ"];
	} else {
		$idSQ = '';
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
	
	if(!empty($idSQ)){
		$queryUpdDTemp = "UPDATE instalacionsq SET fechaInst = '$fechaInst', fechaFin='$fechaFin', observaciones = '$observaciones' WHERE id='$idSQ'";
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
