<?php
	require('conexion/configLogin.php');
	
	$rol=NULL;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}

	$query="SELECT * FROM usuarios as u
			LEFT JOIN roles as r ON u.rolUsr=r.idRol
			LEFT JOIN areas as a ON u.idArea=a.idArea
			LEFT JOIN datosusuario AS d ON u.idUsr=d.idUsuario";

	$result0 = mysqli_query($conexion, $query);

	//$resultado=$mysqli->query($query);
	
?>

<html>
	<head>
		<title>Lista de Usr</title>
		<meta charset="utf-8">
		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/datatables.min.css" >
	<script type="text/javascript" src="js/datatables.min.js"></script>
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
	<script type="text/jscript" src="js/bootstrap.min.js" >	</script>
	<link rel="stylesheet" href="css/tabAz.css" />
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	
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
		 	return true;
		} else {
		 	return false;
		}
	}
</script>

</head>
	<body>
	<div id="cuadro">
		<center>
		<img src="img/logoNew2.jpg" height="200" width="200"><br>
		<div id="titulo">
		<center><h1>LISTA DE USUARIOS</h1></center>
		</div>
		<div class="datagrid">
		<table class="table table-bordered" id="simple">
			<thead>
				<tr class="centro">
				    <td>ID</td>
					<td>NombreUsr</td>
					<td>Empleado</td>
					<td>Área</td>
					<td>Rol</td>
				</tr>
				</thead>
				<tbody>
					<?php while($row=mysqli_fetch_array($result0)){
					//$estatus = $row['estatusCirugia'];
					$estatus = '';
					if($estatus == 4){
						$color = 'class="danger"';
						$cancela = FALSE;
					} else {
						$color = '';
						$cancela = TRUE;
					}
					?>
						<tr <?php echo $color ?> >
							<td><?php echo $row['idUsr'];?>
							</td>							
							<td>
								<?php echo $row['nombreUsr'];?>
							</td>
							<td>
								<?php echo utf8_encode($row['nombre']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['nombreArea']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['nombreRol']);?>
							</td>
							<!--td>
								<a class="btn btn-primary" href="verMas.php?id=<?php #echo $row['id'];?>&rol=<?php #echo $rol ?>">Modificar</a> <br />
								<?php #if($cancela) { ?>
									<a class="btn btn-danger" onclick="return confirmSubmit()" href="eliminar.php?id=<?php #echo $row['id'];?>&rol=<?php #echo $rol ?>">Cancelar</a>
								<?php #} ?>
							</td-->
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<!--form method="post">
				<p><strong>Consultar Cirugías por Rango de Fechas</strong></p>
				Fecha Inicial&nbsp;&nbsp; <input name="fechaIni" type="date" required>&nbsp;&nbsp; Fecha Final&nbsp;&nbsp; <input name="fechaFin" type="date" required>
				<br>
				<br>
				<input type="submit" name="entreFechas" class="btn btn-primary" value="CONSULTAR" >
				<br >
			</form>
			<br >
				<br>
				<br>
				<a class="btn btn-info" href="../listar/lista2.php" style="width: 140px; height: 60px" target="_blank"> PANTALLA </a-->
			<br>
			<br>
			<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>
			</center>
		</div>
		</body>
	</html>