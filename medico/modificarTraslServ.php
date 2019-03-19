<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idNotaTraslServ']))
	{
		$idNotaTraslServ = $_POST["idNotaTraslServ"];

		if (isset($_POST['fechaFin']))
		{
			$fechaFin  = $_POST["fechaFin"];
		} else {
			$fechaFin = '';
		}
		if (isset($_POST['horaFin']))
		{
			$horaFin  = $_POST["horaFin"];
		} else {
			$horaFin = '';
		}
		if (isset($_POST['motivoTransferencia']))
		{
			$motivoTransferencia  = $_POST["motivoTransferencia"];
		} else {
			$motivoTransferencia = '';
		}
		if (isset($_POST['servicioActual']))
		{
			$servicioActual  = $_POST["servicioActual"];
		} else {
			$servicioActual = '';
		}
		if (isset($_POST['servicioTraslada']))
		{
			$servicioTraslada  = $_POST["servicioTraslada"];
		} else {
			$servicioTraslada = '';
		}
		if (isset($_POST['turno']))
		{
			$turno  = $_POST["turno"];
		} else {
			$turno = '';
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
		if (isset($_POST['interrogatorio']))
		{
			$interrogatorio  = $_POST["interrogatorio"];
		} else {
			$interrogatorio = '';
		}
		if (isset($_POST['expFisica']))
		{
			$expFisica  = $_POST["expFisica"];
		} else {
			$expFisica = '';
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
		if (isset($_POST['estudiosGabyLab']))
		{
			$estudiosGabyLab  = $_POST["estudiosGabyLab"];
		} else {
			$estudiosGabyLab = '';
		}
		if (isset($_POST['terapeuticayProcedimientos']))
		{
			$terapeuticayProcedimientos = $_POST["terapeuticayProcedimientos"];
		} else {
			$terapeuticayProcedimientos = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula  = $_POST["cedula"];
		} else {
			$cedula = '';
		}
	
	$formularioNota = "<table>
		<tr>
			<td><label style='color: beige'>Fecha(*) :</label></td>
			<td><input type='date' class='nombre' name='fechaFin' id='fechaFin' value='$fechaFin'></td>
		<tr>
		<tr>
			<td><label style='color: beige'>Hora(*) :</label></td>
			<td><input type='time' class='nombre' name='horaFin' id='horaFin' value='$horaFin'></td>
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
			<td><label style='color: beige'>Motivo Transferencia(*) :</label></td>
			<td><textarea class='nombre' id='motivoTransferencia' name='motivoTransferencia' rows='3' cols='70'>$motivoTransferencia</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Servicio Actual(*) :</label></td>
			<td><textarea class='nombre' id='servicioActual' name='servicioActual' rows='3' cols='70'>$servicioActual</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Servicio al que se Traslada(*) :</label></td>
			<td><textarea class='nombre' id='servicioTraslada' name='servicioTraslada' rows='3' cols='70'>$servicioTraslada</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FC :</label></td>
			<td><input type='text' class='nombre' name='fc' id='fc' style='width: 50px; height: 30px' value='$fc'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>FR :</label></td>
			<td><input type='text' class='nombre' name='fr' id='fr' style='width: 50px; height: 30px' value='$fr'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>TA :</label></td>
			<td><input type='text' class='nombre' name='ta' id='ta' style='width: 70px; height: 30px' value='$ta'>mmHg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Temperatura :</label></td>
			<td><input type='text' class='nombre' name='temp' id='temp' style='width: 50px; height: 30px' value='$temp'>°C</td>
		</tr>				
		<tr>
			<td><label style='color: beige'>Peso :</label></td>
			<td><input type='text' class='nombre' name='peso' id='peso' style='width: 50px; height: 30px' value='$peso'>kg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Talla :</label></td>
			<td><input type='text' class='nombre' name='talla' id='talla' style='width: 50px; height: 30px' value='$talla'>Mts</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Resumen de Padecimiento Actual :</label></td>
			<td><textarea class='nombre' id='interrogatorio' name='interrogatorio' rows='3' cols='70'>$interrogatorio</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>EXPLORACIÓN FÍSICA :</label></td>
			<td><textarea class='nombre' id='expFisica' name='expFisica' rows='3' cols='70'>$expFisica</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Estudios de Gabinete y Lab :</label></td>
			<td><textarea class='nombre' id='estudiosGabyLab' name='estudiosGabyLab' rows='3' cols='70'>$estudiosGabyLab</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Terapeutica empleada y/o Procedimientos Realizados :</label></td>
			<td><textarea class='nombre' id='terapeuticayProcedimientos' name='terapeuticayProcedimientos' rows='3' cols='70'>$terapeuticayProcedimientos</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Cedula(*) :</label></td>
			<td><input type='text' class='nombre' name='cedula' id='cedula' style='width: 100px; height: 30px' value='$cedula'></td>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idNotaTraslServ' id='idNotaTraslServ' value='$idNotaTraslServ' >
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
	 
	  if ($("#horaFin").val() == "") { 
	 	$("#horaFin").focus().after('<span class="error"> Colocar una Hora </span>');
	 	return false;
	 }
	 if ($("#fechaFin").val() == "") { 
	 	$("#fechaFin").focus().after('<span class="error"> Colocar Fecha </span>');
	 	return false;
	 }
	 if ($("#servicioActual").val() == "") { 
	 	$("#servicioActual").focus().after('<span class="error"> Colocar servicio Actual </span>');
	 	return false;
	 }
	  if ($("#servicioTraslada").val() == "") { 
	 	$("#servicioTraslada").focus().after('<span class="error"> Colocar servicio Traslada </span>');
	 	return false;
	 }
	 /*if ($("#diagn").val() == "") { 
	 	$("#diagn").focus().after('<span class="error"> Colocar Diagnósticos </span>');
	 	return false;
	 }
	  if ($("#tratamientoF").val() == "") { 
	 	$("#tratamientoF").focus().after('<span class="error"> Colocar Tratamiento </span>');
	 	return false;
	 }*/
	 if ($("#cedula").val() == "") { 
	 	$("#cedula").focus().after('<span class="error"> Colocar cedula </span>');
	 	return false;
	 }
	/*Fin Validaciónes*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveNotaTraslServ.php',
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
					$("#Usuarios").load("consultaTraslServ.php", function(){});
					alert("Se realizo la Operación Correctamente");
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
	 var Resp = confirm("Se eliminará la Nota de Traslado de Servicio de la hr: "+ $("#horaFin").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Nota de Traslado de Servicio !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaTraslServ.php", function(){});
						alert("Se Elimino la Nota de Traslado de Serv. Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Nota de Traslado de Serv. !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
	
	