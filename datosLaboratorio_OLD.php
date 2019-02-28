<?php
  	header('Content-Type: text/html;charset=utf-8');
  	require_once('conexion/config.php');
  	#Datos recibidos de formulario_farmacia.php
  	if(isset ($_GET['nomPac'])){
  		$nomPac= utf8_encode($_GET['nomPac']);
  	}else{
  		$nomPac= NULL;
  	}

  	if(isset ($_GET['expediente'])){
		$expediente = $_GET['expediente'];
	} else {
		$expediente = nuLL;
	}
	
	if(isset ($_GET['folio'])){
  		$folio= $_GET['folio'];
  	}else{
  		$folio= NULL;
  	}

	#Datos enviados de aqui mismo para guardar datos de Laboratorio
	if(isset($_REQUEST['enviarLab']))
	{
		$expediente = $_POST['expediente'];
		$folio = $_POST['folio'];
		$nomPac = $_POST['nomPac']; #utf8_decode();
		$ref1 = NULL;
		$glc1=NULL;
		$urea1=NULL;
		$crea1=NULL;
		$urico1=NULL;
		$protro1=NULL;
		$col1=NULL;
		$tgn1=NULL;
		$na1=NULL; 
		$k1=NULL;
		$cl1=NULL;
		$hb1=NULL;
		$hema1=NULL;
		$leuco1=NULL;
		$linfo1=NULL;
		$eosin1=NULL;
		$segmen1=NULL;
		$mono1=NULL;
		$idLab=NULL;
		
		if(isset ($_POST['ref1']) && ($_POST['ref1'])!= ''){
			$ref1 = $_POST['ref1'];
		}else{
			if(isset ($_POST['ref2']) && ($_POST['ref2'])!= ''){
				$ref1 =$_POST['ref2'];
			}
		}
		if(isset ($_POST['glc1']) && ($_POST['glc1'])!= ''){
			$glc1= $_POST['glc1'];
		}else{
			if(isset ($_POST['glc2']) && ($_POST['glc2'])!= ''){
				$glc1=$_POST['glc2'];
			}
		}
		if(isset ($_POST['urea1']) && ($_POST['urea1'])!= ''){
			$urea1= $_POST['urea1'];
		}else{
			if(isset ($_POST['urea2']) && ($_POST['urea2'])!= ''){
				$urea1=$_POST['urea2'];
			}
		}
		if(isset ($_POST['crea1']) && ($_POST['crea1'])!= ''){
			$crea1= $_POST['crea1'];
		}else{
			if(isset ($_POST['crea2']) && ($_POST['crea2'])!= ''){
				$crea1=$_POST['crea2'];
			}
		}
		if(isset ($_POST['urico1']) && ($_POST['urico1'])!= ''){
			$urico1= $_POST['urico1'];
		}else{
			if(isset ($_POST['urico2']) && ($_POST['urico2'])!= ''){
				$urico1=$_POST['urico2'];
			}
		}
		if(isset ($_POST['protro1']) && ($_POST['protro1'])!= ''){
			$protro1= $_POST['protro1'];
		}else{
			if(isset ($_POST['protro2']) && ($_POST['protro2'])!= ''){
				$protro1=$_POST['protro2'];
			}
		}
		if(isset ($_POST['col1']) && ($_POST['col1'])!= ''){
			$col1= $_POST['col1'];
		}else{
			if(isset ($_POST['col2']) && ($_POST['col2'])!= ''){
				$col1=$_POST['col2'];
			}
		}
		if(isset ($_POST['tgn1']) && ($_POST['tgn1'])!= ''){
			$tgn1= $_POST['tgn1'];
		}else{
			if(isset ($_POST['tgn2']) && ($_POST['tgn2'])!= ''){
				$tgn1=$_POST['tgn2'];
			}
		}
		if(isset ($_POST['na1']) && ($_POST['na1'])!= ''){
			$na1= $_POST['na1'];
		}else{
			if(isset ($_POST['na2']) && ($_POST['na2'])!= ''){
				$na1=$_POST['na2'];
			}
		}
		if(isset ($_POST['k1']) && ($_POST['k1'])!= ''){
			$k1= $_POST['k1'];
		}else{
			if(isset ($_POST['k2']) && ($_POST['k2'])!= ''){
				$k1=$_POST['k2'];
			}
		}
		if(isset ($_POST['cl1']) && ($_POST['cl1'])!= ''){
			$cl1= $_POST['cl1'];
		}else{
			if(isset ($_POST['cl2']) && ($_POST['cl2'])!= ''){
				$cl1=$_POST['cl2'];
			}
		}
		if(isset ($_POST['hb1']) && ($_POST['hb1'])!= ''){
			$hb1= $_POST['hb1'];
		}else{
			if(isset ($_POST['hb2']) && ($_POST['hb2'])!= ''){
				$hb1=$_POST['hb2'];
			}
		}
		if(isset ($_POST['hema1']) && ($_POST['hema1'])!= ''){
			$hema1= $_POST['hema1'];
		}else{
			if(isset ($_POST['hema2']) && ($_POST['hema2'])!= ''){
				$hema1=$_POST['hema2'];
			}
		}
		if(isset ($_POST['leuco1']) && ($_POST['leuco1'])!= ''){
			$leuco1= $_POST['leuco1'];
		}else{
			if(isset ($_POST['leuco2']) && ($_POST['leuco2'])!= ''){
				$leuco1=$_POST['leuco2'];
			}
		}
		if(isset ($_POST['linfo1']) && ($_POST['linfo1'])!= ''){
			$linfo1= $_POST['linfo1'];
		}else{
			if(isset ($_POST['linfo2']) && ($_POST['linfo2'])!= ''){
				$linfo1=$_POST['linfo2'];
			}
		}
		if(isset ($_POST['eosin1']) && ($_POST['eosin1'])!= ''){
			$eosin1= $_POST['eosin1'];
		}else{
			if(isset ($_POST['eosin2']) && ($_POST['eosin2'])!= ''){
				$eosin1=$_POST['eosin2'];
			}
		}
		if(isset ($_POST['segmen1']) && ($_POST['segmen1'])!= ''){
			$segmen1= $_POST['segmen1'];
		}else{
			if(isset ($_POST['segmen2']) && ($_POST['segmen2'])!= ''){
				$segmen1=$_POST['segmen2'];
			}
		}
		if(isset ($_POST['mono1']) && ($_POST['mono1'])!= ''){
			$mono1= $_POST['mono1'];
		}else{
			if(isset ($_POST['mono2']) && ($_POST['mono2'])!= ''){
				$mono1=$_POST['mono2'];
			}
		}
		
		#Nos esta llegando un valor del 2do recuadro pero no esta llegando id2 entonces es inserción 
		if( (isset ($_POST['mono2']) && ($_POST['mono2']) != '') && ($_POST['idLab2'] == NULL || $_POST['idLab2'] == '' )){
			$idLab = NULL;
		}else {
			if( (isset ($_POST['mono1']) && ($_POST['mono1']) != '') && ($_POST['idLab'] == NULL || $_POST['idLab'] == '' )){
				$idLab = NULL;
			}
		}
		
		#Solo sirve para Actualizacion
		if((isset ($_POST['mono2']) && ($_POST['mono2']) != '') && (isset ($_POST['idLab2']) && ($_POST['idLab2'])!= '')){
			$idLab = $_POST['idLab2'];
		}else{
			if((isset ($_POST['mono1']) && ($_POST['mono1']) != '') && (isset ($_POST['idLab']) && ($_POST['idLab'])!= '')){
				$idLab=$_POST['idLab'];
			}
		}
				
		#Recibimos un id entonces es Actualizacion
		if($idLab != NULL && $idLab != ''){
			$queryUpdLab="UPDATE datoslaboratorio SET fechaMuestra = '$ref1', glucosa = '$glc1', urea = '$urea1', creatinina = '$crea1', `aUrico` = '$urico1',
			tProtrombina = '$protro1', col = '$col1', tgn = '$tgn1', na = '$na1', k = '$k1', cl = '$cl1', hb = '$hb1', hematocrito = '$hema1', leucocitos = '$leuco1',
			linfocitos = '$linfo1', eosinofilos = '$eosin1', `nSegmentados` = '$segmen1', monocitos = '$mono1' WHERE datoslaboratorio.idLab = '$idLab'";
			
			$result0 = mysqli_query($conexion, $queryUpdLab);
			
			if(!$result0){
				echo'!!! ERROR AL ACTUALIZAR DATOS DE LABORATORIO !!!';
				echo '<br/>Query UPDT_LAB: '.$queryUpdLab.'<br/>';
				exit;
			} else {
				echo '<br/><strong>!!!! SE ACTUALIZARON LOS DATOS DE LABORATORIO CORRECTAMENTE !!!!</strong><br>';
				#echo '<br/>Query UPD_LAB: '.$queryUpdLab.'<br/>';
			}
			
		}else{
			 $queryInsLab = "INSERT INTO datoslaboratorio (idLab, numeroExpediente, folio, fechaMuestra, glucosa, urea, creatinina, aUrico,
			 tProtrombina, col, tgn, na, k, cl, hb, hematocrito, leucocitos, linfocitos, eosinofilos, nSegmentados, monocitos)
			 VALUES (NULL, '$expediente', '$folio', '$ref1', '$glc1', '$urea1', '$crea1', '$urico1', '$protro1', '$col1', '$tgn1', '$na1', 
			 '$k1', '$cl1', '$hb1', '$hema1', '$leuco1', '$linfo1', '$eosin1', '$segmen1', '$mono1')";
		
			$result0 = mysqli_query($conexion, $queryInsLab);
			
			if(!$result0){
				echo'!!! ERROR AL INSERTAR DATOS DE LABORATORIO !!!';
				echo '<br/>Query INSRT_LAB: '.$queryInsLab.'<br/>';
				exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LABORATORIO CORRECTAMENTE !!!!</strong><br>';
				#echo '<br/>Query UPD: '.$queryInsLab.'<br/>';
			}
		}
		#echo 'DATOS que llegaron (algunos):Ref '.$ref1.' GLCS: '.$glc1. ' LEUCO: '.$leuco1.' LINFO: '.$linfo1.' SEGMENT: '.$segmen1.' MONO: '.$mono1.'<br>';
	}
	
	$queryDatosLab="SELECT * FROM datoslaboratorio WHERE numeroExpediente='$expediente' AND (folio = 0 || folio= '$folio') ORDER BY fechaMuestra DESC";
	$idLab = mysqli_query($conexion, $queryDatosLab) or die (mysqli_error($conexion));
	$json = array();
	while($row = mysqli_fetch_array($idLab)){
		$json[] = ($row);
	}
	$val='0';
	if(isset ($json[1]['idLab'])){
		$val='1';
		$idLabUpd2=$json[1]['idLab'];
	} else {
		$idLabUpd2 = '';
	}
	
	if(isset ($json[0]['idLab'])){
		$idLabUpd=$json[0]['idLab'];
	} else {
		$idLabUpd = '';
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Datos Laboratorio</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<style type="text/css">
	.auto-style1 {
		border-left: 0px solid #0000FF;
		border-right: 0px solid #0000FF;
		border-top: 1px solid #0000FF;
		border-bottom: 0px solid #0000FF;
	}
	.auto-style2 {
		font-size: large;
		border-bottom-style: solid;
		border-bottom-width: 1px;
	}
	.auto-style4 {
		font-size: large;
		border-style: solid;
		border-width: 1px;
	}
	.auto-style5 {
		text-align: left;
	}
</style>
</head>
<script type="text/javascript">
	function mostrar(v){
	  if(v=="1"){
	  	document.getElementById('celda2_0').style.display="block";
	  	//document.getElementById('ccelda2_0').disabled=false;
	  	document.getElementById('celda2_1').style.display="block";
	  	document.getElementById('celda2_2').style.display="block";
	  	document.getElementById('celda2_3').style.display="block";
	  	document.getElementById('celda2_4').style.display="block";
	  	document.getElementById('celda2_5').style.display="block";
	  	document.getElementById('celda2_6').style.display="block";
	  	document.getElementById('celda2_7').style.display="block";
	  	document.getElementById('celda2_8').style.display="block";
	  	document.getElementById('celda2_9').style.display="block";
	  	document.getElementById('celda2_10').style.display="block";
	  	document.getElementById('celda2_11').style.display="block";
	  	document.getElementById('celda2_12').style.display="block";
	  	document.getElementById('celda2_13').style.display="block";
	  	document.getElementById('celda2_14').style.display="block";
	  	document.getElementById('celda2_15').style.display="block";
	  	document.getElementById('celda2_16').style.display="block";
	  	document.getElementById('celda2_17').style.display="block";
	  	document.getElementById('celda2_18').style.display="block";
	  	
	  	document.getElementById('btnGuardar').disabled=false;
	  } else {
	  	document.getElementById('celda2_0').style.display="none";
	  	
	  } 
	}
	  
	  function desbloquear(d){
	  	if(d=="1"){
	  		document.getElementById('celda1_0').disabled=false;
	  		document.getElementById('celda1_1').disabled=false;
	  		document.getElementById('celda1_2').disabled=false;
	  		document.getElementById('celda1_3').disabled=false;
	  		document.getElementById('celda1_4').disabled=false;
	  		document.getElementById('celda1_5').disabled=false;
			document.getElementById('celda1_6').disabled=false;
			document.getElementById('celda1_7').disabled=false;
			document.getElementById('celda1_8').disabled=false;
			document.getElementById('celda1_9').disabled=false;
			document.getElementById('celda1_10').disabled=false;
			document.getElementById('celda1_11').disabled=false;
			document.getElementById('celda1_12').disabled=false;
			document.getElementById('celda1_13').disabled=false;
			document.getElementById('celda1_14').disabled=false;
			document.getElementById('celda1_15').disabled=false;
			document.getElementById('celda1_16').disabled=false;
			document.getElementById('celda1_17').disabled=false;
			
			document.getElementById('btnGuardar').disabled=false;
			document.getElementById('btnModificar1').disabled=true;
			document.getElementById('btnModificar2').disabled=true;
	  	}
	  	if(d=="2"){
	  			document.getElementById('ccelda2_0').disabled=false;
	  			document.getElementById('ccelda2_1').disabled=false;
	  			document.getElementById('ccelda2_2').disabled=false;
	  			document.getElementById('ccelda2_3').disabled=false;
	  			document.getElementById('ccelda2_4').disabled=false;
	  			document.getElementById('ccelda2_5').disabled=false;
	  			document.getElementById('ccelda2_6').disabled=false;
	  			document.getElementById('ccelda2_7').disabled=false;
	  			document.getElementById('ccelda2_8').disabled=false;
	  			document.getElementById('ccelda2_9').disabled=false;
	  			document.getElementById('ccelda2_10').disabled=false;
	  			document.getElementById('ccelda2_11').disabled=false;
	  			document.getElementById('ccelda2_12').disabled=false;
	  			document.getElementById('ccelda2_13').disabled=false;
	  			document.getElementById('ccelda2_14').disabled=false;
	  			document.getElementById('ccelda2_15').disabled=false;
	  			document.getElementById('ccelda2_16').disabled=false;
	  			document.getElementById('ccelda2_17').disabled=false;
 			
	  			document.getElementById('btnGuardar').disabled=false;
	  			document.getElementById('btnModificar1').disabled=true;
				document.getElementById('btnModificar2').disabled=true;
	  		}
	  	}
</script>
<body onload="mostrar(<?php echo $val ?>);">
&nbsp;&nbsp;<input class="btn btn-danger" id="btnModificar" type="button" value="SALIR" onclick="window.close();" style="width: 150px; height: 60px" />
<br/>
<br/>
<strong>DATOS DE LABORATORIO PARA PACIENTE: <?php echo ' '.$expediente.' '.$nomPac; ?></strong>
<form method="post" action="datosLaboratorio_OLD.php">
	<table class="auto-style1" style="width: 100%">
		<th class="auto-style2">ELEMENTO</th>
		<th class="auto-style2" style="width: 211px">VALOR DE REFERENCIA</th>
		<th class="auto-style2" style="width: 141px"><input id="celda1_0" name="ref1" type="date" value="<?php echo $json[0]['fechaMuestra']; ?>" disabled /></th>
		<th id="celda2_0" style="display:none" class="auto-style2"><input id="ccelda2_0" name="ref2" type="date" value="<?php echo $json[1]['fechaMuestra']; ?>" disabled /></th>
	<tr>
		<td class="auto-style4">GLUCOSA</td>
		<td class="auto-style4" style="width: 211px">70-110 mg/dL</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_1" name="glc1" type="number" step=".01" value="<?php echo $json[0]['glucosa']; ?>" disabled /></td>
		<td id="celda2_1" style="display:none" class="auto-style4"><input id="ccelda2_1" name="glc2" type="number" step=".01" value="<?php echo $json[1]['glucosa']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">UREA</td>
		<td class="auto-style4" style="width: 211px">10-50 mg/dL</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_2" name="urea1" type="number" step=".01" value="<?php echo $json[0]['urea']; ?>" disabled /></td>
		<td id="celda2_2" style="display:none" class="auto-style4"><input id="ccelda2_2" name="urea2" type="number" step=".01" value="<?php echo $json[1]['urea']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">CREATININA</td>
		<td class="auto-style4" style="width: 211px">0.8-1.3 mg/dL</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_3" name="crea1" type="number" step=".01" value="<?php echo $json[0]['creatinina']; ?>" disabled /></td>
		<td id="celda2_3" style="display:none" class="auto-style4"><input id="ccelda2_3" name="crea2" type="number" step=".01" value="<?php echo $json[1]['creatinina']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">A. URICO</td>
		<td class="auto-style4" style="width: 211px">3.4-7 mg/dL</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_4" name="urico1" type="number" step=".01" value="<?php echo $json[0]['aUrico']; ?>" disabled /></td>
		<td id="celda2_4" style="display:none" class="auto-style4"><input id="ccelda2_4" name="urico2" type="number" step=".01" value="<?php echo $json[1]['aUrico']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">T PROTROMBINA</td>
		<td class="auto-style4" style="width: 211px">&nbsp;</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_5" name="protro1" type="number" step=".01" value="<?php echo $json[0]['tProtrombina']; ?>" disabled /></td>
		<td id="celda2_5" style="display:none" class="auto-style4"><input id="ccelda2_5" name="protro2" type="number" step=".01" value="<?php echo $json[1]['tProtrombina']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">COL</td>
		<td class="auto-style4" style="width: 211px">140-220 mg/dL</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_6" name="col1" type="number" step=".01" value="<?php echo $json[0]['col']; ?>" disabled /></td>
		<td id="celda2_6" style="display:none" class="auto-style4"><input id="ccelda2_6" name="col2" type="number" step=".01" value="<?php echo $json[1]['col']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">TGN</td>
		<td class="auto-style4" style="width: 211px">0-150 mg/dL</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_7" name="tgn1" type="number" step=".01" value="<?php echo $json[0]['tgn']; ?>" disabled /></td>
		<td id="celda2_7" style="display:none" class="auto-style4"><input id="ccelda2_7" name="tgn2" type="number" step=".01" value="<?php echo $json[1]['tgn']; ?>" disabled/></td>
	</tr>
	<tr>
		<td class="auto-style4">NA +</td>
		<td class="auto-style4" style="width: 211px">135-145 mEq/l</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_8" name="na1" type="number" step=".01" value="<?php echo $json[0]['na']; ?>" disabled /></td>
		<td id="celda2_8" style="display:none" class="auto-style4"><input id="ccelda2_8" name="na2" type="number" step=".01" value="<?php echo $json[1]['na']; ?>" disabled/></td>
	</tr>
	<tr>
		<td class="auto-style4">K+</td>
		<td class="auto-style4" style="width: 211px">3.4-4.5 mEq/l</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_9" name="k1" type="number" step=".01" value="<?php echo $json[0]['k']; ?>" disabled /></td>
		<td id="celda2_9" style="display:none" class="auto-style4"><input id="ccelda2_9" name="k2" type="number" step=".01" value="<?php echo $json[1]['k']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">Cl-</td>
		<td class="auto-style4" style="width: 211px">96-108 mEq/l</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_10" name="cl1" type="number" step=".01" value="<?php echo $json[0]['cl']; ?>" disabled /></td>
		<td id="celda2_10" style="display:none" class="auto-style4"><input id="ccelda2_10" name="cl2" type="number" step=".01" value="<?php echo $json[1]['cl']; ?>" disabled/></td>
	</tr>
	<tr>
		<td class="auto-style4">Hb</td>
		<td class="auto-style4" style="width: 211px">&nbsp;</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_11" name="hb1" type="number" step=".01" value="<?php echo $json[0]['hb']; ?>" disabled /></td>
		<td id="celda2_11" style="display:none" class="auto-style4"><input id="ccelda2_11" name="hb2" type="number" step=".01" value="<?php echo $json[1]['hb']; ?>" disabled/></td>
	</tr>
	<tr>
		<td class="auto-style4">HEMATOCRITO</td>
		<td class="auto-style4" style="width: 211px">&nbsp;</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_12" name="hema1" type="number" step=".01" value="<?php echo $json[0]['hematocrito']; ?>" disabled /></td>
		<td id="celda2_12" style="display:none" class="auto-style4"><input id="ccelda2_12" name="hema2" type="number" step=".01" value="<?php echo $json[1]['hematocrito']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">LEUCOCITOS</td>
		<td class="auto-style4" style="width: 211px">4500-10000 mill/mm3</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_13" name="leuco1" type="number" step=".01" value="<?php echo $json[0]['leucocitos']; ?>" disabled /></td>
		<td id="celda2_13" style="display:none" class="auto-style4"><input id="ccelda2_13" name="leuco2" type="number" step=".01" value="<?php echo $json[1]['leucocitos']; ?>" disabled/></td>
	</tr>
	<tr>
		<td class="auto-style4">LINFOCITOS</td>
		<td class="auto-style4" style="width: 211px">23-35%</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_14" name="linfo1" type="number" step=".01" value="<?php echo $json[0]['linfocitos']; ?>" disabled /></td>
		<td id="celda2_14" style="display:none" class="auto-style4"><input id="ccelda2_14" name="linfo2" type="number" step=".01" value="<?php echo $json[1]['linfocitos']; ?>" disabled/></td>
	</tr>
	<tr>
		<td class="auto-style4">EOSINOFILOS</td>
		<td class="auto-style4" style="width: 211px">1-4%</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_15" name="eosin1" type="number" step=".01" value="<?php echo $json[0]['eosinofilos']; ?>" disabled /></td>
		<td id="celda2_15" style="display:none" class="auto-style4"><input id="ccelda2_15" name="eosin2" type="number" step=".01" value="<?php echo $json[1]['eosinofilos']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">N. SEGMENTADOS</td>
		<td class="auto-style4" style="width: 211px">55-65%</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_16" name="segmen1" type="number" step=".01" value="<?php echo $json[0]['nSegmentados']; ?>" disabled /></td>
		<td id="celda2_16" style="display:none" class="auto-style4"><input id="ccelda2_16" name="segmen2" type="number" step=".01" value="<?php echo $json[1]['nSegmentados']; ?>" disabled /></td>
	</tr>
	<tr>
		<td class="auto-style4">MONOCITOS</td>
		<td class="auto-style4" style="width: 211px">4-8%</td>
		<td class="auto-style4" style="width: 141px"><input id="celda1_17" name="mono1" type="number" step=".01" value="<?php echo $json[0]['monocitos']; ?>" disabled /></td>
		<td id="celda2_17" style="display:none" class="auto-style4"><input id="ccelda2_17" name="mono2" type="number" step=".01" value="<?php echo $json[1]['monocitos']; ?>" disabled/></td>
	</tr>
	<tr>
		<td class="auto-style4">&nbsp;</td>
		<td class="auto-style4" style="width: 211px">&nbsp;</td>
		<td class="auto-style4" style="width: 141px"><input class="btn btn-info" id="btnModificar1" type="button" value="MODIFICAR1" onclick="desbloquear('1')" style="width: 140px; height: 60px" /></td>
		<td id="celda2_18" style="display:none" class="auto-style4"><input class="btn btn-info" id="btnModificar2" type="button" value="MODIFICAR2" onclick="desbloquear('2')" style="width: 140px; height: 60px" /></td>
	</tr>
</table>
<div class="auto-style5">&nbsp;&nbsp;
		<input name="idLab" type="hidden" value="<?php echo $idLabUpd ?>" />
		<input name="idLab2" type="hidden" value="<?php echo $idLabUpd2 ?>" />
		<input name="expediente" type="hidden" value="<?php echo $expediente ?>" />
		<input name="folio" type="hidden" value="<?php echo $folio ?>" />
		<input name="nomPac" type="hidden" value="<?php echo $nomPac ?>" />

<input class="btn btn-success" id="btnGuardar" name="enviarLab" type="submit" value="GUARDAR" style="width: 160px; height: 60px" disabled/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input class="btn btn-primary" id="btnMostrar" type="button" value="AGREGAR" onclick="mostrar('1')" style="width: 140px; height: 60px"/>
</div>
</form>
</body>

</html>
