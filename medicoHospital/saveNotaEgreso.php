<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idNotaEgreso']))
	{
		$idNotaEgreso = $_POST["idNotaEgreso"];
	} else {
		$idNotaEgreso = '';
	}

	if (isset($_POST['hora']))
	{
		$hora  = $_POST["hora"];
	} else {
		$hora = '';
	}
	if (isset($_POST['diagnosticoIngreso']))
	{
		$diagnosticoIngreso = utf8_decode($_POST["diagnosticoIngreso"]);
		$diagnosticoIngreso = addslashes($diagnosticoIngreso);
	} else {
		$diagnosticoIngreso = '';
	}
	if (isset($_POST['diagnosticoEgreso']))
	{
		$diagnosticoEgreso = utf8_decode($_POST["diagnosticoEgreso"]);
		$diagnosticoEgreso = addslashes($diagnosticoEgreso);
	} else {
		$diagnosticoEgreso = '';
	}
	if (isset($_POST['motivoEgreso']))
	{
		$motivoEgreso = utf8_decode($_POST["motivoEgreso"]);
		$motivoEgreso = addslashes($motivoEgreso);
	} else {
		$motivoEgreso = '';
	}
	if (isset($_POST['resumenEvolucion']))
	{
		$resumenEvolucion = utf8_decode($_POST["resumenEvolucion"]);
		$resumenEvolucion = addslashes($resumenEvolucion);
	} else {
		$resumenEvolucion = '';
	}
	if (isset($_POST['manejoTratamiento']))
	{
		$manejoTratamiento = utf8_decode($_POST["manejoTratamiento"]);
		$manejoTratamiento = addslashes($manejoTratamiento);
	} else {
		$manejoTratamiento = '';
	}
	if (isset($_POST['problemasClinicos']))
	{
		$problemasClinicos = utf8_decode($_POST["problemasClinicos"]);
		$problemasClinicos = addslashes($problemasClinicos);
	} else {
		$problemasClinicos = '';
	}
	if (isset($_POST['recomendacionesVigilancia']))
	{
		$recomendacionesVigilancia = utf8_decode($_POST["recomendacionesVigilancia"]);
		$recomendacionesVigilancia = addslashes($recomendacionesVigilancia);
	} else {
		$recomendacionesVigilancia = '';
	}
	if (isset($_POST['tabaquismo']))
	{
		$tabaquismo  = $_POST["tabaquismo"];
	} else {
		$tabaquismo = '';
	}
	if (isset($_POST['alcohol']))
	{
		$alcohol = $_POST["alcohol"];
	} else {
		$alcohol = '';
	}
	if (isset($_POST['otras']))
	{
		$otras = $_POST["otras"];
	} else {
		$otras = '';
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
	if (isset($_POST['diagnosticos']))
	{
		$diagnosticos = utf8_decode($_POST["diagnosticos"]);
		$diagnosticos = addslashes($diagnosticos);
	} else {
		$diagnosticos = '';
	}
	if (isset($_POST['cedula']))
	{
		$cedula  = $_POST["cedula"];
	} else {
		$cedula = '';
	}
	if (isset($_POST['nombreMedicoTratante']))
	{
		$nombreMedicoTratante = utf8_decode($_POST["nombreMedicoTratante"]);
		$nombreMedicoTratante = addslashes($nombreMedicoTratante);
	} else {
		$nombreMedicoTratante = '';
	}
	

	if(!empty($idNotaEgreso)){
		$queryUpdNotaEgreso = "UPDATE notaegreso SET horaEgreso='$hora',diagnosticoIngreso='$diagnosticoIngreso',diagnosticoEgreso='$diagnosticoEgreso',motivoEgreso='$motivoEgreso',
			resumenEvolucion='$resumenEvolucion',manejoTratamiento='$manejoTratamiento',problemasClinicos='$problemasClinicos',recomendacionesVigilancia='$recomendacionesVigilancia',tabaquismo='$tabaquismo',
			alcohol='$alcohol',otras='$otras',pronosticoVida='$pronosticoVida',pronosticoFuncion='$pronosticoFuncion',diagnosticos='$diagnosticos',cedula='$cedula',nombreMedicoTratante='$nombreMedicoTratante'
			WHERE id='$idNotaEgreso'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdNotaEgreso) or die (mysqli_error($conexionMedico));
			
		if(!$result0){
			//echo'0';
			echo $queryUpdNotaEgreso;
		} else {
			echo '1';
			#echo $queryUpdNotaEgreso;
		}
	} else {
		echo '0';
		return false;
	}
?>
