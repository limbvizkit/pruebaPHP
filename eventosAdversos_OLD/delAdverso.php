<?php
	require_once('../conexion/configMedico.php');

	if (isset($_POST['idEvAdverso'])){

		$idEvAdverso  = $_POST["idEvAdverso"];

		if(!empty($idEvAdverso)){
			//$queryDelNotaMed = "DELETE FROM notaurg WHERE id='$idNotaUrg'";
			$queryDelNotaMed = "UPDATE eventoadverso SET estatus='0' WHERE id='$idEvAdverso'";
				$result0 = mysqli_query($conexionMedico, $queryDelNotaMed) or die (mysqli_error($conexionMedico));			
				if(!$result0){
					echo'0';
				} else {
					echo '1';
				}
		} else {
			echo "0";
			return false;
		}
	}

?>
