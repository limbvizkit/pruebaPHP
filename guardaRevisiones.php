<?php
  	header('Content-Type: text/html;charset=UTF-8');
  	require_once('conexion/config.php');

  	$contraInd= NULL;
  	
  	if(isset($_REQUEST['enviarRevisiones']))
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
		
		if(isset ($_POST['id'])){
			$id= $_POST['id'];
		}else {
			$id= NULL;
		}
		
		if(isset ($_POST['idMedic'])){
			$idMedic= $_POST['idMedic'];
		}else {
			$idMedic= NULL;
		}
		
		if(isset ($_POST['nMedic'])){
			$nMedic= $_POST['nMedic'];
		}else {
			$nMedic= NULL;
		}
		
		if(isset ($_POST['dosisMax'])){
			$dosisMax= utf8_decode($_POST['dosisMax']);
		}else {
			$dosisMax= NULL;
		}
		
		if(isset ($_POST['dosisInc'])){
			$dosisInc= $_POST['dosisInc'];
		}else {
			$dosisInc= NULL;
		}
		
		if(isset ($_POST['revPeso'])){
			$revPeso= utf8_decode($_POST['revPeso']);
		}else {
			$revPeso= NULL;
		}
		
		if(isset ($_POST['pesoInc'])){
			$pesoInc = $_POST['pesoInc'];
		}else {
			$pesoInc = NULL;
		}
		
		if(isset ($_POST['ajstRen'])){
			$ajstRen= utf8_decode($_POST['ajstRen']);
		}else {
			$ajstRen= NULL;
		}

		if(isset ($_POST['renalInc'])){
			$renalInc= $_POST['renalInc'];
		}else {
			$renalInc= NULL;
		}

		if(isset ($_POST['contraInd'])){
			if($_POST['contraInd'] != NULL && $_POST['contraInd'] != ''){
				$contraInd= utf8_decode($_POST['contraInd']);
			}
		}
		
		if(isset ($_POST['recomendacion'])){
			$recomendacion = $_POST['recomendacion'];
		} else {
			$recomendacion = NULL;
		}

		if(isset ($_POST['idRev'])){
			$idRev= $_POST['idRev'];
			#Estoy recibiendo un idRev? entonces la revision ya existe la eliminamos? :o NOOO mejor actualizamos :D
			$queryUpdRevision = "UPDATE revisiones SET dosisMax='$dosisMax', revisionPeso='$revPeso', 
							  ajusteRenal='$ajstRen', contraindicaciones='$contraInd' WHERE idRevision='$idRev'";
			$result0 = mysqli_query($conexion, $queryUpdRevision);
			
			if(!$result0){
				echo'! ERROR al realizar inserción de datos GUARDAR Revisiones!';
			} else {
				echo '<br/>!!!! SE ACTUALIZARON LOS DATOS DE LA REVISIÓN CORRECTAMENTE!!!!<br>';
				#echo '<br/>Query UPD: '.$queryUpdRevision;
			}
		} else {
			$idRev= NULL;
			
			#Query para insertar una nueva Revision
			$queryRevision = "INSERT INTO revisiones (idRevision, numeroExpediente, folio, idMedicamento, nombreMedicamento, dosisMax, dosisIncorrecta,
						revisionPeso, pesoIncorrecto, ajusteRenal, renalIncorrecto, contraindicaciones, idMedPacientes, recomendacion)
						VALUES (NULL, '$expediente', '$folio','$idMedic','$nMedic', '$dosisMax', '$dosisInc',
						 '$revPeso', '$pesoInc', '$ajstRen', '$renalInc', '$contraInd', '$id', '$recomendacion')";
		
		$result0 = mysqli_query($conexion, $queryRevision);
		if(!$result0){
			echo '! ERROR al realizar inserción de datos GUARDAR Revisiones!';
			echo '<br/>'.$queryRevision;
		} else {
			echo '<br>!!!! SE GUARDARON LOS DATOS DE LA REVISIÓN CORRECTAMENTE!!!!<br>';
			#Tomamos el valor del id que acabamos de guardar
			$queryIdRevision = "SELECT idRevision FROM revisiones WHERE idMedPacientes= '$id'";
			$idRev = mysqli_query($conexion, $queryIdRevision) or die (mysqli_error($conexion));
			$idRev1 = mysqli_fetch_array($idRev);
			$idRevFin = $idRev1 ['idRevision'];
			#Insertamos el idRevision para medPaciente seleccionado
			$queryUpdRevision = "UPDATE medpacientes SET idRevision = '$idRevFin' WHERE id = '$id'";
			$result1 = mysqli_query($conexion, $queryUpdRevision) or die (mysqli_error($conexion));
			if(!$result1){
				echo'! ERROR al realizar actualización de datos Revisiones por medPac!';
			} else {
				echo '<br>!!!! SE ACTUALIZARON LOS DATOS DEL MEDICAMENTO/PACIENTE CORRECTAMENTE!!!!<br>';
			}
		}
		}
		mysqli_close($conexion);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Guarda Revisiones</title>
</head>

<body>
	<?php echo '<br><strong>DATOS GUARDADOS PARA REVISIÓN DE MEDICAMENTO : </strong>'.$nMedic.
		'<br> <strong>EXPEDIENTE : </strong>'.$expediente .
		'<br> <strong>FOLIO : </strong>'.$folio .
		'<br> <strong>ID: </strong>'.$id.
		'<br> <strong>IDMEDICAMENTO: </strong>'.$idMedic.
		'<br> <strong>DOSIS MAX: </strong>'.utf8_encode($dosisMax).
	    '<br> <strong>REVISIÓN PESO: </strong>'.utf8_encode($revPeso).
	    '<br> <strong>AJUSTE RENAL: </strong>'.utf8_encode($ajstRen).
	    '<br> <strong>RECOMENDACIONES: </strong>'.$recomendacion.
	    '<br> <strong>CONTRAINDICACIONES: </strong>'.utf8_encode($contraInd);
	?>
	<br/><br/>
	<input name="cerrar" type="button" onclick="window.close();" value="SALIR" />
</body>

</html>
