<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idNotaUrg']))
	{
		$idNotaUrg  = $_POST["idNotaUrg"];
	} else {
		$idNotaUrg = '';
	}

	if (isset($_POST['hora']))
	{
		$hora  = $_POST["hora"];
	} else {
		$hora = '';
	}

	if (isset($_POST['antece']))
	{
		$antece  = utf8_decode($_POST["antece"]);
		$antece=addslashes($antece);
	} else {
		$antece = '';
	}

	/*if (isset($_POST['tratam1']))
	{
		$tratam1  = utf8_decode($_POST["tratam1"]);
	} else {
		$tratam1 = '';
	}*/

	if (isset($_POST['inter']))
	{
		$inter  = utf8_decode($_POST["inter"]);
		$inter=addslashes($inter);
	} else {
		$inter = '';
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
	if (isset($_POST['ta']))
	{
		$ta  = $_POST["ta"];
	} else {
		$ta = '';
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
	if (isset($_POST['habEx']))
	{
		$habEx  = utf8_decode($_POST["habEx"]);
		$habEx=addslashes($habEx);
	} else {
		$habEx = '';
	}
	if (isset($_POST['cabez']))
	{
		$cabez  = utf8_decode($_POST["cabez"]);
		$cabez=addslashes($cabez);
	} else {
		$cabez = '';
	}
	if (isset($_POST['torax']))
	{
		$torax  = utf8_decode($_POST["torax"]);
		$torax=addslashes($torax);
	} else {
		$torax = '';
	}
	if (isset($_POST['abdom']))
	{
		$abdom  = utf8_decode($_POST["abdom"]);
		$abdom=addslashes($abdom);
	} else {
		$abdom = '';
	}
	if (isset($_POST['extrm']))
	{
		$extrm  = utf8_decode($_POST["extrm"]);
		$extrm=addslashes($extrm);
	} else {
		$extrm = '';
	}
	if (isset($_POST['resEst']))
	{
		$resEst  = utf8_decode($_POST["resEst"]);
		$resEst=addslashes($resEst);
	} else {
		$resEst = '';
	}
	if (isset($_POST['diagn']))
	{
		$diagn=addslashes($_POST["diagn"]);
		$diagn  = utf8_decode($diagn);
		
	} else {
		$diagn = '';
	}
	if (isset($_POST['tratam2']))
	{
		$tratam2  = utf8_decode($_POST["tratam2"]);
		$tratam2=addslashes($tratam2);
	} else {
		$tratam2 = '';
	}
	if (isset($_POST['pronosticoVida']))
	{
		$pronosticoVida  = $_POST["pronosticoVida"];
	} else {
		$pronosticoVida = '';
	}
	if (isset($_POST['pronosticoFuncion']))
	{
		$pronosticoFuncion  = $_POST["pronosticoFuncion"];
	} else {
		$pronosticoFuncion = '';
	}
	if (isset($_POST['horaFin']))
	{
		$horaFin  = $_POST["horaFin"];
	} else {
		$horaFin = '';
	}
	if (isset($_POST['cedula']))
	{
		$cedula  = $_POST["cedula"];
	} else {
		$cedula = '';
	}
	
	if(!empty($idNotaUrg)){
		$queryUpdDNotaUrg = "UPDATE notaurg SET hora='$hora', antecedentes='$antece', interrogatorio='$inter', fc='$fc', fr='$fr',
		ta='$ta', temp='$temp', so='$so', glucosa='$glucosa', habExt='$habEx', cabeza='$cabez', torax='$torax', abdomen='$abdom',
		extremidades='$extrm', diag='$diagn', resEst='$resEst', tratamientoFin='$tratam2', pronosticoVida='$pronosticoVida',
		pronosticoFuncion='$pronosticoFuncion', horaFin='$horaFin', cedula='$cedula' WHERE id='$idNotaUrg'";
		
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
