<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>AgregarMaterial</title>
<link rel="stylesheet" href="css/bootstrap1.min.css" />

<style type="text/css">
	.auto-style3 {
		font-family: Arial, Helvetica, sans-serif;
		text-align: center;
	}
	.auto-style4 {
		border: 1px solid #000000;
	}
	.auto-style5 {
		border: 3px solid #000000;
	}
	</style>
</head>

<body>
	<form method="post" action="formatoResguardo.php">
	<div class="auto-style3">
		<span> <br />
		ACTIVO(S)
		FIJO(S), EQUIPO MENOR Y/O HERRAMIENTA(S) DE TRABAJO.</span>
	</div>
	<br/>
	<table style="width: 100%">
		<th style="width: 81px" class="auto-style5">CANTIDAD</th>
		<th style="width: 64px" class="auto-style5">UNIDAD</th>
		<th class="auto-style5">&nbsp;&nbsp;TIPO DE ACTIVO</th>
		<th class="auto-style5">&nbsp;&nbsp;DESCRIPCIÓN <br/>&nbsp;&nbsp;DE ACTIVO</th>
		<th class="auto-style5">&nbsp;&nbsp;NO. SERIE</th>
		<th class="auto-style5">&nbsp;&nbsp;MARCA</th>
		<th class="auto-style5">&nbsp;&nbsp;MODELO</th>
		<th class="auto-style5">&nbsp;&nbsp;IMAGEN</th>
		<tr>
			<td class="auto-style4"></td>
			<td class="auto-style4"></td>
			<td class="auto-style4"></td>
			<td class="auto-style4"></td>
			<td class="auto-style4"></td>
			<td class="auto-style4"></td>
			<td class="auto-style4"></td>
			<td class="auto-style4"></td>
		</tr>
	</table>
		<br />
		<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CANTIDAD: </strong><input type="text" id="cantidad" name="cantidad" style="width: 81px"/>
		<strong>&nbsp;UNIDAD: </strong>
		<input type="text" id="unidad" name="unidad" style="width: 101px"/>&nbsp;
		<strong>TIPO DE ACTIVO: </strong>
		<input type="text" id="tipo" name="tipo" style="width: 298px"/> <br />
		<br />
		&nbsp; <strong>&nbsp;&nbsp;&nbsp;&nbsp; DESCRIPCIÓN DE ACTIVO: </strong>
		<input type="text" id="descripcion" name="descricion" style="width: 577px"/>
		<br />
		<br />
		&nbsp; <strong>&nbsp;&nbsp;&nbsp;&nbsp; NÚMERO DE SERIE: </strong>
		<input type="text" id="serie" name="serie" style="width: 161px"/>&nbsp;
		<strong>MARCA: </strong> 
		<input type="text" id="marca" name="marca" style="width: 170px"/>&nbsp;
		<strong>MODELO:</strong> 
		<input type="text" id="modelo" name="modelo" style="width: 140px"/><br />
		<br />
		&nbsp; <strong>&nbsp;&nbsp;&nbsp;&nbsp; IMAGEN:</strong> <input type="text" id="imagen" name="imagen" style="width: 250px"/>
		<br />
		<br />
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input class="btn btn-success" name="guardar" type="submit" value="GUARDAR" style="height: 60px; width: 166px" />
	</form>	
	<br />
	<br />
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> SALIR </a>
</body>

</html>
