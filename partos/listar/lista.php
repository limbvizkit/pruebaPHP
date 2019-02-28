<?php
	require('conexion.php');
	
	$query="SELECT *  FROM datos";

	$resultado=$mysqli->query($query);
	
?>

<html>
	<head>
		<title>Hospital Henri Dunant</title>
		<!-- en html5 no necesitas indicar el cierre de la etiqueta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="4500">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		

<style type="text/css">


/* Datagrid */
	body {
		text-align: center;
    	background-color: #E8F0FE;
    	font-family: Helvetica,Arial,sans-serif;
  		 
	}
table {
  
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  
}
div.s{
	width: 50%;
	float: left;
}
div.d{
	width: 50%;
	float: right;
}
th, td {
  padding: 0.25rem;
  text-align: center;
  /*min-width: 40px;
  max-width: auto;*/
  	
}
tbody tr:nth-child(odd) {
  background: #eee;
  width: 40px;
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
	
}
label{
	visibility: hidden;
}
#cuadro{
	width: 90%;
	height: all;
	background: #F8F8F8 ;
	padding: 25px;
	margin: 5px auto;
	box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	
}
#titulo{
	width: 100%;
	background: #4285F4;
	color:white;

}
	</style>
</head>
<body>
	<div id="cuadro">
		<center><img src="logo1.png" alt="logo henri" height="100px" width="100px"><br>
		<div id="titulo">
		<center><h1>Registro de Quirófano</h1></center>
		</div>

		<div class="s">
		<table class="table table-bordered">
			<thead>
				<tr class="centro">
				    <td>ID</td>
					<td>Fecha</td>
					<td>Hora</td>
					<td>Nombre del Paciente</td>
					<td>Cirugía</td>
					<td>Cirujano</td>
					<td>Anestesiólogo</td>
				</tr>
				
				<tbody>
					<?php while($row=$resultado->fetch_assoc()){ ?>
						<tr>
						    <td><?php echo $row['id'];?>
							</td>
							<td><?php echo $row['fecha'];?>
							</td>
							<td>
								<?php echo $row['hora'];?>
							</td>
							<td>
								<?php echo $row['nombre'];?>
							</td>
							<td>
								<?php echo $row['cirugia'];?>
							</td>
							<td>
								<?php echo $row['cirujano'];?>
							</td>
							<td>
								<?php echo $row['anestesiologo'];?>
							</td>
						</tr>
					<?php } ?>
				</tbody>

			</table>
			<br>
		</div>
			</center>
			
			<!--<center>
			    <iframe width="1000" height="680" src="https://www.youtube.com/embed/YNumbcGlrlc?autoplay=1" frameborder="0" allowfullscreen></iframe>
			</center>-->
			
			<video width="40%" id="reproductor" controls=""></video>
			<br>
			<label  id="info" ></label>
			</br>
		<br>
		<h3 ><font color="gray"> Henri<strong> Dunant </strong></font></h3>
	</div>
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