<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idNotaUrgT']))
	{
		$idNotaUrgT  = $_POST["idNotaUrgT"];
	} else {
		$idNotaUrgT = '';
	}
	if (isset($_POST['fecha']))
	{
		$fecha  = $_POST["fecha"];
	} else {
		$fecha = '';
	}

	if (isset($_POST['hora']))
	{
		$hora  = $_POST["hora"];
	} else {
		$hora = '';
	}

	if (isset($_POST['turno']))
	{
		$turno  = $_POST["turno"];
	} else {
		$turno = '';
	}

	if (isset($_POST['acude']))
	{
		$acude  = $_POST["acude"];
	} else {
		$acude = '';
	}

	if (isset($_POST['motivo']))
	{
		$motivo  = utf8_decode($_POST["motivo"]);
		$motivo=addslashes($motivo);
	} else {
		$motivo = '';
	}
	if (isset($_POST['ta']))
	{
		$ta  = $_POST["ta"];
	} else {
		$ta = '';
	}
	if (isset($_POST['fc']))
	{
		$fc  = $_POST["fc"];
	} else {
		$fc = '';
	}

	if (isset($_POST['fr']))
	{
		$fr  = $_POST["fr"];
	} else {
		$fr = '';
	}
	
	if (isset($_POST['temp']))
	{
		$temp  = $_POST["temp"];
	} else {
		$temp = '';
	}
	if (isset($_POST['so']))
	{
		$so  = $_POST["so"];
	} else {
		$so = '';
	}
	if (isset($_POST['glucosa']))
	{
		$glucosa  = $_POST["glucosa"];
	} else {
		$glucosa = '';
	}
	if (isset($_POST['peso']))
	{
		$peso  = $_POST["peso"];
	} else {
		$peso = '';
	}
	if (isset($_POST['talla']))
	{
		$talla  = $_POST["talla"];
	} else {
		$talla = '';
	}
	if (isset($_POST['color']))
	{
		$color  = $_POST["color"];
	} else {
		$color = '';
	}
	if (isset($_POST['horaFin']))
	{
		$horaFin  = $_POST["horaFin"];
	} else {
		$horaFin = '';
	}
	if (isset($_POST['realizo']))
	{
		$realizo  = utf8_decode($_POST["realizo"]);
		$realizo=addslashes($realizo);
	} else {
		$realizo = '';
	}
	
	
	if(!empty($idNotaUrgT)){
		$queryUpdDNotaUrg = "UPDATE notaurgtriage SET fecha='$fecha', hora='$hora', turno='$turno', acude='$acude', motivo='$motivo',ta='$ta',fc='$fc',
		fr='$fr',temp='$temp',so='$so', glucosa='$glucosa', peso='$peso', talla='$talla', color='$color',horaFin='$horaFin', realizo='$realizo' WHERE id='$idNotaUrgT'";
		$result0 = mysqli_query($conexionMedico, $queryUpdDNotaUrg) or die (mysqli_error($conexionMedico));
			
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
