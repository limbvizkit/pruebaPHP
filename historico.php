<?php
  	header('Content-Type: text/html;charset=utf-8');
  	#archivo con la conexion a la BD MYSQL local
  	require_once('conexion/config.php');

	#Comenzamos con PHP para recibir por POST 5 variables de formulario_farmacia.php
	if(isset ($_GET['expediente'])){
		$expediente = $_GET['expediente'];
	}else{
		$expediente = NULL;
	}
	if(isset ($_GET['folio'])){
		$folio = $_GET['folio'];
	}else{
		$folio = NULL;
	}
	if(isset ($_GET['nomPac'])){
		$nomPac = utf8_encode($_GET['nomPac']);
	}else{
		$nomPac = NULL;
	}
	if(isset ($_GET['idMedic'])){
		$idMedic = $_GET['idMedic'];
	}else{
		$idMedic = NULL;
	}
	if(isset ($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = NULL;
	}
	if(isset ($_GET['nMedic'])){
		$nMedic = $_GET['nMedic'];
	}else{
		$nMedic = NULL;
	}
	#Esta variable la enviamos de aqui mismo para Eliminar
	if(isset ($_GET['idH'])){
		$idH= $_GET['idH'];
	}else{
		$idH= NULL;
	}
	if($idH != NULL && $idH != ''){
		#Esta es la Query que elimina un dato historico
		 $queryDelHist = "DELETE FROM historicomed WHERE idHistorico='$idH'";
	
		$result0 = mysqli_query($conexion, $queryDelHist);
			
		if(!$result0){
			echo'! ERROR AL ELIMINAR HISTORICO!';
			echo '<br/>Query DEL: '.$queryDelHist;
			exit;
		} else {
			echo '<br/><strong>!!!! SE ELIMINO CORRECTAMENTE!!!!</strong><br>';
			#echo '<br/>Query UPD: '.$queryDelHist;
		}
	}
	#Presionamos el boton y enviamos los datos de aqui mismo ;)
	if(isset($_REQUEST['enviarHistorico']))
	{
		if(isset ($_POST['expediente'])){
			$expediente = $_POST['expediente'];
		}else {
			$expediente = NULL;
		}
		if(isset ($_POST['folio'])){
			$folio = $_POST['folio'];
		}else {
			$folio = NULL;
		}
		if(isset ($_POST['nomPac'])){
			$nomPac = $_POST['nomPac'];
		}else{
			$nomPac = NULL;
		}
		if(isset ($_POST['idMedic'])){
			$idMedic = $_POST['idMedic'];
		}else{
			$idMedic = NULL;
		}
		if(isset ($_POST['nMedic'])){
			$nMedic = $_POST['nMedic'];
		}else{
			$nMedic = NULL;
		}
		if(isset ($_POST['id'])){
			$id = $_POST['id'];
		}else{
			$id = NULL;
		}
		if(isset ($_POST['diaDesc'])){
			$diaDesc= $_POST['diaDesc'];
		}else{
			$diaDesc= NULL;
		}
		if(isset ($_POST['lugar'])){
			$lugar= $_POST['lugar'];
		}else{
			$lugar= NULL;
		}
		if(isset ($_POST['recMed'])){
			$recMed= $_POST['recMed'];
		}else{
			$recMed= NULL;
		}
		if(isset ($_POST['recEgreso'])){
			$recEgreso= utf8_decode($_POST['recEgreso']);
		}else{
			$recEgreso= NULL;
		}
		#Este valor solo llega cuando es actualización
		if(isset ($_POST['idH'])){
			$idH = $_POST['idH'];
		}else{
			$idH = NULL;
		}
		#Recibimos el valor de idH de aqui mismo, entonces es actualización
		if($idH != NULL && $idH != ''){
			#Esta es la Query que actualiza un dato historico
			$queryUpdHist = "UPDATE historicomed SET idTiempoHist = '$diaDesc', fechaInsert = now(), idLugarHist='$lugar', recomendacionEgreso = '$recEgreso',
								idRecomendacionHist='$recMed' WHERE idHistorico = '$idH'";
		
			$result0 = mysqli_query($conexion, $queryUpdHist);
				
			if(!$result0){
				echo'! ERROR AL ACTUALIZAR DATOS!';
				echo '<br/>Query UPD: '.$queryUpdHist;
				exit;
			} else {
				echo '<br/><strong>!!!! SE ACTUALIZO CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query UPD: '.$queryUpdHist;
				echo '<input name="cerrar" class="btn btn-danger" type="button" onclick="window.close();" value="SALIR" style="width: 137px; height: 60px" />';
				exit;
			}

		} else {
			#Esta es la Query que guarda un nuevo dato historico NOTA: la fecha que se guarda es la fecha actual verificar si se requiere
			$queryInsHist = "INSERT INTO historicomed (idHistorico, idMedPaciente, idMedicamento, idTiempoHist, idLugarHist,
			 					idRecomendacionHist, recomendacionEgreso, fechaInsert) 
			 VALUES (NULL, '$id', '$idMedic', '$diaDesc', '$lugar', '$recMed', '$recEgreso', now())";
		
			$result0 = mysqli_query($conexion, $queryInsHist);
				
			if(!$result0){
				echo'! ERROR AL INSERTAR DATOS PARA DESCONTINUAR!';
				echo '<br/>Query INSRT: '.$queryInsHist;
				exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS PARA DESCONTINUAR CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query INSRT: '.$queryInsHist;
			}
		}
	}

	$queryHist0 = "SELECT h.idHistorico
				FROM historicomed AS h
				WHERE idMedPaciente='$id' AND idMedicamento='$idMedic'";
	$idHist0 = mysqli_query($conexion, $queryHist0) or die (mysqli_error($conexion));
	$row0 = mysqli_fetch_array($idHist0);
	
	if($row0 != NULL){
		$datos = "1";
	} else {
		$datos = "0";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Descontinuar Medicamento</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" />
<style type="text/css">
	.auto-style2 {
		font-size: large;
		border-bottom-style: solid;
		border-bottom-width: 2px;
		border-style: solid;
	}
	.auto-style3 {
			color: #070719;
			font-family: Arial, Helvetica, sans-serif;
			font-size:x-large;
	}
</style>
</head>
<body onload="ocultaDt(<?php echo $datos ?>)" style="background-image: url(img/logoNew2Agua.jpg)">
<script type="text/javascript" >
	function dsblqModifHist()
	{
		document.getElementById("diaDesc").disabled=false;
		document.getElementById("show_lugar").disabled=false;
		document.getElementById("show_rec").disabled=false;
		document.getElementById("show_recE").disabled=false;
		document.getElementById("btGd").disabled=false;
	}
	function confirmSubmit()
	{
		var agree=confirm("¿Está seguro de eliminar este registro? !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}
	function ocultaDt(dt) {
		if(dt == "1"){
			document.getElementById('agregaDt').style.display="none";
		}
	}
</script>

<p class="auto-style3"><strong>PACIENTE: <?php echo $expediente.' '.$nomPac ?>
	<br/> DESCONTINUAR EL MEDICAMENTO: <?php echo $nMedic ?>
</strong>
</p>
<form method="post" action="historico.php">
<table style="width: 100%"  border="2px solid black;">
	<tr>
	<th class="auto-style2">&nbsp;DÍA&nbsp;</th>
	<th class="auto-style2">&nbsp;LUGAR&nbsp;</th>
	<th class="auto-style2">&nbsp;RECOMENDACIÓN&nbsp;</th>
	<th class="auto-style2">&nbsp;OBSERVACIONES&nbsp;</th>
	<!--th class="auto-style2">&nbsp;FECHA DE CAPTURA&nbsp;</th-->
	<th class="auto-style2">&nbsp;OPCIONES&nbsp;</th>

	</tr>
	<?php
	$queryHist = "SELECT h.idHistorico, idTiempoHist, l.nombreLugarHist, r.nombreRecHist, recomendacionEgreso, fechaInsert, h.idLugarHist, h.idRecomendacionHist
				FROM historicomed AS h
				LEFT JOIN lugarhistorico as l ON l.idLugarHist=h.idLugarHist
				LEFT JOIN recomendacionhist as r ON r.idRecomendacionHist=h.idRecomendacionHist
				WHERE idMedPaciente='$id' AND idMedicamento='$idMedic' ORDER BY fechaInsert";
	$idHist = mysqli_query($conexion, $queryHist) or die (mysqli_error($conexion));
	while($row = mysqli_fetch_array($idHist)){
		echo '<tr>
			<td>
				<input id="diaDesc" name="diaDesc" type="date" style="width:180px; height:40px" class="auto-style5" value="'.$row[1].'" disabled/>
			</td>
			<td>
			<select id="show_lugar" name="lugar" style="width:160px; height:40px" disabled>
	        <option value="'.$row[6].'">'.utf8_encode($row[2]).'</option>
	   		<option value="1"> URGENCIAS </option>
			<option value="2"> QUIRÓFANO </option>
			<option value="3"> HOSPITALIZACIÓN </option>
			<option value="4"> UCI </option>
			<option value="5"> UCIN </option>
			<option value="6"> EGRESO </option>
			</select>
			</td>
			<td>
			<select id="show_rec" name="recMed" style="width:245px; height:40px" disabled>
	        <option value="'.$row[7].'">'.utf8_encode($row[3]).'</option>
	   		<option value="2">CONCILIACIÓN AL EGRESO</option>
	   		<option value="4"> DESCONTINUAR</option>
			</select>
			</td>
			<td><input id="show_recE" name="recEgreso" type="text" style="width: 450px; height: 44px" value="'.utf8_encode($row[4]).'" disabled /></td>
			
			<input name="expediente" type="hidden" value="'.$expediente.'" />
			<input name="folio" type="hidden" value="'.$folio.'" />
			<input name="id" type="hidden" value="'.$id.'" />
			<input name="idMedic" type="hidden" value="'.$idMedic.'" />
			<input name="nMedic" type="hidden" value="'.$nMedic.'" />
			<input name="nomPac" type="hidden" value="'.$nomPac.'" />
			<input name="idH" type="hidden" value="'.$row[0].'" />
			<!--td><input id="show_fcaptura" name="fcaptura" type="text" style="width: 150px; height: 44px" value="'.utf8_encode($row[5]).'" disabled /></td-->
			<td><input  class="btn btn-primary" type="button" value="MODIFICAR" onclick ="dsblqModifHist()" />
			<a class="btn btn-danger" onclick="return confirmSubmit()" href="historico.php?idH='.$row[0].'&expediente='.$expediente.'&folio='.$folio.'&nomPac='.urlencode($nomPac).'&idMedic='.$idMedic.'&id='.$id.'&nMedic='.urlencode($nMedic).'" />ELIMINAR </a>
			<input id="btGd" type="submit" class="btn btn-success" name="enviarHistorico" value="GUARDAR" disabled />
			</td>
			</tr>
		';
	}
 	?>
	</table>
</form>
<div id="agregaDt" style="display:block">
	<form method="post" action="historico.php">
	<!--strong><br/><br/>&nbsp;SELECCIONE TIEMPO:</strong>&nbsp;
			<select id="tiempo" name="tiempo" style="width:150px; height:40px" required>
	        <option value="">Seleccione:</option>
	   		<option value="1"> INGRESO </option>
			<option value="2"> CONTINUÓ </option>
			<option value="3"> EGRESO </option>
			</select-->
	<br/><strong><span class="auto-style5">AGREGAR DATOS</span><br/><br/>		
	&nbsp;DÍA:</strong>
	<span class="auto-style5">&nbsp;</span>
	<input id="diaDesc" name="diaDesc" type="date" style="width:180px; height:40px" required class="auto-style5" />
	
	<strong>&nbsp; LUGAR:</strong>&nbsp;
			<select id="lugar" name="lugar" style="width:150px; height:40px" required>
	        <option value="">Seleccione:</option>
	   		<option value="1"> URGENCIAS </option>
			<option value="2"> QUIRÓFANO </option>
			<option value="3"> HOSPITALIZACIÓN </option>
			<option value="4"> UCI </option>
			<option value="5"> UCIN </option>
			<option value="6"> EGRESO </option>
			</select>
			<br/>
			<br/>
	<strong>&nbsp; RECOMENDACIÓN:</strong>&nbsp;
			<select id="recMed" name="recMed" style="width:230px; height:40px" required>
			<option value="">Seleccione:</option>
	        <option value="2">CONCILIACIÓN AL EGRESO</option>
	   		<option value="4"> DESCONTINUAR</option>
			<!--option value="2"> DESCONTINUAR MEDICACIÓN </option>
			<option value="3"> INICIAR TRATAMIENTO </option-->
			</select>
			<br/>
			<br/>
		<strong>&nbsp; OBSERVACIONES: </strong>
		<input name="recEgreso" type="text" style="width: 639px; height: 40px" />
		<br/>
		<input name="expediente" type="hidden" value="<?php echo $expediente ?>" />
		<input name="folio" type="hidden" value="<?php echo $folio ?>" />
		<input name="id" type="hidden" value="<?php echo $id ?>" />
		<input name="idMedic" type="hidden" value="<?php echo $idMedic ?>" />
		<input name="nMedic" type="hidden" value="<?php echo $nMedic?>" />
		<input name="nomPac" type="hidden" value="<?php echo $nomPac ?>" />
		<br/>
		&nbsp;
		<input type="submit" class="btn btn-success" name="enviarHistorico" value="GUARDAR" style="width: 137px; height: 60px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</form>
</div>
<br/>&nbsp;
<input name="cerrar" class="btn btn-danger" type="button" onclick="window.close();" value="SALIR" style="width: 137px; height: 60px" />
</body>

</html>
