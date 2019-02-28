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
		$hospital=NULL;

		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		
		if (isset($_POST['permisos']))
		{
			$permisos=$_POST['permisos'];
		}
		
		if (isset($_POST['hospital']))
		{
			$hospital=$_POST['hospital'];
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
			
			//Ocupamos permiso para ver todo lo del medico o solo lo de Triage
			$vista = NULL;
			if($permisos == '3' && $hospital != '1'){
				$vista = 'tabs.php';
			}else if($hospital == '1') {
				$vista = '../medicoHospital/tabs.php';
			} else {
				$vista = 'tabsTriage.php';
			}
		    for($i=0; $i<count($resultado); $i++) {
				for($j=0; $j<count($resultado[$i]); $j++) {
				    $expediente_pac = $resultado[$i][$j]['NO_EXP_PAC'];
				   	$date = $resultado[$i][$j]['FEC_ING_PAC'];
				    $fecha_ing_pac = $date->format('d-m-Y');
				    $folio_pac = $resultado[$i][$j]['FOLIO_PAC'];
				    
				    echo '<form method="post" action="'.$vista.'"><tr>
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
	
	#Esta parte se manda a llamar de aqui mismo
	if(isset($_REQUEST['enviarNombre']))
	{
		$folio = NULL;
		$cadcero=NULL;
		$nombrePaciente=NULL;

		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		
		if (isset($_POST['permisos']))
		{
			$permisos=$_POST['permisos'];
		}
		
		if (isset($_POST['nombre']))
		{
			$nombre=$_POST['nombre'];
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>VISTA MEDICO</title>
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
	<p class="auto-style1"><img alt="logoHD" height="200" src="../img/logoNew.jpg" width="670"/></p>
	<?php if( $permisos == '3'){ ?>
		<p class="auto-style7" ><strong>BIENVENIDO(A) AL APARTADO MÉDICO<br/></strong>
	<?php } else { ?>
			<p class="auto-style7" ><strong>BIENVENIDO(A) AL APARTADO DE TRIAGE<br/></strong>
	<?php } ?>
	
	<br>
	<span> <strong>FAVOR DE DE SELECCIONAR UNA DE LAS SIGUIENTES OPCIÓNES</strong> </span></p>
	<br class="auto-style6"/>
<!----------------------Primera Opcion BUSCAR POR NUM DE EXPEDIENTE---------------------------------------------------------->
	<form method="post" id="search" autocomplete="off">
		<div class="auto-style1">
			<h3>CONSULTA MÉDICA</h3>
			<span class="auto-style3" align="center"> NÚMERO DE EXPEDIENTE DEL PACIENTE:</span>
		<br/>
		</div>
		<p class="auto-style8">
			<input type="number" name="expediente" placeholder="Num. Expediente" onblur="rellenar(this,this.value)" style="width: 224px; height: 70px" />
			<span class="auto-style3" align="center">
			<input class="botoncontacto" type="submit" name="enviar" style="font: xx-small serif; height: 95px; width: 78px" />
			</span>
		</p>
		<br/>
		<!--div class="auto-style1">
			<span class="auto-style3" align="center"> NOMBRE DEL PACIENTE:</span>
		<br/>
		</div>
		<p class="auto-style8">
			<input type="text" name="nombre" placeholder="Nombre Paciente" style="width: 330px; height: 70px" />
			<span class="auto-style3" align="center">
			<input class="botoncontacto" type="submit" name="enviarNombre" style="font: xx-small serif; height: 95px; width: 78px" />
			</span>
		</p-->
		
		<input type="hidden" name="rol" value="<?php echo $rol ?>" />
		<input type="hidden" name="permisos" value="<?php echo $permisos ?>" />
	</form>
	
	<hr style="height:10px; background-color: darkcyan">
	<?php if( $permisos == '3'){ ?>
		<form method="post" id="search" autocomplete="off">
			<div class="auto-style1">
				<h3>FORMATOS DE HOSPITAL</h3>
				<span class="auto-style3" align="center"> NÚMERO DE EXPEDIENTE DEL PACIENTE:</span>
			<br/>
			</div>
			<p class="auto-style8">
				<input type="number" name="expediente" placeholder="Num. Expediente" onblur="rellenar(this,this.value)" style="width: 224px; height: 70px" />
				<span class="auto-style3" align="center">
				<input class="botoncontacto" type="submit" name="enviar" style="font: xx-small serif; height: 95px; width: 78px" />
				</span>
			</p>
			<br/>
			<input type="hidden" name="rol" value="<?php echo $rol ?>" />
			<input type="hidden" name="permisos" value="<?php echo $permisos ?>" />
			<input type="hidden" name="hospital" value="1" />
		</form>
	<?php } ?>
	<?php if( $permisos == '3'){ ?>
	<hr style="height:10px; background-color: darkcyan" >
	<div class="auto-style1" >
		<span class="auto-style3" align="center"> FORMULARIOS DE URGENCIAS:</span>
	<br/>
	<br/>
		<p class="auto-style5" > <input class="btn btn-primary" type="button" value="URGENCIAS" onClick=location.href="tabsUrg.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" style="width: 137px; height: 44px" /></p>
	<br/>
	<br/>
	<?php } else { ?>
		<hr>
		<div class="text-center">
		<!--form action="excel.php" method = "post">
			<br/>
			<strong><span class="auto-style7">REPORTE DE TRIAGE POR DÍA<br/></span> <br/>
			<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required	/>			
			<br/>
			<br/>
			<input type="hidden" name="nombre" value="ReporteTriage" />
			<input id="btPerfilFT" class="btn-success" type="submit" value = "Generar EXCEL" style="height: 50px; width: 303px" />
			<br/>			
		</form-->
			<hr>
			<br>
			<strong><span class="auto-style7">REPORTE DE TRIAGE POR DÍA<br/></span> <br/>
		<form action="../pdf/creaPDFTriage.php" method = "post" target="_blank">
			<br/>
			<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required />
			<br/>
			<br/>
			<input type="hidden" name="name" value="triage" />
			<br/>
			<input type="submit" value="Generar PDF" class="btn btn-danger" name="lvc" style="height: 50px; width: 300px" />
		</form>
			<!--input type="button" value="Generar PDF" class="btn btn-danger" name="lvc" style="height: 50px; width: 300px" 
									   onClick="window.open('../pdf/creaPDF.php?name=triage', '_blank').focus()"/-->
		</div>
		<br/>
		<br/>
	<?php } ?>
	<!--p class="auto-style5" > <a class="btn btn-success" href="javascript:window.history.go(-1);" style="width: 140px; height: 60px" > REGRESAR </a></p-->
	<?php 
		if( $valor == 'administrador'){
			echo '<p class="auto-style5" > <input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 137px; height: 44px" /></p>';
		}else{
			echo '<p class="auto-style5" > <input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" /></p>';
		}
	?>
</body>

</html>
