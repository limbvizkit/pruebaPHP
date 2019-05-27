<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idEvAdverso']))
	{
		$idEvAdverso = $_POST["idEvAdverso"];
	} else {
		$idEvAdverso = '';
	}
	if (isset($_POST['fecha']))
	{
		$fecha   = $_POST["fecha"];
	} else {
		$fecha  = '';
	}
	if (isset($_POST['paciente']))
	{
		$paciente = utf8_decode($_POST["paciente"]);
		$paciente=addslashes($paciente);
	} else {
		$paciente = '';
	}
	if (isset($_POST['servicio']))
	{
		$servicio = utf8_decode($_POST["servicio"]);
		$servicio=addslashes($servicio);
	} else {
		$servicio = '';
	}
	if (isset($_POST['evento']))
	{
		$evento = utf8_decode($_POST["evento"]);
		$evento=addslashes($evento);
	} else {
		$evento = '';
	}
	if (isset($_POST['turno']))
	{
		$turno  = $_POST["turno"];
	} else {
		$turno = '';
	}
	if (isset($_POST['servicioTxt']))
	{
		$servicioTxt = utf8_decode($_POST["servicioTxt"]);
		$servicioTxt =addslashes($servicioTxt);
	} else {
		$servicioTxt = '';
	}
	if (isset($_POST['tipoEvento']))
	{
		$tipoEvento = utf8_decode($_POST["tipoEvento"]);
	} else {
		$tipoEvento = '';
	}
	if (isset($_POST['habitacion']))
	{
		$habitacion = utf8_decode($_POST["habitacion"]);
		$habitacion =addslashes($habitacion);
	} else {
		$habitacion = '';
	}
	if (isset($_POST['nacimientoPaciente']))
	{
		$nacimientoPaciente = utf8_decode($_POST["nacimientoPaciente"]);
		$nacimientoPaciente =addslashes($nacimientoPaciente);
	} else {
		$nacimientoPaciente = '';
	}
	if (isset($_POST['fechaOcurrio']))
	{
		$fechaOcurrio = $_POST["fechaOcurrio"];
	} else {
		$fechaOcurrio = '';
	}
	
	if(!empty($idEvAdverso)){
		$queryUpdEvAdv = "UPDATE eventoadverso SET fecha='$fecha',turno='$turno',paciente='$paciente',servicio='$servicio',servicioTxt='$servicioTxt',tipoEvento='$tipoEvento',habitacion='$habitacion',evento='$evento',
		nacimientoPaciente='$nacimientoPaciente',fechaOcurrio='$fechaOcurrio'WHERE id='$idEvAdverso'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdEvAdv) or die (mysqli_error($conexionMedico));
			
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
