<?php
  	header('Content-Type: text/html;charset=utf-8');
  	#archivo con la conexion a la BD MYSQL local
  	require_once('conexion/config.php');
  	
  	$idDss=NULL;
  	
	#Comenzamos con PHP para recibir por GET 5 variables desde formulario_farmacia.php o de aqui mismo O_o?
	if(isset ($_GET['expediente'])) {
		$expediente = $_GET['expediente'];
	}else{
		$expediente = NULL;
	}
	if(isset ($_GET['folio'])) {
		$folio = $_GET['folio'];
	}else{
		$folio = NULL;
	}
	if(isset ($_GET['nomPac'])){
		$nomPac = utf8_encode($_GET['nomPac']);
	}else{
		$nomPac = NULL;
	}
	if(isset ($_GET['idMedic'])){
		$idMedic = $_GET['idMedic'];
	}else{
		$idMedic = NULL;
	}
	if(isset ($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = NULL;
	}
	if(isset ($_GET['nMedic'])){
		$nMedic = $_GET['nMedic'];
	}else{
		$nMedic = NULL;
	}
	#Si llega este valor quiere decir q es Eliminacion
	if(isset ($_GET['idDss'])){
		$idDss = $_GET['idDss'];
	}else{
		$idDss = NULL;
	}

	if($idDss != NULL && $idDss != ''){
		#Esta es la Query que elimina una dosis
		$queryDelDss = "DELETE FROM historicodosis WHERE idHistDosis='$idDss'";
		$result0 = mysqli_query($conexion, $queryDelDss);
		
		if(!$result0){
			echo'! ERROR AL ELIMINAR DOSIS!';
			echo '<br/>Query DEL: '.$queryDelDss;
			exit;
		} else {
			echo '<br/><strong>!!!! SE ELIMINO LA DOSIS CORRECTAMENTE!!!!</strong><br>';
			#echo '<br/>Query DEL: '.$queryDelDss;
		}
	}

	#Estamos enviando los valores de aqui mismo y aqui los recibimos O_O!
	if(isset($_REQUEST['enviarDss']))
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
			$nomPac = utf8_decode($_POST['nomPac']);
		}else{
			$nomPac = NULL;
		}
		if(isset ($_POST['idMedic'])){
			$idMedic = $_POST['idMedic'];
		}else{
			$idMedic = NULL;
		}
		if(isset ($_POST['id'])){
			$id = $_POST['id'];
		}else{
			$id = NULL;
		}
		##########
		if(isset ($_POST['diaDss'])){
			$diaDss= $_POST['diaDss'];
		}else{
			$diaDss= NULL;
		}
		if(isset ($_POST['horaDss'])){
			$horaDss= $_POST['horaDss'];
		}else{
			$horaDss= NULL;
		}
		if(isset ($_POST['lgPresDss'])){
			$lgPresDss= $_POST['lgPresDss'];
		}else{
			$lgPresDss= NULL;
		}
		if(isset ($_POST['recomendacion'])){
			$recomendacion= $_POST['recomendacion'];
		}else{
			$recomendacion= NULL;
		}
		if(isset ($_POST['nota'])){
			$nota= utf8_decode($_POST['nota']);
		}else{
			$nota= NULL;
		}

		#Estos 2 llegan para actualizar
		if(isset ($_POST['nMedic'])){
			$nMedic = $_POST['nMedic'];
		}else{
			$nMedic = NULL;
		}
		if(isset($_POST["checkbox"])) {
			#Si se marco el checkBox le asignamos a la variable el valor seleccionado
			$idDss = implode(",", $_POST['checkbox']);
		}
			
		/*if(isset ($_POST['idDss'])){
			$idDss= $_POST['idDss'];
		}else{
			$idDss= NULL;
		}*/
		#No esta vacio idDss entonces es Actualizacion
		if($idDss != NULL && $idDss != ''){
			$queryUpdDosis = "UPDATE historicodosis SET diaConsumo = '$diaDss', hrConsumo = '$horaDss', lugarPrescripcion = '$lgPresDss', idRecomendacion = '$recomendacion' 
			 					WHERE idHistDosis = $idDss";
			$result0 = mysqli_query($conexion, $queryUpdDosis);
				
			if(!$result0){
				echo'! ERROR AL REALIZAR ACTUALIZACIÓN DE DATOS PARA DOSIS!';
				echo '<br/>Query UPD: '.$queryUpdDosis;
				exit;
			} else {
				echo '<br/><strong>!!!! SE ACTUALIZARON LOS DATOS DE LA DOSIS CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query UPD: '.$queryUpdDosis;
			}
		} else { #Esta vacio idDss entonces es Inserción
			$queryAddDosis = "INSERT INTO historicodosis (idHistDosis, diaConsumo, hrConsumo, lugarPrescripcion, idMedPaciente, idMedicamento, numeroExpediente, folio, idRecomendacion, notas)
								VALUES (NULL, '$diaDss', '$horaDss', '$lgPresDss', '$id', '$idMedic', '$expediente', '$folio', '$recomendacion', '$nota')";
			$result0 = mysqli_query($conexion, $queryAddDosis);
				
			if(!$result0){
				echo'! ERROR AL REALIZAR INSERCIÓN DE DATOS PARA DOSIS!';
				echo '<br/>Query Add: '.$queryAddDosis;
				exit;
			} else {
				echo '<br/><strong>!!!! SE INSERTARON LOS DATOS DE LA DOSIS CORRECTAMENTE!!!!</strong><br>';
				#echo '<br/>Query Add: '.$queryAddDosis;
			}
		}
	}
?>
<!DOCTYPE html> 
<html>
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
 	<title>DOSIS</title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" >
  	<style type="text/css">
		.auto-style3 {
		color: #070719;
		font-family: Arial, Helvetica, sans-serif;
		font-size:x-large;
	}

	.auto-style4 {
		font-size: large;
		text-align: center;
		border-style: solid;
		border-width: 1px;
		background-color: #FFFFFF;
	}
	.auto-style5 {
		font-size: large;
	}
	.auto-style6 {
		font-size: large;
		border-bottom-style: solid;
		border-bottom-width: 1px;
		border-style: solid;
		background-color: #99FFCC;
		text-align: center;
	}
	</style>
<script type="text/javascript">
	function dsblqModifDss(c)
	{
		document.getElementById("diaDss"+c).disabled=false;
		document.getElementById("horaDss"+c).disabled=false;
		document.getElementById("lgPresDss"+c).disabled=false;
		document.getElementById("recomendacion"+c).disabled=false;
		document.getElementById('btGd'+c).disabled=false;
		document.getElementById('checkboxDss'+c).disabled=false;
	}
	function confirmSubmit()
	{
		var agree=confirm("¿Está seguro de eliminar este registro? !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}
</script>
</head>
<body background="img/logoNew2Agua.jpg">
	<br>
	<strong><span class="auto-style3">HISTORIAL DE DOSIS PARA EL PACIENTE: <?php echo $nomPac ?></span></strong>
	<br>
	<table style="width: 100%">
	<tr>
	<td class="auto-style3"> <strong> MEDICAMENTO: <?php echo $nMedic ?></strong></td>
	</table>
		<hr>
		<table style="width: 100%"  border="5px solid black;">
			<th class="auto-style6">&nbsp;FECHA INICIO&nbsp;</th>
			<th class="auto-style6">&nbsp;MEDICAMENTO&nbsp;</th>
			<th class="auto-style6">&nbsp;DOSIS&nbsp;</th>
			<th class="auto-style6">&nbsp;VÍA DE ADMON&nbsp;</th>
			<th class="auto-style6">&nbsp;FRECUENCIA&nbsp;</th>
			<?php
			$queryDosis = "SELECT fechaInicio,nombreMedicamento,dosis,m.idViaAdmon,v.viaAdmon,frecuencia,f.nombreFrecuencia
							FROM medpacientes as m
							LEFT JOIN viadeadmon as v ON m.idViaAdmon = v.idViaAdmon
							LEFT JOIN frecuencia as f ON m.frecuencia = f.idFrecuencia
							WHERE id = '$id'";
			$idDosis = mysqli_query($conexion, $queryDosis ) or die (mysqli_error($conexion));
			while($row = mysqli_fetch_array($idDosis)){
			if($row[0] != NULL){
				$date1 = date_create_from_format('Y-m-d',$row[0])->format('d-m-Y');
			} else {
				$date1 = NULL;
			}
			?>
			<tr>
				<td class="auto-style4"><?php echo $date1 ?></td>
				<td class="auto-style4"><?php echo $row[1] ?></td>
				<td class="auto-style4"><?php echo $row[2] ?></td>
				<td class="auto-style4"><?php echo $row[4] ?></td>
				<td class="auto-style4"><?php echo $row[6] ?></td>
				<?php } ?>
			</tr>
		</table>
		<br>
		<form method="post" action="dosis.php">
		<table style="width: 100%"  border="5px solid black;">
			<th class="auto-style6">&nbsp;No.</th>
			<th class="auto-style6">&nbsp;DÍA</th>
			<th class="auto-style6">&nbsp;HORA</th>
			<th class="auto-style6">&nbsp;LUGAR DE PRESCRIPCIÓN</th>
			<th class="auto-style6">&nbsp;RECOMENDACIÓN</th>
			<th class="auto-style6">&nbsp;OPCIONES</th>
			<?php
				#Esta Query es para sacar el numero de resultados de dosis para un medicamento de un paciente, sirve para la siguiente tabla
				$queryHistCont = "SELECT COUNT(idHistDosis) AS conteo
							FROM historicodosis							
							WHERE idMedPaciente='$id' AND idMedicamento='$idMedic' LIMIT 1";
				$idHistCont = mysqli_query($conexion, $queryHistCont) or die (mysqli_error($conexion));
				$rowHist = mysqli_fetch_array($idHistCont);
				$conteo = $rowHist['conteo'];

				#Esta Query es para llenar la tabla
				$queryHist = "SELECT idHistDosis, diaConsumo, hrConsumo, lugarPrescripcion, l.nombreLugarHist, idRecomendacion, r.nombreRecHist
							FROM historicodosis AS h 
							LEFT JOIN lugarhistorico AS l ON h.lugarPrescripcion = l.idLugarHist
							LEFT JOIN recomendacionhist AS r ON h.idRecomendacion = r.idRecomendacionHist							
							WHERE idMedPaciente='$id' AND idMedicamento='$idMedic' ORDER BY diaConsumo,hrConsumo";
				$idHist = mysqli_query($conexion, $queryHist) or die (mysqli_error($conexion));
				$c = 1;
				$rowH = NULL;
				while($rowH = mysqli_fetch_array($idHist))
				{
					#$d = $c++;
					echo '<tr>
						<td class="auto-style4"><input name="checkbox[]" type="checkbox" id="checkboxDss'.$rowH[0].'" value='.$rowH[0].' style="width: 45px; height: 35px" disabled><br/>
						'.$c++.'</td>
						<td class="auto-style4"> <input id="diaDss'.$rowH[0].'" name="diaDss" type="date" style="width:163px;" value="'.$rowH[1].'" disabled ></td>
						<td class="auto-style4"> <input id="horaDss'.$rowH[0].'" name="horaDss" type="time" style="width:123px;" value="'.$rowH[2].'" disabled ></td>
						<td class="auto-style4"> <select id="lgPresDss'.$rowH[0].'" name="lgPresDss" style="width:185px; height:40px" disabled>
					        <option value="'.$rowH[3].'">'.utf8_encode($rowH[4]).'</option>
					   		<option value="1"> URGENCIAS </option>
							<option value="2"> QUIRÓFANO </option>
							<option value="3"> HOSPITALIZACIÓN </option>
							<option value="4"> UCI </option>
							<option value="5"> UCIN </option>
							<option value="6"> EGRESO </option>
							</select>
						</td>
						<td class="auto-style4"> <select id="recomendacion'.$rowH[0].'" name="recomendacion" style="width:290px; height:40px" disabled>
					 	<option value="'.$rowH[5].'">'.utf8_encode($rowH[6]).'</option>
						 	<option value="3"> INICIAR TRATAMIENTO </option>
					   		<option value="1"> CONTINUAR MEDICACIÓN </option>
							<!--option value="2"> DESCONTINUAR MEDICACIÓN</option-->
							</select>
						</td>
					<!--input name="idDss" type="hidden" value="'.$rowH[0].'" /-->
					<input name="expediente" type="hidden" value="'.$expediente.'" />
					<input name="folio" type="hidden" value="'.$folio.'" />
					<input name="idMedic" type="hidden" value="'.$idMedic.'" />
					<input name="id" type="hidden" value="'.$id.'" />
					<input name="nMedic" type="hidden" value="'.$nMedic.'" />
					<input name="nomPac" type="hidden" value="'.$nomPac.'" /> <td>';
					#if( /*$d != 1 ||*/ $conteo == '1'){
					    echo '&nbsp;&nbsp;&nbsp;&nbsp;<input  class="btn btn-primary" type="button" value="MODIFICAR" onclick ="dsblqModifDss('.$rowH[0].')" />
					    &nbsp;&nbsp;&nbsp;&nbsp;<input id="btGd'.$rowH[0].'" type="submit" class="btn btn-success" name="enviarDss" value="GUARDAR" disabled />
						&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmit()" href="dosis.php?idDss='.$rowH[0].'&expediente='.$expediente.'&folio='.$folio.'&nomPac='.urlencode($nomPac).'&idMedic='.$idMedic.'&id='.$id.'&nMedic='.urlencode($nMedic).'" />ELIMINAR </a>';
					/*} else {
					echo '&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirmSubmit()" href="dosis.php?idDss='.$rowH[0].'&expediente='.$expediente.'&nomPac='.urlencode($nomPac).'&idMedic='.$idMedic.'&id='.$id.'&nMedic='.urlencode($nMedic).'" />ELIMINAR </a>';
					}*/
					echo'</td></tr>';
				}
				echo '</table><br>';
				$queryNotas = "SELECT idHistDosis, notas
							FROM historicodosis AS h	
							WHERE idMedPaciente='$id' AND idMedicamento='$idMedic' AND notas IS NOT NULL  AND notas <> ''";
				$idNotas = mysqli_query($conexion, $queryNotas) or die (mysqli_error($conexion));
				$rowN = mysqli_fetch_array($idNotas);
				
				echo'<table style="width: 100%"  border="5px solid black;">
					 <th class="auto-style6">&nbsp;OBSERVACIONES</th>
					 <tr>
					 <td class="auto-style4">'.utf8_encode($rowN[1]).'</td>
					 </tr>';
				mysqli_close($conexion);
			?>
			</table>
		</form>
		<form method="post" action="dosis.php">
			<br><strong><span class="auto-style5">AGREGAR NUEVA DOSIS<br/><br/>
			&nbsp;DÍA:</span></strong><span class="auto-style5">&nbsp;
			</span>
			<input id="diaDss" name="diaDss" type="date" style="width:180px; height:40px" required class="auto-style5">	
			<strong><span class="auto-style5">&nbsp; HORA: </span> </strong>
			<span class="auto-style5">&nbsp;</span>
			<input id="horaDss" name="horaDss" type="time" style="width:150px; height:40px" required class="auto-style5">
			<strong><span class="auto-style5">&nbsp; LUGAR DE PRESCRIPCIÓN:</span></strong><span class="auto-style5">&nbsp;
			</span>
			<select id="lgPresDss" name="lgPresDss" style="width:230px; height:40px" required class="auto-style5">
		        <option value="">Seleccione:</option>
		        <option value="7"> CASA </option>
		   		<option value="1"> URGENCIAS </option>
				<option value="2"> QUIRÓFANO </option>
				<option value="3"> HOSPITALIZACIÓN </option>
				<option value="4"> UCI </option>
				<option value="5"> UCIN </option>
				<!--option value="6"> EGRESO </option-->
			</select>
			<br>
			<br>
			<strong><span class="auto-style5">&nbsp; RECOMENDACIÓN:</span></strong><span class="auto-style5">&nbsp;
			</span>
			<select id="recomendacion" name="recomendacion" style="width:290px; height:40px" required class="auto-style5">
		        <option value="">Seleccione:</option>
		        <option value="3"> INICIAR TRATAMIENTO </option>
		   		<option value="1"> CONTINUAR MEDICACIÓN </option>
				<!--option value="2"> DESCONTINUAR MEDICACIÓN</option-->
			</select>
			<strong><span class="auto-style5">&nbsp; OBSERVACIONES: </span> </strong>
			<span class="auto-style5">&nbsp;</span>
			<input id="nota" name="nota" type="text" style="width:550px; height:40px" class="auto-style5">
			<br>
			<br>
		<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
		<input name="folio" type="hidden" value="<?php echo $folio ?>" >
		<input name="id" type="hidden" value="<?php echo $id ?>" >
		<input name="idMedic" type="hidden" value="<?php echo $idMedic ?>" >
		<input name="nomPac" type="hidden" value="<?php echo $nomPac ?>" >
		<br/>
		&nbsp;
		<input type="submit" class="btn btn-success" name="enviarDss" value="GUARDAR" style="width: 140px; height: 60px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> SALIR </a>
	</form>
	</body>
</html>
