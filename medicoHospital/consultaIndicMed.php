<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configMedico.php');

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
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CONSULTA INDICACIONES MED</title>
        <!-- Google Font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<!-- BootStrap Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/bootstrap/css/bootstrap.min.css"-->
		<!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" >
		<!-- Font-Awesome Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/font-awesome/css/font-awesome.min.css"-->
		<!--link rel="stylesheet" href="./tabs_files/font-awesome.css"-->
		
		<!-- Plugin Custom Stylesheet -->
		<link rel="stylesheet" href="css/form-wizard-blue.css">
		<link href="css/switcher.css" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css">

		<!--*****
		If you need to change the form color then you have to just change the CSS file name!! Do it very simply, like as "form-wizard-red.css" for make it red color. Our template other colors name is there ( black, blue, red, pink, purple, teal, green, yellow, orange, brown, cyan, lime ). Replace the name and make it awesome!!!*****-->
    </head>
    <body>		
        <!-- main content -->
        <section class="form-box">
            <div class="container">
                <!--div class="row"-->
                    <!--div class="col-sm-20"-->
						<!-- Form Wizard -->
						<!--div class="form-wizard form-header-stylist form-body-stylist"-->
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
							<h1>HISTÓRICO INDICACIONES MÉDICAS</h1>
							<span>*Si desea ver todos los campos, modificar o borrar un registro dar click cobre el</span>
						<table id="simple" class="display">
							<thead>
								<tr>
									<th >No.</th>
									<th style="display: none">id</th>
									<th style="display: none">FECHA DE CAPTURA</th>
									<th>NOMBRE DEL PACIENTE</th>
									<th>FECHA NACIMIENTO </th>
									<th>DIAGNÓSTICO </th>
									<th>MÉDICO TRATANTE </th>
									<th style="display: none">0</th>
									<th style="display: none">0</th>
									<th style="display: none">1</th>
									<th style="display: none">2</th>
									<th style="display: none">1</th>
									<th style="display: none">2</th>
									<th style="display: none">1</th>
									<th style="display: none">2</th>
									<th style="display: none">1</th>
									<th style="display: none">1</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$queryDocs = "SELECT *
												  FROM indicacionesmedicas
												  WHERE estatus='1'
												  ORDER BY (fechaG) DESC, horaG";
									$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
									$c=1;
									while($row = mysqli_fetch_array($docs)){
										$fecha = strtotime($row['fechaG']);
										$fechaFin = date('d/m/Y',$fecha);
										
										$fechaN = strtotime($row['fNacimiento']);
										$fechaFinN = date('d/m/Y',$fechaN);
										
										/*$hora = strtotime($row['hora']);
										$horaFin = date('H:i',$hora);*/
								?>
								<tr id="nota">
									<td><?php echo $c++ ?></td>
									<td id="idIndicMed1" style="display: none"><?php echo $row['id'] ?></td>
									<td id="fecha1" style="display: none"><?php echo $fechaFin ?></td>
									<td id="nPaciente1"> <?php echo utf8_encode($row['nPaciente']) ?></td>
									<td id="fechaNac1"><?php echo $fechaFinN ?></td>
									<td id="diagnost1"><?php echo utf8_encode($row['diagnostico']) ?></td>
									<td id="medTra1"><?php echo utf8_encode($row['medTratante']) ?></td>
									<td id="exp1" style="display: none"><?php echo $row['numeroExpediente'] ?></td>
									<td id="folio1" style="display: none"><?php echo $row['folio'] ?></td>
									<td id="alergias1" style="display: none"><?php echo utf8_encode($row['alergias']) ?></td>
									<td id="indic1" style="display: none"><?php echo utf8_encode($row['indicacion']) ?></td>
									<td id="fnaci1" style="display: none"><?php echo $row['fNacimiento'] ?></td>
									<td id="fnaci1" style="display: none"><?php echo $row['fechaG'] ?></td>
									<td id="horag1" style="display: none"><?php echo $row['horaG'] ?></td>
									<td id="fechaI1" style="display: none"><?php echo $row['fechaInd'] ?></td>
									<td id="horaI1" style="display: none"><?php echo $row['horaInd'] ?></td>
									<td id="ced1" style="display: none"><?php echo $row['cedula'] ?></td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
						<!--/div-->
						<!-- Form Wizard -->
                    <!--/div-->
					<div class="div_User" id="div_User"></div>
                <!--/div-->
            </div>
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-primary" value="RECARGAR LISTADO" onclick ="location.reload()" style="width: 200px; height: 61px"/>
			<!--form action="excel.php" method = "post">
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><span class="auto-style7">HISTORICO TEMPERATURA EN EXCEL 
			<br/></span> <br/>
			&nbsp;&nbsp;<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required/>
			<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
			<input type="date" name="fecha2" style="height: 40px" required /></strong>
			<br/>
			<br/>
			<input type="hidden" name="nombre" value="MedicionesTemperatura" />
			&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
			<br/>
			</form-->
			<br/>
			<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 200px; height: 61px" />
        </section>

		<!-- main content -->

        <!-- Jquery JS -->
        <!--script src="../js/jquery-1.11.1.min.js"></script-->
		<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
		
		<!-- bootStrap JS -->
		<script src="../js/bootstrap.min.js"></script>
		
		<!-- Plugin Custom JS -->
        <!--script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script-->
        <!-- Plugin Custom JS -->
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
          		$("#div_User").hide();
        	});
			
			$(document).ready(function() {
				$('#simple').dataTable({
					"language": {
						"lengthMenu": "Mostrar _MENU_ Filas",
						"zeroRecords": "Sin Resultados - Intente otra frase",
						"info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE NOTAS _MAX_",
						"infoEmpty": "Sin Tomas",
						"infoFiltered": "(Total _TOTAL_ filas)",
						"sSearch":"Buscar",
						"paginate": {
						  "next": "Siguiente",
						  "sPrevious":"Anterior"
						}
					}
				});
			});
			 //Evaluamos los clic en los registros
			$(document).ready(function() {
			  //$('#tblUser tbody tr').live('click', function () {
			  $('#simple').on('click', '#nota', function () {
					//var sTitle;
				var nTds = $('td', this);
				idIndicMed = $(nTds[1]).text();
				fecha  = $(nTds[2]).text();
				nPaciente = $(nTds[3]).text();
				fNacimiento = $(nTds[11]).text();
				diagnostico = $(nTds[5]).text();				
				medTratante  = $(nTds[6]).text();
				exp  = $(nTds[7]).text();
				folio  = $(nTds[8]).text();
				alergias  = $(nTds[9]).text();
				indicacion  = $(nTds[10]).text();
				fechaG =  $(nTds[12]).text();
				horaG =  $(nTds[13]).text();
				fechaInd =  $(nTds[14]).text();
				horaInd =  $(nTds[15]).text();
				cedula =  $(nTds[16]).text();

				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='../img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarNota.php",{idIndicMed:idIndicMed,nPaciente:nPaciente,fNacimiento:fNacimiento,diagnostico:diagnostico,medTratante:medTratante,exp:exp,folio:folio,alergias:alergias,indicacion:indicacion,fechaG:fechaG,horaG:horaG,fechaInd:fechaInd,horaInd:horaInd,cedula:cedula} ,function(){
				  $("#cargando").css("display", "none");
				});
			  });
			 });
		</script>
		
		<style type="text/css">
		  .div_User{
			position: absolute;
			top: 5%;
			left: 10%;
			width: 80%;
			height: 90%;
			padding: 16px;
			background: linear-gradient(to left, white, rgba(68, 127, 191, 0.9));
			border: double;
			color: #333;
			z-index:1002;
			overflow: auto;
		  }
    </style>
    </body>

</html>