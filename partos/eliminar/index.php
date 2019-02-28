<?php
	require('conexion.php');
	
	$rol=NULL;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}

	#echo 'LLEGO ROL: '.$rol;
	if(isset($_REQUEST['entreFechas']))
	{
		if (isset($_POST['fechaIni']))
		{
			$fechaIni=$_POST['fechaIni'];
		}
		if (isset($_POST['fechaFin']))
		{
			$fechaFin=$_POST['fechaFin'];
		}

		$query="SELECT id, fecha, hora, nombrePaciente, cirugia, cirujano, anestesiologo, estatusCirugia FROM datosnuevosparto WHERE fecha BETWEEN
		'$fechaIni' AND '$fechaFin' ";
	
		$resultado=$mysqli->query($query);
	} else {
		$query="SELECT id, fecha, hora, nombrePaciente, cirugia, cirujano, anestesiologo, estatusCirugia FROM datosnuevosparto ORDER BY fecha";
	
		$resultado=$mysqli->query($query);
	}
	$c=1;
?>

<html>
	<head>
		<title>Pacientes de PARTO</title>
		<meta charset="utf-8">
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
	
			<!-- en html5 no necesitas indicar el cierre de la etiqueta -->
        <meta http-equiv="refresh" content="1000">
<style type="text/css">


/* Datagrid */
	body {
  	text-align: center;
    	background-color: #E8F0FE;
    	font-family: Helvetica,Arial,sans-serif;
    }
table {
  border-collapse: collapse;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
th, td {
  padding: 0.25rem;
  text-align: center;
}
tbody tr:nth-child(odd) {
  background: #eee;
  width: 40px;
}
.centro{
  padding: 0.5rem;
  background: #4285F4 ;
  color: white;
  text-align: center;
  font-size: 21px;

}

#cuadro{
	width: 90%;
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
<script type="text/javascript">	
	function confirmSubmit()
	{
		var agree=confirm("¿Está seguro de cancelar esta cirugía? !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}
</script>

</head>
	<body>
	<div id="cuadro">
		<center>
		<img src="../../img/logoNew2.jpg" height="200" width="200"><br>
		<div id="titulo">
		<center><h1>Registro de PARTOS</h1></center>
		</div>
		<div class="datagrid">
		<table class="table table-bordered" id="simple">
			<thead>
				<tr class="centro">
				    <td>ID</td>
					<td>Fecha</td>
					<!--td>Hora</td-->
					<td>Nombre del Paciente</td>
					<td>Cirugía</td>
					<!--td>Cirujano</td>
					<td>Anestesiólogo</td-->
					<td>Opciones</td>
				</tr>
				</thead>
				<tbody>					
					<?php while($row=$resultado->fetch_assoc()){
					$estatus = $row['estatusCirugia'];
	
					if($estatus == 4){
						$color = 'class="danger"';
						$cancela = FALSE;
					} else {
						$color = '';
						$cancela = TRUE;
					}
					?>
						<tr <?php echo $color ?> >
							<td><?php echo $c++; #$row['id'];?>
							</td>
							<td>
								<?php $date1 = date_create_from_format('Y-m-d',$row['fecha'])->format('d-m-Y'); ?>
								<?php echo $date1;?>
							</td>
							<!--td>
								<?php #echo $row['hora'];?>
							</td-->
							<td>
								<?php echo utf8_encode($row['nombrePaciente']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['cirugia']);?>
							</td>
							<!--td>
								<?php #echo utf8_encode($row['cirujano']);?>
							</td>
							<td>
								<?php #echo utf8_encode($row['anestesiologo']);?>
							</td-->
							<td>
								<a class="btn btn-primary" href="verMas.php?id=<?php echo $row['id'];?>&rol=<?php echo $rol ?>">Modificar</a> <br />
								<?php if($cancela) { ?>
									<a class="btn btn-danger" onclick="return confirmSubmit()" href="eliminar.php?id=<?php echo $row['id'];?>&rol=<?php echo $rol ?>">Cancelar</a>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<form method="post">
				<p><strong>Consultar Cirugías por Rango de Fechas</strong></p>
				Fecha Inicial&nbsp;&nbsp; <input name="fechaIni" type="date" required>&nbsp;&nbsp; Fecha Final&nbsp;&nbsp; <input name="fechaFin" type="date" required>
				<br>
				<br>
				<input type="submit" name="entreFechas" class="btn btn-primary" value="CONSULTAR" />
				<br >
			</form>
			<br>
			<form action="../../excel.php" method = "post">
				<br/>
				<strong><span class="auto-style7">REPORTE EXCEL
				<br/>
				<input type="hidden" name="nombre" value="partos" />  
				<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
				<br/>
			</form>
			<br>
			<br>
				<br>
				<a class="btn btn-info" href="../listar/lista2.php" style="width: 140px; height: 60px" target="_blank"> PANTALLA </a>
			<br>
			<br>
				<a class="btn btn-success" href="../calendario/calendarioPartos.html" style="width: 140px; height: 60px" target="_blank"> CALENDARIO </a>
			<br>
			<br>
			<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>
			</center>
		</div>
		</body>
	</html>