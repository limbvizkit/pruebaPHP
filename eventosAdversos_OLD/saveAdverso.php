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
	if (isset($_POST['reporta']))
	{
		$reporta = utf8_decode($_POST["reporta"]);
		$reporta=addslashes($reporta);
	} else {
		$reporta = '';
	}
	if (isset($_POST['servicio']))
	{
		$servicio = utf8_decode($_POST["servicio"]);
		$servicio=addslashes($servicio);
	} else {
		$servicio = '';
	}
	if (isset($_POST['tipoEvento']))
	{
		$tipoEvento = utf8_decode($_POST["tipoEvento"]);
	} else {
		$tipoEvento = '';
	}
	if (isset($_POST['turno']))
	{
		$turno  = $_POST["turno"];
	} else {
		$turno = '';
	}
	if (isset($_POST['diag']))
	{
		$diag = utf8_decode($_POST["diag"]);
		$diag=addslashes($diag);
	} else {
		$diag = '';
	}
	if (isset($_POST['relacionado']))
	{
		$relacionado  = $_POST["relacionado"];
	} else {
		$relacionado = '';
	}
	if (isset($_POST['alcanzoPac']))
	{
		$alcanzoPac  = $_POST["alcanzoPac"];
	} else {
		$alcanzoPac = '';
	}
	if (isset($_POST['danioPac']))
	{
		$danioPac  = $_POST["danioPac"];
	} else {
		$danioPac = '';
	}
	if (isset($_POST['evento']))
	{
		$evento = utf8_decode($_POST["evento"]);
		$evento=addslashes($evento);
	} else {
		$evento = '';
	}
	if (isset($_POST['como']))
	{
		$como = utf8_decode($_POST["como"]);
		$como=addslashes($como);
	} else {
		$como = '';
	}
	if (isset($_POST['porQue']))
	{
		$porQue = utf8_decode($_POST["porQue"]);
		$porQue=addslashes($porQue);
	} else {
		$porQue = '';
	}
	if (isset($_POST['medicamento']))
	{
		$medicamento = utf8_decode($_POST["medicamento"]);
		$medicamento=addslashes($medicamento);
	} else {
		$evento = '';
	}
	if (isset($_POST['generico']))
	{
		$generico = utf8_decode($_POST["generico"]);
		$generico=addslashes($generico);
	} else {
		$generico = '';
	}
	if (isset($_POST['dosis']))
	{
		$dosis = utf8_decode($_POST["dosis"]);
		$dosis=addslashes($dosis);
	} else {
		$dosis = '';
	}
	if (isset($_POST['presentacion']))
	{
		$presentacion = utf8_decode($_POST["presentacion"]);
		$presentacion=addslashes($presentacion);
	} else {
		$presentacion = '';
	}
	if (isset($_POST['viaAdmin']))
	{
		$viaAdmin = utf8_decode($_POST["viaAdmin"]);
		$viaAdmin=addslashes($viaAdmin);
	} else {
		$viaAdmin = '';
	}
	if (isset($_POST['intervalo']))
	{
		$intervalo = utf8_decode($_POST["intervalo"]);
		$intervalo=addslashes($intervalo);
	} else {
		$intervalo = '';
	}
	if (isset($_POST['aim']))
	{
		$aim  = $_POST["aim"];
	} else {
		$aim = '';
	}		
	if (isset($_POST['cidt']))
	{
		$cidt  = $_POST["cidt"];
	} else {
		$cidt = '';
	}
	if (isset($_POST['ciam']))
	{
		$ciam  = $_POST["ciam"];
	} else {
		$ciam = '';
	}
	if (isset($_POST['dim']))
	{
		$dim = $_POST["dim"];
	} else {
		$dim = '';
	}
	if (isset($_POST['eii']))
	{
		$eii = $_POST["eii"];
	} else {
		$eii = '';
	}
	if (isset($_POST['fimar']))
	{
		$fimar = $_POST["fimar"];
	} else {
		$fimar = '';
	}
	if (isset($_POST['mcmc']))
	{
		$mcmc  = $_POST["mcmc"];
	} else {
		$mcmc = '';
	}
	if (isset($_POST['licim']))
	{
		$licim = $_POST["licim"];
	} else {
		$licim = '';
	}
	if (isset($_POST['fma']))
	{
		$fma = $_POST["fma"];
	} else {
		$fma = '';
	}
	if (isset($_POST['manp']))
	{
		$manp = $_POST["manp"];
	} else {
		$manp = '';
	}
	if (isset($_POST['fdvpam']))
	{
		$fdvpam = $_POST["fdvpam"];
	} else {
		$fdvpam = '';
	}
	if (isset($_POST['frmec']))
	{
		$frmec = $_POST["frmec"];
	} else {
		$frmec = '';
	}
	if (isset($_POST['ficp']))
	{
		$ficp = $_POST["ficp"];
	} else {
		$ficp = '';
	}
	if (isset($_POST['ampi']))
	{
		$ampi = $_POST["ampi"];
	} else {
		$ampi = '';
	}
	if (isset($_POST['amnp']))
	{
		$amnp = $_POST["amnp"];
	} else {
		$amnp = '';
	}
	if (isset($_POST['omisionMed']))
	{
		$omisionMed = $_POST["omisionMed"];
	} else {
		$omisionMed = '';
	}
	if (isset($_POST['ami']))
	{
		$ami = $_POST["ami"];
	} else {
		$ami = '';
	}
	if (isset($_POST['presInc']))
	{
		$presInc = $_POST["presInc"];
	} else {
		$presInc = '';
	}
	if (isset($_POST['transInc']))
	{
		$transInc = $_POST["transInc"];
	} else {
		$transInc = '';
	}
	if (isset($_POST['prepInc']))
	{
		$prepInc = $_POST["prepInc"];
	} else {
		$prepInc = '';
	}
	if (isset($_POST['dispoInc']))
	{
		$dispoInc = $_POST["dispoInc"];
	} else {
		$dispoInc = '';
	}
	if (isset($_POST['tai']))
	{
		$tai = $_POST["tai"];
	} else {
		$tai = '';
	}
	if (isset($_POST['vai']))
	{
		$vai = $_POST["vai"];
	} else {
		$vai = '';
	}
	if (isset($_POST['adpi']))
	{
		$adpi = $_POST["adpi"];
	} else {
		$adpi = '';
	}
	if (isset($_POST['dti']))
	{
		$dti = $_POST["dti"];
	} else {
		$dti = '';
	}
	if (isset($_POST['hai']))
	{
		$hai = $_POST["hai"];
	} else {
		$hai = '';
	}
	if (isset($_POST['ifi']))
	{
		$ifi = $_POST["ifi"];
	} else {
		$ifi = '';
	}
	if (isset($_POST['vii']))
	{
		$vii = $_POST["vii"];
	} else {
		$vii = '';
	}
	if (isset($_POST['ot']))
	{
		$ot = $_POST["ot"];
	} else {
		$ot = '';
	}
	if (isset($_POST['otros']))
	{
		$otros = utf8_decode($_POST["otros"]);
		$otros=addslashes($otros);
	} else {
		$otros = '';
	}
	
	if(!empty($idEvAdverso)){
		$queryUpdEvAdv = "UPDATE eventoadverso SET fecha='$fecha',turno='$turno',reporta='$reporta',servicio='$servicio',diag='$diag',
		tipoEvento='$tipoEvento',relacionado='$relacionado',alcanzoPac='$alcanzoPac',danioPac='$danioPac',evento='$evento',como='$como',
		porQue='$porQue',medicamento='$medicamento',generico='$generico',presentacion='$presentacion',dosis='$dosis',viaAdmin='$viaAdmin',
		intervalo='$intervalo',aim='$aim',cidt='$cidt',ciam='$ciam',dim='$dim',eii='$eii',fimar='$fimar',mcmc='$mcmc',licim='$licim',fma='$fma',
		manp='$manp',fdvpam='$fdvpam',frmec='$frmec',ficp='$ficp',ampi='$ampi',amnp='$amnp',omisionMed='$omisionMed',ami='$ami',presInc='$presInc',
		transInc='$transInc',prepInc='$prepInc',dispoInc='$dispoInc',tai='$tai',vai='$vai',adpi='$adpi',dti='$dti',hai='$hai',ifi='$ifi',vii='$vii',
		ot='$ot',otros='$otros'	WHERE id='$idEvAdverso'";
		
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
