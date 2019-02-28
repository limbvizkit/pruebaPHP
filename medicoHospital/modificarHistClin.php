<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idHistClin']))
	{
		$idHistClin  = $_POST["idHistClin"];
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
			$tipoInterroga  = $_POST["tipoInterroga"];
		} else {
			$tipoInterroga = '';
		}
		if (isset($_POST['antecedentesHeredo']))
		{
			$antecedentesHeredo  = $_POST["antecedentesHeredo"];
		} else {
			$antecedentesHeredo = '';
		}
		if (isset($_POST['edoCivil']))
		{
			$edoCivil  = $_POST["edoCivil"];
		} else {
			$edoCivil = '';
		}
		if (isset($_POST['ocupacion']))
		{
			$ocupacion  = $_POST["ocupacion"];
		} else {
			$ocupacion = '';
		}
		if (isset($_POST['lugarOrigen']))
		{
			$lugarOrigen  = $_POST["lugarOrigen"];
		} else {
			$lugarOrigen = '';
		}
		if (isset($_POST['escolaridad']))
		{
			$escolaridad  = $_POST["escolaridad"];
		} else {
			$escolaridad = '';
		}
		if (isset($_POST['religion']))
		{
			$religion  = $_POST["religion"];
		} else {
			$religion = '';
		}
		if (isset($_POST['grupoRH']))
		{
			$grupoRH  = $_POST["grupoRH"];
		} else {
			$grupoRH = '';
		}
		if (isset($_POST['habitacion']))
		{
			$habitacion  = $_POST["habitacion"];
		} else {
			$habitacion = '';
		}
		if (isset($_POST['habitos']))
		{
			$habitos  = $_POST["habitos"];
		} else {
			$habitos = '';
		}
		if (isset($_POST['alimentacion']))
		{
			$alimentacion  = $_POST["alimentacion"];
		} else {
			$alimentacion = '';
		}
		if (isset($_POST['actividadFisica']))
		{
			$actividadFisica  = $_POST["actividadFisica"];
		} else {
			$actividadFisica = '';
		}
		if (isset($_POST['inmunizaciones']))
		{
			$inmunizaciones  = $_POST["inmunizaciones"];
		} else {
			$inmunizaciones = '';
		}
		if (isset($_POST['antecedentesPatologicos']))
		{
			$antecedentesPatologicos  = $_POST["antecedentesPatologicos"];
		} else {
			$antecedentesPatologicos = '';
		}
		if (isset($_POST['conciliacionMedicamentos']))
		{
			$conciliacionMedicamentos  = $_POST["conciliacionMedicamentos"];
		} else {
			$conciliacionMedicamentos = '';
		}
		if (isset($_POST['antecedentesGineco']))
		{
			$antecedentesGineco  = $_POST["antecedentesGineco"];
		} else {
			$antecedentesGineco = '';
		}
		if (isset($_POST['antecedentesPediatricos']))
		{
			$antecedentesPediatricos  = $_POST["antecedentesPediatricos"];
		} else {
			$antecedentesPediatricos = '';
		}
		if (isset($_POST['padecimientoActual']))
		{
			$padecimientoActual  = $_POST["padecimientoActual"];
		} else {
			$padecimientoActual = '';
		}
		if (isset($_POST['sintomas']))
		{
			$sintomas  = $_POST["sintomas"];
		} else {
			$sintomas = '';
		}
		if (isset($_POST['respiratorio']))
		{
			$respiratorio  = $_POST["respiratorio"];
		} else {
			$respiratorio = '';
		}
		if (isset($_POST['musculoEsquele']))
		{
			$musculoEsquele  = $_POST["musculoEsquele"];
		} else {
			$musculoEsquele = '';
		}
		if (isset($_POST['digestivo']))
		{
			$digestivo  = $_POST["digestivo"];
		} else {
			$digestivo = '';
		}
		if (isset($_POST['genital']))
		{
			$genital  = $_POST["genital"];
		} else {
			$genital = '';
		}
		if (isset($_POST['endocrino']))
		{
			$endocrino  = $_POST["endocrino"];
		} else {
			$endocrino = '';
		}
		if (isset($_POST['nervioso']))
		{
			$nervioso  = $_POST["nervioso"];
		} else {
			$nervioso = '';
		}
		if (isset($_POST['hematologico']))
		{
			$hematologico  = $_POST["hematologico"];
		} else {
			$hematologico = '';
		}
		if (isset($_POST['psicologico']))
		{
			$psicologico  = $_POST["psicologico"];
		} else {
			$psicologico = '';
		}
		if (isset($_POST['urinario']))
		{
			$urinario  = $_POST["urinario"];
		} else {
			$urinario = '';
		}
		if (isset($_POST['cardiocirculatorio']))
		{
			$cardiocirculatorio  = $_POST["cardiocirculatorio"];
		} else {
			$cardiocirculatorio = '';
		}
		if (isset($_POST['pielFaneras']))
		{
			$pielFaneras  = $_POST["pielFaneras"];
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
			$habEx  = $_POST["habEx"];
		} else {
			$habEx = '';
		}
		if (isset($_POST['cabeza']))
		{
			$cabeza  = $_POST["cabeza"];
		} else {
			$cabeza = '';
		}
		if (isset($_POST['cuello']))
		{
			$cuello  = $_POST["cuello"];
		} else {
			$cuello = '';
		}
		if (isset($_POST['abdomen']))
		{
			$abdomen  = $_POST["abdomen"];
		} else {
			$abdomen = '';
		}
		if (isset($_POST['extremidades']))
		{
			$extremidades  = $_POST["extremidades"];
		} else {
			$extremidades = '';
		}
		if (isset($_POST['genitales']))
		{
			$genitales  = $_POST["genitales"];
		} else {
			$genitales = '';
		}
		if (isset($_POST['neurologico']))
		{
			$neurologico  = $_POST["neurologico"];
		} else {
			$neurologico = '';
		}
		if (isset($_POST['pielFaneras2']))
		{
			$pielFaneras2  = $_POST["pielFaneras2"];
		} else {
			$pielFaneras2 = '';
		}
		if (isset($_POST['columnavertebral']))
		{
			$columnavertebral  = $_POST["columnavertebral"];
		} else {
			$columnavertebral = '';
		}
		if (isset($_POST['estudiosGabinete']))
		{
			$estudiosGabinete  = $_POST["estudiosGabinete"];
		} else {
			$estudiosGabinete = '';
		}
		if (isset($_POST['terapeutica']))
		{
			$terapeutica  = $_POST["terapeutica"];
		} else {
			$terapeutica = '';
		}
		if (isset($_POST['criteriosEspecializadas']))
		{
			$criteriosEspecializadas  = $_POST["criteriosEspecializadas"];
		} else {
			$criteriosEspecializadas = '';
		}
		if (isset($_POST['educacionEspecial']))
		{
			$educacionEspecial  = $_POST["educacionEspecial"];
		} else {
			$educacionEspecial = '';
		}
		if (isset($_POST['gestionEquipo']))
		{
			$gestionEquipo  = $_POST["gestionEquipo"];
		} else {
			$gestionEquipo = '';
		}
		if (isset($_POST['procesosAdmin']))
		{
			$procesosAdmin  = $_POST["procesosAdmin"];
		} else {
			$procesosAdmin = '';
		}
		if (isset($_POST['diagnostico']))
		{
			$diagnostico  = $_POST["diagnostico"];
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
			$cedula = $_POST["cedula"];
		} else {
			$cedula = '';
		}
		if (isset($_POST['fechaFin']))
		{
			$fechaFin = $_POST["fechaFin"];
		} else {
			$fechaFin = '';
		}
		if (isset($_POST['horaFin']))
		{
			$horaFin = $_POST["horaFin"];
		} else {
			$horaFin = '';
		}
		
		$vidaB = $pronosticoVida=='BUENO' ? 'checked':'';
		$vidaM = $pronosticoVida=='MALO' ? 'checked':'';
		$vidaR = $pronosticoVida=='RESERVADO' ? 'checked':'';
		
		$funcionB = $pronosticoFuncion=='BUENO' ? 'checked':'';
		$funcionM = $pronosticoFuncion=='MALO' ? 'checked':'';
		$funcionR = $pronosticoFuncion=='RESERVADO' ? 'checked':'';
		
	$formularioNota = "<table>
		<tr>
			<td><label style='color: beige'>Fecha(*) :</label></td>
			<td><input type='date' class='nombre' name='fecha' id='fecha' value='$fechaFin' disabled></td>
		<tr>
		<tr>
			<td><label style='color: beige'>Hora(*) :</label></td>
			<td><input type='time' class='nombre' name='hora' id='hora' value='$horaFin'></td>
		</tr>
		
		<tr>
			<td><label style='color: beige'>Tipo Interrogatorio :</label></td>
			<td> <select id='tipoInterroga' name='tipoInterroga' class='nombre'>
					<option value='$tipoInterroga'>$tipoInterroga</option>
					<option value='MIXTO'>MIXTO</option>
					<option value='DIRECTO'>DIRECTO</option>
					<option value='INDIRECTO'>INDIRECTO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Estado Civil :</label></td>
			<td> <select id='edoCivil' name='edoCivil' class='nombre'>
					<option value='$edoCivil'>$edoCivil</option>
					<option value='SOLTERO'>SOLTERO</option>
					<option value='CASADO'>CASADO</option>
					<option value='UNIÓN LIBRE'>UNIÓN LIBRE</option>
					<option value='VIUDO'>VIUDO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>OCUPACIÓN(*) :</label></td>
			<td><input type='text' class='nombre' id='ocupacion' name='ocupacion' style='width: 200px; height: 30px' value='$ocupacion' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>LUGAR DE ORIGEN(*) :</label></td>
			<td><input type='text' class='nombre' id='lugarOrigen' name='lugarOrigen' style='width: 200px; height: 30px' value='$lugarOrigen' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ESCOLARIDAD(*) :</label></td>
			<td><input type='text' class='nombre' id='escolaridad' name='escolaridad' style='width: 200px; height: 30px' value='$escolaridad' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>RELIGIÓN :</label></td>
			<td><input type='text' class='nombre' id='religion' name='religion' style='width: 200px; height: 30px' value='$religion' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>GRUPO Y RH :</label></td>
			<td><input type='text' class='nombre' id='grupoRH' name='grupoRH' style='width: 200px; height: 30px' value='$grupoRH' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Antecedentes Heredo Familiares(*) :</label></td>
			<td><textarea class='nombre' id='antecedentesHeredo' name='antecedentesHeredo' rows='3' cols='70'>$antecedentesHeredo</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>HABITACIÓN (*) :</label></td>
			<td><textarea class='nombre' id='habitacion' name='habitacion' rows='3' cols='70'>$habitacion</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>HÁBITOS (*) :</label></td>
			<td><textarea class='nombre' id='habitos' name='habitos' rows='3' cols='70'>$habitos</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ALIMENTACIÓN (*) :</label></td>
			<td><textarea class='nombre' id='alimentacion' name='alimentacion' rows='3' cols='70'>$alimentacion</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ACTIVIDAD FÍSICA (*) :</label></td>
			<td><textarea class='nombre' id='actividadFisica' name='actividadFisica' rows='3' cols='70'>$actividadFisica</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>INMUNIZACIONES  (*) :</label></td>
			<td><textarea class='nombre' id='inmunizaciones' name='inmunizaciones' rows='3' cols='70'>$inmunizaciones</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ANTECEDENTES PATOLÓGICOS (*) :</label></td>
			<td><textarea class='nombre' id='antecedentesPatologicos' name='antecedentesPatologicos' rows='3' cols='70'>$antecedentesPatologicos</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CONCILIACIÓN DE MEDICAMENTOS AL INGRESO (*) :</label></td>
			<td><textarea class='nombre' id='conciliacionMedicamentos' name='conciliacionMedicamentos' rows='3' cols='70'>$conciliacionMedicamentos</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ANTECEDENTES GINECO-OBSTÉTRICOS :</label></td>
			<td><textarea class='nombre' id='antecedentesGineco' name='antecedentesGineco' rows='3' cols='70'>$antecedentesGineco</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ANTECEDENTES PEDIÁTRICOS :</label></td>
			<td><textarea class='nombre' id='antecedentesPediatricos' name='antecedentesPediatricos' rows='3' cols='70'>$antecedentesPediatricos</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PADECIMIENTO ACTUAL (*) :</label></td>
			<td><textarea class='nombre' id='padecimientoActual' name='padecimientoActual' rows='3' cols='70'>$padecimientoActual</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>SÍNTOMAS GENERALES (*) :</label></td>
			<td><textarea class='nombre' id='sintomas' name='sintomas' rows='3' cols='70'>$sintomas</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>RESPIRATORIO (*) :</label></td>
			<td><textarea class='nombre' id='respiratorio' name='respiratorio' rows='3' cols='70'>$respiratorio</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>MÚSCULO-ESQUELETICO (*) :</label></td>
			<td><textarea class='nombre' id='musculoEsquele' name='musculoEsquele' rows='3' cols='70'>$musculoEsquele</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>DIGESTIVO (*) :</label></td>
			<td><textarea class='nombre' id='digestivo' name='digestivo' rows='3' cols='70'>$digestivo</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>GENITAL (*) :</label></td>
			<td><textarea class='nombre' id='genital' name='genital' rows='3' cols='70'>$genital</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ENDOCRINO (*) :</label></td>
			<td><textarea class='nombre' id='endocrino' name='endocrino' rows='3' cols='70'>$endocrino</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>NERVIOSO (*) :</label></td>
			<td><textarea class='nombre' id='nervioso' name='nervioso' rows='3' cols='70'>$nervioso</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>HEMATOLÓGICO (*) :</label></td>
			<td><textarea class='nombre' id='hematologico' name='hematologico' rows='3' cols='70'>$hematologico</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PSICOLÓGICOS (*) :</label></td>
			<td><textarea class='nombre' id='psicologico' name='psicologico' rows='3' cols='70'>$psicologico</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>URINARIO (*) :</label></td>
			<td><textarea class='nombre' id='urinario' name='urinario' rows='3' cols='70'>$urinario</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CARDIOCIRCULATORIO (*) :</label></td>
			<td><textarea class='nombre' id='cardiocirculatorio' name='cardiocirculatorio' rows='3' cols='70'>$cardiocirculatorio</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PIEL Y FANERAS (*) :</label></td>
			<td><textarea class='nombre' id='pielFaneras' name='pielFaneras' rows='3' cols='70'>$pielFaneras</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FC(*) :</label></td>
			<td><input type='text' class='nombre' id='fc' name='fc' style='width: 60px; height: 30px' value='$fc' autocomplete='off'><b>min</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FR(*) :</label></td>
			<td><input type='text' class='nombre' id='fr' name='fr' style='width: 60px; height: 30px' value='$fr' autocomplete='off'><b>min</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>T/A(*) :</label></td>
			<td><input type='text' class='nombre' id='ta' name='ta' style='width: 60px; height: 30px' value='$ta' autocomplete='off'><b>mmHg</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TEMP(*) :</label></td>
			<td><input type='text' class='nombre' id='temp' name='temp' style='width: 60px; height: 30px' value='$temp' autocomplete='off'><b>°C</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>SO2(*) :</label></td>
			<td><input type='text' class='nombre' id='so' name='so' style='width: 60px; height: 30px' value='$so' autocomplete='off'><b>%</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>GLUCOSA (*) :</label></td>
			<td><input type='text' class='nombre' id='glucosa' name='glucosa' style='width: 60px; height: 30px' value='$glucosa' autocomplete='off'><b>mg/dl</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PESO(*) :</label></td>
			<td><input type='text' class='nombre' id='peso' name='peso' style='width: 60px; height: 30px' value='$peso' autocomplete='off'><b>kg</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TALLA(*) :</label></td>
			<td><input type='text' class='nombre' id='talla' name='talla' style='width: 60px; height: 30px' value='$talla' autocomplete='off'><b>mts</b></td>
		</tr>
		<tr>
			<td><label style='color: beige'>HABITUS EXTERIOR (*) :</label></td>
			<td><textarea class='nombre' id='habEx' name='habEx' rows='3' cols='70'>$habEx</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CABEZA (*) :</label></td>
			<td><textarea class='nombre' id='cabeza' name='cabeza' rows='3' cols='70'>$cabeza</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CUELLO (*) :</label></td>
			<td><textarea class='nombre' id='cuello' name='cuello' rows='3' cols='70'>$cuello</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ABDOMEN (*) :</label></td>
			<td><textarea class='nombre' id='abdomen' name='abdomen' rows='3' cols='70'>$abdomen</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>EXTREMIDADES (*) :</label></td>
			<td><textarea class='nombre' id='extremidades' name='extremidades' rows='3' cols='70'>$extremidades</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>GENITALES (*) :</label></td>
			<td><textarea class='nombre' id='genitales' name='genitales' rows='3' cols='70'>$genitales</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>NEUROLÓGICO (*) :</label></td>
			<td><textarea class='nombre' id='neurologico' name='neurologico' rows='3' cols='70'>$neurologico</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PIEL Y FANERAS (*) :</label></td>
			<td><textarea class='nombre' id='pielFaneras2' name='pielFaneras2' rows='3' cols='70'>$pielFaneras2</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>COLUMNA VERTEBRAL (*) :</label></td>
			<td><textarea class='nombre' id='columnavertebral' name='columnavertebral' rows='3' cols='70'>$columnavertebral</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ESTUDIOS DE GABINETE Y LABORATORIO (*) :</label></td>
			<td><textarea class='nombre' id='estudiosGabinete' name='estudiosGabinete' rows='3' cols='70'>$estudiosGabinete</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TERAPEUTICA EMPLEADA Y RESULTADOS OBTENIDOS (*) :</label></td>
			<td><textarea class='nombre' id='terapeutica' name='terapeutica' rows='3' cols='70'>$terapeutica</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CRITERIOS PARA IDENTIFICAR PACIENTES QUE REQUIEREN EVALUACIONES ESPECIALIZADAS (*) :</label></td>
			<td><textarea class='nombre' id='criteriosEspecializadas' name='criteriosEspecializadas' rows='3' cols='70'>$criteriosEspecializadas</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>EDUCACIÓN ESPECIAL (*) :</label></td>
			<td><textarea class='nombre' id='educacionEspecial' name='educacionEspecial' rows='3' cols='70'>$educacionEspecial</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>GESTIÓN DE EQUIPO A SU EGRESO (*) :</label></td>
			<td><textarea class='nombre' id='gestionEquipo' name='gestionEquipo' rows='3' cols='70'>$gestionEquipo</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PROCESOS ADMINISTRATIVOS (*) :</label></td>
			<td><textarea class='nombre' id='procesosAdmin' name='procesosAdmin' rows='3' cols='70'>$procesosAdmin</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>DIAGNÓSTICO (*) :</label></td>
			<td><textarea class='nombre' id='diagnostico' name='diagnostico' rows='3' cols='70'>$diagnostico</textarea></td>
		</tr>
		<tr>
			<td>
				<label style='color: beige'>PRONÓSTICO: </label><br>
				<label style='color: beige'> VIDA :</label>
			</td>
			<td>
				<input type='radio' class='nombre' id='pronosticoVida' name='pronosticoVida' style='width: 35px; height: 35px' value='BUENO' $vidaB> BUENO
				<input type='radio' class='nombre' id='pronosticoVida' name='pronosticoVida' style='width: 35px; height: 35px' value='MALO' $vidaM> MALO
				<input type='radio' class='nombre' id='pronosticoVida' name='pronosticoVida' style='width: 35px; height: 35px' value='RESERVADO' $vidaR> RESERVADO
			</td>
		</tr>
		<tr>
			<td>
				<label style='color: beige'> FUNCIÓN : </label>
			</td>
			<td>
				<input type='radio' class='nombre' id='pronosticoFuncion' name='pronosticoFuncion' style='width: 35px; height: 35px' value='BUENO' $funcionB> BUENO
				<input type='radio' class='nombre' id='pronosticoFuncion' name='pronosticoFuncion' style='width: 35px; height: 35px' value='MALO' $funcionM> MALO
				<input type='radio' class='nombre' id='pronosticoFuncion' name='pronosticoFuncion' style='width: 35px; height: 35px' value='RESERVADO' $funcionR> RESERVADO
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>CEDULA :</label></td>
			<td><input type='text' class='nombre' name='cedula' id='cedula' style='width: 100px; height: 30px' value='$cedula' autocomplete='off'></td>
		</tr>
		
	</table>
	<br>
	<input type='hidden' name='idHistClin' id='idHistClin' value='$idHistClin' >
	<div><input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNota'>";

		$btBorrarNota = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='Borrar'>";
		$formulario = $formularioNota;
		$var = true;
		$borrar=$btBorrarNota;
	}

?>

<form class='contacto' method='POST' action='' id="formu">
	<?php echo $formulario ?>
    <?php if($var) { 
			echo $borrar ?>
    <?php } ?>
    	<input  type='button' value='Cerrar' class='btn btn-default' name='boton' id="Cerrar">
    </div>
</form>

<script type="text/javascript">
	 $(document).ready(function() {
		 $("#nombre").focus();
		 $(".result_fail").hide();
	 });

	 $("#Cerrar").click(function(){
		 $("#div_User").fadeOut();
	 });
 
 /*Evento Click Botón Enviar Nota Urg*/
 $("#enviarNota").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	 var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	 
	/* if ($("#fechaM").val() == "" || !yearreg.test($("#fechaM").val())) { 
	 	//alert("Usuario Inválido");
	 	$("#fechaM").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }*/
	  
	 if ($("#fecha").val() == "") { 
	 	$("#fecha").focus().after('<span class="error"> Colocar Fecha </span>');
	 	return false;
	 }
	 if ($("#diagnostico").val() == "") { 
	 	$("#diagnostico").focus().after('<span class="error"> Colocar Diagnósticos </span>');
	 	return false;
	 }
	  if ($("#ocupacion").val() == "") { 
	 	$("#ocupacion").focus().after('<span class="error"> Colocar Ocupacion </span>');
	 	return false;
	 }
	 if ($("#lugarOrigen").val() == "") { 
	 	$("#lugarOrigen").focus().after('<span class="error"> Colocar Lugar de origen </span>');
	 	return false;
	 }
	  if ($("#escolaridad").val() == "") { 
	 	$("#escolaridad").focus().after('<span class="error"> Colocar Escolaridad </span>');
	 	return false;
	 }
	 if ($("#antecedentesHeredo").val() == "") { 
	 	$("#antecedentesHeredo").focus().after('<span class="error"> Colocar Antecedentes Heredo Fam. </span>');
	 	return false;
	 }
	 
	/*Fin Validaciónes*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveHistClin.php',
			error: function(data){
				//Si sucedió algo, se notifica
					$(".result_fail").fadeIn();
					$(".result_fail").html("Error Procesando Datos");
				},
            data: datos,
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				if(data==1){
					/*Reconstruimos la tabla*/
					$("#Usuarios").html("");
					$("#Usuarios").load("consultaHistClin.php", function(){});
					alert("Se realizo la Operación Correctamente");
					//Recargamos la pagina para que se vean los cambios
					self.parent.location.reload();
					/*Fin Reconstruir la tabla*/
					$("#div_User").hide();
		        } else {
					$(".result_fail").fadeIn();
					$(".result_fail").html("Error " . data);
					alert("!!!ERROR: NO Se realizo la Operación !!!");
					return false;
				}
			 }
		});
});
 /*Fin Evento Click Botón Enviar NOTA Urg*/

 /*Evento Click Botón Borrar Nota de Urg*/
 $("#Borrar").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará la Historia Clínica de la fecha: "+ $("#fecha").val());
	 
	 if(Resp){
			 /*Escogió opción ACEPTAR*/
			 //Determinanos los datos del formulario y los serializamos
			var datos = $("#formu").serialize();
			// Enviamos el formulario usando AJAX
			$.ajax({
				type: 'POST',
				url: 'delNotaUrg.php',
				error: function(data){
					//Si sucedió algo, se notifica
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error Eliminando Registro");
						alert("!!!ERROR DATA: NO Se elimino la Historia Clínica !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaPreoperatoria.php", function(){});
						alert("Se Elimino la Historia Clínica Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Historia Clínica !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
	
	