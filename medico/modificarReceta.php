<div class="result_fail"></div>

<?php
if (isset($_POST['idReceta']))
	{
		$idReceta  = $_POST["idReceta"];
				
		if (isset($_POST['nombrePac']))
		{
			$nombrePac=$_POST['nombrePac'];
		} else {
			$nombrePac = '';
		}
		if (isset($_POST['nacimiento']))
		{
			$nacimiento=$_POST['nacimiento'];
		} else {
			$nacimiento = '';
		}
		if (isset($_POST['diagn']))
		{
			$diagn  = $_POST["diagn"];
		} else {
			$diagn = '';
		}
		if (isset($_POST['alergias']))
		{
			$alergias  = $_POST["alergias"];
		} else {
			$alergias = '';
		}
		if (isset($_POST['exp']))
		{
			$exp  = $_POST["exp"];
		} else {
			$exp = '';
		}
		if (isset($_POST['folio']))
		{
			$folio  = $_POST["folio"];
		} else {
			$folio = '';
		}
		if (isset($_POST['cedula']))
		{
			$cedula  = $_POST["cedula"];
		} else {
			$cedula = '';
		}
		if (isset($_POST['idMedicamentos']))
		{
			$idMedicamentos  = $_POST["idMedicamentos"];
		} else {
			$idMedicamentos = '';
		}
		if (isset($_POST['medicamentos']))
		{
			$medicamentos  = $_POST["medicamentos"];
		} else {
			$medicamentos = '';
		}
		if (isset($_POST['sal']))
		{
			$sal  = $_POST["sal"];
		} else {
			$sal = '';
		}
		if (isset($_POST['indicaciones']))
		{
			$indicacion  = $_POST["indicaciones"];
		} else {
			$indicacion = '';
		}
		if (isset($_POST['existencias']))
		{
			$existencia  = $_POST["existencias"];
		} else {
			$existencia = '';
		}

		$formularioReceta = "<table>
			<tr>
				<!--td><label style='color: beige'>Nombre del Paciente :</label></td-->
				<td><input type='hidden' class='nombre' name='nombrePac' id='nombrePac'  style='width: 500px; height: 30px' autocomplete='off' value='$nombrePac'></td>
			</tr>
			<tr>
				<!--td><label style='color: beige'>Fecha de Nacimiento :</label></td-->
				<td><input type='hidden' class='nombre' name='nacimiento' id='nacimiento' value='$nacimiento'></td>
			</tr>
			<tr>
				<td><label style='color: beige'>Alergias :</label></td>
				<td>
				<input type='text' class='nombre' name='alergias' id='alergias' style='width: 800px; height: 30px' autocomplete='off' value='$alergias'>
				<!--td><textarea class='nombre' id='alergias' name='alergias' rows='3' cols='70'>$alergias</textarea-->
				</td>
			</tr>
			<tr>
				<!--td><label style='color: beige'>Diagnóstico(*) :</label></td-->
				<td>
					<input type='hidden' class='nombre' name='diagn' id='diagn' style='width: 800px; height: 30px' autocomplete='off' value='$diagn'>
				   	<!--td><textarea class='nombre' id='diagn' name='diagn' rows='3' cols='70'>$diagn</textarea-->
				</td>
			</tr>
			<tr>
				<td><label style='color: beige'>Cedula Médico (*) :</label></td>
				<td><input type='text' class='nombre' name='cedula' id='cedula' style='width: 80px; height: 30px' autocomplete='off' value='$cedula'></td>
			</tr>
			
			</table>
			<hr>
				<h3>INDICACIÓNES</h3>
			
			<tr>
				<!--td><label style='color: beige'>Indicación(*) :</label></td>
				<td><textarea class='nombre' id='indicacion' name='indicacion' rows='3' cols='70'>$indicacion</textarea></td-->
				
				<td>
					<div class='form-group'>
						
						<label>NOMBRE DEL MÉDICAMENTO : <span>*</span></label>
							<input type='text' name='medicamento' id='service' class='form-control' autocomplete='off'>
							<input type='hidden' size='10' id='idMed' name='idMed' accept-charset='utf-8' >
							<input id='sal' name='sal' type='hidden' accept-charset='utf-8' >
							<input id='exist' name='exist' type='hidden' >
							
							<div id='suggestions' style='height: 180px; overflow: auto; background:#CEECF5' ></div>

							<label>DOSIS/INDICACIONES : <span>*</span></label>
							<textarea class='form-control' name='indicacion' id='indicacion' cols='10' rows='3'></textarea>
							<br>
							<button id='adicionar' class='btn btn-success' type='button'>Agregar Medicamento</button>
						</div>

						<p>Medicamentos Agregados:
						  <div id='adicionados'></div>
						</p>
						<table id='mytable' class='table table-bordered table-hover'>
						<thead>
							<tr>
								<th>MEDICAMENTO</th>
								<th>INDICACIONES</th>
								<th>EXISTENCIAS</th>
								<th>Eliminar</th>
							</tr>
						  </thead>
					  <tbody id='ProSelected'>";
					  if($indicacion != NULL && $indicacion != ''){
						$arreglado = trim($indicacion, '[');
						$arreglado1 = trim($arreglado, ']');
						$indicac = explode("},",$arreglado1);

						$arreglado2 = trim($idMedicamentos, '[');
						$arreglado3 = trim($arreglado2, ']');
						$idMedicam = explode(",",$arreglado3);

						$arreglado4 = trim($medicamentos, '[');
						$arreglado5 = trim($arreglado4, ']');
						$medicam = explode(",",$arreglado5);

						$arreglado6 = trim($sal, '[');
						$arreglado7 = trim($arreglado6, ']');
						$salMed = explode("},",$arreglado7);
						  
						$arreglado8 = trim($existencia, '[');
						$arreglado9 = trim($arreglado8, ']');
						$existMed = explode("},",$arreglado9);

						$longitud = count($medicam);

						for($i=0; $i<$longitud; $i++){
							$fi = substr($idMedicam[$i+1], 9, -2);
							$hi = substr($medicam[$i],17, -2);
							/*$fi = $idMedicam[$i]['medI'];
							$hi = $medicam[$i]['medicamentoI'];
							$si = $salMed[$i]['salI'];
							$ii = $indicac[$i]['nameI'];*/
							
							$reemp = array('"', '}');
							$si = substr(str_replace($reemp,"",$salMed[$i]),6);
							$ei = substr(str_replace($reemp,"", $existMed[$i]), 8);
							$ii = substr(str_replace($reemp,"", $indicac[$i+1]), 7);
							
							/*$fi = $fechaIndic[$i+1]['fechaI'];
							$hi = $horaIndic[$i]['horaI'];
							//var_dump(strlen($indicac[0]));
							if(strlen($indicac[0]) <= 15){								
								$ii = substr($indicac[$i+1], 9, -2);
							} else {
								$ii = substr($indicac[$i], 10, -2);
							}*/
							
						
						$formularioReceta = $formularioReceta."<tr class='item'>
								<td>
									<input id='nMedicamento' name='nMedicamento' type='text' style='width:350px;' value='$hi' disabled />
								</td>
								<td>
									<textarea id='nIndicacion' name='nIndicacion' row='4' cols='30'>$ii </textarea>
								</td>
								<td>
									<input id='nExist' name='nExist' type='text' style='width:50px;' value='$ei' disabled />
								</td>
								<td>
									<button type='button' name='remove' id='$i' class='btn btn-danger btn_remove'>Quitar</button>
								</td>
								<input type='hidden' name='idMed' id='idMed' value='$fi' >
								<input id='nSal' name='nSal' type='hidden' style='width:300px;'' value='$si' />
							</tr>";
						}
					  }
			$formularioReceta = $formularioReceta."</table></td>
			</td>
			</tr>
		<br>
		<input type='hidden' name='idReceta' id='idReceta' value='$idReceta' >
		<div>
		<input type='hidden' id='ListaPro' name='ListaPro' value='' >
		<input type='hidden' id='ListaPro2' name='ListaPro2' value='' >
		<input type='hidden' id='ListaPro3' name='ListaPro3' value='' >
		<input type='hidden' id='ListaPro4' name='ListaPro4' value='' >
		<input type='hidden' id='ListaPro5' name='ListaPro5' value='' >
		<input type='submit' value='Guardar' class='btn btn-success' onclick='creaArr();' name='boton' id='enviarReceta'>";
		//echo "<input type='button' value='PDF' class='btn btn-danger' name='lvc' style='height: 50px; width: 80px'
	  	//onClick=window.open(\"../pdf/creaPDF.php?idIndicMed=$idIndicMed&name=indm\").focus() />";

		$btBorrarIndicMed = "<input type='button' value='Borrar' class='btn btn-danger' name='boton' id='BorrarReceta'>";
		$formulario = $formularioReceta;
		$var = true;
		$borrar=$btBorrarIndicMed;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	
	/*Evento Click Botón Enviar Para Receta Medica*/
 $("#enviarReceta").click(function(evento){
	 evento.preventDefault(); //Evitamos que el formulario se vaya
	 
	 /*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
	// var yearreg = /^(19[0-9]{2}|2[0-9]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/;   //Creamos las reglas para validar la fecha YYY-MM-DD
	 				
	 $(".error").fadeOut().remove();
	/* if ($("#fechaV").val() == "" || !yearreg.test($("#fechaV").val())) { 
	 	$("#fechaV").focus().after('<span class="error"> Colocar Fecha YYYY-MM-DD </span>');
	 	return false;
	 }*/
	 if ($("#nacimiento").val() == "") {
	 	$("#nacimiento").focus().after('<span class="error"> Colocar una Fecha </span>');
	 	return false;
	 }
	  /*if ($("#nombrePac").val() == "") {
	 	$("#nombrePac").focus().after('<span class="error"> Colocar una Nombre </span>');
	 	return false;
	 }	*/
	  if ($("#cedula").val() == "") {
	 	$("#cedula").focus().after('<span class="error"> Colocar una Cedula </span>');
	 	return false;
	 }
	  /*if ($("#diagn").val() == "") {
	 	$("#diagn").focus().after('<span class="error"> Colocar un Diagnóstico </span>');
	 	return false;
	 }*/
	  /*if ($("#indicacion").val() == "") {
	 	$("#indicacion").focus().after('<span class="error"> Colocar Indicaciones </span>');
	 	return false;
	 }*/
	/*Fin Validación*/
	 
	//Determinanos los datos del formulario y los serializamos
	var datos = $("#formu").serialize();
	//alert(datos);
	// Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: 'saveReceta.php',
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
					$("#Usuarios").load("consultaReceta.php", function(){});
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
 /*Fin Evento Click Botón Enviar Vigilancia*/
	
/*Evento Click Botón Borrar Vigilancia*/
 $("#BorrarReceta").click(function(){
	 /*Confirmar si se desea borrar el registro*/
	 var Resp = confirm("Se eliminará los Medicamentos del Paciente: " +" "+$("#nombrePac").val());
	 
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
						alert("!!!ERROR DATA: NO Se elimino NADA !!!");
					},
				data: datos,
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					if(data==1) {
						/*Reconstruimos la tabla*/
						$("#Usuarios").html("");
						$("#Usuarios").load("consultaReceta.php", function(){});
						alert("Se Eliminaron las Indicaciones Correctamente");
						self.parent.location.reload();
						/*Fin Reconstruir la tabla*/
						$("#div_User").hide();
					}else{
						$(".result_fail").fadeIn();
						$(".result_fail").html("Error " . data);
						alert("!!!ERROR BD: NO Se eliminaron las Indicaciones !!!");
						return false;
					}
				 }
			});		 
		 }
	 })
  /*Fin Evento Click Botón Borrar Vigilancia*/
 </script>

<script type="text/javascript">
/**************************************Escript's para agregar Indicaciones Medicas****************************************************************/
	var c=0;//contador para asignar id al boton que borrara la fila
		
			//Funcion para acomodar la fecha de AAAA-MM-DD a DD/MM/AAAA
			function convertDateFormat(string) {
				var info = string.split('-').reverse().join('/');
        		return info;
			}
	
	 $(document).ready(function() {
			//obtenemos el valor de los input
			$('#adicionar').click(function() {
			  	var indicacion = document.getElementById("indicacion").value;
			  	indicacion = indicacion.trim();
				document.getElementById("indicacion").value='';
				
				var medicamento = document.getElementById("service").value;
			  	medicamento = medicamento.trim();
				document.getElementById("service").value='';
				
				var existencias = document.getElementById("exist").value;
			  	existencias = existencias.trim();
				document.getElementById("exist").value='';
				
				var medId = document.getElementById("idMed").value;
			  	medId = medId.trim();
				document.getElementById("idMed").value='';
				
				var salN = document.getElementById("sal").value;
			  	salN = salN.trim();
				document.getElementById("sal").value='';
				
				/*var horaIndicacion = document.getElementById("horaIndicacion").value;
			  	horaIndicacion = horaIndicacion.trim();*/
			  //var cantidad = document.getElementById("cantidad").value;
			  //var i = 1; //contador para asignar id al boton que borrara la fila
			  c++;
			  //var fila = '<tr>';
			  var fila = '<tr class="item"> <td><input id="nMedicamento' + c + '" name="nMedicamento[' + c + ']" type="text" style="width: 350px; height: 28px" value="'+medicamento+'" /></td> ';
			  //fila = fila + '<td> <input id="hIndic[' + c + ']" name="hIndic[' + c + ']" type="time" value="'+horaIndicacion+'" /></td>';
			  fila = fila + '<td><textarea id="nIndicacion' + c + '" name="nIndicacion[' + c + ']">'+indicacion+'</textarea></td> ';
			  fila = fila + '<td><input id="nExist' + c + '" name="nExist[' + c + ']" type="text" style="width: 50px; height: 28px" value="'+existencias+'" disabled /> <input id="idMed' + c + '" name="idMed[' + c + ']" type="hidden" value="'+medId+'" /> <input id="nSal' + c + '" name="nSal[' + c + ']" type="hidden" value="'+salN+'" /> </td> ';
			  fila = fila + '<td><button type="button" name="remove" id="' + c + '" class="btn btn-danger btn_remove">Quitar</button></td> </tr>';
		  	  //'<tr id="row' + i + '"><td>indicacion + '</td><td>' + cantidad + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
			  $('#ProSelected').append(fila);
			  $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
			  var nFilas = $("#mytable tr").length;
			  $("#adicionados").append(nFilas - 1);
			  //le resto 1 para no contar la fila del header
			  document.getElementById("service").value = "";
			  document.getElementById("indicacion").value = "";
			  document.getElementById("service").focus();
		  });
		  
		$(document).on('click', '.btn_remove', function() {
		  var button_id = $(this).attr("id");
		    //cuando da click obtenemos el id del boton
		    //$('#row' + button_id + '').remove(); //borra la fila
		    $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
            if ($('#ProSelected tr.item').length == 0)
                $('#ProSelected .no-item').slideDown(300);

		    //limpia el para que vuelva a contar las filas de la tabla
		    $("#adicionados").text("");
		    var nFilas = $("#mytable tr").length;
		    $("#adicionados").append(nFilas - 1);
		  });
		});
		
		function creaArr(){
			var ip = [];
			var ip2 = [];
			var ip3 = [];
			var ip4 = [];
			var ip5 = [];
			
			$('input[name^="nMedicamento"]').each(function() {
		   	 //alert($(this).val());
		   	 ip.push({ medicamentoI : $(this).val().trim() });
			});
			
			var ipt=JSON.stringify(ip);
			$('#ListaPro').val(encodeURIComponent(ipt));
        	//document.getElementById("valores").innerHTML = ipt;
        	
			$('input[name^="idMed"]').each(function() {
		   	 //alert($(this).val());
		   	 ip2.push({ medI : $(this).val() });
			});
			
			var ipt2=JSON.stringify(ip2);
			$('#ListaPro2').val(encodeURIComponent(ipt2));
        	//document.getElementById("valores").innerHTML = ipt;
			
			$('textarea').each(function() {//indicacion textarea nIndicacion
		   	 //alert($(this).val());
		   	 ip3.push({ nameI : $(this).val() });
			});
			
			var ipt3=JSON.stringify(ip3);
			$('#ListaPro3').val(encodeURIComponent(ipt3));
			
			$('input[name^="nSal"]').each(function() {
		   	 //alert($(this).val());
		   	 ip4.push({ salI : $(this).val() });
			});
			
			var ipt4=JSON.stringify(ip4);
			$('#ListaPro4').val(encodeURIComponent(ipt4));
			
			$('input[name^="nExist"]').each(function() {
		   	 //alert($(this).val());
		   	 ip5.push({ existI : $(this).val() });
			});
			
			var ipt5=JSON.stringify(ip5);
			$('#ListaPro5').val(encodeURIComponent(ipt5));
		}
			
		var id = "";
		$(document).ready(function(e) {
			//Al escribr dentro del input con id="service"
			//$('#service').keypress(function(){
			//$('#service').on('keydown', (function(){
			//$('#service').keydown(function(){
			//$('#service').keyup(function(){
			$('#service').bind('input keyup', function(){
				//Obtenemos el value del input
				var service = $(this).val();
				var dataString0 = 'service='+service;
				var n = dataString0.length;
				if(n > 11){
					var dataString = dataString0;
				} else {
					var dataString = 'service=" "';
				}
				//Le pasamos el valor del input al ajax
				$.ajax({
					type: "POST",
					url: "autocomplete.php",
					data: dataString,
					//Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
					//async: false,
					success: function(data){
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions').fadeIn(1000).html(data);
						//$('#suggestions')
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id = $(this).attr('id'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medicamento
							var sal = $(this).attr('sal'); //Nombre de la Sal
							var exist = $(this).attr('exist');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							$('#service').val(valor);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions').fadeOut(100);
							//$('#result').html('<p>Has seleccionado el '+id+' '+$('#'+id).attr('data')+'</p>');
							//Add valor del id del elemento seleccionado
							$('#idMed').val(id);
							$('#sal').val(sal);
							$('#exist').val(exist);
						});
					}
				});
			});
		});

</script>
