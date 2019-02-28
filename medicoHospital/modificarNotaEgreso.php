<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idNotaEgreso']))
	{
		$idNotaEgreso = $_POST["idNotaEgreso"];
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
		if (isset($_POST['diagnosticoIngreso']))
		{
			$diagnosticoIngreso  = $_POST["diagnosticoIngreso"];
		} else {
			$diagnosticoIngreso = '';
		}
		if (isset($_POST['diagnosticoEgreso']))
		{
			$diagnosticoEgreso = $_POST["diagnosticoEgreso"];
		} else {
			$diagnosticoEgreso = '';
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
		
		if (isset($_POST['motivoEgreso']))
		{
			$motivoEgreso = $_POST["motivoEgreso"];
		} else {
			$motivoEgreso = '';
		}
		if (isset($_POST['resumenEvolucion']))
		{
			$resumenEvolucion = $_POST["resumenEvolucion"];
		} else {
			$resumenEvolucion = '';
		}
		if (isset($_POST['manejoTratamiento']))
		{
			$manejoTratamiento = $_POST["manejoTratamiento"];
		} else {
			$manejoTratamiento = '';
		}
		if (isset($_POST['problemasClinicos']))
		{
			$problemasClinicos = $_POST["problemasClinicos"];
		} else {
			$problemasClinicos = '';
		}
		if (isset($_POST['recomendacionesVigilancia']))
		{
			$recomendacionesVigilancia = $_POST["recomendacionesVigilancia"];
		} else {
			$recomendacionesVigilancia = '';
		}
		if (isset($_POST['tabaquismo']))
		{
			$tabaquismo  = $_POST["tabaquismo"];
		} else {
			$tabaquismo = '';
		}
		if (isset($_POST['alcohol']))
		{
			$alcohol = $_POST["alcohol"];
		} else {
			$alcohol = '';
		}
		if (isset($_POST['otras']))
		{
			$otras = $_POST["otras"];
		} else {
			$otras = '';
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
		if (isset($_POST['diagnosticos']))
		{
			$diagnosticos  = $_POST["diagnosticos"];
		} else {
			$diagnosticos = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula = $_POST["cedula"];
		} else {
			$cedula = '';
		}
		if (isset($_POST['nombreMedicoTratante']))
		{
			$nombreMedicoTratante = $_POST["nombreMedicoTratante"];
		} else {
			$nombreMedicoTratante = '';
		}
		
		$tabacoCK = $tabaquismo=='1' ? 'checked':'';
		$alcoholCK = $alcohol=='1' ? 'checked':'';
		$otrasCK = $otras=='1' ? 'checked':'';
		
		$vidaB = $pronosticoVida=='BUENO' ? 'checked':'';
		$vidaM = $pronosticoVida=='MALO' ? 'checked':'';
		$vidaR = $pronosticoVida=='RESERVADO' ? 'checked':'';
		
		$funcionB = $pronosticoFuncion=='BUENO' ? 'checked':'';
		$funcionM = $pronosticoFuncion=='MALO' ? 'checked':'';
		$funcionR = $pronosticoFuncion=='RESERVADO' ? 'checked':'';
		
	$formularioNota = "<table>
		<tr>
			<td><label style='color: beige'>Fecha Egreso(*) :</label></td>
			<td><input type='date' class='nombre' name='fecha' id='fecha' value='$fechaFin' disabled></td>
		<tr>
		<tr>
			<td><label style='color: beige'>Hora Egreso(*) :</label></td>
			<td><input type='time' class='nombre' name='hora' id='hora' value='$horaFin'></td>
		</tr>
		
		<tr>
			<td><label style='color: beige'>MOTIVO DE EGRESO :</label></td>
			<td> <select id='motivoEgreso' name='motivoEgreso' class='nombre'>
					<option value='$motivoEgreso'>$motivoEgreso</option>
					<option value='Mejoría'>Mejoría</option>
					<option value='Alta Voluntaria'>Alta Voluntaria</option>
					<option value='Traslado'>Traslado</option>
					<option value='Defunción'>Defunción</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>DIAGNÓSTICO DE INGRESO(*) :</label></td>
			<td><textarea class='nombre' id='diagnosticoIngreso' name='diagnosticoIngreso' rows='3' cols='70'>$diagnosticoIngreso</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>DIAGNÓSTICO DE EGRESO(*) :</label></td>
			<td><textarea class='nombre' id='diagnosticoEgreso' name='diagnosticoEgreso' rows='3' cols='70'>$diagnosticoEgreso</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>RESUMEN DE LA EVOLUCIÓN Y EDO. ACTUAL(*) :</label></td>
			<td><textarea class='nombre' id='resumenEvolucion' name='resumenEvolucion' rows='3' cols='70'>$resumenEvolucion</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>MANEJO Y TRATAMIENTO HOSPITALARIO :</label></td>
			<td><textarea class='nombre' id='manejoTratamiento' name='manejoTratamiento' rows='3' cols='70'>$manejoTratamiento</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PROBLEMAS CLÍNICOS PENDIENTES :</label></td>
			<td><textarea class='nombre' id='problemasClinicos' name='problemasClinicos' rows='3' cols='70'>$problemasClinicos</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>RECOMENDACIONES PARA LA VIGILANCIA AMBULATORIA(*) :</label></td>
			<td><textarea class='nombre' id='recomendacionesVigilancia' name='recomendacionesVigilancia' rows='3' cols='70'>$recomendacionesVigilancia</textarea></td>
		</tr>
		<tr>
			<td>
				<label style='color: beige'> ATENCIÓN DE FACTORES DE RIESGO :</label>
			</td>
			<td>
				<input type='checkbox' class='nombre' id='tabaquismo' name='tabaquismo' style='width: 35px; height: 35px' value='1' $tabacoCK> TABAQUISMO
				<input type='checkbox' class='nombre' id='alcohol' name='alcohol' style='width: 35px; height: 35px' value='1' $alcoholCK> ALCOHOL
				<input type='checkbox' class='nombre' id='otras' name='otras' style='width: 35px; height: 35px' value='1' $otrasCK> OTRAS ADICCIONES
			</td>
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
			<td><label style='color: beige'>DIAGNÓSTICOS (*) :</label></td>
			<td><textarea class='nombre' id='diagnosticos' name='diagnosticos' rows='3' cols='70'>$diagnosticos</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CEDULA :</label></td>
			<td><input type='text' class='nombre' name='cedula' id='cedula' style='width: 100px; height: 30px' value='$cedula' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>NOMBRE DEL MÉDICO TRATANTE :</label></td>
			<td><input type='text' class='nombre' name='nombreMedicoTratante' id='nombreMedicoTratante' style='width: 300px; height: 30px' value='$nombreMedicoTratante' autocomplete='off'></td>
		</tr>
		<tr>
		<td><label style='color: yellow'>(*Solo en caso de no contar con cedula)</label></td>
		</tr>
		
	</table>
	<br>
	<input type='hidden' name='idNotaEgreso' id='idNotaEgreso' value='$idNotaEgreso' >
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
	 if ($("#diagnosticos").val() == "") { 
	 	$("#diagnosticos").focus().after('<span class="error"> Colocar Diagnósticos </span>');
	 	return false;
	 }
	  if ($("#diagnosticoIngreso").val() == "") { 
	 	$("#diagnosticoIngreso").focus().after('<span class="error"> Colocar Diagnostico Ingreso </span>');
	 	return false;
	 }
	 if ($("#diagnosticoEgreso").val() == "") { 
	 	$("#diagnosticoEgreso").focus().after('<span class="error"> Colocar Diagnostico Egreso </span>');
	 	return false;
	 }
	  if ($("#resumenEvolucion").val() == "") { 
	 	$("#resumenEvolucion").focus().after('<span class="error"> Colocar Resumen de Evolucion </span>');
	 	return false;
	 }
	 if ($("#manejoTratamiento").val() == "") { 
	 	$("#manejoTratamiento").focus().after('<span class="error"> Colocar Manejo y Tratamiento </span>');
	 	return false;
	 }
	 
	/*Fin Validaciónes*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveNotaEgreso.php',
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
					$("#Usuarios").load("consultaNotaEgreso.php", function(){});
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
	 var Resp = confirm("Se eliminará la Nota de Ingreso de la fecha: "+ $("#fecha").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino la Nota de Ingreso !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaPreoperatoria.php", function(){});
						alert("Se Elimino la Nota de Ingreso Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Nota de Ingreso !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Nota de Urg*/
	
	