<?php
	require_once('../conexion/configLogin.php');
	$directorio='output';
	$contArchivos=0;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	
	$queryArea = "SELECT idArea FROM usuarios WHERE nombreUsr = '$rol'";
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];

	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: ../index.html");
	}
	$valor = $_SESSION[$rol];
?>
<!DOCTYPE html>
<html>
<head>
<title>visorArchivos</title>
<!--style type="text/css">@import "../js/style/style.css";</style-->
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<style type="text/css">
	.styleBD {
		background-image: url('../img/1280x768-A.JPG');
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
<link rel="stylesheet" href="../css/bootstrap.min.css" >
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<link rel=stylesheet href="../css/stylo.css" type="text/css" >

<link rel="stylesheet" type="text/css" href="datatables.min.css">
<script type="text/javascript" src="datatables.min.js"></script>

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
		<img alt="LogoHD" src="../img/logoPeque.jpg">
		<h1>VISOR DE ARCHIVOS</h1>
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
			<th class="auto-style5">Área/Depto</th>
			<th class="auto-style5">Nombre Documento</th>
			<!--th class="auto-style5">Opciones</th-->
		</tr>
	</thead>
	<tbody>
	<?php
		$queryConteo = "SELECT count(*)
			 		    FROM datosdocumentosNew
			 		    WHERE estatus=1 AND (FIND_IN_SET($areaFin, permisos) OR $areaFin = '0' OR $areaFin=areaDepto)";
		$cont = mysqli_query($conexion, $queryConteo) or die (mysqli_error($conexion));
		$contA = mysqli_fetch_array($cont);
		$contArchivos = $contA[0];

		$queryDocs = "SELECT idDocumento,areaDepto,a.nombreArea,nombreDocumento,estatus,fechaAlta
			 		  FROM datosdocumentosNew AS d
					  LEFT JOIN areas AS a ON d.areaDepto=a.idArea
					  WHERE estatus=1 AND (FIND_IN_SET($areaFin, permisos) OR $areaFin = '0' OR $areaFin=areaDepto)";
		$docs = mysqli_query($conexion, $queryDocs) or die (mysqli_error($conexion));
		$c=1;
		while($row = mysqli_fetch_array($docs)){
		$fecha = strtotime($row['fechaAlta']);
	    $fechaFin = date('d-m-Y H:i',$fecha);

	?>
	<tr>
		<td class="auto-style4"><?php echo $c++ ?></td>
		<td class="auto-style4"><?php echo utf8_encode($fechaFin) ?></td>
		<td class="auto-style4"><?php echo utf8_encode($row['nombreArea']) ?></td>
		<td class="auto-style4"><a href="detalleDocNew1.php?id=<?php echo $row[0] ?>" target="_blank" > <?php echo utf8_encode($row['nombreDocumento']) ?> </a></td>
		<!--td class="auto-style3">
		<?php
    		/*if ($extArchivo !== '.png' && $extArchivo != '.jpg' && $extArchivo != '.jpeg') {
    			echo '&nbsp;<input class="btn btn-success" type="button" value="ABRIR" onclick="window.open(\''.$row[4].'\');" target="_blank" style="width: 115px; height: 30px"/>';
    		} else {
    			echo '&nbsp;<input class="btn btn-warning" id="btnLab" type="button" value="ABRIR*" onclick="window.open(\'plantillaPDF.php?pdf='.$archiv.'&pdf1=N\',\'ventana\',\'width=1400,height=1000,scrollbars=NO,menubar=NO,resizable=NO,titlebar=NO,status=NO\');"return="false" style="width: 115px; height: 30px"/>';
    		}*/
    		#echo '&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmit()" href="index.php?rol='.$rol.'&archivo='.$archiv.'&idArchivo='.$row[0].'" style="width: 125px; height: 40px"/> BAJA </a> <br/>';
		?>
		</td-->
		<?php } ?>
	</tr>
	</tbody>
	</table>
	</div>
	<span class="auto-style2">*Para ver los datos guardados dar clic en el nombre del documento<br></span>
	<a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 41px" > REGRESAR </a>
	<?php #echo "Total de archivos: <strong> $contArchivos </strong> <br>
			#*Los botones en color amarillo abren el archivo de manera protegida<br>";
    	if( $valor == 'administrador'){
    		echo '<input class="btn btn-danger" name="cerrar" type="button" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
    	}else{
    		echo '<input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >';
    	}
	?>
	</div>
  </center>
<div class="text-left">
	<footer>
	    &nbsp;&nbsp;&nbsp;&nbsp; USUARIO: <?php echo $rol ?>
	</footer>
</div>
</body>
</html>