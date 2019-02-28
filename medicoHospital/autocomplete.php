<?php
header( 'Content-type: text/html; charset=iso-8859-1' );
#require('config.php');
#require_once "conectar.php";
require_once('../conexion/funciones_db.php');

$search = $_POST['service'];
$usuario1 = new FuncionesDB();
$medicinas[] = $usuario1->medicamento($search);

	/*$query_services="SELECT CVE_PROD,DESC_PROD FROM dbo.HPCATPROD WHERE CVE_MACRO = '12' AND DESC_PROD LIKE '" . $search . "%' ORDER BY DESC_PROD";
        
	$res=sqlsrv_query($con,$query_services);
	
	 if (!$res) {
     	echo "<br>!!!NO HAY DATOS PARA MOSTRAR!!!<br>";
     	echo $query_services;
      	exit;
     } else {
		while($row_services=sqlsrv_fetch_array($res)){
			echo '<div class="item"><a class="suggest-element" data="'.$row_services['DESC_PROD'].'"id="'.$row_services['CVE_PROD'].'">'.$row_services['DESC_PROD'].'</a></div>';
		}
	}*/
	
	for($i=0;$i<count($medicinas );$i++) {
		for($j=0;$j<count($medicinas [$i]);$j++) {
			$color = $medicinas [$i][$j]['ALTORIESGO']=='1' ? 'style="color: red"':'';
			#echo '<option value ="'.$medicinas [$i][$j]['CVE_PROD'].'">'.$medicinas [$i][$j]['DESC_PROD'].'</option>';
			echo '<div class="item"><a '.$color.' class="suggest-element" data="'.$medicinas [$i][$j]['DESC_PROD'].'"id="'.$medicinas [$i][$j]['CVE_PROD'].'"sal="'.$medicinas [$i][$j]['NOMBRE_SAL'].'"idSal="'.$medicinas [$i][$j]['CLAVE_SAL'].'"exist="'.$medicinas [$i][$j]['EXIS_PZA_PROD'].'">
				'.$medicinas [$i][$j]['DESC_GRUPO'].' - '.$medicinas [$i][$j]['DESC_PROD'].' - '.$medicinas [$i][$j]['NOMBRE_SAL'].' - '.$medicinas[$i][$j]['EXIS_PZA_PROD'].'</a></div>';
		}
	}

	#$query_services = mysqli_query($conexion, "SELECT idMedicamento, descMedicamento FROM medicamentos WHERE descMedicamento like '" . $search . "%' ORDER BY descMedicamento");
	#while ($row_services = mysqli_fetch_array($query_services)) {
	#	echo '<div class="item"><a class="suggest-element" data="'.$row_services['descMedicamento'].'"id="'.$row_services['idMedicamento'].'">'.$row_services['descMedicamento'].'</a></div>';
	#}
?>