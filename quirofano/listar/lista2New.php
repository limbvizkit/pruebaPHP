<?php 
	require('conexion.php');
	
	$query="SELECT id, fecha, hora, nombrePaciente, cirugia, cirujano, anestesiologo 
			FROM datosnuevos 
			WHERE fecha BETWEEN  CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY)
			AND estatusCirugia != 4 ORDER BY fecha,hora";

	$resultado=$mysqli->query($query);
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="refresh" content="4500"; URL=lista2.php>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
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
			<h1>Registro de Quirófano</h1>
			<script type="text/javascript">
				function makeArray() {
				for (i = 0; i<makeArray.arguments.length; i++)
				this[i + 1] = makeArray.arguments[i];}
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
		<!--
			<video class="menu" width="100%" id="reproductor" controls=""></video>
			<br>
			<label  id="info" ></label>
			</br>
		-->
		<!--div id="cajon2"> 
		<!--div id="glbd-widget"-->
		<!--div id="glbd-load" style="width: 600px; background: url(http://globedia.com/img/loading.gif) center no-repeat;">
		</div-->
		<!--div id="glbd-link" style="text-align:right; font-size:10px; font-family:'Trebuchet MS', Arial; margin: auto; width: 600px;"-->
		<!--a href="http://globedia.com" title="Noticias" target="_blank" style="color:#999; text-decoration:none;"></a-->
		<!--/div-->
		<!--/div-->
		<!--script type="text/javascript" src="http://globedia.com/widgets/widget.js"></script>
		<script type="text/javascript" src="http://globedia.com/widgets/widget.php?country=MX&category=0&order=date&cols=1&num=6&width=550&height=false&title=Noticias&author=false&images=false&summaries=true&votes=false"></script>
		<script type="text/javascript">GlobediaWidget.init();</script-->
		<!-- <script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" data-fw-param="48166/"></script>-->
		<!-- start feedwind code MEDICO --> <!--script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" data-fw-param="48166/"></script--> <!-- end feedwind code -->
		<!-- start feedwind code DEPORTES IMG --> <!--script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" data-fw-param="48166/"></script> <!-- end feedwind code -->
		<!-- start feedwind code Aristegui Gral --> <!--script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" data-fw-param="48166/"></script> <!-- end feedwind code -->
		<!--br>
		</div-->
		<div class="main" align="left">
		<table class="table " >
			<thead>
				<tr class="centro">
				    <td class="auto-style3">ID</td>
					<td class="auto-style3">Hora</td>
					<td class="auto-style3">Fecha</td>
					<td class="auto-style3">Nombre del Paciente</td>
					<td class="auto-style3">Cirugía</td>
					<td class="auto-style3">Cirujano</td>
					<td class="auto-style3">Anestesiólogo</td>
				</tr>
			</thead>
				<tbody>
				 <?php $c=1; ?>
					<?php while($row=$resultado->fetch_assoc()){ ?>
						<tr>
						    <td class="auto-style4"><strong><?php echo $c++?>
							</strong>
							</td>
							<td class="auto-style4"><strong><?php
							 	$hora1 = date_create_from_format('H:m:s',$row['hora'])->format('H:i');
								echo $hora1.' '.'Hrs';?>
							</strong>
							</td>
							<td class="auto-style4">
								<strong>
								<?php 
								$date1 = date_create_from_format('Y-m-d',$row['fecha'])->format('d-m-Y');
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
								<?php echo utf8_encode($row['cirujano']) ?>
								</strong>
							</td>
							<td class="auto-style4">
								<strong>
								<?php echo utf8_encode($row['anestesiologo'])?>
								</strong>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<!--img alt="sesion" src="sesion.png" height="450" width="724" -->
		</div>
		<br>
		<h1 style="visibility: hidden;">a</h1>
		<br>
		<br>
		<br>
		<br>
		<br>
		<h1 style="visibility: hidden;">a</h1>
		<br>
		<br>
		<br>
		<br>
		<h1 style="visibility: hidden;">a</h1>
		<br>
		<h1 style="visibility: hidden;">a</h1>
	</div>
	<h3 ><font color="gray"><strong> Henri Dunant </strong></font></h3>
</center>
</body>
</html>
<script type="text/javascript">
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
		</script>