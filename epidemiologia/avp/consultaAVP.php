<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../../conexion/configEpidemio.php');

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
        <title>CONSULTA AVP</title>
        <!-- Google Font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<!-- BootStrap Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/bootstrap/css/bootstrap.min.css"-->
		<!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" -->
		<link rel="stylesheet" href="../../css/bootstrap.min.css" >		
		<!-- Font-Awesome Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/font-awesome/css/font-awesome.min.css"-->
		<!--link rel="stylesheet" href="./tabs_files/font-awesome.css"-->
		
		<!-- Plugin Custom Stylesheet -->
		<link rel="stylesheet" href="../css/form-wizard-blue.css">
		<link href="../css/switcher.css" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css">

		<!--*****
		If you need to change the form color then you have to just change the CSS file name!! Do it very simply, like as "form-wizard-red.css" for make it red color. Our template other colors name is there ( black, blue, red, pink, purple, teal, green, yellow, orange, brown, cyan, lime ). Replace the name and make it awesome!!!*****-->
    </head>
    <body>		
        <!-- main content -->
        <section class="form-box">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-stylist form-body-stylist">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
							<h1>ACCESOS VASCULARES PERIFERICOS </h1>
							<span>*Si desea modificar o borrar un registro dar click cobre el</span>
						<table id="simple" class="display">
							<thead>
								<tr>
									<th >No.</th>
									<th>Fecha de Instalación</th>
									<th>Fecha de Retiro</th>
									<th>Verificador</th>
									<th>Instalo</th>
									<th>Observaciones</th>
									<th style="display: none"></th>
									<th style="display: none"></th>
									<th style="display: none"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$queryDocs = "SELECT *
												  FROM instalacionavp
												  WHERE numeroExpediente='$expediente' AND folio='$folio'
												  ORDER BY fechaInstalacion";
									$docs = mysqli_query($conexionEpidemio, $queryDocs) or die (mysqli_error($conexionEpidemio));
									$c=1;
									while($row = mysqli_fetch_array($docs)){
										$fecha = strtotime($row['fechaInstalacion']);
										$fechaFin = date('d/m/Y',$fecha);
										$fecha1 = strtotime($row['fechaFin']);
										$fechaFin1 = date('d/m/Y',$fecha1);
										if($fechaFin1 == '01/01/1970'){
											$fechaFin1 = NULL;
										}
										
										/*$hora = strtotime($row['horaVisita']);
										$horaFin = date('H:i',$hora);*/
								?>
								<tr id="vig">
									<td><?php echo $c++ ?></td>
									<td id="idVigilancia" style="display: none"><?php echo $row['id'] ?></td>
									<td id="fechaIns"><?php echo $fechaFin ?></td>
									<td id="fechaRe"><?php echo $fechaFin1 ?></td>
									<td id="metaVis"><?php echo utf8_encode($row['verificador']) ?></td>
									<td id="vigRPBIVig"><?php echo utf8_encode($row['nombreInstalo']) ?></td>
									<td id="inmunoCompVig"><?php echo utf8_encode($row['observaciones']) ?></td>
									<td id="fechaVis" style="display: none"><?php echo $row['fechaInstalacion'] ?></td>
									<td id="fechaRet" style="display: none"><?php echo  $row['fechaFin'] ?></td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
						</div>
						<!-- Form Wizard -->
                    </div>
					<div class="div_User" id="div_User"></div>
                </div>                    
            </div>
			<br>&nbsp;&nbsp;
			<input type="button" class="btn btn-primary" value="RECARGAR LISTADO" onclick ="location.reload()" style="width: 200px; height: 61px"/>
			<br/>
			<br/>
			&nbsp;&nbsp;<input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 200px; height: 61px" />
        </section>

		<!-- main content -->

        <!-- Jquery JS -->
        <!--script src="../js/jquery-1.11.1.min.js"></script-->
		<script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="../../js/bootstrap.min.js" ></script>
		
		<!-- bootStrap JS -->
		<script src="../../js/bootstrap.min.js"></script>
		
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
						"info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE REGISTROS _MAX_",
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
			  $('#simple').on('click', '#vig', function () {
					//var sTitle;
				var nTds = $('td', this);
				idAVP = $(nTds[1]).text();
				fechaInstalacion = $(nTds[7]).text();
				fechaRetiro  = $(nTds[8]).text();
				fecha1  = $(nTds[2]).text();
				fecha2  = $(nTds[3]).text();
				verificador  = $(nTds[4]).text();
				nombreInstalo  = $(nTds[5]).text();
				observaciones  = $(nTds[6]).text();

				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='../../img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarAVP.php",{idAVP:idAVP,fechaInstalacion:fechaInstalacion,fechaRetiro:fechaRetiro,fecha1:fecha1,fecha2:fecha2,verificador:verificador,nombreInstalo:nombreInstalo,observaciones:observaciones} ,function(){
				  $("#cargando").css("display", "none");
				});
			  });
			 });
		</script>
		
		<style type="text/css">
		  .div_User{
			position: absolute;
			top: 25%;
			left: 35%;
			width: 50%;
			height: 50%;
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