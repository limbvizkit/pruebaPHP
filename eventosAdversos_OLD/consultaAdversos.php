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
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CONSULTA EVENTOS ADVERSOS</title>
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
						<h1>HISTÓRICO EVENTOS ADVERSOS</h1>
						<span>*Si desea ver todos los campos, modificar o borrar un registro dar click cobre el</span>
						<table id="simple" class="display">
							<thead>
								<tr>
									<th >No.</th>
									<th style="display: none">id</th>
									<th>FECHA DE CAPTURA</th>
									<th>EXPEDIENTE</th>
									<th>FOLIO</th>
									<th>REPORTA </th>
									<th>SERVICIO </th>
									<th>TIPO DE EVENTO </th>
									<th>DIAGNÓSTICO </th>
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
									<th style="display: none">1</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$queryDocs = "SELECT *
												  FROM eventoadverso
												  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
												  ORDER BY fecha";
									$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
									$c=1;
									while($row = mysqli_fetch_array($docs)){
										$fecha = strtotime($row['fecha']);
										$fechaFin = date('d/m/Y',$fecha);
								?>
								<tr id="nota">
									<td><?php echo $c++ ?></td>
									<td id="idAdverso1" style="display: none"><?php echo $row['id'] ?></td>
									<td id="fecha1"><?php echo $fechaFin ?></td>
									<td id="expedi1"><?php echo $row['numeroExpediente'] ?></td>
									<td id="fol1"><?php echo $row['folio'] ?></td>
									<td id="repo1"><?php echo utf8_encode($row['reporta']) ?></td>
									<td id="serv1"><?php echo utf8_encode($row['servicio']) ?></td>
									<td id="tipEv1"><?php echo utf8_encode($row['tipoEvento']) ?></td>
									<td id="turno1" style="display: none"><?php echo $row['turno'] ?></td>
									<td id="diagno1"><?php echo utf8_encode($row['diag']) ?></td>
									<td id="rel1" style="display: none"><?php echo $row['relacionado'] ?></td>
									<td id="alcP1" style="display: none"><?php echo $row['alcanzoPac'] ?></td>
									<td id="danio1" style="display: none"><?php echo $row['danioPac'] ?></td>
									<td id="ev1" style="display: none"><?php echo utf8_encode($row['evento']) ?></td>
									<td id="com1" style="display: none"><?php echo utf8_encode($row['como']) ?></td>
									<td id="por1" style="display: none"><?php echo utf8_encode($row['porQue']) ?></td>
									<td id="med1" style="display: none"><?php echo utf8_encode($row['medicamento']) ?></td>
									<td id="gen1" style="display: none"><?php echo utf8_encode($row['generico']) ?></td>
									<td id="pres1" style="display: none"><?php echo utf8_encode($row['presentacion']) ?></td>
									<td id="dss1" style="display: none"><?php echo utf8_encode($row['dosis']) ?></td>
									<td id="viaa1" style="display: none"><?php echo utf8_encode($row['viaAdmin']) ?></td>
									<td id="inter1" style="display: none"><?php echo utf8_encode($row['intervalo']) ?></td>
									<td id="a1" style="display: none"><?php echo $row['aim'] ?></td>
									<td id="a2" style="display: none"><?php echo $row['cidt'] ?></td>
									<td id="a3" style="display: none"><?php echo $row['ciam'] ?></td>
									<td id="a4" style="display: none"><?php echo $row['dim'] ?></td>
									<td id="a5" style="display: none"><?php echo $row['eii'] ?></td>
									<td id="a6" style="display: none"><?php echo $row['fimar'] ?></td>
									<td id="a8" style="display: none"><?php echo $row['mcmc'] ?></td>
									<td id="a7" style="display: none"><?php echo $row['licim'] ?></td>
									<td id="a9" style="display: none"><?php echo $row['fma'] ?></td>
									<td id="a10" style="display: none"><?php echo $row['manp'] ?></td>
									<td id="b1" style="display: none"><?php echo $row['fdvpam'] ?></td>
									<td id="b2" style="display: none"><?php echo $row['frmec'] ?></td>
									<td id="b3" style="display: none"><?php echo $row['ficp'] ?></td>
									<td id="b4" style="display: none"><?php echo $row['ampi'] ?></td>
									<td id="b5" style="display: none"><?php echo $row['amnp'] ?></td>
									<td id="b6" style="display: none"><?php echo $row['omisionMed'] ?></td>
									<td id="b7" style="display: none"><?php echo $row['ami'] ?></td>
									<td id="b8" style="display: none"><?php echo $row['presInc'] ?></td>
									<td id="b9" style="display: none"><?php echo $row['transInc'] ?></td>
									<td id="c1" style="display: none"><?php echo $row['prepInc'] ?></td>
									<td id="c2" style="display: none"><?php echo $row['dispoInc'] ?></td>
									<td id="c3" style="display: none"><?php echo $row['tai'] ?></td>
									<td id="c4" style="display: none"><?php echo $row['vai'] ?></td>
									<td id="c5" style="display: none"><?php echo $row['adpi'] ?></td>
									<td id="c6" style="display: none"><?php echo $row['dti'] ?></td>
									<td id="c7" style="display: none"><?php echo $row['hai'] ?></td>
									<td id="c8" style="display: none"><?php echo $row['ifi'] ?></td>
									<td id="c9" style="display: none"><?php echo $row['vii'] ?></td>
									<td id="d1" style="display: none"><?php echo $row['ot'] ?></td>
									<td id="d2" style="display: none"><?php echo utf8_encode($row['otros']) ?></td>
									<td id="fecha2" style="display: none"><?php echo $row['fecha'] ?></td>
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
				idEvAdverso = $(nTds[1]).text();
				fecha  = $(nTds[2]).text();
				exp  = $(nTds[3]).text();
				folio  = $(nTds[4]).text();
				reporta = $(nTds[5]).text();
				servicio = $(nTds[6]).text();  
				tipoEvento = $(nTds[7]).text();
				turno  = $(nTds[8]).text();
				diag  = $(nTds[9]).text();
				relacionado = $(nTds[10]).text();
				alcanzoPac = $(nTds[11]).text();
				danioPac = $(nTds[12]).text();
				evento = $(nTds[13]).text();
				como = $(nTds[14]).text();
				porQue = $(nTds[15]).text();
				medicamento = $(nTds[16]).text();
				generico = $(nTds[17]).text();
				presentacion = $(nTds[18]).text();
				dosis = $(nTds[19]).text();
				viaAdmin = $(nTds[20]).text();
				intervalo = $(nTds[21]).text();
				aim = $(nTds[22]).text();
				cidt = $(nTds[23]).text();
				ciam = $(nTds[24]).text();
				dim = $(nTds[25]).text();
				eii = $(nTds[26]).text();
				fimar = $(nTds[27]).text();
				mcmc = $(nTds[28]).text();
				licim = $(nTds[29]).text();
				fma = $(nTds[30]).text();
				manp = $(nTds[31]).text();
				fdvpam = $(nTds[32]).text();
				frmec = $(nTds[33]).text();
				ficp = $(nTds[34]).text();
				ampi = $(nTds[35]).text();
				amnp = $(nTds[36]).text();
				omisionMed = $(nTds[37]).text();
				ami = $(nTds[38]).text();
				presInc = $(nTds[39]).text();
				transInc = $(nTds[40]).text();
				prepInc = $(nTds[41]).text();
				dispoInc = $(nTds[42]).text();
				tai = $(nTds[43]).text();
				vai = $(nTds[44]).text();
				adpi = $(nTds[45]).text();
				dti = $(nTds[46]).text();
				hai = $(nTds[47]).text();
				ifi = $(nTds[48]).text();
				vii = $(nTds[49]).text();
				ot = $(nTds[50]).text();
				otros = $(nTds[51]).text();
				fechaB = $(nTds[52]).text();

				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='../img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarAdversos.php",{idEvAdverso:idEvAdverso,fecha:fecha,exp:exp,folio:folio,reporta:reporta, servicio:servicio,
				tipoEvento:tipoEvento ,turno:turno ,diag:diag ,relacionado:relacionado, alcanzoPac:alcanzoPac, danioPac:danioPac, evento:evento, 
				como:como, porQue:porQue, medicamento:medicamento, generico:generico, presentacion:presentacion, dosis:dosis, viaAdmin:viaAdmin,
				intervalo:intervalo, aim:aim, cidt:cidt, ciam:ciam, dim:dim, eii:eii, fimar:fimar, mcmc:mcmc, licim:licim, fma:fma, manp:manp,
				fdvpam:fdvpam, frmec:frmec,ficp:ficp, ampi:ampi, amnp:amnp, omisionMed:omisionMed, ami:ami, presInc:presInc, transInc:transInc,
				prepInc:prepInc, dispoInc:dispoInc, tai:tai, vai:vai, adpi:adpi, dti:dti ,hai:hai, ifi:ifi, vii:vii, ot:ot, otros:otros, fechaB:fechaB} ,function(){
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