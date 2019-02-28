<?php
header( 'Content-type: text/html; charset=iso-8859-1' );
#require('config.php');
#require_once "conectar.php";
require_once('../conexion/funciones_db.php');

	$search = $_POST['cedula'];
	$usuario1 = new FuncionesDB();
	$medics[] = $usuario1->medicosCedB($search);
		for($i=0;$i<count($medics );$i++) {
			for($j=0;$j<count($medics [$i]);$j++) {
				#echo '<option value ="'.$medicinas [$i][$j]['CVE_PROD'].'">'.$medicinas [$i][$j]['DESC_PROD'].'</option>';
				echo '<div class="item"><a class="suggest-element" data="'.utf8_decode($medics [$i][$j]['DESC_MEDICO']).'"especialidad="'.$medics [$i][$j]['DESC_ESPEC'].'"ced="'.trim($medics [$i][$j]['CEDULA_MEDICO']).'"id1="'.$medics [$i][$j]['CVE_MEDICO'].'"> 
					'.trim(utf8_decode($medics [$i][$j]['DESC_MEDICO'])).' - '.trim(utf8_decode($medics [$i][$j]['DESC_ESPEC'])).' - '.utf8_decode(trim($medics [$i][$j]['UNIVERSIDAD_CEDULA_MEDICO'])).' - '.utf8_decode(trim($medics[$i][$j]['CEDULA_MEDICO'])).'</a></div>';
			}
		}
 ?>