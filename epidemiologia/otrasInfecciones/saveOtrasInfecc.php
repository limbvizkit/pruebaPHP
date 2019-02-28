<?php
require_once('../../conexion/configEpidemio.php');

	if (isset($_POST['idOtrasInfecc']))
	{
		$idOtrasInfecc  = $_POST["idOtrasInfecc"];
	} else {
		$idOtrasInfecc = '';
	}

	if (isset($_POST['infeccion']))
	{
		$infeccion  = utf8_decode($_POST["infeccion"]);
	} else {
		$infeccion = '';
	}

	if (isset($_POST['fechaIni']))
	{
		$fechaIni  = $_POST["fechaIni"];
	} else {
		$fechaIni = '';
	}

	if (isset($_POST['fechaObs']))
	{
		$fechaObs  = $_POST["fechaObs"];
	} else {
		$fechaObs = '';
	}

	if (isset($_POST['fechaFin']))
	{
		$fechaFin  = $_POST["fechaFin"];
	} else {
		$fechaFin = '';
	}

	if (isset($_POST['verif']))
	{
		$verif  = utf8_decode($_POST["verif"]);
	} else {
		$verif = '';
	}

	if (isset($_POST['observaciones']))
	{
		$observaciones  = utf8_decode($_POST["observaciones"]);
	} else {
		$observaciones = '';
	}
	
	if(!empty($infeccion)){
		$queryUpdOtrInf = "UPDATE pacienteotrasinfecciones SET verificador = '$verif', infeccion='$infeccion', fechaInicio='$fechaIni', 
							fechaObservacion = '$fechaObs', fechaTermino = '$fechaFin', observaciones='$observaciones' WHERE id='$idOtrasInfecc'";
		$result0 = mysqli_query($conexionEpidemio, $queryUpdOtrInf) or die (mysqli_error($conexionEpidemio));
			
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
