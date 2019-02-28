<?php
	setlocale(LC_ALL,'');
	require_once('conexion/config.php');

	$fecha1 = NULL;
	$fecha2 = NULL;
	
	if (isset($_POST['export']))
	{
		$excel =$_POST['export'];
	}else{
		$excel =NULL;
	}

	$nombre = $_POST['nombre'];
	#header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-type: application/x-msexcel; charset=utf-8");
	header("Content-disposition: attachment; filename=$nombre.xls");
	
if($nombre == 'PerfilFarmacoTerapeutico'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	#Vamos a generar otro excel con TODOS los DATOS del paciente, medicamentos, dosis por medicamento, etc.
	$excel= "REPORTE DE PERFIL FÁRMACO TERAPÉUTICO   ".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	$excel.="Consecutivo\tExpediente\tNombre Paciente\tEdad\tSexo\tFecha De Nacimiento\tAlergias\tPeso\tTalla\tHabitacion\tFecha De Ingreso\tFecha De Egreso\tMedico\tEspecialidad\t";
	$excel.="Diagnostico\tConcomitantes\tDep De Creatinina\tMedicamentosCasa\tCultivo\tTipoMedicamento\tOtroTipoMedicamento\tFecha De Inicio\tNombre De Medicamento\tSAL\tDosis\tVía De Admon\t";
	$excel.="Frecuencia\tOtraFrecuencia\tDosisMaxima\tDosisIncorrecta\tRevision Peso\tPesoIncorrecto\tAjuste Renal\tRenalIncorrecto\tContraindicaciones\tDia De Consumo\tHora De Consumo\tLugar De Prescripción\t";
	$excel.="Recomendación\tObservaciones\tEgreso\tFechaDeConciliaciónEgreso\tObservacionesEgreso\tFarmaco Interacción\tFarmaco Interacción2\tAlimento Interacción\tDescripción Del Efecto\tSeveridad\t";
	$excel.="DescripciónContraindicación/Precauciones a Medicamentos\tRecomendacion\tLugar De Interacción\n\n";
	#Primero los datos Basicos
	$queryExcelFT = "SELECT p.numeroExpediente,nombre,edad,sexo,fechaNacimiento,alergias,peso,talla,habitacion,
						fechaIngreso,fechaEgreso,medico,especialidad,diagnostico,concomitantes,depCreatinina,
						t.nombreTipo,m.nombreOtroTipo,m.fechaInicio,m.nombreMedicamento,m.dosis,v.viaAdmon,f.nombreFrecuencia,m.otraFrecuencia,
						r.dosisMax,r.revisionPeso,r.ajusteRenal,r.contraindicaciones,d.diaConsumo,d.hrConsumo,l.nombreLugarHist,
						re.nombreRecHist, d.notas, CASE WHEN h.idRecomendacionHist = '2' THEN 'CONCILIACION AL EGRESO' END AS egreso,h.idTiempoHist, 
						h.recomendacionEgreso,i.nombreFarmaco,i.nombreFarmaco2,i.alimento,i.descEfecto,s.nombreSeveridad,i.descripcion,
						CASE i.recomendacion WHEN '1' THEN 'SI' ELSE 'NO' END AS reco,
						l1.nombreLugarHist,
						CASE r.dosisIncorrecta WHEN '1' THEN 'SI' ELSE 'NO' END AS dssInc,
						CASE r.pesoIncorrecto WHEN '1' THEN 'SI' ELSE 'NO' END AS pesoInc,
						CASE r.renalIncorrecto WHEN '1' THEN 'SI' ELSE 'NO' END AS renalInc,
						m.sal, p.medicamentoCasa, p.cultivo
						FROM paciente AS p
						LEFT JOIN medpacientes AS m ON p.numeroExpediente=m.numeroExpediente
						LEFT JOIN tipomedicamento AS t ON m.tipoMedicamento=t.tipoMedicamento
						LEFT JOIN viadeadmon AS v ON m.idViaAdmon=v.idViaAdmon
						LEFT JOIN frecuencia AS f ON m.frecuencia=f.idFrecuencia
						LEFT JOIN revisiones AS r ON m.idRevision=r.idRevision
						LEFT JOIN historicodosis AS d ON m.id=d.idMedPaciente
						LEFT JOIN lugarhistorico AS l ON d.lugarPrescripcion=l.idLugarHist
						LEFT JOIN recomendacionhist AS re ON d.idRecomendacion=re.idRecomendacionHist
						LEFT JOIN interacciones AS i ON i.numeroExpediente=p.numeroExpediente AND i.farmaco=m.idMedicamento
						LEFT JOIN lugarhistorico AS l1 ON i.lugarInteraccion=l1.idLugarHist
						LEFT JOIN severidadinteraccion AS s ON i.severidad=s.idSeveridad
						LEFT JOIN historicomed AS h ON m.id=h.idMedPaciente
						WHERE p.fechaIngreso >= '$fecha1' AND p.fechaIngreso <= '$fecha2'
						ORDER BY p.numeroExpediente";
	$result1 = mysqli_query($conexion, $queryExcelFT) or die (mysqli_error($conexion));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		$excel.= $c++."\t".$row[0]."\t".utf8_encode($row[1])."\t".$row[2]."\t".$row[3]."\t".$row[4]."\t";
		$excel.= utf8_encode($row[5])."\t".$row[6]."\t".$row[7]."\t".$row[8]."\t".$row[9]."\t".$row[10]."\t".utf8_encode($row[11])."\t".utf8_encode($row[12])."\t";
		$excel.= utf8_encode($row[13])."\t".utf8_encode($row[14])."\t".utf8_encode($row[15])."\t".utf8_encode($row[48])."\t".utf8_encode($row[49])."\t".utf8_encode($row[16])."\t".utf8_encode($row[17])."\t".utf8_encode($row[18])."\t";
		$excel.= utf8_encode($row[19])."\t".utf8_encode($row['sal'])."\t".utf8_encode($row[20])."\t".utf8_encode($row[21])."\t".utf8_encode($row[22])."\t".utf8_encode($row[23])."\t".utf8_encode($row[24])."\t".$row[44]."\t";
		$excel.= utf8_encode($row[25])."\t".$row[45]."\t".utf8_encode($row[26])."\t".$row[46]."\t".utf8_encode($row[27])."\t".utf8_encode($row[28])."\t".utf8_encode($row[29])."\t".utf8_encode($row[30])."\t";
		$excel.= utf8_encode($row[31])."\t".utf8_encode($row[32])."\t".utf8_encode($row[33])."\t".utf8_decode($row[34])."\t".utf8_encode($row[35])."\t".utf8_encode($row[36])."\t";
		$excel.= utf8_encode($row[37])."\t".utf8_encode($row[38])."\t".utf8_encode($row[39])."\t".utf8_encode($row[40])."\t".utf8_encode($row[41])."\t".utf8_encode($row[42])."\t";
		$excel.= utf8_encode($row[43])."\t";
		$excel.= "\n";
	}
}

if($nombre == 'Interacciones'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	#Vamos a generar otro excel con TODOS los DATOS del paciente, medicamentos, dosis por medicamento, etc.
	$excel= "REPORTE DE PERFIL FÁRMACO TERAPÉUTICO   ".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	$excel.="Consecutivo\tExpediente\tNombre Paciente\tFecha De Ingreso\tFecha De Egreso\t";
	$excel.="Farmaco Interacción\tFarmaco Interacción2\tAlimento Interacción\tDescripción Del Efecto\tSeveridad\t";
	$excel.="Descripción De Contraindicaciones\tRecomendacion\tLugar de Interacción\n";
	
	$queryExcelIT = "SELECT p.numeroExpediente,nombre,fechaIngreso,fechaEgreso,i.nombreFarmaco,i.nombreFarmaco2,i.alimento,
							i.descEfecto,s.nombreSeveridad,i.descripcion,CASE i.recomendacion WHEN '1' THEN 'SI' ELSE 'NO' END AS reco,i.lugarInteraccion
					FROM interacciones AS i
					LEFT JOIN paciente AS p ON i.numeroExpediente=p.numeroExpediente
					LEFT JOIN severidadinteraccion AS s ON i.severidad=s.idSeveridad
					WHERE p.fechaIngreso >= '$fecha1' AND p.fechaIngreso <= '$fecha2'
					ORDER BY p.fechaIngreso";
	$result1 = mysqli_query($conexion, $queryExcelIT) or die (mysqli_error($conexion));
	$i = 1;
	while($row = mysqli_fetch_array($result1)){
		$excel.= $i++."\t".$row[0]."\t".utf8_encode($row[1])."\t".$row[2]."\t".$row[3]."\t".utf8_encode($row[4])."\t";
		$excel.= utf8_encode($row[5])."\t".utf8_encode($row[6])."\t".utf8_encode($row[7])."\t".utf8_encode($row[8])."\t".utf8_encode($row[9])."\t".$row[10]."\t".utf8_encode($row[11])."\t";
		#$excel.= utf8_encode($row[13])."\t".utf8_encode($row[14])."\t".utf8_encode($row[15])."\t".utf8_encode($row[16])."\t".utf8_encode($row[17])."\t".utf8_encode($row[18])."\t";
		#$excel.= utf8_encode($row[19])."\t".utf8_encode($row[20])."\t".utf8_encode($row[21])."\t".utf8_encode($row[22])."\t".utf8_encode($row[23])."\t".utf8_encode($row[24])."\t";
		#$excel.= utf8_encode($row[25])."\t".utf8_encode($row[26])."\t".utf8_encode($row[27])."\t".utf8_encode($row[28])."\t".utf8_encode($row[29])."\t".utf8_encode($row[30])."\t";
		#$excel.= utf8_encode($row[31])."\t".utf8_encode($row[32])."\t".utf8_encode($row[33])."\t".utf8_decode($row[34])."\t".utf8_encode($row[35])."\t".utf8_encode($row[36])."\t";
		#$excel.= utf8_encode($row[37])."\t".utf8_encode($row[38])."\t".utf8_encode($row[39])."\t".utf8_encode($row[40])."\t".utf8_encode($row[41])."\t".utf8_encode($row[42])."\t";
		$excel.= "\n";
	}
}

if($nombre == 'ConteoPacientes'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	/*$queryExcelCP = "SELECT count(numeroExpediente)
					FROM paciente 
					WHERE fechaIngreso BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY fechaIngreso";
	$row0 = mysqli_fetch_array($result0);*/
	$queryExcelCP ="SELECT DISTINCT p.numeroExpediente
					FROM paciente AS p
					LEFT JOIN historicodosis AS h ON p.folio=h.folio
					LEFT JOIN historicomed AS m on h.idMedPaciente=m.idMedPaciente
					WHERE fechaIngreso BETWEEN '$fecha1' AND '$fecha2'
					GROUP BY p.numeroExpediente,p.fechaIngreso";
	$result0 = mysqli_query($conexion, $queryExcelCP) or die (mysqli_error($conexion));
	$row0 = mysqli_num_rows($result0);
	
	#Vamos a generar otro excel con TODOS los DATOS del paciente, medicamentos, dosis por medicamento, etc.
	$excel= "REPORTE DE CONTEO DE PACIENTES   ".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	$excel.= "TOTAL DE CONTEO DE PACIENTES:   ".$row0."\n";
	$excel.="Consecutivo\tExpediente\tNombre Paciente\tFecha De Ingreso\tFecha De Egreso\tAlergias\tSexo\tEdad\tDiagnóstico\tEspecialidad\tMed. en Quirófano\tMed. al Egreso\n";
		
	$queryExcelIT = "SELECT DISTINCT p.numeroExpediente,p.nombre,p.fechaIngreso,p.fechaEgreso,alergias,
					sexo,edad,diagnostico,especialidad,
					(SELECT CASE h.lugarPrescripcion WHEN '2' THEN '1' ELSE '0' END AS QF
					FROM paciente AS p1
					LEFT JOIN historicodosis AS h ON p1.folio=h.folio
					WHERE fechaIngreso BETWEEN '$fecha1' AND '$fecha2' AND h.lugarPrescripcion=2 AND p1.numeroExpediente=p.numeroExpediente
					GROUP BY p1.numeroExpediente,fechaIngreso LIMIT 1) AS QF,
					(SELECT CASE idRecomendacionHist WHEN '2' THEN '1' ELSE '0' END AS CE
					FROM paciente AS p2
					LEFT JOIN medpacientes AS m ON p2.folio=m.folio
					LEFT JOIN historicomed AS hm ON hm.idMedPaciente=m.id
					WHERE fechaIngreso BETWEEN '$fecha1' AND '$fecha2' AND idRecomendacionHist=2 AND p2.numeroExpediente=p.numeroExpediente
					GROUP BY p2.numeroExpediente,fechaIngreso LIMIT 1) AS CE
					FROM paciente AS p
					LEFT JOIN historicodosis AS h ON p.folio=h.folio
					WHERE fechaIngreso BETWEEN '$fecha1' AND '$fecha2'
					GROUP BY p.numeroExpediente,p.fechaIngreso
					ORDER BY p.fechaIngreso";
	$result1 = mysqli_query($conexion, $queryExcelIT) or die (mysqli_error($conexion));
	$i = 1;
	while($row = mysqli_fetch_array($result1)){
		if($row[9] == '' || $row[9] == NULL){
			$row[9] = '0';
		}
		if($row[10] == '' || $row[9] == NULL){
			$row[10] = '0';
		}
		
		$excel.= $i++."\t".$row[0]."\t".utf8_encode($row[1])."\t".$row[2]."\t".$row[3]."\t".$row[4]."\t".$row[5]."\t".$row[6]."\t".utf8_encode($row[7])."\t".utf8_encode($row[8])."\t".$row[9]."\t".$row[10]."\t";
		$excel.= "\n";
	}
}

if($nombre == 'partos'){
	require('partos/eliminar/conexion.php');
	
	#Vamos a generar otro excel con TODOS los DATOS del paciente, medicamentos, dosis por medicamento, etc.
	$excel= "REPORTE DE PARTOS REGISTRADOS  AL ".utf8_encode(strftime('%d de %B de %Y'))."\n";
	$excel.="No., Nombre Paciente, Fecha Probable de Parto, Tipo de Cirugia, Medico Tratante\n";
		
	$query="SELECT id, fecha, nombrePaciente, cirugia, cirujano FROM datosnuevosparto WHERE estatusCirugia !=4 ORDER BY fecha ASC";
	
	$resultado=$mysqli->query($query);
	$i = 1;
	while($row=$resultado->fetch_assoc()){
		$excel.= $i++.", ".utf8_encode($row['nombrePaciente']).", ".$row['fecha'].", ".utf8_encode($row['cirugia']).", ".utf8_encode($row['cirujano']).", ";
		$excel.= "\n";
	}
	print $excel;
}

if( $nombre != 'partos'){
	print utf8_decode($excel);
}
	exit;

?>