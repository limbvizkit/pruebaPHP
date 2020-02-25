<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configMedico.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../conexion/funciones_db.php');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['exp']))
	{
		$expediente=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	
	
	//echo 'Nombre PAc: '.$nombre_pac;
	//Sacar Edad Precisa en años o Meses
	/*$hoy = new DateTime();
	$anniosO = $hoy->diff($date2);
	//$annios = $annios->y;
	$annios = $anniosO->format('%y Año(s)');
	$anniosBool = $anniosO->format('%y');
	if($anniosBool == '0'){
		$annios = $anniosO->format('%m Mes(es)');
	}*/

	if(isset($_REQUEST['enviar']))
	{

		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		if (isset($_POST['exp']))
		{
			$expediente=$_POST['exp'];
		}
		if (isset($_POST['folio']))
		{
			$folio=$_POST['folio'];
		} 
		
		if (isset($_POST['dieta']))
		{
			$dieta=utf8_decode($_POST['dieta']);
		}
		if (isset($_POST['medidasGral']))
		{
			$medidasGral=utf8_decode($_POST['medidasGral']);
		}
		if (isset($_POST['soluciones']))
		{
			$soluciones=utf8_decode($_POST['soluciones']);
		}
		if (isset($_POST['laboratorios']))
		{
			$laboratorios=utf8_decode($_POST['laboratorios']);
		}
		if (isset($_POST['otros']))
		{
			$otros=utf8_decode($_POST['otros']);
		}
		if (isset($_POST['nombreMedicoTratante']))
		{
			$nombreMedicoTratante=utf8_decode($_POST['nombreMedicoTratante']);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}

		/*$usuario1 = new FuncionesDB();
		#La funcion retorna un arreglo lo mandamos a una variable
		$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
		$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
		$date2 = $resultado[0][0]['NACIO_PA'];
		$fecha_nac_pac = $date2->format('Y-m-d');
		$diagMed = NULL;
		$cedulaMed = NULL;
			
		$queryMed = "SELECT cedula, diag
					  FROM notaurg
					  WHERE numeroExpediente='$expediente' AND folio='$folio' and estatus=1";
		$cedu = mysqli_query($conexionMedico, $queryMed) or die (mysqli_error($conexionMedico));
		
		while($row = mysqli_fetch_array($cedu)){
			$cedulaMed=$row[0];
			$diagMed=$row[1];
			//echo '1.- '.$cedu.' '.$diagMed;
		}
		
		if($diagMed == NULL || $diagMed == ''){
			$queryMed = "SELECT cedula, diag
						  FROM notaurgchoque
						  WHERE numeroExpediente='$expediente' AND folio='$folio' and estatus=1";
			$cedu = mysqli_query($conexionMedico, $queryMed) or die (mysqli_error($conexionMedico));

			while($row = mysqli_fetch_array($cedu)){
				$cedulaMed=$row[0];
				$diagMed=$row[1];
				//echo '2.- '.$cedu.' '.$diagMed;
			}
		}
		
		//echo '3.- '.$cedu.' '.$diagMed;
		$resultado2[] = $usuario1->medicosCed($cedulaMed);
		
		$univMed = utf8_decode($resultado2[0][0]['UNIVERSIDAD_CEDULA_MEDICO']);
		$nombMed = utf8_decode($resultado2[0][0]['DESC_MEDICO']);*/
		
		//echo 'Nombre PAc: '.$nombre_pac.' '.$univMed.'  '.$fecha_nac_pac.'  '; 
		
		$acturl=NULL;
		$acturl2=NULL;
		$acturl3=NULL;
		$acturl4=NULL;
		#vamos a recibir los datos del listado de Indicaciones
		if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = utf8_decode(urldecode($_POST['ListaPro'])); //decodifico el JSON
			//echo 'LLEGOOOO: '.$acturl;
			if($acturl == '[]'){
	        	$acturl = NULL;
	        }
	        //$productos = json_decode($acturl, true);
        	//$separado1 = implode(",", $productos);
        	//var_dump($productos);
	        //echo 'FINAL1: '.$separado1;
	        /*foreach ($productos  as $pro) {
	        	echo ' DENTRO: '.$pro->idInst;
	            $misProductos = array('nombre['.$n++.']' => $pro->idInst);
	        }*/
        }
        
        if(isset ($_POST['ListaPro2']) && $_POST['ListaPro2'] != NULL){
			$acturl2 = utf8_decode(urldecode($_POST['ListaPro2'])); //decodifico el JSON
			//echo 'LLEGOOOO2: '.$acturl2;
			if($acturl2 == '[]'){
	        	$acturl2 = NULL;
	        }
		}
	        //$productos2 = json_decode($acturl2, true);
			
        if(isset ($_POST['ListaPro3']) && $_POST['ListaPro3'] != NULL){
			$acturl3 = utf8_decode(urldecode($_POST['ListaPro3'])); //decodifico el JSON
			//$acturl3=addslashes($acturl3);
			if($acturl3 == '[]'){
	        	$acturl3 = NULL;
	        }
		}
		
		if(isset ($_POST['ListaPro4']) && $_POST['ListaPro4'] != NULL){
			$acturl4 = utf8_decode(urldecode($_POST['ListaPro4'])); //decodifico el JSON
			//$acturl4=addslashes($acturl4);
			if($acturl4 == '[]'){
	        	$acturl4 = NULL;
	        }
		}
		
		if(isset ($_POST['ListaPro5']) && $_POST['ListaPro5'] != NULL){
			$acturl5 = utf8_decode(urldecode($_POST['ListaPro5'])); //decodifico el JSON
			//$acturl4=addslashes($acturl4);
			if($acturl5 == '[]'){
	        	$acturl5 = NULL;
	        }
		}
		
		//echo 'LLEGO:  ' .$acturl.' \n  '.$acturl2.'\n  '.$acturl3.'\n  '.$acturl4;
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' '.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryIndMed = "INSERT INTO indicacionesmt (id,numeroExpediente,folio,dieta,medidasGral,soluciones,laboratorios,otros,idMedicamentos,medicamentos,sal,indicaciones,existencias,nombreMedicoTratante,cedula,usr)
							VALUES (NULL,'$expediente','$folio','$dieta','$medidasGral','$soluciones','$laboratorios','$otros','$acturl2','$acturl','$acturl4','$acturl3','$acturl5','$nombreMedicoTratante','$cedula','$rol')";
		
		$result0 = mysqli_query($conexionMedico, $queryIndMed);
		if(!$result0) {
			echo '<br>! ERROR al insertar Datos de Indicaciones Médicas! <br>';
			echo 'QUERY: '.$queryIndMed;
		} else {
			echo '<br>!!!! SE GUARDARON LAS DATOS DE LAS INDICACIONES MÉDICAS CORRECTAMENTE!!!!<br>';
			//echo 'QUERY: '.$queryIndMed;
		}	
		
	}	

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>INDICACIONES MÉDICAS</title>

        <!-- Google Font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<!-- BootStrap Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/bootstrap/css/bootstrap.min.css"-->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
		<!-- Font-Awesome Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/font-awesome/css/font-awesome.min.css"-->
		<link rel="stylesheet" href="./tabs_files/font-awesome.css">
		
		<!-- Plugin Custom Stylesheet -->
		<link rel="stylesheet" href="css/form-wizard-blue.css">
		<link href="css/switcher.css" rel="stylesheet">
		<!--*****
		If you need to change the form color then you have to just change the CSS file name!! Do it very simply, like as "form-wizard-red.css" for make it red color. Our template other colors name is there ( black, blue, red, pink, purple, teal, green, yellow, orange, brown, cyan, lime ). Replace the name and make it awesome!!!
		*****-->	
    </head>

    <body>
	
        <!-- main content -->
        <section class="form-box">
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-15 col-lg-offset-13 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
					
                    	<form role="form" action="" method="post">

                    		<h3>INDICACIONES MÉDICAS</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 100%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>INDICACIONES</p>
                    			</div>
								<!-- Step 1 -->
                    		</div>
							<!-- Form progress -->
                    		
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<div class="form-group">
									<h3>INDICACIONES</h3>
									<label>DIETA : <span>*</span></label>
									<textarea class="form-control" name="dieta" id="dieta" cols="10" rows="3"></textarea>
									<br>
									<label>MEDIDAS GENERALES : <span>*</span></label>
									<textarea class="form-control" name="medidasGral" id="medidasGral" cols="10" rows="3"></textarea>
									<br>
									<label>SOLUCIONES : <span>*</span></label>
									<textarea class="form-control" name="soluciones" id="soluciones" cols="10" rows="3"></textarea>
									<br>
									<h3>MEDICAMENTOS</h3>
									<label>NOMBRE DEL MÉDICAMENTO : <span>* (Medicamentos en rojo ALTO RIESGO)</span></label>
									<input type="text" name="medicamento" id="service" class="form-control" autocomplete="off">
									<input type="hidden" size="10" id="idMed" name="idMed" accept-charset="utf-8" >
									<input id="sal" name="sal" type="hidden" accept-charset="utf-8" >
									<input id="exist" name="exist" type="hidden" >
									
									<!--div style="height: 200px"-->
										<div id="suggestions" style="height: 180px; overflow: auto" ></div>
									<!--/div-->
									<br>
									
									<label>DOSIS/INDICACIONES : <span>*</span></label>
									<input type="text" name="indicacion" id="indicacion" class="form-control" autocomplete="off">
									<!--textarea class="form-control" name="indicacion" id="indicacion" cols="10" rows="3"></textarea-->
									<!--h6>Favor de anotar nombre del Médico y Cédula profesional después de cada indicación</h6-->
									<br>
									<button id="adicionar" class="btn btn-success" type="button">Agregar Medicamento</button>
								</div>
								
								<p>Medicamentos Agregados:
								  <div id="adicionados"></div>
								</p>
								<table id="mytable" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Medicamento</th>
										<th>Dosis</th>
										<!--th>Existencias</th-->
										<th>Eliminar</th>
									</tr>
								  </thead>
								  <tbody id="ProSelected">
									  <!--Ingreso un id al tbody-->
								  <!--tr>
									<td><input id="var1" type="text" name="variable1[]" value=""></td>
									<td><input id="var2" type="text" name="variable2[]" value=""></td>
								</tr-->
								</tbody>
								</table>
							
							<label>LABORATORIOS :</label>
							<textarea class="form-control" name="laboratorios" id="laboratorios" cols="10" rows="3"></textarea>
							<br>
							<label>OTROS : </label>
							<textarea class="form-control" name="otros" id="otros" cols="10" rows="3"></textarea>
							<br>
							<div class="form-group">
								<h4>DATOS DEL MÉDICO TRATANTE:</h4>
								&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
								<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off">
								<br>
								<div id="suggestions1"></div>
							</div>
							<h6>*Si no conoce la cedula del medico tratante colocar el nombre, si ya colocó una cedula no llenar</h6>
							<div class="form-group">
								<label>NOMBRE DEL MEDICO TRATANTE : </label>
								<input class="form-control " type="text"  name="nombreMedicoTratante" id="nombreMedicoTratante">
							</div>
							
							<input type="hidden" id="exp" name="exp" value="<?php echo $expediente ?>" >
							<input type="hidden" id="folio" name="folio" value="<?php echo $folio ?>" >
							
								<input type="hidden" id="ListaPro" name="ListaPro" value="" >
								<input type="hidden" id="ListaPro2" name="ListaPro2" value="">
								<input type="hidden" id="ListaPro3" name="ListaPro3" value="" >
								<input type="hidden" id="ListaPro4" name="ListaPro4" value="" >
								<input type="hidden" id="ListaPro5" name="ListaPro5" value="" >
								<input name="rol" type="hidden" value="<?php echo $rol ?>" >
                                <div class="form-wizard-buttons">
                                    <button type="submit" name="enviar" onclick="creaArr();" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->
                    	</form>
						</div>
						<!-- Form Wizard -->
                    </div>
                </div>
            </div>
			<input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 137px; height: 44px" />
        </section>
		<!-- main content -->

        <!-- Jquery JS -->
        <script src="../js/jquery-1.11.1.min.js"></script>
	
		<!-- bootStrap JS -->
		<script src="../js/bootstrap.min.js"></script>
		
		<!-- Plugin Custom JS -->
        <script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script>
        <!-- Plugin Custom JS -->
		<!--Otros Sxripts-->
		<script type="text/javascript">
			var c=0;//contador para asignar id al boton que borrara la fila
		
			//Funcion para acomodar la fecha de AAAA-MM-DD a DD/MM/AAAA
			/*function convertDateFormat(string) {
				var info = string.split('-').reverse().join('/');
        		return info;
			}*/
		    	
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
			  fila = fila + '<td><input id="nIndicacion' + c + '" name="nIndicacion[' + c + ']"type="text" style="width: 350px; height: 28px" value="'+indicacion+'" /> ';
			  fila = fila + '<input id="nExist' + c + '" name="nExist[' + c + ']" type="hidden" style="width: 50px; height: 28px" value="'+existencias+'" disabled /> <input id="idMed' + c + '" name="idMed[' + c + ']" type="hidden" value="'+medId+'" /> <input id="nSal' + c + '" name="nSal[' + c + ']" type="hidden" value="'+salN+'" /> </td> ';
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
			
			$('input[name^="nIndicacion"]').each(function() {
		   	 //alert($(this).val());
		   	 ip3.push({ medI : $(this).val() });
			});
			//Esta opcion toma TODOS los text areas y lo mete al arreglo de indicaciones
			/*$('textarea').each(function() {//indicacion textarea nIndicacion
		   	 //alert($(this).val());
		   	 ip3.push({ nameI : $(this).val() });
			});*/
			
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
		//Funcion para autocomplemento del campo de Medicamentos
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
			
			//Funcion para autocomplementar los Medicos
		var id1 = "";
		  $(document).ready(function(e) {
			$('#cedula').bind('input keyup', function(){
				//Obtenemos el value del input
				var cedula = $(this).val();
				var dataString0 = 'cedula='+cedula;
				
				var n = dataString0.length;
				if(n > 10){
					var dataString = dataString0;
				} else {
					var dataString = 'cedula=" "';
				}
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "autocompleteDR.php",
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
							var especialidad = $(this).attr('especialidad');
							var ced = $(this).attr('ced');
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							valor = valor.trim();
							$('#cedula').val(ced);
							//$('#telCirujano').val(tel);
							//$('#emailCirujano').val(email);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions1').fadeOut(1000);
							//Add valor del id del elemento seleccionado
							//$('#idMedic').val(id1);
						});
		            }
		        });
		    });
		});
	</script>

    </body>

</html>