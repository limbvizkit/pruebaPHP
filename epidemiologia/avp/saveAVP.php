<?php
require_once('../../conexion/configEpidemio.php');

	if (isset($_POST['idAVP']))
	{
		$idAVP  = $_POST["idAVP"];
	} else {
		$idAVP = '';
	}

	if (isset($_POST['fechaInstalacion']))
	{
		$fechaInstalacion  = $_POST["fechaInstalacion"];
	} else {
		$fechaInstalacion = '';
	}

	if (isset($_POST['fechaRetiro']))
	{
		$fechaRetiro  = $_POST["fechaRetiro"];
	} else {
		$fechaRetiro = '';
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
	
	if(!empty($idAVP)){
		$queryUpdDTemp = "UPDATE instalacionavp SET fechaInstalacion = '$fechaInstalacion', fechaFin='$fechaRetiro', observaciones = '$observaciones' WHERE id='$idAVP'";
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