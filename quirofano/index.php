

<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Formulario De Registro de Pacientes</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
	<link href="../css/bootstrap.min.css" rel="stylesheet" >
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	

	<style type="text/css">
		.auto-style1 {
			font-size: medium;
		}
		.auto-style2 {
			font-size: small;
		}
		.auto-style3 {
			text-align: center;
		}
		.autoStyle4 {
			color: #FF0000;
			font-size: medium;
		}
		.suggest-element {
			width:100%;
			cursor:pointer;
			background-color: #ECECEC;
		    margin-top: 1px;
		    padding-bottom: 5px;
		    padding: 5px;
			float:left;
		}
		
		.suggest-element:hover {
			background-color:#999999;
			color:#FFFFFF;
		}
		
		#suggestions {
			width:425px;
			height:165px;
			overflow: auto;
		}
		
		#suggestions .item{
		    float: left;
		    width: 396px;
		}
		
		#suggestions1 {
			width:425px;
			height:165px;
			overflow: auto;
		}
		
		#suggestions1 .item{
		    float: left;
		    width: 396px;
		}
		
		#result {
			background-color: #EDEDED;
		    clear: both;
		    color: #999999;
		    margin-bottom: 10px;
		    padding: 5px;
		    width: 500px;
		}
	</style>

<?php
	header('Content-Type: text/html;charset=utf-8');
	require "conexion.php";
	require_once('../conexion/funciones_db.php');
	
	$usuario1 = new FuncionesDB();
	
	$rol=NULL;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}

	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   #echo "Variable de session VACIA!!!!!";
	   header("location: index.php");
	}
	
	if(isset($_REQUEST['addCirugia']))
	{
		//recuperar las variables
		#$id=$_POST['id'];
		$fecha=$_POST['fecha'];
		$hora=$_POST['hora'];
		
		$tipoCir=$_POST['tipoCir'];
		$costeador=$_POST['costeador'];
		$sala=$_POST['sala'];
		$tiempoHr=$_POST['tiempoHr'];
		$tiempoMin=$_POST['tiempoMin'];
		$autorizo=utf8_decode($_POST['autorizo']);
		$descorcheTxt=$_POST['descorcheTxt'];
		
		if(isset ($_POST['transope'])){
			$transope= $_POST['transope'];
		}else {
			$transope= NULL;
		}
		
		$patologo=$_POST['patologo'];
		$tamano=$_POST['tamano'];
		$telCirujano=$_POST['telCirujano'];
		$emailCirujano=$_POST['emailCirujano'];
		$instrumentista=$_POST['instrumentista'];
		
		$enfermera=$_POST['enfermera'];
		$nombre=$_POST['nombrePaciente'];
		$edad=$_POST['edad'];
		$diagnostico=$_POST['diagnostico'];
		$cirugia=$_POST['cirugia'];
		//$instrumental=$_POST['instrumental'];
		$equipo=$_POST['equipo'];
		$descorche=$_POST['descorche'];
		$imagen=$_POST['imagen'];
		$sangre=$_POST['sangre'];
		$patologias=$_POST['patologias'];
		$cirujano=$_POST['cirujano'];
		$ayudante=$_POST['ayudante'];
		$pediatra=$_POST['pediatra'];
		$anestesiologo=$_POST['anestesiologo'];
		$nombrePrograma=$_POST['nombrePrograma'];
		$telPrograma=$_POST['telPrograma'];
		$emailPrograma=$_POST['emailPrograma'];
		$confirma=$_POST['confirma'];
		if($confirma == 'SI'){
			$confirma = '1'; //Confirmada
		} else {
			$confirma = '2'; //NO confirmada
		}
		
		
		#vamos a recibir los datos de material o equipo especial
		if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = urldecode($_POST['ListaPro']); //decodifico el JSON
			//echo 'LLEGOOOO: '.$acturl;
			if($acturl == '[]'){
	        	$acturl = NULL;
	        }
	        $productos = json_decode($acturl, true);
        	//$separado1 = implode(",", $productos);
        	//var_dump($productos);
	        //echo 'FINAL1: '.$separado1;
	        /*foreach ($productos  as $pro) {
	        	echo ' DENTRO: '.$pro->idInst;
	            $misProductos = array('nombre['.$n++.']' => $pro->idInst);
	        }*/
        }
        
        if(isset ($_POST['ListaPro2']) && $_POST['ListaPro2'] != NULL){
			$acturl2 = urldecode($_POST['ListaPro2']); //decodifico el JSON
			//echo 'LLEGOOOO2: '.$acturl2;
			if($acturl2 == '[]'){
	        	$acturl2 = NULL;
	        }
	        $productos2 = json_decode($acturl2, true);
        	//$separado2 = implode(",", $productos2);
        	//var_dump($productos2);
	        //echo 'FINAL2: '.$separado2;
	
	        /*foreach ($productos2  as $pro2) {
	        	echo ' DENTRO2: '.$pro2->cantidad;
	            $misProductos2 = array('cantidad['.$c++.']' => $pro2->cantidad);
	        }*/
        }
		
		//Query para validar si no esta ocupada la Sala en la fecha y hora seleccionada
		require "eliminar/conexion.php";
		$sqlValida = "SELECT * FROM programaCirugia WHERE idSala='$sala' AND '$fecha'=fecha AND '$hora' BETWEEN hrInicio AND hrFin";
		$resultado=$mysqli->query($sqlValida);
		
		if($resultado->num_rows > 0){
				echo "<br/><strong><p class='autoStyle4'>LA SALA ESTA OCUPADA EN LA FECHA Y HORA SELECCIONADAS, FAVOR DE SELECCIONAR OTRA HORA U OTRA SALA </p></strong><br>";
		} else {
			//hacemos la sentencia de sql para guardar la cirugia
			$sqlDN = "INSERT INTO datosnuevos (id, fecha, hora, enfermera, nombrePaciente, edad, diagnostico, cirugia, equipo, descorche, imagen, sangre, patologias, cirujano, 
											ayudante, pediatra, anestesiologo, tipoDeCirugia, costeador, sala, tiempoHr, tiempoMin, autorizo, descorcheTxt, transPosOperatorio, 
											patologo, tamano, telCirujano, emailCirujano, instrumentista, materialEsp, cantidadMaterialEsp, nombrePrograma,
											telPrograma, correoPrograma, estatusCirugia)
				 VALUES (NULL, '$fecha', '$hora', '$enfermera', '$nombre', '$edad', '$diagnostico', '$cirugia', '$equipo', '$descorche', '$imagen', '$sangre', '$patologias', 
						 '$cirujano', '$ayudante', '$pediatra', '$anestesiologo', '$tipoCir', '$costeador', '$sala', '$tiempoHr', '$tiempoMin', '$autorizo', '$descorcheTxt', '$transope', 
						 '$patologo', '$tamano', '$telCirujano', '$emailCirujano', '$instrumentista', '$acturl', '$acturl2', '$nombrePrograma',
						 '$telPrograma', '$emailPrograma', '$confirma')";
		 								   
			//ejecutamos la sentencia de sqlDN
			if ($conn->query($sqlDN)==true) {
				#Sacamos el id anteriormente guardado
				$sqlMax = "SELECT MAX(id) AS maximo FROM datosnuevos LIMIT 1";
				
				$resultadoMax=$mysqli->query($sqlMax);
				while($row=$resultadoMax->fetch_assoc()){
					$idCirugia = $row['maximo'];
					#echo $sqlMax."<br>";
					#echo "idCirugia: ".$idCirugia."<br>";
				}
				//Guardamos el dato del urs que programo la cirugia
				$sqlExtra = "INSERT INTO extras (id,  usrAlta, idcirugia)
				 VALUES (NULL, '$rol', '$idCirugia')";
				//ejecutamos la sentencia de sqlExtra
				if ($conn->query($sqlExtra)==true) {
					echo '<br><strong>!!!! SE INSERTARON LOS DATOS EXTRA CORRECTAMENTE !!!!</strong><br>';
					$sqlMaxExt = "SELECT MAX(id) AS maximo FROM extras LIMIT 1";
				
					$resultadoMaxExt=$mysqli->query($sqlMaxExt);
					while($row=$resultadoMaxExt->fetch_assoc()){
						$idExtr = $row['maximo'];
					}
					$sqlDNExt = "UPDATE datosnuevos SET datosExtra='$idExtr' WHERE id='$idCirugia'";
					$resultadoExt=$mysqli->query($sqlDNExt);
						if($resultadoExt > 0){
							echo " <br><strong>Se actualizo dato Extra de Cirugía correctamente </strong>";
						} else {
							echo "<br><strong>Error al actualizar Dato Extra de Cirugía</strong>";
						}
				} else {
					echo '<br><strong>!!!! ERROR AL INSERTAR LOS DATOS EXTRA !!!!</strong><br>';
				}
				#sacamos los datos para la suma de horas y minutos
				$hr=$tiempoHr;
				$min=$tiempoMin;
				$hrFin= $hr.':'.$min;

				#sacamos la hora final sumandole horas y minutos a la hr inicial
				$sqlHrFin= "SELECT ADDTIME(hora, '$hrFin') AS horaFin FROM datosnuevos WHERE id='$idCirugia' LIMIT 1";
				$resultadoHr=$mysqli->query($sqlHrFin);
				while($row1=$resultadoHr->fetch_assoc()){
					$hrFinal= $row1['horaFin'];
					#echo $sqlHrFin."<br>";
					#echo "HrFinal: ".$hrFinal."<br>";
				}
				#$hrFinal = $resultadoHr->fetch_array(MYSQLI_ASSOC);
				
				
				#Insertamos todos los datos para programacion de Cirugia
				$sqlPC = "INSERT INTO programaCirugia (id, idCirugia, idSala, fecha, hrInicio, hrFin)
								VALUES(NULL, '$idCirugia', '$sala', '$fecha', '$hora', '$hrFinal')";
								
				if ($conn->query($sqlPC)==true) {
					echo '<br><strong>!!!! SE INSERTARON LOS DATOS DE LA PROGRAMACIÓN CORRECTAMENTE!!!!</strong><br>';
				}else{
					echo '!!! Error Programación de Cirugía: '.$sqlPC.'<br>'.$conn->error;
				}
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LA CIRUGÍA CORRECTAMENTE !!!!</strong><br>';
			}else{
				echo '!!! Error Datos de Cirugía: '.$sqlDN.'<br>'.$conn->error;
			}$conn->close();
		}
	}
?>

	<script type="text/javascript">
		function mostrar0(v){
			if(v == '1'){
				document.getElementById('descorcheTxtVer').style="display:block";
				document.getElementById('autorizo').style="display:block";
			} else {
				document.getElementById('descorcheTxtVer').style="display:none";
				document.getElementById('autorizo').style="display:none";
			}
		}

		function mostrar(v){
			if(v == '1'){
				document.getElementById('transopeVer').style="display:block";
				document.getElementById('tamanoVer').style="display:block";
			} else {
				document.getElementById('transopeVer').style="display:none";
				document.getElementById('patologoVer').style="display:none";
				document.getElementById('tamanoVer').style="display:none";
			}
		}
		function mostrar1(v1){
			if(v1 == '1'){
				document.getElementById('patologoVer').style="display:block";
			} else {
				document.getElementById('patologoVer').style="display:none";
	
			}
		}
		function mostrar2(v1){
			if(v1 == '1'){
				document.getElementById('pediatraVer').style="display:block";
			} else {
				document.getElementById('pediatraVer').style="display:none";
	
			}
		}
		function mostrar3(v1){
			if(v1 == '1'){
				document.getElementById('instrumentistaVer').style="display:block";
			} else {
				document.getElementById('instrumentistaVer').style="display:none";
			}
		}
		function creaArr(){
			var ip = [];
			var ip2 = [];
			$('input[name^="nInstrumento"]').each(function() {
		   	 //alert($(this).val());
		   	 ip.push({ idInst : $(this).val().trim() });
			});
			
			var ipt=JSON.stringify(ip);
			$('#ListaPro').val(encodeURIComponent(ipt));
        	//document.getElementById("valores").innerHTML = ipt;
        	
			$('input[name^="nCantidad"]').each(function() {
		   	 //alert($(this).val());
		   	 ip2.push({ cantidad : $(this).val() });
			});
			
			var ipt2=JSON.stringify(ip2);
			$('#ListaPro2').val(encodeURIComponent(ipt2));
        	//document.getElementById("valores").innerHTML = ipt;
		}
	</script>
	
	<script type="text/javascript">
		var c=0;//contador para asignar id al boton que borrara la fila
		    	
		 $(document).ready(function() {
			//obtenemos el valor de los input
			$('#adicionar').click(function() {
			  var instrumental = document.getElementById("instrumental").value;
			  instrumental = instrumental.trim();
			  //var cantidad = document.getElementById("cantidad").value;
			  //var i = 1; //contador para asignar id al boton que borrara la fila
			  c++;
			  //var fila = '<tr>';
			  var fila = '<tr class="item"> <td><input id="nInstrumento' + c + '" name="nInstrumento[' + c + ']" type="text" value="'+instrumental+'" disabled /></td> ';
			  fila = fila + '<td> <input id="nCantidad[' + c + ']" name="nCantidad[' + c + ']" type="text" style="width:30px;" value="" /></td>';
			  fila = fila + '<td><button type="button" name="remove" id="' + c + '" class="btn btn-danger btn_remove">Quitar</button></td> </tr>';
		  	  //'<tr id="row' + i + '"><td>instrumental + '</td><td>' + cantidad + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
			  $('#ProSelected').append(fila);		  			  
			  $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
			  var nFilas = $("#mytable tr").length;
			  $("#adicionados").append(nFilas - 1);
			  //le resto 1 para no contar la fila del header
			  //document.getElementById("cantidad").value = "";
			  document.getElementById("instrumental").value = "";
			  document.getElementById("instrumental").focus();
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
		
		//Funcion para autocomplementar el material de Laboratorio
		var id = "";
		  $(document).ready(function(e) {
			//Al escribr dentro del input con id="service"
			//$('#service').keypress(function(){
			//$('#service').on('keydown', (function(){
			//$('#service').keydown(function(){
			//$('#service').keyup(function(){
			$('#instrumental').bind('input keyup', function(){
				//Obtenemos el value del input
				var instrumental = $(this).val();
				var dataString = 'instrumental='+instrumental;
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "autocompleteMat.php",
		            data: dataString,
		            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
		            //async: false,
		            success: function(data) {
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions').fadeIn(1000).html(data);
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id = $(this).attr('id'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medicamento
							//var sal = $(this).attr('sal'); //Nombre de la Sal
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							$('#instrumental').val(valor);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions').fadeOut(1000);
							//$('#result').html('<p>Has seleccionado el '+id+' '+$('#'+id).attr('data')+'</p>');
							//Add valor del id del elemento seleccionado
							$('#idMed').val(id);
							//$('#sal').val(sal);
							//$('#idSal').val(idSal);
						});
		            }
		        });
		    });
		});
		
		//Funcion para autocomplementar los cirujanos
		var id1 = "";
		  $(document).ready(function(e) {
			$('#cirujano').bind('input keyup', function(){
				//Obtenemos el value del input
				var cirujano = $(this).val();
				var dataString = 'cirujano='+cirujano;
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "autocompleteMat.php",
		            data: dataString,
		            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
		            //async: false,
		            success: function(data) {
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions1').fadeIn(1000).html(data);
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id1 = $(this).attr('id1'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medico
							var tel = $(this).attr('tel'); //Nombre de la Sal
							var email = $(this).attr('email');
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							valor = valor.trim();
							$('#cirujano').val(valor);
							$('#telCirujano').val(tel);
							$('#emailCirujano').val(email);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions1').fadeOut(1000);
							//Add valor del id del elemento seleccionado
							$('#idMedic').val(id1);
						});
		            }
		        });
		    });
		});
	</script>
	</head>
	<body background="../img/logoNew2Agua.jpg">
		<div class="form" style="width: 900px">
			<div align="center"><img alt="logoHD" src="../img/logoNew.jpg" height="100"></div>
			<div class="bg-info">
			<form action="" method="post">
				<!--p>ID</p>
				<label for="id">ID de Cirugía</label>
				<br>
				<input class="box" type="text" name="id" placeholder="id"-->
				<!--p id="valores"></p-->
				<p class="auto-style3">Registro de Cirugías</p>
				<p class="auto-style1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp; Hora*</strong></p>
				
				<label for="fecha"><span class="auto-style2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				Fecha de Cirugía</span></label>
				<label for="hora">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="auto-style2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hora de Cirugía</span></label>
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;
				
				<input class="box" type="date" name="fecha" required style="width: 148px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
				
				<input class="box" type="time" name="hora" required style="width: 136px">
				
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Sala de Operaciones*</p>
					<select class="form-control" id="sala" name="sala" style="width:230px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="1"> SALA 1 </option>
				   		<option value="2"> SALA 2 </option>
				   		<option value="3"> SALA 3 </option>
				   		<option value="4"> SALA DE EXPULSIÓN </option>
					</select><br>&nbsp;&nbsp;&nbsp;
				<a class="btn btn-info" href="salasDisp.php?rol=<?php echo $rol ?>" target="_blank">Disponibilidad de Salas</a>
				
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Tipo de Cirugía*</p>
					<select class="form-control" id="tipoCir" name="tipoCir" style="width:230px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="PROGRAMADA"> PROGRAMADA </option>
				   		<option value="URGENCIA"> URGENCIA </option>
					</select>
				
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Costeador*</p>
					<select class="form-control" id="costeador" name="costeador" style="width:200px; height:40px" required >
				        <option value="">Seleccionar</option>
				        <option value="ASEGURADORA "> ASEGURADORA </option>
				   		<option value="PARTICULAR "> PARTICULAR </option>
						<option value="SE DESCONOCE "> SE DESCONOCE </option>
					</select>

				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Tiempo Quirúrgico Aproximado*</p>
				<input class="box" type="number" name="tiempoHr" style="width: 50px" min="0" max="10" value="0" > Horas&nbsp;&nbsp;&nbsp;
				<input class="box" type="number" name="tiempoMin" style="width: 50px" min="0" max="59" value="0" > Minutos
				
				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Enfermera(o) que Programa Cirugía*</p>
				<!--label for="nombre">Nombre del Paciente</label>
				<br-->
				<input class="form-control" type="text" name="enfermera" placeholder="Nombre Enf." required>

				<p>&nbsp;</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Nombre del Paciente*</p>
				<input class="form-control" type="text" name="nombrePaciente" placeholder="Nombre y Apellidos" autocomplete="off" required>
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Edad del Paciente(Opcional)</p>
				<input class="form-control" type="number" name="edad" style="width: 60px"> 
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Diagnóstico Preoperatorio*</p>
				<input class="form-control" type="text" name="diagnostico" placeholder="Diagnóstico" autocomplete="off" required>
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Cirugía a Realizar*</p>
				<input class="form-control" type="text" name="cirugia" placeholder="Cirugía a realizar" autocomplete="off" required>
				
				<!--div class="container"-->
				  <!--form-->
				  	<div class="form-group">
						&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Instrumental o Material Especial (Opcional)</p>
						<input class="form-control" id="instrumental" type="text" name="instrumental" style="background-color:#9EE5D7" accept-charset="utf-8" autocomplete="off">
						<br>
						<div id="suggestions"></div>
						&nbsp;<!--p>Cantidad(Solo si se llena el campo anterior)</p>
						<input class="form-control" id="cantidad" type="text" name="cantidad" >
						<br-->
						<button id="adicionar" class="btn btn-success" type="button">Agregar Material Especial</button>
					</div>
				<!--/form-->
				
				<p>Material Especial Agregado:
				  <div id="adicionados"></div>
				</p>
				<table  id="mytable" class="table table-bordered table-hover ">
				<thead>
					<tr>
						<th>Nombre</th>
					    <th>Cantidad</th>
					    <th>Eliminar</th>
					</tr>
				  </thead>
				  <tbody id="ProSelected"><!--Ingreso un id al tbody-->
                  <!--tr>
             		<td><input id="var1" type="text" name="variable1[]" value=""></td>
             		<td><input id="var2" type="text" name="variable2[]" value=""></td>
                </tr-->
            	</tbody>
				</table>
				
				<!--/div-->
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Equipo (Opcional)</p>
				<input class="form-control" type="text" name="equipo" autocomplete="off">
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Descorche*</p>
				SI
				<input type="radio" id="descorche" name="descorche" onclick="mostrar0('1')" value="SI" required style="width: 20px; height: 20px">&nbsp;
				NO <input type="radio" id="descorche" name="descorche" onclick="mostrar0('2')" value="NO" required style="width: 20px; height: 20px">
				<br>
				&nbsp;&nbsp;<p id="descorcheTxtVer" style="display:none">Descorche sobre
					<textarea class="form-control" name="descorcheTxt" id="descorcheTxt" cols="5" rows="2"></textarea>
				</p>
				<br>
				<div id="autorizo" style="display:none">
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Autorizó</p>
					<select class="form-control" id="autorizo" name="autorizo" style="width:330px; height:40px" >
				        <option value="">Seleccionar</option>
				        <option value="<?php echo utf8_encode("Dr. Juan Augusto Miranda Avilés") ?>">  Dr. Juan Augusto Miranda Avilés </option>
				   		<option value="<?php echo utf8_encode("Dr. Fernando Carreño De La Rosa") ?>" > Dr. Fernando Carreño De La Rosa </option>
					</select>
				</div>
				<br>

				<p>&nbsp;&nbsp;&nbsp;&nbsp;Imagenología (Opcional)</p>
				<input class="form-control" type="text" name="imagen" autocomplete="off">
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Reserva de Sangre (Opcional)</p>
				<input class="form-control" type="text" name="sangre" autocomplete="off" >
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Muestra de Patologías*</p>
				SI <input type="radio" id="patologias" onclick="mostrar('1')" name="patologias" value="SI" required style="width: 20px; height: 20px">&nbsp;
				NO <input type="radio" id="patologias" onclick="mostrar('2')" name="patologias" value="NO" required style="width: 20px; height: 20px"><br>&nbsp;&nbsp;<p id="transopeVer" style="display:none" >
					Transoperatorio<input type="radio" id="transope" onclick="mostrar1('1')" name="transope" value="Transoperatorio" style="width: 20px; height: 20px">&nbsp;
					Postoperatorio<input type="radio" id="transope" onclick="mostrar1('2')" name="transope" value="Postoperatorio" style="width: 20px; height: 20px">
				</p>
				
				&nbsp;<p id="patologoVer" style="display:none" >&nbsp;&nbsp;&nbsp;&nbsp;Patólogo
					<input class="form-control" type="text" id="patologo" name="patologo" placeholder="Nombre y Apellidos" >
				</p>
				
				&nbsp;<p id="tamanoVer" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;Tamaño de la muestra
					<select class="form-control" id="tamano" name="tamano" style="width:230px; height:40px" >
				        <option value="">Seleccionar</option>
				        <option value="CHICO">  CHICO </option>
				   		<option value="MEDIANO"> MEDIANO </option>
						<option value="GRANDE"> GRANDE </option>
						<option value="EXTRA GRANDE"> EXTRA GRANDE </option>
					</select>
					</p>
				<br>
				<div class="form-group">
						&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Médico Cirujano*</p>
						<input class="form-control" id="cirujano" type="text" name="cirujano" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Nombre y Apellidos" autocomplete="off" required>
						<br>
						<div id="suggestions1"></div>
					</div>
				<!--p>&nbsp;&nbsp;&nbsp;&nbsp;Médico Cirujano*</p>
				<input class="form-control" type="text" name="cirujano" placeholder="Nombre y Apellidos" required-->
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Teléfono del Médico Cirujano (Opcional)</p>
				<input class="form-control" type="text" id="telCirujano" name="telCirujano" autocomplete="off" >
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;E-mail del Médico Cirujano (Opcional)</p>
				<input class="form-control" type="email" id="emailCirujano" name="emailCirujano" >
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Médico Ayudante (Opcional)</p>
				<input class="form-control" type="text" name="ayudante" placeholder="Nombre y Apellidos">
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Médico Anestesiólogo*</p>
				<input class="form-control" type="text" name="anestesiologo" required placeholder="Nombre y Apellidos">
				
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Médico Pediatra*</p>
					SI <input type="radio" id="pediatra1" onclick="mostrar2('1')" name="pediatra1" value="SI" required style="width: 20px; height: 20px">&nbsp;
					NO <input type="radio" id="pediatra1" onclick="mostrar2('2')" name="pediatra1" value="NO" required style="width: 20px; height: 20px">
				
				&nbsp;<p id="pediatraVer" style="display:none" >
					<input class="form-control" type="text" name="pediatra" placeholder="Nombre y Apellidos">
				</p>
				
				<br>&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Enfermera(o) Instrumentista*</p>
					SI <input type="radio" id="instrumentista1" onclick="mostrar3('1')" name="instrumentista1" value="SI" required style="width: 20px; height: 20px">&nbsp;
					NO <input type="radio" id="instrumentista1" onclick="mostrar3('2')" name="instrumentista1" value="NO" required style="width: 20px; height: 20px">
				
				&nbsp;<p id="instrumentistaVer" style="display:none" >
					<input class="form-control" type="text" name="instrumentista" placeholder="Nombre y Apellidos">
				</p>
				<br>
				&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Quien Programa Cirugía (Opcional)</p>
				<input class="form-control" type="text" name="nombrePrograma"  placeholder="Nombre y Apellidos">
				<input class="form-control" type="text" name="telPrograma"  placeholder="Teléfono">
				<input class="form-control" type="text" name="emailPrograma"  placeholder="Correo">
				
				<!--&nbsp;<p>Nombre de Quien Proporciono Datos (Opcional)</p>
				<input class="box" type="text" name="proporciono" placeholder="Nombre y Apellidos" -->
				<br>
				<br>&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;Se confirma cirugía*</p>
					SI <input type="radio" id="confirma" name="confirma" value="SI" required style="width: 20px; height: 20px">&nbsp;
					NO <input type="radio" id="confirma" name="confirma" value="NO" required style="width: 20px; height: 20px">
				<br>
				<br>
				<br>
				<input type="hidden" id="ListaPro" name="ListaPro" value="" >
				<input type="hidden" id="ListaPro2" name="ListaPro2" value="" >
				<input type="hidden" name="rol" value="<?php echo $rol ?>" >
				<input class="btn btn-success" onclick="creaArr();" type="submit" name="addCirugia" value="Guardar Información" >
				<br>
				<br>
			</form>
			</div>
		<br>
				<br>
				<a class="btn btn-primary" style="width: 187px; height: 44px" href="../quirofano/eliminar/index.php?rol=<?php echo $rol ?>" target="_blank">Modificar/Cancelar Cirugía</a>
		<br>
				<br>
			<input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >
		</div>
	</body>
</html>