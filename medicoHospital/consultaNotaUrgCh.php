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
        <title>CONSULTA NOTAS URGENCIA CHOQUE</title>
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
							<h1>HISTÓRICO NOTAS URGENCIAS CHOQUE</h1>
							<span>*Si desea ver todos los campos, modificar o borrar un registro dar click cobre el</span>
						<table id="simple" class="display">
							<thead>
								<tr>
									<th >No.</th>
									<th style="display: none">11</th>
									<th>FECHA</th>
									<th>HORA</th>
									<th style="display: none">0</th>
									<th style="display: none">0</th>
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
									<th style="display: none">1</th>
									<th style="display: none">2</th>
									<th style="display: none">3</th>
									<th style="display: none">4</th>
									<th style="display: none">5</th>
									<th style="display: none">6</th>
									<th style="display: none">7</th>
									<th style="display: none">7</th>
									<th style="display: none">7</th>
									<th>NOMBRE DEL PACIENTE</th>
									<th style="display: none">7</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$queryDocs = "SELECT *
												  FROM notaurgchoque
												  WHERE estatus='1'
												  ORDER BY (fecha) DESC, hora";
									$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
									$c=1;
									while($row = mysqli_fetch_array($docs)){
										$fecha = strtotime($row['fecha']);
										$fechaFin = date('d/m/Y',$fecha);
										
										$hora = strtotime($row['hora']);
										$horaFin = date('H:i',$hora);
								?>
								<tr id="nota">
									<td><?php echo $c++ ?></td>
									<td id="idNotaCh" style="display: none"><?php echo $row['id'] ?></td>
									<td id="fechaMed1"><?php echo $fechaFin ?></td>
									<td id="horaMed1"><?php echo $horaFin.'hrs' ?></td>
									<td id="anteced1" style="display: none"><?php echo utf8_encode($row['antecedentes']) ?></td>
									<td id="trata1" style="display: none"><?php echo utf8_encode($row['tratamiento']) ?></td>
									<td id="interr1" style="display: none"><?php echo utf8_encode($row['interrogatorio']) ?></td>
									<td id="fc1" style="display: none"><?php echo $row['fc'] ?></td>
									<td id="fr1" style="display: none"><?php echo $row['fr'] ?></td>
									<td id="ta1" style="display: none"><?php echo $row['ta'] ?></td>
									<td id="temp1" style="display: none"><?php echo $row['temp'] ?></td>
									<td id="so1" style="display: none"><?php echo $row['so'] ?></td>
									<td id="respOcul1" style="display: none"><?php echo $row['respOcul'] ?></td>
									<td id="respVerb1" style="display: none"><?php echo $row['respVerb'] ?></td>
									<td id="respMot1" style="display: none"><?php echo $row['respMot'] ?></td>
									<td id="habExt1" style="display: none"><?php echo utf8_encode($row['habExt']) ?></td>
									<td id="cab1" style="display: none"><?php echo utf8_encode($row['cabeza']) ?></td>
									<td id="tor1" style="display: none"><?php echo utf8_encode($row['torax']) ?></td>
									<td id="abd1" style="display: none"><?php echo utf8_encode($row['abdomen']) ?></td>
									<td id="ext1" style="display: none"><?php echo utf8_encode($row['extremidades']) ?></td>
									<td id="bhc1" style="display: none"><?php echo $row['bhc'] ?></td>							
									<td id="qs1" style="display: none"><?php echo $row['qs'] ?></td>
									<td id="tpt1" style="display: none"><?php echo $row['tpt'] ?></td>
									<td id="rx1" style="display: none"><?php echo $row['rx'] ?></td>
									<td id="tac1" style="display: none"><?php echo $row['tac'] ?></td>
									<td id="rm1" style="display: none"><?php echo $row['rm'] ?></td>
									<td id="us1" style="display: none"><?php echo $row['us'] ?></td>
									<td id="paraclin1" style="display: none"><?php echo utf8_encode($row['paraclin']) ?></td>
									<td id="dia1" style="display: none"><?php echo utf8_encode($row['diag']) ?></td>
									<td id="tratUtil1" style="display: none"><?php echo utf8_encode($row['tratUtil']) ?></td>
									<td id="tratUtil2" style="display: none"><?php echo utf8_encode($row['tratUtilTxt']) ?></td>
									<td id="inter1" style="display: none"><?php echo utf8_encode($row['interconsulta']) ?></td>
									<td id="horaSol1" style="display: none"><?php echo $row['horaSol'] ?></td>
									<td id="especialidad1" style="display: none"><?php echo utf8_encode($row['especialidad']) ?></td>
									<td id="horaAcud1" style="display: none"><?php echo $row['horaAcud'] ?></td>
									<td id="vida1" style="display: none"><?php echo utf8_encode($row['vida']) ?></td>
									<td id="funcion1" style="display: none"><?php echo utf8_encode($row['funcion']) ?></td>
									<td id="ingresa1" style="display: none"><?php echo utf8_encode($row['ingresa']) ?></td>
									<td id="cedula1" style="display: none"><?php echo $row['cedula'] ?></td>
									<td id="exp1" style="display: none"><?php echo $row['numeroExpediente'] ?></td>
									<td id="folio1" style="display: none"><?php echo $row['folio'] ?></td>
									<td id="turno1" style="display: none"><?php echo $row['turno'] ?></td>
									<td id="acude" style="display: none"><?php echo $row['acude'] ?></td>
									<td id="nPaciente1"> <?php echo utf8_encode($row['nPaciente']) ?></td>
									<td id="gluc" style="display: none"><?php echo $row['glucosa'] ?></td>
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
				idNotaCh = $(nTds[1]).text();
				fecha  = $(nTds[2]).text();
				hora = $(nTds[3]).text();
				antece  = $(nTds[4]).text();
				tratam  = $(nTds[5]).text();				
				inter  = $(nTds[6]).text();
				fc  = $(nTds[7]).text();
				fr  = $(nTds[8]).text();
				ta  = $(nTds[9]).text();
				temp  = $(nTds[10]).text();
				so  = $(nTds[11]).text();
				respOcul = $(nTds[12]).text();
				respVerb  = $(nTds[13]).text();
				respMot  = $(nTds[14]).text();				  
				habEx  = $(nTds[15]).text();
				cabez  = $(nTds[16]).text();
				torax  = $(nTds[17]).text();
				abdom  = $(nTds[18]).text();
				extrm  = $(nTds[19]).text();
				bhc = $(nTds[20]).text();
				qs = $(nTds[21]).text();
				tpt = $(nTds[22]).text();
				rx = $(nTds[23]).text();
				tac = $(nTds[24]).text();
				rm = $(nTds[25]).text();
				us = $(nTds[26]).text();
				paraclin = $(nTds[27]).text();
				diagn  = $(nTds[28]).text();
			 	tratUtil  = $(nTds[29]).text();
				tratUtilTxt  = $(nTds[30]).text();
				interconsulta  = $(nTds[31]).text();
				horaSol  = $(nTds[32]).text();
				especialidad  = $(nTds[33]).text();
				horaAcud  = $(nTds[34]).text();
				vida  = $(nTds[35]).text();
				funcion  = $(nTds[36]).text();
				ingresa  = $(nTds[37]).text();
				cedula  = $(nTds[38]).text();
				exp  = $(nTds[39]).text();
				folio  = $(nTds[40]).text();
				turno  = $(nTds[41]).text();
				acude  = $(nTds[42]).text();
				nPaciente = $(nTds[43]).text();
				glucosa = $(nTds[44]).text();

				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='../img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarNota.php",{idNotaCh:idNotaCh,hora:hora,antece:antece,tratam:tratam,inter:inter,fc:fc,fr:fr,ta:ta,temp:temp,so:so,glucosa:glucosa,respOcul:respOcul,respVerb:respVerb,respMot:respMot,habEx:habEx,cabez:cabez,torax:torax,abdom:abdom,extrm:extrm,bhc:bhc,qs:qs,tpt:tpt,rx:rx,tac:tac,rm:rm,us:us,paraclin:paraclin,diagn:diagn,tratUtil:tratUtil,tratUtilTxt:tratUtilTxt,interconsulta:interconsulta,horaSol:horaSol,especialidad:especialidad,horaAcud:horaAcud,vida:vida,funcion:funcion,ingresa:ingresa,cedula:cedula,exp:exp,folio:folio,fecha:fecha,turno:turno,acude:acude,nPaciente:nPaciente} ,function(){
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