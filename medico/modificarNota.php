
<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idNotaUrg']))
	{
		$idNotaUrg  = $_POST["idNotaUrg"];

		if (isset($_POST['hora']))
		{
			$hora1  = $_POST["hora"];
			$hora = substr($hora1, 0, -3);
		} else {
			$hora = '';
		}

		if (isset($_POST['antece']))
		{
			$antece  = $_POST["antece"];
		} else {
			$antece = '';
		}
		if (isset($_POST['inter']))
		{
			$inter  = $_POST["inter"];
		} else {
			$inter = '';
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
		if (isset($_POST['habEx']))
		{
			$habEx  = $_POST["habEx"];
		} else {
			$habEx = '';
		}
		if (isset($_POST['cabez']))
		{
			$cabez  = $_POST["cabez"];
		} else {
			$cabez = '';
		}
		if (isset($_POST['torax']))
		{
			$torax  = $_POST["torax"];
		} else {
			$torax = '';
		}
		if (isset($_POST['abdom']))
		{
			$abdom  = $_POST["abdom"];
		} else {
			$abdom = '';
		}
		if (isset($_POST['extrm']))
		{
			$extrm  = $_POST["extrm"];
		} else {
			$extrm = '';
		}
		if (isset($_POST['resEst']))
		{
			$resEst  = $_POST["resEst"];
		} else {
			$resEst = '';
		}
		if (isset($_POST['diagn']))
		{
			$diagn  = $_POST["diagn"];
		} else {
			$diagn = '';
		}
		if (isset($_POST['tratam2']))
		{
			$tratam2  = $_POST["tratam2"];
		} else {
			$tratam2 = '';
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
		if (isset($_POST['horaFin']))
		{
			$horaFin  = $_POST["horaFin"];
		} else {
			$horaFin = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula  = $_POST["cedula"];
		} else {
			$cedula = '';
		}
		
		$vidaB = $pronosticoVida=='BUENO' ? 'checked':'';
		$vidaM = $pronosticoVida=='MALO' ? 'checked':'';
		$vidaR = $pronosticoVida=='RESERVADO' ? 'checked':'';
		
		$funcionB = $pronosticoFuncion=='BUENO' ? 'checked':'';
		$funcionM = $pronosticoFuncion=='MALO' ? 'checked':'';
		$funcionR = $pronosticoFuncion=='RESERVADO' ? 'checked':'';


		$formularioNota = "<table>
		<tr>
			<td><label style='color: beige'>Hora(*) :</label></td>
			<td><input type='time' class='nombre' name='hora' id='hora' value='$hora'></td>
		<tr>
			<td><label style='color: beige'>Antecedentes(*) :</label></td>
			<td><textarea class='nombre' id='antece' name='antece' rows='3' cols='70'>$antece</textarea></td>
		</tr>		
		<tr>
			<td><label style='color: beige'>Interrogatorio (*):</label></td>
			<td><textarea class='nombre' id='inter' name='inter' rows='3' cols='70'>$inter</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FC :</label></td>
			<td><input type='text' class='nombre' name='fc' id='fc' style='width: 50px; height: 30px' value='$fc' autocomplete='off'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>FR :</label></td>
			<td><input type='text' class='nombre' name='fr' id='fr' style='width: 50px; height: 30px' value='$fr' autocomplete='off'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>TA :</label></td>
			<td><input type='text' class='nombre' name='ta' id='ta' style='width: 70px; height: 30px' value='$ta' autocomplete='off'>mmHg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Temperatura :</label></td>
			<td><input type='text' class='nombre' name='temp' id='temp' style='width: 50px; height: 30px' value='$temp' autocomplete='off'>°C</td>
		</tr>
		<tr>
			<td><label style='color: beige'>SO :</label></td>
			<td><input type='text' class='nombre' name='so' id='so' style='width: 50px; height: 30px' value='$so' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Glucosa :</label></td>
			<td><input type='text' class='nombre' name='glucosa' id='so' style='width: 50px; height: 30px' value='$glucosa' autocomplete='off'>mg/dl</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Hab. Exterior :</label></td>
			<td><textarea class='nombre' id='habEx' name='habEx' rows='3' cols='70'>$habEx</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Cabeza :</label></td>
			<td><textarea class='nombre' id='cabez' name='cabez' rows='3' cols='70'>$cabez</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Torax :</label></td>
			<td><textarea class='nombre' id='torax' name='torax' rows='3' cols='70'>$torax</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Abdomen :</label></td>
			<td><textarea class='nombre' id='abdom' name='abdom' rows='3' cols='70'>$abdom</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Extremidades :</label></td>
			<td><textarea class='nombre' id='extrm' name='extrm' rows='3' cols='70'>$extrm</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Resultado de Estudios:</label></td>
			<td><textarea class='nombre' id='resEst' name='resEst' rows='3' cols='70'>$resEst</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Diagnósticos(*) :</label></td>
			<td><textarea class='nombre' id='diagn' name='diagn' rows='3' cols='70'>$diagn</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Tratamiento(*) :</label></td>
			<td><textarea class='nombre' id='tratam2' name='tratam2' rows='3' cols='70'>$tratam2</textarea></td>
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
			<td><label style='color: beige'>HoraFin(*) :</label></td>
			<td><input type='time' class='nombre' name='horaFin' id='hora' value='$horaFin'></td>
		<tr>
		<tr>
			<td><label style='color: beige'>Cedula(*) :</label></td>
			<td><input type='text' class='nombre' name='cedula' id='cedula' style='width: 100px; height: 30px' value='$cedula' autocomplete='off'></td>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idNotaUrg' id='idNotaUrg' value='$idNotaUrg' >
	<div><input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNota'>";

		$btBorrarNota = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='Borrar'>";
		$formulario = $formularioNota;
		$var = true;
		$borrar=$btBorrarNota;
	}
/*-------------------------------------------------------------------------------------------------------------------------------------------------*/
	//Datos para Nota Urgencias Triage
	if (isset($_POST['idNotaUrgT']))
	{
		$idNotaUrgT  = $_POST["idNotaUrgT"];
		
		if (isset($_POST['hora']))
		{
			$hora1  = $_POST["hora"];
			$hora = substr($hora1, 0, -3);
		} else {
			$hora = '';
		}

		if (isset($_POST['fecha']))
		{
			$fecha  = $_POST["fecha"];
		} else {
			$fecha = '';
		}
		
		/*if (isset($_POST['fechaV']))
		{
			$fechaV  = $_POST["fechaV"];			
		} else {
			$fechaV = '';
		}*/

		if (isset($_POST['turno']))
		{
			$turno  = $_POST["turno"];
		} else {
			$turno = '';
		}

		if (isset($_POST['acude']))
		{
			$acude  = $_POST["acude"];
		} else {
			$acude = '';
		}
		if (isset($_POST['motivo']))
		{
			$motivo  = $_POST["motivo"];
		} else {
			$motivo = '';
		}
		if (isset($_POST['ta']))
		{
			$ta  = $_POST["ta"];
		} else {
			$ta = '';
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
		if (isset($_POST['color']))
		{
			$color  = $_POST["color"];
		} else {
			$color = '';
		}
		if (isset($_POST['horaFin']))
		{
			$horaFin1  = $_POST["horaFin"];
			$horaFin = substr($horaFin1, 0, -3);
		} else {
			$horaFin = '';
		}
		if (isset($_POST['realizo']))
		{
			$realizo  = $_POST["realizo"];
		} else {
			$realizo = '';
		}

		$formularioNotaT = "<table>
		<tr>
			<td><label style='color: beige'>Fecha(*) :</label></td>
			<td><input type='text' class='nombre' name='fecha' id='fecha' value='$fecha' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>HoraIni(*) :</label></td>
			<td><input type='time' class='nombre' name='hora' id='hora' value='$hora'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Turno :</label></td>
			<td><select id='turno' name='turno' class='nombre'>
					<option value='$turno'>Seleccione</option>
					<option value='M'>Matutino</option>
					<option value='V'>Vespertino</option>
					<option value='N'>Nocturno</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Acude :</label></td>
			<td> <select id='acude' name='acude' class='nombre'>
					<option value='$acude'>Seleccione</option>
					<option value='AMBULANCIA'>Ambulancia</option>
					<option value='CAMINANDO'>Caminando</option>
					<option value='BRAZOS'>Brazos</option>
				   <option value='SILLA DE RUEDAS'>Silla de Ruedas</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Motivo (*):</label></td>
			<td><textarea class='nombre' id='motivo' name='motivo' rows='3' cols='70'>$motivo</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TA :</label></td>
			<td><input type='text' class='nombre' name='ta' id='ta' style='width: 70px; height: 30px' value='$ta' autocomplete='off'>mmHg</td>
		</tr>
			<td><label style='color: beige'>FC :</label></td>
			<td><input type='text' class='nombre' name='fc' id='fc' style='width: 50px; height: 30px' value='$fc' autocomplete='off'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>FR :</label></td>
			<td><input type='text' class='nombre' name='fr' id='fr' style='width: 50px; height: 30px' value='$fr' autocomplete='off'>min</td>
		</tr>		
		<tr>
			<td><label style='color: beige'>Temperatura :</label></td>
			<td><input type='text' class='nombre' name='temp' id='temp' style='width: 50px; height: 30px' value='$temp' autocomplete='off'>°C</td>
		</tr>
		<tr>
			<td><label style='color: beige'>SO :</label></td>
			<td><input type='text' class='nombre' name='so' id='so' style='width: 50px; height: 30px' value='$so' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Glucosa :</label></td>
			<td><input type='text' class='nombre' name='glucosa' id='glucosa' style='width: 50px; height: 30px' value='$glucosa' autocomplete='off'>mg/dl</td>
		</tr>
		
		<tr>
			<td><label style='color: beige'>Peso :</label></td>
			<td><input type='text' class='nombre' name='peso' id='peso' style='width: 50px; height: 30px' value='$peso' autocomplete='off'>Kg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Talla :</label></td>
			<td><input type='text' class='nombre' name='talla' id='talla' style='width: 50px; height: 30px' value='$talla' autocomplete='off'>Mts</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Color :</label></td>
			<td><label style='color: red'>ROJO : </label>
				<input type='radio' name='color' value='ROJO' class='nombre' checked>
				<label style='color: yellow'>AMARILLO : </label>
				<input type='radio' name='color' value='AMARILLO' class='nombre'>
				<label style='color: green'>VERDE : </label>
				<input type='radio' name='color' value='VERDE' class='nombre'>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>HoraFin(*) :</label></td>
			<td><input type='time' class='nombre' name='horaFin' id='hora' value='$horaFin'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Realizo(*) :</label></td>
			<td><input type='text' class='nombre' name='realizo' id='realizo' style='width: 300px; height: 30px' value='$realizo' autocomplete='off'></td>
		</tr>	
	</table>
	<br>
			<input type='hidden' name='idNotaUrgT' id='idNotaUrgT' value='$idNotaUrgT' >
			<div><input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNotaT'>";

		$btBorrarNotaT = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='BorrarT'>";
		$formulario = $formularioNotaT;
		$var = true;
		$borrar=$btBorrarNotaT;
	}
/*-------------------------------------------------------------------------------------------------------------------------------------------------*/
	if (isset($_POST['idNotaCh']))
	{
		$idNotaCh  = $_POST["idNotaCh"];

		if (isset($_POST['hora']))
		{
			$hora1  = $_POST["hora"];
			$hora = substr($hora1, 0, -3);
		} else {
			$hora = '';
		}
		if (isset($_POST['turno']))
		{
			$turno  = $_POST["turno"];
		} else {
			$turno ='';
		}
		if (isset($_POST['acude']))
		{
			$acude  = $_POST["acude"];
		} else {
			$acude = '';
		}
		if (isset($_POST['nPaciente']))
		{
			$nPaciente  = $_POST["nPaciente"];
		} else {
			$nPaciente = '';
		}
		if (isset($_POST['fecha']))
		{
			$fecha  = $_POST["fecha"];
		} else {
			$fecha ='';
		}
		if (isset($_POST['antece']))
		{
			$antece  = $_POST["antece"];			
		} else {
			$antece = '';
		}

		if (isset($_POST['tratam']))
		{
			$tratam  = $_POST["tratam"];
		} else {
			$tratam = '';
		}

		if (isset($_POST['inter']))
		{
			$inter  = $_POST["inter"];
		} else {
			$inter = '';
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
		if (isset($_POST['respOcul']))
		{
			$respOcul  = $_POST["respOcul"];
		} else {
			$respOcul = '';
		}
		if (isset($_POST['respVerb']))
		{
			$respVerb  = $_POST["respVerb"];
		} else {
			$respVerb = '';
		}
		if (isset($_POST['respMot']))
		{
			$respMot  = $_POST["respMot"];
		} else {
			$respMot = '';
		}
		if (isset($_POST['habEx']))
		{
			$habEx  = $_POST["habEx"];
		} else {
			$habEx = '';
		}
		if (isset($_POST['cabez']))
		{
			$cabez  = $_POST["cabez"];
		} else {
			$cabez = '';
		}
		if (isset($_POST['torax']))
		{
			$torax  = $_POST["torax"];
		} else {
			$torax = '';
		}
		if (isset($_POST['abdom']))
		{
			$abdom  = $_POST["abdom"];
		} else {
			$abdom = '';
		}
		if (isset($_POST['extrm']))
		{
			$extrm  = $_POST["extrm"];
		} else {
			$extrm = '';
		}
		if (isset($_POST['bhc']))
		{
			$bhc  = $_POST["bhc"];
		} else {
			$bhc = '';
		}
		if (isset($_POST['qs']))
		{
			$qs  = $_POST["qs"];
		} else {
			$qs = '';
		}
		if (isset($_POST['tpt']))
		{
			$tpt  = $_POST["tpt"];
		} else {
			$tpt = '';
		}
		if (isset($_POST['rx']))
		{
			$rx  = $_POST["rx"];
		} else {
			$rx = '';
		}
		if (isset($_POST['tac']))
		{
			$tac  = $_POST["tac"];
		} else {
			$tac = '';
		}
		if (isset($_POST['rm']))
		{
			$rm  = $_POST["rm"];
		} else {
			$rm = '';
		}
		if (isset($_POST['us']))
		{
			$us  = $_POST["us"];
		} else {
			$us = '';
		}
		if (isset($_POST['paraclin']))
		{
			$paraclin  = $_POST["paraclin"];
		} else {
			$paraclin = '';
		}
		if (isset($_POST['diagn']))
		{
			$diagn  = $_POST["diagn"];
		} else {
			$diagn = '';
		}
		if (isset($_POST['tratUtil']))
		{
			$tratUtil  = $_POST["tratUtil"];
		} else {
			$tratUtil = '';
		}
		if (isset($_POST['tratUtilTxt']))
		{
			$tratUtilTxt  = $_POST["tratUtilTxt"];
		} else {
			$tratUtilTxt = '';
		}
		if (isset($_POST['interconsulta']))
		{
			$interconsulta  = $_POST["interconsulta"];
		} else {
			$interconsulta = '';
		}
		if (isset($_POST['horaSol']))
		{
			$horaSol  = $_POST["horaSol"];
		} else {
			$horaSol = '';
		}
		if (isset($_POST['especialidad']))
		{
			$especialidad  = $_POST["especialidad"];
		} else {
			$especialidad = '';
		}
		if (isset($_POST['horaAcud']))
		{
			$horaAcud  = $_POST["horaAcud"];
		} else {
			$horaAcud = '';
		}
		if (isset($_POST['vida']))
		{
			$vida  = $_POST["vida"];
		} else {
			$vida = '';
		}
		if (isset($_POST['funcion']))
		{
			$funcion  = $_POST["funcion"];
		} else {
			$funcion = '';
		}
		if (isset($_POST['ingresa']))
		{
			$ingresa  = $_POST["ingresa"];
		} else {
			$ingresa = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula  = $_POST["cedula"];
		} else {
			$cedula = '';
		}
		if (isset($_POST['exp']))
		{
			$exp  = $_POST["exp"];
		} else {
			$exp = '';
		}
		if (isset($_POST['folio']))
		{
			$folio  = $_POST["folio"];
		} else {
			$folio = '';
		}
		$bhcCK = $bhc=='1' ? 'checked':'';
		$qsCK = $qs=='1' ? 'checked':'';
		$tptCK = $tpt=='1' ? 'checked':'';
		$rxCK = $rx=='1' ? 'checked':'';
		$tacCK = $tac=='1' ? 'checked':'';
		$rmCK = $rm=='1' ? 'checked':'';
		$usCK = $us=='1' ? 'checked':'';
		$trataCK = $tratUtil=='SI' ? 'checked':'';
		$interconsultaCK = $interconsulta=='SI' ? 'checked':'';
		
		$vidaB = $vida=='BUENO' ? 'checked':'';
		$vidaM = $vida=='MALO' ? 'checked':'';
		$vidaR = $vida=='RESERVADO' ? 'checked':'';
		
		$funcionB = $funcion=='BUENO' ? 'checked':'';
		$funcionM = $funcion=='MALO' ? 'checked':'';
		$funcionR = $funcion=='RESERVADO' ? 'checked':'';
		
		$formularioNotaCh = "<table>
		<input type='text' class='nombre' name='fecha' id='fecha' value='$fecha' style='display:none'>
		<tr>
			<td><label style='color: beige'>Expediente :</label></td>
			<td><input type='text' class='nombre' name='expediente' id='expediente' onblur='rellenar(this,this.value)' value='$exp' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Folio :</label></td>
			<td><input type='text' class='nombre' name='folio' id='folio' autocomplete='off' value='$folio' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Hora(*) :</label></td>
			<td><input type='time' class='nombre' name='hora' id='hora' value='$hora'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TURNO :</label></td>
			<td> <select id='turno' name='turno' class='nombre'>
					<option value='$turno'>Seleccione</option>
					<option value='M'>MATUTINO</option>
					<option value='V'>VESPERTINO</option>
					<option value='N'>NOCTURNO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Acude :</label></td>
			<td> <select id='acude' name='acude' class='nombre'>
					<option value='$acude'>Seleccione</option>
					<option value='AMBULANCIA'>Ambulancia</option>
					<option value='CAMINANDO'>Caminando</option>
					<option value='BRAZOS'>Brazos</option>
				   <option value='SILLA DE RUEDAS'>Silla de Ruedas</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Antecedentes(*) :</label></td>
			<td><textarea class='nombre' id='antece' name='antece' rows='3' cols='70'>$antece</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Tratamiento (Conciliación de Medicamentos*) :</label></td>
			<td><textarea class='nombre' id='tratam' name='tratam' rows='3' cols='70'>$tratam</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Interrogatorio (*):</label></td>
			<td><textarea class='nombre' id='inter' name='inter' rows='3' cols='70'>$inter</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FC (*):</label></td>
			<td><input type='text' class='nombre' name='fc' id='fc' style='width: 50px; height: 30px' value='$fc' autocomplete='off'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>FR (*):</label></td>
			<td><input type='text' class='nombre' name='fr' id='fr' style='width: 50px; height: 30px' value='$fr' autocomplete='off'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>TA (*):</label></td>
			<td><input type='text' class='nombre' name='ta' id='ta' style='width: 70px; height: 30px' value='$ta' autocomplete='off'>mmHg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Temperatura (*):</label></td>
			<td><input type='text' class='nombre' name='temp' id='temp' style='width: 50px; height: 30px' value='$temp' autocomplete='off'>°C</td>
		</tr>
		<tr>
			<td><label style='color: beige'>SO2 (*):</label></td>
			<td><input type='text' class='nombre' name='so' id='so' style='width: 50px; height: 30px' value='$so' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Glucosa:</label></td>
			<td><input type='text' class='nombre' name='glucosa' id='so' style='width: 50px; height: 30px' value='$glucosa' autocomplete='off'>mg/dl</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Resp. Ocular (*):</label></td>
			<td><input type='text' class='nombre' name='respOcul' id='respOcul' style='width: 50px; height: 30px' value='$respOcul' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Resp. Verbal (*):</label></td>
			<td><input type='text' class='nombre' name='respVerb' id='respVerb' style='width: 50px; height: 30px' value='$respVerb' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Resp. Motora (*):</label></td>
			<td><input type='text' class='nombre' name='respMot' id='respMot' style='width: 50px; height: 30px' value='$respMot' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Hab. Exterior (*):</label></td>
			<td><textarea class='nombre' id='habEx' name='habEx' rows='3' cols='70'>$habEx</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Cabeza (*):</label></td>
			<td><textarea class='nombre' id='cabez' name='cabez' rows='3' cols='70'>$cabez</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Torax (*):</label></td>
			<td><textarea class='nombre' id='torax' name='torax' rows='3' cols='70'>$torax</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Abdomen (*):</label></td>
			<td><textarea class='nombre' id='abdom' name='abdom' rows='3' cols='70'>$abdom</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Extremidades (*):</label></td>
			<td><textarea class='nombre' id='extrm' name='extrm' rows='3' cols='70'>$extrm</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Paraclinicos: BHC</label></td>
			<td><input type='checkbox' class='nombre' id='bhc' name='bhc' style='width: 45px; height: 35px' value='1' $bhcCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>QS</label></td>
			<td><input type='checkbox' class='nombre' id='qs' name='qs' style='width: 45px; height: 35px' value='1' $qsCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TPT</label></td>
			<td><input type='checkbox' class='nombre' id='tpt' name='tpt' style='width: 45px; height: 35px' value='1' $tptCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>RX</label></td>
			<td><input type='checkbox' class='nombre' id='rx' name='rx' style='width: 45px; height: 35px' value='1' $rxCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TAC</label></td>
			<td><input type='checkbox' class='nombre' id='tac' name='tac' style='width: 45px; height: 35px' value='1' $tacCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>RM</label></td>
			<td><input type='checkbox' class='nombre' id='rm' name='rm' style='width: 45px; height: 35px' value='1' $rmCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>US</label></td>
			<td><input type='checkbox' class='nombre' id='us' name='us' style='width: 45px; height: 35px' value='1' $usCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Interpretación de Paraclínicos :</label></td>
			<td><textarea class='nombre' id='paraclin' name='paraclin' rows='3' cols='70'>$paraclin</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Diagnósticos(*) :</label></td>
			<td><textarea class='nombre' id='diagn' name='diagn' rows='3' cols='70'>$diagn</textarea></td>
		</tr>
		<!--tr>
			<td><label style='color: beige'>Tratamiento Utilizó :</label></td>
			<td><input type='checkbox' class='nombre' id='tratUtil' name='tratUtil' style='width: 45px; height: 35px' value='SI' $trataCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Tratamiento Utilizó Txt :</label></td>
			<td><textarea class='nombre' id='tratUtilTxt' name='tratUtilTxt' rows='3' cols='70'>$tratUtilTxt</textarea></td>
		</tr-->
		<tr>
			<td><label style='color: beige'>Interconsulta :</label></td>
			<td><input type='checkbox' class='nombre' id='interconsulta' name='interconsulta' style='width: 45px; height: 35px' value='SI' $interconsultaCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Hora de Solicitud :</label></td>
			<td><input type='time' class='nombre' name='horaSol' id='horaSol' value='$horaSol'></td>
		<tr>
		<tr>
			<td><label style='color: beige'>Especialidad :</label></td>
			<td><input type='text' class='nombre' name='especialidad' id='especialidad' style='width: 600px; height: 30px' autocomplete='off' value='$especialidad'></td>
		</tr>
		<!--tr>
			<td><label style='color: beige'>Hora en que Acudió :</label></td>
			<td><input type='time' class='nombre' name='horaAcud' id='horaAcud' value='$horaAcud'></td>
		<tr-->
		<tr>
			<td>
				<label style='color: beige'>PRONÓSTICO: </label><br>
				<label style='color: beige'> VIDA :</label>
			</td>
			<td>
				<input type='radio' class='nombre' id='vida' name='vida' style='width: 35px; height: 35px' value='BUENO' $vidaB> BUENO
				<input type='radio' class='nombre' id='vida' name='vida' style='width: 35px; height: 35px' value='MALO' $vidaM> MALO
				<input type='radio' class='nombre' id='vida' name='vida' style='width: 35px; height: 35px' value='RESERVADO' $vidaR> RESERVADO
			</td>
		</tr>
		<tr>
			<td>
				<label style='color: beige'> FUNCIÓN : </label>
			</td>
			<td>
				<input type='radio' class='nombre' id='funcion' name='funcion' style='width: 35px; height: 35px' value='BUENO' $funcionB> BUENO
				<input type='radio' class='nombre' id='funcion' name='funcion' style='width: 35px; height: 35px' value='MALO' $funcionM> MALO
				<input type='radio' class='nombre' id='funcion' name='funcion' style='width: 35px; height: 35px' value='RESERVADO' $funcionR> RESERVADO
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Ingresa :</label></td>
			<td> <select id='ingresa' name='ingresa' class='nombre'>
					<option value='$ingresa'>Seleccione</option>
					<option value='HOSPITALIZACIÓN'>HOSPITALIZACIÓN</option>
					<option value='UCI'>UCI</option>
					<option value='UCIPYN'>UCIPYN</option>
				   <option value='QUIRÓFANO'>QUIRÓFANO</option>
				   <option value='EGRESO'>EGRESO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Cedula(*) :</label></td>
			<td><input type='text' class='nombre' name='cedula' id='cedula' style='width: 100px; height: 30px' autocomplete='off' value='$cedula'></td>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idNotaCh' id='idNotaCh' value='$idNotaCh' >
	<div> 
	<input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNotaCh'>";
	
	$docPDF=NULL;
	if($exp != NULL && $exp != '' && $folio != NULL && $folio != ''){
		$docPDF = "<input type='button' value='PDF' class='btn btn-danger' name='lvc' style='height: 50px; width: 80px'
	  	onClick=window.open(\"../pdf/creaPDF.php?exp=$exp&folio=$folio&name=ncch\").focus() />";
	  }
		echo $docPDF;
		$btBorrarNotaCh = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='BorrarCh'>";
		$formulario = $formularioNotaCh;
		$var = true;
		$borrar=$btBorrarNotaCh;
	}
/*-------------------------------------------------------------------------------------------------------------------------------------------------*/
	//Datos para Indicaciones Medicas
	if (isset($_POST['idIndicMed']))
	{
		$idIndicMed  = $_POST["idIndicMed"];
				
		if (isset($_POST['nPaciente']))
		{
			$nPaciente=$_POST['nPaciente'];
		} else {
			$nPaciente = '';
		}
		if (isset($_POST['fNacimiento']))
		{
			$fNacimiento=$_POST['fNacimiento'];
		} else {
			$fNacimiento = '';
		}
		if (isset($_POST['diagnostico']))
		{
			$diagnostico  = $_POST["diagnostico"];
		} else {
			$diagnostico = '';
		}
		if (isset($_POST['medTratante']))
		{
			$medTratante  = $_POST["medTratante"];
		} else {
			$medTratante = '';
		}
		if (isset($_POST['exp']))
		{
			$exp  = $_POST["exp"];
		} else {
			$exp = '';
		}
		if (isset($_POST['folio']))
		{
			$folio  = $_POST["folio"];
		} else {
			$folio = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula  = $_POST["cedula"];
		} else {
			$cedula = '';
		}
		if (isset($_POST['alergias']))
		{
			$alergias  = $_POST["alergias"];
		} else {
			$alergias = '';
		}
		if (isset($_POST['indicacion']))
		{
			$indicacion  = $_POST["indicacion"];
		} else {
			$indicacion = '';
		}
		if (isset($_POST['fechaG']))
		{
			$fechaG  = $_POST["fechaG"];
		} else {
			$fechaG = '';
		}
		if (isset($_POST['horaG']))
		{
			$horaG  = $_POST["horaG"];
		} else {
			$horaG = '';
		}
		if (isset($_POST['fechaInd']))
		{
			$fechaInd  = $_POST["fechaInd"];
		} else {
			$fechaInd = '';
		}
		if (isset($_POST['horaInd']))
		{
			$horaInd  = $_POST["horaInd"];
		} else {
			$horaInd = '';
		}

		$formularioIndicMed = "<table>
			<tr>
				<td><label style='color: beige'>Fecha de Captura(*) :</label></td>
				<td><input type='date' class='nombre' name='fechaG' id='fechaG' value='$fechaG'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Hora de Captura(*) :</label></td>
				<td><input type='time' class='nombre' name='horaG' id='horaG' value='$horaG'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Número de Expediente :</label></td>
				<td><input type='text' class='nombre' name='exp' id='exp'  style='width: 100px; height: 30px' autocomplete='off' value='$exp'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Folio :</label></td>
				<td><input type='text' class='nombre' name='folio' id='folio'  style='width: 100px; height: 30px' autocomplete='off' value='$folio'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Nombre del Paciente(*) :</label></td>
				<td><input type='text' class='nombre' name='nPaciente' id='nPaciente'  style='width: 500px; height: 30px' autocomplete='off' value='$nPaciente'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Fecha de Nacimiento(*) :</label></td>
				<td><input type='date' class='nombre' name='fNacimiento' id='fNacimiento' value='$fNacimiento'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Alergias :</label></td>
				<td>
				<input type='text' class='nombre' name='alergias' id='alergias' style='width: 800px; height: 30px' autocomplete='off' value='$alergias'>
				<!--td><textarea class='nombre' id='alergias' name='alergias' rows='3' cols='70'>$alergias</textarea-->
				</td>
			</tr>
			<tr>
				<td><label style='color: beige'>Médico Tratante(*) :</label></td>
				<td><input type='text' class='nombre' name='medTratante' id='medTratante' style='width: 500px; height: 30px' autocomplete='off' value='$medTratante'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Cedula :</label></td>
				<td><input type='text' class='nombre' name='cedula' id='cedula'  style='width: 100px; height: 30px' autocomplete='off' value='$cedula'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Diagnóstico(*) :</label></td>
				<td>
					<input type='text' class='nombre' name='diagnostico' id='diagnostico' style='width: 800px; height: 30px' autocomplete='off' value='$diagnostico'>
				<!--td><textarea class='nombre' id='diagnostico' name='diagnostico' rows='3' cols='70'>$diagnostico</textarea-->
				</td>
			</tr>
			</table>
			<hr>
				<h3>INDICACIÓNES</h3>
			
			<tr>
				<!--td><label style='color: beige'>Indicación(*) :</label></td>
				<td><textarea class='nombre' id='indicacion' name='indicacion' rows='3' cols='70'>$indicacion</textarea></td-->
				
				<td>
					<div class='form-group'>
						
						<label>FECHA : </label>
						<input type='date' name='fIndicacion' id='fIndicacion' class='nombre' autocomplete='off'>

						<label>HORA : </label>
						<input type='time' name='horaIndicacion' id='horaIndicacion' class='nombre' autocomplete='off'>
						<!--br>
						<label>INDICACIÓN : </label>
						<input type='text' name='indicacion' id='indicacion' class='nombre' style='width: 700px; height: 30px' autocomplete='off'-->
						<br>
						<br>
						<button id='adicionar' class='btn btn-success' type='button'>Agregar Indicación</button>
					</div>
				</td>
				<td>	
					<p>Indicaciones Agregadas:
					  <div id='adicionados' style='display:none;'></div>
					</p>
					<table id='mytable' class='table table-bordered table-hover'>
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Indicación</th>
							<th>Eliminar</th>
						</tr>
					  </thead>
					  <tbody id='ProSelected'>";
					  if($indicacion != NULL && $indicacion != ''){
						//var_dump($indicacion);
						//$indicac = json_decode($indicacion, true);
						 $arreglado = trim($indicacion, '[');
						 $arreglado1 = trim($arreglado, ']');
				
						 $indicac = explode("},",$arreglado1);
						  
						//echo 'Indic OTRO: '.$indicacion;
						//echo '<br>Indicacion : '.$indicac[1]['nameI'];
						
						//$longitud = count($indicac);
						//echo 'LONGITUD: '.$longitud;
						//var_dump(json_decode($fechaInd,true));
						  
						$fechaIndic = json_decode($fechaInd,true);
						//echo '<br>Fecha : '.$fechaIndic[1]['fechaI'];
						  
						//var_dump(json_decode($horaInd,true));
						$horaIndic = json_decode($horaInd,true);
						$longitud = count($horaIndic);
						/*echo '<br>HORA OTRO: '.$fechaInd;
						echo 'HORA: '.$horaIndic[1]['horaI'];*/

						for($i=0; $i<$longitud; $i++){
							$fi = $fechaIndic[$i+1]['fechaI'];
							$hi = $horaIndic[$i]['horaI'];
							//var_dump(strlen($indicac[0]));
							if(strlen($indicac[0]) <= 15){								
								$ii = substr($indicac[$i+1], 9, -2);
							} else {
								$ii = substr($indicac[$i], 10, -2);
							}
							
							/*if($indicac[0]=''){
								$ii = substr($indicac[$i], 9, -2);
							}else {
								$ii = substr($indicac[$i], 9, -2);
							}*/
							//$ii = $indicac[$i+1]["nameI"];
							//echo 'OTRO: '.$fechaIndic[$i]["fechaI"];							
							//var_dump($fi);
						$formularioIndicMed = $formularioIndicMed."<tr class='item'>
								<td>
								<input id='fIndic' name='fIndic' type='text' style='width:100px;' value='$fi' />
								</td>
								<td>
								<input id='hIndic' name='hIndic' type='text' style='width:120px;'' value='$hi' />
								</td>
								<td>
								<textarea id='nIndicacion' name='nIndicacion' row='4' cols='70'>$ii </textarea>
								</td>
								<td>
								<button type='button' name='remove' id='$i' class='btn btn-danger btn_remove'>Quitar</button>
								</td>
							</tr>";
						}
					  }
			$formularioIndicMed = $formularioIndicMed."</table></td>
			</td>
			</tr>
		<br>
		<input type='hidden' name='idIndicMed' id='idIndicMed' value='$idIndicMed' >
		<div>
		<input type='hidden' id='ListaPro' name='ListaPro' value='' >
		<input type='hidden' id='ListaPro2' name='ListaPro2' value='' >
		<input type='hidden' id='ListaPro3' name='ListaPro3' value='' >
		<input type='submit' value='Guardar' class='btn btn-success' onclick='creaArr();' name='boton' id='enviarIndicMed'>";
		echo "<input type='button' value='PDF' class='btn btn-danger' name='lvc' style='height: 50px; width: 80px'
	  	onClick=window.open(\"../pdf/creaPDF.php?idIndicMed=$idIndicMed&name=indm\").focus() />";

		$btBorrarIndicMed = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='BorrarIndicMed'>";
		$formulario = $formularioIndicMed;
		$var = true;
		$borrar=$btBorrarIndicMed;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	 
	  if ($("#hora").val() == "") { 
	 	$("#hora").focus().after('<span class="error"> Colocar una Hora </span>');
	 	return false;
	 }
	 if ($("#antece").val() == "") { 
	 	$("#antece").focus().after('<span class="error"> Colocar Antecedentes </span>');
	 	return false;
	 }
	 /*if ($("#tratam1").val() == "") { 
	 	$("#tratam1").focus().after('<span class="error"> Colocar Tratamiento (CM) </span>');
	 	return false;
	 }*/
	  if ($("#inter").val() == "") { 
	 	$("#inter").focus().after('<span class="error"> Colocar Interrogatorio </span>');
	 	return false;
	 }
	 if ($("#diagn").val() == "") { 
	 	$("#diagn").focus().after('<span class="error"> Colocar Diagnósticos </span>');
	 	return false;
	 }
	  if ($("#tratam2").val() == "") { 
	 	$("#tratam2").focus().after('<span class="error"> Colocar Tratamiento </span>');
	 	return false;
	 }
	 if ($("#horaFin").val() == "") { 
	 	$("#horaFin").focus().after('<span class="error"> Colocar una hora </span>');
	 	return false;
	 }
	/*Fin Validaciónes*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveNotaUrg.php',
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
					$("#Usuarios").load("consultaNotaUrg.php", function(){});
					alert("Se realizo la Operación Correctamente");
					//Recargamos la pagina para que se vean los cambios en la tabla
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
	 var Resp = confirm("Se eliminará la Nota de Urgencia de la hr: "+ $("#hora").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Nota de Urgencia !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaNotaUrg.php", function(){});
						alert("Se Elimino la Nota de Urgencia Correctamente");
						//Recargamos la pagina para que se vean los cambios en la tabla
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Nota de Urgencia !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
/*********************************************************************************************************************************/	
/*Evento Click Botón Enviar Para Notas Urg T*/
 $("#enviarNotaT").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	 var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	 
	 if ($("#hora").val() == "") { 
	 	$("#hora").focus().after('<span class="error"> Colocar una Hora </span>');
	 	return false;
	 }
	 
	 if ($("#fecha").val() == "" || !yearreg.test($("#fecha").val())) { 
	 	$("#fecha").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }
	 
	 if ($("#motivo").val() == "") { 
	 	$("#motivo").focus().after('<span class="error"> Colocar Motivo </span>');
	 	return false;
	 }
	 
	  if ($("#realizo").val() == "") {
	 	$("#realizo").focus().after('<span class="error"> Colocar Quien Realizo </span>');
	 	return false;
	 }
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveNotaUrgT.php',
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
					$("#Usuarios").load("consultaNotaUrgT.php", function(){});
					alert("Se realizo la Operación Correctamente");
					//Recargamos la pagina para que se vean los cambios en la tabla
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
 /*Fin Evento Click Botón Notas Urg T*/
	
/*Evento Click Botón Borrar Notas Urg T*/
 $("#BorrarT").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará la Nota de Urgencias Triage del: "+" "+$("#fecha").val()+" y hora "+$("#hora").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Nota Urgencia Triage !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaNotaUrgT.php", function(){});
						alert("Se Elimino la Nota Urgencia Triage Correctamente");
						//Recargamos la pagina para que se vean los cambios en la tabla
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Nota Urgencia Triage !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Notas Urg T*/
/*********************************************************************************************************************************/	
/*Evento Click Botón Enviar Para Notas Urg CH*/
 $("#enviarNotaCh").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 				
	 $(".error").fadeOut().remove();
	 
	 if ($("#hora").val() == "") { 
	 	$("#hora").focus().after('<span class="error"> Colocar una Hora </span>');
	 	return false;
	 }	 	 
	 if ($("#antece").val() == "") { 
	 	$("#antece").focus().after('<span class="error"> Colocar Antecedente </span>');
	 	return false;
	 }
	  if ($("#tratam").val() == "") {
	 	$("#tratam").focus().after('<span class="error"> Colocar Tratamiento </span>');
	 	return false;
	  }
	 
	 if ($("#inter").val() == "") { 
	 	$("#inter").focus().after('<span class="error"> Colocar Interrogatorio </span>');
	 	return false;
	 }
	 if ($("#fc").val() == "") { 
	 	$("#fc").focus().after('<span class="error"> Colocar FC </span>');
	 	return false;
	 }
	 if ($("#fr").val() == "") { 
	 	$("#fr").focus().after('<span class="error"> Colocar FR </span>');
	 	return false;
	 }
	 if ($("#ta").val() == "") { 
	 	$("#ta").focus().after('<span class="error"> Colocar TA </span>');
	 	return false;
	 }
	 if ($("#temp").val() == "") { 
	 	$("#temp").focus().after('<span class="error"> Colocar Temperatura </span>');
	 	return false;
	 }
	 if ($("#so").val() == "") { 
	 	$("#so").focus().after('<span class="error"> Colocar SO2 </span>');
	 	return false;
	 }
	 if ($("#respOcul").val() == "") { 
	 	$("#respOcul").focus().after('<span class="error"> Colocar Resp. Ocul. </span>');
	 	return false;
	 }
	 if ($("#respVerb").val() == "") { 
	 	$("#respVerb").focus().after('<span class="error"> Colocar Resp. Verb. </span>');
	 	return false;
	 }
	 if ($("#respMot").val() == "") { 
	 	$("#respMot").focus().after('<span class="error"> Colocar Resp. Mot. </span>');
	 	return false;
	 }
	 if ($("#habEx").val() == "") { 
	 	$("#habEx").focus().after('<span class="error"> Colocar Habitus Ext. </span>');
	 	return false;
	 }
	 if ($("#cabez").val() == "") { 
	 	$("#cabez").focus().after('<span class="error"> Colocar Cabez </span>');
	 	return false;
	 }
	 if ($("#torax").val() == "") { 
	 	$("#torax").focus().after('<span class="error"> Colocar Torax </span>');
	 	return false;
	 }
	 if ($("#abdom").val() == "") { 
	 	$("#abdom").focus().after('<span class="error"> Colocar Abdomen </span>');
	 	return false;
	 }
	 if ($("#extrm").val() == "") { 
	 	$("#extrm").focus().after('<span class="error"> Colocar Extremidades </span>');
	 	return false;
	 }
	 if ($("#diagn").val() == "") { 
	 	$("#diagn").focus().after('<span class="error"> Colocar Diagnosticos </span>');
	 	return false;
	 }
	 if ($("#cedula").val() == "") { 
	 	$("#cedula").focus().after('<span class="error"> Colocar Cedula </span>');
	 	return false;
	 }
	 
	 
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveNotaUrgCh.php',
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
					$("#Usuarios").load("consultaNotaUrgCh.php", function(){});
					alert("Se realizo la Operación Correctamente");
					//Recargamos la pagina para que se vean los cambios en la tabla
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
 /*Fin Evento Click Botón Notas Urg Ch*/
	
/*Evento Click Botón Borrar Notas Urg Ch*/
 $("#BorrarCh").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará la Nota de Urgencias choque del: "+" "+$("#fecha").val()+" y hora "+$("#hora").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Nota Urgencia Triage !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaNotaUrgT.php", function(){});
						alert("Se Elimino la Nota Urgencia Triage Correctamente");
						//Recargamos la pagina para que se vean los cambios en la tabla
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Nota Urgencia Triage !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Notas Urg Ch*/
/************************************************************************************************************************************/
	
/*Evento Click Botón Enviar Para Indicaciones Medicas*/
 $("#enviarIndicMed").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	// var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	/* if ($("#fechaV").val() == "" || !yearreg.test($("#fechaV").val())) { 
	 	$("#fechaV").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }*/
	 if ($("#fechaG").val() == "") {
	 	$("#fechaG").focus().after('<span class="error"> Colocar una Fecha </span>');
	 	return false;
	 }
	 if ($("#horaG").val() == "") {
	 	$("#horaG").focus().after('<span class="error"> Colocar una Hora </span>');
	 	return false;
	 }
	  if ($("#nPaciente").val() == "") {
	 	$("#nPaciente").focus().after('<span class="error"> Colocar una Nombre </span>');
	 	return false;
	 }
	 if ($("#fNacimiento").val() == "") {
	 	$("#fNacimiento").focus().after('<span class="error"> Colocar una Fecha </span>');
	 	return false;
	 }
	  if ($("#medTratante").val() == "") {
	 	$("#medTratante").focus().after('<span class="error"> Colocar un Médico </span>');
	 	return false;
	 }
	  if ($("#diagnostico").val() == "") {
	 	$("#diagnostico").focus().after('<span class="error"> Colocar un Diagnóstico </span>');
	 	return false;
	 }
	  /*if ($("#indicacion").val() == "") {
	 	$("#indicacion").focus().after('<span class="error"> Colocar Indicaciones </span>');
	 	return false;
	 }*/
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveIndicMed.php',
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
					$("#Usuarios").load("consultaIndicMed.php", function(){});
					alert("Se realizo la Operación Correctamente");
					//Recargamos la pagina para que se vean los cambios en la tabla
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
 /*Fin Evento Click Botón Enviar Vigilancia*/
	
/*Evento Click Botón Borrar Vigilancia*/
 $("#BorrarIndicMed").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará las Indicaciones del Paciente: " +" "+$("#nPaciente").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Incidencia !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1) {
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaIndicMed.php", function(){});
						alert("Se Eliminaron las Indicaciones Correctamente");
						//Recargamos la pagina para que se vean los cambios en la tabla
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se eliminaron las Indicaciones !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Vigilancia*/
 </script>
<script type="text/javascript" src="../js/funciones.js"></script>
<script type="text/javascript">
/**************************************Escript's para agregar Indicaciones Medicas****************************************************************/
		var c=0;//contador para asignar id al boton que borrara la fila
		
			//Funcion para acomodar la fecha de AAAA-MM-DD a DD/MM/AAAA
			function convertDateFormat(string) {
				var info = string.split('-').reverse().join('/');
        		return info;
			}
		    	
		 $(document).ready(function() {
			//obtenemos el valor de los input
			$('#adicionar').click(function() {
			  	//var indicacion = document.getElementById("indicacion").value;
			  	//indicacion = indicacion.trim();	
				var indicacion = "";
				var fIndicacion = document.getElementById("fIndicacion").value;
			  	fIndicacion = fIndicacion.trim();
				var fIndicacionB = convertDateFormat(fIndicacion);
				var horaIndicacion = document.getElementById("horaIndicacion").value;
			  	horaIndicacion = horaIndicacion.trim();
			  //var cantidad = document.getElementById("cantidad").value;
			  //var i = 1; //contador para asignar id al boton que borrara la fila
			  c++;
			  //var fila = '<tr>';
			  var fila = '<tr class="item"> <td><input id="fIndic' + c + '" name="fIndic[' + c + ']" type="text" style="width: 100px; height: 28px" value="'+fIndicacionB+'" /></td> ';
			  fila = fila + '<td> <input id="hIndic[' + c + ']" name="hIndic[' + c + ']" type="time" value="'+horaIndicacion+'" /></td>';
			  fila = fila + '<td><textarea id="nIndicacion' + c + '" name="nIndicacion[' + c + ']">'+indicacion+'</textarea></td> ';
			  //fila = fila + '<td><input id="nIndicacion' + c + '" name="nIndicacion[' + c + ']" type="text" value="'+indicacion+'" disabled /></td> ';
			  fila = fila + '<td><button type="button" name="remove" id="' + c + '" class="btn btn-danger btn_remove">Quitar</button></td> </tr>';
		  	  //'<tr id="row' + i + '"><td>indicacion + '</td><td>' + cantidad + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
			  $('#ProSelected').append(fila);
			  $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
			  var nFilas = $("#mytable tr").length;
			  $("#adicionados").append(nFilas - 1);
			  //le resto 1 para no contar la fila del header
			  //document.getElementById("cantidad").value = "";
			  document.getElementById("indicacion").value = "";
			  document.getElementById("indicacion").focus();
		  });
		  
		$(document).on('click', '.btn_remove', function() {
		  var button_id = $(this).attr("id");
		    //cuando da click obtenemos el id del boton
		    //$('#row' + button_id + '').remove(); //borra la fila
		    $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
            if ($('#ProSelected tr.item').length == 0)
                $('#ProSelected .no-item').slideDown(300);

		    //limpia el para que vuelva a contar las filas de la tabla
		    $("#adicionados").text("");
		    var nFilas = $("#mytable tr").length;
		    $("#adicionados").append(nFilas - 1);
		  });
		});
		
		function creaArr(){
			var ip = [];
			var ip2 = [];
			var ip3 = [];
			$('input[name^="fIndic"]').each(function() {
		   	 //alert($(this).val());
		   	 ip.push({ fechaI : $(this).val().trim() });
			});
			
			var ipt=JSON.stringify(ip);
			$('#ListaPro').val(encodeURIComponent(ipt));
        	//document.getElementById("valores").innerHTML = ipt;
        	
			$('input[name^="hIndic"]').each(function() {
		   	 //alert($(this).val());
		   	 ip2.push({ horaI : $(this).val() });
			});
			
			var ipt2=JSON.stringify(ip2);
			$('#ListaPro2').val(encodeURIComponent(ipt2));
        	//document.getElementById("valores").innerHTML = ipt;
			
			$('textarea').each(function() {
		   	 //alert($(this).val());
		   	 ip3.push({ nameI : $(this).val() });
			});
			
			var ipt3=JSON.stringify(ip3);
			$('#ListaPro3').val(encodeURIComponent(ipt3));
		}
	</script>