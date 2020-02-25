<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idImagenologia']))
	{
		$idImagenologia=$_POST['idImagenologia'];
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
		if (isset($_POST['diag']))
		{
			$diag = $_POST["diag"];
		} else {
			$diag = '';
		}
		if (isset($_POST['servicio']))
		{
			$servicio  = $_POST["servicio"];
		} else {
			$servicio = '';
		}
		if (isset($_POST['turno']))
		{
			$turno  = $_POST["turno"];
		} else {
			$turno = '';
		}
		if (isset($_POST['datosClinicos']))
		{
			$datosClinicos  = $_POST["datosClinicos"];
		} else {
			$datosClinicos = '';
		}
		if (isset($_POST['tiroides']))
		{
			$tiroides  = $_POST["tiroides"];
		} else {
			$tiroides = '';
		}
		if (isset($_POST['mama']))
		{
			$mama  = $_POST["mama"];
		} else {
			$mama = '';
		}		
		if (isset($_POST['higadoVesiculayPancreas']))
		{
			$higadoVesiculayPancreas  = $_POST["higadoVesiculayPancreas"];
		} else {
			$higadoVesiculayPancreas = '';
		}
		if (isset($_POST['renal']))
		{
			$renal = $_POST["renal"];
		} else {
			$renal = '';
		}
		if (isset($_POST['abdominal']))
		{
			$abdominal = $_POST["abdominal"];
		} else {
			$abdominal = '';
		}
		if (isset($_POST['uteroOvariosyVejiga']))
		{
			$uteroOvariosyVejiga = $_POST["uteroOvariosyVejiga"];
		} else {
			$uteroOvariosyVejiga = '';
		}
		if (isset($_POST['pelvico']))
		{
			$pelvico = $_POST["pelvico"];
		} else {
			$pelvico = '';
		}
		if (isset($_POST['obstetrico']))
		{
			$obstetrico = $_POST["obstetrico"];
		} else {
			$obstetrico = '';
		}
		if (isset($_POST['vejigayProstata']))
		{
			$vejigayProstata = $_POST["vejigayProstata"];
		} else {
			$vejigayProstata = '';
		}
		if (isset($_POST['tejidosBlandos']))
		{
			$tejidosBlandos = $_POST["tejidosBlandos"];
		} else {
			$tejidosBlandos = '';
		}
		if (isset($_POST['transrectal']))
		{
			$transrectal = $_POST["transrectal"];
		} else {
			$transrectal = '';
		}
		if (isset($_POST['transvaginal']))
		{
			$transvaginal = $_POST["transvaginal"];
		} else {
			$transvaginal = '';
		}
		if (isset($_POST['carotideoBilateral']))
		{
			$carotideoBilateral = $_POST["carotideoBilateral"];
		} else {
			$carotideoBilateral = '';
		}
		if (isset($_POST['carotideoBiTxt']))
		{
			$carotideoBiTxt = $_POST["carotideoBiTxt"];
		} else {
			$carotideoBiTxt = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula = $_POST["cedula"];
		} else {
			$cedula = '';
		}
		if (isset($_POST['fechaGuarda']))
		{
			$fechaGuarda = $_POST["fechaGuarda"];
		} else {
			$fechaGuarda = '';
		}

		
		$tiroidesCK = substr($tiroides,-1)!='' ? 'checked':'';
		$mamaCK = substr($mama,-1)!='' ? 'checked':'';
		$higadoVesiculayPancreasCK = substr($higadoVesiculayPancreas,-1)!='' ? 'checked':'';
		$renalCK = substr($renal,-1)!='' ? 'checked':'';
		$abdominalCK = substr($abdominal,-1)!='' ? 'checked':'';
		$uteroOvariosyVejigaCK = substr($uteroOvariosyVejiga,-1) !='' ? 'checked':'';
		$pelvicoCK = substr($pelvico,-1)!='' ? 'checked':'';
		$obstetricoCK = substr($obstetrico,-1)!='' ? 'checked':'';
		$vejigayProstataCK = substr($vejigayProstata,-1)!='' ? 'checked':'';
		$tejidosBlandosCK = substr($tejidosBlandos,-1)!='' ? 'checked':'';
		$transrectalCK = substr($transrectal,-1)!='' ? 'checked':'';
		$transvaginalCK = substr($transvaginal,-1)!='' ? 'checked':'';
		$carotideoBilateralCK = substr($carotideoBilateral,-1)!='' ? 'checked':'';
		
		$formularioImagenologia = "<table>
		<tr>
			<td><label style='color: beige'>FECHA(*) :</label></td>
			<td><input type='input' class='nombre' name='fecha' id='fecha' value='$fecha' disabled></td>
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
			<td><label style='color: beige'>SERVICIO(*) :</label></td>
			<td><input type='text' class='nombre' name='servicio' id='servicio' style='width: 350px; height: 30px' value='$servicio' autocomplete='off'>
		</td>
		</tr>
		<tr>
			<td><label style='color: beige'>DIAGNÓSTICO :</label></td>
			<td><textarea class='nombre' id='diag' name='diag' rows='3' cols='70'>$diag</textarea></td>
		</tr>
		
		<tr>
			<td><label style='color: beige'>DATOS CLÍNICOS</label></td>
			<td><textarea class='nombre' id='evento' name='evento' rows='3' cols='70'>$datosClinicos</textarea></td>
		</tr>
		<tr>
			<table>
				<tr>
					<td><input type='checkbox' class='nombre' id='tiroides' name='tiroides' style='width: 45px; height: 35px' value='1' $tiroidesCK></td>
					<td><label style='color: beige'>Tiroides</label></td>
					<td><input type='checkbox' class='nombre' id='mama' name='mama' style='width: 45px; height: 35px' value='1' $mamaCK></td>
					<td><label style='color: darkslategray'>Mama</label></td>
					<td><input type='checkbox' class='nombre' id='higadoVesiculayPancreas' name='Hígado Vesícula y Páncreas' style='width: 45px; height: 35px' value='1' $higadoVesiculayPancreasCK></td>
					<td><label style='color: darkslategray'>Hígado, Vesícula y Páncreas</label></td>
					<td><input type='checkbox' class='nombre' id='renal' name='renal' style='width: 45px; height: 35px' value='1' $renalCK></td>
					<td><label style='color: darkslategray'>Renal</label></td>
				</tr>
				<tr>
					
					<td><input type='checkbox' class='nombre' id='abdominal' name='abdominal' style='width: 45px; height: 35px' value='1' $abdominalCK></td>
					<td><label style='color: beige'>abdominal</label></td>
					<td><input type='checkbox' class='nombre' id='uteroOvariosyVejiga' name='uteroOvariosyVejiga' style='width: 45px; height: 35px' value='1' $uteroOvariosyVejigaCK></td>
					<td><label style='color: darkslategray'>Útero Ovarios y Vejiga</label></td>
					<td><input type='checkbox' class='nombre' id='pelvico' name='pelvico' style='width: 45px; height: 35px' value='1' $pelvicoCK></td>
					<td><label style='color: darkslategray'>Pélvico</label></td>
					<td><input type='checkbox' class='nombre' id='obstetrico' name='obstetrico' style='width: 45px; height: 35px' value='1' $obstetricoCK></td>
					<td><label style='color: darkslategray'>Obstétrico</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='vejigayProstata' name='vejigayProstata' style='width: 45px; height: 35px' value='1' $vejigayProstataCK></td>
					<td><label style='color: beige'>Vejiga y Próstata</label></td>
					<td><input type='checkbox' class='nombre' id='tejidosBlandos' name='tejidosBlandos' style='width: 45px; height: 35px' value='1' $tejidosBlandosCK></td>
					<td><label style='color: darkslategray'>Tejidos Blandos</label></td>
					<td><input type='checkbox' class='nombre' id='transrectal' name='transrectal' style='width: 45px; height: 35px' value='1' $transrectalCK></td>
					<td><label style='color: darkslategray'>Transrectal</label></td>
					<td><input type='checkbox' class='nombre' id='transvaginal' name='transvaginal' style='width: 45px; height: 35px' value='1' $transvaginalCK></td>
					<td><label style='color: darkslategray'>Transvaginal</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' class='nombre' id='carotideoBilateral' name='carotideoBilateral' style='width: 45px; height: 35px' value='1' $carotideoBilateralCK></td>
					<td><label style='color: beige'>Carotideo Bilateral</label>
						<input type='text' name='carotideoBiTxt' value = '$carotideoBiTxt' >
					</td>
				</tr>
			</table>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idImagenologia' id='idImagenologia' value='$idImagenologia' >
	<div><input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNota'>";
	if ($expediente == NULL) {
		echo "<input type='button' value='PDF' class='btn btn-danger' name='lvc' style='height: 50px; width: 80px'
	  	onClick=window.open(\"../pdf/creaPDF.php?idImagenologia=$idImagenologia&name=imagenologia\").focus() />";
	} else {
		echo "<input type='button' value='PDF SOLICITUD' class='btn btn-danger' name='lvc' style='height: 50px; width: 180px'
	  	onClick=window.open(\"../pdf/creaPDF.php?idImagenologia=$idImagenologia&exp=$expediente&folio=$folio&name=imagenologia\").focus() />   ";
		echo "<input type='button' value='INTERPRETACIONES' class='btn btn-info' name='lvc' style='height: 50px; width: 180px'
	  	onClick=window.open(\"../imagenologia/listaImg.php?exp=$expediente&folio=$folio&rol=medico\").focus() />   ";
	}
		$btBorrarNota = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='Borrar'>";
		$formulario = $formularioImagenologia;
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
	 var Resp = confirm("Se eliminará la solicitud de Imagenología de la fecha: "+ $("#fecha").val() +" Solicitado desde: "+ $("#servicio").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la solicitud de Imagenología !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaAdversos.php", function(){});
						alert("Se Elimino la solicitud a Imagenología Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					} else {
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la solicitud a Imagenología !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
</script>
	