<?php
  	header('Content-Type: text/html;charset=utf-8');
  	require_once('conexion/funciones_db.php');
  	
  	if(isset ($_GET['nomPac'])){
  		$nomPac= $_GET['nomPac'];
  	}else{
  		$nomPac= NULL;
  	}
  	
  	if(isset ($_GET['folio'])){
  		$folio= $_GET['folio'];
  	}else{
  		$folio= NULL;
  	}
	if(isset ($_GET['epidemio'])){
  		$epidemio= $_GET['epidemio'];
  	}else{
  		$epidemio= NULL;
  	}

  	if(isset ($_GET['expediente'])){
		$expediente = $_GET['expediente'];
		
		$usuario1 = new FuncionesDB();
		$datosLB[] = $usuario1->datosLaboratorio($expediente,$folio);
		
		if (empty($datosLB[0])) {
			if($epidemio==''||$epidemio==NULL){
				header("location: datosLaboratorio_OLD.php?nomPac=$nomPac&expediente=$expediente&folio=$folio");
			}
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>Consulta Medicamento</title>
				<link rel="stylesheet" href="css/bootstrap.min.css" />
				</head>
				<body style="background-image: url(\'img/logoNew2Agua.jpg\');">&nbsp;&nbsp;!!!ESTE PACIENTE NO TIENE DATOS DE LABORATORIO!!! <br><br>
	    	    &nbsp;&nbsp;<input name="cerrar" class="btn btn-danger" type="button" onclick="window.close();" value="SALIR" style="width: 137px; height: 44px"></body></html>'; 
	    	exit();
		}else{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
			<title>Consulta Medicamento</title>
			<style type="text/css">
			.auto-style2 {
				font-size: large;
				border-bottom-style: solid;
				border-bottom-width: 1px;
			}

			.auto-style4 {
				font-size: large;
				border-style: solid;
				border-width: 1px;
			}

			</style>
			<link rel="stylesheet" href="css/bootstrap.min.css" />
			</head>
			<body style="background-image: url(\'img/logoNew2Agua.jpg\');"><strong>&nbsp;&nbsp;DATOS DE LABORATORIO PARA PACIENTE:</strong> '.$expediente.' '.$nomPac.'<br><br>';
			echo '<table style="width: 100%" border="1px solid black;">';
			echo "<th class='auto-style2'>No.</th>";
			echo "<th class='auto-style2'>FECHA CAPTURA</th>";
			echo "<th class='auto-style2'>DESCRIPCIÓN</th>";
			echo "<th class='auto-style2'>RESULTADO</th>";
			echo "<th class='auto-style2'>UNIDAD</th>";
			echo "<th class='auto-style2'>LIMITE INF.</th>";
			echo "<th class='auto-style2'>LIMITE SUP.</th>";
			$c=1;
			$consecutivo;
			$consecutivoOLD;
			for($i=0; $i<count($datosLB); $i++) {
				for($j=0; $j<count($datosLB[$i]); $j++) {
				$consecutivo=$datosLB[$i][$j]['consecutivo'];
				$fechaCaptura=$datosLB[$i][$j]['FECHA_CAPTURA']->format('d-m-Y');
				#if($datosLB[$i][$j]['SEXO'] == 'A' || $datosLB[$i][$j]['SEXO_PAC'] == $datosLB[$i][$j]['SEXO']){
					if(trim($datosLB[$i][$j]['SEXO']) == 'A' || trim($datosLB[$i][$j]['SEXO_PAC']) == trim($datosLB[$i][$j]['SEXO'])){
						if(trim($datosLB[$i][$j]['DESCRIPCION']) !== 'Sodio (Na)' && trim($datosLB[$i][$j]['DESCRIPCION']) !== 'Potasio (K)' &&
							trim($datosLB[$i][$j]['DESCRIPCION']) !== 'Cloro (Cl)'){
							$nuevo=NULL;
							#$consecutivo=$datosLB[$i][$j]['consecutivo'];
							echo '<tr><td class="auto-style4">'.$c++.'</td><td>'.
							$fechaCaptura.'</td><td>'.
							$datosLB[$i][$j]['DESCRIPCION'].'</td><td>'.
							$datosLB[$i][$j]['RESULTADO'].'</td><td>'.
							$datosLB[$i][$j]['UNIDAD'].'</td><td>'.
							$datosLB[$i][$j]['LIMITE_INFERIOR'].'</td><td>'.
							$datosLB[$i][$j]['LIMITE_SUPERIOR'].'</td><td>'.
							#$medSurtido[$i][$j]['p.UNIDAD']->format('d-m-Y').'</td><td>'.
							#$medSurtido[$i][$j]['FECHA']->format('H:i:s').'</td><td>'.
							#$medSurtido[$i][$j]['fecha_registro']->format('d-m-Y H:i:s').'</td><td>'.
							#$medSurtido[$i][$j]['HORA'].'</td><td>'.
							'</td></tr>';
							if($j+1 < count($datosLB[$i])){
								$consecutivoOLD=$datosLB[$i][$j+1]['consecutivo'];
								if($consecutivo != $consecutivoOLD){
									$nuevo = '<tr><td class="auto-style4">ESTUDIO</td><td>';
									$c=1;
								}
							}
							echo $nuevo;
						} else if((trim($datosLB[$i][$j]['DESCRIPCION']) == 'Sodio (Na)' && trim($datosLB[$i][$j]['LIMITE_SUPERIOR']) == '148') || 
							(trim($datosLB[$i][$j]['DESCRIPCION']) == 'Potasio (K)' && trim($datosLB[$i][$j]['LIMITE_SUPERIOR']) == '5.5') || 
							(trim($datosLB[$i][$j]['DESCRIPCION']) == 'Cloro (Cl)' && trim($datosLB[$i][$j]['LIMITE_SUPERIOR']) == '115')){
							$nuevo=NULL;
							#$consecutivo=$datosLB[$i][$j]['consecutivo'];
							echo '<tr><td class="auto-style4">'.$c++.'</td><td>'.
							$fechaCaptura.'</td><td>'.
							$datosLB[$i][$j]['DESCRIPCION'].'</td><td>'.
							$datosLB[$i][$j]['RESULTADO'].'</td><td>'.
							$datosLB[$i][$j]['UNIDAD'].'</td><td>'.
							$datosLB[$i][$j]['LIMITE_INFERIOR'].'</td><td>'.
							$datosLB[$i][$j]['LIMITE_SUPERIOR'].'</td><td>'.
							'</td></tr>';
							if($j+1 < count($datosLB[$i])){
								$consecutivoOLD=$datosLB[$i][$j+1]['consecutivo'];
								if($consecutivo != $consecutivoOLD){
									$nuevo = '<tr><td class="auto-style4">NUEVO ESTUDIO</td><td>';
									$c=1;
								}
							}
							echo $nuevo;
						}
					}
				}
			}
			echo '</table><br/><br/>&nbsp;&nbsp;<input name="cerrar" class="btn btn-danger" type="button" onclick="window.close();" value="SALIR" style="width: 137px; height: 44px" /></body></html>';
			#$desc_prod = $medSurtido[0][0]['DESC_PROD'];
		}
	}else {
		$expediente = NULL;
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
			<title>Consulta Medicamento</title>
			<link rel="stylesheet" href="css/bootstrap.min.css" />
			</head>
			<body style="background-image: url(\'img/logoNew2Agua.jpg\');">!!! ERROR CON NÚMERO DE EXPEDIENTE !!! <br/><br/>
    	    &nbsp;&nbsp;<input name="cerrar" class="btn btn-danger" type="button" onclick="window.close();" value="SALIR" style="width: 137px; height: 44px"></body></html>'; 
    	exit();
	}
	
?>