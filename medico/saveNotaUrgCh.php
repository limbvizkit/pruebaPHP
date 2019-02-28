<?php
require_once('../conexion/configMedico.php');

	$bhc=NULL;
	$qs=NULL;
	$tpt=NULL;
	$rx=NULL;
	$tac=NULL;
	$rm=NULL;
	$us=NULL;
	$diagn=NULL;
	$tratUtil=NULL;
	$tratUtilTxt=NULL;
	$interconsulta=NULL;

	if (isset($_POST['idNotaCh']))
	{
		$idNotaCh  = $_POST["idNotaCh"];
	} else {
		$idNotaCh = '';
	}

	if (isset($_POST['expediente']))
	{
		$expediente  = $_POST["expediente"];
	} else {
		$expediente = '';
	}

	if (isset($_POST['folio']))
	{
		$folio  = $_POST["folio"];
	} else {
		$folio = '';
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

	if (isset($_POST['antece']))
	{
		$antece  = utf8_decode($_POST["antece"]);
		$antece=addslashes($antece);
	} else {
		$antece = '';
	}

	if (isset($_POST['tratam']))
	{
		$tratam  = utf8_decode($_POST["tratam"]);
		$antece=addslashes($antece);
	} else {
		$tratam = '';
	}

	if (isset($_POST['inter']))
	{
		$inter  = utf8_decode($_POST["inter"]);
		$antece=addslashes($antece);
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
	if (isset($_POST['respOcul']))
	{
		$respOcul  = $_POST["respOcul"];
	} else {
		$respOcul = '';
	}
	if (isset($_POST['respVerb']))
	{
		$respVerb  = $_POST["respVerb"];
	} else {
		$respVerb = '';
	}
	if (isset($_POST['respMot']))
	{
		$respMot  = $_POST["respMot"];
	} else {
		$respMot = '';
	}

	$totalValNeu = $respOcul + $respVerb + $respMot;

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
	if (isset($_POST['bhc']))
	{
		$bhc=$_POST['bhc'];
	}
	if (isset($_POST['qs']))
	{
		$qs=utf8_decode($_POST['qs']);
		$qs=addslashes($qs);
	}
	if (isset($_POST['tpt']))
	{
		$tpt=utf8_decode($_POST['tpt']);
		$tpt=addslashes($tpt);
	}
	if (isset($_POST['rx']))
	{
		$rx=utf8_decode($_POST['rx']);
		$rx=addslashes($rx);
	}
	if (isset($_POST['tac']))
	{
		$tac=utf8_decode($_POST['tac']);
		$tac=addslashes($tac);
	}
	if (isset($_POST['rm']))
	{
		$rm=utf8_decode($_POST['rm']);
		$rm=addslashes($rm);
	}
	if (isset($_POST['us']))
	{
		$us=utf8_decode($_POST['us']);
		$us=addslashes($us);
	}
	if (isset($_POST['paraclin']))
	{
		$paraclin=utf8_decode($_POST['paraclin']);
		$paraclin=addslashes($paraclin);
	}
		#3
	if (isset($_POST['diagn']))
	{
		$diagn=utf8_decode($_POST['diagn']);
		$diagn=addslashes($diagn);
	}
	if (isset($_POST['tratUtil']))
	{
		$tratUtil=utf8_decode($_POST['tratUtil']);
		$tratUtil=addslashes($tratUtil);
	}
	if (isset($_POST['tratUtilTxt']))
	{
		$tratUtilTxt=utf8_decode($_POST['tratUtilTxt']);
		$tratUtilTxt=addslashes($tratUtilTxt);
	}
	if (isset($_POST['interconsulta']))
	{
		$interconsulta=utf8_decode($_POST['interconsulta']);
		$interconsulta=addslashes($interconsulta);
	}
	if (isset($_POST['horaSol']))
	{
		$horaSol=$_POST['horaSol'];
	}
	if (isset($_POST['especialidad']))
	{
		$especialidad=utf8_decode($_POST['especialidad']);
		$especialidad=addslashes($especialidad);
	}
	/*if (isset($_POST['horaAcud']))
	{
		$horaAcud=$_POST['horaAcud'];
	}*/
	if (isset($_POST['vida']))
	{
		$vida=$_POST['vida'];
	}
	if (isset($_POST['funcion']))
	{
		$funcion=$_POST['funcion'];
	}
	if (isset($_POST['ingresa']))
	{
		$ingresa=utf8_decode($_POST['ingresa']);
		$ingresa=addslashes($ingresa);
	}
	if (isset($_POST['cedula']))
	{
		$cedula=$_POST['cedula'];
	}
	
	if(!empty($idNotaCh)){
		$queryUpdDNotaUrgCh = "UPDATE notaurgchoque SET numeroExpediente='$expediente',folio='$folio',hora='$hora',acude='$acude',turno='$turno',
		antecedentes='$antece',tratamiento='$tratam',interrogatorio='$inter',fc='$fc',fr='$fr',ta='$ta',temp='$temp',so='$so',glucosa='$glucosa',
		respOcul='$respOcul',respVerb='$respVerb',respMot='$respMot', totalValNeu='$totalValNeu', habExt='$habEx', cabeza='$cabez',
		torax='$torax', abdomen='$abdom',extremidades='$extrm',bhc='$bhc', qs='$qs', tpt='$tpt', rx='$rx', tac='$tac', rm='$rm', us='$us',
		paraclin='$paraclin', diag='$diagn',tratUtil='$tratUtil',tratUtilTxt='$tratUtilTxt' ,interconsulta='$interconsulta', horaSol='$horaSol',
		especialidad='$especialidad',vida='$vida', funcion='$funcion', ingresa='$ingresa', cedula='$cedula' WHERE id='$idNotaCh'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdDNotaUrgCh) or die (mysqli_error($conexionMedico));
		
		if(!$result0){
			//echo $$queryUpdDNotaUrgCh;
			echo'0';
		} else {
			//echo $$queryUpdDNotaUrgCh;
			echo '1';
		}
	} else {
		echo '0';
		return false;
	}
?>
