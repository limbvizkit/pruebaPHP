<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Ver_Modificar</title>

<!-- en html5 no necesitas indicar el cierre de la etiqueta -->
<style type="text/css">
/* Datagrid */
	body {
  	text-align: center;
    	background-color: #E8F0FE;
    	font-family: Helvetica,Arial,sans-serif;
    }
	table {
	  border-collapse: collapse;
	  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	}
	th, td {
	  padding: 0.25rem;
	  text-align: center;
	}
	tbody tr:nth-child(odd) {
	  background: #eee;
	  width: 40px;
	}
	.centro{
	  padding: 0.5rem;
	  background: #4285F4 ;
	  color: white;
	  text-align: center;
	  font-size: 21px;
	
	}
	#cuadro{
		width: 90%;
		background: #F8F8F8 ;
		padding: 25px;
		margin: 5px auto;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	}
	#titulo{
		width: 100%;
		background: #4285F4;
		color:white;
	
	}
	.autoStyle4 {
			color: #FF0000;
			font-size: medium;
	}
	.suggest-element:hover {
		background-color:#999999;
		color:#FFFFFF;
	}

	#suggestions {
		width:475px;
		height:165px;
		overflow: auto;
		
	}

	#suggestions .item{
		float: left;
		width: 470px;
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
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php 
	
	require('conexion.php');
	
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}

	
	if(isset ($_GET['id'])){
		$id= $_GET['id'];
	}else {
		$id= NULL;
	}
		
	//Cuando se mandan actualizar los datos con el boton de Guardar
	if(isset($_REQUEST['enviarQx']))
	{
		require('../conexion.php');

		if(isset ($_POST['id'])){
			$id= $_POST['id'];
		}else {
			$id= NULL;
		}

		if(isset ($_POST['diaQx'])){
			$fecha= $_POST['diaQx'];
		}else {
			$fecha= NULL;
		}
		
		if(isset ($_POST['hrQx'])){
			$hora= $_POST['hrQx'];
		}else {
			$hora= NULL;
		}
		if(isset ($_POST['enfermeraQx'])){
			$enfermeraQx= $_POST['enfermeraQx'];
		}else {
			$enfermeraQx= NULL;
		}
		if(isset ($_POST['nompQx'])){
			$nombre= $_POST['nompQx'];
		}else {
			$nombre= NULL;
		}
		if(isset ($_POST['edadQx'])){
			$edad= $_POST['edadQx'];
		}else {
			$edad= NULL;
		}
		if(isset ($_POST['diagQx'])){
			$diagnostico= $_POST['diagQx'];
		}else {
			$diagnostico= NULL;
		}
		if(isset ($_POST['cirgQx'])){
			$cirugia= $_POST['cirgQx'];
		}else {
			$cirugia= NULL;
		}
		/*if(isset ($_POST['instrQx'])){
			$instrumental= $_POST['instrQx'];
		}else {
			$instrumental= NULL;
		}*/
		if(isset ($_POST['eqQx'])){
			$equipo= $_POST['eqQx'];
		}else {
			$equipo= NULL;
		}
		if(isset ($_POST['descoQx'])){
			$descorche= $_POST['descoQx'];
		}else {
			$descorche= NULL;
		}
		if(isset ($_POST['imagenQx'])){
			$imagen= $_POST['imagenQx'];
		}else {
			$imagen= NULL;
		}
		if(isset ($_POST['sangreQx'])){
			$sangre= $_POST['sangreQx'];
		}else {
			$sangre= NULL;
		}
		if(isset ($_POST['patolQx'])){
			$patologias= $_POST['patolQx'];
		}else {
			$patologias= NULL;
		}
		if(isset ($_POST['cirugQx'])){
			$cirujano= $_POST['cirugQx'];
		}else {
			$cirujano= NULL;
		}
		if(isset ($_POST['ayudQx'])){
			$ayudante= $_POST['ayudQx'];
		}else {
			$ayudante= NULL;
		}
		if(isset ($_POST['pediatQx'])){
			$pediatra= $_POST['pediatQx'];
		}else {
			$pediatra= NULL;
		}
		if(isset ($_POST['anestQx'])){
			$anestesiologo= $_POST['anestQx'];
		}else {
			$anestesiologo= NULL;
		}
		/*if(isset ($_POST['realizoQx'])){
			$realizoQx= $_POST['realizoQx'];
		}else {
			$realizoQx= NULL;
		}*/
		///////////////
		if(isset ($_POST['tipoCirgQx'])){
			$tipoCirgQx= $_POST['tipoCirgQx'];
		}else {
			$tipoCirgQx= NULL;
		}
		if(isset ($_POST['costeadorQx'])){
			$costeadorQx= $_POST['costeadorQx'];
		}else {
			$costeadorQx= NULL;
		}
		if(isset ($_POST['salaQx'])){
			$salaQx= $_POST['salaQx'];
		}else {
			$salaQx= NULL;
		}
		if(isset ($_POST['tiempoHrQx'])){
			$tiempoHrQx= $_POST['tiempoHrQx'];
		}else {
			$tiempoHrQx= NULL;
		}
		if(isset ($_POST['tiempoMinQx'])){
			$tiempoMinQx= $_POST['tiempoMinQx'];
		}else {
			$tiempoMinQx= NULL;
		}
		if(isset ($_POST['autorizoQx'])){
			$autorizoQx= $_POST['autorizoQx'];
		}else {
			$autorizoQx= NULL;
		}
		if(isset ($_POST['descorcheTxtQx'])){
			$descorcheTxtQx= $_POST['descorcheTxtQx'];
		}else {
			$descorcheTxtQx= NULL;
		}
		if(isset ($_POST['transopeQx'])){
			$transopeQx= $_POST['transopeQx'];
		}else {
			$transopeQx= NULL;
		}
		if(isset ($_POST['patologoQx'])){
			$patologoQx= $_POST['patologoQx'];
		}else {
			$patologoQx= NULL;
		}
		if(isset ($_POST['tamanoQx'])){
			$tamanoQx= $_POST['tamanoQx'];
		}else {
			$tamanoQx= NULL;
		}
		if(isset ($_POST['telCirujanoQx'])){
			$telCirujanoQx= $_POST['telCirujanoQx'];
		}else {
			$telCirujanoQx= NULL;
		}
		if(isset ($_POST['emailCirujanoQx'])){
			$emailCirujanoQx= $_POST['emailCirujanoQx'];
		}else {
			$emailCirujanoQx= NULL;
		}
		if(isset ($_POST['instrumentistaQx'])){
			$instrumentistaQx= $_POST['instrumentistaQx'];
		}else {
			$instrumentistaQx= NULL;
		}
		if(isset ($_POST['nombProgQx'])){
			$nombProgQx= $_POST['nombProgQx'];
		}else {
			$nombProgQx= NULL;
		}
		if(isset ($_POST['telProgQx'])){
			$telProgQx= $_POST['telProgQx'];
		}else {
			$telProgQx= NULL;
		}
		if(isset ($_POST['emailProgQx'])){
			$emailProgQx = $_POST['emailProgQx'];
		}else {
			$emailProgQx = NULL;
		}
		if(isset ($_POST['diferirQx'])){
			$diferirQx = $_POST['diferirQx'];
		}else {
			$diferirQx= NULL;
		}
		if(isset ($_POST['fechaDiferirQx'])){ 
			$fechaDiferirQx = $_POST['fechaDiferirQx'];
		}else {
			$fechaDiferirQx = NULL;
		}
		
		if($diferirQx == 'SI'){
			$diferidos = ",diferida='$diferirQx', fechaOriginal='$fecha'";
			$fechaFinal = $fechaDiferirQx;
		} else {
			$diferidos = "";
			$fechaFinal = $fecha;
		}
		
		#vamos a recibir los datos de material o equipo especial
		if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = urldecode($_POST['ListaPro']); //decodifico el JSON
			if($acturl == '[]'){
	        	$acturl = NULL;
	        }
	        $productos = json_decode($acturl, true);
        }
        
        if(isset ($_POST['ListaPro2']) && $_POST['ListaPro2'] != NULL){
			$acturl2 = urldecode($_POST['ListaPro2']); //decodifico el JSON
			if($acturl2 == '[]'){
	        	$acturl2 = NULL;
	        }
	        $productos2 = json_decode($acturl2, true);
        }
		
		//Query para validar si no esta ocupada la Sala en la fecha y hora seleccionada
		/*$sqlValida = "SELECT * FROM programaparto WHERE idSala='$salaQx' AND '$fechaFinal'=fecha AND '$hora' BETWEEN hrInicio AND hrFin AND idCirugia != '$id'";
		$resultado = $mysqli->query($sqlValida);
		
		if($resultado->num_rows > 0){
				echo "<br/><strong><p class='autoStyle4'> LA SALA ESTA OCUPADA EN LA FECHA Y HORA SELECCIONADAS, FAVOR DE SELECCIONAR OTRA HORA U OTRA SALA </p></strong><br>";
		} else {*/
			//Sacamos los datos como estan Actualmente
			$queryDts="SELECT * FROM datosnuevosparto WHERE id='$id'";

			$resultado1=$mysqli->query($queryDts);
			while($row = mysqli_fetch_array($resultado1)){
				$enfermera0 = utf8_encode($row['enfermera']);
				$nombrePaciente0 = utf8_encode($row['nombrePaciente']);
				$diagnostico0 = utf8_encode($row['diagnostico']);
				$cirugia0 = utf8_encode($row['cirugia']);
				$equipo0 = utf8_encode($row['equipo']);
				$imagen0 =  utf8_encode($row['imagen']);
				$sangre0 = utf8_encode($row['sangre']);
				$cirujano0 = utf8_encode($row['cirujano']);
				$ayudante0 = utf8_encode($row['ayudante']);
				$pediatra0 = utf8_encode($row['pediatra']);
				$anestesiologo0 = utf8_encode($row['anestesiologo']);
				$tipoDeCirugia0 = utf8_encode($row['tipoDeCirugia']);
				$autorizo0 = utf8_encode($row['autorizo']);
				$descorcheTxt0 = utf8_encode($row['descorcheTxt']);
				$patologo0 = utf8_encode($row['patologo']);
				$instrumentista0 = utf8_encode($row['instrumentista']);
				$materialEsp0 = utf8_encode($row['materialEsp']);
				$nombrePrograma0 = utf8_encode($row['nombrePrograma']);
				
				//Insertamos TODOS los datos en el log para ver como estaba antes y como quedo despues
				$sqlDN = "INSERT INTO logparto (id, idCirugia, fecha, hora, enfermera, nombrePaciente, edad, diagnostico, cirugia, equipo, descorche, imagen,
					sangre, patologias, cirujano, ayudante, pediatra, anestesiologo, tipoDeCirugia, costeador, sala, tiempoHr, tiempoMin, autorizo,
					descorcheTxt,transPosOperatorio, patologo, tamano, telCirujano, emailCirujano, instrumentista, materialEsp, cantidadMaterialEsp,
					nombrePrograma,telPrograma, correoPrograma, estatusCirugia, datosExtra, usrModifico)
					 VALUES (NULL, '$row[id]', '$row[fecha]', '$row[hora]', '$enfermera0', '$nombrePaciente0', '$row[edad]','$diagnostico0', '$cirugia0',
					 '$equipo0', '$row[descorche]', '$imagen0', '$sangre0', '$row[patologias]', '$cirujano0', '$ayudante0', '$pediatra0', 
					 '$anestesiologo0', '$tipoDeCirugia0', '$row[costeador]', '$row[sala]', '$row[tiempoHr]', '$row[tiempoMin]', '$autorizo0', 
					 '$descorcheTxt0', '$row[transPosOperatorio]', '$patologo0', '$row[tamano]', '$row[telCirujano]', '$row[emailCirujano]',
					 '$instrumentista0', '$materialEsp0', '$row[cantidadMaterialEsp]', '$nombrePrograma0', '$row[telPrograma]', '$row[correoPrograma]', 
					 '$row[estatusCirugia]', '$row[datosExtra]', '$rol')";
			}
			if ($conn->query($sqlDN)==true) {
				echo '<br><strong>Se agrego registro al LOG Correctamente</strong><br>';
			} else {
				echo 'ERROR QUERY LOG: '.$sqlDN;
			}
			
			
			//Actualizamos los datos con los nuevos datos modificados
			$sql = "UPDATE datosnuevosparto SET fecha = '$fechaFinal', hora = '$hora', enfermera= '$enfermeraQx', nombrePaciente = '$nombre', edad = '$edad',
					diagnostico = '$diagnostico', cirugia= '$tipoCirgQx',equipo = '$equipo', descorche = '$descorche', imagen = '$imagen', 
					sangre = '$sangre', patologias= '$patologias', cirujano= '$cirujano', ayudante= '$ayudante', pediatra= '$pediatra', 
					anestesiologo= '$anestesiologo', tipoDeCirugia= '$tipoCirgQx',costeador= '$costeadorQx',
					sala= '$salaQx',tiempoHr= '$tiempoHrQx',tiempoMin= '$tiempoMinQx',autorizo= '$autorizoQx', 
					descorcheTxt= '$descorcheTxtQx',transPosOperatorio= '$transopeQx',patologo= '$patologoQx',tamano= '$tamanoQx',
					telCirujano= '$telCirujanoQx', emailCirujano='$emailCirujanoQx',instrumentista= '$instrumentistaQx',materialEsp='$acturl' ,
					cantidadMaterialEsp='$acturl2',	nombrePrograma='$nombProgQx', telPrograma='$telProgQx', correoPrograma='$emailProgQx' $diferidos
					WHERE id = $id";
			
			//ejecutamos la sentencia de sql
			if ($conn->query($sql)==true) {
				#sacamos los datos para la suma de horas y minutos
					$hr=$tiempoHrQx;
					$min=$tiempoMinQx;
					$hrFin= $hr.':'.$min;
	
					#sacamos la hora final sumandole horas y minutos a la hr inicial
					$sqlHrFin= "SELECT ADDTIME(hora, '$hrFin') AS horaFin FROM datosnuevosparto WHERE id='$id' LIMIT 1";
					$resultadoHr=$mysqli->query($sqlHrFin);
					while($row1=$resultadoHr->fetch_assoc()){
						$hrFinal= $row1['horaFin'];
					}
					
					#Insertamos todos los datos para programacion de Cirugia
					/*$sqlPC = "UPDATE programaparto SET idSala = '$salaQx', fecha = '$fechaFinal', hrInicio='$hora', hrFin='$hrFinal' WHERE idCirugia='$id'";
					
					if ($conn->query($sqlPC)==true) {
						echo '<br><strong>!!!! SE ACTUALIZARON LOS DATOS DE LA PROGRAMACIÓN CORRECTAMENTE!!!!</strong><br>';
					}else{
						echo '!!! ERROR AL ACTUALIZAR LA PROGRAMACIÓN DE CIRUGÍA: '.$sqlPC.'<br>'.$conn->error;
					}*/
				
				echo '<br/><strong>!!!! SE ACTUALIZARON LOS DATOS DE LA CIRUGÍA CORRECTAMENTE!!!!</strong><br>';
				#echo 'Query: '.$sql;
			}else{
				echo "ERROR NO SE ACTUALIZARON LOS DATOS INFORMAR A SISTEMAS :<br>".$sql."<br>".$conn->error;
			}
			$conn->close();
		//}

	}
	
	$query="SELECT * FROM datosnuevosparto WHERE id='$id'";
	
	$resultado=$mysqli->query($query);
	
?>


<script type="text/javascript">
	function dsblqModifDss()
	{
		document.getElementById("diaQx").disabled=false;
		//document.getElementById("hrQx").disabled=false;
		document.getElementById("enfermeraQx").disabled=false;
		document.getElementById("nompQx").disabled=false;
		document.getElementById("edadQx").disabled=false;
		//document.getElementById("diagQx").disabled=false;
		//document.getElementById('cirgQx').disabled=false;
		//document.getElementById('instrumental').disabled=false;
		//document.getElementById('adicionar').disabled=false;
		//document.getElementById("eqQx").disabled=false;
		//document.getElementById("descoQx").disabled=false;
		//document.getElementById("imagenQx").disabled=false;
		//document.getElementById("sangreQx").disabled=false;
		//document.getElementById('patolQx').disabled=false;
		document.getElementById('cirugQx').disabled=false;
		//document.getElementById("ayudQx").disabled=false;
		//document.getElementById("pediatQx").disabled=false;
		//document.getElementById('anestQx').disabled=false;
		//document.getElementById('realizoQx').disabled=false;
		
		document.getElementById('tipoCirgQx').disabled=false;
		document.getElementById('costeadorQx').disabled=false;
		document.getElementById('salaQx').disabled=false;
		//document.getElementById('tiempoHrQx').disabled=false;
		//document.getElementById('tiempoMinQx').disabled=false;
		//document.getElementById('autorizoQx').disabled=false;
		//document.getElementById('descorcheTxtQx').disabled=false;
		//document.getElementById('transopeQx').disabled=false;
		//document.getElementById('patologoQx').disabled=false;
		//document.getElementById('tamanoQx').disabled=false;
		//document.getElementById('telCirujanoQx').disabled=false;
		//document.getElementById('emailCirujanoQx').disabled=false;
		//document.getElementById('instrumentistaQx').disabled=false;
		//document.getElementById('nombProgQx').disabled=false;
		//document.getElementById('telProgQx').disabled=false;
		//document.getElementById('emailProgQx').disabled=false;
		document.getElementById('diferirQx').disabled=false;
		document.getElementById('btGd').disabled=false;
	}
		
	var aplicacion = {
	    lista : null,	 
	    asignarFuncion : function() {
	        var valor = aplicacion.lista.value;
	 
	        if (valor === 'SI') {
	            document.getElementById('fechaDiferirQx').style="display:block";
	        } else {
	            document.getElementById('fechaDiferirQx').style="display:none";
	        }
	    },
	    
	    asignarEventos : function() {
	        aplicacion.lista.onchange = aplicacion.asignarFuncion;
	        aplicacion.asignarFuncion();
	    }
	};
	 
	window.onload = function() {
	    //aplicacion.campoTexto = document.getElementById('nom_clicon');
	    aplicacion.lista = document.getElementById('diferirQx');
	    aplicacion.asignarEventos();
	}
			
	function confirmSubmit()
	{
		var agree=confirm("¿Está seguro de eliminar este registro? !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
		 	return true;
		}else{
		 	return false;
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
		function confirmSubmit()
		{
			var agree=confirm("Recuerde que debe generar el formato antes de enviar el correo ¿Desea Continuar?");
			if (agree){
				return true;
			} else {
				return false;
			}
		}
</script>

<script type="text/javascript">
		var c=0;//contador para asignar id al boton que borrara la fila
		    	
		 $(document).ready(function() {
			//obtenemos el valor de los input
			$('#adicionar').click(function() {
			  var instrumental = document.getElementById("instrumental").value;
			  //var cantidad = document.getElementById("cantidad").value;
			  //var i = 1; //contador para asignar id al boton que borrara la fila
			  c++;
			  //var fila = '<tr>';
			  var fila = '<tr class="item"> <td><input id="nInstrumento' + c + '" name="nInstrumento[' + c + ']" type="text" style="width:350px;" value="'+instrumental+'" disabled /></td> ';
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
		
		var id = "";
		  $(document).ready(function(e) {
			$('#instrumental').bind('input keyup', function(){
				//Obtenemos el value del input
				var instrumental = $(this).val();
				var dataString = 'instrumental='+instrumental;
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "../autocompleteMat.php",
		            data: dataString,
		            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
		            success: function(data) {
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions').fadeIn(1000).html(data);
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id = $(this).attr('id'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medicamento
							$('#instrumental').val(valor);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions').fadeOut(1000);
							//Add valor del id del elemento seleccionado
							$('#idMed').val(id);
						});
		            }
		        });
		    });
		});
	</script>
	
	</head>
	<body>
	<div id="cuadro">
		<center><img src="../../img/logoNew2.jpg" width="200" height="200"/><br />
		<div id="titulo">
		<center><h1>Modificar Registro de PARTOS</h1></center>
		</div>
		
		<form method="post" action="verMas.php">
		<table class="table table-bordered">
			<thead>
				<tr class="centro">
				    <td>ID</td>
					<td>Fecha</td>
					<!--td>Hora</td-->
					<td>Tipo de Cirugía</td>
					<td>Costeador</td>
					<td>Lugar de la Operación</td>
					<!--td>Tiempo Aprox. de Cirugía</td-->
				</tr>
				</thead>
				<tbody>
					<?php while($row=$resultado->fetch_assoc()){ 
							$estatusCirugia0 = $row['estatusCirugia'];
					?>
						<tr>
							<td>
								<?php echo $row['id'];?>
							</td>
							<td>
								<input id="diaQx" name="diaQx" type="date" style="width:140px;" value="<?php echo $row['fecha'];?>" disabled />
								<?php 
									$fechaDoc = $row['fecha'];
								?>
							</td>
							<!--td>
								<input id="hrQx" name="hrQx" type="time" style="width:110px;" value="<?php #echo $row['hora'];?>" disabled />
								<?php 
									#$horaDoc = $row['hora'];
								?>
							</td-->
							<td>
								<select id="tipoCirgQx" name="tipoCirgQx" style="width:140px; height:40px" disabled>
							        <option value="<?php echo utf8_encode($row['tipoDeCirugia']);?>"><?php echo utf8_encode($row['tipoDeCirugia']);?></option>
							   		<option value="CESÁREA">CESÁREA</option>
									<option value="PARTO NATURAL">PARTO NATURAL</option>
								</select>
							</td>
							<td>
								<select id="costeadorQx" name="costeadorQx" style="width:140px; height:40px" disabled>
							        <option value="<?php echo $row['costeador'];?>"><?php echo utf8_encode($row['costeador']);?></option>
							   		<option value="ASEGURADORA "> ASEGURADORA </option>
				   					<option value="PARTICULAR "> PARTICULAR </option>
									<option value="SE DESCONOCE "> SE DESCONOCE </option>
				   				</select>
							</td>
							<td>
								<select id="salaQx" name="salaQx" style="width:200px; height:40px" required disabled>
							        <option value="<?php echo utf8_encode($row['sala']);?>"><?php echo utf8_encode($row['sala']);?></option>
							   		<option value="QUIRÓFANO"> QUIRÓFANO </option>
				   					<option value="HABITACIÓN"> HABITACIÓN </option>
				   				</select>
							</td>
							<!--td>
								<input id="tiempoHrQx" name="tiempoHrQx" type="number" style="width:40px;" min="0" max="10" value="<?php #echo $row['tiempoHr'];?>" disabled />Horas&nbsp;&nbsp;&nbsp;
								<input id="tiempoMinQx" name="tiempoMinQx" type="number" style="width:40px;" min="0" max="59" value="<?php #echo $row['tiempoMin'];?>" disabled />Minutos
							</td-->
						</tr>
				</tbody>
			</table>
					
					<table class="table table-bordered">
					<thead>
						<tr class="centro">
							<td>Nombre Quien Programa</td>							
							<td>Nombre del Paciente</td>
							<td>Edad</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<input id="enfermeraQx" name="enfermeraQx" type="text" style="width:350px;" value="<?php echo utf8_encode($row['enfermera']);?>" disabled />
							</td>
							<td>
								<input id="nompQx" name="nompQx" type="text" style="width:350px;" value="<?php echo utf8_encode($row['nombrePaciente']);?>" disabled />
							</td>
							<td>
								<input id="edadQx" name="edadQx" type="number" style="width:40px;" value="<?php echo $row['edad'];?>" disabled />
							</td>						
						</tr>
						</tbody>
						</table>

					
					<!--table class="table table-bordered">
					<thead>
						<tr class="centro">
							<!--td>Diagnóstico</td-->
							<!--td>Cirugía</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<!--td>
								<input id="diagQx" name="diagQx" type="text" style="width:450px;" value="<?php #echo utf8_encode($row['diagnostico']);?>" disabled />
							</td-->
							<!--td>
								<input id="cirgQx" name="cirgQx" type="text" style="width:450px;" value="<?php #echo utf8_encode($row['cirugia']);?>" disabled />
							</td>						
						</tr>
						</tbody>
						</table-->

					
					<!--table class="table table-bordered">
					<thead>
						<tr class="centro">
							<td>Instrumental/Material Especial</td>
							<td>Equipo</td>
							<td>Descorche</td>							
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<!--input id="instrQx" name="instrQx" type="text" style="width:450px;" value="PENDIENTE" disabled /-->
								<!--div class="form-group">
									&nbsp;<p>Instrumental o Material Especial (Opcional)</p>
									<input class="form-control" id="instrumental" type="text" name="instrumental" style="background-color:#C6E2FF" autocomplete="off" accept-charset="utf-8" disabled/>
									<br>
									<div id="suggestions"></div>
									<button id="adicionar" class="btn btn-success" type="button" disabled>Agregar Material Especial</button>
								</div>

								<p>Material Especial Agregado:
								  <div id="adicionados" style="display:none;"></div>
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
										  
										  <?php if($row['materialEsp'] != NULL && $row['materialEsp'] != ''){
											$material = json_decode(utf8_encode($row['materialEsp']),true);
											//echo 'MATERIAL: '.$material[1]["idInst"];
											$longitud = count($material);
											//echo 'LONGITUD: '.$longitud;
											$cantidad = json_decode($row['cantidadMaterialEsp'],true);
											//echo 'CANTIDAD: '.$cantidad[1]["cantidad"];

											for($i=0; $i<$longitud; $i++){ 
												//echo 'OTRO: '.$material[$i]["idInst"];?>
												<!--tr class="item"> 
													<td><input id="nInstrumento" name="nInstrumento" type="text" style="width:350px;" value="<?php echo $material[$i]["idInst"] ?>" disabled />
													</td>
													<td>
													<input id="nCantidad" name="nCantidad" type="text" style="width:30px;" value="<?php echo $cantidad[$i]["cantidad"] ?>" />
													</td>
													<td>
													<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button>
													</td>
										  		</tr>
											<?php } #termina el FOR
										} #Termina el IF ?>										  
								</table>
								
							</td>
							<td>
								<!--input id="eqQx" name="eqQx" type="text" style="width:450px;" value="<?php echo utf8_encode($row['equipo']);?>" disabled />
							</td>
							<td-->
								<!--input id="descoQx0" name="descoQx0" type="text" style="width:40px;" value="<?php echo $row['descorche'];?>" disabled /-->
								<!--select id="descoQx" name="descoQx" style="width:60px; height:40px" disabled>
							        <option value="<?php echo $row['descorche'];?>"><?php echo $row['descorche'];?></option>
							   		<option value="SI"> SI </option>
									<option value="NO"> NO </option>
								</select>
							</td>							
							</tbody>
						</tr>
						</tbody>
						</table-->
						
						<!--table class="table table-bordered">
						<thead>
						<tr class="centro">
							<td>Descorche Sobre</td>
							<td>Autorizó</td>
							<td>Imagenología</td>
							<td>Reserva de Sangre</td>
							<td>Muestra de Patologías</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<textarea name="descorcheTxtQx" id="descorcheTxtQx" cols="30" rows="2" disabled ><?php echo utf8_encode($row['descorcheTxt']);?></textarea>
								<!--input id="descorcheTxtQx" name="descorcheTxtQx" type="text" style="width:450px;" value="<?php echo utf8_encode($row['descorcheTxt']);?>" disabled /-->
							<!--/td>
							<td>
								<select id="autorizoQx" name="autorizoQx" style="width:260px; height:40px" disabled>
									<option value="<?php echo utf8_encode($row['autorizo']) ?>" ><?php echo utf8_encode($row['autorizo']) ?></option>
									<option value="<?php echo "Dr. Juan Augusto Miranda Avilés" ?>">  Dr. Juan Augusto Miranda Avilés </option>
									<option value="<?php echo "Dr. Fernando Carreño De La Rosa" ?>" > Dr. Fernando Carreño De La Rosa </option>
									<option value="Ing. Carlos Padilla Morales"> Ing. Carlos Padilla Morales </option>
								</select>
							</td>
							<td>
								<input id="imagenQx" name="imagenQx" type="text" style="width:300px;" value="<?php echo utf8_encode($row['imagen']);?>" disabled />
							</td>
							<td>
								<input id="sangreQx" name="sangreQx" type="text" style="width:200px;" value="<?php echo utf8_encode($row['sangre']);?>" disabled />
							</td>	
							<td>
								<select id="patolQx" name="patolQx" style="width:60px; height:40px" disabled>
							        <option value="<?php echo $row['patologias'];?>"><?php echo $row['patologias'];?></option>
							   		<option value="SI"> SI </option>
									<option value="NO"> NO </option>
								</select>
							</td>
						</tr>
						</tbody>
						</table-->
						
						<table class="table table-bordered">
						<thead>
						<tr class="centro">
							<!--td>Trans/Pos</td>
							<td>Patólogo</td>
							<td>Tamaño Frasco</td-->
							<td>Médico Tratante</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<!--td>
								<select id="transopeQx" name="transopeQx" style="width:150px; height:40px" disabled>
							        <option value="<?php echo $row['transPosOperatorio'];?>"><?php echo $row['transPosOperatorio'];?></option>
							   		<option value="Transoperatorio"> Transoperatorio</option>
				   					<option value="Postoperatorio"> Postoperatorio</option>
				   					<option value=""> Ninguno</option>
								</select>							
								<!--input id="transopeQx" name="transopeQx" type="text" style="width:130px;" value="<?php echo utf8_encode($row['transPosOperatorio']);?>" disabled /-->
							<!--/td>
							<td>
								<input id="patologoQx" name="patologoQx" type="text" style="width:280px;" value="<?php echo utf8_encode($row['patologo']);?>" disabled />
							</td>
							<td>
								<select id="tamanoQx" name="tamanoQx" style="width:180px; height:40px" disabled>
							        <option value="<?php echo $row['tamano'];?>"><?php echo $row['tamano'];?></option>
							   		<option value="CHICO">  CHICO </option>
				   					<option value="MEDIANO"> MEDIANO </option>
									<option value="GRANDE"> GRANDE </option>
									<option value="EXTRA GRANDE"> EXTRA GRANDE </option>
									<option value=""> NINGUNO</option>
								</select>
							</td-->							
							<td>
								<input id="cirugQx" name="cirugQx" type="text" style="width:280px;" value="<?php echo utf8_encode($row['cirujano']);?>" disabled />
								<?php $nomCirg = utf8_encode($row['cirujano']) ?>
							</td>
						</tr>
						</tbody>
						</table>
						<!--table class="table table-bordered">
						<thead>
						<tr class="centro">
							<td>Tel. Cirujano</td>
							<td>E-mail Cirujano</td>
							<td>Instrumentista</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<input id="telCirujanoQx" name="telCirujanoQx" type="text" style="width:130px;" value="<?php echo ($row['telCirujano']);?>" disabled />
							</td>
							<td>
								<input id="emailCirujanoQx" name="emailCirujanoQx" type="email" style="width:300px;" value="<?php echo ($row['emailCirujano']);?>" disabled />
								<?php 
								$emailDoc = $row['emailCirujano'];
								?>
							</td>							
							<td>
								<input id="instrumentistaQx" name="instrumentistaQx" type="text" style="width:330px;" value="<?php echo utf8_encode($row['instrumentista']);?>" disabled />
							</td>
						</tr>
						</tbody>
						</table-->

						<!--table class="table table-bordered">
						<thead>
						<tr class="centro">
							<td>Anestesiólogo</td>
							<td>Ayudante</td>
							<td>Pediatra</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<input id="anestQx" name="anestQx" type="text" style="width:350px;" value="<?php echo utf8_encode($row['anestesiologo']);?>" disabled />
							</td>
							<td>
								<input id="ayudQx" name="ayudQx" type="text" style="width:280px;" value="<?php echo utf8_encode($row['ayudante']);?>" disabled />
							</td>
							<td>
								<input id="pediatQx" name="pediatQx" type="text" style="width:280px;" value="<?php echo utf8_encode($row['pediatra']);?>" disabled />
							</td>
						</tr>
				</tbody>
			</table>
		
			<table class="table table-bordered">
						<thead>
						<tr class="centro">
							<td>Nombre de quien programa Cirugía</td>
							<td>Teléfono de quien programa Cirugía</td>
							<td>Correo de quien programa Cirugía</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<input id="nombProgQx" name="nombProgQx" type="text" style="width:350px;" value="<?php echo utf8_encode($row['nombrePrograma']);?>" disabled />
							</td>
							<td>
								<input id="telProgQx" name="telProgQx" type="text" style="width:280px;" value="<?php echo utf8_encode($row['telPrograma']);?>" disabled />
							</td>
							<td>
								<input id="emailProgQx" name="emailProgQx" type="text" style="width:280px;" value="<?php echo utf8_encode($row['correoPrograma']);?>" disabled />
							</td>
						</tr>
				</tbody>
			</table-->
			
			<table class="table table-bordered">
					<thead>
					<tr class="centro">
						<td>Cambiar Fecha Probable de Parto</td>
						<!--td>Se realizó Operación</td-->
						<td>Datos</td>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							<select id="diferirQx" name="diferirQx" style="width:130px; height:40px" disabled>
								<option value="<?php echo $row['diferida'];?>"><?php echo $row['diferida'];?></option>
								<option value="SI"> SI </option>
								<option value="NO"> NO </option>
							</select>
							<br/>
							<input id="fechaDiferirQx" name="fechaDiferirQx" type="date" style="width:140px;display:none" value="<?php echo $row['fechaOriginal'];?>" />
						</td>
						<!--td>
						<select id="realizoQx" name="realizoQx" style="width:130px; height:40px" disabled>
								<option value="<?php //echo $row['seRealizo'];?>"><?php //echo $row['seRealizo'];?></option>
								<option value="SI"> SI </option>
								<option value="NO"> NO </option>
							</select>
						</td-->
						<td>
							<input type="hidden" id="ListaPro" name="ListaPro" value="" >
							<input type="hidden" id="ListaPro2" name="ListaPro2" value="" >
							<input id="id" name="id" type="hidden" value="<?php echo $id ?>" />
							<input id="rol" name="rol" type="hidden" value="<?php echo $rol ?>" />
							<?php //if($rol == 'quirofano') { ?>
								<input  class="btn btn-primary" type="button" value="MODIFICAR" onclick ="dsblqModifDss()" />
								<input type="submit" onclick="creaArr();" id="btGd" class="btn btn-success" name="enviarQx" value="GUARDAR" disabled />
							<?php //} ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		</form>
		<br>
		<p> <strong>OPCIONES</strong></p>
		<!--a  class="btn btn-info" href="formatoQuirofano.php?rol=<?php #echo $rol ?>&id=<?php #echo $id ?>">Generar Formato</a>
		<a  class="btn btn-primary" href="emailHD.php?rol=<?php #echo $rol ?>&id=<?php #echo $id ?>&emailDoc=<?php #echo $emailDoc ?>&fecha=<?php #echo $fechaDoc ?>&cirujano=<?php #echo $nomCirg ?>&hora=<?php #echo $horaDoc ?>&estaus=<?php #echo $estatusCirugia0 ?>" target="_blank" onClick="return confirmSubmit()">Enviar E-mail</a-->
		<a  class="btn btn-danger" href="index.php?rol=<?php echo $rol ?>">Regresar</a>
	</center>
</div>
</body>
</html>	