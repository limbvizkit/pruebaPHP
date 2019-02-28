
<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idTemp']))
	{
		$idTemp  = $_POST["idTemp"];
	

		if (isset($_POST['fecha']))
		{
			$fecha=$_POST['fecha'];
			//$fecha = strtotime($_POST["fecha"]);
			//$fechaM = date('Y-m-d',$fecha);
		} else {
			$fecha = '';
		}

		if (isset($_POST['hora']))
		{
			$hora  = $_POST["hora"];
		} else {
			$hora = '';
		}

		if (isset($_POST['tempM']))
		{
			$temperatura  = substr($_POST["tempM"], 0,-3);
			//$$temperatura1 = substr($temperatura, 0, -2);
		} else {
			$temperatura = '';
		}

		if (isset($_POST['verif']))
		{
			$verif  = $_POST["verif"];
		} else {
			$verif = '';
		}

		if (isset($_POST['observaciones']))
		{
			$observaciones  = $_POST["observaciones"];
		} else {
			$observaciones = '';
		}


		$formularioTemp = "<div><label style='color: beige'>Fecha Medición (*):</label><input type='text' autocomplete='off' class='nombre' name='fechaM' id='fechaM' value='$fecha'></div>
						<div><label style='color: beige'>Hora Medición (*):</label>&nbsp;&nbsp;<input type='time' class='nombre' name='horaM' id='horaM' value='$hora'></div>
						<div><label style='color: beige'>Temperatura (*):</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' autocomplete='off' class='nombre' name='temperatura' id='temperatura' style='width:50px' value='$temperatura'>°C</div>
						<div><label style='color: beige'>Verificador (*):</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' class='nombre' name='verif' id='verif' autocomplete='off' style='width:300px' value='$verif'></div>
						<div><label style='color: beige'>Observaciones :</label>&nbsp;&nbsp;&nbsp;
						<textarea class='nombre' id='observaciones' name='observaciones' rows='3' cols='50'>$observaciones</textarea>
						<!--input type='text' class='nombre' name='observaciones' id='observaciones' value='$observaciones'-->
						</div>
						<input type='hidden' name='idTemp' id='idTemp' value='$idTemp' >
						<div><input type='submit' value='Guardar' class='boton' name='boton' id='enviarTemp'>";

		$btBorrarTemp = "<input type='button' value='Borrar' class='boton' name='boton' id='Borrar'>";
		$formulario = $formularioTemp;
		$var = true;
		$borrar=$btBorrarTemp;
	}

	//Datos para OtrasInfecciones
	if (isset($_POST['idOtrasInfecc']))
	{
		$idOtrasInfecc  = $_POST["idOtrasInfecc"];
		
		if (isset($_POST['infeccion']))
		{
			$infeccion  = $_POST["infeccion"];
		} else {
			$infeccion = '';
		}
		if (isset($_POST['inicio']))
		{
			$inicio=$_POST['inicio'];
		} else {
			$inicio = '';
		}
		if (isset($_POST['fechObser']))
		{
			$fechObser=$_POST['fechObser'];
		} else {
			$fechObser = '';
		}
		if (isset($_POST['final']))
		{
			$final=$_POST['final'];
		} else {
			$final = '';
		}
		if (isset($_POST['verif']))
		{
			$verif  = $_POST["verif"];
		} else {
			$verif = '';
		}
		if (isset($_POST['observaciones']))
		{
			$observaciones  = $_POST["observaciones"];
		} else {
			$observaciones = '';
		}

		$formularioOtrasInfecc = "<div><label style='color: beige'>Infección (*):</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='text' autocomplete='off' class='nombre' name='infeccion' id='infeccion' style='width:380px' value='$infeccion'></div>
						<div><label style='color: beige'>Fecha Inicio (*):</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='text' autocomplete='off' class='nombre' name='fechaIni' id='fechaIni' value='$inicio'></div>
						<div><label style='color: beige'>Fecha Observación (*):</label><input type='text' autocomplete='off' class='nombre' name='fechaObs' id='fechaObs' value='$fechObser'></div>
						<div><label style='color: beige'>Fecha Fin (*):</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='text' autocomplete='off' class='nombre' name='fechaFin' id='fechaFin' value='$final'></div>
						<div><label style='color: beige'>Verificador (*):</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='text' autocomplete='off' class='nombre' name='verif' id='verif' style='width:300px' value='$verif'></div>
						<div><label style='color: beige'>Observaciones :</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea class='nombre' id='observaciones' name='observaciones' rows='3' cols='50'>$observaciones</textarea>
						</div>
						<input type='hidden' name='idOtrasInfecc' id='idOtrasInfecc' value='$idOtrasInfecc' >
						<div><input type='submit' value='Guardar' class='boton' name='enviarOtrasInfecc' id='enviarOtrasInfecc'>";

		$btBorrarOtrasInfecc = "<input type='button' value='Borrar' class='boton' name='boton' id='BorrarOtrasInfecc'>";
		$formulario = $formularioOtrasInfecc;
		$var = true;
		$borrar=$btBorrarOtrasInfecc;
	}

	//Datos para Vigilancia
	if (isset($_POST['idVig']))
	{
		$idVig  = $_POST["idVig"];
		
		if (isset($_POST['fecha']))
		{
			$fecha  = $_POST["fecha"];
		} else {
			$fecha = '';
		}
		if (isset($_POST['hora']))
		{
			$hora=$_POST['hora'];
		} else {
			$hora = '';
		}
		if (isset($_POST['metaInt']))
		{
			$metaInt=$_POST['metaInt'];
		} else {
			$metaInt = '';
		}
		if (isset($_POST['vigRPBI']))
		{
			$vigRPBI=$_POST['vigRPBI'];
		} else {
			$vigRPBI = '';
		}
		if (isset($_POST['inmuno']))
		{
			$inmuno  = $_POST["inmuno"];
		} else {
			$inmuno = '';
		}
		if (isset($_POST['comor']))
		{
			$comor  = $_POST["comor"];
		} else {
			$comor = '';
		}
		if (isset($_POST['aisla']))
		{
			$aisla  = $_POST["aisla"];
		} else {
			$aisla = '';
		}
		if (isset($_POST['padAct']))
		{
			$padAct  = $_POST["padAct"];
		} else {
			$padAct = '';
		}
		if (isset($_POST['notas']))
		{
			$notas  = $_POST["notas"];
		} else {
			$notas = '';
		}

		$formularioVig = "
						<div><label style='color: beige'>Fecha Visita (*):</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='text' autocomplete='off' class='nombre' name='fechaV' id='fechaV' value='$fecha'></div>
						<div><label style='color: beige'>Hora Visita (*):</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<input type='time' class='nombre' name='horaV' id='horaV' value='$hora'></div>
						<div><label style='color: beige'>Meta Inter. :</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='text' autocomplete='off' class='nombre' name='meta' id='meta' value='$metaInt'></div>
						<div><label style='color: beige'>VigilanciaRPBI :</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='text' autocomplete='off' class='nombre' name='vigRPBI' id='vigRPBI' value='$vigRPBI'></div>
						<div><label style='color: beige'>Inmunocomprometido (*):</label><input type='text' autocomplete='off' class='nombre' name='inmuno' id='inmuno' value='$inmuno'></div>
						<div><label style='color: beige'>Comorbilidad :</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea class='nombre' id='comor' name='comor' rows='3' cols='50'>$comor</textarea>
						</div>
						<div><label style='color: beige'>Aislamiento :</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea class='nombre' id='aisla' name='aisla' rows='3' cols='50'>$aisla</textarea>
						</div>
						<div><label style='color: beige'>Padecimiento Act. :</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea class='nombre' id='padAct' name='padAct' rows='3' cols='50'>$padAct</textarea>
						</div>
						<div><label style='color: beige'>Notas :</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea class='nombre' id='notas' name='notas' rows='3' cols='50'>$notas</textarea>
						</div>
						<input type='hidden' name='idVig' id='idVig' value='$idVig' >
						<input type='hidden' name='horaOc' id='horaOc' value='$hora' >
						<div><input type='submit' value='Guardar' class='boton' name='enviarVig' id='enviarVig'>";

		$btBorrarVig = "<input type='button' value='Borrar' class='boton' name='boton' id='BorrarVig'>";
		$formulario = $formularioVig;
		$var = true;
		$borrar=$btBorrarVig;
	}
?>

<form class='contacto' method='POST' action='' id="formu">
	<?php echo $formulario ?>
    <?php if($var) { 
				echo $borrar ?>
    <?php } ?>
    	<input  type='button' value='Cerrar' class='boton' name='boton' id="Cerrar">
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
 
 /*Evento Click Botón Enviar Para usuario*/
 $("#enviarTemp").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	 var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	 
	 if ($("#fechaM").val() == "" || !yearreg.test($("#fechaM").val())) { 
	 	//alert("Usuario Inválido");
	 	$("#fechaM").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }
	 
	  if ($("#horaM").val() == "") { 
	 	$("#horaM").focus().after('<span class="error"> Colocar una Hora </span>');
	 	return false;
	 }
	 
	 if ($("#temperatura").val() == "") { 
	 	$("#temperatura").focus().after('<span class="error"> Colocar una Temperatura </span>');
	 	return false;
	 }
	 
	  if ($("#verif").val() == "") { 
	 	$("#verif").focus().after('<span class="error"> Colocar un Verificador </span>');
	 	return false;
	 }
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveTemp.php',
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
					$("#Usuarios").load("consultaTemperatura.php", function(){});
					alert("Se realizo la Operación Correctamente");
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
 /*Fin Evento Click Botón Enviar Temperatura*/

 /*Evento Click Botón Borrar Usuario*/
 $("#Borrar").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará la medición: " +" "+$("#temperatura").val()+" del "+ $("#fechaM").val());
	 
	 if(Resp){
			 /*Escogió opción ACEPTAR*/
			 //Determinanos los datos del formulario y los serializamos
			var datos = $("#formu").serialize();
			// Enviamos el formulario usando AJAX
			$.ajax({
				type: 'POST',
				url: 'delTemp.php',
				error: function(data){
					//Si sucedió algo, se notifica
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error Eliminando Registro");
						alert("!!!ERROR DATA: NO Se elimino la Medición !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaTemperatura.php", function(){});
						alert("Se Elimino la Medición Correctamente");
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Medición !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Temperatura*/
/*********************************************************************************************************************************/	
/*Evento Click Botón Enviar Para Otras Infecciones*/
 $("#enviarOtrasInfecc").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	 var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	 
	 if ($("#infeccion").val() == "") { 
	 	$("#infeccion").focus().after('<span class="error"> Colocar una Infección </span>');
	 	return false;
	 }
	 
	 if ($("#fechaIni").val() == "" || !yearreg.test($("#fechaIni").val())) { 
	 	$("#fechaIni").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }
	 
	 if ($("#fechaObs").val() == "" || !yearreg.test($("#fechaObs").val())) { 
	 	$("#fechaObs").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }
	 
	 /*if ($(!yearreg.test($("#fechaFin").val()))) {
	 	$("#fechaFin").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }*/  
	 
	  if ($("#verif").val() == "") {
	 	$("#verif").focus().after('<span class="error"> Colocar un Verificador </span>');
	 	return false;
	 }
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveOtrasInfecc.php',
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
					$("#Usuarios").load("consultaOtrasInfecciones.php", function(){});
					alert("Se realizo la Operación Correctamente");
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
 /*Fin Evento Click Botón Enviar Otras Infecciones*/
	
/*Evento Click Botón Borrar Otras Infecciones*/
 $("#BorrarOtrasInfecc").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará la infeccion: " +" "+$("#infeccion").val());
	 
	 if(Resp){
			 /*Escogió opción ACEPTAR*/
			 //Determinanos los datos del formulario y los serializamos
			var datos = $("#formu").serialize();
			// Enviamos el formulario usando AJAX
			$.ajax({
				type: 'POST',
				url: 'delOtrasInfecc.php',
				error: function(data){
					//Si sucedió algo, se notifica
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error Eliminando Registro");
						alert("!!!ERROR DATA: NO Se elimino la Infección !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaOtrasInfecciones.php", function(){});
						alert("Se Elimino la Infección Correctamente");
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Infección !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Otras Infecciones*/
/************************************************************************************************************************************/	
/*Evento Click Botón Enviar Para Vigilancia*/
 $("#enviarVig").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	 var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	 
	 if ($("#fechaV").val() == "" || !yearreg.test($("#fechaV").val())) { 
	 	$("#fechaV").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }
	 
	  if ($("#horaV").val() == "") {
	 	$("#horaV").focus().after('<span class="error"> Colocar una Hora </span>');
	 	return false;
	 }
	 
	 if ($("#inmuno").val() == "") {
	 	$("#inmuno").focus().after('<span class="error"> Colocar un Valor </span>');
	 	return false;
	 }
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveVigilancia.php',
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
					$("#Usuarios").load("consultaVigilancia.php", function(){});
					alert("Se realizo la Operación Correctamente");
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
 $("#BorrarVig").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará la Vigilancia del día: " +" "+$("#fechaV").val()+" y hora "+$("#horaOc").val());
	 
	 if(Resp){
			 /*Escogió opción ACEPTAR*/
			 //Determinanos los datos del formulario y los serializamos
			var datos = $("#formu").serialize();
			// Enviamos el formulario usando AJAX
			$.ajax({
				type: 'POST',
				url: 'delVigilancia.php',
				error: function(data){
					//Si sucedió algo, se notifica
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error Eliminando Registro");
						alert("!!!ERROR DATA: NO Se elimino la Vigilancia !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1){
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaVigilancia.php", function(){});
						alert("Se Elimino la Vigilancia Correctamente");
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se elimino la Vigilancia !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Vigilancia*/

 </script>