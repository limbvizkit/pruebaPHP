<?php
	require_once('../conexion/configLogin.php');

	$area=NULL;
	
 	if (isset($_POST['area']))
	{
		$area = $_POST['area'];
		if($area == 0){
			$area = 'areaDepto > 0';
		} else {
			$area = 'areaDepto = '.$area;
		}
	}
	#echo 'AREA: '.$area;
	/*$queryCodig = "SELECT codigo,fechaAlta FROM datosdocumentosNew WHERE idDocumento = '$id'";
	$codi = mysqli_query($conexion, $queryCodig) or die (mysqli_error($conexion));
	$codigo = mysqli_fetch_array($codi);
	$codigoFin = $codigo[0];
	$fecha = strtotime($codigo['fechaAlta']);
	$fechaFin = date('Y',$fecha);*/
	
	$hoy = getdate();
	$fechaFin=$hoy['year'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Detalle Documento</title>
<script type="text/jscript" src="../js/bootstrap.min.js" >	</script>
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<style type="text/css">
.auto-style1 {
	border: 1px solid #000000;
	text-align: center;
}
.auto-style4 {
	text-align: center;
	border: 2px solid #000000;
}
.auto-style5 {
	text-align: left;
	border: 2px solid #000000;
}
</style>
</head>
<body>

	<h1><br/>
	<img alt="imgHD" height="108" longdesc="Logo del HD" src="../img/logoNew2.jpg" width="100"/> CATÁLOGO DE DISPOSICIÓN DOCUMENTAL</h1>

	<table>
      <thead>
        <tr>
		  <th class="auto-style4" colspan="15">Hospital Henri Dunant</th>
		  <th class="auto-style4" colspan="4">Año: <?php echo $fechaFin ?></th>
        </tr>
        <tr>
		  <th class="auto-style4" colspan="3"></th>
		  <th class="auto-style4" colspan="3">Información Documental</th>
		  <th class="auto-style4" colspan="5">Plazo de Vigencia</th>
		  <th class="auto-style4" colspan="4">Valor Documental</th>
		  <th class="auto-style4">&nbsp;</th>
		  <th class="auto-style4">&nbsp;</th>
		  <th class="auto-style4">&nbsp;</th>
		  <th class="auto-style4">&nbsp;</th>
        </tr>
        <tr>
		  <th class="auto-style4"></th>
		  <th class="auto-style4">Código</th>
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
			$serieOld = NULL;
			$queryDocs = "SELECT idDocumento, codigo, a.nombreArea, s.NombreSerieDoc, subSerie, nombreDocumento, tipoDocsIntegran, c.nombreCaracterDocs, nombreVigencia, ao, at, ac, t, l, f, c, a, 
									nombreDisposicionDoc, r, c1, observaciones, estatus, fechaAlta, observaciones
				 		  FROM datosdocumentosNew AS d
						  LEFT JOIN areas AS a ON d.areaDepto=a.idArea
						  LEFT JOIN seriedocumental AS s ON d.serie=s.idSerieDoc
						  LEFT JOIN caracterdocs AS c ON d.caracterDoc=c.idCaracterDocs
						  LEFT JOIN disposiciondocumental AS dis ON d.disposicionDoc=dis.idDisposicionDoc
						  LEFT JOIN vigencia AS v ON d.vigencia=v.idVigencia
						  WHERE $area AND estatus=1 ORDER BY s.NombreSerieDoc, subSerie";
			$docs = mysqli_query($conexion, $queryDocs) or die (mysqli_error($conexion));
			
			while($row = mysqli_fetch_array($docs)){
				$fecha = strtotime($row['fechaAlta']);
		    	$fechaFin = date('d-m-Y H:i',$fecha);
		    	
		    	$serie = $row['NombreSerieDoc'];
		    	if($serie != $serieOld){
		    	$queryCodigo = "SELECT a.nombreArea, s.NombreSerieDoc
				 		  FROM datosdocumentosNew AS d
						  LEFT JOIN areas AS a ON d.areaDepto=a.idArea
						  LEFT JOIN seriedocumental AS s ON d.serie=s.idSerieDoc
						  WHERE $area AND estatus=1 AND s.NombreSerieDoc='$serie'";
				$codig = mysqli_query($conexion, $queryCodigo) or die (mysqli_error($conexion));
				$row0 = mysqli_fetch_array($codig);
				
				$serieOld = $row0['NombreSerieDoc'];
		?>
		 <tr>
			<th class="auto-style5" colspan="19">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Área Depto/Servicio: <?php echo utf8_encode($row0['nombreArea']) ?></th>
      	</tr>
      	<tr>
			<th class="auto-style5" colspan="19">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Serie: <?php echo utf8_encode($row0['NombreSerieDoc']) ?></th>
      	</tr>
        <?php } ?>
		<tr>
			<td class="auto-style1"></td>
			<td class="auto-style1"><?php echo $row['codigo'] ?></td>
			<td class="auto-style1"><?php echo $row['subSerie'] ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['nombreDocumento']) ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['tipoDocsIntegran']) ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['nombreCaracterDocs']) ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['nombreVigencia']) ?></td>
			<td class="auto-style1"><?php echo $row['ao'] ?></td>
			<td class="auto-style1"><?php echo $row['at'] ?></td>
			<td class="auto-style1"><?php echo $row['ac'] ?></td>
			<td class="auto-style1"><?php echo $row['t'] ?></td>
			<td class="auto-style1"><?php echo ($row['l']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo ($row['f']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo ($row['c']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo ($row['a']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['nombreDisposicionDoc']) ?></td>
			<td class="auto-style1"><?php echo $row['r'] ?></td>
			<td class="auto-style1"><?php echo ($row['c1'] == 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['observaciones']) ?></td>
		</tr>
		<?php } ?>
      </tbody>
	</table>
	<br/><br/>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" />
</body>

</html>
