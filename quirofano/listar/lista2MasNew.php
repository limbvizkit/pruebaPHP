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
	{
		box-sizing: border-box;
	}
	.menu {
    width: 50%;
    float: right;
    padding-left:  15px;
    
	}
	.main {
    width: 90%;
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
		width: 100%;
		height: 100%;
		background-image:url('../../img/logoNew2.jpg') ;
		padding: 10px;
		margin: 5px auto;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	
	}
	#titulo{
		float:left;
		width: 50%;
		background: #0950B0;
		color:white;

	}
	#titulo2{
		float:none;
		width: 50%;
		background: #07036B;
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
	 #carousel {
		margin: 0 auto;
		/*width: 20px;
		height: 10px;*/
		padding: 0;
		overflow: scroll;
		border: 1px solid #999;
	}
	#carousel ul {
		list-style: none;
		/*width: 1500px;*/
		margin: 0;
		padding: 0;
		position: relative;
	}
	#carousel li {
		display: inline;
		float: left;
	}
</style>
	<title>Hospital Henri Dunant</title>
</head>
<body>
<center>
<div class="container-fluid">
	<div class="in" id="cuadro">
		<div class="row-fluid">
			<div class="col-md-1 well" id="titulo">
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
				<br/>
				<br/>
				<table class="table">
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
						<tr>
							<td class="auto-style4">
								<strong>1</strong>
							</td>
							<td class="auto-style4">
								<strong><p>10:40Hrs</p></strong>
							</td>
							<td class="auto-style4">
								<strong><p>27/11/2018</p></strong>
							</td>
							<td class="auto-style4">
								<strong><p>Juan Diego Gómez</p></strong>
							</td>
							<td class="auto-style4">
								<strong>Histerectomia por Laparoscopia</strong>
							</td>
							<td class="auto-style4">
								<strong>Dr. Alejandro del Rio Meraz</strong>
							</td>
							<td class="auto-style4">
								<strong>Dr. Perez Landa</strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="col-md-1 well" id="titulo"> 
				<!--div id="titulo2"-->
					<h1>Promociones del Mes</h1>
				<!--/div-->
				<div id="carousel">
					<ul>
					<li><img alt="" src="../../promos/n1.jpg" width="700" height="400"><p>Promociones Noviembre</p></li>
					<li><img alt="" src="../../promos/n2.jpg"  width="700" height="400"></li>
					<li><img alt="" src="../../promos/n3.jpg"  width="700" height="400"></li>

					<li><img alt="" src="../../promos/n4.jpg" width="700" height="400" ></li>
					<!--li><img alt="" src="../../promos/n5.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n6.jpg" width="700" height="400" ></li>

					<li><img alt="" src="../../promos/n7.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n8.jpg" width="700" height="400" ></li>

					<li><img alt="" src="../../promos/n9.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n10.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n11.jpg" width="700" height="400" ></li>

					<li><img alt="" src="../../promos/n12.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n13.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n14.jpg" width="700" height="400" ></li>

					<li><img alt="" src="../../promos/n15.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n16.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n17.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n18.jpg" width="700" height="400" ></li>
					<li><img alt="" src="../../promos/n19.jpg" width="700" height="400" ></li-->
				</ul>
			</div>
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	</div>
	<h3 ><font color="gray"><strong> Henri Dunant </strong></font></h3>
	</div>
</center>

	
<script type="text/javascript" src="../../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../assets/js/jquery.dropotron.min.js"></script>
<script type="text/javascript" src="../../assets/js/skel.min.js"></script>
<script type="text/javascript" src="../../assets/js/util.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script type="text/javascript" src="../../assets/js/main.js"></script>
<script type="text/javascript" src="../../js/infiniteCarousel/jquery.infinitecarousel.js"></script>
</body>
</html>

<script type="text/javascript">
	$(function(){
				$('#carousel').infiniteCarousel({
					displayTime: 6000,
					textholderHeight : .25
				});
			});
		</script>