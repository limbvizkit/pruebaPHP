<?php
require_once('../conexion/configEpidemio.php');

if (isset($_POST['idTemp']))
	{
		$idTemp  = $_POST["idTemp"];
	} else {
		$idTemp = '';
	}


	if(!empty($idTemp)){
		$queryDelTemp = "DELETE FROM pacientetemperatura WHERE id='$idTemp'";
			$result0 = mysqli_query($conexionEpidemio, $queryDelTemp) or die (mysqli_error($conexionEpidemio));			
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