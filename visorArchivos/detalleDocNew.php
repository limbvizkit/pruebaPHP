<?php
	require_once('../conexion/configLogin.php');

 	if (isset($_GET['id']))
	{
		$id=$_GET['id'];
	}
	
	if(isset($_REQUEST['modifDoc']))
	{
	
		$l = '0';
		$f = '0';
		$c = '0';
		$a = '0';
		$c1 = '0';
		$ao = '0';
		$at = '0';
		$ac = '0';
		$t = '0';
		
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
		} else {
			$id = NULL;
		}
		if (isset($_POST['nombreDoc']))
		{
			$nombreDoc= utf8_decode($_POST['nombreDoc']);
		}else {
			$nombreDoc= NULL;
		}
		if (isset($_POST['tiposDoc']))
		{
			$tiposDoc= utf8_decode($_POST['tiposDoc']);
		}else {
			$tiposDoc= NULL;
		}
		
		if (isset($_POST['caracterDocs']))
		{
			$caracterDocs=$_POST['caracterDocs'];
		}else {
			$caracterDocs= NULL;
		}
		if (isset($_POST['vigencia']))
		{
			$vigencia= $_POST['vigencia'];
		}else {
			$vigencia= NULL;
		}
		if (isset($_POST['ao']))
		{
			if($_POST['ao'] != NULL && $_POST['ao'] != ''){
				$ao = $_POST['ao'];
			} else {
				$ao = '0';
			}
		}
		if (isset($_POST['at']))
		{
			if($_POST['at'] != NULL && $_POST['at'] != ''){
				$at = $_POST['at'];
			} else {
				$at = '0';
			}
		}
		if (isset($_POST['ac']))
		{
			if($_POST['ac'] != NULL && $_POST['ac'] != ''){
				$ac= $_POST['ac'];
			} else {
				$ac= '0';
			}
		}
		if (isset($_POST['t']))
		{
			if($_POST['t'] != NULL && $_POST['t'] != ''){
				$t= $_POST['t'];
			} else {
				$t= '0';
			}
		}
		if (isset($_POST['l']))
		{
			if($_POST['l'] != NULL && $_POST['l'] != ''){
				$l= $_POST['l'];
			} else {
				$l= '0';
			}
		}
		if (isset($_POST['f']))
		{
			if($_POST['f'] != NULL && $_POST['f'] != ''){
				$f= $_POST['f'];
			} else {
				$f= '0';
			}
		}
		if (isset($_POST['c']))
		{
			if($_POST['c'] != NULL && $_POST['c'] != ''){
				$c= $_POST['c'];
			} else {
				$c= '0';
			}
		}
		if (isset($_POST['a']))
		{
			if($_POST['a'] != NULL && $_POST['a'] != ''){
				$a= $_POST['a'];
			} else {
				$a= '0';
			}
		}
		if (isset($_POST['dispDoc']))
		{
			$dispDoc = $_POST['dispDoc'];
		}else {
			$dispDoc = NULL;
		}
		if (isset($_POST['r']))
		{
			if($_POST['r'] != NULL && $_POST['r'] != ''){
				$r= $_POST['r'];
			} else {
				$r= '0';
			}
		}
		if (isset($_POST['c1']))
		{
			if($_POST['c1'] != NULL && $_POST['c1'] != ''){
				$c1= $_POST['c1'];
			} else {
				$c1= '0';
			}
		}
		if (isset($_POST['obsDoc']))
		{
			$obsDoc=utf8_decode($_POST['obsDoc']);
		}else {
			$obsDoc= NULL;
		}
		#echo "LLEGO: ID ".$id.' NomDoc: '.$nombreDoc.' TipDoc: '.$tiposDoc.' CaracDocs: '.$caracterDocs.' vigDocs: '.$vigencia.' AO: '.$ao.' AT: '.$at.' AC: '.$ac.' T: '.
			#$t.' L: '.$l.' F: '.$f.' C: '.$c.' A: '.$a.' DispDocs: '.$dispDoc.' R: '.$r.' C1: '.$c1.' ObsDoc: '.$obsDoc;
			
		$queryUpdArchivo = "UPDATE datosdocumentosnew SET tipoDocsIntegran = '$tiposDoc', nombreDocumento = '$nombreDoc', caracterDoc = '$caracterDocs', vigencia = '$vigencia', 
							   ao = '$ao', at = '$at', ac = '$ac', t = '$t', l = '$l', f = '$f', c = '$c', a = '$a', disposicionDoc = '$dispDoc', r = '$r', c1 = '$c1', observaciones = '$obsDoc' 
							WHERE idDocumento = '$id'";
		$result0 = mysqli_query($conexion, $queryUpdArchivo);
			
		if(!$result0){
			echo'<span class="auto-style1">!!! ERROR AL REALIZAR ACTUALIZACIÓN DE DATOS DEL DOCUMENTO!!!</span>';
			echo '<br/>Query Add: '.$queryUpdArchivo;
			exit;
		} else {
			echo '<br/><span class="auto-style3"><strong>!!!! SE ACTUALIZARON LOS DATOS DEL DOCUMENTO CORRECTAMENTE !!!!</strong></span><br>';
			#echo '<br/>Query Add: '.$queryUpdArchivo;
		}
	}
	
	$queryCodig = "SELECT codigo,fechaAlta FROM datosdocumentosNew WHERE idDocumento = '$id'";
	$codi = mysqli_query($conexion, $queryCodig) or die (mysqli_error($conexion));
	$codigo = mysqli_fetch_array($codi);
	$codigoFin = $codigo[0];
	$fecha = strtotime($codigo['fechaAlta']);
	$fechaFin = date('Y',$fecha);
	
	$queryRevision0 = "SELECT l, f, c, a, c1 FROM datosdocumentosNew WHERE idDocumento = '$id'";
	$idRevi0 = mysqli_query($conexion, $queryRevision0) or die (mysqli_error($conexion));
	$row0 = mysqli_fetch_array($idRevi0);
	$valL = $row0[0];
	$valF = $row0[1];
	$valC = $row0[2];
	$valA = $row0[3];
	$valC1 = $row0[4];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Detalle Documento</title>
<script type="text/jscript" src="../js/bootstrap.min.js" >	</script>
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<script type="text/javascript">
	function blqCeldas(){
		document.getElementById("nombreDoc").disabled=false;
		document.getElementById("tiposDoc").disabled=false;
		document.getElementById("caracterDocs").disabled=false;
		document.getElementById("vigencia").disabled=false;
		document.getElementById("ao").disabled=false;
		document.getElementById("at").disabled=false;
		document.getElementById("ac").disabled=false;
		document.getElementById("t").disabled=false;
		document.getElementById("l").disabled=false;
		document.getElementById("f").disabled=false;
		document.getElementById("c").disabled=false;
		document.getElementById("a").disabled=false;
		document.getElementById("dispDoc").disabled=false;
		document.getElementById("r").disabled=false;
		document.getElementById("c1").disabled=false;
		document.getElementById("obsDoc").disabled=false;
		document.getElementById("btnGrd").disabled=false;
	}
	function checarL(d){
		if(d=="1"){
		 	document.getElementById('l').checked = true;
		} else {
			document.getElementById('l').checked = false;
		}
	}
	function checarF(d){
		if(d=="1"){
		 	document.getElementById('f').checked = true;
		} else {
			document.getElementById('f').checked = false;
		}
	}
	function checarC(d){
		if(d=="1"){
		 	document.getElementById('c').checked = true;
		} else {
			document.getElementById('c').checked = false;
		}
	}
	function checarA(d){
		if(d=="1"){
		 	document.getElementById('a').checked = true;
		} else {
			document.getElementById('a').checked = false;
		}
	}
	function checarC1(d){
		if(d=="1"){
		 	document.getElementById('c1').checked = true;
		} else {
			document.getElementById('c1').checked = false;
		}
	}
</script>
<style type="text/css">
.auto-style1 {
	border: 1px solid #000000;
	text-align: center;
}
.auto-style4 {
	text-align: center;
	border: 2px solid #000000;
}
</style>
</head>
<body  onload="checarL(<?php echo $valL ?>); checarF(<?php echo $valF ?>); checarC(<?php echo $valC ?>); checarA(<?php echo $valA ?>); checarC1(<?php echo $valC1 ?>)">

	<h1><br/>Datos del documento</h1>
	<form method="post" action="detalleDocNew.php">
	<input name="id" type="hidden" value="<?php echo $id ?>" />
	<table>
      <thead>
        <tr>
		  <th class="auto-style4" colspan="4">Código: <?php echo $codigoFin ?> </th>
		  <th class="auto-style4" colspan="11">Hospital Henri Dunant</th>
		  <th class="auto-style4">Año: <?php echo $fechaFin ?></th>
		  <th colspan="3" class="auto-style4">HHD</th>
        </tr>
        <tr>
		  <th class="auto-style4" colspan="3">&nbsp;</th>
		  <th class="auto-style4" colspan="3">Información Documental</th>
		  <th class="auto-style4" colspan="5">Plazo de Vigencia</th>
		  <th class="auto-style4" colspan="4">Valor Documental</th>
		  <th class="auto-style4">&nbsp;</th>
		  <th class="auto-style4">&nbsp;</th>
		  <th class="auto-style4">&nbsp;</th>
		  <th class="auto-style4">&nbsp;</th>
        </tr>
        <tr>
		  <th class="auto-style4">Área Depto/Servicio</th>
		  <th class="auto-style4">Serie</th>
		  <th class="auto-style4">Subserie</th>
		  <th class="auto-style4">Nombre</th>
		  <th class="auto-style4">Tipos de documentos que la integran</th>
		  <th class="auto-style4">Carácter de los documentos</th>
		  <th class="auto-style4">Vigencia</th>
		  <th class="auto-style4">&nbsp;AO&nbsp;</th>
		  <th class="auto-style4">&nbsp;AT&nbsp;</th>
		  <th class="auto-style4">&nbsp;AC&nbsp;</th>
		  <th class="auto-style4">&nbsp;T&nbsp;</th>
		  <th class="auto-style4">&nbsp;L&nbsp;</th>
		  <th class="auto-style4">&nbsp;F&nbsp;</th>
		  <th class="auto-style4">&nbsp;C&nbsp;</th>
		  <th class="auto-style4">&nbsp;A&nbsp;</th>
		  <th class="auto-style4">Disposición<br/>documental</th>
		  <th class="auto-style4">&nbsp;R&nbsp;</th>
		  <th class="auto-style4">&nbsp;Conf&nbsp;</th>
		  <th class="auto-style4">Observaciones</th>
        </tr>
      </thead>
      <tbody>
		<?php
			$queryDocs = "SELECT idDocumento, a.nombreArea, s.NombreSerieDoc, subSerie, nombreDocumento, tipoDocsIntegran, d.caracterDoc, c.nombreCaracterDocs, d.vigencia, nombreVigencia,
			 					ao, at, ac, t, l, f, c, a, d.disposicionDoc, nombreDisposicionDoc, r, c1, observaciones, estatus, fechaAlta, observaciones
				 		  FROM datosdocumentosNew AS d
						  LEFT JOIN areas AS a ON d.areaDepto=a.idArea
						  LEFT JOIN seriedocumental AS s ON d.serie=s.idSerieDoc
						  LEFT JOIN caracterdocs AS c ON d.caracterDoc=c.idCaracterDocs
						  LEFT JOIN disposiciondocumental AS dis ON d.disposicionDoc=dis.idDisposicionDoc
						  LEFT JOIN vigencia AS v ON d.vigencia=v.idVigencia
						  WHERE idDocumento = '$id'";
			$docs = mysqli_query($conexion, $queryDocs) or die (mysqli_error($conexion));
			while($row = mysqli_fetch_array($docs)){
				$fecha = strtotime($row['fechaAlta']);
		    	$fechaFin = date('d-m-Y H:i',$fecha);
		?>
		
		<tr>
			<td class="auto-style1"><?php echo utf8_encode($row['nombreArea']) ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['NombreSerieDoc']) ?></td>
			<td class="auto-style1"><?php echo $row['subSerie'] ?></td>
			<td class="auto-style1"><textarea id="nombreDoc" name="nombreDoc" cols="20" rows="3" disabled><?php echo utf8_encode($row['nombreDocumento']) ?></textarea> </td>
			<td class="auto-style1"><textarea id="tiposDoc" name="tiposDoc" cols="20" rows="3" disabled><?php echo utf8_encode($row['tipoDocsIntegran']) ?></textarea></td>
			<td class="auto-style1"> 
				<select id="caracterDocs" name="caracterDocs" style="width:150px; height:40px" disabled >
					<option value="<?php echo $row['caracterDoc'] ?>"><?php echo utf8_encode($row['nombreCaracterDocs']) ?></option>
				     <option value="1"> ARCHIVO DIGITAL </option>
				     <option value="2"> ARCHIVO FÍSICO </option>
				</select>
			</td>
			<td class="auto-style1"> 
				<select id="vigencia" name="vigencia" style="width:210px; height:40px" disabled>
					<option value="<?php echo $row['vigencia'] ?>"><?php echo utf8_encode($row['nombreVigencia']) ?></option>
			        <option value="1"> HASTA VIGENCIA </option>
			        <option value="2"> HASTA RESOLUCIÓN </option>
			        <option value="3"> VIGENCIA INDETERMINADA </option>
			   	</select>
			</td>
			<td class="auto-style1"><input type="number" id="ao" name="ao" style="width: 40px;" value="<?php echo $row['ao'] ?>" disabled />  </td>
			<td class="auto-style1"><input type="number" id="at" name="at" style="width: 40px;" value="<?php echo $row['at'] ?>" disabled /> </td>
			<td class="auto-style1"><input type="number" id="ac" name="ac" style="width: 40px;" value="<?php echo $row['ac'] ?>" disabled /> </td>
			<td class="auto-style1"><input type="number" id="t" name="t" style="width: 40px;" value="<?php echo $row['t'] ?>" disabled /> </td>
			<td class="auto-style1"> <?php #echo ($row['l']== 1)? "X":"" ?>
				<input type="checkbox" id="l" name="l" style="width: 30px; height: 30px" value="1" disabled />
			</td>
			<td class="auto-style1"><?php #echo ($row['f']== 1)? "X":"" ?>
				<input type="checkbox" id="f" name="f" style="width: 30px; height: 30px" value="1" disabled />
			</td>
			<td class="auto-style1"><?php #echo ($row['c']== 1)? "X":"" ?>
				<input type="checkbox" id="c" name="c" style="width: 30px; height: 30px" value="1" disabled />
			</td>
			<td class="auto-style1"><?php #echo ($row['a']== 1)? "X":"" ?>
				<input type="checkbox" id="a" name="a" style="width: 30px; height: 30px" value="1" disabled />
			</td>
			<td class="auto-style1">
				<select id="dispDoc" name="dispDoc" style="width:255px; height:40px" disabled >
					<option value="<?php echo $row['disposicionDoc'] ?>"><?php echo utf8_encode($row['nombreDisposicionDoc']) ?></option>
				    <option value="1"> ARCHIVO HISTORICO </option>
				    <option value="2"> BAJA DEFINITIVA </option>
				    <option value="3"> CONSERVACIÓN POR MUESTREO </option>
			   	</select>
			</td>
			<td class="auto-style1"><input type="number" id="r" name="r" style="width: 40px;" value="<?php echo $row['r'] ?>" disabled /></td>
			<td class="auto-style1"><?php #echo ($row['c1'] == 1)? "X":"" ?>
			<input type="checkbox" id="c1" name="c1" style="width: 30px; height: 30px" value="1" disabled />
			</td>
			<td class="auto-style1"><textarea id="obsDoc" name="obsDoc" cols="20" rows="3" disabled><?php echo utf8_encode($row['observaciones']) ?></textarea></td>
			<!--td><?php echo utf8_encode($fechaFin) ?></td-->
		</tr>
		<?php } ?>
      </tbody>
	</table>
	<br/><br/>
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;<!--a class="btn-lg btn-info" onclick="blqCeldas()" >MODIFICAR</a-->
	<input class="btn-lg btn-info" type="button" onclick="blqCeldas()" value="MODIFICAR" style="height: 40px" />
	&nbsp;&nbsp;<input class="btn-lg btn-success" id="btnGrd" type="Submit" name="modifDoc" value="GUARDAR" disabled style="height: 40px" /><br/><br/>
	</form>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="cerrar" type="button" class="btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 40px" />
</body>

</html>
