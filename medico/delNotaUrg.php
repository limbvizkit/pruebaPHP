<?php
require_once('../conexion/configMedico.php');

if (isset($_POST['idNotaUrg'])){
	
	$idNotaUrg  = $_POST["idNotaUrg"];

	if(!empty($idNotaUrg)){
		//$queryDelNotaMed = "DELETE FROM notaurg WHERE id='$idNotaUrg'";
		$queryDelNotaMed = "UPDATE notaurg SET estatus='0' WHERE id='$idNotaUrg'";
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

if (isset($_POST['idNotaUrgT']))
	{
		$idNotaUrgT  = $_POST["idNotaUrgT"];

	if(!empty($idNotaUrgT)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelNotaMedT = "UPDATE notaurgtriage SET estatus='0' WHERE id='$idNotaUrgT'";
		$result0 = mysqli_query($conexionMedico, $queryDelNotaMedT) or die (mysqli_error($conexionMedico));			
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

if (isset($_POST['idNotaCh']))
	{
		$idNotaCh  = $_POST["idNotaCh"];

	if(!empty($idNotaCh)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelNotaMedCh = "UPDATE notaurgchoque SET estatus='0' WHERE id='$idNotaCh'";
		$result0 = mysqli_query($conexionMedico, $queryDelNotaMedCh) or die (mysqli_error($conexionMedico));			
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

if (isset($_POST['idIndicMed']))
	{
		$idIndicMed  = $_POST["idIndicMed"];

	if(!empty($idIndicMed)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelIndicacionMed = "UPDATE indicacionesmedicas SET estatus='0' WHERE id='$idIndicMed'";
		$result0 = mysqli_query($conexionMedico, $queryDelIndicacionMed) or die (mysqli_error($conexionMedico));			
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

if (isset($_POST['idNotaEvo']))
	{
		$idNotaEvo  = $_POST["idNotaEvo"];

	if(!empty($idNotaEvo)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelEvolucion = "UPDATE notaEvolucion SET estatus='0' WHERE id='$idNotaEvo'";
		$result0 = mysqli_query($conexionMedico, $queryDelEvolucion) or die (mysqli_error($conexionMedico));			
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

if (isset($_POST['idNotaTraslServ']))
	{
		$idNotaTraslServ  = $_POST["idNotaTraslServ"];

	if(!empty($idNotaTraslServ)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelEvolucion = "UPDATE notaTrasladoServ SET estatus='0' WHERE id='$idNotaTraslServ'";
		$result0 = mysqli_query($conexionMedico, $queryDelEvolucion) or die (mysqli_error($conexionMedico));			
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

if (isset($_POST['idNotaRefTrasl']))
	{
		$idNotaRefTrasl  = $_POST["idNotaRefTrasl"];

	if(!empty($idNotaRefTrasl)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelEvolucion = "UPDATE notareferenciatras SET estatus='0' WHERE id='$idNotaRefTrasl'";
		$result0 = mysqli_query($conexionMedico, $queryDelEvolucion) or die (mysqli_error($conexionMedico));
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
	if (isset($_POST['idReceta']))
	{
		$idReceta  = $_POST["idReceta"];

		if(!empty($idReceta)){
			//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
			$queryDelEvolucion = "UPDATE receta SET estatus='0' WHERE id='$idReceta'";
			$result0 = mysqli_query($conexionMedico, $queryDelEvolucion) or die (mysqli_error($conexionMedico));
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

if (isset($_POST['idNotaPreope']))
	{
		$idNotaPreope  = $_POST["idNotaPreope"];

		if(!empty($idNotaPreope)){
			//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
			$queryDelEvolucion = "UPDATE notapreoperatoriaurg SET estatus='0' WHERE id='$idNotaPreope'";
			$result0 = mysqli_query($conexionMedico, $queryDelEvolucion) or die (mysqli_error($conexionMedico));
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

if (isset($_POST['idImagenologia']))
	{
		$idImagenologia  = $_POST["idImagenologia"];

		if(!empty($idImagenologia)){
			//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
			$queryDelEvolucion = "UPDATE imagenologia SET estatus='0' WHERE id='$idImagenologia'";
			$result0 = mysqli_query($conexionMedico, $queryDelEvolucion) or die (mysqli_error($conexionMedico));
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