<?php
require_once('../conexion/configMedico.php');

	$alergias=NULL;

	if (isset($_POST['idReceta']))
	{
		$idReceta  = $_POST["idReceta"];
	} else {
		$idReceta = '';
	}
	if (isset($_POST['nombrePac']))
	{
		$nombrePac=utf8_decode(trim($_POST['nombrePac']));
		$nombrePac=addslashes($nombrePac);
	} else {
		$nombrePac = '';
	}
	if (isset($_POST['nacimiento']))
	{
		$nacimiento=$_POST['nacimiento'];
	} else {
		$nacimiento = '';
	}
	if (isset($_POST['diagn']))
	{
		$diagn  = utf8_decode($_POST["diagn"]);
		$diagn =addslashes($diagn);
	} else {
		$diagn = '';
	}
	if (isset($_POST['alergias']))
	{
		$alergias  = utf8_decode($_POST["alergias"]);
		$alergias=addslashes($alergias);
	} else {
		$alergias = '';
	}
	if (isset($_POST['cedula']))
	{
		$cedula  = $_POST["cedula"];
	} else {
		$cedula = '';
	}

	$acturl=NULL;
	$acturl2=NULL;
	$acturl3=NULL;
	$acturl4=NULL;
	#vamos a recibir los datos del listado de Indicaciones
	if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
		$acturl = utf8_decode(urldecode($_POST['ListaPro'])); //decodifico el JSON
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
	#vamos a recibir los datos del listado de Indicaciones
	if(isset ($_POST['ListaPro2']) && $_POST['ListaPro2'] != NULL){
		$acturl2 = urldecode($_POST['ListaPro2']); //decodifico el JSON
		//echo 'LLEGOOOO2: '.$acturl2;
		if($acturl2 == '[]'){
			$acturl2 = NULL;
		}
	}
		//$productos2 = json_decode($acturl2, true);

	if(isset ($_POST['ListaPro3']) && $_POST['ListaPro3'] != NULL){
		$acturl3 = utf8_decode(urldecode($_POST['ListaPro3'])); //decodifico el JSON
		//$acturl3=addslashes($acturl3);
		if($acturl3 == '[]'){
			$acturl3 = NULL;
		}
	}

	if(isset ($_POST['ListaPro4']) && $_POST['ListaPro4'] != NULL){
		$acturl4 = utf8_decode(urldecode($_POST['ListaPro4'])); //decodifico el JSON
		//$acturl4=addslashes($acturl4);
		if($acturl4 == '[]'){
			$acturl4 = NULL;
		}
	}

	if(isset ($_POST['ListaPro5']) && $_POST['ListaPro5'] != NULL){
			$acturl5 = utf8_decode(urldecode($_POST['ListaPro5'])); //decodifico el JSON
			//$acturl4=addslashes($acturl4);
			if($acturl5 == '[]'){
	        	$acturl5 = NULL;
	        }
		}
		
	if(!empty($idReceta)){
		$queryUpRecet = "UPDATE receta SET nombrePac='$nombrePac', fechaNacimiento='$nacimiento', alergias='$alergias', nombreMed='',
			cedula='$cedula', diag='$diagn', idMedicamentos='$acturl2', medicamentos='$acturl', sal='$acturl4', indicaciones='$acturl3',
			existencias='$acturl5', fecha=NOW()
			WHERE id='$idReceta'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpRecet) or die (mysqli_error($conexionMedico));
		
		if(!$result0){
			//echo $queryUpRecet;
			echo'0';
		} else {
			//echo $queryUpRecet;
			echo '1';
		}
	} else {
		echo '0';
		return false;
	}
		
?>
