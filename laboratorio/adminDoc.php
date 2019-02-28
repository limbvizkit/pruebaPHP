<?php
	require_once "classes/pdf_to_image.php";
	require_once('../conexion/configGodady.php');

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   // nos envía a la siguiente dirección en el caso de no tener sesión
	   header("location: ../index.html");
	}
	//$valor = $_SESSION[$rol];
	$directorio='output';
	$contArchivos=0;
	
	if(isset ($_GET['tipo'])) {
		#si queremos dar de BAJA nos llega esta variable
		if($_GET['tipo'] == 2){
			if(isset ($_GET['archivo'])) {
				$archivo= $_GET['archivo'];
			} else {
				$archivo= NULL;
			}
			if(isset ($_GET['idArchivo'])) {
				$idArchivo= $_GET['idArchivo'];
			} else {
				$idArchivo= NULL;
			}
			
			if($archivo != NULL && $archivo != '' && $idArchivo!= NULL && $idArchivo != ''){		
				#Cambiamos el estatus en la BD para el archivo
				$queryUpdDoc = "UPDATE datosdocslab SET estatus = '3' WHERE idDocumento = $idArchivo";
				$result0 = mysqli_query($conexion, $queryUpdDoc);
		
				if(!$result0){
					echo'!!! ERROR AL REALIZAR BAJA DE DATOS PARA DOCUMENTO !!!';
					echo '<br/>Query UPD: '.$queryUpdDoc;
					exit;
				} else {
					echo '<br/><strong>!!!! SE DIO DE BAJA EL DOCUMENTO '.$archivo.' !!!!</strong><br>';
					#echo '<br/>Query UPD: '.$queryUpdDosis;
				}
			}
		}
		
		#si queremos eliminar nos llega esta variable
		if($_GET['tipo'] == 3){
			if(isset ($_GET['archivo'])) {
				$archivo= $_GET['archivo'];
			} else {
				$archivo= NULL;
			}
			if(isset ($_GET['idArchivo'])) {
				$idArchivo= $_GET['idArchivo'];
			} else {
				$idArchivo= NULL;
			}
		    #Por el momento no se eliminan archivos de la carpeta
			if($archivo != NULL && $archivo != '' && $idArchivo!= NULL && $idArchivo != ''){
				#Eliminamos el archivo de la carpeta???O_o MMMMMMejor esperamos y solo cambiamos el estatus del archivo
				//unlink('output/'.$archivo); #Descomentar para eliminar el archivo
		
				#Cambiamos el estatus en la BD para el archivo
				$queryUpdDoc = "UPDATE datosdocslab SET estatus = '0' WHERE idDocumento = $idArchivo";
				$result0 = mysqli_query($conexion, $queryUpdDoc);
		
				if(!$result0){
					echo'!!! ERROR AL ELIMINAR DATOS PARA DOCUMENTO !!!';
					echo '<br/>Query UPD: '.$queryUpdDoc;
					exit;
				} else {
					echo '<br/><strong>!!!! SE ELIMINO EL DOCUMENTO '.$archivo.' !!!!</strong><br>';
					#echo '<br/>Query UPD: '.$queryUpdDosis;
				}
			}
		}

		
		#si queremos dar nuevamente de ALTA nos llega esta variable
		if($_GET['tipo'] == 1){
			if(isset ($_GET['archivo'])) {
				$archivo= $_GET['archivo'];
			} else {
				$archivo= NULL;
			}
			if(isset ($_GET['idArchivo'])) {
				$idArchivo= $_GET['idArchivo'];
			} else {
				$idArchivo= NULL;
			}
			
			if($archivo != NULL && $archivo != '' && $idArchivo!= NULL && $idArchivo != ''){	
				#Cambiamos el estatus en la BD para el archivo
				$queryUpdDoc = "UPDATE datosdocslab SET estatus = '1' WHERE idDocumento = $idArchivo";
				$result0 = mysqli_query($conexion, $queryUpdDoc);
		
				if(!$result0){
					echo'!!! ERROR AL REALIZAR ALTA DE DATOS PARA DOCUMENTO !!!';
					echo '<br/>Query UPD: '.$queryUpdDoc;
					exit;
				} else {
					echo '<br/><strong>!!!! SE DIO NUEVAMENTE DE ALTA EL DOCUMENTO '.$archivo.' !!!!</strong><br>';
					#echo '<br/>Query UPD: '.$queryUpdDosis;
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

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
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
		background-image: url('../img/logoNew2Agua.jpg');
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
<script type="text/jscript">

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
<div class="head">
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
		  <th class="auto-style5">Expediente</th>
		  <th class="auto-style5">Paciente</th>
		  <th class="auto-style5">Notas</th>
		  <th class="auto-style5">Nombre Documento</th>
		  <th class="auto-style5">Opciones</th>
        </tr>
      </thead>
      <tbody>
		<?php
			/*$queryConteo = "SELECT count(*)
				 		    FROM datosdocumentos
				 		    WHERE estatus > 0";
			$cont = mysqli_query($conexion, $queryConteo) or die (mysqli_error($conexion));
			$contA = mysqli_fetch_array($cont);
			$contArchivos = $contA[0];*/

			$queryDocs = "SELECT *
				 		  FROM datosdocslab
						  WHERE estatus > 0";
			$docs = mysqli_query($conexion, $queryDocs) or die (mysqli_error($conexion));
			$c=1;
			while($row = mysqli_fetch_array($docs)){
			$extArchivo = substr($row['rutaArchivo'], strpos($row['rutaArchivo'], "."), strlen($row['rutaArchivo']));
			$archiv = substr($row['rutaArchivo'], strpos($row['rutaArchivo'], "/"), strlen($row['rutaArchivo']));
			$archiv = substr($archiv, 1, strlen($archiv));

			$fecha = strtotime($row['fechaAlta']);
		    $fechaFin = date('d-m-Y H:i',$fecha);

		    $colorFila;

		    if($row['estatus'] == 3){
		        $colorFila='style="color:red"';
		        $bttAltBj='&nbsp;&nbsp;<a class="btn btn-info" onclick="return confirmSubmitAlta()" href="adminDoc.php?rol='.$rol.'&archivo='.$archiv.'&idArchivo='.$row[0].'&tipo=1" style="width: 70px; height: 30px"/> ALTA </a>';
		    } else {
		        $colorFila='style="color:black"';
		        $bttAltBj='&nbsp;&nbsp;<a class="btn btn-primary" onclick="return confirmSubmit()" href="adminDoc.php?rol='.$rol.'&archivo='.$archiv.'&idArchivo='.$row[0].'&tipo=2" style="width: 70px; height: 30px"/> BAJA </a>';
		    }

		?>
		<tr <?php echo $colorFila ?> >
			<td class="auto-style7"><?php echo $c++ ?></td>
			<td class="auto-style7"><?php echo utf8_encode($fechaFin) ?></td>
			<td class="auto-style7"><?php echo utf8_encode($row['expediente']) ?></td>
			<td class="auto-style7"><?php echo utf8_encode($row['paciente']) ?></td>
			<td class="auto-style7"><?php echo utf8_encode($row['notas']) ?></td>
			<td class="auto-style7"><?php echo utf8_encode($row['nombreArchivo']) ?></td>
			<td class="auto-style6">
			<?php
				//if ($extArchivo !== '.png' && $extArchivo != '.jpg' && $extArchivo != '.jpeg') {
					#echo '&nbsp;<input class="btn btn-success" type="button" value="ABRIR" onclick="window.open(\''.$row[5].'\');" target="_blank" style="width: 80px; height: 30px"/>';
				echo '<a class="btn btn-success" href="https://'.$row[5].'" style="width: 80px; height: 30px" target="_blank"/> ABRIR </a>';
				//}
				echo $bttAltBj;
				echo '&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmitEliminar()" href="adminDoc.php?rol='.$rol.'&archivo='.$archiv.'&idArchivo='.$row[0].'&tipo=3" style="width: 90px; height: 30px"/> ELIMINAR </a> <br/>';
			?>
			</td>
			<?php } ?>
		</tr>
      </tbody>
	</table>
	<?php #echo "Total de archivos: <strong> $contArchivos </strong> <br>
			#echo "*Los botones en color amarillo abren el archivo de manera protegida<br>";
	?>
	<span class="auto-style3">*Al dar de baja un archivo ya no aparece en el listado de archivos del paciente<br></span>
	</div>
	<div class="head">
		<form action="guardarDoc.php" method="post" target="_blank">
			<h1> CARGAR RESULTADOS DE ESTUDIOS</h1>
			(PDF, Word, Excel)
			<input type="submit" class="btn btn-info btn-lg btn-block" value="Subir Archivo" name="subirArch" style="width: 140px; height: 40px">
			<input name="rol"  type="hidden" value="<?php echo $rol ?>" >
		</form>
		<hr>
		<!--h1>CARGAR ARCHIVO PROTEGIDO</h1>
		(PDF e Imagenes)
		<form action="guardarArchivoProte.php" method="post" target="_blank">
			<input type="submit" class="btn btn-info btn-lg btn-block" value="Subir Protegido" name="subirProte" style="width: 175px; height: 40px">
			<input name="rol"  type="hidden" value="<?php #echo $rol ?>" >
		</form-->
	</div>
<br>
<!--a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 41px" > REGRESAR </a-->
<?php
    /*if( $valor == 'administrador'){
	   echo '<input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
    }else{*/
		echo '<input type="button" class="btn btn-info btn-lg btn-danger" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" >';
	//}
?>
</center>
</body>
</html>