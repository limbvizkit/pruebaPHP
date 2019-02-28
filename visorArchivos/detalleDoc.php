<?php
	require_once('../conexion/configLogin.php');

 	if (isset($_GET['id']))
	{
		$id=$_GET['id'];
	}
	
	

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
	border: 2px solid #000000;
}
</style>
</head>
<body>

	<h1><br/>Datos del documento</h1>

	<table>
      <thead>
        <tr>
		  <th class="auto-style4" colspan="4">Código</th>
		  <th class="auto-style5" colspan="10">Fondo:</th>
		  <th class="auto-style5">Año:</th>
		  <th colspan="3" class="auto-style4">Fondo:</th>
        </tr>
        <tr>
		  <th class="auto-style5">&nbsp;</th>
		  <th class="auto-style4" colspan="3">Documental</th>
		  <th class="auto-style5">&nbsp;</th>
		  <th class="auto-style5">&nbsp;</th>
		  <th colspan="8" class="auto-style4">Vigencia</th>
		  <th class="auto-style5">&nbsp;</th>
		  <th colspan="3" class="auto-style4">Consulta y plazo de reserva</th>
        </tr>
        <tr>
		  <th class="auto-style4">Sección</th>
		  <th class="auto-style4">Serie</th>
		  <th class="auto-style4">Subserie</th>
		  <th class="auto-style4">Nombre</th>
		  <th class="auto-style4">Tipos de documentos que la integran</th>
		  <th class="auto-style4">Carácter de los documentos</th>
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
		  <th class="auto-style4">&nbsp;C&nbsp;</th>
		  <th class="auto-style4">Plazo</th>
        </tr>
      </thead>
      <tbody>
		<?php
			$queryDocs = "SELECT idDocumento, a.nombreArea, serie, subSerie, nombreDocumento, tipoDocsIntegran, caracterDoc, ao, at, ac, t, l, f, c, a, disposicionDoc, r, c1, plazo, estatus, fechaAlta
				 		  FROM datosdocumentos AS d
						  LEFT JOIN areas AS a ON d.areaDepto=a.idArea
						  WHERE idDocumento = '$id'";
			$docs = mysqli_query($conexion, $queryDocs) or die (mysqli_error($conexion));
			while($row = mysqli_fetch_array($docs)){
				$fecha = strtotime($row['fechaAlta']);
		    	$fechaFin = date('d-m-Y H:i',$fecha);
		?>
		<tr>
			<td class="auto-style1"><?php echo utf8_encode($row['nombreArea']) ?></td>
			<td class="auto-style1"><?php echo $row['serie'] ?></td>
			<td class="auto-style1"><?php echo $row['subSerie'] ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['nombreDocumento']) ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['tipoDocsIntegran']) ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['caracterDoc']) ?></td>
			<td class="auto-style1"><?php echo $row['ao'] ?></td>
			<td class="auto-style1"><?php echo $row['at'] ?></td>
			<td class="auto-style1"><?php echo $row['ac'] ?></td>
			<td class="auto-style1"><?php echo $row['t'] ?></td>
			<td class="auto-style1"><?php echo ($row['l']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo ($row['f']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo ($row['c']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo ($row['a']== 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo utf8_encode($row['disposicionDoc']) ?></td>
			<td class="auto-style1"><?php echo $row['r'] ?></td>
			<td class="auto-style1"><?php echo ($row['c1'] == 1)? "X":"" ?></td>
			<td class="auto-style1"><?php echo $row['plazo'] ?></td>
			<!--td><?php echo utf8_encode($fechaFin) ?></td-->
		</tr>
		<?php } ?>
      </tbody>
	</table>
	<br/><br/>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" />
</body>

</html>
