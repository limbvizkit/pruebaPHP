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

if (isset($_POST['idNotaEvoh']))
	{
		$idNotaEvoh  = $_POST["idNotaEvoh"];

	if(!empty($idNotaEvoh)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelEvolucion = "UPDATE notaEvolucionh SET estatus='0' WHERE id='$idNotaEvoh'";
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

if (isset($_POST['idNotaTraslServh']))
	{
		$idNotaTraslServh  = $_POST["idNotaTraslServh"];

	if(!empty($idNotaTraslServh)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelEvolucion = "UPDATE notaTrasladoServh SET estatus='0' WHERE id='$idNotaTraslServh'";
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

if (isset($_POST['idNotaRefTraslh']))
	{
		$idNotaRefTraslh  = $_POST["idNotaRefTraslh"];

	if(!empty($idNotaRefTraslh)){
		//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
		$queryDelEvolucion = "UPDATE notareferenciatras SET estatus='0' WHERE id='$idNotaRefTraslh'";
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

if (isset($_POST['idNotaPreopeH']))
	{
		$idNotaPreopeH  = $_POST["idNotaPreopeH"];

		if(!empty($idNotaPreopeH)){
			//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
			$queryDelEvolucion = "UPDATE notapreoperatoria SET estatus='0' WHERE id='$idNotaPreopeH'";
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

if (isset($_POST['idHistClin']))
	{
		$idHistClin  = $_POST["idHistClin"];

		if(!empty($idHistClin)){
			//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
			$queryDelHistClin = "UPDATE historiaclinica SET estatus='0' WHERE id='$idHistClin'";
			$result0 = mysqli_query($conexionMedico, $queryDelHistClin) or die (mysqli_error($conexionMedico));
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

if (isset($_POST['idNotaIngreso']))
	{
		$idNotaIngreso  = $_POST["idNotaIngreso"];

		if(!empty($idNotaIngreso)){
			//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
			$queryDelNotaIngreso = "UPDATE notaingreso SET estatus='0' WHERE id='$idNotaIngreso'";
			$result0 = mysqli_query($conexionMedico, $queryDelNotaIngreso) or die (mysqli_error($conexionMedico));
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

if (isset($_POST['idNotaEgreso']))
	{
		$idNotaEgreso  = $_POST["idNotaEgreso"];

		if(!empty($idNotaEgreso)){
			//$queryDelNotaMedT = "DELETE FROM notaurgtriage WHERE id='$idNotaUrgT'";
			$queryDelNotaIngreso = "UPDATE notaegreso SET estatus='0' WHERE id='$idNotaEgreso'";
			$result0 = mysqli_query($conexionMedico, $queryDelNotaIngreso) or die (mysqli_error($conexionMedico));
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