<?php
header( 'Content-type: text/html; charset=iso-8859-1' );
require_once "../conexion/funciones_db.php";

if(isset ($_POST['instrumental'])){
	$search = $_POST['instrumental'];
	$usuario1 = new FuncionesDB();
	$medicinas[] = $usuario1->material($search);	
		for($i=0;$i<count($medicinas );$i++) {
			for($j=0;$j<count($medicinas [$i]);$j++) {
				#echo '<option value ="'.$medicinas [$i][$j]['CVE_PROD'].'">'.$medicinas [$i][$j]['DESC_PROD'].'</option>';
				echo '<div class="item"><a class="suggest-element" data="'.utf8_decode($medicinas [$i][$j]['DESC_PROD']).'"id="'.$medicinas [$i][$j]['CVE_PROD'].'">
					'.utf8_decode($medicinas [$i][$j]['DESC_GRUPO']).' - '.utf8_decode($medicinas [$i][$j]['DESC_PROD']).'</a></div>';
			}
		}
}

if(isset ($_POST['cirujano'])){
	$search = $_POST['cirujano'];
	$usuario1 = new FuncionesDB();
	$medics[] = $usuario1->medicos($search);	
		for($i=0;$i<count($medics );$i++) {
			for($j=0;$j<count($medics [$i]);$j++) {
				#echo '<option value ="'.$medicinas [$i][$j]['CVE_PROD'].'">'.$medicinas [$i][$j]['DESC_PROD'].'</option>';
				echo '<div class="item"><a class="suggest-element" data="'.utf8_decode($medics [$i][$j]['DESC_MEDICO']).'"tel="'.$medics [$i][$j]['TEL_PART_MEDICO'].'"email="'.$medics [$i][$j]['EMAIL_MEDICO'].'"id1="'.$medics [$i][$j]['CVE_MEDICO'].'"> 
					'.utf8_decode($medics [$i][$j]['DESC_MEDICO']).' - '.utf8_decode($medics [$i][$j]['DESC_ESPEC']).'</a></div>';
			}
		}
}

?>