<?php
	require_once('../conexion/configGodady.php');
	//$directorio='output';
	//$contArchivos=0;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	/*if (isset($_GET['permisos']))
	{
		$permisos=$_GET['permisos'];
	}*/
	
	$queryArea = "SELECT idArea FROM usuarioslab WHERE nombreUsr = '$rol'";
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];
	
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   // nos envía a la siguiente dirección en el caso de no poseer autorización
	   header("location: index.php");
	}
	$valor = $_SESSION[$rol];
?>
<!DOCTYPE html>
<html>
<head>
<title>visorArchivos</title>
<!--style type="text/css">@import "../js/style/style.css";</style-->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<style type="text/css">
	.styleBD {
		background-image: url('../img/logoNew2.jpg');
	}
	.auto-style2 {
		text-align: center;
		font-size: x-large;
		color: #D9EDF7;
	}
	.auto-style3 {
		font-size: medium;
	}
	.auto-style4 {
		text-align: center;
		font-size: medium;
	}
.auto-style5 {
	text-align: center;
	font-size: medium;
	background-color: #D9EDF7;
}
</style>
<link rel="stylesheet" href="css/bootstrap.min.css" >
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<link rel=stylesheet href="css/stylo.css" type="text/css" >

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>

<!--link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.10.16/datatables.min.css"> 
<script type="text/javascript" src="https://cdn.datatables.net/v/ju/dt-1.10.16/datatables.min.js"></script-->

<script type="text/javascript">
	$(document).ready(function() {
		$('#simple').dataTable({
			"language": {
    	        "lengthMenu": "Mostrar _MENU_ Filas",
    	        "zeroRecords": "Sin Resultados - Intente otra frase",
    	        "info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE ARCHIVOS _MAX_",
    	        "infoEmpty": "Sin Archivos",
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
</head>
<body class="styleBD" >
  <center>
	<div class="h">
	<div class="head">
		<img alt="LogoHD" src="img/logoNew2.jpg">
		<h1>RESULTADOS DE ESTUDIOS</h1>
	</div>
	<br>
	<table style="width: 100%">
		<thead>
			<tr>
				<td class="auto-style2"> <strong> Listado de Archivos</strong></td>
			</tr>
		<thead>
	</table>
	<div>
	<table id="simple" class="display">
	<thead>
		<tr>
			<th class="auto-style5">No.</th>
			<th class="auto-style5">Fecha de Alta</th>
			<th class="auto-style5">Paciente</th>
			<th class="auto-style5">Nombre del Archivo</th>
			<th class="auto-style5">Opciones</th>
		</tr>
	</thead>
	<tbody>
	<?php
		/*$queryConteo = "SELECT count(*)
			 		    FROM datosdocumentos
			 		    WHERE estatus=1 AND (FIND_IN_SET($areaFin, permisos) OR $areaFin = '0' OR $areaFin=areaDepto)";
		$cont = mysqli_query($conexion, $queryConteo) or die (mysqli_error($conexion));
		$contA = mysqli_fetch_array($cont);
		$contArchivos = $contA[0];*/

		$queryDocs = "SELECT *
			 		  FROM datosdocslab 
					  WHERE estatus=1 AND usuario='$rol'";
		$docs = mysqli_query($conexion, $queryDocs) or die (mysqli_error($conexion));
		$c=1;
		while($row = mysqli_fetch_array($docs)){
			$extArchivo = substr($row['rutaArchivo'], strpos($row['rutaArchivo'], "."), strlen($row['rutaArchivo']));
			$archiv = substr($row['rutaArchivo'], strpos($row['rutaArchivo'], "/"), strlen($row['rutaArchivo']));
			$archiv = substr($archiv, 1, strlen($archiv));

			$fecha = strtotime($row['fechaAlta']);
	    	$fechaFin = date('d-m-Y H:i',$fecha);

	?>
	<tr>
		<td class="auto-style4"><?php echo $c++ ?></td>
		<td class="auto-style4"><?php echo utf8_encode($fechaFin) ?></td>
		<td class="auto-style4"><?php echo utf8_encode($row['paciente']) ?></td>
		<td class="auto-style4"><!--a href="detalleDoc.php?id=<?php echo $row[0] ?>" target="_blank" --> <?php echo utf8_encode($row['nombreArchivo']) ?></td>
		<td class="auto-style3">
		<?php
    			echo '&nbsp;<input class="btn btn-success" type="button" value="ABRIR" onclick="window.open(\''.$row[5].'\');" target="_blank" style="width: 115px; height: 30px"/>';
		?>
		</td>
		<?php } ?>
	</tr>
	</tbody>
	</table>
	</div>
	<span class="auto-style2">*Da clic en el boton ABRIR para poder descargar el archivo</span>
	<br />
	<br />
	<br />
	<!--a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 41px" > REGRESAR </a-->
	<?php 
			echo '<input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >';
	?>
	</div>
  </center>
</body>
</html>