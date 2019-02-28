<div class="result_fail"></div>

<?php
	require_once('conexion/configRepo.php');
	#Para modificar un Material
	if (isset($_POST['idMaterial']))
	{
		//echo 'Llego: '.$_POST['idMaterial'].'  y  '.$_POST['idResguardo'];
		$idMaterial=$_POST['idMaterial'];
		
		if (isset($_POST['idResguardo'])) {
			$idResguardo = $_POST['idResguardo'];
		}
		
		$queryBuscaRes = "SELECT r.idResguardo, idMaterial, fechaResguardo, area, entrega, recibe, cargo, observaciones, m.tipoActivo, cantidad, unidad,
								m.descActivo, m.marca, m.modelo, m.numSerie
						FROM resguardosrh AS r
						LEFT JOIN materiaresguardorh as m ON r.idResguardo=m.idResguardo
						WHERE r.idResguardo='$idResguardo' AND idMaterial = '$idMaterial'";
		$result1 = mysqli_query($conexion, $queryBuscaRes) or die (mysqli_error($conexion));

		while($row = mysqli_fetch_array($result1)){
				$fecha = $row[2];
				$cantidad = utf8_encode($row['cantidad']);
				$unidad = utf8_encode($row['unidad']);
				$tipoActivo = utf8_encode($row['tipoActivo']);
				$marca = utf8_encode($row['marca']);
				$modelo = utf8_encode($row['modelo']);
				$numSerie = utf8_encode($row['numSerie']);
				$descActivo = utf8_encode($row['descActivo']);
				$area = utf8_encode($row['area']);
				$entrego = utf8_encode($row['entrega']);
				$recibe = utf8_encode($row['recibe']);
				$cargo = utf8_encode($row['cargo']);
				$observaciones = utf8_encode($row['observaciones']);
				$idResguardo = $row['idResguardo'];
		}
		
		$formularioAdverso = "<table>
		<tr>
			<td><label style='color: #000066'>FECHA(*) :</label></td>
			<td><input type='date' class='nombre' name='fecha' id='fecha' value='$fecha' disabled></td>
		</tr>
		<tr>
			<td><label style='color: #000066'>Cantidad(*) :</label></td>
			<td><input type='number' class='nombre' name='cantidad' id='cantidad' style='width: 50px; height: 30px' value='$cantidad' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: #000066'>Unidad(*) :</label></td>
			<td><input type='text' class='nombre' name='unidad' id='unidad' style='width: 200px; height: 30px' value='$unidad' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: #000066'>Material/Equipo(*) :</label></td>
			<td><input type='text' class='nombre' name='tipoActivo' id='tipoActivo' style='width: 400px; height: 30px' value='$tipoActivo' autocomplete='off'></td>
		</tr>
		<tr>
			<td><label style='color: #000066'>MARCA(*) :</label></td>
			<td><input type='text' class='nombre' name='marca' id='marca' style='width: 350px; height: 30px' value='$marca' autocomplete='off'>
		</td>
		<tr>
			<td><label style='color: #000066'>MODELO(*) :</label></td>
			<td><input type='text' class='nombre' name='modelo' id='modelo' style='width: 350px; height: 30px' value='$modelo' autocomplete='off'>
		</td>
		<tr>
			<td><label style='color: #000066'>No. de Serie(*) :</label></td>
			<td><input type='text' class='nombre' name='numSerie' id='numSerie' style='width: 350px; height: 30px' value='$numSerie' autocomplete='off'>
		</td>
		
		<tr>
			<td><label style='color: #000066'>DESCRIPCIÓN(*) :</label></td>
			<td><textarea class='nombre' id='descActivo' name='descActivo' rows='3' cols='70'>$descActivo</textarea></td>
		</tr>
		<tr>
			<td><label style='color: #000066'>Área(*) :</label></td>
			<td><input type='text' class='nombre' name='area' id='area' style='width: 350px; height: 30px' value='$area' autocomplete='off'>
		</td>
		<tr>
			<td><label style='color: #000066'>Enrtega(*) :</label></td>
			<td><input type='text' class='nombre' name='entrego' id='entrego' style='width: 350px; height: 30px' value='$entrego' autocomplete='off'>
		</td>
		<tr>
			<td><label style='color: #000066'>Recibe(*) :</label></td>
			<td><input type='text' class='nombre' name='recibe' id='recibe' style='width: 350px; height: 30px' value='$recibe' autocomplete='off'>
		</td>
		<tr>
			<td><label style='color: #000066'>Cargo(*) :</label></td>
			<td><input type='text' class='nombre' name='cargo' id='cargo' style='width: 350px; height: 30px' value='$cargo' autocomplete='off'>
		</td>
		<tr>
			<td><label style='color: #000066'>Observaciones</label></td>
			<td><textarea class='nombre' id='observaciones' name='observaciones' rows='3' cols='70'>$observaciones</textarea></td>
		</tr>
	</table>
	<br>
	<input type='hidden' name='idMaterial' id='idMaterial' value='$idMaterial' >
	<input type='hidden' name='idResguardo' id='idResguardo' value='$idResguardo' >
	
	<div><input type='submit' value='Guardar' class='btn btn-success' name='boton' id='enviarNota'>";
	
		$btBorrarNota = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='Borrar'>";
		$formulario = $formularioAdverso;
}

?>

	<form class='contacto' method='POST' action='' id="formu">
		<?php echo $formulario ?>
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
	 if ($("#cantidad").val() == "") {
	 	$("#cantidad").focus().after('<span class="error"> Colocar Cantidad </span>');
	 	return false;
	 }
	 if ($("#unidad").val() == "") {
	 	$("#unidad").focus().after('<span class="error"> Colocar las unidades </span>');
	 	return false;
	 }
	 if ($("#tipoActivo").val() == "") {
	 	$("#tipoActivo").focus().after('<span class="error"> Colocar Material </span>');
	 	return false;
	 }
	 if ($("#marca").val() == "") {
	 	$("#marca").focus().after('<span class="error"> Colocar una Marca </span>');
	 	return false;
	 }
	  if ($("#modelo").val() == "") {
	 	$("#modelo").focus().after('<span class="error"> Colocar un Modelo </span>');
	 	return false;
	 }
	  if ($("#numSerie").val() == "") {
	 	$("#numSerie").focus().after('<span class="error"> Colocar un Num. de Serie </span>');
	 	return false;
	 }
	  if ($("#descActivo").val() == "") {
	 	$("#descActivo").focus().after('<span class="error"> Colocar una Descripcion </span>');
	 	return false;
	 }
	 if ($("#area").val() == "") {
	 	$("#area").focus().after('<span class="error"> Colocar un área </span>');
	 	return false;
	 }
	 if ($("#entrego").val() == "") {
	 	$("#entrego").focus().after('<span class="error"> Colocar quien entregó </span>');
	 	return false;
	 }
	 if ($("#recibe").val() == "") {
	 	$("#recibe").focus().after('<span class="error"> Colocar quien recibe </span>');
	 	return false;
	 }
	 if ($("#cargo").val() == "") {
	 	$("#cargo").focus().after('<span class="error"> Colocar el cargo </span>');
	 	return false;
	 }
	 if ($("#recibe").val() == "") {
	 	$("#recibe").focus().after('<span class="error"> Colocar quien recibe </span>');
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
            url: 'saveResguardorh.php',
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
					$("#Usuarios").load("buscaResguardorh.php?rol=admin", function(){});
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

</script>