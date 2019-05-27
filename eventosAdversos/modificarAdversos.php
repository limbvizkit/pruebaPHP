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
		if (isset($_POST['paciente']))
		{
			$paciente  = $_POST["paciente"];
		} else {
			$paciente = '';
		}
		if (isset($_POST['servicio']))
		{
			$servicio  = $_POST["servicio"];
		} else {
			$servicio = '';
		}
		if (isset($_POST['evento']))
		{
			$evento  = $_POST["evento"];
		} else {
			$evento = '';
		}
		if (isset($_POST['turno']))
		{
			$turno  = $_POST["turno"];
		} else {
			$turno = '';
		}
		if (isset($_POST['servicioTxt']))
		{
			$servicioTxt = $_POST["servicioTxt"];
		} else {
			$servicioTxt = '';
		}
		if (isset($_POST['tipoEvento']))
		{
			$tipoEvento  = $_POST["tipoEvento"];
		} else {
			$tipoEvento = '';
		}
		if (isset($_POST['habitacion']))
		{
			$habitacion = $_POST["habitacion"];
		} else {
			$habitacion = '';
		}
		if (isset($_POST['nacimientoPaciente']))
		{
			$nacimientoPaciente  = $_POST["nacimientoPaciente"];
		} else {
			$nacimientoPaciente = '';
		}
		if (isset($_POST['fechaOcurrio']))
		{
			$fechaOcurrio  = $_POST["fechaOcurrio"];
		} else {
			$fechaOcurrio = '';
		}
		
		$centiCK = $tipoEvento=='Centinela' ? 'checked':'';
		$adverCK = $tipoEvento=='Adverso' ? 'checked':'';
		$cuasiCK = $tipoEvento=='Cuasifalla' ? 'checked':'';
		$errMedCK = $tipoEvento=='Error De Medicación' ? 'checked':'';
		$ramCK = $tipoEvento=='RAM' ? 'checked':'';
		//$otroCK = $tipoEvento=='OTRO' ? 'checked':'';
		
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
					<option value='N'>NOCTURNO A</option>
					<option value='NB'>NOCTURNO B</option>
					<option value='JA'>JORNADA ACUMULADA</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>NOMBRE PACIENTE :</label></td>
			<td><input type='text' class='nombre' name='paciente' id='paciente' style='width: 400px; height: 30px' value='$paciente' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>SERVICIO(*) :</label></td>
			<td><input type='text' class='nombre' name='servicio' id='servicio' style='width: 350px; height: 30px' value='$servicio' autocomplete='off'>
		</td>
		</tr>
		<tr>
			<td><label style='color: beige'>OTRO SERVICIO :</label></td>
			<td><input type='text' class='nombre' name='servicioTxt' id='servicioTxt' style='width: 350px; height: 30px' value='$servicioTxt' autocomplete='off'></td>
		</tr>
		<tr>
			<td>
				<label style='color: beige'> TIPO DE EVENTO :</label>
			</td>
			<td>
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Centinela' $centiCK> Evento Centinela
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Adverso' $adverCK> Evento Adverso
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Cuasifalla' $cuasiCK> Cuasifalla
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='Error De Medicación' $errMedCK> Error De Medicación
				<input type='radio' class='nombre' id='tipoEvento' name='tipoEvento' style='width: 35px; height: 35px' value='RAM' $ramCK> RAM (Reacción Adversa a Medicamentos)
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>NÚMERO DE HABITACIÓN DONDE SE PRESENTO EL INCIDENTE</label></td>
			<td><input type='text' class='nombre' name='habitacion' id='habitacion' style='width: 350px; height: 30px' value='$habitacion' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FECHA DE NACIMIENTO DEL PACIENTE INVOLUCRADO EN EL INCIDENTE</label></td>
			<td><input type='text' class='nombre' name='nacimientoPaciente' id='nacimientoPaciente' style='width: 350px; height: 30px' value='$nacimientoPaciente' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FECHA EN LA QUE OCURRIÓ EL INCIDENTE</label></td>
			<td><input type='date' class='nombre' name='fechaOcurrio' id='fechaOcurrio' value='$fechaOcurrio'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CUÉNTENOS LO QUE HA PASADO</label></td>
			<td><textarea class='nombre' id='evento' name='evento' rows='3' cols='70'>$evento</textarea></td>
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
	 if ($("#servicio").val() == "") {
	 	$("#servicio").focus().after('<span class="error"> Colocar un Servicio </span>');
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
	 var Resp = confirm("Se eliminará el evento adverso de la fecha: "+ $("#fecha").val() +" Del Paciente: "+ $("#paciente").val());
	 
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
	