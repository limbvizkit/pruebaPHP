<?php
  	header('Content-Type: text/html;charset=utf-8');
  	require_once('conexion/funciones_db.php');
  	
  	if(isset ($_GET['nomPac'])){
  		$nomPac= $_GET['nomPac'];
  	}else{
  		$nomPac= NULL;
  	}

  	if(isset ($_GET['expediente'])){
		$expediente = $_GET['expediente'];
		$folio = $_GET['folio'];
		
		$usuario1 = new FuncionesDB();
		$medSurtido[] = $usuario1->medicamentoSurtido($expediente,$folio);
		
		if (empty($medSurtido[0])) {
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>Consulta Medicamento</title>
				<link rel="stylesheet" href="css/bootstrap.min.css" />
				</head>
				<body style="background-image: url(img/logoNew2Agua.jpg)">&nbsp;&nbsp;!!!ESTE PACIENTE NO TIENE MEDICAMENTO SURTIDO!!! <br><br>
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
			<body style="background-image: url(img/logoNew2Agua.jpg)"><strong>&nbsp;&nbsp;MEDICAMENTOS SURTIDOS PARA PACIENTE:</strong> '.$expediente.' '.$nomPac.'<br><br>';
			echo '<table style="width: 100%" border="1px solid black;">';
			echo "<th class='auto-style2'>No.</th>";
			echo "<th class='auto-style2'>CANTIDAD</th>";
			echo "<th class='auto-style2'>DESCRIPCION</th>";
			echo "<th class='auto-style2'>FECHA REGISTRO</th>";
			echo "<th class='auto-style2'>HORA</th>";
			$c=1;
			for($i=0;$i<count($medSurtido);$i++) {
				for($j=0;$j<count($medSurtido[$i]);$j++) {
					echo '<tr><td class="auto-style4">'.
					$c++.'</td><td>'.
					#$medSurtido[$i][$j]['CONSECUTIVO_LAB'].'</td><td>'.
					$medSurtido[$i][$j]['CANT'].'</td><td>'.
					$medSurtido[$i][$j]['DESC_PROD'].'</td><td>'.
					$medSurtido[$i][$j]['FECHA']->format('d-m-Y').'</td><td>'.
					$medSurtido[$i][$j]['FECHA']->format('H:i:s').'</td><td>'.
					#$medSurtido[$i][$j]['fecha_registro']->format('d-m-Y H:i:s').'</td><td>'.
					#$medSurtido[$i][$j]['HORA'].'</td><td>'.
					'</td></tr>';
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
			<body style="background-image: url(img/logoNew2Agua.jpg)">!!! ERROR CON NÚMERO DE EXPEDIENTE !!! <br/><br/>
    	    &nbsp;&nbsp;<input name="cerrar" class="btn btn-danger" type="button" onclick="window.close();" value="SALIR" style="width: 137px; height: 44px"></body></html>'; 
    	exit();
	}
	
?>