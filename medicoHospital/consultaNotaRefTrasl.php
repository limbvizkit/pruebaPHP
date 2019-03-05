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
			  FROM notaReferenciaTrash
			  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
			  ORDER BY fecha, hora";
	$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
	$c=1;
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CONSULTA HISTÓRICO NOTA DE REFERENCIA Y TRASLADO</title>
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
							<h1>HISTÓRICO NOTAS DE REFERENCIA Y TRASLADO</h1>
							<span>*Si desea ver todos los campos, modificar o borrar un registro dar click cobre el</span>
						<table id="simple" class="display">
							<thead>
								<tr>
									<th >No.</th>
									<th style="display: none">ID</th>
									<th>FECHA</th>
									<th>HORA</th>
									<th>TIPO DE TRASLADO</th>
									<th>ESTABLECIMIENTO RECEPTOR</th>
									<th></th>
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
									<th style="display: none">18</th>
									<th style="display: none">18</th>
									<th style="display: none">18</th>
									<th style="display: none">18</th>
									<th style="display: none">18</th>
									<th style="display: none">18</th>
									<th style="display: none">18</th>
									<th style="display: none">18</th>
								</tr>
							</thead>
							<tbody>
								<?php
									while($row = mysqli_fetch_array($docs)){
										$fecha = strtotime($row['fecha']);
										$fechaFin = date('d/m/Y',$fecha);
										
										$hora = strtotime($row['hora']);
										$horaFin = date('H:i',$hora);
								?>
								<tr id="nota">
									<td><?php echo $c++ ?></td>
									<td style="display: none"><?php echo $row['id'] ?></td>
									<td><?php echo $fechaFin ?></td>
									<td><?php echo $horaFin.'hrs' ?></td>
									<td><?php echo utf8_encode($row['tipoTraslado']) ?></td>
									<td><?php echo utf8_encode($row['receptor']) ?></td>
									<td><?php echo utf8_encode($row['otroReceptor']) ?></td>
									<td style="display: none"><?php echo $row['hora'] ?></td>
									<td style="display: none"><?php echo $row['fecha'] ?></td>
									<td style="display: none"><?php echo $row['turno'] ?></td>
									<td style="display: none"><?php echo $row['servicio'] ?></td>
									<td style="display: none"><?php echo $row['ambulanciaTecno'] ?></td>
									<td style="display: none"><?php echo $row['tipoPaciente'] ?></td>
									<td style="display: none"><?php echo $row['oxigeno'] ?></td>
									<td style="display: none"><?php echo $row['desfibrilador'] ?></td>
									<td style="display: none"><?php echo $row['ventilador'] ?></td>
									<td style="display: none"><?php echo $row['incubadora'] ?></td>
									<td style="display: none"><?php echo $row['envia'] ?></td>
									<td style="display: none"><?php echo $row['fc'] ?></td>
									<td style="display: none"><?php echo $row['fr'] ?></td>
									<td style="display: none"><?php echo $row['ta'] ?></td>
									<td style="display: none"><?php echo $row['temp'] ?></td>									
									<td style="display: none"><?php echo $row['peso'] ?></td>
									<td style="display: none"><?php echo $row['talla'] ?></td>
									<td style="display: none"><?php echo utf8_encode($row['motivoEnvio']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['impresionDiag']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['terapeuticaEmpl']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['cedulaMedEntrega']) ?></td>
									<td style="display: none"><?php echo $row['fechaExt'] ?></td>
									<td style="display: none"><?php echo $row['horaExt'] ?></td>
									<td style="display: none"><?php echo $row['estable'] ?></td>
									<td style="display: none"><?php echo $row['turnoExt'] ?></td>
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
				idNotaRefTraslh = $(nTds[1]).text();
				fecha = $(nTds[2]).text();
				hora = $(nTds[3]).text();
				tipoTraslado = $(nTds[4]).text();
				receptor = $(nTds[5]).text();
				otroReceptor = $(nTds[6]).text();
				horaFin = $(nTds[7]).text();
				fechaFin = $(nTds[8]).text();
				turno = $(nTds[9]).text();
				servicio = $(nTds[10]).text();
				ambulanciaTecno = $(nTds[11]).text();
				tipoPaciente = $(nTds[12]).text();
				oxigeno = $(nTds[13]).text();
				desfibrilador = $(nTds[14]).text();
				ventilador = $(nTds[15]).text();
				incubadora = $(nTds[16]).text();
				envia = $(nTds[17]).text();
				fc = $(nTds[18]).text();
				fr = $(nTds[19]).text();
				ta = $(nTds[20]).text();
				temp = $(nTds[21]).text();
				peso = $(nTds[22]).text();
				talla = $(nTds[23]).text();
				motivoEnvio = $(nTds[24]).text();
				impresionDiag = $(nTds[25]).text();
				terapeuticaEmpl = $(nTds[26]).text();
				cedulaMedEntrega = $(nTds[27]).text();
				fechaExt = $(nTds[28]).text();
				horaExt = $(nTds[29]).text();
				estable = $(nTds[30]).text();
				turnoExt = $(nTds[31]).text();
				

				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='../img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarRefTrasl.php",{idNotaRefTraslh:idNotaRefTraslh,fecha:fecha,hora:hora,tipoTraslado:tipoTraslado,receptor:receptor,otroReceptor:otroReceptor,horaFin:horaFin,fechaFin:fechaFin,turno:turno,servicio:servicio,ambulanciaTecno:ambulanciaTecno,tipoPaciente:tipoPaciente,oxigeno:oxigeno,desfibrilador:desfibrilador,ventilador:ventilador,incubadora:incubadora,envia:envia,fc:fc,fr:fr,ta:ta,temp:temp,peso:peso,talla:talla,motivoEnvio:motivoEnvio,impresionDiag:impresionDiag,terapeuticaEmpl:terapeuticaEmpl,cedulaMedEntrega:cedulaMedEntrega,fechaExt:fechaExt,horaExt:horaExt,estable:estable,turnoExt:turnoExt} ,function(){
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
			height: 95%;
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