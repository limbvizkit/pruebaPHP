<?php
	require_once('conexion/configRepo.php');

	if (isset($_POST['idMaterial']))
	{
		$idMaterial = $_POST["idMaterial"];
	} else {
		$idMaterial = '';
	}
	if (isset($_POST['idResguardo']))
	{
		$idResguardo = $_POST["idResguardo"];
	} else {
		$idResguardo = '';
	}
	if (isset($_POST['fecha']))
	{
		$fecha   = $_POST["fecha"];
	} else {
		$fecha  = '';
	}
	if (isset($_POST['cantidad']))
	{
		$cantidad   = $_POST["cantidad"];
	} else {
		$cantidad  = '';
	}
	if (isset($_POST['unidad']))
	{
		$unidad = utf8_decode($_POST["unidad"]);
		$unidad=addslashes($unidad);
	} else {
		$unidad = '';
	}
	if (isset($_POST['tipoActivo']))
	{
		$tipoActivo = utf8_decode($_POST["tipoActivo"]);
		$tipoActivo=addslashes($tipoActivo);
	} else {
		$tipoActivo = '';
	}
	if (isset($_POST['marca']))
	{
		$marca = utf8_decode($_POST["marca"]);
		$marca=addslashes($marca);
	} else {
		$marca = '';
	}
	if (isset($_POST['modelo']))
	{
		$modelo = utf8_decode($_POST["modelo"]);
		$modelo=addslashes($modelo);
	} else {
		$modelo = '';
	}
	if (isset($_POST['numSerie']))
	{
		$numSerie = $_POST["numSerie"];
	} else {
		$numSerie = '';
	}
	if (isset($_POST['descActivo']))
	{
		$descActivo = utf8_decode($_POST["descActivo"]);
		$descActivo=addslashes($descActivo);
	} else {
		$descActivo = '';
	}
	if (isset($_POST['area']))
	{
		$area = utf8_decode($_POST["area"]);
		$area=addslashes($area);
	} else {
		$area = '';
	}
	if (isset($_POST['entrego']))
	{
		$entrego = utf8_decode($_POST["entrego"]);
		$entrego=addslashes($entrego);
	} else {
		$entrego = '';
	}
	if (isset($_POST['recibe']))
	{
		$recibe = utf8_decode($_POST["recibe"]);
		$recibe=addslashes($recibe);
	} else {
		$recibe = '';
	}
	if (isset($_POST['cargo']))
	{
		$cargo = utf8_decode($_POST["cargo"]);
		$cargo=addslashes($cargo);
	} else {
		$cargo = '';
	}
	if (isset($_POST['observaciones']))
	{
		$observaciones = utf8_decode($_POST["observaciones"]);
		$observaciones=addslashes($observaciones);
	} else {
		$observaciones = '';
	}

	if(!empty($idResguardo)){
		$queryUpdEvAdv = "UPDATE resguardosrh SET area='$area',entrega='$entrego',recibe='$recibe',cargo='$cargo',observaciones='$observaciones'
							WHERE idResguardo='$idResguardo'";
		$result0 = mysqli_query($conexion, $queryUpdEvAdv) or die (mysqli_error($conexion));
		
		if(!empty($idMaterial)){
			$queryUpdEvAdv = "UPDATE materiaresguardorh SET cantidad='$cantidad',unidad='$unidad',tipoActivo='$tipoActivo',descActivo='$descActivo',
									numSerie='$numSerie',marca='$marca',modelo='$modelo'
							WHERE idResguardo='$idResguardo' AND idMaterial='$idMaterial'";
			$result0 = mysqli_query($conexion, $queryUpdEvAdv) or die (mysqli_error($conexion));
		}
			
		if(!$result0){
			echo'0';
			echo $queryUpdEvAdv;
		} else {
			echo '1';
			//echo $queryUpdDNotaRT;
		}
	} else {
		echo '0';
		return false;
	}

?>