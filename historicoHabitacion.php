<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>HistoricoHab</title>
<!--link rel="stylesheet" href="css/bootstrap.min.css" /-->
<title>Incidencias Fechas</title>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
<script type="text/javascript" src="js/datatables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#simple').dataTable({
			"language": {
    	        "lengthMenu": "Mostrar _MENU_ Filas",
    	        "zeroRecords": "Sin Resultados - Intente otra frase",
    	        "info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE INCIDENCIAS _MAX_",
    	        "infoEmpty": "Sin Incidencias",
    	        "infoFiltered": "(Total _TOTAL_ filas)",
    	        "sSearch":"Buscar",
    	        "paginate": {
    			  	"next": "Siguiente",
    			 	"sPrevious":"Anterior"
    			}
    	    }
    	});
	});
	
	var clic = 2;
	function mostrar(m){
		if(clic == 1){
			document.getElementById('oculto'+m).style.display="none";
			document.getElementById('ocultos'+m).style.display="none";
			clic = clic + 1;
		} else {
			document.getElementById('oculto'+m).style.display="block";
			document.getElementById('ocultos'+m).style.display="block";
			clic = 1;
		}
	}

	//function mostrar(m){
	//	document.getElementById('oculto'+m).style.display = 'block';
	//}
</script>
<script type="text/jscript" src="js/bootstrap.min.js" >	</script>
<link rel="stylesheet" href="css/tabAz.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />

</head>

<?php
	setlocale(LC_ALL,'');
	date_default_timezone_set("America/Mexico_City");
	require_once('conexion/configLogin.php');
	
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
		$regresa=FALSE;
	}
	
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
		$regresa=TRUE;
	}

	
	session_name($rol);
	session_start();
	
	#echo 'ROL: '.$rol;
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: index.html"); 
	}
	$valor = $_SESSION[$rol];
	
	$queryArea = "SELECT u.idArea, a.nombreArea FROM usuarios as u
				LEFT JOIN areas as a ON u.idArea=a.idArea
				WHERE u.nombreUsr = '$rol'";
				
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];
	$areaName = utf8_encode($area[1]);
	$fechaGet = date('Y-m-d');
	
	if (isset($_POST['habitacion']))
	{
		$habitacion = $_POST['habitacion'];
	}
	
	if (isset($_GET['habitacion']))
	{
		$habitacion = $_GET['habitacion'];
	}

	
	/*if (isset($_POST['fecha1']) || isset($_POST['fecha2']) ){
		$fechaHoy = 'Historico del día'.' '.date_create_from_format('Y-m-d',$fechatxt1)->format('d/m/Y').' al Día '.date_create_from_format('Y-m-d',$fechatxt2)->format('d/m/Y');
	}*/
	
?>

<body style="background-image: url(img/logoNew2Agua.jpg)" >
	<br/>
	<h1><strong><span style="font-size:large">&nbsp;&nbsp; Histórico de la habitación: <?php echo $habitacion ?></span></strong></h1>
	<br/>
	&nbsp;&nbsp;<a class="btn btn-info" href="graficas/graficaCirculo.php?rol=<?php echo $rol ?>&&habitacion=<?php echo $habitacion ?>" style="width: 190px; height: 40px" target="_blank"> GRÁFICA DE OCUPACIÓN </a> 
		<br/>
		<hr/>
		<div class="datagrid">
		<table id="simple">
		<thead>
         <tr>
			<th>&nbsp;No.&nbsp;</th>
			<th>&nbsp;MOVIMIENTOS&nbsp;</th>
			<th>&nbsp;TIPO HABITACIÓN&nbsp;</th>
			<th>&nbsp;REPORTE&nbsp;</th>
			<th>&nbsp;FECHA DE ALTA&nbsp;</th>
			<th>&nbsp;ÁREA REPORTA&nbsp;</th>
			<th>&nbsp;ÁREA RESPONSABLE&nbsp;</th>
			<th>&nbsp;SOLUCION&nbsp;</th>
			<th>&nbsp;RESUELTO&nbsp;</th>
			<th>&nbsp;PERSONA QUE RESOLVIO&nbsp;</th>
			<th>&nbsp;FECHA DE SOLUCION&nbsp;</th>
		 </tr>
     	</thead>
      	<tbody>
			<?php
				$queryHistHab = "SELECT i.idIncidencia, h.numeroHabitacion, h.tipoHabitacion, i.reporte, i.fechaAlta, a1.nombreArea, a2.nombreArea, 
									i.solucion, i.resuelto, i.fechaSolucion, i.personaRes
									FROM incidencias AS i
									LEFT JOIN habitaciones AS h ON i.idHabitacion=h.idHabitacion
									LEFT JOIN areas as a1 ON i.idAreaReporta = a1.idArea
									LEFT JOIN areas as a2 ON i.idAreaResponsable = a2.idArea
									WHERE h.numeroHabitacion='$habitacion' ORDER BY i.fechaAlta DESC";
			$idHistHab = mysqli_query($conexion, $queryHistHab) or die (mysqli_error($conexion));
			$c = 1; 
			while($row = mysqli_fetch_array($idHistHab)){
			$idIncid=$row[0];
			if($row[4] != NULL){
				$date1 = date_create_from_format('Y-m-d H:i:s',$row[4])->format('d/m/Y H:i:s');
			} else {
				$date1 = NULL;
			}
			if($row[9] != NULL){
				$date2 = date_create_from_format('Y-m-d H:i:s',$row[9])->format('d/m/Y H:i:s');
			} else {
				$date2 = NULL;
			}
			#if($c%2==0){
			#	$clas = 'class="alt"';
			#} else {
				$clas = '';
			#}
			?>
				<tr <?php echo $clas ?> >
					<td><?php echo $c++ ?></td>
					<td>
					
					<?php
						$queryHistHab1 = "SELECT h.fechaHistorico, h.solucion, h.resuelto, e.nombreEstatus, h.usr, h.reporte
							FROM historicoincidencias AS h
							LEFT JOIN estatusincidencia as e ON h.estatus=e.idEstatusIncidencia
							WHERE h.idIncidencia='$idIncid'";
						$idHistHab1 = mysqli_query($conexion, $queryHistHab1) or die (mysqli_error($conexion));
						$row_cnt = mysqli_num_rows($idHistHab1);
						if($row_cnt >= 1){
							$row0 = NULL;
						$d = 1;
					?>
		<div class="datagrid">
		<table id="simple1">
		<tr>
		<td style="width: 170px"><input type="button" value="Movimientos" onclick="mostrar(<?php echo $c ?>)" /></td>
		</tr>
		<thead id="oculto<?php echo $c ?>" style="display:none">
         <tr>
			<th style="width: 170px">&nbsp;No.&nbsp;</th>
			<th>&nbsp;FECHA HISTORICO&nbsp;</th>
			<th>&nbsp;SOLUCION&nbsp;</th>
			<th>&nbsp;RESUELTO&nbsp;</th>
			<th>&nbsp;ESTATUS&nbsp;</th>
			<th>&nbsp;USUARIO&nbsp;</th>
			<th>&nbsp;REPORTE&nbsp;</th>
		 </tr>
     	</thead>
      	<tbody id="ocultos<?php echo $c ?>" style="display:none">
			<?php
			while($row0 = mysqli_fetch_array($idHistHab1)){
			if($row0[0] != NULL){
				$date1 = date_create_from_format('Y-m-d H:i:s',$row0[0])->format('d/m/Y H:i:s');
			} else {
				$date1 = NULL;
			}
			#if($d%2==0){
			$clas = 'class="alt"';
			#} else {
			#	$clas = '';
			#}
			?>
				<tr <?php echo $clas ?> >
					<td style="width: 50px; text-align:center"><?php echo $d++ ?></td>
					<td style="width: 100px"><?php echo $date1 ?></td>
					<td style="width: 130px"><?php echo  utf8_encode($row0[1]) ?></td>
					<td style="width: 100px"><?php echo utf8_encode($row0[2]) ?></td>
					<td style="width: 100px"><?php echo utf8_encode($row0[3]) ?></td>
					<td style="width: 100px"><?php echo utf8_encode($row0[4]) ?></td>
					<td style="width: 100px"><?php echo utf8_encode($row0[5]) ?></td>
				</tr>
				<?php } ?>
		  </tbody>
		</table></div>
		<?php } ?>
					
			</td>
					<td><?php echo  utf8_encode($row[2]) ?></td>
					<td><?php echo utf8_encode($row[3]) ?></td>
					<td><?php echo $date1 ?></td>
					<td><?php echo utf8_encode($row[5]) ?></td>
					<td><?php echo utf8_encode($row[6]) ?></td>
					<td><?php echo utf8_encode($row[7]) ?></td>
					<td><?php echo $row[8] ?></td>
					<td><?php echo utf8_encode($row[10]) ?></td>
					<td><?php echo $date2 ?></td>
				</tr>
		<?php } ?>
		</tbody>
		</table></div>
		
		<br/> <br/>
		 &nbsp;&nbsp;
		 <?php if($regresa){ ?>
		 	<input class="btn btn-success" onclick=location.href="habitaciones.php?rol=<?php echo $rol ?>"  value="REGRESAR" style="width: 140px; height: 60px" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <?php } else { ?>
		 	<input class="btn btn-success" onclick="window.close();"  value="REGRESAR" style="width: 140px; height: 60px" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <?php } ?> 
		 <input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
		 <br/>

</body>

</html>
