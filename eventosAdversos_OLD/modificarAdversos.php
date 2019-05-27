<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idEvAdverso']))
	{
		$idEvAdverso=$_POST['idEvAdverso'];
		$expediente = NULL;
		$folio = NULL;
		
		if (isset($_POST['exp'])) {
			if( $_POST['exp'] != NULL && $_POST['exp'] != '' ){
				$expediente = $_POST['exp'];
			}
		}
		
		if (isset($_POST['folio'])) {
			if( $_POST['folio'] != NULL && $_POST['folio'] != '' ){
				$folio = $_POST['folio'];
			}
		}
		
		if (isset($_POST['fecha']))
		{
			$fecha   = $_POST["fecha"];
		} else {
			$fecha  = '';
		}
		if (isset($_POST['fechaB']))
		{
			$fechaB   = $_POST["fechaB"];
		} else {
			$fechaB  = '';
		}
		if (isset($_POST['reporta']))
		{
			$reporta  = $_POST["reporta"];
		} else {
			$reporta = '';
		}
		if (isset($_POST['servicio']))
		{
			$servicio  = $_POST["servicio"];
		} else {
			$servicio = '';
		}
		if (isset($_POST['tipoEvento']))
		{
			$tipoEvento  = $_POST["tipoEvento"];
		} else {
			$tipoEvento = '';
		}
		if (isset($_POST['turno']))
		{
			$turno  = $_POST["turno"];
		} else {
			$turno = '';
		}
		if (isset($_POST['diag']))
		{
			$diag = $_POST["diag"];
		} else {
			$diag = '';
		}
		if (isset($_POST['relacionado']))
		{
			$relacionado  = $_POST["relacionado"];
		} else {
			$relacionado = '';
		}
		if (isset($_POST['alcanzoPac']))
		{
			$alcanzoPac  = $_POST["alcanzoPac"];
		} else {
			$alcanzoPac = '';
		}
		if (isset($_POST['danioPac']))
		{
			$danioPac  = $_POST["danioPac"];
		} else {
			$danioPac = '';
		}
		if (isset($_POST['evento']))
		{
			$evento  = $_POST["evento"];
		} else {
			$evento = '';
		}
		if (isset($_POST['como']))
		{
			$como  = $_POST["como"];
		} else {
			$como = '';
		}
		if (isset($_POST['porQue']))
		{
			$porQue  = $_POST["porQue"];
		} else {
			$porQue = '';
		}
		if (isset($_POST['medicamento']))
		{
			$medicamento = $_POST["medicamento"];
		} else {
			$medicamento = '';
		}
		if (isset($_POST['generico']))
		{
			$generico = $_POST["generico"];
		} else {
			$generico = '';
		}
		if (isset($_POST['dosis']))
		{
			$dosis  = $_POST["dosis"];
		} else {
			$dosis = '';
		}
		if (isset($_POST['presentacion']))
		{
			$presentacion  = $_POST["presentacion"];
		} else {
			$presentacion = '';
		}
		if (isset($_POST['viaAdmin']))
		{
			$viaAdmin  = $_POST["viaAdmin"];
		} else {
			$viaAdmin = '';
		}
		if (isset($_POST['intervalo']))
		{
			$intervalo  = $_POST["intervalo"];
		} else {
			$intervalo = '';
		}
		if (isset($_POST['aim']))
		{
			$aim  = $_POST["aim"];
		} else {
			$aim = '';
		}		
		if (isset($_POST['cidt']))
		{
			$cidt  = $_POST["cidt"];
		} else {
			$cidt = '';
		}
		if (isset($_POST['ciam']))
		{
			$ciam  = $_POST["ciam"];
		} else {
			$ciam = '';
		}
		if (isset($_POST['dim']))
		{
			$dim = $_POST["dim"];
		} else {
			$dim = '';
		}
		if (isset($_POST['eii']))
		{
			$eii = $_POST["eii"];
		} else {
			$eii = '';
		}
		if (isset($_POST['fimar']))
		{
			$fimar = $_POST["fimar"];
		} else {
			$fimar = '';
		}
		if (isset($_POST['mcmc']))
		{
			$mcmc  = $_POST["mcmc"];
		} else {
			$mcmc = '';
		}
		if (isset($_POST['licim']))
		{
			$licim = $_POST["licim"];
		} else {
			$licim = '';
		}
		if (isset($_POST['fma']))
		{
			$fma = $_POST["fma"];
		} else {
			$fma = '';
		}
		if (isset($_POST['manp']))
		{
			$manp = $_POST["manp"];
		} else {
			$manp = '';
		}
		if (isset($_POST['fdvpam']))
		{
			$fdvpam = $_POST["fdvpam"];
		} else {
			$fdvpam = '';
		}
		if (isset($_POST['frmec']))
		{
			$frmec = $_POST["frmec"];
		} else {
			$frmec = '';
		}
		if (isset($_POST['ficp']))
		{
			$ficp = $_POST["ficp"];
		} else {
			$ficp = '';
		}
		if (isset($_POST['ampi']))
		{
			$ampi = $_POST["ampi"];
		} else {
			$ampi = '';
		}
		if (isset($_POST['amnp']))
		{
			$amnp = $_POST["amnp"];
		} else {
			$amnp = '';
		}
		if (isset($_POST['omisionMed']))
		{
			$omisionMed = $_POST["omisionMed"];
		} else {
			$omisionMed = '';
		}
		if (isset($_POST['ami']))
		{
			$ami = $_POST["ami"];
		} else {
			$ami = '';
		}
		if (isset($_POST['presInc']))
		{
			$presInc = $_POST["presInc"];
		} else {
			$presInc = '';
		}
		if (isset($_POST['transInc']))
		{
			$transInc = $_POST["transInc"];
		} else {
			$transInc = '';
		}
		if (isset($_POST['prepInc']))
		{
			$prepInc = $_POST["prepInc"];
		} else {
			$prepInc = '';
		}
		if (isset($_POST['dispoInc']))
		{
			$dispoInc = $_POST["dispoInc"];
		} else {
			$dispoInc = '';
		}
		if (isset($_POST['tai']))
		{
			$tai = $_POST["tai"];
		} else {
			$tai = '';
		}
		if (isset($_POST['vai']))
		{
			$vai = $_POST["vai"];
		} else {
			$vai = '';
		}
		if (isset($_POST['adpi']))
		{
			$adpi = $_POST["adpi"];
		} else {
			$adpi = '';
		}
		if (isset($_POST['dti']))
		{
			$dti = $_POST["dti"];
		} else {
			$dti = '';
		}
		if (isset($_POST['hai']))
		{
			$hai = $_POST["hai"];
		} else {
			$hai = '';
		}
		if (isset($_POST['ifi']))
		{
			$ifi = $_POST["ifi"];
		} else {
			$ifi = '';
		}
		if (isset($_POST['vii']))
		{
			$vii = $_POST["vii"];
		} else {
			$vii = '';
		}
		if (isset($_POST['ot']))
		{
			$ot = $_POST["ot"];
		} else {
			$ot = '';
		}
		if (isset($_POST['otros']))
		{
			$otros = $_POST["otros"];
		} else {
			$otros = '';
		}
		
		$centiCK = $tipoEvento=='Centinela' ? 'checked':'';
		$adverCK = $tipoEvento=='Adverso' ? 'checked':'';
		$cuasiCK = $tipoEvento=='Cuasifalla' ? 'checked':'';
		$errMedCK = $tipoEvento=='Error De Medicación' ? 'checked':'';
		$ramCK = $tipoEvento=='RAM' ? 'checked':'';
		$otroCK = $tipoEvento=='OTRO' ? 'checked':'';
		
		$aimCK = $aim=='1' ? 'checked':'';
		$fdvpamCK = $fdvpam=='1' ? 'checked':'';
		$dispoIncCK = $dispoInc=='1' ? 'checked':'';
		$cidtCK = $cidt=='1' ? 'checked':'';
		$frmecCK = $frmec=='1' ? 'checked':'';
		$taiCK = $tai=='1' ? 'checked':'';
		$ciamCK = $ciam=='1' ? 'checked':'';
		$ficpCK = $ficp=='1' ? 'checked':'';
		$vaiCK = $vai=='1' ? 'checked':'';
		$dimCK = $dim=='1' ? 'checked':'';
		$ampiCK = $ampi=='1' ? 'checked':'';
		$adpiCK = $adpi=='1' ? 'checked':'';
		$eiiCK = $eii=='1' ? 'checked':'';
		$amnpCK = $amnp=='1' ? 'checked':'';
		$dtiCK = $dti=='1' ? 'checked':'';
		$fimarCK = $fimar=='1' ? 'checked':'';
		$omisionMedCK = $omisionMed=='1' ? 'checked':'';
		$haiCK = $hai=='1' ? 'checked':'';
		$mcmcCK = $mcmc=='1' ? 'checked':'';
		$amiCK = $ami=='1' ? 'checked':'';
		$ifiCK = $ifi=='1' ? 'checked':'';
		$licimCK = $licim=='1' ? 'checked':'';
		$presIncCK = $presInc=='1' ? 'checked':'';
		$viiCK = $vii=='1' ? 'checked':''; 
		$fmaCK = $fma=='1' ? 'checked':'';
		$transIncCK = $transInc=='1' ? 'checked':'';
		$otCK = $ot=='1' ? 'checked':'';
		$manpCK = $manp=='1' ? 'checked':'';
		$prepIncCK = $prepInc=='1' ? 'checked':'';
		
		$formularioAdverso = "<table>
		<tr>
			<td><label style='color: beige'>FECHA(*) :</label></td>
			<td><input type='date' class='nombre' name='fecha' id='fecha' value='$fechaB'></td>
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
			<td><label style='color: beige'>REPORTA(*) :</label></td>
			<td><input type='text' class='nombre' name='reporta' id='reporta' style='width: 400px; height: 30px' value='$reporta' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>SERVICIO(*) :</label></td>
			<td><input type='text' class='nombre' name='servicio' id='servicio' style='width: 350px; height: 30px' value='$servicio' autocomplete='off'>
		</td>
		</tr>
		<tr>
			<td><label style='color: beige'>DIAGNÓSTICO :</label></td>
			<td><textarea class='nombre' id='diag' name='diag' rows='3' cols='70'>$diag</textarea></td>
		</tr>
		<tr>
			<td>
				<label style='color: beige'> TIPO DE EVENTO :</label>
			</td>
			<td>
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Centinela' $centiCK> Centinela
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Adverso' $adverCK> Adverso
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Cuasifalla' $cuasiCK> Cuasifalla
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Error De Medicación' $errMedCK> Error De Medicación
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='RAM' $ramCK> RAM
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='OTRO' $otroCK> OTRO
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>¿El evento adverso está relacionado a medicamentos? </label></td>
			<td> <select id='relacionado' name='relacionado' class='nombre'>
					<option value=$relacionado>$relacionado</option>
					<option value='SI'>SI</option>
					<option value='NO'>NO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>¿Alcanzó el error al paciente?</label></td>
			<td> <select id='alcanzoPac' name='alcanzoPac' class='nombre'>
					<option value=$alcanzoPac>$alcanzoPac</option>
					<option value='SI'>SI</option>
					<option value='NO'>NO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>¿Causó daño al paciente?</label></td>
			<td> <select id='danioPac' name='danioPac' class='nombre'>
					<option value=$danioPac>$danioPac</option>
					<option value='SI'>SI</option>
					<option value='NO'>NO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>¿Cuál fue el evento?</label></td>
			<td><textarea class='nombre' id='evento' name='evento' rows='3' cols='70'>$evento</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>¿Cómo pasó?</label></td>
			<td><textarea class='nombre' id='como' name='como' rows='3' cols='70'>$como</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>¿Por qué pasó?</label></td>
			<td><textarea class='nombre' id='porQue' name='porQue' rows='3' cols='70'>$porQue</textarea></td>
		</tr>
		<tr>
			<td>
				<label style='color: beige'>-------------------------- ERROR DE MEDICACIÓN ---------------</label>
			</td>
			<td>
				<label style='color: GREEN'>(LLENAR ÚNICAMENTE SI SE TRATA DE UN ERROR DE MEDICACIÓN)</label>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>NOMBRE DEL MÉDICAMENTO :</label></td>
			<td><input type='text' class='nombre' name='medicamento' id='medicamento' style='width: 350px; height: 30px' value='$medicamento' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>NOMBRE GENÉRICO :</label></td>
			<td><input type='text' class='nombre' name='generico' id='generico' style='width: 350px; height: 30px' value='$generico' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PRESENTACIÓN :</label></td>
			<td><input type='text' class='nombre' name='presentacion' id='presentacion' style='width: 450px; height: 30px' value='$presentacion' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>DOSIS :</label></td>
			<td><input type='text' class='nombre' name='dosis' id='dosis' style='width: 550px; height: 30px' value='$dosis' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>VÍA DE ADMINISTRACIÓN :</label></td>
			<td><input type='text' class='nombre' name='viaAdmin' id='viaAdmin' style='width: 500px; height: 30px' value='$viaAdmin' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>INTERVALO :</label></td>
			<td><input type='text' class='nombre' name='intervalo' id='intervalo' style='width: 350px; height: 30px' value='$intervalo' autocomplete='off'></td>
		</tr>
		<tr>
			<table>
				<tr>
					<td><input type='checkbox' class='nombre' id='aim' name='aim' style='width: 45px; height: 35px' value='1' $aimCK></td>
					<td><label style='color: beige'>Adquisición incorrecta del medicamento</label></td>
					<td><input type='checkbox' class='nombre' id='fdvpam' name='fdvpam' style='width: 45px; height: 35px' value='1' $fdvpamCK></td>
					<td><label style='color: darkslategray'>Falta de doble verificación de preparación y administración de los medicamentos</label></td>
					<td><input type='checkbox' class='nombre' id='dispoInc' name='dispoInc' style='width: 45px; height: 35px' value='1' $dispoIncCK></td>
					<td><label style='color: darkslategray'>Dispositivo Incorrecto</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='cidt' name='cidt' style='width: 45px; height: 35px' value='1' $cidtCK></td>
					<td><label style='color: beige'>Condiciones inadecuadas durante el transporte</label></td>
					<td><input type='checkbox' class='nombre' id='frmec' name='frmec' style='width: 45px; height: 35px' value='1' $frmecCK></td>
					<td><label style='color: darkslategray'>Falta de registro de los medicamentos en expediente clínico</label></td>
					<td><input type='checkbox' class='nombre' id='tai' name='tai' style='width: 45px; height: 35px' value='1' $taiCK></td>
					<td><label style='color: darkslategray'>Técnica de administración incorrecta</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='ciam' name='ciam' style='width: 45px; height: 35px' value='1' $ciamCK></td>
					<td><label style='color: beige'>Condiciones inadecuadas en el almacenamiento del medicamento</label></td>
					<td><input type='checkbox' class='nombre' id='ficp' name='ficp' style='width: 45px; height: 35px' value='1' $ficpCK></td>
					<td><label style='color: darkslategray'>Falta de identificación correcta del paciente</label></td>
					<td><input type='checkbox' class='nombre' id='vai' name='vai' style='width: 45px; height: 35px' value='1' $vaiCK></td>
					<td><label style='color: darkslategray'>Vía de administración incorrecta</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='dim' name='dim' style='width: 45px; height: 35px' value='1' $dimCK></td>
					<td><label style='color: beige'>Dispensación incorrecta de medicamento</label></td>
					<td><input type='checkbox' class='nombre' id='ampi' name='ampi' style='width: 45px; height: 35px' value='1' $ampiCK></td>
					<td><label style='color: darkslategray'>Se administra el medicamento a un paciente incorrecto</label></td>
					<td><input type='checkbox' class='nombre' id='adpi' name='adpi' style='width: 45px; height: 35px' value='1' $adpiCK></td>
					<td><label style='color: darkslategray'>Se administra una dosis o potencia incorrecta</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='eii' name='eii' style='width: 45px; height: 35px' value='1' $eiiCK></td>
					<td><label style='color: beige'>Etiquetado incompleto o incorrecto</label></td>
					<td><input type='checkbox' class='nombre' id='amnp' name='amnp' style='width: 45px; height: 35px' value='1' $amnpCK></td>
					<td><label style='color: darkslategray'>Se administra un medicamento no prescrito</label></td>
					<td><input type='checkbox' class='nombre' id='dti' name='dti' style='width: 45px; height: 35px' value='1' $dtiCK></td>
					<td><label style='color: darkslategray'>Duración del tratamiento incorrecto</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='fimar' name='fimar' style='width: 45px; height: 35px' value='1' $fimarCK></td>
					<td><label style='color: beige'>Falta de identificación de medicamentos de alto riesgo</label></td>
					<td><input type='checkbox' class='nombre' id='omisionMed' name='omisionMed' style='width: 45px; height: 35px' value='1' $omisionMedCK>
					</td>
					<td><label style='color: darkslategray'>Omisión de un medicamento</label></td>
					<td><input type='checkbox' class='nombre' id='hai' name='hai' style='width: 45px; height: 35px' value='1' $haiCK></td>
					<td><label style='color: darkslategray'>Hora de administración incorrecta</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='mcmc' name='mcmc' style='width: 45px; height: 35px' value='1' $mcmcCK></td>
					<td><label style='color: beige'>Medicamento caducado/malas condiciones</label></td>
					<td><input type='checkbox' class='nombre' id='ami' name='ami' style='width: 45px; height: 35px' value='1' $amiCK></td>
					<td><label style='color: darkslategray'>Se administra un medicamento incorrecto</label></td>
					<td><input type='checkbox' class='nombre' id='ifi' name='ifi' style='width: 45px; height: 35px' value='1' $ifiCK></td>
					<td><label style='color: darkslategray'>Intervalo de frecuencia incorrecto</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='licim' name='licim' style='width: 45px; height: 35px' value='1' $licimCK></td>
					<td><label style='color: beige'>Letra ilegible y confusa en la indicación medica</label></td>
					<td><input type='checkbox' class='nombre' id='presInc' name='presInc' style='width: 45px; height: 35px' value='1' $presIncCK></td>
					<td><label style='color: darkslategray'>Prescripción incompleta</label></td>
					<td><input type='checkbox' class='nombre' id='vii' name='vii' style='width: 45px; height: 35px' value='1' $viiCK></td>
					<td><label style='color: darkslategray'>Velocidad de infusión incorrecta</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='fma' name='fma' style='width: 45px; height: 35px' value='1' $fmaCK></td>
					<td><label style='color: beige'>Falta de notificación de alergias</label></td>
					<td><input type='checkbox' class='nombre' id='transInc' name='transInc' style='width: 45px; height: 35px' value='1' $transIncCK></td>
					<td><label style='color: darkslategray'>Transcripción incompleta</label></td>
					<td><input type='checkbox' class='nombre' id='ot' name='ot' style='width: 45px; height: 35px' value='1' $otCK></td>
					<td><label style='color: darkslategray'>Otros especificar</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='manp' name='manp' style='width: 45px; height: 35px' value='1' $manpCK></td>
					<td><label style='color: beige'>Medicamento con aspecto y/o nombre parecido</label></td>
					<td><input type='checkbox' class='nombre' id='prepInc' name='prepInc' style='width: 45px; height: 35px' value='1' $prepIncCK></td>
					<td><label style='color: darkslategray'>Preparación incorrecta</label></td>
					<td></td>
					<td><textarea class='nombre' id='otros' name='otros' rows='3' cols='70'>$otros</textarea></td>
				</tr>
			</table>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idEvAdverso' id='idEvAdverso' value='$idEvAdverso' >
	<div><input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNota'>";
	if ($expediente == NULL) {
		echo "<input type='button' value='PDF' class='btn btn-danger' name='lvc' style='height: 50px; width: 80px'
	  	onClick=window.open(\"../pdf/creaPDF.php?idEvAdverso=$idEvAdverso&name=adverso\").focus() />";
	} else {
		echo "<input type='button' value='PDF' class='btn btn-danger' name='lvc' style='height: 50px; width: 80px'
	  	onClick=window.open(\"../pdf/creaPDF.php?exp=$expediente&folio=$folio&name=adverso\").focus() />";
	}
		$btBorrarNota = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='Borrar'>";
		$formulario = $formularioAdverso;
		$var = true;
		$borrar = $btBorrarNota;
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
	 
	 if ($("#fecha").val() == "") {
	 	$("#fecha").focus().after('<span class="error"> Colocar Fecha </span>');
	 	return false;
	 }
	 if ($("#reporta").val() == "") {
	 	$("#reporta").focus().after('<span class="error"> Colocar quien Reporta </span>');
	 	return false;
	 }
	 if ($("#servicio").val() == "") {
	 	$("#servicio").focus().after('<span class="error"> Colocar una Servicio </span>');
	 	return false;
	 }
	 /* if ($("#diag").val() == "") {
	 	$("#diag").focus().after('<span class="error"> Colocar Diagnóstico </span>');
	 	return false;
	 }*/
	 
	/*Fin Validaciónes*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveAdverso.php',
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
					$("#Usuarios").load("consultaAdversos.php", function(){});
					alert("Se realizo la Operación Correctamente");
					//Refrescamos la pagina para ver los cambios
					self.parent.location.reload();
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
	 var Resp = confirm("Se eliminará el evento adverso de la fecha: "+ $("#fecha").val() +" Reportado por: "+ $("#reporta").val());
	 
	 if(Resp){
			 /*Escogió opción ACEPTAR*/
			 //Determinanos los datos del formulario y los serializamos
			var datos = $("#formu").serialize();
			// Enviamos el formulario usando AJAX
			$.ajax({
				type: 'POST',
				url: 'delAdverso.php',
				error: function(data){
					//Si sucedió algo, se notifica
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error Eliminando Registro");
						alert("!!!ERROR DATA: NO Se elimino el Evento Adverso !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaAdversos.php", function(){});
						alert("Se Elimino el Evento Adverso Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					} else {
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino el Evento Adverso !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
</script>
	