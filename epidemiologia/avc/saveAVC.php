<?php
require_once('../../conexion/configEpidemio.php');

	if (isset($_POST['idAVC']))
	{
		$idAVC  = $_POST["idAVC"];
	} else {
		$idAVC = '';
	}

	if (isset($_POST['fechaInst']))
	{
		$fechaInst  = $_POST["fechaInst"];
	} else {
		$fechaInst = '';
	}

	if (isset($_POST['fechaRetiro']))
	{
		$fechaRetiro  = $_POST["fechaRetiro"];
	} else {
		$fechaRetiro = '';
	}

	if (isset($_POST['nInstala']))
	{
		$nInstala  = $_POST["nInstala"];
	} else {
		$nInstala = '';
	}

	if (isset($_POST['complicacion']))
	{
		$complicacion  = utf8_decode($_POST["complicacion"]);
	} else {
		$complicacion = '';
	}

	if (isset($_POST['observaciones']))
	{
		$observaciones  = utf8_decode($_POST["observaciones"]);
	} else {
		$observaciones = '';
	}
	
	if(!empty($idAVC)){
		$queryUpdDTemp = "UPDATE instalacionlvc SET fechaInst = '$fechaInst', fechaRetiro='$fechaRetiro', observaciones = '$observaciones' WHERE id='$idAVC'";
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
