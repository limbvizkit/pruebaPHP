<?php
require_once('../conexion/configEpidemio.php');

	if (isset($_POST['idTemp']))
	{
		$idTemp  = $_POST["idTemp"];
	} else {
		$idTemp = '';
	}

	if (isset($_POST['fechaM']))
	{
		$fechaM  = $_POST["fechaM"];
	} else {
		$fechaM = '';
	}

	if (isset($_POST['horaM']))
	{
		$horaM  = $_POST["horaM"];
	} else {
		$horaM = '';
	}

	if (isset($_POST['temperatura']))
	{
		$temperatura  = $_POST["temperatura"];
	} else {
		$temperatura = '';
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
	
	if(!empty($temperatura)){
		$queryUpdDTemp = "UPDATE pacientetemperatura SET verificador = '$verif', fechaMedicion='$fechaM', horaMedicion = '$horaM', 
						  temperatura = '$temperatura', observaciones='$observaciones' WHERE id='$idTemp'";
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
