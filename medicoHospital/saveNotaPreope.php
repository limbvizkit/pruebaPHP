<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idNotaPreopeH']))
	{
		$idNotaPreopeH  = $_POST["idNotaPreopeH"];
	} else {
		$idNotaPreopeH = '';
	}

	if (isset($_POST['fechaFin']))
	{
		$fechaFin  = $_POST["fechaFin"];
	} else {
		$fechaFin = '';
	}

	if (isset($_POST['diagn']))
	{
		$diagn=addslashes($_POST["diagn"]);
		$diagn  = utf8_decode($diagn);
		
	} else {
		$diagn = '';
	}

	if (isset($_POST['planQui']))
	{
		$planQui  = utf8_decode($_POST["planQui"]);
		$planQui=addslashes($planQui);
	} else {
		$planQui = '';
	}

	if (isset($_POST['tipoInterQui']))
	{
		$tipoInterQui  = utf8_decode($_POST["tipoInterQui"]);
		$tipoInterQui=addslashes($tipoInterQui);
	} else {
		$tipoInterQui = '';
	}

	if (isset($_POST['riesgoQui']))
	{
		$riesgoQui  = utf8_decode($_POST["riesgoQui"]);
		$riesgoQui=addslashes($riesgoQui);
	} else {
		$riesgoQui = '';
	}

	if (isset($_POST['cuidadosTerap']))
	{
		$cuidadosTerap  = utf8_decode($_POST["cuidadosTerap"]);
		$cuidadosTerap=addslashes($cuidadosTerap);
	} else {
		$cuidadosTerap = '';
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

	if (isset($_POST['nomMedico']))
	{
		$nomMedico  = utf8_decode($_POST["nomMedico"]);
		$nomMedico=addslashes($nomMedico);
	} else {
		$nomMedico = '';
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
	
	if(!empty($idNotaPreopeH)){
		$queryUpdDNotaPreope = "UPDATE notapreoperatoria SET fecha='$fechaFin',servicio='$servicio',turno='$turno',diagnostico='$diagn',
		planQx='$planQui',tipoIntervencionQx='$tipoInterQui',riesgoQx='$riesgoQui',cuidadosTerapeuticos='$cuidadosTerap',pronosticoVida='$pronosticoVida',
		pronosticoFuncion='$pronosticoFuncion',nombreMedicoTratante='$nomMedico', cedula='$cedula' WHERE id='$idNotaPreopeH'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdDNotaPreope) or die (mysqli_error($conexionMedico));
			
		if(!$result0){
			//echo'0';
			echo $$queryUpdDNotaPreope;
		} else {
			echo '1';
			//echo $queryUpdDNotaPreope;
		}
	} else {
		echo '0';
		return false;
	}
?>
