<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idNotaEvoh']))
	{
		$idNotaEvoh  = $_POST["idNotaEvoh"];

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
		if (isset($_POST['evolucion']))
		{
			$evolucion  = $_POST["evolucion"];
		} else {
			$evolucion = '';
		}
		if (isset($_POST['estudios']))
		{
			$estudios  = $_POST["estudios"];
		} else {
			$estudios = '';
		}
		if (isset($_POST['tratamientoF']))
		{
			$tratamientoF  = $_POST["tratamientoF"];
		} else {
			$tratamientoF = '';
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
		if (isset($_POST['diagn']))
		{
			$diagn  = $_POST["diagn"];
		} else {
			$diagn = '';
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
			<td><label style='color: beige'>Hora(*) :</label></td>
			<td><input type='time' class='nombre' name='horaFin' id='horaFin' value='$horaFin'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Servicio(*) :</label></td>
			<td><input type='text' class='nombre' name='servicio' id='servicio' style='width: 400px; height: 30px' value='$servicio' autocomplete='off'></td>
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
			<td><label style='color: beige'>Evolución(*) :</label></td>
			<td><textarea class='nombre' id='evolucion' name='evolucion' rows='3' cols='70'>$evolucion</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Tratamiento(*) :</label></td>
			<td><textarea class='nombre' id='tratamientoF' name='tratamientoF' rows='3' cols='70'>$tratamientoF</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>FC :</label></td>
			<td><input type='text' class='nombre' name='fc' id='fc' style='width: 50px; height: 30px' autocomplete='off' value='$fc'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>FR :</label></td>
			<td><input type='text' class='nombre' name='fr' id='fr' style='width: 50px; height: 30px' autocomplete='off' value='$fr'>min</td>
		</tr>
		<tr>
			<td><label style='color: beige'>TA :</label></td>
			<td><input type='text' class='nombre' name='ta' id='ta' style='width: 70px; height: 30px' autocomplete='off' value='$ta'>mmHg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Temperatura :</label></td>
			<td><input type='text' class='nombre' name='temp' id='temp' style='width: 50px; height: 30px' autocomplete='off' value='$temp'>°C</td>
		</tr>
		<tr>
			<td><label style='color: beige'>SO :</label></td>
			<td><input type='text' class='nombre' name='so' id='so' style='width: 50px; height: 30px' autocomplete='off' value='$so'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Glucosa :</label></td>
			<td><input type='text' class='nombre' name='glucosa' id='so' style='width: 50px; height: 30px' autocomplete='off' value='$glucosa'>mg/dl</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Peso :</label></td>
			<td><input type='text' class='nombre' name='peso' id='peso' style='width: 50px; height: 30px' autocomplete='off' value='$peso'>kg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Talla :</label></td>
			<td><input type='text' class='nombre' name='talla' id='talla' style='width: 50px; height: 30px' autocomplete='off' value='$talla'>Mts</td>
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
			<td><label style='color: beige'>Estudios :</label></td>
			<td><textarea class='nombre' id='estudios' name='estudios' rows='3' cols='70'>$estudios</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>Diagnósticos(*) :</label></td>
			<td><textarea class='nombre' id='diagn' name='diagn' rows='3' cols='70'>$diagn</textarea></td>
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
			<td><label style='color: beige'>Cedula(*) :</label></td>
			<td><input type='text' class='nombre' name='cedula' id='cedula' style='width: 100px; height: 30px' value='$cedula' autocomplete='off'></td>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idNotaEvoh' id='idNotaEvoh' value='$idNotaEvoh' >
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
	 if ($("#servicio").val() == "") { 
	 	$("#servicio").focus().after('<span class="error"> Colocar Servicio </span>');
	 	return false;
	 }
	  if ($("#evolucion").val() == "") { 
	 	$("#inter").focus().after('<span class="error"> Colocar Evolución </span>');
	 	return false;
	 }
	 
	 if ($("#diagn").val() == "") { 
	 	$("#diagn").focus().after('<span class="error"> Colocar Diagnósticos </span>');
	 	return false;
	 }
	  if ($("#tratamientoF").val() == "") { 
	 	$("#tratamientoF").focus().after('<span class="error"> Colocar Tratamiento </span>');
	 	return false;
	 }
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
            url: 'saveNotaEvo.php',
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
					$("#Usuarios").load("consultaEvolucion.php", function(){});
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
	 var Resp = confirm("Se eliminará la Nota de Evolución de la hr: "+ $("#horaFin").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Nota de Evolución !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaEvolucion.php", function(){});
						alert("Se Elimino la Nota de Evolución Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Nota de Evolución !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
	
	