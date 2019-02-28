<?php
require_once('../../conexion/configEpidemio.php');

if (isset($_POST['idVig']))
	{
		$idVig  = $_POST["idVig"];
	} else {
		$idVig = '';
	}


	if(!empty($idVig)){
		$queryDelVigilancia = "DELETE FROM vigilanciacapacitacion WHERE id='$idVig'";
			$result0 = mysqli_query($conexionEpidemio, $queryDelVigilancia) or die (mysqli_error($conexionEpidemio));			
			if(!$result0){
				echo'0';
			} else {
				echo '1';
			}
	} else {
		echo "0";
		return false;
	}

?>