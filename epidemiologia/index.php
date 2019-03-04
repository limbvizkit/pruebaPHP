<?php
	setlocale(LC_ALL,'');
	header('Content-Type: text/html;charset=utf-8');

	require_once('../conexion/config.php');
	require_once('../conexion/funciones_db.php');
	
 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['permisos']))
	{
		$permisos=$_GET['permisos'];
	}
	/*session_name($rol);
	session_start();*/
	//Si la variable sesión está vacía
	/*if (!isset($_SESSION[$rol]))
	{
	   //nos envía a la siguiente dirección en el caso de no poseer autorización 
	   header("location: index.html");
	}*/
	
	#Esta parte se manda a llamar de aqui mismo
	if(isset($_REQUEST['enviar']))
	{
		$folio = NULL;
		$cadcero=NULL;
		$expediente=NULL;

		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		
		if (isset($_POST['permisos']))
		{
			$permisos=$_POST['permisos'];
		}
		
		#Si el numero de expediente no contiene los 0's al comienzo se los ponemos
		if(isset($_POST['expediente'])){
			$expediente = $_POST['expediente'];
			if(strlen($expediente)<8){
				for($i=0 ; $i<(8 - strlen($expediente)) ; $i++)
				{
					$cadcero.='0';
				}
				$expediente = $cadcero.$expediente;
			}
		}
		
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
	    $usuario1 = new FuncionesDB();
	    #La funcion retorna un arreglo lo mandamos a una variable
	    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	    
	    if (empty($resultado[0])) {
	    	echo '<br/><p class="auto-style7"> <strong> NO EXISTEN DATOS PARA ESE NÚMERO DE EXPEDIENTE <br/> </strong>';
	    } else {
		    echo '<br/><p class="auto-style7"> <strong> Favor de seleccionar una fila:</strong>
		    		<br/><center><table style="width: 30%"  border="3px solid black;">
					<th class="auto-style6">&nbsp;FECHA INGRESO&nbsp;</th>
					<th class="auto-style6">&nbsp;EXPEDIENTE&nbsp;</th>
					<th class="auto-style6">&nbsp;FOLIO&nbsp;</th>
					<th class="auto-style6">&nbsp;ENVIAR&nbsp;</th>
				';
	
		    for($i=0; $i<count($resultado); $i++) {
				for($j=0; $j<count($resultado[$i]); $j++) {
				    $expediente_pac = $resultado[$i][$j]['NO_EXP_PAC'];
				   	$date = $resultado[$i][$j]['FEC_ING_PAC'];
				    $fecha_ing_pac = $date->format('d-m-Y');
				    $folio_pac = $resultado[$i][$j]['FOLIO_PAC'];
				    
				    echo '<form method="post" action="tabs.php"><tr>
							<td class="auto-style5">'.$fecha_ing_pac.' </td>
							<td class="auto-style5">'.$expediente.' </td>
							<td class="auto-style5">'.$folio_pac.' </td>
							<td> <input class="btn-success" type="submit" name="enviar" style="height: 62px; width: 100px" /></span></td>
							<input type="hidden" name="rol" value="'.$rol.'" />
							<input type="hidden" name="permisos" value="'.$permisos.'" />
							<input type="hidden" name="expediente" value="'.$expediente_pac.'" />
							<input type="hidden" name="folio" value="'.$folio_pac.'" />
						</form>
					</tr>';
				}
			}
			echo '</table></center><br/>';
		}
	}

	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   // Nos envía a la siguiente dirección en el caso de no poseer autorización 
	   header("location: index.html");
	}
	
	$valor = $_SESSION[$rol];
	#Para generar un archivo excel con todos los datos guardados hasta ahora 
	$excel = "MES\tNUMERO\tEXPEDIENTE\tF. INGRESO\tF. EGRESO\tESPECIALIDAD\tNO. MX PRESCRITOS\tANTIBIOTICOS\tANALGÉSICOS\tANTIÁCIDO\tANTIEMÉTICO\tANESTÉSICO\tANTIESPASMÓDICO\tOTRO\n";
	#Consulta para sacar los valores de MYSQL NOTA: Considerar colocar rango de fechas
	$queryExcel= "SELECT p.numeroExpediente, fechaIngreso, fechaEgreso, especialidad, Count(m.tipoMedicamento) AS med,
				SUM( CASE WHEN m.tipoMedicamento = '1' THEN 1 ELSE 0 END ) as antib, SUM( CASE WHEN m.tipoMedicamento = '2' THEN 1 ELSE 0 END ) as analg,
				SUM( CASE WHEN m.tipoMedicamento = '3' THEN 1 ELSE 0 END ) as antiAcid, SUM( CASE WHEN m.tipoMedicamento = '4' THEN 1 ELSE 0 END ) as antiEme, 
				SUM( CASE WHEN m.tipoMedicamento = '5' THEN 1 ELSE 0 END ) as anest, SUM( CASE WHEN m.tipoMedicamento = '6' THEN 1 ELSE 0 END ) as antiEspa,
				SUM( CASE WHEN m.tipoMedicamento = '7' THEN 1 ELSE 0 END ) as otro
				FROM paciente AS p 
				LEFT JOIN medpacientes as m ON p.numeroExpediente=m.numeroExpediente
				GROUP BY p.numeroExpediente";
	$result0 = mysqli_query($conexion, $queryExcel) or die (mysqli_error($conexion));
	$c = 1;
	while($row = mysqli_fetch_array($result0)){
		$excel.= date('F')."\t".$c++."\t".$row[0]."\t".$row[1]."\t";
		$excel.= $row[2]."\t".$row[3]."\t".$row[4]."\t".$row[5]."\t".$row[6]."\t".$row[7]."\t";
		$excel.= $row[8]."\t".$row[9]."\t".$row[10]."\t".$row[11]."\n";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Vista Epidemiologia</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<style type="text/css">
	.auto-style1 {
		text-align: center;
	}
	.auto-style3 {
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
		font-size:x-large;
	}
	.auto-style5 {
		text-align: center;
		font-size: medium;
		letter-spacing: normal;
		color: #010736;
		font-family: Arial, Helvetica, sans-serif;
	}
	.auto-style6 {
		color: #000000;
		text-align: center;
	}
	.auto-style7 {
		text-align: center;
		font-size: medium;
		letter-spacing: normal;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.auto-style8 {
		text-align: center;
		font-size: medium;
		letter-spacing: normal;
		color: black;
		font-family: Arial, Helvetica, sans-serif;
	}
	.styleBD {
		background-image: url('../img/logoNew2Agua.jpg');
	}
	.botoncontacto 
	{
		background-image: url('../img/lupa2.png');  
		border-width: 2
	}
	.auto-style9 {
		font-size: medium;
		color: #C4E3F3;
	}
	#search {

	}

	#search input[type="number"] {
		background: url(../css/images/icons-png/search-white.png) no-repeat 10px 6px #444;
		border: 0 none;
		font: bold 12px Arial,Helvetica,Sans-serif;
		color: #d7d7d7;
		width:150px;
		padding: 6px 15px 6px 35px;
		-webkit-border-radius: 20px;
		-moz-border-radius: 20px;
		border-radius: 20px;
		text-shadow: 0 2px 2px rgba(0, 0, 0, 0.3); 
		-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 3px rgba(0, 0, 0, 0.2) inset;
		-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 3px rgba(0, 0, 0, 0.2) inset;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 3px rgba(0, 0, 0, 0.2) inset;
		-webkit-transition: all 0.7s ease 0s;
		-moz-transition: all 0.7s ease 0s;
		-o-transition: all 0.7s ease 0s;
		transition: all 0.7s ease 0s;
		}

	#search input[type="number"]:focus {
		background: url(../css/images/icons-png/search-black.png) no-repeat 10px 6px #fcfcfc;
		color: #6a6f75;
		width: 200px;
		-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(0, 0, 0, 0.9) inset;
		-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(0, 0, 0, 0.9) inset;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(0, 0, 0, 0.9) inset;
		text-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
		}
</style>
<script type="text/javascript" src="../js/funciones.js"></script>

</head>

<body class="styleBD" onload="reportes(<?php echo $permisos ?>);" >
	<p class="auto-style1"><img alt="logoHD" height="200" src="../img/logoNew.jpg" width="600"/></p>
	<p class="auto-style7" ><strong>BIENVENIDO(A) AL APARTADO DE EPIDEMIOLOGÍA <br/>
	</strong>
	<span> <strong>FAVOR DE COLOCAR UN NÚMERO DE EXPEDIENTE </strong> </span></p>
	<br class="auto-style6"/>
<!--------------------------------------------------------Primera Opcion BUSCAR POR NUM DE EXPEDIENTE---------------------------------------------------->
	<form method="post" id="search" autocomplete="off">
		<div class="auto-style1">
			<span class="auto-style3" align="center"> Expediente Paciente:</span>
		<br/>
		</div>
		<p class="auto-style8">
			<input type="number" name="expediente" placeholder="Num. Expediente" onblur="rellenar(this,this.value)" style="width: 224px; height: 70px" required/>
			<span class="auto-style3" align="center">
				<input class="botoncontacto" type="submit" name="enviar" style="font: xx-small serif; height: 95px; width: 78px" />
			</span>
		</p>
		<input type="hidden" name="rol" value="<?php echo $rol ?>" />
		<input type="hidden" name="permisos" value="<?php echo $permisos ?>" />
	</form>
	<br/>
<!--------------------------------------------------------------- Segunda Opcion Higiene de manos ------------------------------------------------------->
	<br/>
	<hr/>
	<br/>
	<div class="text-center">
		<input type="button" value="CONSULTAR DATOS HISTÓRICOS" class="btn btn-primary" name="lvc" style="height: 50px; width: 450px" onClick="window.open('tabsHist.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>', '_blank').focus()" />
	</div>
	<br/>
	<hr/>
	<br/>
	<div class="text-center">
		<input type="button" value="VERIFICACIÓN DE TÉCNICA DE HIGIENE DE MANOS" class="btn btn-primary" name="lvc" style="height: 50px; width: 450px" onClick="window.open('tecnicaManos.php?rol=<?php echo $rol ?>', '_blank').focus()" />
		<br>
		<br>
		<!--form action="revTecnicaManos.php" method = "post" target="_blank">
			<br/>
			<strong><span class="auto-style7">REVISIONES DE TÉCNICA DE HIGIENE DE MANOS</span> 
			<br>
			<br>
			<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fechaIni" style="height: 40px" required	/>
			<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
			<input type="date" name="fechaFin" style="height: 40px" required 	/></strong>
			<br/>
			<br/> 
			<input id="entreFechas" name="entreFechas" class="btn-success" type="submit" value="ENVIAR" style="height: 50px; width: 303px" />
			<br/>
		</form-->
		<hr/>
		<form action="excel.php" method = "post">
			<br/>
			<strong><span class="auto-style7">ANTIBIÓTICOS Y DOSIS
			<br/></span> <br/>
			<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required />
			<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
			<input type="date" name="fecha2" style="height: 40px" required 	/></strong>
			<br/>
			<br/>
			<input type="hidden" name="nombre" value="MedicamentosDosis" />  
			<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
			<br/>
		</form>
		<br/>
		<hr/>
		<form action="excel.php" method = "post">
			<br/>
			<strong><span class="auto-style7">REVISIONES DE TÉCNICA DE HIGIENE DE MANOS EXCEL 
			<br/></span> <br/>
			<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required />
			<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
			<input type="date" name="fecha2" style="height: 40px" required 	/></strong>
			<br/>
			<br/>
			<input type="hidden" name="nombre" value="RevisionTecnicaHigieneManos" />  
			<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
			<br/>
		</form>
		<br/>
		<hr/>
	<p class="auto-style5">
		<br/>
		<input type="button" value="VERIFICACIÓN DE CONSUMIBLES HIGIENE DE MANOS" class="btn btn-primary" name="lvc" style="height: 50px; width: 450px" onClick="window.open('higieneManos.php?rol=<?php echo $rol ?>', '_blank').focus()" />
		<br/>
		<br/>
		<form action="excel.php" method = "post">
			<br/>
			<strong><span class="auto-style7">REVISIONES DE CONSUMIBLES PARA HIGIENE DE MANOS EXCEL 
			<br/></span> <br/>
			<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required />
			<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
			<input type="date" name="fecha2" style="height: 40px" required /></strong>
			<br/>
			<br/>
			<input type="hidden" name="nombre" value="RevisionConsumiblesaHigieneManos" />  
			<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
			<br/>
		</form>
		<br>
		<a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 60px" > REGRESAR </a>
	</div>
	</p>
	<?php 
		if( $valor == 'administrador'){
			echo '<p class="auto-style5" > <input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 137px; height: 44px" /></p>';
		}else{
			echo '<p class="auto-style5" > <input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" /></p>';
		}
	?>
</body>

</html>
