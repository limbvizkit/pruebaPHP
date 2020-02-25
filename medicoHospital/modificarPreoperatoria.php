<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idNotaPreopeH']))
	{
		$idNotaPreopeH  = $_POST["idNotaPreopeH"];

		if (isset($_POST['fechaFin']))
		{
			$fechaFin  = $_POST["fechaFin"];
		} else {
			$fechaFin = '';
		}
		if (isset($_POST['diagn']))
		{
			$diagn  = $_POST["diagn"];
		} else {
			$diagn = '';
		}
		if (isset($_POST['planQui']))
		{
			$planQui  = $_POST["planQui"];
		} else {
			$planQui = '';
		}
		if (isset($_POST['tipoInterQui']))
		{
			$tipoInterQui  = $_POST["tipoInterQui"];
		} else {
			$tipoInterQui = '';
		}
		if (isset($_POST['riesgoQui']))
		{
			$riesgoQui  = $_POST["riesgoQui"];
		} else {
			$riesgoQui = '';
		}
		if (isset($_POST['cuidadosTerap']))
		{
			$cuidadosTerap  = $_POST["cuidadosTerap"];
		} else {
			$cuidadosTerap = '';
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
		if (isset($_POST['nomMedico']))
		{
			$nomMedico  = $_POST["nomMedico"];
		} else {
			$nomMedico = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula  = $_POST["cedula"];
		} else {
			$cedula = '';
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
		if (isset($_POST['expediente']))
		{
			$expediente  = $_POST["expediente"];
		} else {
			$expediente = '';
		}
		if (isset($_POST['folio']))
		{
			$folio  = $_POST["folio"];
		} else {
			$folio = '';
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
			<td><input type='date' class='nombre' name='fechaFin' id='fechaFin' value='$fechaFin'></td>
		<tr>
		<tr>
			<td><label style='color: beige'>SERVICIO :</label></td>
			<td> <select id='servicio' name='servicio' class='nombre'>
					<option value='$servicio'>Seleccione</option>
					<option value='Hospitalización'>HOSPITALIZACIÓN</option>
					<option value='Urgencias'>URGENCIAS</option>
					<option value='Corta Estancia'>CORTA ESTANCIA</option>
					<option value='Terapia Intensiva'>TERAPIA INTENSIVA</option>
				</select>
			</td>
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
			<td><label style='color: beige'>Diagnósticos(*) :</label></td>
			<td><textarea class='nombre' id='diagn' name='diagn' rows='3' cols='70'>$diagn</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Plan Quirúrgico(*) :</label></td>
			<td><textarea class='nombre' id='planQui' name='planQui' rows='3' cols='70'>$planQui</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Tipo de Intervención Quirúrgica :</label></td>
			<td> <select id='tipoInterQui' name='tipoInterQui' class='nombre'>
					<option value='$tipoInterQui'>Seleccione</option>
					<option value='Electiva'>ELECTIVA</option>
					<option value='Urgente'>URGENTE</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Riesgo Quirúrgico :</label></td>
			<td><textarea class='nombre' id='riesgoQui' name='riesgoQui' rows='3' cols='70'>$riesgoQui</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Cuidados y Plan Terapéutico Preoperatorio(*) :</label></td>
			<td><textarea class='nombre' id='cuidadosTerap' name='cuidadosTerap' rows='3' cols='70'>$cuidadosTerap</textarea></td>
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
		<tr>
			<td><strong>*Solo llenar el Nombre en caso de no conocer la cedula del médico</strong></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Nombre del Médico Tratante :</label></td>
			<td><input type='text' class='nombre' id='nomMedico' name='nomMedico' style='width: 300px; height: 30px' value='$nomMedico' autocomplete='off'></td>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idNotaPreopeH' id='idNotaPreopeH' value='$idNotaPreopeH' >
	<div><input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNota'>";
		
		$docPDF = "<input type='button' value='PDF' class='btn btn-danger' name='lvc' style='height: 50px; width: 80px'
	  	onClick=window.open(\"../pdf/creaPDF.php?exp=$expediente&folio=$folio&id=$idNotaPreopeH&name=preoperatoria\").focus() />";
	  
		echo $docPDF;

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
	  
	 if ($("#fechaFin").val() == "") { 
	 	$("#fechaFin").focus().after('<span class="error"> Colocar Fecha </span>');
	 	return false;
	 }
	 if ($("#diagn").val() == "") { 
	 	$("#diagn").focus().after('<span class="error"> Colocar Diagnósticos </span>');
	 	return false;
	 }
	  if ($("#planQui").val() == "") { 
	 	$("#planQui").focus().after('<span class="error"> Colocar Plan Quirúrgico </span>');
	 	return false;
	 }
	 if ($("#cuidadosTerap").val() == "") { 
	 	$("#cuidadosTerap").focus().after('<span class="error"> Colocar Plan Terapéutico </span>');
	 	return false;
	 }
	 
	/*Fin Validaciónes*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveNotaPreope.php',
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
					$("#Usuarios").load("consultaPreoperatoria.php", function(){});
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
	 var Resp = confirm("Se eliminará la Nota Preoperatoria de la fecha: "+ $("#fechaFin").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Nota Preoperatoria !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaPreoperatoria.php", function(){});
						alert("Se Elimino la Nota Preoperatoria Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Nota Preoperatoria !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
	
	