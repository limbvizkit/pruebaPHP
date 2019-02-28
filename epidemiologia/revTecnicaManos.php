<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configEpidemio.php');
	
	/*$rol=NULL;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}*/

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

		$query="SELECT *
				FROM tecnicahigienemanos AS t
				LEFT JOIN categoriaprofesional AS c ON t.catProfesional=c.id
				WHERE fechaVerif BETWEEN '$fechaIni' AND '$fechaFin' ORDER BY fechaVerif";
	
		$resultado=mysqli_query($conexionEpidemio, $query) or die (mysqli_error($conexionEpidemio));
	}

?>

<html>
	<head>
		<title>Tecnica Higiene de Manos</title>
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
		<img src="logo1.png"><br>
		<div id="titulo">
		<center><h1>Revisiones Técnica de Higiene de manos</h1></center>
		</div>
		<div class="datagrid">
		<table class="table table-bordered" id="simple">
			<thead>
				<tr class="centro">
				    <td>ID</td>
					<td>Verificador</td>
					<td>Fecha Verif</td>
					<td>Localización</td>
					<td>Turno</td>
					<td>Habitación</td>
					<td>Otros</td>
					<td>Categoria Prof</td>
					<td>CatOtros</td>
					<td>Observaciones</td>
				</tr>
				</thead>
				<tbody>
					<?php while($row=$resultado->fetch_assoc()){
					/*$estatus = $row['estatusCirugia'];
	
					if($estatus == 4){
						$color = 'class="danger"';
						$cancela = FALSE;
					} else {
						$color = '';
						$cancela = TRUE;
					}*/
						$color='';
						$cancela=TRUE;
					?>
						<tr <?php echo $color ?> >
							<td><?php echo $row['id'];?>
							</td>
							<td>
								<?php echo utf8_encode($row['verificador']);?>
							</td>
							<td>
								<?php $date1 = date_create_from_format('Y-m-d',$row['fechaVerif'])->format('d-m-Y'); ?>
								<?php echo $date1;?>
							</td>
							
							<td>
								<?php echo utf8_encode($row['localizacion']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['turno']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['habitacion']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['locOtros']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['categoriaProf']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['catOtros']);?>
							</td>
							<td>
								<?php echo utf8_encode($row['observaciones']);?>
							</td>
							<!--td>
								<a class="btn btn-primary" href="verMas.php?id=<?php #echo $row['id'];?>&rol=<?php #echo $rol ?>">Modificar</a> <br />
								<?php if($cancela) { ?>
									<a class="btn btn-danger" onclick="return confirmSubmit()" href="eliminar.php?id=<?php #echo $row['id'];?>&rol=<?php echo $rol ?>">Cancelar</a>
								<?php } ?>
							</td-->
						</tr>
					<?php } ?>
				</tbody>
			</table>			
			<br>
			<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>
			</center>
		</div>
		</body>
	</html>