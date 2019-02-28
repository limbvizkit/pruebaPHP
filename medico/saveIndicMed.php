<?php
require_once('../conexion/configMedico.php');

	$exp=NULL;
	$folio=NULL;
	$alergias=NULL;

	if (isset($_POST['idIndicMed']))
	{
		$idIndicMed  = $_POST["idIndicMed"];
	} else {
		$idIndicMed = '';
	}
	if (isset($_POST['nPaciente']))
	{
		$nPaciente=utf8_decode(trim($_POST['nPaciente']));
		$nPaciente=addslashes($nPaciente);
	} else {
		$nPaciente = '';
	}
	if (isset($_POST['fNacimiento']))
	{
		$fNacimiento=$_POST['fNacimiento'];
	} else {
		$fNacimiento = '';
	}
	if (isset($_POST['diagnostico']))
	{
		$diagnostico  = utf8_decode($_POST["diagnostico"]);
		$diagnostico=addslashes($diagnostico);
	} else {
		$diagnostico = '';
	}
	if (isset($_POST['medTratante']))
	{
		$medTratante  = utf8_decode($_POST["medTratante"]);
		$medTratante=addslashes($medTratante);
	} else {
		$medTratante = '';
	}
	if (isset($_POST['exp']))
	{
		$exp  = $_POST["exp"];
	} else {
		$exp = '';
	}
	if (isset($_POST['folio']))
	{
		$folio  = $_POST["folio"];
	} else {
		$folio = '';
	}
	if (isset($_POST['cedula']))
	{
		$cedula  = $_POST["cedula"];
	} else {
		$cedula = '';
	}
	if (isset($_POST['alergias']))
	{
		$alergias  = utf8_decode($_POST["alergias"]);
		$alergias=addslashes($alergias);
	} else {
		$alergias = '';
	}
	/*if (isset($_POST['indicacion']))
	{
		$indicacion  = utf8_decode($_POST["indicacion"]);
	} else {
		$indicacion = '';
	}*/
	if (isset($_POST['fechaG']))
	{
		$fechaG  = $_POST["fechaG"];
	} else {
		$fechaG = '';
	}
	if (isset($_POST['horaG']))
	{
		$horaG  = $_POST["horaG"];
	} else {
		$horaG = '';
	}

	#vamos a recibir los datos del listado de Indicaciones
		if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = urldecode($_POST['ListaPro']); //decodifico el JSON
			//echo 'LLEGOOOO: '.$acturl;
			if($acturl == '[]'){
	        	$acturl = NULL;
	        }
	        //$productos = json_decode($acturl, true);
        	//$separado1 = implode(",", $productos);
        	//var_dump($productos);
	        //echo 'FINAL1: '.$separado1;
	        /*foreach ($productos  as $pro) {
	        	echo ' DENTRO: '.$pro->idInst;
	            $misProductos = array('nombre['.$n++.']' => $pro->idInst);
	        }*/
        }
        
        if(isset ($_POST['ListaPro2']) && $_POST['ListaPro2'] != NULL){
			$acturl2 = urldecode($_POST['ListaPro2']); //decodifico el JSON
			//echo 'LLEGOOOO2: '.$acturl2;
			if($acturl2 == '[]'){
	        	$acturl2 = NULL;
	        }
	        //$productos2 = json_decode($acturl2, true);
		}
        if(isset ($_POST['ListaPro3']) && $_POST['ListaPro3'] != NULL){
			$acturl3 = utf8_decode(urldecode($_POST['ListaPro3'])); //decodifico el JSON
			//$acturl3=addslashes($acturl3);
			if($acturl3 == '[]'){
	        	$acturl3 = NULL;
	        }
	       //$productos3 = json_decode($acturl3, true);
		}
	if(!empty($idIndicMed)){
		$queryUpdIndicMed = "UPDATE indicacionesmedicas SET numeroExpediente='$exp',folio='$folio',nPaciente='$nPaciente',fNacimiento='$fNacimiento',
			alergias='$alergias',medTratante='$medTratante', diagnostico='$diagnostico',cedula='$cedula',fechaInd='$acturl',horaInd='$acturl2',
			indicacion='$acturl3',fechaG='$fechaG',horaG='$horaG' WHERE id='$idIndicMed'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdIndicMed) or die (mysqli_error($conexionMedico));
		
		if(!$result0){
			echo $queryUpdIndicMed;
			echo'0';
		} else {
			//echo $queryUpdIndicMed;
			echo '1';
		}
	} else {
		echo '0';
		return false;
	}

?>

