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
		    echo '<br/><p class="auto-style7"> <strong> seleccione una fila:</strong>
		    		<br/><center><table style="width: 30%"  border="3px solid black;">
					<th class="auto-style6">&nbsp;FECHA INGRESO&nbsp;</th>
					<th class="auto-style6">&nbsp;EXPEDIENTE&nbsp;</th>
					<th class="auto-style6">&nbsp;FOLIO&nbsp;</th>
					<th class="auto-style6">&nbsp;OPCIONES&nbsp;</th>
				';
			
			//Ocupamos permiso para ver todo lo del medico o solo lo de Triage
			$vista = NULL;
			//if($permisos == '0'){
				$vista = 'tabsAdverso.php';
			/*}else{
				$vista = 'tabsTriage.php';
			}*/
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
							<td> <input class="btn-success" type="submit" name="enviar" value="SELECCIONAR" style="height: 52px; width: 140px" /></span></td>
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>VISTA EVENTOS ADVERSOS</title>
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

</head>

<body class="styleBD" >
	<p class="auto-style1"><img alt="logoHD" height="200" src="../img/logoNew.jpg" width="670"/></p>
	<p class="auto-style7" ><strong>BIENVENIDO(A) A NOTIFICACIÓN DE EVENTOS ADVERSOS<br/></strong>
	<br>
	<!--span> <strong>FAVOR DE DE SELECCIONAR UNA DE LAS SIGUIENTES OPCIÓNES</strong> </span></p-->
	<br class="auto-style6"/>
<!----------------------Primera Opcion BUSCAR POR NUM DE EXPEDIENTE---------------------------------------------------------->
	<form method="post" id="search" autocomplete="off">
		<div class="auto-style1">
			<span class="auto-style3" align="center">FAVOR DE COLOCAR UN NÚMERO DE EXPEDIENTE:</span>
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
	</form>
	<hr style="height:10px; background-color: darkcyan">
	<div class="auto-style1" >
		<span class="auto-style3" align="center"> NO SE TIENE UN NÚMERO DE EXPEDIENTE:</span>
	<br/>
	<br/>
		<p class="auto-style5" > <input class="btn btn-primary" type="button" value="EVENTO ADVERSO" onClick=location.href="tabsAdversoNE.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" style="width: 147px; height: 44px" /></p>
	<br/>
	<hr style="height:10px; background-color: darkcyan">
	<div class="auto-style1" >
		<span class="auto-style3" align="center"> HISTÓRICO DE EVENTOS ADVERSOS:</span>
	<br/>
	<br/>
		<p class="auto-style5" > <input class="btn btn-primary" type="button" value="HISTÓRICO" onClick=window.open('consultaTodos.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>','_black') style="width: 147px; height: 44px" /></p>
	<br/>
	<br/>
		<form action="excel.php" method = "post">
			<br/>
			<strong><span class="auto-style7">EXCEL HISTÓRICO DE EVENTOS ADVERSOS
			<br/></span> <br/>
			<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required />
			<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
			<input type="date" name="fecha2" style="height: 40px" required /></strong>
			<br/>
			<br/>
			<input type="hidden" name="nombre" value="HistoricoEventosAdversos" />  
			<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
			<br/>
		</form>
		<br/>
	<br/>
	<?php
		if( $rol == 'ureza'){
			echo '<hr/>
			<p class="auto-style5">
			<span><strong> OTROS SISTEMAS</strong></span>
			<br/>
			Nota: Si ingresa otro sistema se saldrá de la pantalla actual
			</p>';
			echo '<a class="btn btn-primary" href="../vistaAtencionClnt.php?rol='.$rol.'&permisos='.$permisos.'" style="height: 50px; width: 210px; font-size: large;">INCIDENCIAS</a><br/>';
		}
	
		if( $valor == 'administrador'){
			echo '<p class="auto-style5" > <input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 137px; height: 44px" /></p>';
		}else{
			echo '<br/><p class="auto-style5" > <input class="btn btn-danger" type="button" value="SALIR" onClick=location.href="../terminarSesion.php?rol='.$rol.'" style="width: 137px; height: 44px" /></p>';
		}
	?>
</body>

</html>
