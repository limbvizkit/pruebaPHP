<?php
	require_once "classes/pdf_to_image.php";
	require_once('../conexion/configLogin.php');

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	session_name($rol);
	session_start();
	
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía a la siguiente dirección en el caso de no tener sesión */
	   header("location: ../index.html");
	}
	$valor = $_SESSION[$rol];
	
	$queryArea = "SELECT idArea FROM usuarios WHERE nombreUsr = '$rol'";
	$ar = mysqli_query($conexion, $queryArea);
	$area = mysqli_fetch_array($ar);
	$areaFin = $area[0];
	
	if (isset($_GET['incidencia']))
	{
		$incidencia=$_GET['incidencia'];
	} else {
		$incidencia='n';
	}
	
	if(isset ($_GET['tipo'])) {
		#si queremos dar de BAJA nos llega esta variable
		if($_GET['tipo'] == 2){
			if(isset ($_GET['idArchivo'])) {
				$idArchivo= $_GET['idArchivo'];
			} else {
				$idArchivo= NULL;
			}
			
			if($idArchivo!= NULL && $idArchivo != ''){		
				#Cambiamos el estatus en la BD para el archivo
				$queryUpdDoc = "UPDATE datosdocumentosNew SET estatus = '3' WHERE idDocumento = $idArchivo";
				$result0 = mysqli_query($conexion, $queryUpdDoc);
		
				if(!$result0){
					echo'!!! ERROR AL REALIZAR BAJA DE DATOS PARA DOCUMENTO !!!';
					echo '<br/>Query UPD: '.$queryUpdDoc;
					exit;
				} else {
					echo '<br/><strong style="color:red">!!!! SE DIO DE BAJA EL DOCUMENTO !!!!</strong><br>';
					#echo '<br/>Query UPD: '.$queryUpdDoc;
				}
			}
		}
		
		#si queremos dar nuevamente de ALTA nos llega esta variable
		if($_GET['tipo'] == 1){
			if(isset ($_GET['idArchivo'])) {
				$idArchivo= $_GET['idArchivo'];
			} else {
				$idArchivo= NULL;
			}
			
			if($idArchivo!= NULL && $idArchivo != ''){	
				#Cambiamos el estatus en la BD para el archivo
				$queryUpdDoc = "UPDATE datosdocumentosNew SET estatus = '1' WHERE idDocumento = $idArchivo";
				$result0 = mysqli_query($conexion, $queryUpdDoc);
		
				if(!$result0){
					echo'!!! ERROR AL REALIZAR ALTA DE DATOS PARA DOCUMENTO !!!';
					echo '<br/>Query UPD: '.$queryUpdDoc;
					exit;
				} else {
					echo '<br/><strong style="color:lime">!!!! SE DIO NUEVAMENTE DE ALTA EL DOCUMENTO !!!!</strong><br>';
					#echo '<br/>Query UPD: '.$queryUpdDoc;
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admon de Archivos</title>

<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="datatables.min.css">
<script type="text/javascript" src="datatables.min.js"></script>
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
<script type="text/jscript" src="../js/bootstrap.min.js" >	</script>
<link rel="stylesheet" href="../css/bootstrap.min.css" >
<!-- Latest compiled and minified JavaScript -->
<link rel=stylesheet href="../css/stylo.css" type="text/css">

<style type="text/css">
	.styleBD {
		background-image: url('../img/logoNew2.jpg');
        text-align: center;
	}
	.auto-style3 {
		text-align: center;
		font-size: x-large;
		color: #D9EDF7;
	}
	.auto-style5 {
		text-align: center;
		font-size: medium;
		background-color: #D9EDF7;
	}
	.auto-style6 {
		font-size: small;
        text-align: center;
	}
	.auto-style7 {
		text-align: center;
		font-size: small;
	}
</style>
<script type="text/jscript" >
	function confirmSubmit()
	{
		var agree=confirm("¿Está seguro de DAR DE BAJA este Documento?");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}
	function confirmSubmitAlta()
	{
		var agree=confirm("¿Está seguro de DAR NUEVAMENTE DE ALTA este Documento?");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}
	function confirmSubmitEliminar()
	{
		var agree=confirm("¿Está seguro de ELIMINAR este Documento?\n !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}

</script>
</head>
<body class="styleBD">
<center>
<div class="h">
    <img alt="LogoHD" src="../img/logoNew2.jpg">
    <h1>ADMINISTRADOR DE ARCHIVOS</h1>
  </div>
  <div class="h">
	<br>
	<table style="width: 100%">
    <thead>
	 <tr>
	   <td class="auto-style3"> <strong> Listado de Archivos</strong></td>
      </tr>
    <thead>
	</table>

	<table id="simple">
      <thead>
        <tr>
		  <th class="auto-style5">No.</th>
		  <th class="auto-style5">Fecha de Alta</th>
		  <th class="auto-style5">Área/Depto</th>
		  <th class="auto-style5">Nombre Documento</th>
		  <th class="auto-style5">Opciones</th>
        </tr>
      </thead>
      <tbody>
		<?php
			$queryConteo = "SELECT count(*)
				 		    FROM datosdocumentosNew
				 		    WHERE estatus > 0 AND (FIND_IN_SET($areaFin, permisos) OR $areaFin = '0')";
			$cont = mysqli_query($conexion, $queryConteo) or die (mysqli_error($conexion));
			$contA = mysqli_fetch_array($cont);
			$contArchivos = $contA[0];

			$queryDocs = "SELECT idDocumento,areaDepto,a.nombreArea,nombreDocumento,estatus,fechaAlta
				 		  FROM datosdocumentosNew AS d
						  LEFT JOIN areas AS a ON d.areaDepto=a.idArea
						  WHERE estatus > 0 AND (FIND_IN_SET($areaFin, permisos) OR $areaFin = '0' OR $areaFin=areaDepto)";
			$docs = mysqli_query($conexion, $queryDocs) or die (mysqli_error($conexion));
			$c=1;
			while($row = mysqli_fetch_array($docs)){

					$fecha = strtotime($row['fechaAlta']);
				    $fechaFin = date('d-m-Y H:i',$fecha);
		
				    $colorFila;
		
				    if($row['estatus'] == 3){
				        $colorFila='style="color:red"';
				        $bttAltBj='&nbsp;&nbsp;<a class="btn btn-info" onclick="return confirmSubmitAlta()" href="indexNew.php?rol='.$rol.'&idArchivo='.$row[0].'&tipo=1" style="width: 70px; height: 30px"/> ALTA </a>';
				    } else {
				        $colorFila='style="color:black"';
				        $bttAltBj='&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmit()" href="indexNew.php?rol='.$rol.'&idArchivo='.$row[0].'&tipo=2" style="width: 70px; height: 30px"/> BAJA </a>';
				    }
				?>
				<tr <?php echo $colorFila ?> >
					<td class="auto-style7"><?php echo $c++ ?></td>
					<td class="auto-style7"><?php echo utf8_encode($fechaFin) ?></td>
					<td class="auto-style7"><?php echo utf8_encode($row['nombreArea']) ?></td>
					<td class="auto-style7"><a href="detalleDocNew.php?id=<?php echo $row[0] ?>" target="_blank" > <?php echo utf8_encode($row['nombreDocumento']) ?> </a></td>
					<td class="auto-style6">
					<?php
						/*if ($extArchivo !== '.png' && $extArchivo != '.jpg' && $extArchivo != '.jpeg') {
							echo '&nbsp;<input class="btn btn-success" type="button" value="ABRIR" onclick="window.open(\''.$row[4].'\');" target="_blank" style="width: 80px; height: 30px"/>';
						} else {
							echo '&nbsp;<input class="btn btn-warning" id="btnLab" type="button" value="ABRIR*" onclick="window.open(\'plantillaPDF.php?pdf='.$archiv.'&pdf1=N\',\'ventana\',\'width=1400,height=1000,scrollbars=NO,menubar=NO,resizable=NO,titlebar=NO,status=NO\');"return="false" style="width: 80px; height: 30px"/>';
						}*/
						echo $bttAltBj;
						#echo '&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmitEliminar()" href="index.php?rol='.$rol.'&archivo='.$archiv.'&idArchivo='.$row[0].'&tipo=3" style="width: 90px; height: 30px"/> ELIMINAR </a> <br/>';
					?>
					</td>
			<?php } ?>
		</tr>
      </tbody>
	</table>
	<?php #echo "Total de archivos: <strong> $contArchivos </strong> <br>
			#echo "*Los botones en color amarillo abren el archivo de manera protegida<br>";
	?>
	<span class="auto-style3">*Para ver los datos guardados dar clic en el nombre del documento<br></span>
	</div>
	<div class="h">
		<form action="guardarArchivoNew.php" method="post" target="_blank">
			<h1> GUARDAR DATOS DE ARCHIVO</h1>
			<input type="submit" class="btn btn-success btn-lg btn-block" value="Nuevos Datos" name="subirArch" style="width: 140px; height: 40px">
			<input name="rol"  type="hidden" value="<?php echo $rol ?>" >
		</form>
		<hr>
	</div>
	<div class="h">
		<form action="detalleDocNewArea.php" method="post" target="_blank">
			<h1> CATÁLOGO DE DOCUMENTOS</h1>
			*Solo genera el catálogo de documentos del area del usuario que ingreso
			<input name="area"  type="hidden" value="<?php echo $areaFin ?>" >
			<input type="submit" class="btn btn-success btn-lg btn-block" value="CONSULTAR" name="consulta" style="width: 140px; height: 40px">
		</form>
		<hr>
	</div>
<br>
<?php
    if( $incidencia == 'y'){
	   echo '<hr/>
	   <div class="h">
				<p>
				<span><strong> OTROS SISTEMAS</strong></span>
				<br/>
				Nota: Si ingresa a otro sistema se saldrá de la pantalla actual <br /><br />
				</div>
	   <a class="btn btn-primary" href="../vistaAtencionClnt.php?rol='.$rol.'" style="width: 250px; height: 40px"> INCIDENCIAS </a>
	   <br/><br/>
	   <a class="btn btn-primary" href="visorArchivos.php?rol='.$rol.'" style="width: 250px; height: 40px"> VISOR DE ARCHIVOS INTERNOS </a>';
		if( $rol == 'ygarcia'|| $rol == 'svelazquez' || $rol == 'knunez'){
			echo '<br/><br/>
	   		<a class="btn btn-primary" href="../quirofano/index.php?rol='.$rol.'" style="width: 250px; height: 40px" target="_blank"> QUIRÓFANO </a>';
		}
		if( $rol == 'mbenitez'){
			echo '<br/><br/>
	   		<a class="btn btn-primary" href="../quirofano/eliminar/index.php?rol='.$rol.'" style="width: 250px; height: 40px" target="_blank"> QUIRÓFANO </a>';
		}
		if( $rol == 'dgamboa' || $rol == 'achavez'){
			echo '<br/><br/>
	   		<a class="btn btn-primary" href="../medico/index.php?rol='.$rol.'&permisos=3" style="width: 250px; height: 40px"> CONSULTA MÉDICA </a>
			<br/><br/>
			<a class="btn btn-primary" href="../eventosAdversos/index.php?rol='.$rol.'&permisos=0" style="width: 250px; height: 40px"> EVENTOS ADVERSOS </a>';
		}
		if( $rol == 'jrada'){
			echo '<br/><br/>
	   		<a class="btn btn-primary" href="../epidemiologia/index.php?rol='.$rol.'&permisos=0" style="width: 250px; height: 40px"> EPIDEMIOLOGÍA </a>
			<br/><br/>
			<a class="btn btn-primary" href="../eventosAdversos/index.php?rol='.$rol.'&permisos=0" style="width: 250px; height: 40px"> EVENTOS ADVERSOS </a>';
		}
		if( $rol == 'msoto' || $rol == 'knunez'){
			echo '<br/><br/>
	   		<a class="btn btn-primary" href="../partos/index.php?rol='.$rol.'&permisos=0" style="width: 250px; height: 40px"> PARTOS </a>';
		}
		if( $rol == 'lvilla' || $rol == 'ehernandez'){
			echo '<br/><br/>
	   		<a class="btn btn-primary" href="../resguardosrh.php?rol='.$rol.'&permisos=0" style="width: 250px; height: 40px"> RESGUARDOS </a>';
		}
		echo '<br/><br/><br/>';
    }
?>

<!--a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 41px" > REGRESAR </a-->
<?php
    if( $valor == 'administrador'){
	   echo '<input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
    }else{
		echo '<input type="button" class="btn btn-info btn-lg btn-danger" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >';
	}
?>
</center>
<div class="text-left">
<footer>
    &nbsp;&nbsp;&nbsp;&nbsp; USUARIO: <?php echo $rol ?>
</footer>
</div>
</body>
</html>