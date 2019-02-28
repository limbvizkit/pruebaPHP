<?php
require_once('../../conexion/configEpidemio.php');

if (isset($_POST['idOtrasInfecc']))
	{
		$idOtrasInfecc  = $_POST["idOtrasInfecc"];
	} else {
		$idOtrasInfecc = '';
	}


	if(!empty($idOtrasInfecc)){
		$queryDelOtrasInfecc = "DELETE FROM pacienteotrasinfecciones WHERE id='$idOtrasInfecc'";
			$result0 = mysqli_query($conexionEpidemio, $queryDelOtrasInfecc) or die (mysqli_error($conexionEpidemio));			
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