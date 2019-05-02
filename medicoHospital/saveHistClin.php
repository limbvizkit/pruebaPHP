<?php
require_once('../conexion/configMedico.php');
	
	$tabaco=NULL;
	$alcohol=NULL;
	$drogas=NULL;
	if (isset($_POST['idHistClin']))
	{
		$idHistClin  = $_POST["idHistClin"];
	} else {
		$idHistClin = '';
	}
	if (isset($_POST['fecha']))
	{
		$fecha  = $_POST["fecha"];
	} else {
		$fecha = '';
	}
	if (isset($_POST['hora']))
	{
		$hora  = $_POST["hora"];
	} else {
		$hora = '';
	}
	if (isset($_POST['tipoInterroga']))
	{
		$tipoInterroga = $_POST["tipoInterroga"];
	} else {
		$tipoInterroga = '';
	}
	if (isset($_POST['edoCivil']))
	{
		$edoCivil  = utf8_decode($_POST["edoCivil"]);
	} else {
		$edoCivil = '';
	}
	if (isset($_POST['ocupacion']))
	{
		$ocupacion = addslashes($_POST["ocupacion"]);
		$ocupacion = utf8_decode($ocupacion);
	} else {
		$ocupacion = '';
	}
	if (isset($_POST['lugarOrigen']))
	{
		$lugarOrigen=addslashes($_POST["lugarOrigen"]);
		$lugarOrigen  = utf8_decode($lugarOrigen);
	} else {
		$lugarOrigen = '';
	}
	if (isset($_POST['escolaridad']))
	{
		$escolaridad=addslashes($_POST["escolaridad"]);
		$escolaridad  = utf8_decode($escolaridad);
	} else {
		$escolaridad = '';
	}
	if (isset($_POST['religion']))
	{
		$religion=addslashes($_POST["religion"]);
		$religion  = utf8_decode($religion);
	} else {
		$religion = '';
	}
	if (isset($_POST['grupoRH']))
	{
		$grupoRH = addslashes($_POST["grupoRH"]);
		$grupoRH = utf8_decode($grupoRH);
	} else {
		$grupoRH = '';
	}
	if (isset($_POST['antecedentesHeredo']))
	{
		$antecedentesHeredo  = utf8_decode($_POST["antecedentesHeredo"]);
		$antecedentesHeredo=addslashes($antecedentesHeredo);
	} else {
		$antecedentesHeredo = '';
	}
	if (isset($_POST['habitacion']))
	{
		$habitacion = utf8_decode($_POST["habitacion"]);
		$habitacion = addslashes($habitacion);
	} else {
		$habitacion = '';
	}
	if (isset($_POST['habitos']))
	{
		$habitos  = utf8_decode($_POST["habitos"]);
		$habitos=addslashes($habitos);
	} else {
		$habitos = '';
	}
	if (isset($_POST['alimentacion']))
	{
		$alimentacion  = utf8_decode($_POST["alimentacion"]);
		$alimentacion=addslashes($alimentacion);
	} else {
		$alimentacion = '';
	}

	if (isset($_POST['actividadFisica']))
	{
		$actividadFisica  = utf8_decode($_POST["actividadFisica"]);
		$actividadFisica=addslashes($actividadFisica);
	} else {
		$actividadFisica = '';
	}
	if (isset($_POST['inmunizaciones']))
	{
		$inmunizaciones  = utf8_decode($_POST["inmunizaciones"]);
		$inmunizaciones=addslashes($inmunizaciones);
	} else {
		$inmunizaciones = '';
	}
	if (isset($_POST['antecedentesPatologicos']))
	{
		$antecedentesPatologicos  = utf8_decode($_POST["antecedentesPatologicos"]);
		$antecedentesPatologicos=addslashes($antecedentesPatologicos);
	} else {
		$antecedentesPatologicos = '';
	}
	if (isset($_POST['tabaco']))
	{
		$tabaco = $_POST["tabaco"];
	} else {
		$tabaco = '';
	}
	if (isset($_POST['alcohol']))
	{
		$alcohol = $_POST["alcohol"];
	} else {
		$alcohol = '';
	}
	if (isset($_POST['drogas']))
	{
		$drogas = $_POST["drogas"];
	} else {
		$drogas = '';
	}
	if (isset($_POST['conciliacionMedicamentos']))
	{
		$conciliacionMedicamentos  = utf8_decode($_POST["conciliacionMedicamentos"]);
		$conciliacionMedicamentos=addslashes($conciliacionMedicamentos);
	} else {
		$conciliacionMedicamentos = '';
	}
	if (isset($_POST['antecedentesGineco']))
	{
		$antecedentesGineco  = utf8_decode($_POST["antecedentesGineco"]);
		$antecedentesGineco=addslashes($antecedentesGineco);
	} else {
		$antecedentesGineco = '';
	}
	if (isset($_POST['antecedentesPediatricos']))
	{
		$antecedentesPediatricos  = utf8_decode($_POST["antecedentesPediatricos"]);
		$antecedentesPediatricos=addslashes($antecedentesPediatricos);
	} else {
		$antecedentesPediatricos = '';
	}
	if (isset($_POST['padecimientoActual']))
	{
		$padecimientoActual  = utf8_decode($_POST["padecimientoActual"]);
		$padecimientoActual=addslashes($padecimientoActual);
	} else {
		$padecimientoActual = '';
	}
	if (isset($_POST['sintomas']))
	{
		$sintomas  = utf8_decode($_POST["sintomas"]);
		$sintomas=addslashes($sintomas);
	} else {
		$sintomas = '';
	}
	if (isset($_POST['respiratorio']))
	{
		$respiratorio  = utf8_decode($_POST["respiratorio"]);
		$respiratorio=addslashes($respiratorio);
	} else {
		$respiratorio = '';
	}
	if (isset($_POST['musculoEsquele']))
	{
		$musculoEsquele  = utf8_decode($_POST["musculoEsquele"]);
		$musculoEsquele=addslashes($musculoEsquele);
	} else {
		$musculoEsquele = '';
	}
	if (isset($_POST['digestivo']))
	{
		$digestivo = utf8_decode($_POST["digestivo"]);
		$digestivo = addslashes($digestivo);
	} else {
		$digestivo = '';
	}
	if (isset($_POST['genital']))
	{
		$genital = utf8_decode($_POST["genital"]);
		$genital = addslashes($genital);
	} else {
		$genital = '';
	}
	if (isset($_POST['endocrino']))
	{
		$endocrino = utf8_decode($_POST["endocrino"]);
		$endocrino = addslashes($endocrino);
	} else {
		$endocrino = '';
	}
	if (isset($_POST['nervioso']))
	{
		$nervioso = utf8_decode($_POST["nervioso"]);
		$nervioso = addslashes($nervioso);
	} else {
		$nervioso = '';
	}
	if (isset($_POST['hematologico']))
	{
		$hematologico = utf8_decode($_POST["hematologico"]);
		$hematologico = addslashes($hematologico);
	} else {
		$hematologico = '';
	}
	if (isset($_POST['psicologico']))
	{
		$psicologico = utf8_decode($_POST["psicologico"]);
		$psicologico = addslashes($psicologico);
	} else {
		$psicologico = '';
	}
	if (isset($_POST['urinario']))
	{
		$urinario = utf8_decode($_POST["urinario"]);
		$urinario = addslashes($urinario);
	} else {
		$urinario = '';
	}
	if (isset($_POST['cardiocirculatorio']))
	{
		$cardiocirculatorio = utf8_decode($_POST["cardiocirculatorio"]);
		$cardiocirculatorio = addslashes($cardiocirculatorio);
	} else {
		$cardiocirculatorio = '';
	}
	if (isset($_POST['pielFaneras']))
	{
		$pielFaneras = utf8_decode($_POST["pielFaneras"]);
		$pielFaneras = addslashes($pielFaneras);
	} else {
		$pielFaneras = '';
	}
	if (isset($_POST['fc']))
	{
		$fc  = $_POST["fc"];
	} else {
		$fc = '';
	}
	if (isset($_POST['fr']))
	{
		$fr  = $_POST["fr"];
	} else {
		$fr = '';
	}
	if (isset($_POST['ta']))
	{
		$ta  = $_POST["ta"];
	} else {
		$ta = '';
	}
	if (isset($_POST['temp']))
	{
		$temp  = $_POST["temp"];
	} else {
		$temp = '';
	}
	if (isset($_POST['so']))
	{
		$so  = $_POST["so"];
	} else {
		$so = '';
	}
	if (isset($_POST['glucosa']))
	{
		$glucosa  = $_POST["glucosa"];
	} else {
		$glucosa = '';
	}
	if (isset($_POST['peso']))
	{
		$peso  = $_POST["peso"];
	} else {
		$peso = '';
	}
	if (isset($_POST['talla']))
	{
		$talla  = $_POST["talla"];
	} else {
		$talla = '';
	}
	if (isset($_POST['habEx']))
	{
		$habEx = utf8_decode($_POST["habEx"]);
		$habEx = addslashes($habEx);
	} else {
		$habEx = '';
	}
	if (isset($_POST['cabeza']))
	{
		$cabeza = utf8_decode($_POST["cabeza"]);
		$cabeza = addslashes($cabeza);
	} else {
		$cabeza = '';
	}
	if (isset($_POST['torax']))
	{
		$torax = utf8_decode($_POST["torax"]);
		$torax = addslashes($torax);
	} else {
		$torax = '';
	}
	if (isset($_POST['abdomen']))
	{
		$abdomen = utf8_decode($_POST["abdomen"]);
		$abdomen = addslashes($abdomen);
	} else {
		$abdomen = '';
	}
	if (isset($_POST['extremidades']))
	{
		$extremidades = utf8_decode($_POST["extremidades"]);
		$extremidades = addslashes($extremidades);
	} else {
		$extremidades = '';
	}
	if (isset($_POST['genitales']))
	{
		$genitales = utf8_decode($_POST["genitales"]);
		$genitales = addslashes($genitales);
	} else {
		$genitales = '';
	}
	if (isset($_POST['neurologico']))
	{
		$neurologico = utf8_decode($_POST["neurologico"]);
		$neurologico = addslashes($neurologico);
	} else {
		$neurologico = '';
	}
	if (isset($_POST['pielFaneras2']))
	{
		$pielFaneras2 = utf8_decode($_POST["pielFaneras2"]);
		$pielFaneras2 = addslashes($pielFaneras2);
	} else {
		$pielFaneras2 = '';
	}
	if (isset($_POST['columnavertebral']))
	{
		$columnavertebral = utf8_decode($_POST["columnavertebral"]);
		$columnavertebral = addslashes($columnavertebral);
	} else {
		$columnavertebral = '';
	}
	if (isset($_POST['estudiosGabinete']))
	{
		$estudiosGabinete = utf8_decode($_POST["estudiosGabinete"]);
		$estudiosGabinete = addslashes($estudiosGabinete);
	} else {
		$estudiosGabinete = '';
	}
	if (isset($_POST['terapeutica']))
	{
		$terapeutica = utf8_decode($_POST["terapeutica"]);
		$terapeutica = addslashes($terapeutica);
	} else {
		$terapeutica = '';
	}
	if (isset($_POST['criteriosEspecializadas']))
	{
		$criteriosEspecializadas = utf8_decode($_POST["criteriosEspecializadas"]);
		$criteriosEspecializadas = addslashes($criteriosEspecializadas);
	} else {
		$criteriosEspecializadas = '';
	}
	if (isset($_POST['educacionEspecial']))
	{
		$educacionEspecial = utf8_decode($_POST["educacionEspecial"]);
		$educacionEspecial = addslashes($educacionEspecial);
	} else {
		$educacionEspecial = '';
	}
	if (isset($_POST['gestionEquipo']))
	{
		$gestionEquipo = utf8_decode($_POST["gestionEquipo"]);
		$gestionEquipo = addslashes($gestionEquipo);
	} else {
		$gestionEquipo = '';
	}
	if (isset($_POST['procesosAdmin']))
	{
		$procesosAdmin = utf8_decode($_POST["procesosAdmin"]);
		$procesosAdmin = addslashes($procesosAdmin);
	} else {
		$procesosAdmin = '';
	}
	if (isset($_POST['diagnostico']))
	{
		$diagnostico = utf8_decode($_POST["diagnostico"]);
		$diagnostico = addslashes($diagnostico);
	} else {
		$diagnostico = '';
	}
	if (isset($_POST['pronosticoVida']))
	{
		$pronosticoVida  = $_POST["pronosticoVida"];
	} else {
		$pronosticoVida = '';
	}
	if (isset($_POST['pronosticoFuncion']))
	{
		$pronosticoFuncion  = $_POST["pronosticoFuncion"];
	} else {
		$pronosticoFuncion = '';
	}
	if (isset($_POST['cedula']))
	{
		$cedula  = $_POST["cedula"];
	} else {
		$cedula = '';
	}
	

	if(!empty($idHistClin)){
		$queryUpdDHistClin = "UPDATE historiaclinica SET hora='$hora',tipoInterroga='$tipoInterroga',edoCivil='$edoCivil',ocupacion='$ocupacion',
			lugarOrigen='$lugarOrigen',escolaridad='$escolaridad',religion='$religion',grupoRH='$grupoRH',antecedentesHeredo='$antecedentesHeredo',
			habitacion='$habitacion',habitos='$habitos',alimentacion='$alimentacion',actividadFisica='$actividadFisica',inmunizaciones='$inmunizaciones',
			antecedentesPatologicos='$antecedentesPatologicos',tabaco='$tabaco',alcohol='$alcohol',drogas='$drogas',conciliacionMedicamentos='$conciliacionMedicamentos',
			antecedentesGineco='$antecedentesGineco',antecedentesPediatricos='$antecedentesPediatricos',padecimientoActual='$padecimientoActual',
			sintomas='$sintomas',respiratorio='$respiratorio',musculoEsquele='$musculoEsquele',digestivo='$digestivo',genital='$genital',
			endocrino='$endocrino',nervioso='$nervioso',hematologico='$hematologico',psicologico='$psicologico',urinario='$urinario',
			cardiocirculatorio='$cardiocirculatorio',pielFaneras='$pielFaneras',fc='$fc',fr='$fr',ta='$ta',temp='$temp',so='$so',glucosa='$glucosa',
			peso='$peso',talla='$talla',habExt='$habEx',cabeza='$cabeza',torax='$torax',abdomen='$abdomen',extremidades='$extremidades',
			genitales='$genitales',neurologico='$neurologico',pielFaneras2='$pielFaneras2',columnavertebral='$columnavertebral',
			estudiosGabinete='$estudiosGabinete',terapeutica='$terapeutica',criteriosEspecializadas='$criteriosEspecializadas',
			educacionEspecial='$educacionEspecial',gestionEquipo='$gestionEquipo',procesosAdmin='$procesosAdmin',diagnostico='$diagnostico',
			pronosticoVida='$pronosticoVida',pronosticoFuncion='$pronosticoFuncion',cedula='$cedula', fecha='$fecha' WHERE id='$idHistClin'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdDHistClin) or die (mysqli_error($conexionMedico));
			
		if(!$result0){
			//echo'0';
			echo $queryUpdDHistClin;
		} else {
			echo '1';
			#echo $queryUpdDHistClin;
		}
	} else {
		echo '0';
		return false;
	}
?>
