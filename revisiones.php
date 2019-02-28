<?php 
	header('Content-Type: text/html;charset=utf-8');
  	#archivo con la conexion a la BD MYSQL local
  	require_once('conexion/config.php');
  	
  	$dssInc = NULL;
	$psInc = NULL;
	$renInc = NULL;
	
	#Comenzamos con PHP para recibir por POST 5 variables desde formualario_farmacia.php
	if(isset ($_GET['expediente'])){
		$expediente = $_GET['expediente'];
	}else {
		$expediente = NULL;
	}
	if(isset ($_GET['folio'])){
		$folio = $_GET['folio'];
	}else {
		$folio = NULL;
	}
	if(isset ($_GET['nomPac'])){
		$nomPac = $_GET['nomPac'];
	}else{
		$nomPac = NULL;
	}
	if(isset ($_GET['idMedic'])){
		$idMedic = $_GET['idMedic'];
	}else{
		$idMedic =NULL;
	}
	if(isset ($_GET['id'])){
		$id = $_GET['id'];
	}else {
		$id =NULL;
	}
	if(isset ($_GET['nMedic'])){
		$nMedic = $_GET['nMedic'];
	}else{
		$nMedic=NULL;
	}
	#Esta variable es de aqui mismo si queremos eliminar una Revision
	if(isset ($_GET['idDelRevis'])){
		$idDelRevis=$_GET['idDelRevis'];
		#primero borramos el id de la tabla medpacientes
		$queryDelRevMedPac = "UPDATE medpacientes SET idRevision = NULL WHERE medpacientes.id = '$id'";
		$idDelRevMedPac = mysqli_query($conexion, $queryDelRevMedPac ) or die (mysqli_error($conexion));
		#ahora si borramos el registro de la tabla revisiones
		$queryDelRevision = "DELETE FROM revisiones WHERE idRevision = '$idDelRevis'";
		$idDelRevi = mysqli_query($conexion, $queryDelRevision ) or die (mysqli_error($conexion));
		
		echo '!!!!!!!!!!!!!!!!SE ELIMINO LA REVISIÓN!!!!!!!!!
			<br><br>&nbsp;&nbsp;<input name="cerrar" type="button" onclick="window.close();" style="background-color:red" value="SALIR">';
		exit();
	} else {
		$idDelRevis = NULL;
	}
	#Valores recibidos de aqui tambien para modificar una revision
	if(isset($_REQUEST['enviarRevisiones']))
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
		
		if(isset ($_POST['id'])){
			$id= $_POST['id'];
		}else {
			$id= NULL;
		}
		
		if(isset ($_POST['idMedic'])){
			$idMedic= $_POST['idMedic'];
		}else {
			$idMedic= NULL;
		}
		
		if(isset ($_POST['nMedic'])){
			$nMedic= $_POST['nMedic'];
		}else {
			$nMedic= NULL;
		}
		
		if(isset ($_POST['dosisMax'])){
			$dosisMax= utf8_decode($_POST['dosisMax']);
		}else {
			$dosisMax= NULL;
		}
		
		if(isset ($_POST['dosisInc'])){
			$dosisInc= $_POST['dosisInc'];
		}else {
			$dosisInc= NULL;
		}
		
		if(isset ($_POST['revPeso'])){
			$revPeso= utf8_decode($_POST['revPeso']);
		}else {
			$revPeso= NULL;
		}
		
		if(isset ($_POST['pesoInc'])){
			$pesoInc= $_POST['pesoInc'];
		}else {
			$pesoInc= NULL;
		}
		
		if(isset ($_POST['ajstRen'])){
			$ajstRen= utf8_decode($_POST['ajstRen']);
		}else {
			$ajstRen= NULL;
		}

		if(isset ($_POST['renalInc'])){
			$renalInc= $_POST['renalInc'];
		}else {
			$renalInc= NULL;
		}
		
		if(isset ($_POST['contraInd'])){
			#if($_POST['contraInd'] != ""){
				$contraInd= utf8_decode($_POST['contraInd']);
			#}
		}else {
			$contraInd= NULL;
		}
		
		if(isset ($_POST['recomendacion'])){
			$recomendacion = $_POST['recomendacion'];
		} else {
			$recomendacion = NULL;
		}
		
		if(isset ($_POST['idRev'])){
			$idRev= $_POST['idRev'];
			#Estoy recibiendo un idRev? entonces la revision ya existe la eliminamos? :o NOOO mejor actualizamos :D
			$queryUpdRevision = "UPDATE revisiones SET dosisMax='$dosisMax', dosisIncorrecta='$dosisInc', revisionPeso='$revPeso', pesoIncorrecto='$pesoInc',  
							  ajusteRenal='$ajstRen', renalIncorrecto='$renalInc', contraindicaciones='$contraInd', recomendacion='$recomendacion'
							  WHERE idRevision='$idRev'";
			$result0 = mysqli_query($conexion, $queryUpdRevision);
			
			if(!$result0){
				echo'! ERROR al realizar inserción de datos GUARDAR Revisiones!';
			} else {
				echo '<br/>!!!! SE ACTUALIZARON LOS DATOS DE LA REVISIÓN CORRECTAMENTE!!!!<br>';
				#echo '<br/>Query UPD: '.$queryUpdRevision;
			}
		}
	}
		
	$queryIdRevision0 = "SELECT idRevision FROM medpacientes WHERE id = '$id'";
	$idRev0 = mysqli_query($conexion, $queryIdRevision0) or die (mysqli_error($conexion));
	$idRev10 = mysqli_fetch_array($idRev0);
	$idRevFin0 = $idRev10 ['idRevision'];
	
	if($idRevFin0 != NULL){
		$queryRevision0 = "SELECT dosisIncorrecta,pesoIncorrecto,renalIncorrecto,recomendacion FROM revisiones WHERE idRevision = '$idRevFin0'";
		$idRevi0 = mysqli_query($conexion, $queryRevision0) or die (mysqli_error($conexion));
		$row0 = mysqli_fetch_array($idRevi0);
		$dssInc = $row0[0];
		$psInc = $row0[1];
		$renInc = $row0[2];
		$recomen = $row0[3];
	}
?>
<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<title>Revisiones</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" >
<script type="text/javascript">
	function confirmSubmit()
	{
		var agree=confirm("Está seguro de eliminar este registro? Este proceso es irreversible.");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}
	function blqCeldas(){
		document.getElementById("dosisMaxRev").disabled=false;
		document.getElementById("pesoRev").disabled=false;
		document.getElementById("renalRev").disabled=false;
		document.getElementById("contraIndRev").disabled=false;
		document.getElementById("btnGrd").disabled=false;
		document.getElementById("dosisInc").disabled=false;
		document.getElementById("pesoInc").disabled=false;
		document.getElementById("renalInc").disabled=false;
		document.getElementById("recomendacion").disabled=false;
	}
	function checarD(d){
		if(d=="1"){
		 	document.getElementById('dosisInc').checked = true;
		} else {
			document.getElementById('dosisInc').checked = false;
		}
	}
	function checarP(p){
		if(p=="1"){
		 	document.getElementById('pesoInc').checked = true;
		} else {
			document.getElementById('pesoInc').checked = false;
		}
	}
	function checarR(r){
		if(r=="1"){
		 	document.getElementById('renalInc').checked = true;
		} else {
			document.getElementById('renalInc').checked = false;
		}
	}
	function checarReco(reco){
		if(reco=="1"){
		 	document.getElementById('recomendacion').checked = true;
		} else {
			document.getElementById('recomendacion').checked = false;
		}
	}
</script>
</head>
<body onload="checarD(<?php echo $dssInc ?>); checarP(<?php echo $psInc ?>); checarR(<?php echo $renInc ?>); checarReco(<?php echo $recomen ?>)" style="background-image: url(img/logoNew2Agua.jpg)">
<?php

	$queryIdRevision = "SELECT idRevision FROM medpacientes WHERE id = '$id'";
	$idRev = mysqli_query($conexion, $queryIdRevision) or die (mysqli_error($conexion));
	$idRev1 = mysqli_fetch_array($idRev);
	$idRevFin = $idRev1 ['idRevision'];
	
	if($idRevFin != NULL){
		echo '
		ESTE MEDICAMENTO YA TIENE REVISIÓN
		<br>
		<table style="width: 100%">
		<tr>
		<td class="auto-style2"> <strong> REVISIÓN DE MEDICAMENTO: '.$nMedic.'</strong>
		<hr/>
		<table style="width: 100%"  border="5px solid black;">
			<th class="auto-style2">DOSIS MAX.</th>
			<th class="auto-style2">REVISIÓN PESO</th>
			<th class="auto-style2">AJUSTE RENAL</th>
			<th class="auto-style2">CONTRAINDICACIONES</th>
			<th class="auto-style2">RECOMENDACIONES</th>
			<th class="auto-style2">OPCIONES</th>';
			$queryRevision = "SELECT idRevision,dosisMax,revisionPeso,ajusteRenal,contraindicaciones,recomendacion FROM revisiones WHERE idRevision = '$idRevFin'";
			$idRevi = mysqli_query($conexion, $queryRevision ) or die (mysqli_error($conexion));
			while($row = mysqli_fetch_array($idRevi)){
			echo ' <form method="post" action="revisiones.php">
				<tr>
					<td><input id="dosisMaxRev" name="dosisMax" type="text" value="'.utf8_encode($row[1]).'" disabled >
					<br/>
					INCORRECTA 
					<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="dosisInc" name="dosisInc" style="width: 30px; height: 30px" value="1" disabled >
					</td>
					<td><input id="pesoRev" name="revPeso" type="text" value="'.utf8_encode($row[2]).'" disabled  >
					<br/>
					INCORRECTO 
					<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="pesoInc" name="pesoInc" style="width: 30px; height: 30px" value="1" disabled >
					</td>
					<td><input id="renalRev" name="ajstRen" type="text" value="'.utf8_encode($row[3]).'" disabled  >
					<br/>
					INCORRECTO 
					<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="renalInc" name="renalInc" style="width: 30px; height: 30px" value="1" disabled >
					</td>
					</td>
					<td><input id="contraIndRev" name="contraInd" type="text" value="'.utf8_encode($row[4]).'" disabled  ></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="recomendacion" name="recomendacion" style="width: 30px; height: 30px" value="1" disabled ></td>
					
					<input type="hidden" name="idRev" value="'.$row[0].'">
					<input name="expediente" type="hidden" value="'.$expediente.'" >
					<input name="folio" type="hidden" value="'.$folio.'" >
					<input name="idMedic" type="hidden" value="'.$idMedic.'" >
					<input name="id" type="hidden" value="'.$id.'" >
					<input name="nMedic" type="hidden" value="'.$nMedic.'" >';
			    #echo '<td> <input id="btnModif" type="button" value="MODIFICAR" onclick =blqCeldas() style="width: 137px; height: 44px"/>&nbsp;&nbsp;';
			    echo '<td>&nbsp;&nbsp;<input class="btn btn-success" id="btnGrd" type="Submit" name="enviarRevisiones" value="GUARDAR" disabled >';
			    echo '&nbsp;&nbsp;<a class="btn btn-info" onclick="blqCeldas()" >MODIFICAR</a>';
			    echo '&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmit()" href="revisiones.php?idDelRevis='.$row[0].'&id='.$id.'&expediente='.$expediente.'&folio='.$folio.'&nomPac='.$nomPac.'&idMedic='.$idMedic.'&nMedic='.$nMedic.'">ELIMINAR</a>  </td>';
				echo "</tr>";
			}
		echo '</table></form>';
		#echo '<br><input type="submit" value="AGREGAR?" onclick =window.open(\'revisiones.php\');return false style="width: 200px; height: 44px"/> &nbsp;&nbsp;';
		echo '<br><br>&nbsp;&nbsp;<a class="btn btn-warning" onclick="window.close();" style="width: 140px; height: 44px"> SALIR </a>
		</body>
		</html>';
		mysqli_close($conexion);
		exit;
	}
 ?>
 
<!DOCTYPE html> 
<html>
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
  <title>Revisiones</title>
  <link rel="stylesheet" href="css/jquery.mobile-1.4.4.min.css" >
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.mobile-1.4.4.min.js"></script>
<style type="text/css">
  .auto-style10 {
	  font-size: large;
  }
  .auto-style20 {
	  color: #808080;
  }
  .auto-style30 {
	   text-align: left;
   }
</style>
</head>
<body>
<script type="text/javascript">
	if((navigator.userAgent.match(/MSIE/i)) || (navigator.userAgent.match(/Chrome/i)) || (navigator.userAgent.match(/Firefox/i))) {
		document.write('<style type="text/css" media="screen">#header{font-family:Verdana;font-size:16px;width:90%;}</style>');	
	}
</script>

<p align="center" >
<strong><span class="auto-style10">REVISIONES: <?php echo $expediente.' '.urldecode($nomPac).' Medicamento: '.$nMedic; ?> </span></strong>
</p>
<hr class="auto-style20" style="height: 5">
<form method="post" action="guardaRevisiones.php">
	<div class="auto-style30">
		<hr>
		&nbsp;&nbsp; <strong>DOSIS MÁXIMA:</strong>&nbsp; <input type="text" name="dosisMax" style="background-color:#C6E2FF">&nbsp;&nbsp;
		<strong>DOSIS INCORRECTA 
		<input type="checkbox" name="dosisInc" style="width: 30px; height: 30px" value="1"></strong>
		<br><br>
		&nbsp;&nbsp;<strong>REVISIÓN PESO:</strong>&nbsp; <input type="text" name="revPeso" style="background-color:#C6E2FF">&nbsp;&nbsp;
		<strong>PESO INCORRECTO <input type="checkbox" name="pesoInc" style="width: 30px; height: 30px" value="1"></strong>
		<br><br>
		&nbsp;&nbsp;<strong>AJUSTE RENAL:</strong>&nbsp; <input type="text" name="ajstRen" style="background-color:#C6E2FF">&nbsp;&nbsp;
		<strong>AJUSTE RENAL INCORRECTO <input type="checkbox" name="renalInc" style="width: 30px; height: 30px" value="1"></strong>
		<br>
		<br>
		&nbsp; <strong>CONTRAINDICACIONES:</strong>&nbsp; <input type="text" name="contraInd" style="background-color:#C6E2FF">
		<br>
		<br>
		<strong>&nbsp;&nbsp;AGREGAR RECOMENDACIÓN:</strong>
		<br>
		<br> 
		&nbsp;&nbsp;SI<input name="recomendacion" type="radio" style="width: 30px; height: 30px" value="1" required>&nbsp; 
		<br>
		<br>
		&nbsp;&nbsp;NO<input name="recomendacion" type="radio" style="width: 30px; height: 30px" value="0" required>&nbsp;
		<br>
		<br>
		<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
		<input name="folio" type="hidden" value="<?php echo $folio ?>" >
		<input name="idMedic" type="hidden" value="<?php echo $idMedic?>" >
		<input name="id" type="hidden" value="<?php echo $id?>" >
		<input name="nMedic" type="hidden" value="<?php echo $nMedic?>" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="Submit" name="enviarRevisiones" style="background-color:lime" value="GUARDAR">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="cerrar" type="button" onclick="window.close();" style="background-color:red" value="SALIR"> 
	</div>
	</form>
</body>
</html>