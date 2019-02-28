<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configLogin.php');	

	/*if (isset($_GET['rol']))
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
	}*/
	
	$nombreEmpl = NULL;
	$numEmp = NULL;
	$nombJefeEmpl = NULL;
	$area = NULL;
	$nombAreaEmpl = NULL;
	$areaEmpl = NULL;

	//Si enviamos una solicitud de busqueda por num de empleado
	if(isset($_REQUEST['buscar']))
	{
		if (isset($_POST['numEmp']))
		{
			$numEmp=$_POST['numEmp'];
		}
		
		//Consultamos los datos del numero de empleado colocado
		$queryEmpleado = "SELECT * FROM empleados WHERE numeroEmpleado = '$numEmp'";
		$empl = mysqli_query($conexion, $queryEmpleado);
		$emple = mysqli_fetch_array($empl);
		
		if($emple != NULL && $emple != ''){
		
			$nombreEmpl = utf8_decode($emple[2]);
			$jefeEmpl = $emple[5];
			$areaEmpl = $emple[3];

			//Consultamos los datos del jefe del empleado
			$queryJefe= "SELECT * FROM empleados WHERE id = '$jefeEmpl'";
			$jf = mysqli_query($conexion, $queryJefe);
			$jefe = mysqli_fetch_array($jf);

			$nombJefeEmpl = utf8_decode($jefe[2]);

			//Consultamos los datos del area del empleado
			$queryArea = "SELECT * FROM areas WHERE idArea = '$areaEmpl'";
			$ar = mysqli_query($conexion, $queryArea);
			$area = mysqli_fetch_array($ar);

			$nombAreaEmpl = utf8_encode($area[1]);
		} else {
			echo '<br/>NUMERO DE EMPLEADO NO EXISTENTE';
			$numEmp=NULL;
		}
		
	}

	if(isset($_REQUEST['enviar']))
	{
		if (isset($_POST['fecha']))
		{
			$fecha=$_POST['fecha'];
		} else {
			$fecha=date('Y-m-d');
		}
		
		if (isset($_POST['numEmp']))
		{
			$numEmp=$_POST['numEmp'];
		}
		
		if (isset($_POST['nombre']))
		{
			$nombre=utf8_decode($_POST['nombre']);
			$nombre=addslashes($nombre);
		}
		
		if (isset($_POST['nombreJefe']))
		{
			$nombreJefe=utf8_decode($_POST['nombreJefe']);
			$nombreJefe=addslashes($nombreJefe);
		}
		
		if (isset($_POST['area']))
		{
			$area=$_POST['area'];
		}
		
		if (isset($_POST['diasCorre']))
		{
			$diasCorre=$_POST['diasCorre'];
		}
		
		if (isset($_POST['diasDisfr']))
		{
			$diasDisfr=$_POST['diasDisfr'];
		}
		
		if (isset($_POST['diasPend']))
		{
			$diasPend=$_POST['diasPend'];
		}
		
		if (isset($_POST['diaRegreso']))
		{
			$diaRegreso=$_POST['diaRegreso'];
		}
		
		//Consultamos los datos del numero de empleado colocado
		$queryEmpleado = "SELECT * FROM empleados WHERE numeroEmpleado = '$numEmp'";
		$empl = mysqli_query($conexion, $queryEmpleado);
		$emple = mysqli_fetch_array($empl);
		
		if($emple != NULL && $emple != ''){
			//$nombreEmpl = utf8_decode($emple[2]);
			$jefeEmpl = $emple[5];
			//$areaEmpl = $emple[3];
		}
		
		$acturl=NULL;
		#vamos a recibir los datos del listado de Fechas de vacas
		if(isset ($_POST['ListaPro']) && $_POST['ListaPro'] != NULL){
			$acturl = utf8_decode(urldecode($_POST['ListaPro'])); //decodifico el JSON
			echo 'LLEGOOOO: '.$acturl;
			if($acturl == '[]'){
	        	$acturl = NULL;
	        }
			//$long=strlen($acturl);
			/*$matches = array();
			preg_match('~[0-9]{4}-(0[0-9]|1[012])-([012][0-9]|3[01])~', $acturl, $matches);*/
	        //$productos = json_decode($acturl, true);
			//Les quitamos los corchetes y las "" al arreglo que llego
			$quit1=str_replace("[","",$acturl);
			$quit2=str_replace("]","",$quit1);
			$quit3=str_replace("\"","",$quit2);
			
			//Convertimos en arreglo de php al arreglo que llego
        	$separado1 = explode(",", $quit3);
        	//var_dump($separado1[0]);
			//var_dump($separado1[1]);
	        //echo 'FINAL1: '.$separado1;
	        foreach ($separado1  as $pro) {
	        	echo ' DENTRO: '.$pro;
				$randon=date("dmYHms").mt_rand(1, 99);
	            //$misProductos = array('nombre['.$n++.']' => $pro->idInst);
				$queryVacaciones = "INSERT INTO formvacaciones (id, idSolicitud,fecha,numeroEmpleado,nombreEmpleado,idjefe,nombreJefe,area,
									diasCorresponden,diasDisfrutar,diasPendientes,diaVacaciones,regresaLaborar,estatus)
									VALUES
									(NULL,$randon,'$fecha','$numEmp','$nombre','$jefeEmpl','$nombreJefe','$area','$diasCorre','$diasDisfr','$diasPend',
									'$pro','$diaRegreso','1')";
				$result0 = mysqli_query($conexion, $queryVacaciones);
				if(!$result0) {
					echo '!<br> ERROR al insertar Datos de vacaciones! <br>';
					echo 'QUERY: '.$queryVacaciones;
				} else {
					echo '<br>!!!! SE GUARDARON LOS DATOS CORRECTAMENTE!!!!<br>';
					echo 'QUERY: '.$queryVacaciones;
				}
	        }
        }
		//echo 'LLEGO : '.$expediente.' '.$folio.' '.$rol.' '.$hora.' '.$motivo.' '.$ta.' '.$fc.' '.$fr.' '.$temp.' '.$so.' '.$peso.' '.
			//$talla.' '.$color.' '.$realizo;
	}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FORMULARIO VACACIONES</title>
        <!-- Google Font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<!-- BootStrap Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/bootstrap/css/bootstrap.min.css"-->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
		<!-- Font-Awesome Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/font-awesome/css/font-awesome.min.css"-->
		<link rel="stylesheet" href="../tabs_files/font-awesome.css">
		<!-- Plugin Custom Stylesheet -->
		<link rel="stylesheet" href="../css/form-wizard-blue.css">
		<link href="../css/switcher.css" rel="stylesheet">
		<!--*****
		If you need to change the form color then you have to just change the CSS file name!! Do it very simply, like as "form-wizard-red.css" for make it red color. Our template other colors name is there ( black, blue, red, pink, purple, teal, green, yellow, orange, brown, cyan, lime ). Replace the name and make it awesome!!!
		*****-->
    </head>
    <body>
        <!-- main content -->
        <section class="form-box">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-stylist form-body-material">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
						<form role="form" action="" method="post">
							<div class="form-group col-md-6 col-xs-6">
								<label>NÚMERO DE EMPLEADO : <span>*</span></label>
								<input type="number" name="numEmp" class="form-control" autocomplete="off">
							</div>
							<div class="form-wizard-buttons">
                            	<button type="submit" name="buscar" id="buscar" class="btn btn-submit">Buscar</button>
                            </div>
						</form>
							<br/>
							<br/>
                    	<form role="form" action="" method="post">
                    		<h3>FORMULARIO VACACIONES</h3>
                    		<p></p>
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="4" style="width: 100%;"></div>
                    			</div>								
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                    				<p>VACACIONES</p>
                    			</div>
								<!-- Step 2 -->
                    		</div>
							<!-- Form progress -->

							<!-- Form Step 2 -->
                            <fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>SOLICITUD DE PERIODO VACACIONAL : <span>Paso 1 - 1</span></h4>
								<div class="row form-inline">
									<div class="form-group col-md-6 col-xs-6">
										<label>FECHA : <span>*</span></label>
                                    	<!--input type="date" name="fecha" class="form-control required" -->
										<input type="date" name="fecha" class="form-control" value="<?php echo date("Y-m-d");?>" disabled>
									</div>
									<div class="form-group col-md-6 col-xs-6">
										<label>NÚMERO DE EMPLEADO : <span>*</span></label>
										<input type="number" name="numEmp" class="form-control" autocomplete="off" value="<?php echo $numEmp ?>">
									</div>
								</div>
								<div class="form-group">
									<label>NOMBRE DEL EMPLEADO : <span>*</span></label>
									<input type="text" name="nombre" class="form-control" autocomplete="off" value="<?php echo $nombreEmpl ?>">
								</div>
								<div class="form-group">
									<label>JEFE DIRECTO : <span>*</span></label>
									<input type="text" name="nombreJefe" class="form-control" autocomplete="off" value="<?php echo $nombJefeEmpl ?>">
								</div>
								<div class="form-group">
                    			    <label>DEPARTAMENTO : <span>*</span></label>
                                   	<select id="area" name="area" class="form-control">
									    <option value="<?php echo $areaEmpl ?>"> <?php echo $nombAreaEmpl ?> </option>
									</select>
								</div>
								<br />
								<div class="row form-inline">
									<div class="form-group col-md-6 col-xs-6">
										<label>DÍAS QUE LE CORRESPONDEN : <span>*</span></label>
                                    	<input type="number" name="diasCorre" class="form-control" >
									</div>
									<div class="form-group col-md-6 col-xs-6">
										<label>DÍAS A DISFRUTAR : <span>*</span></label>
										<input type="number" name="diasDisfr" class="form-control" autocomplete="off">
									</div>
									<div class="form-group col-md-6 col-xs-6">
										<label>DÍAS PENDIENTES : <span>*</span></label>
										<input type="number" name="diasPend" class="form-control" autocomplete="off">
									</div>
								</div>
								<br />
								<div class="form-group">
									<label>DÍAS DE VACACIONES : <span>*</span></label>
									<input type="date" name="diasVac" id="diasVac" class="form-control" >
								</div>
									<button id="adicionar" class="btn btn-success" type="button">Agregar Día</button>
								<br/>
								<p>Días Agregados:
								  <div id="adicionados"></div>
								</p>
								<table id="mytable" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Día</th>
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
								<div class="form-group">
									<label>REGRESANDO A LABORAR EL DÍA : <span>*</span></label>
									<input type="date" name="diaRegreso" class="form-control" >
								</div>
                                <input type="hidden" id="ListaPro" name="ListaPro" value="" >
                                <div class="form-wizard-buttons">
                                    <button type="submit" name="enviar" id="enviar" onclick="creaArr();" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 2 -->
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
        <script src="../js/form-wizard.js"></script>
		<script src="../js/switcher.js"></script>
        <!-- Plugin Custom JS -->
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
					var diasVac = document.getElementById("diasVac").value;
					diasVac = diasVac.trim();
					document.getElementById("diasVac").value='';

					/*var horaIndicacion = document.getElementById("horaIndicacion").value;
					horaIndicacion = horaIndicacion.trim();*/
				  //var cantidad = document.getElementById("cantidad").value;
				  //var i = 1; //contador para asignar id al boton que borrara la fila
				  c++;
				  //var fila = '<tr>';
				  var fila = '<tr class="item"><td><input id="nDiaVac' + c + '" name="nDiaVac[' + c + ']" type="text" style="width: 150px; height: 28px" value="'+diasVac+'" disabled />  </td> ';
				  fila = fila + '<td><button type="button" name="remove" id="' + c + '" class="btn btn-danger btn_remove">Quitar</button></td> </tr>';
				  //'<tr id="row' + i + '"><td>indicacion + '</td><td>' + cantidad + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila
				  $('#ProSelected').append(fila);
				  $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
				  var nFilas = $("#mytable tr").length;
				  $("#adicionados").append(nFilas - 1);
				  //le resto 1 para no contar la fila del header
				  document.getElementById("diasVac").value = "";
				  document.getElementById("diasVac").focus();
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

				$('input[name^="nDiaVac"]').each(function() {
				 //alert($(this).val());
				 ip.push($(this).val().trim());
				});
				
				var ipt=JSON.stringify(ip);
				$('#ListaPro').val(encodeURIComponent(ipt));
        		//document.getElementById("valores").innerHTML = ipt;
			}
		</script>
    </body>
</html>