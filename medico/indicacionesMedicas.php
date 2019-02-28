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
	/*if (isset($_GET['exp']))
	{
		$expediente=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}*/ 

	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    /*$usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	$expediente_pac = trim($resultado[0][0]['NO_EXP_PAC']);
	$folio_pac = $resultado[0][0]['FOLIO_PAC'];
	$edad_pac = $resultado[0][0]['EDAD_PAC'];
   	$sexo_pac = $resultado[0][0]['SEXO_PAC'];
	if($sexo_pac == 'M'){
		$sexo_pac='MASCULINO';
	} else {
		$sexo_pac='FEMENINO';
	}
	$obligado_pac = $resultado[0][0]['OBLI_PAC'];
 	$date2 = $resultado[0][0]['NACIO_PA'];
	//Sacar Edad Precisa en años o Meses
	$hoy = new DateTime();
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
		
		if (isset($_POST['nPaciente']))
		{
			$nPaciente=utf8_decode($_POST['nPaciente']);
			$nPaciente=addslashes($nPaciente);
		}
		if (isset($_POST['fNacimieto']))
		{
			$fNacimieto=$_POST['fNacimieto'];
		}
		if (isset($_POST['alergias']))
		{
			$alergias=utf8_decode($_POST['alergias']);
			$alergias=addslashes($alergias);
		} else {
			$alergias=NULL;
		}
		if (isset($_POST['medTratante']))
		{
			$medTratante=utf8_decode($_POST['medTratante']);
			$medTratante=addslashes($medTratante);
		}
		if (isset($_POST['diagnostico']))
		{
			$diagnostico=utf8_decode($_POST['diagnostico']);
			$diagnostico=addslashes($diagnostico);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		if (isset($_POST['fechaG']))
		{
			$fechaG=$_POST['fechaG'];
		}
		if (isset($_POST['horaG']))
		{
			$horaG=$_POST['horaG'];
		}
		$acturl=NULL;
		$acturl2=NULL;
		$acturl3=NULL;
		#vamos a recibir los datos del listado de Indicaciones
		if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = urldecode($_POST['ListaPro']); //decodifico el JSON
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
			$acturl2 = urldecode($_POST['ListaPro2']); //decodifico el JSON
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
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' '.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryIndMed = "INSERT INTO indicacionesMedicas (id,numeroExpediente,folio,nPaciente,fNacimiento,alergias,medTratante,diagnostico,cedula,fechaInd,
								horaInd,indicacion,usr,estatus,fechaG,horaG)
						VALUES 	
								(NULL,NULL,NULL,'$nPaciente','$fNacimieto','$alergias','$medTratante','$diagnostico','$cedula','$acturl','$acturl2',
								'$acturl3','$rol','1','$fechaG','$horaG')";
		
		$result0 = mysqli_query($conexionMedico, $queryIndMed);
		if(!$result0) {
			echo '<br>! ERROR al insertar Indicaciones Médicas! <br>';
			echo 'QUERY: '.$queryIndMed;
		} else {
			echo '<br>!!!! SE GUARDARON LAS INDICACIONES MÉDICAS CORRECTAMENTE!!!!<br>';
		}
		
	}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NOTA URGENCIAS CHOQUE</title>

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
                    <div class="col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1">
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
                    	<form role="form" action="" method="post">
                    		<h3>HOJA DE INDICACIONES MÉDICAS</h3>
                    		<p></p>
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="1" style="width: 100%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>DATOS</p>
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
								<!-- Progress Bar -->
                    		    <h4>INDICACIONES MÉDICAS: <span>Paso 1 - 1</span></h4>
								<div class="form-group">
									<label>FECHA DE CAPTURA : <span>*</span></label>
									<input type="date" name="fechaG" class="form-control required" >
								</div>
								<div class="form-group">
									<label>HORA DE CAPTURA : <span>*</span></label>
									<input type="time" name="horaG" class="form-control required" >
								</div>
								<div class="form-group">
									<label>NOMBRE COMPLETO DEL PACIENTE : <span>*</span></label>
									<input type="text" name="nPaciente" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>FECHA DE NACIMIENTO : <span>*</span></label>
									<input type="date" name="fNacimieto" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
									<label>ALERGIAS : <span></span></label>
									<input type="text" name="alergias" class="form-control" autocomplete="off">
								</div>								
								<div class="form-group">
                    			    <label>DIAGNÓSTICO : <span>*</span></label>
									<input type="diagnostico" name="diagnostico" class="form-control required" autocomplete="off">
                                    <!--textarea class="form-control required" name="diagnostico" id="diagnostico" cols="10" rows="3"></textarea-->
                                </div>
								<div class="form-group">
									<h4>DATOS DEL MÉDICO:</h4>
                    			    <label>CEDULA PROFESIONAL : <span>*</span></label>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off" required>
									<br>
									<div id="suggestions1"></div>
                                </div>
								<div class="form-group">
									<label>NOMBRE DEL MÉDICO TRATANTE : <span>*</span></label>
									<input type="text" name="medTratante" id="medTratante" class="form-control required" autocomplete="off">
								</div>
								<div class="form-group">
									<h3>AGREGAR INDICACIÓNES</h3>
									<label>FECHA : <span>*</span></label>
									<input type="date" name="fIndicacion" id="fIndicacion" class="form-control" autocomplete="off">
									<label>HORA : <span>*</span></label>
									<input type="time" name="horaIndicacion" id="horaIndicacion" class="form-control" autocomplete="off">
									<label>INDICACIONES : <span>*</span></label>
									<!--input type="text" name="indicacion" id="indicacion" class="form-control" autocomplete="off"-->
									<textarea class="form-control" name="indicacion" id="indicacion" cols="10" rows="3"></textarea>
									<!--h6>Favor de anotar nombre del Médico y Cédula profesional después de cada indicación</h6-->
									<button id="adicionar" class="btn btn-success" type="button">Agregar Indicación</button>
								</div>
								<p>Indicaciones Agregadas:
								  <div id="adicionados"></div>
								</p>
								<table id="mytable" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Indicación</th>
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
								<input type="hidden" id="ListaPro" name="ListaPro" value="" >
								<input type="hidden" id="ListaPro2" name="ListaPro2" value="" >
								<input type="hidden" id="ListaPro3" name="ListaPro3" value="" >
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
			function convertDateFormat(string) {
				var info = string.split('-').reverse().join('/');
        		return info;
			}
			
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
							$('#medTratante').val(valor);
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
		    	
		 $(document).ready(function() {
			//obtenemos el valor de los input
			$('#adicionar').click(function() {
			  	var indicacion = document.getElementById("indicacion").value;
			  	indicacion = indicacion.trim();
				
				var fIndicacion = document.getElementById("fIndicacion").value;
			  	//fIndicacion = fIndicacion.trim();
				var fIndicacionB = convertDateFormat(fIndicacion);
				
				var horaIndicacion = document.getElementById("horaIndicacion").value;
			  	horaIndicacion = horaIndicacion.trim();
			  //var cantidad = document.getElementById("cantidad").value;
			  //var i = 1; //contador para asignar id al boton que borrara la fila
			  c++;
			  //var fila = '<tr>';
			  var fila = '<tr class="item"> <td><input id="fIndic' + c + '" name="fIndic[' + c + ']" type="text" style="width: 100px; height: 28px" value="'+fIndicacionB+'" /></td> ';
			  fila = fila + '<td> <input id="hIndic[' + c + ']" name="hIndic[' + c + ']" type="time" value="'+horaIndicacion+'" /></td>';
			  fila = fila + '<td><textarea id="nIndicacion' + c + '" name="nIndicacion[' + c + ']">'+indicacion+'</textarea></td> ';
			  //fila = fila + '<td><input id="nIndicacion' + c + '" name="nIndicacion[' + c + ']" type="text" value="'+indicacion+'" disabled /></td> ';
			  fila = fila + '<td><button type="button" name="remove" id="' + c + '" class="btn btn-danger btn_remove">Quitar</button></td> </tr>';
		  	  //'<tr id="row' + i + '"><td>indicacion + '</td><td>' + cantidad + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
			  $('#ProSelected').append(fila);
			  $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
			  var nFilas = $("#mytable tr").length;
			  $("#adicionados").append(nFilas - 1);
			  //le resto 1 para no contar la fila del header
			  //document.getElementById("cantidad").value = "";
			  document.getElementById("indicacion").value = "";
			  document.getElementById("indicacion").focus();
		  });
		  
		$(document).on('click', '.btn_remove', function() {
		  var button_id = $(this).attr("id");
		    //cuando da click obtenemos el id del boton
		    //$('#row' + button_id + '').remove(); //borra la fila
		    $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
            if ($('#ProSelected tr.item').length == 0)
                $('#ProSelected .no-item').slideDown(300);

		    //limpia el contador para que vuelva a contar las filas de la tabla
		    $("#adicionados").text("");
		    var nFilas = $("#mytable tr").length;
		    $("#adicionados").append(nFilas - 1);
		  });
		});
		
		function creaArr(){
			var ip = [];
			var ip2 = [];
			var ip3 = [];
			$('input[name^="fIndic"]').each(function() {
		   	 	//alert($(this).val());
		   	 	ip.push({ fechaI : $(this).val().trim() });
			});
			
			var ipt=JSON.stringify(ip);
			$('#ListaPro').val(encodeURIComponent(ipt));
        	//document.getElementById("valores").innerHTML = ipt;
        	
			$('input[name^="hIndic"]').each(function() {
		   	 //alert($(this).val());
		   	 ip2.push({ horaI : $(this).val() });
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
		}
	</script>

    </body>

</html>