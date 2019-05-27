<?php
require_once('../../conexion/configEpidemio.php');

	if (isset($_POST['idSV']))
	{
		$idSV = $_POST["idSV"];
	} else {
		$idSV = '';
	}

	if (isset($_POST['fechaProcedimiento']))
	{
		$fechaProcedimiento = $_POST["fechaProcedimiento"];
	} else {
		$fechaProcedimiento = '';
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
	
	if(!empty($idSV)){
		$queryUpdDTemp = "UPDATE instalacionsv SET fechaProcedimiento = '$fechaProcedimiento', fechaFin='$fechaFin', observaciones = '$observaciones' WHERE id='$idSV'";
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
