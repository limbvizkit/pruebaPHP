<?php
require_once('../conexion/configMedico.php');

	if (isset($_POST['idNotaRefTraslh']))
	{
		$idNotaRefTraslh = $_POST["idNotaRefTraslh"];
	} else {
		$idNotaRefTraslh = '';
	}

	if (isset($_POST['horaFin']))
	{
		$horaFin = $_POST["horaFin"];
	} else {
		$horaFin = '';
	}
	if (isset($_POST['turno']))
	{
		$turno = $_POST["turno"];
	} else {
		$turno = '';
	}
	if (isset($_POST['fechaFin']))
	{
		$fechaFin = $_POST["fechaFin"];
	} else {
		$fechaFin = '';
	}
	if (isset($_POST['tipoTraslado']))
	{
		$tipoTraslado = $_POST["tipoTraslado"];
	} else {
		$tipoTraslado = '';
	}
	if (isset($_POST['receptor']))
	{
		$receptor = $_POST["receptor"];
	} else {
		$receptor = '';
	}
	if (isset($_POST['otroReceptor']))
	{
		$otroReceptor = utf8_decode($_POST["otroReceptor"]);
		$otroReceptor=addslashes($otroReceptor);
	} else {
		$otroReceptor = '';
	}
	if (isset($_POST['servicio']))
	{
		$servicio = $_POST["servicio"];
	} else {
		$servicio = '';
	}
	if (isset($_POST['ambulanciaTecno']))
	{
		$ambulanciaTecno = $_POST["ambulanciaTecno"];
	} else {
		$ambulanciaTecno = '';
	}
	if (isset($_POST['tipoPaciente']))
	{
		$tipoPaciente  = $_POST["tipoPaciente"];
	} else {
		$tipoPaciente = '';
	}
	if (isset($_POST['oxigeno']))
	{
		$oxigeno = $_POST["oxigeno"];
	} else {
		$oxigeno = '0';
	}
	if (isset($_POST['desfibrilador']))
	{
		$desfibrilador = $_POST["desfibrilador"];
	} else {
		$desfibrilador = '0';
	}
	if (isset($_POST['ventilador']))
	{
		$ventilador = $_POST["ventilador"];
	} else {
		$ventilador = '0';
	}
	if (isset($_POST['incubadora']))
	{
		$incubadora = $_POST["incubadora"];
	} else {
		$incubadora = '0';
	}
	/*if (isset($_POST['envia']))
	{
		$envia  = $_POST["envia"];
	} else {
		$envia = '';
	}*/
	if (isset($_POST['fc']))
	{
		$fc  = $_POST["fc"];
	} else {
		$fc = '';
	}

	if (isset($_POST['fr']))
	{
		$fr  = $_POST["fr"];
	} else {
		$fr = '';
	}

	if (isset($_POST['ta']))
	{
		$ta  = $_POST["ta"];
	} else {
		$ta = '';
	}

	if (isset($_POST['temp']))
	{
		$temp  = $_POST["temp"];
	} else {
		$temp = '';
	}

	if (isset($_POST['peso']))
	{
		$peso  = $_POST["peso"];
	} else {
		$peso = '';
	}
	if (isset($_POST['talla']))
	{
		$talla  = $_POST["talla"];
	} else {
		$talla = '';
	}
	if (isset($_POST['motivoEnvio']))
	{
		$motivoEnvio  = utf8_decode($_POST["motivoEnvio"]);
		$motivoEnvio =addslashes($motivoEnvio);
	} else {
		$motivoEnvio = '';
	}
	if (isset($_POST['impresionDiag']))
	{
		$impresionDiag  = utf8_decode($_POST["impresionDiag"]);
		$impresionDiag=addslashes($impresionDiag);
	} else {
		$impresionDiag = '';
	}
	if (isset($_POST['terapeuticaEmpl']))
	{
		$terapeuticaEmpl  = utf8_decode($_POST["terapeuticaEmpl"]);
		$terapeuticaEmpl =addslashes($terapeuticaEmpl);
	} else {
		$terapeuticaEmpl = '';
	}
	if (isset($_POST['cedulaMedEntrega']))
	{
		$cedulaMedEntrega  = $_POST["cedulaMedEntrega"];
	} else {
		$cedulaMedEntrega = '';
	}
	if (isset($_POST['horaExt']))
	{
		$horaExt  = $_POST["horaExt"];
	} else {
		$horaExt = '';
	}
	if (isset($_POST['turnoExt']))
	{
		$turnoExt  = $_POST["turnoExt"];
	} else {
		$turnoExt = '';
	}
	if (isset($_POST['fechaExt']))
	{
		$fechaExt  = $_POST["fechaExt"];
	} else {
		$fechaExt = '';
	}
	if (isset($_POST['estable']))
	{
		$estable = $_POST["estable"];
	} else {
		$estable = '';
	}
	
	if(!empty($idNotaRefTraslh)){
		$queryUpdDNotaRT = "UPDATE notaReferenciaTrash SET hora='$horaFin', fecha='$fechaFin',turno='$turno',servicio='$servicio',
		tipoTraslado='$tipoTraslado',ambulanciaTecno='$ambulanciaTecno',tipoPaciente='$tipoPaciente',oxigeno='$oxigeno',desfibrilador='$desfibrilador',
		ventilador='$ventilador',incubadora='$incubadora',receptor='$receptor',otroReceptor='$otroReceptor',fc='$fc',fr='$fr',ta='$ta',temp='$temp',
		peso='$peso',talla='$talla',motivoEnvio='$motivoEnvio',impresionDiag='$impresionDiag',terapeuticaEmpl='$terapeuticaEmpl',
		cedulaMedEntrega='$cedulaMedEntrega',fechaExt='$fechaExt',horaExt='$horaExt',estable='$estable',turnoExt='$turnoExt' WHERE id='$idNotaRefTraslh'";
		
		$result0 = mysqli_query($conexionMedico, $queryUpdDNotaRT) or die (mysqli_error($conexionMedico));
			
		if(!$result0){
			echo'0';
			echo $queryUpdDNotaRT;
		} else {
			echo '1';
			//echo $queryUpdDNotaRT;
		}
	} else {
		echo '0';
		return false;
	}
?>
