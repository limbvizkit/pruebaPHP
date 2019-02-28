<?php 
	require('conexion.php');
	
	$query="SELECT id, fecha, hora, nombrePaciente, cirugia, 'AC' 
			FROM datosnuevosparto
			WHERE estatusCirugia != 4
			UNION
			SELECT id, fecha, hora, nombrePaciente, cirugia, 'QX'
			FROM datosnuevos
			WHERE estatusCirugia != 4 AND (cirugia like '%cesarea%' OR cirugia like '%parto%')
			ORDER BY fecha, hora";

	$resultado=$mysqli->query($query);

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="refresh" content="4500"; URL=lista2.php >
    <script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../css/datatables.min.css" >
	<script type="text/javascript" src="../../js/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#simple').dataTable({
				"language": {
	    	        "lengthMenu": "Mostrar _MENU_ Filas",
	    	        "zeroRecords": "Sin Resultados - Intente otra frase",
	    	        "info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE REGISTROS _MAX_",
	    	        "infoEmpty": "Sin Registros",
	    	        "infoFiltered": "(Total _TOTAL_ filas)",
	    	        "sSearch":"Buscar",
	    	        "paginate": {
	    			  	"next": "Siguiente",
	    			 	"sPrevious":"Anterior"
	    			}
	    	    }
	    	});
		});
	</script>
	<script type="text/jscript" src="../../js/bootstrap.min.js" >	</script>
	<link rel="stylesheet" href="../../css/tabAz.css" />
	<link rel="stylesheet" href="../../css/bootstrap.min.css" />
    
<style type="text/css">
	/* Datagrid */
	*{
		box-sizing: border-box;
	}
	.menu {
    width: 50%;
    float: right;
    padding-left:  15px;
    
	}
	.main {
    width: 100%;
    float: left;
    padding: 15px;
    
	}
	body {
		text-align: center;
   		background-color: #E8F0FE;
    	font-family: Helvetica,Arial,sans-serif;
  		 	
		}
	table {
	float:left;
	width: 50%;
  	box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  	font-size: 15px;
	  
	}
	.table > thead > tr > th,
	.table > tbody > tr > th,
	.table > tfoot > tr > th,
	.table > thead > tr > td,
	.table > tbody > tr > td,
	.table > tfoot > tr > td {
  	padding: 4px;
  	line-height: 1.42857143;
  	vertical-align: top;
  	border-top: 1px solid #ddd;
}

	th, td {
  	padding: 0.25rem;
  	text-align: center;
  	/*min-width: 40px;
  	max-width: auto;*/
	  	
	}
	/*lo de la tabla*/
	.centro{
  	padding: 0.5rem;
  	background: #4285F4 ;
  	color: white;
  	text-align: center;
	  font-size: 21px;

	}
	video{
		padding-left: 25px;
		padding-top: 10px;
		
	}
	label{
		visibility: hidden;
	}
	#cajon1{
		float:left;
		width: 50%;
		background:#F8F8F8;
	}
	#cajon2{
		float:right;
		width: 50%;
		background:#F8F8F8;

	}
	#cajon3{
		clear: both;
		background: #F8F8F8;
	}
	#cuadro{
		width: 90%;
		height: 100%;
		background-image:url('../../img/logoNew2.jpg') ;
		padding: 10px;
		margin: 5px auto;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	
	}
	#titulo{
		float:left;
		width: 100%;
		background: #4285F4;
		color:white;

	}
	.auto-style3 {
		border-left: 1px solid #FFFFFF;
		border-right: 1px solid #FFFFFF;
		border-top-color: #FFFFFF;
		border-bottom: 1px solid #FFFFFF;
	}
	.auto-style4 {
		border-left: 1px solid #D4D4D4;
		border-right: 1px solid #D4D4D4;
		border-top-width: 2px;
		border-bottom: 1px solid #D4D4D4;
		border-top-color: #D4D4D4;
		background-color: #FFFFFF;
	}
</style>
	<title>Hospital Henri Dunant</title>
</head>
<body>
<center>
	<div class="in" id="cuadro">
		&nbsp;<div id="titulo">
		<h1>Registro de PARTOS</h1>
		<script type="text/javascript">
			function makeArray() {
				for (i = 0; i<makeArray.arguments.length; i++)
					this[i + 1] = makeArray.arguments[i];
			}
			var months = new makeArray('Enero','Febrero','Marzo','Abril','Mayo',
			'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');				
			var date = new Date();
			var day = date.getDate();
			var month = date.getMonth() + 1;
			var yy = date.getYear();
			var year = (yy < 1000) ? yy + 1900 : yy;
			document.write("Hoy es "+ day + " de " + months[month] + " del " + year);
		</script>
		</div>
		<table id="simple">
			<thead>
				<tr class="centro">
				    <td class="auto-style3">ID</td>
					<td class="auto-style3">Fecha</td>
					<td class="auto-style3">Nombre del Paciente</td>
					<td class="auto-style3">Operación</td>
					<td class="auto-style3">CAPTURO</td>
				</tr>
			</thead>
			<tbody>
			 <?php $c=1; ?>
				<?php while($row=$resultado->fetch_assoc()){ ?>
					<tr>
						<td class="auto-style4">
							<strong><?php echo $c++ ?></strong>
						</td>							
						<td class="auto-style4">
							<strong>
							<?php
							$date1 = date_create_from_format('Y-m-d',$row['fecha'])->format('d/m/Y');
							echo $date1;?>
							</strong>
						</td>
						<td class="auto-style4">
							<strong>
							<?php echo utf8_encode($row['nombrePaciente'])?>
							</strong>
						</td>
						<td class="auto-style4">
							<strong>
							<?php echo utf8_encode($row['cirugia']) ?>
							</strong>
						</td>
						<td class="auto-style4">
							<strong>
							<?php echo $row['AC'] ?>
							</strong>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
			<!--img alt="sesion" src="sesion.png" height="450" width="724" -->
		<!--/div-->
	</div>
	<br>
	<h3 ><font color="gray"><strong> Henri Dunant </strong></font></h3>
</center>
</body>
</html>
<!--script type="text/javascript">
	window.onload = function playlist(){
        var reproductor = document.getElementById("reproductor"),
        videos = ["ldm","MANEJO DE RPBI", "medidas estandar","TARJETAS DE AISLAMIENTO","CORPORATIVO_HENRI_DUNANT", "CORPORATIVO_CRUZ_ROJA"],
    	info = document.getElementById("info");
 
    	info.innerHTML = "Vídeo: " + videos[0];
    	reproductor.src = videos[0] + ".mp4";
    	reproductor.play();
 
    	reproductor.addEventListener("ended", function() {
        	var nombreActual = info.innerHTML.split(": ")[1];
	        var actual = videos.indexOf(nombreActual);
        	this.src = (actual == videos.length - 1 ? videos[0] : videos[actual + 1]) + ".mp4";
        	info.innerHTML = "Vídeo: " + videos[actual + 1];
        	this.play();
    	}, false);
	}
		</script-->