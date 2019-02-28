<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Buscar Resguardos</title>
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
	<script type="text/javascript" src="js/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#simple').dataTable({
				"language": {
	    	        "lengthMenu": "Mostrar _MENU_ Filas",
	    	        "zeroRecords": "Sin Resultados - Intente otra frase",
	    	        "info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE REGISTROS _MAX_",
	    	        "infoEmpty": "Sin Registros",
	    	        "infoFiltered": "(Total _TOTAL_ filas)",
	    	        "sSearch":"Buscar",
	    	        "paginate": {
	    			  	"next": "Siguiente",
	    			 	"sPrevious":"Anterior"
	    			}
	    	    }
	    	});
		});
	</script>
	<script type="text/jscript" src="js/bootstrap.min.js" >	</script>
	<link rel="stylesheet" href="css/tabAz.css" />
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<style type="text/css">
		.auto-style1 {
			text-align: center;
		}
		.auto-style6 {
			text-align: center;
			font-size: medium;
			letter-spacing: normal;
			color: #0000FF;
			font-family: Arial, Helvetica, sans-serif;
		}
		.styleBD {
			background-image: url('img/logoNew2Agua.jpg');
		}
	.auto-style7 {
		font-size: large;
	}
	</style>

	<script type="text/javascript">
		function confirmSubmit()
			{
				var agree=confirm("¿Está seguro de eliminar este registro? !!!EL PROCESO ES IRREVERSIBLE!!!");
				if (agree){
				 	return true;
				}else{
				 	return false;
				}
			}
		
		$(document).ready(function() {
				$("#div_User").hide();
		});
		
		function modifRes(idMat, idRes, roles){
			idMaterial=idMat;
			idResguardo=idRes;
			rol=roles;
			
			$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarResguardo.php",{idMaterial:idMaterial,idResguardo:idResguardo,rol:rol} ,function(){
				  $("#cargando").css("display", "none");
				});
		}
	</script>
	
</head>
<body class="styleBD">

<?php
	#Archivo con la conexion para MYSQL
  	require_once('conexion/configRepo.php');

	$rol=NULL;
	$fechaResguardoForm = NULL;
	$areaForm = NULL;
	$entregaForm = NULL;
	$recibeForm = NULL;
	$cargoForm = NULL;
	$observacionesForm = NULL;

 	if (isset($_GET['rol'])){
		$rol=$_GET['rol'];
	}
	
	if (isset($_POST['rol'])){
		$rol=$_POST['rol'];
	}

	if(isset($_REQUEST['buscar']) || isset($_GET['idMaterial'])) {
		$condiciones = NULL;
		$fechas = false;
		$areas = false;
		$entrego1=false;
		$recibio1=false;
		$material1=false;

		/*if(isset($_POST['rol'])){
			$rol = $_POST['rol'];
		}*/

		if(isset($_POST['fecha1']) && $_POST['fecha1'] != '' && $_POST['fecha1'] != NULL && isset($_POST['fecha2']) && $_POST['fecha2'] != '' && $_POST['fecha2'] != NULL ){
			$fecha1 = $_POST['fecha1'];
			$fecha2 = $_POST['fecha2'];
			$fechas=true;
			$condiciones = "fechaResguardo BETWEEN '$fecha1' AND '$fecha2'";
		}
		if(isset($_POST['area']) && $_POST['area']!= NULL && $_POST['area'] != ''){
			$area= $_POST['area'];
			$areas=true;
			if($fechas){
				$condiciones = $condiciones." AND area LIKE '%$area%'";
			} else {
				$condiciones = "area LIKE '%$area%'";
			}
		}
		if(isset($_POST['entrego'])&& $_POST['entrego']!= NULL && $_POST['entrego'] != ''){
			$entrego= $_POST['entrego'];
			$entrego1=true;
			if ($fechas || $areas){
				$condiciones = $condiciones." AND entrega LIKE '%$entrego%'";
			} else {
				$condiciones = "entrega LIKE '%$entrego%'";
			}
		}

		if(isset($_POST['recibio'])&& $_POST['recibio']!= NULL && $_POST['recibio'] != ''){
			$recibio = $_POST['recibio'];
			$recibio1=true;
			if ($fechas || $areas || $entrego1){
				$condiciones = $condiciones." AND recibe LIKE '%$recibio%'";
			} else {
				$condiciones = "recibe LIKE '%$recibio%'";
			}
		}
		
		if(isset($_POST['material'])&& $_POST['material']!= NULL && $_POST['material'] != ''){
			$material = $_POST['material'];
			$material1=true;
			if ($fechas || $areas || $entrego1 || $recibio1){
				$condiciones = $condiciones." AND tipoActivo LIKE '%$material%'";
			} else {
				$condiciones = "tipoActivo LIKE '%$material%'";
			}
		}
		
		if (!$fechas && !$areas && !$entrego1 && !$recibio1 && !$material1){
			$condiciones = "r.idResguardo > 0";
		}
		
		#Para eliminar un material
		if(isset($_GET['idMaterial'])){
			$idMaterial = $_GET['idMaterial'];
			$idResguardo = $_GET['idResguardo'];
			$condiciones = $_GET['condiciones'];
			$condiciones = base64_decode($condiciones);
			
			$queryDelMaterial = "UPDATE materiaresguardo SET estatus=0 WHERE idMaterial = $idMaterial";
				$result1 = mysqli_query($conexion, $queryDelMaterial);
					
				if(!$result1){
					echo'! ERROR AL REALIZAR BORRADO DE DATOS PARA MATERIAL!';
					echo '<br/>Query Add: '.$queryDelMaterial;
					exit;
				} else {
					echo '<br/><strong>!!!! SE ELIMINO EL MATERIAL CORRECTAMENTE!!!!</strong><br>';
					//echo '<br/>Query Add: '.$queryDelMaterial ;
					echo '<br><input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />';
					exit;
				}
		}
		
		$queryBuscaResID = "SELECT DISTINCT r.idResguardo, fechaResguardo
							FROM resguardos AS r
							LEFT JOIN materiaresguardo as m ON r.idResguardo=m.idResguardo
							WHERE $condiciones AND m.estatus=1
							ORDER BY fechaResguardo";
		//echo '<br/>Query: '.$queryBuscaResID ;
		$result0 = mysqli_query($conexion, $queryBuscaResID) or die (mysqli_error($conexion));

		/*$queryBuscaRes = "SELECT r.idResguardo, fechaResguardo, area, entrega, recibe, cargo, observaciones, m.tipoActivo, m.descActivo, m.marca, m.modelo, m.numSerie
						FROM resguardos AS r
						LEFT JOIN materiaresguardo as m ON r.idResguardo=m.idResguardo
						WHERE $condiciones
						ORDER BY fechaResguardo";
		$result1 = mysqli_query($conexion, $queryBuscaRes) or die (mysqli_error($conexion));*/
		
		echo '<div>
		<div class="div_User" id="div_User"></div>
		<h1>&nbsp;&nbsp;RESGUARDOS CON LOS CRITERIOS DE BÚSQUEDA</h1>
			<hr>
			<div class="datagrid">
			<table id="simple">
			<thead>
				<tr>
					<!--&nbsp;&nbsp;<table style="width: 80%; text-align: center;"  border="5px solid black;"-->
					<th>&nbsp;No.&nbsp;</th>
					<th>&nbsp;FECHA RESGUARDO&nbsp;</th>
					<th>&nbsp;MATERIAL/EQUIPO&nbsp;</th>
					<th>&nbsp;MARCA&nbsp;</th>
					<th>&nbsp;MODELO&nbsp;</th>
					<th>&nbsp;No. SERIE&nbsp;</th>
					<th>&nbsp;DESCRIPCIÓN&nbsp;</th>
					<th>&nbsp;ÁREA&nbsp;</th>
					<th>&nbsp;ENTREGÓ&nbsp;</th>
					<th>&nbsp;RECIBIÓ&nbsp;</th>
					<th>&nbsp;CARGO&nbsp;</th>
					<th>&nbsp;OBSERVACIONES&nbsp;</th>
					<th>&nbsp;PDF&nbsp;</th>
					<th>&nbsp;ELIMINAR&nbsp;</th>
				</tr>
     		</thead>
      		<tbody>';
		$c = 0;
		while ($row0 = mysqli_fetch_array($result0)){
			$c++;
			$fechaResguardo0 = date_create_from_format('Y-m-d',$row0['fechaResguardo'])->format('d-m-Y');

			echo " <tr class='alt'> 
					<td> $c </td>
					<td> $fechaResguardo0 </td>
					<td> $row0[0]</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
					  <a class='btn btn-primary' target='_blank' name='generapdf' style='height: 50px; width: 140px' href='pdf/creaPDF1.php?idResguardo=$row0[0]' />GENERAR PDF </a>
					</td>
					<td> 
					<a class='btn btn-success' target='_blank' name='addMaterial' style='height: 50px; width: 140px' href='pdf/creaPDF1.php?idResguar=$row0[0]' />Agregar Material </a>
					</td>
					</tr>
				";
				$queryBuscaRes = "SELECT r.idResguardo, idMaterial,fechaResguardo, area, entrega, recibe, cargo, observaciones, m.tipoActivo, m.descActivo, m.marca, m.modelo, m.numSerie
						FROM resguardos AS r
						LEFT JOIN materiaresguardo as m ON r.idResguardo=m.idResguardo
						WHERE $condiciones AND r.idResguardo = '$row0[0]' AND estatus=1
						ORDER BY fechaResguardo";
			$result1 = mysqli_query($conexion, $queryBuscaRes) or die (mysqli_error($conexion));
			$d = 0;
			while($row = mysqli_fetch_array($result1)){
				$d++;
				#$fechaResguardoForm = date_create_from_format('Y-m-d',$row['fechaResguardo'])->format('d-m-Y');
				$tipoActivo = utf8_encode($row['tipoActivo']);
				$marca = utf8_encode($row['marca']);
				$modelo = utf8_encode($row['modelo']);
				$numSerie = $row['numSerie'];
				$descActivo = utf8_encode($row['descActivo']);
				$areaForm = utf8_encode($row['area']);
				$entregaForm = utf8_encode($row['entrega']);
				$recibeForm = utf8_encode($row['recibe']);
				$cargoForm = utf8_encode($row['cargo']);
				$observacionesForm = utf8_encode($row['observaciones']);
				$idResguardo = $row['idResguardo'];
				$cond64 = base64_encode($condiciones);
			echo "<tr>
					<td>$c</td>
					<td></td>
					<td>$tipoActivo</td>
					<td>$marca</td>
					<td>$modelo</td>
					<td>$numSerie</td>
					<td>$descActivo</td>
					<td>$areaForm </td>
					<td>$entregaForm </td>
					<td>$recibeForm </td>
					<td>$cargoForm </td>
					<td>$observacionesForm </td>
					<input name='idResguardo' type='hidden' value='$idResguardo' />
					<td>
						<input type='button' class='btn btn-warning' id='btModif' onclick='modifRes($row[1],$idResguardo,\"$rol\")' value='MODIFICAR' /> 
					</td>
					<td>
					 	<a class='btn btn-danger' onclick='return confirmSubmit()' href='buscarResguardo.php?idMaterial=$row[1]&idResguardo=$idResguardo&condiciones=$cond64&rol=$rol' />ELIMINAR </a>
					 </td>
				</tr>";
			}
		}
		echo'
		 </tbody>
		</table>
		</div>
		</div>
		<br>
		<br>
		&nbsp;&nbsp;<input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
		</body>
		</html>';
		exit();
	}

	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   #echo "Variable de session VACIA!!!!!";
	   header("location: index.html");
	}
?>


	<div>
		<br/>
		<p class="auto-style1"><img alt="logo" height="150" src="img/logoNew.jpg" width="500"/></p>
		<p class="auto-style6">&nbsp;</p>
		<p class="auto-style6"><span><strong>BUSQUEDA DE RESGUARDOS</strong></span></p>
		<br/>
		<form method="post" action="buscarResguardo.php" target="_blank">
			<div class="text-center">
				<span class="auto-style7">Puede colocar todos los filtros necesarios para hacer la busqueda más específica<br />
				Si se dejan en blanco TODOS los campos se mostrarán todos los resguardos<br />
				<strong><br />
					Rango de Fechas de Resguardo:
				</strong>
				</span>
				<strong>
					<br/><br/>
					<span class="auto-style7">DEL&nbsp; </span>
					&nbsp;<input type="date" name="fecha1" style="height: 40px" />
					<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
					<input type="date" name="fecha2" style="height: 40px" />
				</strong>
				<br/><br/>
				<strong><span class="auto-style7">*Los siguientes campos son por frase de busqueda </span></strong>
				<br/><br/>
				<strong><span class="auto-style7">Área contiene: </span></strong>
				<br/>
				<input type="text" name="area" style="height: 40px; width: 223px" />
				<br/><br/>
				<strong><span class="auto-style7">Persona que Entregó: </span></strong>
				<br/>
				<input type="text" name="entrego" style="height: 40px; width: 223px" />
				<br/><br/>
				<strong><span class="auto-style7">Persona que Recibió: </span></strong>
				<br/>
				<input type="text" name="recibio" style="height: 40px; width: 223px" />
				<br/><br/>
				<strong><span class="auto-style7">Material/Activo/Equipo: </span></strong>
				<br/>
				<input type="text" name="material" style="height: 40px; width: 223px" />

				<input type="hidden" name="rol" value="<?php echo $rol ?>" />
				<br/><br/><br/>
				<input class="btn btn-success" name="buscar" type="submit" value="BUSCAR" style="width: 140px; height: 60px" />
			</div>
		</form>
		<br/>
		<center>
			<input class="btn btn-danger" onclick="window.close();"  value="CERRAR" style="width: 140px; height: 60px" />
		</center>
	</div>
	
	<!--script type="text/javascript">
		/*function modifRes(idMat, idRes){
			idMaterial=idMat;
			idResguardo=idRes;
			
			$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("buscarResguardo.php",{idMaterial:idMaterial,idResguardo:idResguardo} ,function(){
				  $("#cargando").css("display", "none");
				});
		}*/
		
		//Evaluamos los clic en los registros
			/*$(document).ready(function() {
			  //$('#tblUser tbody tr').live('click', function () {
			  $('#simple').on('click', '#btModif', function () {
					//var sTitle;
				var nTds = $('td', this);
				idEvAdverso = $(nTds[1]).text();
				
				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarResguardo.php",{idEvAdverso:idEvAdverso,fecha:fecha,reporta:reporta,servicio:servicio,evento:evento,fechaB:fechaB,turno:turno,diag:diag,tipoEvento:tipoEvento,relacionado:relacionado,alcanzoPac:alcanzoPac,danioPac:danioPac,como:como,porQue:porQue,medicamento:medicamento,generico:generico,presentacion:presentacion,dosis:dosis,viaAdmin:viaAdmin,intervalo:intervalo,aim:aim,cidt:cidt,ciam:ciam,dim:dim,eii:eii,fimar:fimar,mcmc:mcmc,licim:licim,fma:fma,manp:manp,fdvpam:fdvpam,frmec:frmec,ficp:ficp,ampi:ampi,amnp:amnp,omisionMed:omisionMed,ami:ami,presInc:presInc,transInc:transInc,prepInc:prepInc,dispoInc:dispoInc,tai:tai,vai:vai,adpi:adpi,dti:dti,hai:hai,ifi:ifi,vii:vii,ot:ot,otros} ,function(){
				  $("#cargando").css("display", "none");
				});
			  });
			 });*/
	</script-->
	
	<style type="text/css">
		  .div_User{
			position: absolute;
			top: 15%;
			left: 25%;
			width: 30%;
			height: 60%;
			padding: 16px;
			background: linear-gradient(to left, white, rgba(68, 127, 191, 0.9));
			border: double;
			color: #333;
			z-index:1002;
			overflow: auto;
		  }
    </style>
</body>

</html>
