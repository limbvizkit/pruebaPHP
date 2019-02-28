<?php
	setlocale(LC_ALL,'');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configEpidemio.php');

	$fecha1 = NULL;
	$fecha2 = NULL;
	$nombre = NULL;

	if (isset($_POST['nombre']))
	{
		$nombre = $_POST['nombre'];
	}

	if (isset($_GET['nombre']))
	{
		$nombre = $_GET['nombre'];
	}
		
	
	#header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-type: application/x-msexcel; charset=utf-8");
	header("Content-disposition: attachment; filename=$nombre.xls");
/********************************************************************************************************************************************************/
if($nombre == 'RevisionTecnicaHigieneManos'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "Cédula para la verificación de técnica correcta de higiene de manos 1.0   ".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	
	$queryExcelFT = "SELECT *
					FROM tecnicahigienemanos AS t
					LEFT JOIN categoriaprofesional AS c ON t.catProfesional=c.id
					WHERE fechaVerif BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY fechaVerif";
	
	$result1 = mysqli_query($conexionEpidemio, $queryExcelFT) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	$d = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.="\nNo.\tVerificador\tFecha Verificación\tLocalización\tHabitación\tOtra Ubicación\tCategoria\tOtra Cat\tTurno\tTipo Higiene\tSexo\n";
		}
		$excel.= $c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaVerif"]."\t".$row["localizacion"]."\t".$row["habitacion"]."\t".utf8_encode($row["locOtros"])."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["catOtros"])."\t".$row["turno"]."\t".$row["tipoHigiene"]."\t".$row["sexo"]."\n";
	}
	$excel.="\nNo.\t";
	//$excel.= $c;
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	
	$excel.="\nMOMENTOS DE LAVADOS DE MANOS\n1. ANTES DE TENER CONTACTO CON EL PACINTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['antesContactoPaciente']."\t";
	}
	$excel.="\n2.ANTES DE REALIZAR ALGUNA TAREA ASEPTICA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['antesTareaAseptica']."\t";
	}
	$excel.="\n3.DESPUES DE TENER CONTACTO CON EL ENTORNO DEL PACIENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['despuesContactoEntorno']."\t";
	}
	$excel.="\n4.DESPUES DE TENER CONTACTO CON EL PACIENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['despuesContactoPaciente']."\t";
	}
	$excel.="\n5.DESPUES DE TENER CONTACTO CON FLUIDOS DEL PACIENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['despuesContactoFluidos']."\t";
	}
	$excel.="\nMEDIDAS DE PROTECCION GENERAL\n2.1 Retirar alhajas\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['retirarAlhajas']."\t";
	}
	$excel.="\n2.2 Preparar el papel o sanita\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['prepararPapel']."\t";
	}
	$excel.="\n2.3 Mojar las manos y aplicar jabon o aplicar alcohol gel\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['mojarManos']."\t";
	}
	$excel.="\n2.4 Frotar  las palmas en froma circular\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['frotarPalmas']."\t";
	}
	$excel.="\n2.5 Frotar los dorsos de las palma entrelanzando los dedos\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['frotarDorsoPalmas']."\t";
	}
	$excel.="\n2.6 Frotar palma contra palma entrelanzando los dedos\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['frotarPalmaPalma']."\t";
	}
	$excel.="\n2.7 Doblar los dedos de ambas manos y frotar los nudillos con la manos contralateral\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['frotarNudillos']."\t";
	}
	$excel.="\n2.8 Frotar pulgares con movimientos ciruculares\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['frotarPulgares']."\t";
	}
	$excel.="\n2.9 Frotar las puntas de los dedos contra  la mano contraria\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['frotarPuntasDedos']."\t";
	}
	$excel.="\n2.10 Enjuagar con agua corriente\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['enjuagarConAgua']."\t";
	}
	$excel.="\n2.11 Secar manos con sanita o papel desechable desde la punta de la manos haceia la muñeca\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['secarManos']."\t";
	}
	$excel.="\n2.12 Cerrar la llave con la sanita\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['cerrarLlave']."\t";
	}
	$excel.="\n2.13 Llevaba guantes se omitio la higiene de manos\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['llevaGuantes']."\t";
	}
	$excel.="\nOBSERVACIONES\t";	
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
	
}

/********************************************************************************************************************************************************/
if($nombre == 'RevisionConsumiblesaHigieneManos'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "Cédula para la verificación de estructura y consumibles para la higiene de manos 1.1   ".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	
	$queryExcelFT = "SELECT *
					FROM consumibleshigienemanos
					WHERE fechaVerificacion BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY fechaVerificacion";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelFT) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.="\nNo.\tVerificador\tFecha Verificación\tLocalización del Dispositivo\tHabitación\tOtra Ubicación\tTurno\n";
		}
		
		$excel.= $c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaVerificacion"]."\t".$row["localizacion"]."\t".$row["habitacion"]."\t".utf8_encode($row["locOtros"])."\t".$row["turno"]."\n";
	}
	$excel.="\nNo.\t";
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	$excel.="\nCRITERIOS DE VERIFICACIÓN\n1. Abastecimiento\n1.1. El dispositivo tiene suficiente cantidad de jabón\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['suficienteJabon']."\t";
	}
	$excel.="\n1.2. El dispositivo tiene suficiente cantidad de gel-alcohol\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['suficienteGel']."\t";
	}
	$excel.="\n1.3 El dispositivo tiene suficiente cantidad de toallas para el secado de manos\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['suficienteToallas']."\t";
	}
	$excel.="\n2. Señalización\n2.1 Cuenta con señalización sobre los 5 momentos de la higiene de manos\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['senal5Momentos']."\t";
	}
	$excel.="\n2.2 Cuenta con señalización sobre la técnica correcta de la higiene de manos\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['senalTecnicaManos']."\t";
	}
	$excel.="\n3. Funcionalidad del Dispositivo\n3.1 El mecanismo del dispositivo está funcional y despacha satisfactoriamente el producto\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['mecanismoFuncional']."\t";
	}
	$excel.="\n3.2 El dispositivo cuenta con sistemas de solución cerrados\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['solucionCerrados']."\t";
	}
	$excel.="\n3.3 Se encuentra libre de derrames, goteo de producto\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['libreDerramesGoteo']."\t";
	}
	$excel.="\n3.4 Está libre de polvo, suciedad, manchas y/o residuo del producto\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['librePolvoManchas']."\t";
	}
	$excel.="\n3.5 La superficie donde está instalado el dispositivo está libre de polvo, suciedad, manchas y/o residuo del producto\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['superficieLibrePolvo']."\t";
	}
	$excel.="\n3.6 Cuenta con etiqueta que identifique el producto que contiene\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['etiquetaIdentif']."\t";
	}
	$excel.="\n4. Uso adecuado de soluciones para la higiene de manos\n4.1 Si es un área crítica utiliza jabón con clorhexidina al 4%\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['jabonClorhexidina']."\t";
	}
	$excel.="\n4.2 El alcohol gel tiene por sustancia activa alcohol etílico al 70% o equivalente\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['alcoholEtilico']."\t";
	}
	$excel.="\n4.3 Si es un área crítica utiliza gel-alcohol al 70% con clorhexidina al 4%\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['gelAlcoholClorhexidina']."\t";
	}
	$excel.="\n\nAviso a Servicios Generales\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['avisoServGral']."\t";
	}
	$excel.="\nOBSERVACIONES\t";	
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}

}
/********************************************************************************************************************************************************/
if($nombre == 'AccesosVascPerInst'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "PROGRAMA DE PREVENCION DE INFECCIONES ASOCIADAS A CATETER PERIFERICO   \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "HOJA DE SEGUIMIENTO DEL PAQUETE BUNDLE PARA PREVENCION DE INFECCIONES EN TORRENTE SANGUINEO.\n";
	
	$queryExcelAVP = "SELECT *
						FROM instalacionavp AS i
						LEFT JOIN categoriaprofesional AS c ON i.personaInstalo=c.id
						WHERE numeroExpediente='$exp' AND folio='$folio'
						ORDER BY fechaInstalacion";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\tSEXO: ".$sexo."\n";
			$excel.="\nNo.\tVerificador\tFecha Instalación\tUBICACIÓN\tHabitación\tOtra Ubicación\tTurno\tProfesional Instaló\tNombre Instaló\n";
		}
		$excel.=$c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaInstalacion"]."\t".$row["ubicacion"]."\t".$row["habitacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["turno"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombreInstalo"])."\n";	
	}
	
	$excel.="\nNo.\t";
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	$excel.="\nCRITERIOS DE VERIFICACIÓN\n1. REALIZÓ TÉCNICA CORRECTA DE HIGIENE DE MANOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['manosTecPac']."\t";
	}
	$excel.="\n2. REALIZÓ LOS MOMENTOS DE LAVADO DE MANOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['manosPac']."\t";
	}
	$excel.="\n3. UTILIZÓ MEDIDAS DE PROTECCION UNIVERSAL (GUANTES,CUBREBOCAS,etc.)\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['proteccPac']."\t";
	}
	$excel.="\n4. LA ZONA A CANALIZAR ES UN MIEMBRO SUPERIOR (evitó accesos femorales)\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['superiorPac']."\t";
	}
	$excel.="\n5. REALIZÓ LA ASEPSIA Y ANTISEPSIA CON CLORHEXIDINA ALCOHOLICA AL 2% EN PACIENTES >2 MESES EN LA ZONA A PUNCIONAR\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['asepsiaPac']."\t";
	}
	$excel.="\n6. ESPERÓ QUE EL AREA ESTUVIERA SECA ANTES DE REALIZAR LA PUNCION\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['puncionPac']."\t";
	}
	$excel.="\n7. USÓ APOSITO TRANSPARENTE PARA CUBRIR EL SITIO DE PUNCIÓN\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['apositoPac']."\t";
	}
	$excel.="\n8. VERIFICÓ QUE EL SITIO DE INSERCION SE ENCUENTRE VISIBLE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['inserPac']."\t";
	}
	$excel.="\n9. VERIFICÓ EL MEMBRETE DE IDENTIFICACIÓN CON LOS DATOS COMPLETOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['identificPac']."\t";
	}
	$excel.="\n10. VERIFICÓ SI EL PACIENTE TENÍA PUNCIONES ANTERIORES\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['puncAntPac']."\t";
	}
	$excel.="\nOBSERVACIONES\t";
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
	
}	
/********************************************************************************************************************************************************/
if($nombre == 'AccesosVascPerManto'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "PROGRAMA DE PREVENCION DE INFECCIONES ASOCIADAS A CATETER PERIFERICO   ".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "BUNDLE MANTENIMIENTO DE CATÉTER PERIFÉRICO.\n";	
	$queryExcelAVP = "SELECT *
					FROM mantoavp
					WHERE numeroExpediente='$exp' AND folio='$folio'
					ORDER BY fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	$d = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\n";
			$excel.="\nNo.\tVerificador\tFecha Instalación\n";
		}		
		$excel.=$c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaInst"]."\n";
	}
	
	$excel.="\nNo.\t";
	//$excel.= $c;
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	
	$excel.="\n1. INDENTIFICO AL PACIENTE CORRECTAMENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['identPac']."\t";
	}
	$excel .= "\n2. INFORMÓ AL PACIENTE O FAMILIARES SOBRE EL PROCESO A REALIZAR\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['infoPac']."\t";
	}
	$excel .= "\n3. REALIZO HIGIENE DE MANOS ANTES DE LA MANIPULACIÓN DEL SITIO DE INSERCIÓN DEL CATÉTER\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['higieneManPac']."\t";
	}
	$excel .= "\n4. VALORA CONDICIONES DEL ACCESO VENOSO PARA IDENTIFICAR OPORTUNAMENTE SIGNOS DE INFECCIÓN\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['condicionesPac']."\t";
	}
	$excel .= "\n5. VERIFICA PERMEABILIDAD DEL CATÉTER CON TÉCNICA ASÉPTICA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['permeaPac']."\t";
	}
	$excel .= "\n6. REEMPLAZO APÓSITO DE ACUERDO A NORMATIVA ESTABLECIDA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['apositoPac']."\t";
	}
	$excel .= "\n7. CAMBIO SOLUCIONES Y EQUIPOS DE ACUERDO A LA NORMATIVIDAD\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['solucionesPac']."\t";
	}
	$excel .= "\n8. MANTIENE EL SISTEMA DE INFUSIÓN CERRADO Y EVITA DESCONEXIONES INNECESARIAS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['infusionPac']."\t";
	}
	$excel .= "\n9. DESINFECTA LOS PUERTOS Y CONEXIONES ANTES DE MANIPULARLOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['puertosPac']."\t";
	}
	$excel .= "\n10. DESINFECTA LA VÍA VENOSA DESPUÉS DE LA ADMINISTRACIÓN DE MEDICAMENTOS O HEMODERIVADOS DE ACUERDO AL PROTOCOLO\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['viaPac']."\t";
	}
	$excel .= "\n11. REGISTRA EN FORMATOS ESTABLECIDOS LAS ACCIONES REALIZADAS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['formatosPac']."\t";
	}
	$excel .= "\n12. RETIRA EL CATETER PREVIA INDICACIÓN MÉDICA O ANTE LA PRESENCIA DE UNA COMPLICACIÓN\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['retirarPac']."\t";
	}
	
}
/********************************************************************************************************************************************************/
if($nombre == 'SitiosQuirurgInst'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "PROGRAMA DE PREVENCIÓN DE INFECCIONES ASOCIADAS A SITIO QUIRÚRGICO \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "HOJA DE SEGUIMIENTO PAQUETE BUNDLE PARA PREVENCIÓN DE INFECCIÓN EN SITIO QUIRÚRGICO.\n";
	
	$queryExcelSV = "SELECT *
					FROM instalacionsq AS i
					LEFT JOIN categoriaprofesional AS c ON i.instalo=c.id
					WHERE numeroExpediente='$exp' AND folio='$folio'
					ORDER BY fechaInst";
	
	$result1 = mysqli_query($conexionEpidemio, $queryExcelSV) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	$d = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\tSEXO: ".$sexo."\n";
			$excel.="\nNo.\tVerificador\tFecha Instalación\tUBICACIÓN\tHabitación\tOtra Ubicación\tTurno\tProfesional que Realizó\tNombre profesional Realizó\tÁrea\tOtra Área\tCirugía\tTipo Cirugía\t\n";
		}
		$excel.=$c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaInst"]."\t".$row["ubicacion"]."\t".$row["habitacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["turno"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombInstalo"])."\t".utf8_encode($row["area"])."\t".utf8_encode($row["otraArea"])."\t".utf8_encode($row["cirugia"])."\t".utf8_encode($row["tipoCirugia"])."\n";
		
	}
	$excel.="\n CRITERIOS DE VERIFICACIÓN";
	$excel.="\nNo.\t";
	//$excel.= $c;
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	
	$excel.="\n1. CORROBORÓ LA IDENTIDAD DEL PACIENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['identidadPac']."\t";
	}
	$excel .= "\n2. REALIZÓ LA HIGIENE DE MANOS, DURANTE LOS MOMENTOS ESTABLECIDOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['manosPac']."\t";
	}
	$excel .= "\n3. VERIFICÓ QUE EL MATERIAL SEA ESTERIL\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['materialPac']."\t";
	}
	$excel .= "\n4. VERIFICÓ QUE SE LLEVARA LA TECNICA ASEPTICA DURANTE EL PROCEDIMIENTO\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['asepticaPac']."\t";
	}
	$excel .= "\n5. VERIFICÓ QUE SE REALIZARA CORTE DE VELLO O CABELLO EN EL CASO DE SER NECESARIO, CON MAQUINA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['cortePac']."\t";
	}
	$excel .= "\n6. VERIFICÓ QUE LA TEMPERATURA CORPORAL DEL PACIENTE SE ENCONTRARA DENTRO DE LOS PARAMETROS NORMALES\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['tempPac']."\t";
	}
	$excel .= "\n7. VERIFICÓ QUE SE REALIZARA ANTIBIOPROFILAXIS ADECUADA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['antibioPac']."\t";
	}
	$excel .= "\n8. VERIFICÓ QUE LOS PARAMETROS DE GLUCOSA DEL PACIENTE FUERAN NORMALES\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['glucosaPac']."\t";
	}
	
	$excel.="\nOBSERVACIONES\t";
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
	
}

/********************************************************************************************************************************************************/
if($nombre == 'SondaVesicalInst'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "PROGRAMA DE PREVENCION DE INFECCIONES ASOCIADAS A SONDA VESICAL \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "PAQUETE BUNDLE PARE PREVENCION DE INFECCIONES POR CATETER URINARIO.\n";
	
	$queryExcelSV = "SELECT *
					FROM instalacionsv AS i
					LEFT JOIN categoriaprofesional AS c ON i.personaInstalo=c.id
					WHERE numeroExpediente='$exp' AND folio='$folio'
					ORDER BY fechaProcedimiento";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelSV) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	$d = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\tSEXO: ".$sexo."\n";
			$excel.="\nNo.\tVerificador\tFecha Instalación\tUBICACIÓN\tHabitación\tOtra Ubicación\tTurno\tProfesional Instaló\tNombre Instaló\n";
		}
		$excel.=$c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaProcedimiento"]."\t".$row["ubicacion"]."\t".$row["habitacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["turno"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombreInstalo"])."\n";
		
	}
	$excel.="\n CRITERIOS DE VERIFICACIÓN";
	$excel.="\nNo.\t";
	//$excel.= $c;
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	
	$excel.="\n1. VERIFICÓ LA INDICACIÓN EN EL EXPEDIENTE DE USO DE LA SONDA VESICAL\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['sondaPac']."\t";
	}
	$excel .= "\n2. APLICÓ TÉCNICA ADECUADA DE LAVADO DE MANOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['manosPac']."\t";
	}
	$excel .= "\n3. UTILIZÓ BARRERA MAXIMA PARA LA INSTALACION\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['barreraPac']."\t";
	}
	$excel .= "\n4. VERIFICÓ TÉCNICA APROPIADA PARA LA INSERCIÓN DE LA SONDA VESICAL\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['inserPac']."\t";
	}
	$excel .= "\n5. VERIFICÓ QUE LA SONDA FUERA FIJADA DE ACUERDO AL SEXO DEL PACIENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['fijadaPac']."\t";
	}
	$excel .= "\n6. VERIFICÓ QUE LA BOLSA RECOLECTORA SE MANTIENE POR DEBAJO DEL NIVEL DE LA VEJIGA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['vejigaPac']."\t";
	}
	$excel .= "\n7. VERIFICÓ QUE SE MANTIENGA UN FLUJO SIN OBSTRUCCIÓN\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['flujoPac']."\t";
	}
	$excel .= "\n8. VERIFICÓ QUE SE HA DRENADO PERIODICAMENTE LA BOLSA COLECTORA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['drenadoPac']."\t";
	}
	$excel .= "\n9. VERIFICÓ SI EL PACIENTE TIENE OTROS SITIOS ACTIVOS DE INFECCION\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['sitiosPac']."\t";
	}
	$excel .= "\n10. VERIFICÓ SI EL PACIENTE PRESENTA ALGUNA CO-MORBILIDAD (DIABETES,HIPERTENSIÓN,ETC)\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['morbilidadPac']."\t";
	}
	$excel .= "\n11. VERIFICÓ QUE EL PACIENTE Y FAMILIAR RECIBIO INFORMACIÓN ACERCA DE LOS CUIDADOS DE LA SONDA URINARIA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['cuidadosPac']."\t";
	}
	$excel .= "\n12. IDENTIFICÓ Y REPORTÓ SI EXISTEN SIGNOS QUE SE SOSPECHE INFECCIÓN DE VÍAS URINARIAS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['infeccionPac']."\t";
	}
	$excel.="\nOBSERVACIONES\t";	
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
	
}
/********************************************************************************************************************************************************/
if($nombre == 'SondaVesicalManto'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "BUNDLE MANTENIMIENTO DE SONDA VESICAL INSTALADA \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA.\n";
	
	$queryExcelSV = "SELECT *
					FROM mantosv
					WHERE numeroExpediente='$exp' AND folio='$folio'
					ORDER BY fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelSV) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	$d = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\tSEXO: ".$sexo."\n";
			$excel.="\nNo.\tVerificador\tFecha Instalación\n";
		}
		$excel.=$c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaInst"]."\n";
		
	}
	$excel.="\nNo.\t";
	//$excel.= $c;
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	
	$excel.="\nA. La bolsa colectora se mantiene por debajo del nivel de la vejiga (REVISAR QUE LA BOLSA RECOLECTORA)\n1. Se mantiene por debajo del nivel de la vejiga independientemente de la posición\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['nivelPac']."\t";
	}
	$excel .= "\n2. No rebasa más del 75% de la capacidad de la misma\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['rebasaPac']."\t";
	}
	$excel .= "\n3. No está colocada sobre el piso, superficie sucia o cualquier otro recipiente\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['pisoPac']."\t";
	}
	$excel .= "\nB. El catéter está fijado de acuerdo al sexo del paciente (permitiendo la movilidad del paciente sin obstruir la permeabilidad de la sonda y no hay tracción de la misma) (VERIFIQUE FIJACIÓN DE LA SONDA)\n4. Mujeres cara interna del muslo\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['mujerPac']."\t";
	}
	$excel .= "\n5. Hombres cara antero lateral superior del muslo\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['hombrePac']."\t";
	}
	$excel .= "\nC. La sonda se encuentra con membrete de identificación (MEMBRETE DEBE TENER ESCRITO COMO MÍNIMO)\n6. Fecha de instalación. Nombre completo de quién instaló la sonda\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['instaloPac']."\t";
	}
	$excel .= "\nD. El sistema de drenaje se mantiene permanentemente conectado\n7. Se mantiene conectado el sistema de drenaje\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['drenajePac']."\t";
	}
	$excel .= "\nE. Se registran datos referentes al funcionamiento de sonda y tubo drenaje. (OBSERVAR Y VERIFICAR QUE ESTE REGISTRADO EN NOTAS DE ENFERMERÍA)\n8. Sonda y tubo de drenaje permite fluir orina libremente\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['fluirPac']."\t";
	}
	$excel .= "\n9. Que no existan fisuras, ni fugas\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['fugasPac']."\t";
	}
	$excel .= "\n10. Que no estén pinzadas, torcidas, acodados colapsados presionados (barandales cama)\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['barandalesPac']."\t";
	}
	$excel .= "\nF. Repara ausencia o presencia de signos y síntomas que evidencien Infección de tracto urinario. (VERIFICAR NOTAS DE ENFERMERÍA, MÉDICOS Y/O LABORATORIO)\n11. Cuenta con cultivo antes de colocación de sonda y cada 5 días a partir de la fecha de instalación\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['cultivoPac']."\t";
	}
	$excel .= "\n12. Picos febriles, dolor supra púbico o en flanco\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['febrilesPac']."\t";
	}
	$excel .= "\n13. Área peri uretral secreción, prurito, inflamación, etc.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['uretralPac']."\t";
	}
	$excel .= "\n14. Características macroscópicas de orina, turbia, hematuria, sedimento, entre otro\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['orinaPac']."\t";
	}
	
	$excel.="\nOBSERVACIONES\t";	
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
}
/********************************************************************************************************************************************************/
if($nombre == 'VentilacionMecanicaInst'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "PROGRAMA DE PREVENCION DE NEUMONIAS ASOCIADAS A VENTILACION MECANICA \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "PAQUETE BUNDLE PARA PREVENCION DE N.A.V.M.\n";
	
	$queryExcelSV = "SELECT *
					FROM instalacionvm AS i
					LEFT JOIN categoriaprofesional AS c ON i.personaInstalo=c.id
					WHERE numeroExpediente='$exp' AND folio='$folio'
					ORDER BY fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelSV) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	$d = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\tSEXO: ".$sexo."\n";
			$excel.="\nNo.\tVerificador\tFecha Instalación\tUBICACIÓN\tHabitación\tOtra Ubicación\tTurno\tProfesional Instaló\tNombre Instaló\n";
		}
		$excel.=$c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaInst"]."\t".$row["ubicacion"]."\t".$row["habitacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["turno"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombreInstalo"])."\n";
		
	}
	$excel.="\n CRITERIOS DE VERIFICACIÓN";
	$excel.="\nNo.\t";
	//$excel.= $c;
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	
	$excel.="\n1. VERIFICÓ LA INDICACIÓN DE VENTILACIÓN MECÁNICA EN EL EXPEDIENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['indicPac']."\t";
	}
	$excel .= "\n2. APLICÓ LA TÉCNICA DE HIGIENE DE MANOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['manosPac']."\t";
	}
	$excel .= "\n3. VERIFICÓ LA UTILIZACIÓN DE BARRERA DE MÁXIMA PROTECCIÓN DURANTE LA INSTALACIÓN (guantes,cubrebocas,bata,gorro)\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['barreraPac']."\t";
	}
	$excel .= "\n4. VERIFICÓ LA ELEVACIÓN DE LA CABEZA DEL PACIENTE SOBRE LA CAMA DE 30° A 40°, EN NEONATOS 10° A 15°\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['elevaPac']."\t";
	}
	$excel .= "\n5. EFECTUAR HIGIENE DE CAVIDAD ORAL USANDO CLORHEXIDINA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['oralPac']."\t";
	}
	$excel .= "\n6. VERIFICÓ LA POSIBILIDAD DE EXTUBACIÓN\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['extubaPac']."\t";
	}
	$excel .= "\n7. VERIFICÓ LA DISMINUCIÓN TRANSITORIA DE LA SEDACIÓN PROGRAMADA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['sedacionPac']."\t";
	}
	$excel .= "\n8. VERIFICÓ LA ASPIRACIÓN ENDOTRAQUEAL AL PACIENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['endotraPac']."\t";
	}
	$excel .= "\n9. VERIFICÓ LA MEDICIÓN DE LA PRESIÓN DEL GLOBO DE CANULA ENDOTRAQUEAL\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['canulaPac']."\t";
	}
	$excel.="\nOBSERVACIONES\t";	
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
	
}
/********************************************************************************************************************************************************/	
if($nombre == 'VentilacionMecanicaManto'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "BUNDLE MANTENIMIENTO DE VENTILACIÓN MECÁNICA \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA.\n";
	
	$queryExcelVM = "SELECT *
					FROM mantovm
					WHERE numeroExpediente='$exp' AND folio='$folio'
					ORDER BY fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelVM) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	$d = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\tSEXO: ".$sexo."\n";
			$excel.="\nNo.\tVerificador\tFecha Instalación\n";
		}
		$excel.=$c++."\t".utf8_encode($row["verificador"])."\t".$row["fechaInst"]."\n";
		
	}
	$excel.="\nNo.\t";
	//$excel.= $c;
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	
	$excel.="\n1. HIGIENE DE MANOS EN LOS 5 MOMENTOS\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['higieneManos']."\t";
	}
	$excel .= "\n2. CABEZA ELEVADA >30°\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['cabezaElev']."\t";
	}
	$excel .= "\n3. Realiza la técnica de higiene de manos antes de tener contacto con el ventilador\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['contactoVent']."\t";
	}
	$excel .= "\n4. Utiliza medidas de precaucion estandar\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['medidasEstn']."\t";
	}
	$excel .= "\n5. Interrupción diaria de sedación y evaluación diaria de sedación\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['intDiaria']."\t";
	}
	$excel .= "\n6. Desechar en bolsa roja de residuos peligrosos biológicos infecciosos\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['desechRes']."\t";
	}
	$excel .= "\n7. higiene oral correcta con un antiseptico\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['higieneAntisep']."\t";
	}
	
	
	$excel.="\nOBSERVACIONES\t";	
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
}

/********************************************************************************************************************************************************/
if($nombre == 'VigilanciaYcapacitacion'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "VIGILANCIA Y CAPACITACIÓN  \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryDocs = "SELECT *
				  FROM vigilanciacapacitacion 
				  WHERE fechaVisita BETWEEN '$fecha1' AND '$fecha2'
				  ORDER BY numeroExpediente,fechaVisita, horaVisita";
	
	$result1 = mysqli_query($conexionEpidemio, $queryDocs) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tNúmero Expediente\tFolio\tFecha Visita\tHora Visita\tMeta Internacional\tVigilancia de RPBI\tInmunocomprometido\tComorbilidad\tAislamiento\tPadecimiento Actual\tnotas\n";
		}
		$comor= preg_replace("/[\n|\r|\n\r]/i"," ",$row["comorbilidad"]);
		$aisla= preg_replace("/[\n|\r|\n\r]/i"," ",$row["aislamiento"]);
		$padec= preg_replace("/[\n|\r|\n\r]/i"," ",$row["padecimientoAct"]);
		$nota= preg_replace("/[\n|\r|\n\r]/i"," ",$row["notas"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaVisita"]."\t".$row["horaVisita"]."\t".$row["metaInternacional"]."\t".utf8_encode($row["vigilanciaRPBI"])."\t".utf8_encode($row["inmunocomprometido"])."\t".utf8_encode($comor)."\t".utf8_encode($aisla)."\t".utf8_encode($padec)."\t".utf8_encode($nota)."\n";
	}
}
/****************************************************************************************************************************************************/	
if($nombre == 'MedicionesTemperatura'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "MEDICIONES DE TEMPERATURA  \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryMedTemp = "SELECT *
				  FROM pacientetemperatura 
				  WHERE fechaMedicion BETWEEN '$fecha1' AND '$fecha2'
				  ORDER BY numeroExpediente,fechaMedicion,horaMedicion";

	
	$result1 = mysqli_query($conexionEpidemio, $queryMedTemp) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tNúmero Expediente\tFolio\tFecha Medición\tHora Medición\tTemperatura\tVerificador\tObservaciones\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaMedicion"]."\t".$row["horaMedicion"]."\t".$row["temperatura"]."\t".utf8_encode($row["verificador"])."\t".utf8_encode($observaciones)."\n";
	}
}
/********************************************************************************************************************************************************/
if($nombre == 'OtrasInfecciones'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "MEDICIONES DE VIGILANCIA DE OTRAS INFECCIONES ASOCIADAS A LA ATENCIÓN DE SALUD  \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryMedTemp = "SELECT *
				  FROM pacienteotrasinfecciones 
				  WHERE fechaInicio BETWEEN '$fecha1' AND '$fecha2'
				  ORDER BY numeroExpediente,fechaObservacion";

	
	$result1 = mysqli_query($conexionEpidemio, $queryMedTemp) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tNúmero Expediente\tFolio\tFecha Inicio\tFecha Observacion\tFecha Termino\tVerificador\tObservaciones\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInicio"]."\t".$row["fechaObservacion"]."\t".$row["fechaTermino"]."\t".utf8_encode($row["verificador"])."\t".utf8_encode($observaciones)."\n";
	}
}

/***************-------------------------------------ARCHIVOS EXCEL HISTORICOS-----------------------------------------**********************************/

if($nombre == 'AccesosVascPerInstHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "PROGRAMA DE PREVENCION DE INFECCIONES ASOCIADAS A CATETER PERIFERICO \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "HOJA DE SEGUIMIENTO DEL PAQUETE BUNDLE PARA PREVENCION DE INFECCIONES EN TORRENTE SANGUINEO.\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM instalacionavp AS i
					LEFT JOIN categoriaprofesional AS c ON i.personaInstalo=c.id
					WHERE fechaInstalacion BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaInstalacion";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFecha Instalación\tVerificador\tTurno\tUbicación\tOtra Ubicación\tHabitación\tProfesional Instalo\tNombre Instalo\t1. REALIZÓ TÉCNICA CORRECTA DE HIGIENE DE MANOS \t2. REALIZÓ LOS MOMENTOS DE LAVADO DE MANOS\t3. UTILIZÓ MEDIDAS DE PROTECCIÓN UNIVERSAL (guantes,cubrebocas,bata,gorro,etc.)\t4. LA ZONA A CANALIZAR ES UN MIEMBRO SUPERIOR (evitó accesos femorales)\t5. REALIZÓ LA ASEPSIA Y ANTISEPSIA CON CLORHEXIDINA ALCOHOLICA AL 2% EN PACIENTES > 2 MESES EN LA ZONA A PUNCIONAR\t6. ESPERÓ QUE EL ÁREA ESTUVIERA SECA ANTES DE REALIZAR LA PUNCIÓN\t7. USÓ APOSITO TRANSPARENTE PARA CUBRIR EL SITIO DE PUNCIÓN\t8. VERIFICÓ QUE EL SITIO DE INSERCIÓN SE ENCUENTRE VISIBLE\t9. VERIFICÓ EL MEMBRETE DE IDENTIFICACIÓN CON LOS DATOS COMPLETOS\t10. VERIFICÓ SI EL PACIENTE TENÍA PUNCIONES ANTERIORES\tOBSERVACIONES\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInstalacion"]."\t".utf8_encode($row["verificador"])."\t".$row["turno"]."\t".$row["ubicacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["habitacion"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombreInstalo"])."\t".$row["manosTecPac"]."\t".$row["manosPac"]."\t".$row["proteccPac"]."\t".$row["superiorPac"]."\t".$row["asepsiaPac"]."\t".$row["puncionPac"]."\t".$row["apositoPac"]."\t".$row["inserPac"]."\t".$row["identificPac"]."\t".$row["puncAntPac"]."\t".utf8_encode($observaciones)."\n";
	}
}
		
/********************************************************************************************************************************************************/
if($nombre == 'AccesosVascPerMantoHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "BUNDLE MANTENIMIENTO DE CATÉTER PERIFÉRICO \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "UNIDAD DE VIGILANCIA EPIDEMIOLÓGICA HOSPITALARIA.\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM mantoavp
					WHERE fechaInst BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFecha Instalación\tVerificador\t INDENTIFICO AL PACIENTE CORRECTAMENTE\t INFORMÓ AL PACIENTE O FAMILIARES SOBRE EL PROCESO A REALIZAR\tREALIZÓ HIGIENE DE MANOS ANTES DE LA MANIPULACIÓN DEL SITIO DE INSERCIÓN DEL CATÉTER\tVALORA CONDICIONES DEL ACCESO VENOSO PARA IDENTIFICAR OPORTUNAMENTE SIGNOS DE INFECCIÓN\tVERIFICA PERMEABILIDAD DEL CATÉTER CON TÉCNICA ASÉPTICA\tREEMPLAZO APÓSITO DE ACUERDO A NORMATIVA ESTABLECIDA\tCAMBIO SOLUCIONES Y EQUIPOS DE ACUERDO A LA NORMATIVIDAD\tMANTIENE EL SISTEMA DE INFUSIÓN CERRADO Y EVITA DESCONEXIONES INNECESARIAS\tDESINFECTA LOS PUERTOS Y CONEXIONES ANTES DE MANIPULARLOS\tDESINFECTA LA VÍA VENOSA DESPUÉS DE LA ADMINISTRACIÓN DE MEDICAMENTOS O HEMODERIVADOS DE ACUERDO AL PROTOCOLO\tREGISTRA EN FORMATOS ESTABLECIDOS LAS ACCIONES REALIZADAS\tRETIRA EL CATETER PREVIA INDICACIÓN MÉDICA O ANTE LA PRESENCIA DE UNA COMPLICACIÓN\n";
		}
		//$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInst"]."\t".utf8_encode($row["verificador"])."\t".$row["identPac"]."\t".$row["infoPac"]."\t".$row["higieneManPac"]."\t".$row["condicionesPac"]."\t".$row["permeaPac"]."\t".$row["apositoPac"]."\t".$row["solucionesPac"]."\t".$row["infusionPac"]."\t".$row["puertosPac"]."\t".$row["viaPac"]."\t".$row["formatosPac"]."\t".$row["retirarPac"]."\n";
	}
}
/********************************************************************************************************************************************************/
if($nombre == 'VentilacionMecanicaInstHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "PROGRAMA DE PREVENCIÓN DE NEUMONIAS ASOCIADAS A VENTILACIÓN MECÁNICA \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "PAQUETE BUNDLE PARA PREVENCION DE N.A.V.M.\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM instalacionvm AS i
					LEFT JOIN categoriaprofesional AS c ON i.personaInstalo=c.id
					WHERE fechaInst BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFecha Instalación\tVerificador\tTurno\tUbicación\tOtra Ubicación\tHabitación\tProfesional Instalo\tNombre Instalo\t1. VERIFICÓ LA INDICACIÓN DE VENTILACIÓN MECÁNICA EN EL EXPEDIENTE \t2. APLICÓ LA TÉCNICA DE HIGIENE DE MANOS\t3. VERIFICÓ LA UTILIZACIÓN DE BARRERA DE MÁXIMA PROTECCIÓN DURANTE LA INSTALACIÓN (guantes,cubrebocas,bata,gorro)\t4. VERIFICÓ LA ELEVACIÓN DE LA CABEZA DEL PACIENTE SOBRE LA CAMA DE 30° A 40°, EN NEONATOS 10° A 15°\t5. EFECTUAR HIGIENE DE CAVIDAD ORAL USANDO CLORHEXIDINA\t6. VERIFICÓ LA POSIBILIDAD DE EXTUBACIÓN\t7. VERIFICÓ LA DISMINUCIÓN TRANSITORIA DE LA SEDACIÓN PROGRAMADA\t8. VERIFICÓ LA ASPIRACIÓN ENDOTRAQUEAL AL PACIENTE\t9. VERIFICÓ LA ASPIRACIÓN ENDOTRAQUEAL AL PACIENTE\tOBSERVACIONES\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInst"]."\t".utf8_encode($row["verificador"])."\t".$row["turno"]."\t".$row["ubicacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["habitacion"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombreInstalo"])."\t".$row["indicPac"]."\t".$row["manosPac"]."\t".$row["barreraPac"]."\t".$row["elevaPac"]."\t".$row["oralPac"]."\t".$row["extubaPac"]."\t".$row["sedacionPac"]."\t".$row["endotraPac"]."\t".$row["canulaPac"]."\t".utf8_encode($observaciones)."\n";
	}
}
/*******************************************************************************************************************************************************/
if($nombre == 'VentilacionMecanicaMantoHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "BUNDLE MANTENIMIENTO DE VENTILACIÓN MECÁNICA \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "UNIDAD DE VIGILANCIA EPIDEMIOLÓGICA HOSPITALARIA.\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM mantovm
					WHERE fechaInst BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFecha Instalación\tVerificador\t1. HIGIENE DE MANOS EN LOS 5 MOMENTOS\t 2. CABEZA ELEVADA >30°\t3. Realiza la tecnica de higiene de manos antes de tener contacto con el ventilador\t4. Utiliza medidas de precaución estandar\t5. Interrupción diaria de sedación y evaluación diaria de sedación\t6. Desechar en bolsa roja de residuos peligrosos biológicos infecciosos\t7. Higiene oral correcta con un antiseptico\tOBSERVACONES\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInst"]."\t".utf8_encode($row["verificador"])."\t".$row["higieneManos"]."\t".$row["cabezaElev"]."\t".$row["contactoVent"]."\t".$row["medidasEstn"]."\t".$row["intDiaria"]."\t".$row["desechRes"]."\t".$row["higieneAntisep"]."\t".utf8_encode($observaciones)."\n";
	}
}
/*****************************************************************************************************************************************************/
if($nombre == 'SitiosQuirurgInstHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "PROGRAMA DE PREVENCIÓN DE INFECCIONES ASOCIADAS A SITIO QUIRÚRGICO \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "HOJA DE SEGUIMIENTO PAQUETE BUNDLE PARA PREVENCIÓN DE INFECCIÓN EN SITIO QUIRÚRGICO\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM instalacionsq AS i
					LEFT JOIN categoriaprofesional AS c ON i.instalo=c.id
					WHERE fechaInst BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFecha Procedimiento\tVerificador\tTurno\tUbicación\tOtra Ubicación\tHabitación\tProfesional que Realizó\tNombre quien Realizó\tÁrea\tOtra Área\tCirugía\tTipo Cirugía\t1.  CORROBORÓ LA IDENTIDAD DEL PACIENTE\t2. REALIZÓ LA HIGIENE DE MANOS, DURANTE LOS MOMENTOS ESTABLECIDOS\t3. VERIFICÓ QUE EL MATERIAL SEA ESTERIL\t4. VERIFICÓ QUE SE LLEVARA LA TECNICA ASEPTICA DURANTE EL PROCEDIMIENTO\t5. VERIFICÓ QUE SE REALIZARA CORTE DE VELLO O CABELLO EN EL CASO DE SER NECESARIO, CON MAQUINA\t6. VERIFICÓ QUE LA TEMPERATURA CORPORAL DEL PACIENTE SE ENCONTRARA DENTRO DE LOS PARAMETROS NORMALES\t7. VERIFICÓ QUE SE REALIZARA ANTIBIOPROFILAXIS ADECUADA\t8. VERIFICÓ QUE LOS PARAMETROS DE GLUCOSA DEL PACIENTE FUERAN NORMALES\tOBSERVACIONES\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInst"]."\t".utf8_encode($row["verificador"])."\t".$row["turno"]."\t".$row["ubicacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["habitacion"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombInstalo"])."\t".utf8_encode($row["area"])."\t".utf8_encode($row["otraArea"])."\t".utf8_encode($row["cirugia"])."\t".utf8_encode($row["tipoCirugia"])."\t".$row["identidadPac"]."\t".$row["manosPac"]."\t".$row["materialPac"]."\t".$row["asepticaPac"]."\t".$row["cortePac"]."\t".$row["tempPac"]."\t".$row["antibioPac"]."\t".$row["glucosaPac"]."\t".utf8_encode($observaciones)."\n";
	}
}
/****************************************************************************************************************************************************/	
if($nombre == 'sondaVesicalInstHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "PROGRAMA DE PREVENCION DE INFECCIONES ASOCIADAS A SONDA VESICAL \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "PAQUETE BUNDLE PARE PREVENCION DE INFECCIONES POR CATETER URINARIO\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM instalacionsv AS i
					LEFT JOIN categoriaprofesional AS c ON i.personaInstalo=c.id
					WHERE fechaProcedimiento BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaProcedimiento";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFecha Procedimiento\tVerificador\tTurno\tUbicación\tOtra Ubicación\tHabitación\tProfesional Instalo\tNombre Instalo\t1. VERIFICÓ LA INDICIACION EN EL EXPEDIENTE DE USO DE LA SONDA VESICAL\t2. APLICÓ TECNICA ADECUADA DE LAVADO DE MANOS\t3. UTILIZÓ BARRERA MAXIMA PARA LA INSTALACION\t4. VERIFICÓ  TECNICA APROPIADA PARA LA INSERCION DE LA SONDA VESICAL\t5. VERIFICÓ QUE LA SONDA FUERA FIJADA DEACUERDO AL SEXO DEL PACIENTE\t6. VERIFICÓ QUE LA BOLSA RECOLECTORA SE MANTIENE POR DEBAJO DEL NIVEL DE LA VEJIGA\t7. VERIFICÓ QUE SE MANTIENGA UN FLUJO SIN OBSTRUCCION\t8. VERIFICÓ QUE SE HA DRENADO PERIODICAMENTE LA BOLSA COLECTORA\t9. VERIFICÓ SI EL PACIENTE TIENE OTROS SITIOS ACTIVOS DE INFECCIÓN\t10. VERIFICÓ SI EL PACIENTE PRESENTA ALGUNA CO-MORBILIDAD (DIABETES,HIPERTENSION,ETC) \t11. VERIFICÓ QUE EL PACIENTE Y FAMILIAR RECIBIO INFORMACION ACERCA DE LOS CUIDADOS DE LA SONDA URINARIA \t12. IDENTIFICÓ Y REPORTÓ SI EXISTEN SIGNOS QUE SE SOSPECHE INFECCION DE VIAS URINARIAS\tOBSERVACIONES\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaProcedimiento"]."\t".utf8_encode($row["verificador"])."\t".$row["turno"]."\t".$row["ubicacion"]."\t".utf8_encode($row["otraUbic"])."\t".$row["habitacion"]."\t".utf8_encode($row["categoriaProf"])."\t".utf8_encode($row["nombreInstalo"])."\t".$row["sondaPac"]."\t".$row["manosPac"]."\t".$row["barreraPac"]."\t".$row["inserPac"]."\t".$row["fijadaPac"]."\t".$row["vejigaPac"]."\t".$row["flujoPac"]."\t".$row["drenadoPac"]."\t".$row["sitiosPac"]."\t".$row["morbilidadPac"]."\t".$row["cuidadosPac"]."\t".$row["infeccionPac"]."\t".utf8_encode($observaciones)."\n";
	}
}
/********************************************************************************************************************************************************/
if($nombre == 'sondaVesicalMantoHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "BUNDLE MANTENIMIENTO DE SONDA VESICAL INSTALADA \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "UNIDAD DE VIGILANCIA EPIDEMIOLÓGICA HOSPITALARIA.\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM mantosv
					WHERE fechaInst BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFecha Instalación\tVerificador\tA. La bolsa colectora se mantiene por debajo del nivel de la vejiga (REVISAR QUE LA BOLSA RECOLECTORA) 1. Se mantiene por debajo del nivel de la vejiga independientemente de la posición\t2. No rebasa más del 75% de la capacidad de la misma\t3. No está colocada sobre el piso, superficie sucia o cualquier otro recipiente\tB. El catéter está fijado de acuerdo al sexo del paciente (permitiendo la movilidad del paciente sin obstruir la permeabilidad de la sonda y no hay tracción de la misma) (VERIFIQUE FIJACIÓN DE LA SONDA) 4. Mujeres cara interna del muslo\t5. Hombres cara antero lateral superior del muslo\tC. La sonda se encuentra con membrete de identificación (MEMBRETE DEBE TENER ESCRITO COMO MÍNIMO) 6. Fecha de instalación. Nombre completo de quién instaló la sonda\tD. El sistema de drenaje se mantiene permanentemente conectado 7. Se mantiene conectado el sistema de drenaje\tE. Se registran datos referentes al funcionamiento de sonda y tubo drenaje. (OBSERVAR Y VERIFICAR QUE ESTE REGISTRADO EN NOTAS DE ENFERMERÍA) 8. Sonda y tubo de drenaje permite fluir orina libremente\t9. Que no existan fisuras, ni fugas\t10. Que no estén pinzadas, torcidas, acodados colapsados presionados (barandales cama)\tF. Repara ausencia o presencia de signos y síntomas que evidencien Infección de tracto urinario. (VERIFICAR NOTAS DE ENFERMERÍA, MÉDICOS Y/O LABORATORIO) 11. Cuenta con cultivo antes de colocación de sonda y cada 5 días a partir de la fecha de instalación\t12. Picos febriles, dolor supra púbico o en flanco\t13. Área peri uretral secreción, prurito, inflamación, etc.\t14. Características macroscópicas de orina, turbia, hematuria, sedimento, entre otro\tOBSERVACONES\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInst"]."\t".utf8_encode($row["verificador"])."\t".$row["nivelPac"]."\t".$row["rebasaPac"]."\t".$row["pisoPac"]."\t".$row["mujerPac"]."\t".$row["hombrePac"]."\t".$row["instaloPac"]."\t".$row["drenajePac"]."\t".$row["fluirPac"]."\t".$row["fugasPac"]."\t".$row["barandalesPac"]."\t".$row["cultivoPac"]."\t".$row["febrilesPac"]."\t".$row["uretralPac"]."\t".$row["orinaPac"]."\t".utf8_encode($observaciones)."\n";
	}
}
/********************************************************************************************************************************************************/
if($nombre == 'LineasVascularesCentralesInstHist'){
	if (isset($_POST['fecha1']))
	{
		$fecha1=$_POST['fecha1'];
	}
	if (isset($_POST['fecha2']))
	{
		$fecha2=$_POST['fecha2'];
	}
	
	$excel= "VERIFICACION EN LA INSERCION DE LINEAS VASCULARES CENTRALES \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA\n";
	$excel.= "DATOS DEL  \t".$fecha1."\t AL \t".$fecha2."\n";
	
	$queryExcelAVP = "SELECT *
					FROM instalacionlvc AS i
					WHERE fechaInst BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY numeroExpediente,fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		if($c == 1){
			$excel.="\nNo.\tExpediente\tFolio\tFECHA DE INSTALACIÓN\tFECHA DE RETIRO\tSUBCLAVIA\tYUGULAR\tBASILICA\tFEMORAL\tANESTESIA \tNUM. LUMEN\tREINSTALACIÓN \tQUIEN INSTALA\tESPECIALIDAD\tOTRA ESPECIALIDAD\tASISTENTE\tSUPERVISO\tConsentimiento informado al paciente\tOBSERVACIONES CONS. INF.\tPosicion correcta del paciente para el procedimiento de acuerdo al sitio señalado\toBSERVACIONES POS. CORRECTA.\tOperador utilizar: gorro, mascarilla, bata, guantes esteriles proteccion ocular\tOBSERVACIONES OPERADOR\tAyudantes: gorro, mascarilla\tOBSERVACIONES AYUDANTES\tAsepsia de la piel con clorhexidina alcoholica al 2% en mayores de 2 meses\tOBSERVACIONES ASEPSIA DE PIEL\tEspero a que seque el antisÉptico\tOBSERVACIONES SECÓ ANTISÉPTICO\tUtilizo tecnica aseptica para cubrir al paciente de pies a cabeza\tOBSERVACIONES TÉCNICA ANTISEPTICA\tLAVADO DE MANOS, DURANTE LOS 5 MOMENTOS\tOBSERVACIONES 5 MOMENTOS\tASEPSIA DE LA PIEL CON CLOREHIXIDINA ALCOHOLICA AL 2% EN MAYORES DE 2 MESES\tOBSERVACIONES ASEPSIA PIEL\tBARRERA MAXIMA DURANTE LA INSTALACIÓN DEL CATETER\tOBSERVACIONES BARRERA MAXIMA\tEVIATAR ACCESOS FEMORALES\tOBSERVACIONES ACCESOS FEMORALES\tRETIRAR LAS VIAS INNECESARIAS\tOBSERVACIONES VÍAS INNECESARIAS\tLIMPIO CON CLORHEXIDINA LOS RESTOS DE SANGRE EN EL LUGAR DE LA INSERCIÓN\tOBSERVACIONES LIMPIA SANGRE\tSE FIJO CATETER CON MATERIAL DE SUTURA\tOBSERVACIONES CATETER SUTURA\tCOLOCO APOSITO SEMIPERMEABLE ESTERIL PARA CUBRIR CATETER\tOBSERVACIONES APOSITO\tCORROBORA LA POSICION DEL CATETER MEDIANTE RADIOGRAFIA\tOBSERVACIONES POSICIÓN CATETER\tSE PRESENTO ALGUNA COMPLICACIÓN\t¿CÓMO SE SOLUCIONO?\tDURACIÓN DEL PROCEDIMIENTO\tOBSERVACIONES\n";
		}
		$observaciones= preg_replace("/[\n|\r|\n\r]/i"," ",$row["observaciones"]);
		$excel.= $c++."\t".$row["numeroExpediente"]."\t".$row["folio"]."\t".$row["fechaInst"]."\t".$row["fechaRetiro"]."\t".$row["subClav"]."\t".$row["yugular"]."\t".$row["basilica"]."\t".$row["femoral"]."\t".$row["anestesia"]."\t".utf8_encode($row["lumen"])."\t".$row["reinst"]."\t".utf8_encode($row["nInstala"])."\t".$row["instala"]."\t".utf8_encode($row["otraEsp"])."\t".utf8_encode($row["nAsistente"])."\t".utf8_encode($row["superviso"])."\t".$row["consInf"]."\t".utf8_encode($row["consInfObs"])."\t".$row["posCorr"]."\t".utf8_encode($row["posCorrObs"])."\t".$row["operador"]."\t".utf8_encode($row["operadorObs"])."\t".$row["ayudante"]."\t".utf8_encode($row["ayudanteObs"])."\t".$row["asepsia"]."\t".utf8_encode($row["asepsiaObs"])."\t".$row["antiseptico"]."\t".utf8_encode($row["antisepticoObs"])."\t".$row["tecnica"]."\t".utf8_encode($row["tecnicaObs"])."\t".$row["manos"]."\t".utf8_encode($row["manosObs"])."\t".$row["clorehixidina"]."\t".utf8_encode($row["clorehixidinaObs"])."\t".$row["cateter"]."\t".utf8_encode($row["cateterObs"])."\t".$row["femorales"]."\t".utf8_encode($row["femoralesObs"])."\t".$row["viasIn"]."\t".utf8_encode($row["viasInObs"])."\t".$row["restosSangre"]."\t".utf8_encode($row["restosSangreObs"])."\t".$row["sutura"]."\t".utf8_encode($row["suturaObs"])."\t".$row["aposito"]."\t".utf8_encode($row["apositoObs"])."\t".$row["radiografia"]."\t".utf8_encode($row["radiografiaObs"])."\t".utf8_encode($row["complicacion"])."\t".utf8_encode($row["como"])."\t".utf8_encode($row["duracion"])."\t".utf8_encode($observaciones)."\n";
	}
}

/********************************************************************************************************************************************************/
if($nombre == 'AccesosVascCentrInst'){
	if (isset($_GET['exp']))
	{
		$exp=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	if (isset($_GET['sexo']))
	{
		$sexo=$_GET['sexo'];
	}
	
	$excel= "VERIFICACION EN LA INSERCION DE LINEAS VASCULARES CENTRALES \t   \t".utf8_encode(strftime('%A, %d de %B de %Y'))."\n\n";
	$excel.= "UNIDAD DE VIGILANCIA EPIDEMIOLOGICA HOSPITALARIA. \n";
	
	$queryExcelAVP = "SELECT *
						FROM instalacionlvc
						WHERE numeroExpediente='$exp' AND folio='$folio'
						ORDER BY fechaInst";
	$result1 = mysqli_query($conexionEpidemio, $queryExcelAVP) or die (mysqli_error($conexionEpidemio));
	$c = 1;
	while($row = mysqli_fetch_array($result1)){
		$fila1[] = $row;
		if($c == 1){
			$excel.= "EXPEDIENTE: ".$row["numeroExpediente"]."\tSEXO: ".$sexo."\n";
			$excel.="\nNo.\tFECHA DE INSTALACIÓN\tFECHA DE RETIRO\n";
		}
		$excel.=$c++."\t".$row["fechaInst"]."\t".$row["fechaRetiro"]."\n";
	}
	
	$excel.="\nNo.\t";
	for($i = 1; $i < $c; $i++){
		$excel.= $i."\t";
	}
	$excel.="\nSUBCLAVIA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['subClav']."\t";
	}
	$excel.="\nYUGULAR\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['yugular']."\t";
	}
	$excel.="\nBASILICA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['basilica']."\t";
	}
	$excel.="\nFEMORAL\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['femoral']."\t";
	}
	$excel.="\nANESTESIA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['anestesia'])."\t";
	}
	$excel.="\nNÚMERO DE LUMEN\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['lumen'])."\t";
	}
	$excel.="\nREINSTALACIÓN\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['reinst']."\t";
	}
	$excel.="\nQUIEN INSTALA\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['nInstala'])."\t";
	}
	$excel.="\nESPECIALIDAD\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['instala']."\t";
	}
	$excel.="\nOTRA ESPECIALIDAD\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['otraEsp'])."\t";
	}
	$excel.="\nASISTENTE\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['nAsistente'])."\t";
	}
	$excel.="\nSUPERVISO\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['superviso'])."\t";
	}
	$excel.="\nConsentimiento informado al paciente.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['consInf']."\t";
	}
	$excel.="\nOBSERVACIONES CONS. INF.\t";
	foreach($fila1 as $filita1)
	{
		$str16 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["consInfObs"]);
		$excel .= utf8_encode($str16)."\t";
	}
	$excel.="\nPosición correcta del paciente para el procedimiento de acuerdo al sitio señalado.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['posCorr']."\t";
	}
	$excel.="\nOBSERVACIONES POSICIÓN\t";
	foreach($fila1 as $filita1)
	{
		$str15 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["posCorrObs"]);
		$excel .= utf8_encode($str15)."\t";
	}
	$excel.="\nOperador utilizar: gorro, mascarilla, bata, guantes esteriles proteccion ocular.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['operador']."\t";
	}
	$excel.="\nOBSERVACIONES OPERADOR\t";
	foreach($fila1 as $filita1)
	{
		$str14 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["operadorObs"]);
		$excel .= utf8_encode($str14)."\t";
	}
	$excel.="\nAyudantes: gorro, mascarilla.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['ayudante']."\t";
	}
	$excel.="\nOBSERVACIONES AYUDANTE\t";
	foreach($fila1 as $filita1)
	{
		$str13 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["ayudanteObs"]);
		$excel .= utf8_encode($str13)."\t";
	}
	$excel.="\nAsepsia de la piel con clorhexidina alcoholica al 2% en mayores de 2 meses.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['asepsia']."\t";
	}
	$excel.="\nOBSERVACIONES ASEPSIA PIEL\t";
	foreach($fila1 as $filita1)
	{
		$str12 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["asepsiaObs"]);
		$excel .= utf8_encode($str12)."\t";
	}
	$excel.="\nEspero a que seque el antiseptico\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['antiseptico']."\t";
	}
	$excel.="\nOBSERVACIONES SECADO ANTISEPTICO\t";
	foreach($fila1 as $filita1)
	{
		$str11 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["antisepticoObs"]);
		$excel .= utf8_encode($str11)."\t";
	}
	$excel.="\nUtilizo técnica aseptica para cubrir al paciente de pies a cabeza.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['tecnica']."\t";
	}
	$excel.="\nOBSERVACIONES CUBRIR PACIENTE\t";
	foreach($fila1 as $filita1)
	{
		$str10 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["tecnicaObs"]);
		$excel .= utf8_encode($str10)."\t";
	}
	$excel.="\nLAVADO DE MANOS, DURANTE LOS 5 MOMENTOS.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['manos']."\t";
	}
	$excel.="\nOBSERVACIONES 5 MOMENTOS\t";
	foreach($fila1 as $filita1)
	{
		$str9 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["manosObs"]);
		$excel .= utf8_encode($str9)."\t";
	}
	$excel.="\nASEPSIA DE LA PIEL CON CLOREHIXIDINA ALCOHOLICA AL 2% EN MAYORES DE 2 MESES.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['clorehixidina']."\t";
	}
	$excel.="\nOBSERVACIONES ASEPSIA PIEL CLOREHIXIDINA\t";
	foreach($fila1 as $filita1)
	{
		$str8 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["clorehixidinaObs"]);
		$excel .= utf8_encode($str8)."\t";
	}
	$excel.="\nBARRERA MAXIMA DURANTE LA INSTALACION DEL CATETER.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['cateter']."\t";
	}
	$excel.="\nOBSERVACIONES BARRERA MAXIMA\t";
	foreach($fila1 as $filita1)
	{
		$str7 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["cateterObs"]);
		$excel .= utf8_encode($str7)."\t";
	}
	$excel.="\nEVIATAR ACCESOS FEMORALES.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['femorales']."\t";
	}
	$excel.="\nOBSERVACIONES ACCESOS FEMORALES\t";
	foreach($fila1 as $filita1)
	{
		$str6 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["femoralesObs"]);
		$excel .= utf8_encode($str6)."\t";
	}
	
	$excel.="\nRETIRAR LAS VIAS INNECESARIAS.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['viasIn']."\t";
	}
	$excel.="\nOBSERVACIONES VIAS INNECESARIAS\t";
	foreach($fila1 as $filita1)
	{
		$str5 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["viasInObs"]);
		$excel .= utf8_encode($str5)."\t";
	}
	$excel.="\nLIMPIO CON CLORHEXIDINA LOS RESTOS DE SANGRE EN EL LUGAR DE LA INSERCION.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['restosSangre']."\t";
	}
	$excel.="\nOBSERVACIONES LIMPIEZA RESTOS SANGRE\t";
	foreach($fila1 as $filita1)
	{
		$str4 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["restosSangreObs"]);
		$excel .= utf8_encode($str4)."\t";
	}
	$excel.="\nSE FIJO CATETER CON MATERIAL DE SUTURA.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['sutura']."\t";
	}
	$excel.="\nOBSERVACIONES SUTURA\t";
	foreach($fila1 as $filita1)
	{
		$str3 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["suturaObs"]);
		$excel .= utf8_encode($str3)."\t";
	}
	$excel.="\nCOLOCO APOSITO SEMIPERMEABLE ESTERIL PARA CUBRIR CATETER.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['aposito']."\t";
	}
	$excel.="\nOBSERVACIONES APOSITO\t";
	foreach($fila1 as $filita1)
	{
		$str2 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["apositoObs"]);
		$excel .= utf8_encode($str2)."\t";
	}
	$excel.="\nCORROBORA LA POSICION DEL CATETER MEDIANTE RADIOGRAFIA.\t";
	foreach($fila1 as $filita1)
	{
		$excel .= $filita1['radiografia']."\t";
	}
	$excel.="\nOBSERVACIONES POSICION RADIOGRAFÍA\t";
	foreach($fila1 as $filita1)
	{
		$str1 = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["radiografiaObs"]);
		$excel .= utf8_encode($str1)."\t";
	}
	$excel.="\n¿SE PRESENTO ALGUNA COMPLICACIÓN?\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['complicacion'])."\t";
	}
	$excel.="\n¿CÓMO SE SOLUCIONO?\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['como'])."\t";
	}
	$excel.="\nDURACIÓN DEL PROCEDIMIENTO\t";
	foreach($fila1 as $filita1)
	{
		$excel .= utf8_encode($filita1['duracion'])."\t";
	}
	$excel.="\nOBSERVACIONES\t";
	foreach($fila1 as $filita1)
	{
		$str = preg_replace("/[\n|\r|\n\r]/i"," ",$filita1["observaciones"]);
		$excel .= utf8_encode($str)."\t";
	}
	
}

	print utf8_decode($excel);
	exit;

?>