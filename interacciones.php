<!DOCTYPE html> 
<html>
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
  <title>Captura Interacciones</title>
  <!--link rel="stylesheet" href="css/jquery.mobile-1.4.4.min.css" >
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.mobile-1.4.4.min.js">
  </script-->
  <link rel="stylesheet" href="css/Prueba1.min.css" >
  <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" >
  <link rel="stylesheet" href="css/jquery.mobile.structure-1.4.5.min.css" >
  <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
  <style type="text/css">
	.auto-style1 {
		font-size: large;
		text-align:center;
	}
	.auto-style2 {
	  color: #808080;
	  height: 5px;
	}
	.auto-style3 {
	   text-align: left;
	}
   .auto-style6 {
		border: 3px solid #000000;
	}
	.auto-style7 {
		border-style: solid;
		border-width: 1px;
		text-align:center;
	}
	.auto-style8 {
		border: 1px solid #000000;
	}
	#div1 {
     overflow:scroll;
     height:400px;
     width:100%;
}
</style>
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" -->
</head>

<?php
  	header('Content-Type: text/html;charset=utf-8');
  	require_once('conexion/config.php');

	$farmaco2 = NULL;
	$alimento = NULL;
    $idFarmaco1 = NULL;
    $nameFarmaco1 = NULL;
    $idFarmaco2 = NULL;
    $nameFarmaco2 = NULL;

	#Comenzamos con PHP para recibir por GET 5 variables desde formualario_farmacia.php
	if(isset ($_GET['expediente'])){
		$expediente = $_GET['expediente'];
	}else {
		$expediente = NULL;
	}
	if(isset ($_GET['folio'])){
		$folio= $_GET['folio'];
	}else {
		$folio= NULL;
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
    if(isset ($_GET['idDint'])){
    echo '<!DOCTYPE html> 
			<html>
			<head>
			  <meta charset="UTF-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
			  <title>Captura Interacciones</title>
			  <!--link rel="stylesheet" href="css/jquery.mobile-1.4.4.min.css" >
			  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
			  <script type="text/javascript" src="js/jquery.mobile-1.4.4.min.js">
			  </script-->
			  <link rel="stylesheet" href="css/Prueba1.min.css" >
			  <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" >
			  <link rel="stylesheet" href="css/jquery.mobile.structure-1.4.5.min.css" >
			  <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
			  <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
			 </head>
			 <body>
			';
        $idDint = $_GET['idDint'];
        #Esta varable es deaqui mismo para borrar una interacción
        $queryDelInteraccion = "DELETE FROM interacciones WHERE idInteraccion = '$idDint'";
        $idDelInteraccion = mysqli_query($conexion, $queryDelInteraccion) or die (mysqli_error($conexion));

        echo '<strong><span class="auto-style2">! SE ELIMINO LA INTERACCIÓN !</span></strong>
			<br><br>&nbsp;&nbsp;<input type="button" style="background-color:red" onclick="window.close()" value="SALIR">
			</body>
			</html>';
        exit();
    }else{
        $idDss = NULL;
    }
	
	#Estamos enviando los valores de aqui mismo y aqui los recibimos O_O!
	if(isset($_REQUEST['enviarInteraccion']))
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
		if(isset ($_POST['nomPac'])){
			$nomPac = $_POST['nomPac'];
		}else{
			$nomPac = NULL;
		}
		if(isset ($_POST['idMedic'])){
			$idMedic = $_POST['idMedic'];
		}else{
			$idMedic = NULL;
		}
		if(isset ($_POST['nMedic'])){
			$nMedic= $_POST['nMedic'];
		}else{
			$nMedic= NULL;
		}
		if(isset ($_POST['farmaco1'])){
			$farmaco1 = $_POST['farmaco1'];
			list($idFarmaco1, $nameFarmaco1) = explode("*", $farmaco1);
		}else{
			$farmaco1= NULL;
		}
		if(isset ($_POST['farmaco2'])){
			if($_POST['farmaco2'] != NULL && $_POST['farmaco2'] != ''){
				$farmaco2 = $_POST['farmaco2'];
				list($idFarmaco2, $nameFarmaco2) = explode("*", $farmaco2);
			}
		}
		if(isset ($_POST['alimento'])){
			if($_POST['alimento'] != NULL && $_POST['alimento'] != ''){
				$alimento = $_POST['alimento'];
			}
		}
		if(isset ($_POST['descEfec'])){
			$descEfec= utf8_decode($_POST['descEfec']);
		}else{
			$descEfec= NULL;
		}
		if(isset ($_POST['sevInteraccion'])){
			$sevInteraccion= utf8_decode($_POST['sevInteraccion']);
		}else{
			$sevInteraccion= NULL;
		}
		if(isset ($_POST['descInteracciones'])){
			$descInteracciones = utf8_decode($_POST['descInteracciones']);
		} else {
			$descInteracciones= NULL;
		}
		if(isset ($_POST['recomendacion'])){
			$recomendacion= $_POST['recomendacion'];
		} else {
			$recomendacion= NULL;
		}
		if(isset ($_POST['duplicTerap'])){
			$duplicTerap= $_POST['duplicTerap'];
			if($duplicTerap != '1'){
				$duplicTerap = '0';
			}
		} else {
			$duplicTerap= NULL;
		}
		if(isset ($_POST['lugarInteraccion'])){
			$lugarInteraccion = $_POST['lugarInteraccion'];
		} else {
			$lugarInteraccion = NULL;
		}
		#Este valor solo llega cuando es actualizacion
		if(isset ($_POST['idInt'])){
			$idInt = $_POST['idInt'];
		} else {
			$idInt = NULL;
		}
		
		#No esta vacio idInt entonces es Actualizacion
		if($idInt != NULL && $idInt != ''){
			$queryUpdInt = "UPDATE interacciones SET  fechaGuardado=now()
			 				WHERE idInteraccion = $idInt";
			$result0 = mysqli_query($conexion, $queryUpdInt);
				
			if(!$result0){
				echo'! ERROR AL REALIZAR ACTUALIZACIÓN DE DATOS PARA INTERACCIÓN!';
				echo '<br/>Query UPD: '.$queryUpdInt;
				exit;
			} else {
				echo '<br/><strong>!!!! SE ACTUALIZARON LOS DATOS DE LA INTERACCIÓN CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query UPD: '.$queryUpdInt;
			}
			/*Para Upd del BK*/
			$queryUpdIntBk = "UPDATE interacciones_bk SET  fechaGuardado=now()
			 				WHERE idInteraccion = $idInt";
			$result01 = mysqli_query($conexion, $queryUpdIntBk);
				
			if(!$result01){
				echo'! ERROR AL REALIZAR ACTUALIZACIÓN DE DATOS PARA INTERACCIÓN BK!';
				echo '<br/>Query UPD: '.$queryUpdIntBk;
				exit;
			} else {
				echo '<br/><strong>!!!! SE ACTUALIZARON LOS DATOS DE LA INTERACCIÓN BK CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query UPD: '.$queryUpdInt;
			}
		} else { #Esta vacio idInt entonces es Inserción
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>Formulario Farmacia</title>
				<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
				<script src="js/jquery-3.2.1.min.js"></script>
				<script src="js/jquery.mobile-1.4.5.min.js"></script>
				</head>
				<body>';
			$queryAddInt = "INSERT INTO interacciones(idInteraccion,farmaco,nombreFarmaco,farmaco2,nombreFarmaco2,alimento,descEfecto,
								severidad,descripcion,numeroExpediente,folio,fechaGuardado,recomendacion, lugarInteraccion, duplicidadTerapeutica)
							VALUES (NULL, '$idFarmaco1','$nameFarmaco1','$idFarmaco2','$nameFarmaco2','$alimento', '$descEfec',
								'$sevInteraccion', '$descInteracciones', '$expediente', '$folio', now(), '$recomendacion', '$lugarInteraccion', '$duplicTerap')";
			$result0 = mysqli_query($conexion, $queryAddInt);
				
			if(!$result0){
				echo '<strong>! ERROR AL REALIZAR INSERCIÓN DE DATOS PARA INTERACCIÓN! </strong>';
				echo '<br/>Query Add: '.$queryAddInt;
				#exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LA INTERACCIÓN CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query Add: '.$queryAddInt;
			}
			/*BK de la tabla Interacciones*/
			$queryAddIntBk = "INSERT INTO interacciones_bk(idInteraccion,farmaco,nombreFarmaco,farmaco2,nombreFarmaco2,alimento,descEfecto,
								severidad,descripcion,numeroExpediente,folio,fechaGuardado,recomendacion, lugarInteraccion, duplicidadTerapeutica)
							VALUES (NULL, '$idFarmaco1','$nameFarmaco1','$idFarmaco2','$nameFarmaco2','$alimento', '$descEfec',
								'$sevInteraccion', '$descInteracciones', '$expediente', '$folio', now(), '$recomendacion', '$lugarInteraccion', '$duplicTerap')";
			$result00 = mysqli_query($conexion, $queryAddIntBk);
				
			if(!$result00){
				echo '<strong>! ERROR AL REALIZAR INSERCIÓN DE DATOS PARA INTERACCIÓN BK! </strong>';
				echo '<br/>Query Add: '.$queryAddIntBk;
				#exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LA INTERACCIÓN BK CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query Add: '.$queryAddInt;
			}
		}
		echo '&nbsp;&nbsp;<!--input type="image" src="img/reg.png" value="REGRESAR" onclick="window.close()" height="75" width="161"-->
		<input type="button" style="background-color:red" onclick="window.close()" value="SALIR"> 
		<input type="button" class="btn btn-info" value="Agregar Nueva" onclick ="window.open(\'interacciones.php?expediente='.$expediente.'&folio='.$folio.'&nomPac='.urlencode($nomPac).'\',\'ventana\',\'width=840,height=680,scrollbars=YES,menubar=NO,resizable=NO,titlebar=NO,status=NO\')"/>
		</body></html>
		';
		exit();
	}
	
	if(isset($_REQUEST['enviarNoInteraccion']))
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
		if(isset ($_POST['nomPac'])){
			$nomPac = $_POST['nomPac'];
		}else{
			$nomPac = NULL;
		}
		if(isset ($_POST['idMedic'])){
			$idMedic = $_POST['idMedic'];
		}else{
			$idMedic = NULL;
		}
		if(isset ($_POST['nMedic'])){
			$nMedic= $_POST['nMedic'];
		}else{
			$nMedic= NULL;
		}
		if(isset ($_POST['noInteracc'])){
			$noInteracc= utf8_decode($_POST['noInteracc']);
		}else{
			$noInteracc= NULL;
		}
		
		#Este valor solo llega cuando es actualizacion
		if(isset ($_POST['idInt'])){
			$idInt = $_POST['idInt'];
		} else {
			$idInt = NULL;
		}
		
		#No esta vacio idInt entonces es Actualizacion
		if($idInt != NULL && $idInt != ''){
			$queryUpdInt = "UPDATE interacciones SET  fechaGuardado=now()
			 				WHERE idInteraccion = $idInt";
			$result0 = mysqli_query($conexion, $queryUpdInt);
				
			if(!$result0){
				echo'! ERROR AL REALIZAR ACTUALIZACIÓN DE DATOS PARA INTERACCIÓN!';
				echo '<br/>Query UPD: '.$queryUpdInt;
				exit;
			} else {
				echo '<br/><strong>!!!! SE ACTUALIZARON LOS DATOS DE LA INTERACCIÓN CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query UPD: '.$queryUpdInt;
			}
		} else { #Esta vacio idInt entonces es Inserción
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>Formulario Farmacia</title>
				<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
				<script src="js/jquery-3.2.1.min.js"></script>
				<script src="js/jquery.mobile-1.4.5.min.js"></script>
				</head>
				<body>';
			$queryAddInt = "INSERT INTO interacciones(idInteraccion, farmaco, nombreFarmaco, farmaco2, nombreFarmaco2, alimento, descEfecto,
								severidad, descripcion, numeroExpediente, folio, fechaGuardado, recomendacion, lugarInteraccion, duplicidadTerapeutica)
							VALUES (NULL, NULL, '', NULL, '', NULL, '$noInteracc', NULL, NULL, '$expediente', '$folio', now(), '', NULL, '')";
			$result0 = mysqli_query($conexion, $queryAddInt);
				
			if(!$result0){
				echo '<strong>! ERROR AL REALIZAR INSERCIÓN DE DATOS PARA INTERACCIÓN! </strong>';
				echo '<br/>Query Add: '.$queryAddInt;
				#exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LA INTERACCIÓN CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query Add: '.$queryAddInt;
			}
		}
		echo '&nbsp;&nbsp;<!--input type="image" src="img/reg.png" value="REGRESAR" onclick="window.close()" height="75" width="161"-->
		<input type="button" style="background-color:red" onclick="window.close()" value="SALIR"> </body></html>';
		exit();
	}
    
    $queryMedicamentos = "SELECT idMedicamento,nombreMedicamento
							FROM medpacientes
							WHERE numeroExpediente = '$expediente' AND (folio = 0 || folio= '$folio')";
	$idMedicamentos = mysqli_query($conexion, $queryMedicamentos) or die (mysqli_error($conexion));
	
	$queryMedicamentos2 = "SELECT idMedicamento,nombreMedicamento
							FROM medpacientes
							WHERE numeroExpediente = '$expediente' AND (folio = 0 || folio= '$folio')";
	$idMedicamentos2 = mysqli_query($conexion, $queryMedicamentos2) or die (mysqli_error($conexion));

	
 ?>

<body> 
<!--script type="text/javascript">
	if((navigator.userAgent.match(/MSIE/i)) || (navigator.userAgent.match(/Chrome/i)) || (navigator.userAgent.match(/Firefox/i))) {
		document.write('<style type="text/css" media="screen">{font-size:16px;width:90%;}</style>');
	}
</script-->

<script type="text/javascript">
	function mostrar(v){
		if(v == '1'){
			document.getElementById('farmaco2').style="display:block";
			document.getElementById('alimento').style="display:none";
		} else {
			document.getElementById('alimento').style="display:block";
			document.getElementById('farmaco2').style="display:none";
		}
	}
	
	function mostrarInt() {
        element = document.getElementById("btnGdNoInt");
        element1 = document.getElementById("interacciones");
        element2 = document.getElementById("btnGd");
        
        check = document.getElementById("ckInteraccion");
        if (check.checked) {
            element.style.display='block';
            element1.style.display='none';
            element2.style.display='none';
        }
        else {
            element.style.display='none';
            element1.style.display='block';
            element2.style.display='block';
        }
    }
	function dsblqModifInt(c)
	{
		document.getElementById("diaDss"+c).disabled=false;
		document.getElementById("horaDss"+c).disabled=false;
		document.getElementById("lgPresDss"+c).disabled=false;
		document.getElementById('btGd'+c).disabled=false;
	}
	function confirmSubmit()
	{
		var agree=confirm("¿Está seguro de eliminar este registro? !!!EL PROCESO ES IRREVERSIBLE!!!");
        //return  agree();
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}

</script>
<p>
	<strong><span class="auto-style1">Captura de Interacciones: <?php echo $expediente; ?> <?php echo ' '.urldecode($nomPac); ?> </span></strong>
</p>
<hr class="auto-style2">
<div  id="div1">
	<table style="width: 100%" class="auto-style6">
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;No.&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;FARMACO&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;FARMACO/ALIMENTO&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;DESCRIPCIÓN DEL EFECTO&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;SEVERIDAD DE INTERACCIÓN&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;DESCRIPCIÓN DE CONTRAINDICACIONES&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;DUPLICIDAD TERAPÉUTICA&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;RECOMENDACIÓN&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;LUGAR&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;FECHA DE CAPTURA&nbsp;</th>
		<th class="auto-style7" style="background-color:#CCFFFF">&nbsp;OPCIONES&nbsp;</th>
		<?php
			$queryInt = "SELECT idInteraccion,nombreFarmaco,CASE nombreFarmaco2 WHEN '' THEN alimento ELSE nombreFarmaco2 END AS farmacoAlimento,
								descEfecto,nombreSeveridad,descripcion, CASE duplicidadTerapeutica WHEN '1' THEN 'SI' ELSE 'NO' END AS dupTep, CASE recomendacion WHEN '1' THEN 'SI' ELSE 'NO' END AS reco, l.nombreLugarHist, i.fechaGuardado
						FROM interacciones AS i
						LEFT JOIN severidadinteraccion AS s ON i.severidad=s.idSeveridad
						LEFT JOIN lugarhistorico AS l ON i.lugarInteraccion=l.idLugarHist
						WHERE i.numeroExpediente='$expediente' AND (i.folio = 0 || i.folio= '$folio')";
			$resInt = mysqli_query($conexion, $queryInt) or die (mysqli_error($conexion));
			$cont=1;
			while($rowI = mysqli_fetch_array($resInt)){
			if($rowI[9] != NULL){
				$date1 = date_create_from_format('Y-m-d',$rowI[9])->format('d-m-Y');
			} else {
				$date1 = NULL;
			}
			?>
		<tr>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo $cont++ ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo $rowI[1] ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo utf8_encode($rowI[2]) ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo utf8_encode($rowI[3]) ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo utf8_encode($rowI[4]) ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo utf8_encode($rowI[5]) ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo utf8_encode($rowI[6]) ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo utf8_encode($rowI[7]) ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo utf8_encode($rowI[8]) ?></td>
			<td class="auto-style7" style="background-color:#c7e1f0"><?php echo $date1 ?></td>
			<td class="auto-style8" style="background-color:#c7e1f0"><!--input  type="button" value="MODIFICAR" onclick ="dsblqModifInt('.$rowI[0].')" disabled-->
			    <?php echo '<a onclick="return confirmSubmit()" href="interacciones.php?idDint='.$rowI[0].'&expediente='.$expediente.'&folio='.$folio.'&nomPac='.urlencode($nomPac).'&idMedic='.$idMedic.'&id='.$id.'&nMedic='.urlencode($nMedic).'" >ELIMINAR </a>'; ?>
			    <!--input id="btGd'.$rowH[0].'" type="submit" name="enviarDss" value="GUARDAR" disabled -->
			</td>
			<?php } ?>
		</tr>
	</table>
</div>
<br>

<form method="post" action="interacciones.php">
	<strong>&nbsp;&nbsp;NO TIENE INTERACCIONES:</strong>&nbsp;
	<input name="noInteracc" id="ckInteraccion" type="checkbox" value="NO SE PRESENTARON INTERACCIONES" style="width: 30px; height: 30px" onchange="mostrarInt()" >
	<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
	<input name="folio" type="hidden" value="<?php echo $folio ?>" >
	<input name="nomPac" type="hidden" value="<?php echo $nomPac ?>" >
	<input name="idMedic" type="hidden" value="<?php echo $idMedic ?>" >
	<input name="nMedic" type="hidden" value="<?php echo $nMedic?>" >
	<br>
	<div id="btnGdNoInt" style="display:none" >
		<input type="Submit" name="enviarNoInteraccion" id="noInteraccion" style="background-color:lime" value="GUARDAR SIN INTERACCIONES" >
	</div>
</form>
<form method="post" action="interacciones.php" autocomplete="off">
	<div class="auto-style3">
	<!-- Bloque para Interacciones con el Medicamento style="display:none; -->
	<div id="interacciones">
		<strong>&nbsp;&nbsp;FARMACO:</strong>&nbsp;
		<!--input type="text" name="farmaco">&nbsp;&nbsp;-->
		<select id="farmaco1" name="farmaco1" required>
		<option value="">Seleccione</option>
		<?php
		while($row = mysqli_fetch_array($idMedicamentos)){
			echo '<option value="'.$row[0].'*'.utf8_encode($row[1]).'">'.utf8_encode($row[1]).'</option>';
			}
		?>
		</select>
		<br>
		<strong>FARMACO/ALIMENTO:</strong>&nbsp;
		<br>
		<br> 
		FARMACO<input name="show_farmacoAlim" type="radio" onclick="mostrar('1')" style="width: 30px; height: 30px" required>&nbsp; 
		<br>
		<br>
		ALIMENTO<input name="show_farmacoAlim" type="radio" onclick="mostrar('2')" style="width: 30px; height: 30px" required>&nbsp;
		<br>
		<br>
		<input type="text" id="alimento" name="alimento" style="display:none">
		
		<select id="farmaco2" name="farmaco2" style="display:none">
		<option value="">Seleccione</option>
		<?php
		while($row2 = mysqli_fetch_array($idMedicamentos2)){
			echo '<option value="'.$row2[0].'*'.utf8_encode($row2[1]).'">'.utf8_encode($row2[1]).'</option>';
			}
			mysqli_close($conexion);
		?>
		</select>
		<strong>DESCRIPCIÓN DEL EFECTO:</strong>&nbsp; <input type="text" name="descEfec" style="background-color:#C6E2FF">
		<br>
		<br>
		<strong>&nbsp;&nbsp;SEVERIDAD DE LA INTERACCIÓN</strong>
		<select name="sevInteraccion" required>
        	<option value="">Seleccione</option>
   			<option value="1" style="background-color:#FF6666"> CONTRAINDICADA </option>
			<option value="2" style="background-color:red"> SERIA </option>
			<option value="3" style="background-color:yellow"> SIGNIFICATIVA </option>
			<option value="4" style="background-color:green"> MENOR </option>
		</select>
		<br>
		<br>
		<strong>&nbsp;&nbsp;DESCRIPCIÓN DE CONTRAINDICACIONES Y PRECAUCIONES A LOS MEDICAMENTOS:</strong>
		<textarea name="descInteracciones" cols="20" rows="2" style="background-color:#C6E2FF"></textarea>
		<br>
		<strong>&nbsp;&nbsp;DUPLICIDAD TERAPEUTICA:</strong>&nbsp;
		<input name="duplicTerap" type="checkbox" value="1" style="width: 30px; height: 30px" >
		<br>
		<strong>&nbsp;&nbsp;LUGAR DE INCIDENCIA:</strong>
		<br>
		<select name="lugarInteraccion" required>
	        <option value="">Seleccione:</option>
		    <option value="7"> CASA </option>
	   		<option value="1"> URGENCIAS </option>
			<option value="2"> QUIRÓFANO </option>
			<option value="3"> HOSPITALIZACIÓN </option>
			<option value="4"> UCI </option>
			<option value="5"> UCIN </option>
			<option value="6"> EGRESO </option>
		</select>
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
		</div>
		<!-- Termina Bloque para Interacciones con el Medicamento -->
		<br>
		<br>
		<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
		<input name="folio" type="hidden" value="<?php echo $folio ?>" >
		<input name="nomPac" type="hidden" value="<?php echo $nomPac ?>" >
		<input name="idMedic" type="hidden" value="<?php echo $idMedic ?>" >
		<input name="nMedic" type="hidden" value="<?php echo $nMedic?>" >

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<div id="btnGd">
			<input type="Submit" name="enviarInteraccion" style="background-color:lime" value="GUARDAR">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
		<input type="button" style="background-color:red" onclick="window.close()" value="SALIR">
	</div>
	</form>
</body>
</html>