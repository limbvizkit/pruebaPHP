<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idNotaRefTraslh']))
	{
		$idNotaRefTraslh = $_POST["idNotaRefTraslh"];

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
		if (isset($_POST['turno']))
		{
			$turno  = $_POST["turno"];
		} else {
			$turno = '';
		}
		if (isset($_POST['tipoTraslado']))
		{
			$tipoTraslado  = $_POST["tipoTraslado"];
		} else {
			$tipoTraslado = '';
		}
		if (isset($_POST['receptor']))
		{
			$receptor  = $_POST["receptor"];
		} else {
			$receptor = '';
		}
		if (isset($_POST['otroReceptor']))
		{
			$otroReceptor  = $_POST["otroReceptor"];
		} else {
			$otroReceptor = '';
		}
		if (isset($_POST['servicio']))
		{
			$servicio  = $_POST["servicio"];
		} else {
			$servicio = '';
		}
		if (isset($_POST['ambulanciaTecno']))
		{
			$ambulanciaTecno  = $_POST["ambulanciaTecno"];
		} else {
			$ambulanciaTecno = '';
		}
		if (isset($_POST['tipoPaciente']))
		{
			$tipoPaciente  = $_POST["tipoPaciente"];
		} else {
			$tipoPaciente = '';
		}
		if (isset($_POST['oxigeno']))
		{
			$oxigeno  = $_POST["oxigeno"];
		} else {
			$oxigeno = '';
		}
		if (isset($_POST['desfibrilador']))
		{
			$desfibrilador  = $_POST["desfibrilador"];
		} else {
			$desfibrilador = '';
		}
		if (isset($_POST['ventilador']))
		{
			$ventilador = $_POST["ventilador"];
		} else {
			$ventilador = '';
		}
		if (isset($_POST['incubadora']))
		{
			$incubadora = $_POST["incubadora"];
		} else {
			$incubadora = '';
		}
		if (isset($_POST['ninguno']))
		{
			$ninguno = $_POST["ninguno"];
		} else {
			$ninguno = '';
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
		if (isset($_POST['antecedentesPer']))
		{
			$antecedentesPer  = $_POST["antecedentesPer"];
		} else {
			$antecedentesPer = '';
		}
		if (isset($_POST['padecimientoAct']))
		{
			$padecimientoAct  = $_POST["padecimientoAct"];
		} else {
			$padecimientoAct = '';
		}
		if (isset($_POST['expFisica']))
		{
			$expFisica  = $_POST["expFisica"];
		} else {
			$expFisica = '';
		}
		if (isset($_POST['motivoEnvio']))
		{
			$motivoEnvio = $_POST["motivoEnvio"];
		} else {
			$motivoEnvio = '';
		}
		if (isset($_POST['impresionDiag']))
		{
			$impresionDiag = $_POST["impresionDiag"];
		} else {
			$impresionDiag = '';
		}
		if (isset($_POST['terapeuticaEmpl']))
		{
			$terapeuticaEmpl = $_POST["terapeuticaEmpl"];
		} else {
			$terapeuticaEmpl = '';
		}
		if (isset($_POST['cedulaMedEntrega']))
		{
			$cedulaMedEntrega  = $_POST["cedulaMedEntrega"];
		} else {
			$cedulaMedEntrega = '';
		}
		if (isset($_POST['fechaExt']))
		{
			$fechaExt = $_POST["fechaExt"];
		} else {
			$fechaExt = '';
		}
		if (isset($_POST['horaExt']))
		{
			$horaExt = $_POST["horaExt"];
		} else {
			$horaExt = '';
		}
		if (isset($_POST['estable']))
		{
			$estable = $_POST["estable"];
		} else {
			$estable = '';
		}
		if (isset($_POST['turnoExt']))
		{
			$turnoExt = $_POST["turnoExt"];
		} else {
			$turnoExt = '';
		}
		
		$ambuT = $ambulanciaTecno == '1' ? 'SI':'NO';
		$pacEst = $estable == '1' ? 'SI':'NO';
		
		$oxiCK = $oxigeno=='1' ? 'checked':'';
		$desfiCK = $desfibrilador=='1' ? 'checked':'';
		$ventiCK = $ventilador=='1' ? 'checked':'';
		$incubaCK = $incubadora=='1' ? 'checked':'';
		$ningunoCK = $ninguno=='1' ? 'checked':'';
		
	$formularioNota = "<table>
		<tr>
			<td><label style='color: beige'>FECHA(*) :</label></td>
			<td><input type='date' class='nombre' name='fechaFin' id='fechaFin' value='$fechaFin'></td>
		<tr>
		<tr>
			<td><label style='color: beige'>HORA(*) :</label></td>
			<td><input type='time' class='nombre' name='horaFin' id='horaFin' value='$horaFin'></td>
		</tr>		
		<tr>
			<td><label style='color: beige'>TURNO(*) :</label></td>
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
			<td><input type='text' class='nombre' name='servicio' id='servicio' style='width: 150px; height: 30px' value='$servicio'></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TIPO DE TRASLADO :</label></td>
			<td> <select id='tipoTraslado' name='tipoTraslado' class='nombre'>
					<option value='$tipoTraslado'>$tipoTraslado</option>
					<option value='TRASLADO DEFINITIVO'>TRASLADO DEFINITIVO</option>
					<option value='TRASLADO TRANSITORIO'>TRASLADO TRANSITORIO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>REQUIERE AMBULANCIA ALTA TECNOLOGÍA :</label></td>
			<td> <select id='ambulanciaTecno' name='ambulanciaTecno' class='nombre'>
					<option value=$ambuT>$ambuT</option>
					<option value='1'>SI</option>
					<option value='0'>NO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>TIPO DE PACIENTE :</label></td>
			<td> <select id='tipoPaciente' name='tipoPaciente' class='nombre'>
					<option value='$tipoPaciente'>$tipoPaciente</option>
					<option value='CRITICO'>CRITICO</option>
					<option value='NO CRITICO'>NO CRITICO</option>
				</select>
			</td>
		</tr>
		<tr>
		<td><label style='color: beige'>-----ADITAMENTOS-----</label></td>
		</tr>
		<tr>
			<td><label style='color: beige'>OXIGENO :</label></td>
			<td><input type='checkbox' class='nombre' id='oxigeno' name='oxigeno' style='width: 45px; height: 35px' value='1' $oxiCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>DESFIBRILADOR :</label></td>
			<td><input type='checkbox' class='nombre' id='desfibrilador' name='desfibrilador' style='width: 45px; height: 35px' value='1' $desfiCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>VENTILADOR :</label></td>
			<td><input type='checkbox' class='nombre' id='ventilador' name='ventilador' style='width: 45px; height: 35px' value='1' $ventiCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>INCUBADORA :</label></td>
			<td><input type='checkbox' class='nombre' id='incubadora' name='incubadora' style='width: 45px; height: 35px' value='1' $incubaCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>NINGUNO :</label></td>
			<td><input type='checkbox' class='nombre' id='ninguno' name='ninguno' style='width: 45px; height: 35px' value='1' $ningunoCK></td>
		</tr>
		<tr>
			<td><label style='color: beige'>ESTABLECIMIENTO RECEPTOR :</label></td>
			<td> <select id='receptor' name='receptor' class='nombre'>
					<option value='$receptor'>$receptor</option>
					<option value='IMSS'>IMSS</option>
					<option value='ISSSTE'>ISSSTE</option>
					<option value='HOSPITAL G. PARRES'>HOSPITAL G. PARRES</option>
					<option value='HOSPITAL SECRETARIA DE SALUD'>HOSPITAL SECRETARIA DE SALUD</option>
					<option value='HOSPITAL MORELOS'>HOSPITAL MORELOS</option>
					<option value='INSTITUTO MEXICANO DE TRANSPLANTES'>INSTITUTO MEXICANO DE TRANSPLANTES</option>
					<option value='HOSPITAL SAN DIEGO'>HOSPITAL SAN DIEGO</option>
					<option value='MEDICA SUR'>MEDICA SUR</option>
					<option value='HOSPITAL ANGELES'>HOSPITAL ANGELES</option>
					<option value='CARDICA'>CARDICA</option>
					<option value='IMAGEN MEDICA'>IMAGEN MEDICA</option>
					<option value='LABORATORIOS CHOPO'>LABORATORIOS CHOPO</option>
					<option value='LABORATORIOS POLAB'>LABORATORIOS POLAB</option>
					<option value='OTROS'>OTROS</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>OTRO ESTABLECIMIENTO :</label></td>
			<td><input type='text' class='nombre' name='otroReceptor' id='otroReceptor' style='width: 450px; height: 30px' value='$otroReceptor'></td>
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
			<td><label style='color: beige'>TEMPERATURA :</label></td>
			<td><input type='text' class='nombre' name='temp' id='temp' style='width: 50px; height: 30px' value='$temp'>°C</td>
		</tr>				
		<tr>
			<td><label style='color: beige'>PESO :</label></td>
			<td><input type='text' class='nombre' name='peso' id='peso' style='width: 50px; height: 30px' value='$peso'>kg</td>
		</tr>
		<tr>
			<td><label style='color: beige'>TALLA :</label></td>
			<td><input type='text' class='nombre' name='talla' id='talla' style='width: 50px; height: 30px' value='$talla'>Mts</td>
		</tr>
		<tr>
			<td><label style='color: beige'>ANTECEDENTES PERSONALES :</label></td>
			<td><textarea class='nombre' id='antecedentesPer' name='antecedentesPer' rows='3' cols='70'>$antecedentesPer</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>PADECIMIENTO ACTUAL :</label></td>
			<td><textarea class='nombre' id='padecimientoAct' name='padecimientoAct' rows='3' cols='70'>$padecimientoAct</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>EXPLORACIÓN FÍSICA :</label></td>
			<td><textarea class='nombre' id='expFisica' name='expFisica' rows='3' cols='70'>$expFisica</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>IMPRESIÓN DIAGNOSTICA :</label></td>
			<td><textarea class='nombre' id='impresionDiag' name='impresionDiag' rows='3' cols='70'>$impresionDiag</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>TERAPEUTICA EMPLEADA :</label></td>
			<td><textarea class='nombre' id='terapeuticaEmpl' name='terapeuticaEmpl' rows='3' cols='70'>$terapeuticaEmpl</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>MOTIVO DE ENVIO :</label></td>
			<td><textarea class='nombre' id='motivoEnvio' name='motivoEnvio' rows='3' cols='70'>$motivoEnvio</textarea></td>
		</tr>
		<tr>
			<td><label style='color: beige'>CEDULA MÉDICO QUE ENTREGA AL PACIENTE(*) :</label></td>
			<td><input type='text' class='nombre' name='cedulaMedEntrega' id='cedulaMedEntrega' style='width: 100px; height: 30px' value='$cedulaMedEntrega'></td>
		</tr>
		<tr>
		<td> <label style='color: beige'> PACIENTE REGRESA DE ESTUDIOS EXTERNOS :</label> </td>
		</tr>
		<tr>
			<td><label style='color: beige'>Fecha Externo :</label></td>
			<td><input type='date' class='nombre' name='fechaExt' id='fechaExt' value='$fechaExt'></td>
		<tr>
		<tr>
			<td><label style='color: beige'>Hora Externo :</label></td>
			<td><input type='time' class='nombre' name='horaExt' id='horaExt' value='$horaExt'></td>
		</tr>		
		<tr>
			<td><label style='color: beige'>TURNO :</label></td>
			<td> <select id='turnoExt' name='turnoExt' class='nombre'>
					<option value='$turnoExt'>Seleccione</option>
					<option value='M'>MATUTINO</option>
					<option value='V'>VESPERTINO</option>
					<option value='N'>NOCTURNO</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style='color: beige'>Se recibe al paciente estable :</label></td>
			<td> <select id='estable' name='estable' class='nombre'>
					<option value=$pacEst>$pacEst</option>
					<option value='1'>SI</option>
					<option value='0'>NO</option>
				</select>
			</td>
		</tr>
		
	</table>
	<br>
	<input type='hidden' name='idNotaRefTraslh' id='idNotaRefTraslh' value='$idNotaRefTraslh' >
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
	 	$("#servicio").focus().after('<span class="error"> Colocar servicio </span>');
	 	return false;
	 }
	  if ($("#turno").val() == "") { 
	 	$("#turno").focus().after('<span class="error"> Colocar Turno </span>');
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
	 if ($("#cedulaMedEntrega").val() == "") { 
	 	$("#cedulaMedEntrega").focus().after('<span class="error"> Colocar Cedula</span>');
	 	return false;
	 }
	/*Fin Validaciónes*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveNotaRefTrasl.php',
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
					$("#Usuarios").load("consultaNotaRefTrasl.php", function(){});
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
						$("#Usuarios").load("consultaNotaRefTrasl.php", function(){});
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
	
	