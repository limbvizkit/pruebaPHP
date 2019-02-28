<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configMedico.php');

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
	$queryDocs = "SELECT *
			  FROM notaegreso
			  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
			  ORDER BY fecha";
	$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
	$c=1;
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CONSULTA NOTA EGRESO</title>
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
							<h1>NOTA DE EGRESO</h1>
							<span>*Si desea ver todos los campos, modificar o borrar un registro dar click cobre el</span>
						<table id="simple" class="display">
							<thead>
								<tr>
									<th >No.</th>
									<th style="display: none">ID</th>
									<th>FECHA</th>
									<th>HORA</th>
									<th>Diagnostico Ingreso</th>
									<th>Diagnostico Egreso</th>
									<th style="display: none">1</th>
									<th style="display: none">2</th>
									<th style="display: none">3</th>
									<th style="display: none">4</th>
									<th style="display: none">5</th>
									<th style="display: none">6</th>
									<th style="display: none">7</th>
									<th style="display: none">8</th>
									<th style="display: none">9</th>
									<th style="display: none">10</th>
									<th style="display: none">11</th>
									<th style="display: none">12</th>
									<th style="display: none">13</th>
									<th style="display: none">14</th>
									<th style="display: none">15</th>
									<th style="display: none">16</th>
									<th style="display: none">17</th>
									<th style="display: none">18</th>
								</tr>
							</thead>
							<tbody>
								<?php
									while($row = mysqli_fetch_array($docs)){
										$fecha = strtotime($row['fechaEgreso']);
										$fechaFin = date('d/m/Y',$fecha);
										
										$fecha1 = strtotime($row['fechaEgreso']);
										$fechaFin1 = date('Y-m-d',$fecha1);
										
										$hora = strtotime($row['horaEgreso']);
										$horaFin = date('H:i',$hora);
								?>
								<tr id="nota">
									<td><?php echo $c++ ?></td>
									<td style="display: none"><?php echo $row['id'] ?></td>
									<td><?php echo $fechaFin ?></td>
									<td><?php echo $horaFin.'hrs' ?></td>
									<td ><?php echo utf8_encode($row['diagnosticoIngreso']) ?></td>
									<td><?php echo utf8_encode($row['diagnosticoEgreso']) ?></td>
									<td style="display: none"><?php echo $fechaFin1 ?></td>
									<td style="display: none"><?php echo $row['horaEgreso'] ?></td>
									<td style="display: none"><?php echo utf8_encode($row['motivoEgreso']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['resumenEvolucion']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['manejoTratamiento']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['problemasClinicos']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['recomendacionesVigilancia']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['pronosticoVida']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['pronosticoFuncion']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['diagnosticos']) ?></td>
									<td style="display: none"><?php echo $row['cedula'] ?></td>
									<td style="display: none"><?php echo utf8_encode($row['nombreMedicoTratante']) ?></td>
									<td style="display: none"><?php echo $row['tabaquismo'] ?></td>
									<td style="display: none"><?php echo $row['alcohol'] ?></td>
									<td style="display: none"><?php echo $row['otras'] ?></td>
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
				idNotaEgreso = $(nTds[1]).text();
				fecha = $(nTds[2]).text();
				hora = $(nTds[3]).text();
				diagnosticoIngreso  = $(nTds[4]).text();
				diagnosticoEgreso  = $(nTds[5]).text();
				fechaFin  = $(nTds[6]).text();
				horaFin  = $(nTds[7]).text();
				motivoEgreso  = $(nTds[8]).text();
				resumenEvolucion  = $(nTds[9]).text();
				manejoTratamiento  = $(nTds[10]).text();
				problemasClinicos  = $(nTds[11]).text();
				recomendacionesVigilancia = $(nTds[12]).text();
				pronosticoVida = $(nTds[13]).text();
				pronosticoFuncion = $(nTds[14]).text();
				diagnosticos  = $(nTds[15]).text();
				cedula  = $(nTds[16]).text();
				nombreMedicoTratante  = $(nTds[17]).text();
				tabaquismo = $(nTds[18]).text();
				alcohol = $(nTds[19]).text();
				otras = $(nTds[20]).text();
				

				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='../img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarNotaEgreso.php",{idNotaEgreso:idNotaEgreso,fecha:fecha,hora:hora,diagnosticoIngreso:diagnosticoIngreso,diagnosticoEgreso:diagnosticoEgreso,fechaFin:fechaFin,horaFin:horaFin,motivoEgreso:motivoEgreso,resumenEvolucion:resumenEvolucion,manejoTratamiento:manejoTratamiento,problemasClinicos:problemasClinicos,recomendacionesVigilancia:recomendacionesVigilancia,pronosticoVida:pronosticoVida,pronosticoFuncion:pronosticoFuncion,diagnosticos:diagnosticos,cedula:cedula,nombreMedicoTratante:nombreMedicoTratante,tabaquismo:tabaquismo,alcohol:alcohol,otras:otras},function(){
				  $("#cargando").css("display", "none");
				});
			  });
			 });
		</script>
		
		<style type="text/css">
		  .div_User{
			position: absolute;
			top: 5%;
			left: 25%;
			width: 60%;
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