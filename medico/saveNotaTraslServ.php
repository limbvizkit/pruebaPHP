<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idNotaTraslServ']))
	{
		$idNotaTraslServ  = $_POST["idNotaTraslServ"];
	} else {
		$idNotaTraslServ = '';
	}

	if (isset($_POST['horaFin']))
	{
		$horaFin  = $_POST["horaFin"];
	} else {
		$horaFin = '';
	}

	if (isset($_POST['fechaFin']))
	{
		$fechaFin  = $_POST["fechaFin"];
	} else {
		$fechaFin = '';
	}

	if (isset($_POST['motivoTransferencia']))
	{
		$motivoTransferencia  = utf8_decode($_POST["motivoTransferencia"]);
		$motivoTransferencia=addslashes($motivoTransferencia);
	} else {
		$motivoTransferencia = '';
	}

	if (isset($_POST['servicioActual']))
	{
		$servicioActual  = utf8_decode($_POST["servicioActual"]);
		$servicioActual=addslashes($servicioActual);
	} else {
		$servicioActual = '';
	}

	if (isset($_POST['servicioTraslada']))
	{
		$servicioTraslada  = utf8_decode($_POST["servicioTraslada"]);
		$servicioTraslada=addslashes($servicioTraslada);
	} else {
		$servicioTraslada = '';
	}

	if (isset($_POST['turno']))
	{
		$turno  = $_POST["turno"];
	} else {
		$turno = '';
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

	if (isset($_POST['interrogatorio']))
	{
		$interrogatorio  = utf8_decode($_POST["interrogatorio"]);
		$interrogatorio=addslashes($interrogatorio);
	} else {
		$interrogatorio = '';
	}
	
	if (isset($_POST['expFisica']))
	{
		$expFisica  = utf8_decode($_POST["expFisica"]);
		$expFisica=addslashes($expFisica);
	} else {
		$expFisica = '';
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
	
	if (isset($_POST['estudiosGabyLab']))
	{
		$estudiosGabyLab=addslashes($_POST["estudiosGabyLab"]);
		$estudiosGabyLab  = utf8_decode($estudiosGabyLab);
		
	} else {
		$estudiosGabyLab = '';
	}
	
	if (isset($_POST['terapeuticayProcedimientos']))
	{
		$terapeuticayProcedimientos=addslashes($_POST["terapeuticayProcedimientos"]);
		$terapeuticayProcedimientos  = utf8_decode($terapeuticayProcedimientos);
		
	} else {
		$terapeuticayProcedimientos = '';
	}
	
	if (isset($_POST['cedula']))
	{
		$cedula  = $_POST["cedula"];
	} else {
		$cedula = '';
	}
	
	if(!empty($idNotaTraslServ)){
		$queryUpdDNotaTS = "UPDATE notaTrasladoServ SET hora='$horaFin', fecha='$fechaFin',motivoTransferencia='$motivoTransferencia',
		servicioActual='$servicioActual',servicioTraslada='$servicioTraslada',turno='$turno',fc='$fc',fr='$fr',ta='$ta',temp='$temp',peso='$peso',
		talla='$talla',interrogatorio='$interrogatorio',expFisica='$expFisica',estudiosGabyLab='$estudiosGabyLab',terapeuticayProcedimientos='$terapeuticayProcedimientos',cedula='$cedula'
		WHERE id='$idNotaTraslServ'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdDNotaTS) or die (mysqli_error($conexionMedico));
			
		if(!$result0){
			echo'0';
			echo $queryUpdDNotaTS;
		} else {
			echo '1';
			//echo $queryUpdDNotaTS;
		}
	} else {
		echo '0';
		return false;
	}
?>
