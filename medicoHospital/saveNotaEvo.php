<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idNotaEvoh']))
	{
		$idNotaEvoh  = $_POST["idNotaEvoh"];
	} else {
		$idNotaEvoh = '';
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

	if (isset($_POST['evolucion']))
	{
		$evolucion  = utf8_decode($_POST["evolucion"]);
		$evolucion=addslashes($evolucion);
	} else {
		$evolucion = '';
	}

	if (isset($_POST['estudios']))
	{
		$estudios  = utf8_decode($_POST["estudios"]);
		$estudios=addslashes($estudios);
	} else {
		$estudios = '';
	}

	if (isset($_POST['tratamientoF']))
	{
		$tratamientoF  = utf8_decode($_POST["tratamientoF"]);
		$tratamientoF=addslashes($tratamientoF);
	} else {
		$tratamientoF = '';
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

	if (isset($_POST['expFisica']))
	{
		$expFisica  = utf8_decode($_POST["expFisica"]);
		$expFisica=addslashes($expFisica);
	} else {
		$expFisica = '';
	}
	
	if (isset($_POST['diagn']))
	{
		$diagn=addslashes($_POST["diagn"]);
		$diagn  = utf8_decode($diagn);
		
	} else {
		$diagn = '';
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
	
	if (isset($_POST['cedula']))
	{
		$cedula  = $_POST["cedula"];
	} else {
		$cedula = '';
	}
	if (isset($_POST['turno']))
	{
		$turno  = $_POST["turno"];
	} else {
		$turno = '';
	}

	if (isset($_POST['servicio']))
	{
		$servicio=addslashes($_POST["servicio"]);
		$servicio  = utf8_decode($servicio);
	} else {
		$servicio = '';
	}
	
	if(!empty($idNotaEvoh)){
		$queryUpdDNotaEvo = "UPDATE notaEvolucionh SET hora='$horaFin', fecha='$fechaFin',servicio='$servicio',turno='$turno',fc='$fc',fr='$fr',
		ta='$ta', temp='$temp', so='$so', glucosa='$glucosa',peso='$peso',talla='$talla',evolucion='$evolucion',expFisica='$expFisica',estudios='$estudios',diag='$diagn',tratamientoFin='$tratamientoF',
		pronosticoVida='$pronosticoVida',pronosticoFuncion='$pronosticoFuncion', cedula='$cedula' WHERE id='$idNotaEvoh'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdDNotaEvo) or die (mysqli_error($conexionMedico));
			
		if(!$result0){
			//echo'0';
			echo $queryUpdDNotaEvo;
		} else {
			echo '1';
			//echo $queryUpdDNotaEvo;
		}
	} else {
		echo '0';
		return false;
	}
?>
