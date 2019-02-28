<?php
	header('Content-Type: text/html;charset=utf-8');

	require_once('conexion/config.php');
  	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('conexion/funciones_db.php');
	
	if (isset($_GET['expediente']))
	{
		$expediente=$_GET['expediente'];
	} else {
		$expediente=NULL;
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	} else {
		$folio=NULL;
	}
	
	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente, $folio);
	$nombre_pac = $resultado[0][0]['NOMBRE'];
    $expediente_pac = $resultado[0][0]['NO_EXP_PAC'];
    $folio_pac = $resultado[0][0]['FOLIO_PAC'];
    $edad_pac = $resultado[0][0]['EDAD_PAC'];
    $sexo_pac = $resultado[0][0]['SEXO_PAC'];
    $diag_ingreso_pac = $resultado[0][0]['MOTIV_ING_PAC'];
    $nombre_med = $resultado[0][0]['DESC_MEDICO'];
    $especialidad_med = $resultado[0][0]['DESC_ESPEC'];
    if($resultado[0][0]['CVE_CUARTO'] != NULL && $resultado[0][0]['CVE_CUARTO'] != ''){
   	    $cuarto = $resultado[0][0]['CVE_CUARTO'];
	}
    $date = $resultado[0][0]['FEC_ING_PAC']; //HR_ING_PAC
    $fecha_ing_pac = $date->format('d-m-Y');
    $hrI = $resultado[0][0]['HR_ING_PAC'];
    $hrsI = $hrI->format('H');
    $minI = $hrI->format('i');
    $hrIngreso = $hrsI.':'.$minI;
	if($resultado[0][0]['FEC_SAL']!= NULL && $resultado[0][0]['FEC_SAL'] !='' ){
	    $date1 = $resultado[0][0]['FEC_SAL'];
	    $fecha_sal_pac = $date1->format('d-m-Y');
    } else {
    	$fecha_sal_pac = NULL;
    }
    
    $date2 = $resultado[0][0]['NACIO_PA'];
    $fecha_nac_pac = $date2->format('d-m-Y');
	
	#Obtenemos datos de MYSQL si es que existen para el expediente dado
	$queryBasicos1 = "SELECT nombre,numeroExpediente,folio,edad,sexo,diagnostico,medico,especialidad,habitacion,fechaIngreso,fechaNacimiento,alergias,peso,talla,medicamentoCasa,
						diagnostico,concomitantes,depCreatinina,medico, cultivo
					  FROM paciente WHERE numeroExpediente = '$expediente' AND (folio = 0 || folio= '$folio')";
	$idBas1 = mysqli_query($conexion, $queryBasicos1) or die (mysqli_error($conexion));
	#echo $queryBasicos1;
	$idbas2 = mysqli_fetch_array($idBas1);
	if($idbas2 != NULL) {
		/*$nombre_pac = utf8_decode($idbas2 ['nombre']); #tambien puede ser $idbas2[0]
	    $expediente_pac = $idbas2 ['numeroExpediente'];
	    $edad_pac = $idbas2 ['edad'];
   	    $sexo_pac = $idbas2 ['sexo'];
   	    $diag_ingreso_pac = $idbas2 ['diagnostico'];
   	    $nombre_med = $idbas2 ['medico'];
   	    $especialidad_med = $idbas2 ['especialidad'];
   	    $cuarto = $idbas2 ['habitacion'];
		    
	    $fecha_ing_pac1 = strtotime($idbas2 ['fechaIngreso']);
	    $fecha_ing_pac = date('d-m-Y',$fecha_ing_pac1);
	    		    
	    $fecha_nac_pac1 = strtotime($idbas2 ['fechaNacimiento']);
	    $fecha_nac_pac = date('d-m-Y',$fecha_nac_pac1);*/
	    $alergias = utf8_encode($idbas2 ['alergias']);
	    $peso= $idbas2 ['peso'];
	    $talla= $idbas2 ['talla'];
	    $medicamentoCasa= utf8_encode($idbas2['medicamentoCasa']);
	    $diagnostico= utf8_encode($idbas2 ['diagnostico']);
	    $concomitantes= utf8_encode($idbas2 ['concomitantes']);
	    $creatinina= utf8_encode($idbas2 ['depCreatinina']);
	    $medico= utf8_encode($idbas2 ['medico']);
	    $cultivo = utf8_encode($idbas2 ['cultivo']);
	} else {
    	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
			<title>Reporte General</title>
			<link rel="stylesheet" href="css/bootstrap.min.css" />
			</head>
			<body><strong>FAVOR DE COMPLEMENTAR LOS DATOS BASICOS DEL PACIENTE</strong> <br><br>';
    	echo '&nbsp;&nbsp;<input type="button" class="btn btn-danger" value="SALIR" onclick="window.close();" height="75" width="161">
       		</body></html>';
    	exit();
	}
   ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Reporte General</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<style type="text/css">
	.auto-style1 {
		text-align: center;
	}
	.auto-style2 {
		font-size: large;
	}
	.auto-style3 {
		font-size: 16px;
	}
	.auto-style5 {
		background-color: #99FF99;
		text-align: center;
	}
	.auto-style6 {
		background-color: #dff0d8;
		text-align: center;
	}
	.auto-style8 {
		background-color: #EBBFFF;
		text-align: center;
	}
	.auto-styleDesc {
		background-color: #FFFF99;
		text-align: center;
	}
	.auto-styleInt {
		background-color: #FF9393;
		text-align: center;
	}
	.auto-styleRec{
		background-color: #00CC99;
		text-align: center;
	}

</style>
</head>
<body>
<div style="background-color:#AAE3FF">
	<br/>
	&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="window.close();" style="width: 120px; height: 40px"> CERRAR </a>
	<h1 class="auto-style1">PERFIL FARMACOTERAPÉUTICO Y CONCILIACIÓN DE LA MEDICACIÓN</h1>
	<span> <strong>&nbsp;&nbsp; <span class="auto-style2">DATOS BÁSICOS:</span></strong></span>
	<br/>
	<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="auto-style3">
	Expediente:</span></strong><span class="auto-style3"> <?php echo $expediente_pac?> </span>
	<span class="auto-style3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<strong>Nombre:</strong> <?php echo $nombre_pac ?> &nbsp;&nbsp;&nbsp;&nbsp; 
	<strong>Edad:</strong> <?php echo $edad_pac ?>
	&nbsp;&nbsp;&nbsp;&nbsp; <strong>Sexo:</strong> <?php echo $sexo_pac ?> &nbsp;&nbsp;&nbsp;&nbsp; 
	<strong>Fecha de Nacimiento:</strong> <?php echo $fecha_nac_pac ?>
	&nbsp;&nbsp;&nbsp;&nbsp; <strong>
	<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha y Hora de Ingreso:</strong> <?php echo $fecha_ing_pac.' '.$hrIngreso ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Fecha de Egreso:</strong> <?php echo $fecha_sal_pac ?>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Alergias:</strong> <?php echo $alergias ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Peso:</strong> <?php echo $peso ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Talla:</strong> <?php echo $talla ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Medicamentos de Casa:</strong> <?php echo $medicamentoCasa ?>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Diagnostico:</strong> <?php echo $diagnostico ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Enfermedades Concomitantes:</strong> <?php echo $concomitantes ?>
	<br/> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Cultivo:</strong> <?php echo $cultivo ?>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Medico:</strong> <?php echo $medico ?>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<strong>Depuración de Creatinina:</strong> <?php echo $creatinina ?>
	</span>
</div>
	<div style="background-image: url('img/logoNew2Agua.jpg')">
	<!--------------------------------------------------------------------- Tabla de medicamentos ------------------------------------------------------------------------->
	<hr/>
	<strong>&nbsp;&nbsp; <span class="auto-style2">MEDICAMENTOS:</span></strong>
	<table style="width: 100%"  border="5px solid black;">
		<th class="auto-style6">&nbsp;No.&nbsp;</th>
		<th class="auto-style6">&nbsp;NOMBRE&nbsp;</th>
		<th class="auto-style6">&nbsp;TIPO MEDICAMENTO&nbsp;</th>
		<th class="auto-style6">&nbsp;SAL&nbsp;</th>
		<th class="auto-style6">&nbsp;FECHA INICIO&nbsp;</th>
		<th class="auto-style6">&nbsp;FECHA FIN&nbsp;</th>
		<th class="auto-style6">&nbsp;LUGAR DONDE INICIO&nbsp;</th>
		<th class="auto-style6">&nbsp;DOSIS&nbsp;</th>
		<th class="auto-style6">&nbsp;VÍA ADMON.&nbsp;</th>
		<th class="auto-style6">&nbsp;FRECUENCIA&nbsp;</th>
	<?php
		$queryMedPac = "SELECT  m.idMedicamento,t.nombreTipo,m.nombreOtroTipo,m.fechaInicio,m.nombreMedicamento,m.sal,m.dosis,v.viaAdmon,m.otraVia,f.nombreFrecuencia,m.otraFrecuencia, 
						r.dosisMax,r.dosisIncorrecta,r.revisionPeso,r.pesoIncorrecto,r.ajusteRenal,r.renalIncorrecto,r.contraindicaciones,
						CASE r.recomendacion WHEN '1' THEN 'SI' ELSE 'NO' END AS reco, (SELECT MAX(d.diaConsumo)
																						FROM historicodosis AS d
																						WHERE d.numeroExpediente=p.numeroExpediente AND d.folio=p.folio
																						AND d.idMedPaciente = m.id) AS fechaFin
						FROM paciente AS p 
						LEFT JOIN medpacientes AS m ON p.numeroExpediente=m.numeroExpediente AND p.folio=m.folio
						LEFT JOIN tipomedicamento AS t ON m.tipoMedicamento=t.tipoMedicamento 
						LEFT JOIN viadeadmon AS v ON m.idViaAdmon=v.idViaAdmon 
						LEFT JOIN frecuencia AS f ON m.frecuencia=f.idFrecuencia 
						LEFT JOIN revisiones AS r ON m.idRevision=r.idRevision 
						WHERE p.numeroExpediente='$expediente' AND (p.folio = 0 || p.folio= '$folio')
						ORDER BY m.fechaInicio, m.nombreMedicamento";
		$resultM = mysqli_query($conexion, $queryMedPac) or die (mysqli_error($conexion));
		$m = 1;
		while($rowM = mysqli_fetch_array($resultM)){
		$query1Dss = "SELECT MIN(h.diaConsumo) AS dia, MIN(h.hrConsumo) AS hora,l.nombreLugarHist
					FROM historicodosis AS h
					LEFT JOIN medpacientes AS m ON m.id=h.idMedPaciente 
					LEFT JOIN lugarhistorico as l ON h.lugarPrescripcion=l.idLugarHist
					WHERE h.numeroExpediente='$expediente_pac' AND (h.folio = 0 || h.folio= '$folio_pac') AND h.idMedicamento=$rowM[0]
					LIMIT 1";
		$result1Dss = mysqli_query($conexion, $query1Dss) or die (mysqli_error($conexion));
		$row1Dss = mysqli_fetch_array($result1Dss);
		
		$incorrecto = NULL;
		if($rowM['dosisIncorrecta'] == 1 || $rowM['pesoIncorrecto'] == 1 || $rowM['renalIncorrecto'] == 1){
			$incorrecto = "<span style='color:red'>*</span>";
		}
		if($rowM['fechaFin'] != '' || $rowM['fechaFin'] != NULL){
			$fecha_fin = date_create_from_format('Y-m-d',$rowM['fechaFin'])->format('d-m-Y');
		} else{
			$fecha_fin = '';
		}
	?>
		<tr>
			<td class="text-center"><?php echo $incorrecto . $m++  ?></td>
			<td class="text-center"><a href="#<?php echo $rowM['nombreMedicamento'].$m?>"</a><?php echo $rowM['nombreMedicamento'] ?></td>
			<td class="text-center"><?php echo utf8_encode($rowM['nombreTipo']).' '.utf8_encode($rowM['nombreOtroTipo'])?></td>
			<td class="text-center"><?php echo $rowM['sal']?></td>
			<td class="text-center"><?php echo date_create_from_format('Y-m-d',$rowM['fechaInicio'])->format('d-m-Y') ?></td>
			<td class="text-center"><?php echo  $fecha_fin?></td>
			<td class="text-center"><?php echo utf8_encode($row1Dss['nombreLugarHist'])?></td>
			<td class="text-center"><?php echo $rowM['dosis']?></td>
			<td class="text-center"><?php echo $rowM['viaAdmon'] .' '.utf8_encode($rowM['otraVia']) ?></td>
			<td class="text-center"><?php echo $rowM['nombreFrecuencia'].' '.utf8_encode($rowM['otraFrecuencia']) ?></td>
		</tr>
		<?php } ?>
	</table>
	
	<!------------------------------------------------------------------ Medicamentos por Dosis --------------------------------------------------------------------------->
	<hr/>
	<strong>&nbsp;&nbsp; <span class="auto-style2">MEDICAMENTOS A DETALLE:</span></strong>
	<?php
		$queryMedPac = "SELECT  m.idMedicamento,t.nombreTipo,m.nombreOtroTipo,m.fechaInicio,m.nombreMedicamento,m.dosis,v.viaAdmon,m.otraVia,f.nombreFrecuencia,m.otraFrecuencia, 
						r.dosisMax,r.dosisIncorrecta,r.revisionPeso,r.pesoIncorrecto,r.ajusteRenal,r.renalIncorrecto,r.contraindicaciones,
						CASE r.recomendacion WHEN '1' THEN 'SI' ELSE 'NO' END AS reco
						FROM paciente AS p 
						LEFT JOIN medpacientes AS m ON p.numeroExpediente=m.numeroExpediente AND p.folio=m.folio
						LEFT JOIN tipomedicamento AS t ON m.tipoMedicamento=t.tipoMedicamento 
						LEFT JOIN viadeadmon AS v ON m.idViaAdmon=v.idViaAdmon 
						LEFT JOIN frecuencia AS f ON m.frecuencia=f.idFrecuencia 
						LEFT JOIN revisiones AS r ON m.idRevision=r.idRevision 
						WHERE p.numeroExpediente='$expediente_pac' AND (p.folio = 0 || p.folio= '$folio_pac')
						ORDER BY m.fechaInicio, m.nombreMedicamento";
		$result1 = mysqli_query($conexion, $queryMedPac) or die (mysqli_error($conexion));
		$c = 1;
		while($row = mysqli_fetch_array($result1)){
		$DssIncorrecta = NULL;
		$PesIncorrecta = NULL;
		$RenIncorrecta = NULL;
		if($row['dosisIncorrecta'] == 1){
			$DssIncorrecta = "<span style='color:red'>Dosis Incorrecta</span>";
		}
		if($row['pesoIncorrecto'] == 1){
			$PesIncorrecta = "<span style='color:red'>Peso Incorrecto</span>";
		}
		if($row['renalIncorrecto'] == 1){
			$RenIncorrecta = "<span style='color:red'>Renal Incorrecto</span>";
		}
	?>
	<table style="width: 100%"  border="5px solid black;">
			<th class="auto-style8">&nbsp;No.&nbsp;</th>
			<th class="auto-style8">&nbsp;NOMBRE&nbsp;</th>
			<th class="auto-style8">&nbsp;TIPO MEDICAMENTO&nbsp;</th>
			<th class="auto-style8">&nbsp;FECHA INICIO&nbsp;</th>
			<th class="auto-style8">&nbsp;DOSIS&nbsp;</th>
			<th class="auto-style8">&nbsp;VÍA ADMON.&nbsp;</th>
			<th class="auto-style8">&nbsp;FRECUENCIA&nbsp;</th>
		<tr>
			<td class="text-center"> <?php echo $c++?> </td>
			<a name="<?php echo $row['nombreMedicamento'].$c?>" id="<?php echo $row['nombreMedicamento'].$c?>"></a> 
			<td class="auto-styleRec"><strong><?php echo $row['nombreMedicamento']?></strong></td>
			<td class="text-center"><?php echo utf8_encode($row['nombreTipo']).' '.utf8_encode($row['nombreOtroTipo'])?></td>
			<td class="text-center"><?php echo date_create_from_format('Y-m-d',$row['fechaInicio'])->format('d-m-Y') ?></td>
			<td class="text-center"><?php echo $row['dosis']?></td>
			<td class="text-center"><?php echo $row['viaAdmon'] .' '.$row['otraVia']?></td>
			<td class="text-center"><?php echo $row['nombreFrecuencia'].' '.utf8_encode($row['otraFrecuencia']) ?></td>
		</tr>
		</table>
		<br/>
		&nbsp;<strong><span class="auto-style3">REVISIÓN:</span></strong> 
		<table style="width: 70%"  border="5px solid black;" align="center">
			<th class="auto-style5">&nbsp;DOSIS MAX.&nbsp;</th>
			<th class="auto-style5">&nbsp;REVISIÓN PESO&nbsp;</th>
			<th class="auto-style5">&nbsp;AJUSTE RENAL&nbsp;</th>
			<th class="auto-style5">&nbsp;CONTRAINDICACIONES&nbsp;</th>
			<th class="auto-style5">&nbsp;RECOMENDACIONES&nbsp;</th>
			<tr>
				<td class="text-center"><?php echo utf8_encode($row['dosisMax'].' '.$DssIncorrecta) ?></td>
				<td class="text-center"><?php echo utf8_encode($row['revisionPeso'].' '.$PesIncorrecta) ?></td>
				<td class="text-center"><?php echo utf8_encode($row['ajusteRenal'].' '.$RenIncorrecta) ?></td>
				<td class="text-center"><?php echo utf8_encode($row['contraindicaciones']) ?></td>
				<td class="text-center"><?php echo utf8_encode($row['reco']) ?></td>
			</tr>
		</table>
		<?php
		$dosis=$row['dosis'];
		$idMed = trim($row['idMedicamento']);
		$queryDss = "SELECT d.diaConsumo,d.hrConsumo,l.nombreLugarHist,re.nombreRecHist,d.notas
					FROM paciente AS p
					LEFT JOIN historicodosis AS d ON p.numeroExpediente=d.numeroExpediente AND p.folio=d.folio
					LEFT JOIN lugarhistorico AS l ON d.lugarPrescripcion=l.idLugarHist
					LEFT JOIN recomendacionhist AS re ON d.idRecomendacion=re.idRecomendacionHist
					LEFT JOIN medpacientes AS m ON d.idMedPaciente=m.id
					WHERE p.numeroExpediente='$expediente_pac' AND (p.folio = 0 || p.folio= '$folio_pac') AND d.idMedicamento = '$idMed' AND m.dosis='$dosis'
					ORDER BY d.diaConsumo";
		$result2 = mysqli_query($conexion, $queryDss) or die (mysqli_error($conexion));
		$d = 1;
		$dss = NULL;
		if($result2 != NULL){
			$dss = "<br/><strong> &nbsp;DOSIS: </strong>";
		}
		echo $dss;
		echo '<table style="width: 90%"  border="5px solid black;" align="center">
			<th class="auto-style7">&nbsp;No.&nbsp;</th>
			<th class="auto-style7">&nbsp;DÍA CONSUMO&nbsp;</th>
			<th class="auto-style7">&nbsp;HORA CONSUMO&nbsp;</th>
			<th class="auto-style7">&nbsp;LUGAR DE PRESCRIPCIÓN&nbsp;</th>
			<th class="auto-style7">&nbsp;RECOMENDACIÓN&nbsp;</th>
			<th class="auto-style7">&nbsp;OBSERVACIONES&nbsp;</th>';
		while($rowD = mysqli_fetch_array($result2)){ ?>
			<tr>
				<td class="text-center"><?php echo $d++ ?></td>
				<td class="text-center"><?php echo $rowD['diaConsumo']?></td>
				<td class="text-center"><?php echo $rowD['hrConsumo']?></td>
				<td class="text-center"><?php echo utf8_encode($rowD['nombreLugarHist']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowD['nombreRecHist']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowD['notas']) ?></td>
			</tr>
			
	<?php } 
		echo '</table>';
	?>
	
	<?php
		#$idMed = trim($row['idMedicamento']);
		$queryDesc = "SELECT idTiempoHist,l.nombreLugarHist,r.nombreRecHist,recomendacionEgreso
						FROM historicomed AS h
						LEFT JOIN medpacientes as m ON h.idMedPaciente=m.id
						LEFT JOIN lugarhistorico AS l ON h.idLugarHist=l.idLugarHist
						LEFT JOIN recomendacionhist AS r ON h.idRecomendacionHist=r.idRecomendacionHist
						WHERE m.numeroExpediente = '$expediente_pac' AND (m.folio = 0 || m.folio= '$folio_pac') AND h.idMedicamento= '$idMed'";
		$result3 = mysqli_query($conexion, $queryDesc) or die (mysqli_error($conexion));
		$dss = NULL;
		/*if($result3 != NULL){
			$desc = "<br/><strong> &nbsp;DESCONTINUADO: </strong>";
		}
		echo $desc;*/
		echo '<table style="width: 90%"  border="5px solid black;" align="center">
			<th class="auto-styleDesc">&nbsp;DÍA&nbsp;</th>
			<th class="auto-styleDesc">&nbsp;LUGAR&nbsp;</th>
			<th class="auto-styleDesc">&nbsp;RECOMENDACIÓN&nbsp;</th>
			<th class="auto-styleDesc">&nbsp;OBSERVACIONES&nbsp;</th>';
		while($rowDe = mysqli_fetch_array($result3)){ ?>
			<tr>
				<td class="text-center"><?php echo $rowDe['idTiempoHist']?></td>
				<td class="text-center"><?php echo utf8_encode($rowDe['nombreLugarHist']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowDe['nombreRecHist']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowDe['recomendacionEgreso']) ?></td>
			</tr>
	<?php } 
	echo '</table><hr size="5px">';
	} ?>
	<!----------------------------------------------------------------------RECUADRO DE INTERACCIONES --------------------------------------------------------------------->
	<hr/>
	<strong>&nbsp;&nbsp; <span class="auto-style2">INTERACCIONES:</span></strong>
	<?php
		#$idMed = trim($row['idMedicamento']);
		$queryInt = "SELECT idInteraccion,nombreFarmaco,CASE nombreFarmaco2 WHEN '' THEN alimento ELSE nombreFarmaco2 END AS farmacoAlimento,
								descEfecto,nombreSeveridad,descripcion, CASE duplicidadTerapeutica WHEN '1' THEN 'SI' ELSE 'NO' END AS dupTep, CASE recomendacion WHEN '1' THEN 'SI' ELSE 'NO' END AS reco,l.nombreLugarHist, i.fechaGuardado
						FROM interacciones AS i
						LEFT JOIN severidadinteraccion as s ON i.severidad=s.idSeveridad
						LEFT JOIN lugarhistorico AS l ON i.lugarInteraccion=l.idLugarHist
						WHERE i.numeroExpediente='$expediente_pac' AND (i.folio = 0 || i.folio= '$folio_pac')";
			$resInt = mysqli_query($conexion, $queryInt) or die (mysqli_error($conexion));
		echo '<table style="width: 100%"  border="5px solid black;" align="center">
			<th class="auto-styleInt">&nbsp;No.&nbsp;</th>
			<th class="auto-styleInt">&nbsp;FARMACO&nbsp;</th>
			<th class="auto-styleInt">&nbsp;FARMACO/ALIMENTO&nbsp;</th>
			<th class="auto-styleInt">&nbsp;DESCRIPCIÓN DEL EFECTO&nbsp;</th>
			<th class="auto-styleInt">&nbsp;SEVERIDAD DE INTERACCIÓN&nbsp;</th>
			<th class="auto-styleInt">&nbsp;DESCRIPCIÓN DE CONTRAINDICACIONES &nbsp;</th>
			<th class="auto-styleInt">&nbsp;DUPLICIDAD TERAPÉUTICA&nbsp;</th>
			<th class="auto-styleInt">&nbsp;RECOMENDACIÓN&nbsp;</th>
			<th class="auto-styleInt">&nbsp;LUGAR DE INTERACCIÓN&nbsp;</th>
			<th class="auto-styleInt">&nbsp;FECHA DE CAPTURA&nbsp;</th>';
			$i = 1;
		while($rowI = mysqli_fetch_array($resInt)){ 
		if($rowI['fechaGuardado'] != NULL){
				$date1 = date_create_from_format('Y-m-d',$rowI['fechaGuardado'])->format('d-m-Y');
			} else {
				$date1 = NULL;
			}
		?>
			<tr>
				<td class="text-center"><?php echo $i++ ?></td>
				<td class="text-center"><?php echo $rowI['nombreFarmaco']?></td>
				<td class="text-center"><?php echo utf8_encode($rowI['farmacoAlimento']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowI['descEfecto']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowI['nombreSeveridad']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowI['descripcion']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowI['dupTep']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowI['reco']) ?></td>
				<td class="text-center"><?php echo utf8_encode($rowI['nombreLugarHist']) ?></td>
				<td class="text-center"><?php echo $date1 ?></td>
			</tr>
	<?php } 
	echo '</table>';
	?>
	</div>
</body>

</html>
