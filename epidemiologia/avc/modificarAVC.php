
<div class="result_fail"></div>

<?php
	//Datos para Temperatura
	//$temperatura1 =NULL;
	if (isset($_POST['idAVC']))
	{
		$idAVC  = $_POST["idAVC"];
	

		if (isset($_POST['fechaInst']))
		{
			$fechaInst=$_POST['fechaInst'];
			//$fecha = strtotime($_POST["fecha"]);
			//$fechaM = date('Y-m-d',$fecha);
		} else {
			$fechaInst = '';
		}
		
		if (isset($_POST['fechaRetiro']))
		{
			$fechaRetiro=$_POST['fechaRetiro'];
		} else {
			$fechaRetiro = '';
		}

		if (isset($_POST['nInstala']))
		{
			$nInstala  = $_POST["nInstala"];
		} else {
			$nInstala = '';
		}

		if (isset($_POST['complicacion']))
		{
			$complicacion  = $_POST["complicacion"];
			//$$temperatura1 = substr($temperatura, 0, -2);
		} else {
			$complicacion = '';
		}

		if (isset($_POST['observaciones']))
		{
			$observaciones  = $_POST["observaciones"];
		} else {
			$observaciones = '';
		}


		$formularioTemp = "<div><label style='color: beige'>Fecha Instalación (*):</label><input type='date' autocomplete='off' class='nombre' name='fechaInst' id='fechaInst' value='$fechaInst'></div>
						<div><label style='color: beige'>Fecha Retiro (*):</label><input type='date' autocomplete='off' class='nombre' name='fechaRetiro' id='fechaRetiro' value='$fechaRetiro'></div>
						<label style='color: beige'>Observaciones :</label><textarea class='nombre' id='observaciones' name='observaciones' rows='3' cols='50'>$observaciones</textarea>
						<!--input type='text' class='nombre' name='observaciones' id='observaciones' value='$observaciones'-->
						</div>
						<input type='hidden' name='idAVC' id='idAVC' value='$idAVC' >
						<div><input type='submit' value='Guardar' class='boton' name='boton' id='enviarAVC'>";

		$btBorrarTemp = "<input type='button' value='Borrar' class='boton' name='boton' id='Borrar'>";
		$formulario = $formularioTemp;
		$var = true;
		$borrar=$btBorrarTemp;
	}

?>

<form class='contacto' method='POST' action='' id="formu">
	<?php echo $formulario ?>
    <?php if($var) { 
			echo $borrar
	?>
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
 $("#enviarAVC").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	 var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	 
	 if ($("#fechaInst").val() == "" || $("#fechaInst").val() == "0000-00-00" ) { 
	 	//alert("Usuario Inválido");
	 	$("#fechaInst").focus().after('<span class="error"> Colocar Fecha Instalacion </span>');
	 	return false;
	 }
	 
	  if ($("#fechaRetiro").val() == "" || $("#fechaRetiro").val() == "0000-00-00" ) { 
	 	//alert("Usuario Inválido");
	 	$("#fechaRetiro").focus().after('<span class="error"> Colocar Fecha Retiro </span>');
	 	return false;
	 }
	 
	 /*if ($("#temperatura").val() == "") { 
	 	$("#temperatura").focus().after('<span class="error"> Colocar una Temperatura </span>');
	 	return false;
	 }
	 
	  if ($("#verif").val() == "") { 
	 	$("#verif").focus().after('<span class="error"> Colocar un Verificador </span>');
	 	return false;
	 }*/
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveAVC.php',
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
					$("#Usuarios").load("consultaAVC.php", function(){});
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


 </script>