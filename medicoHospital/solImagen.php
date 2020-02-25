<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configMedico.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../conexion/funciones_db.php');
	setlocale(LC_ALL,'');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
		if (isset($_GET['exp']))
		{
			$expediente=$_GET['exp'];
		} else {
			$expediente=NULL;
		}
		if (isset($_GET['folio']))
		{
			$folio=$_GET['folio'];
		} else {
			$folio=NULL;
		}
	} else {
		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		if (isset($_POST['exp']))
		{
			$expediente=$_POST['exp'];
		} else {
			$expediente=NULL;
		}
		if (isset($_POST['folio']))
		{
			$folio=$_POST['folio'];
		} else {
			$folio=NULL;
		}
	}
	
	//echo 'LLEGO: '.$rol.' '.$expediente.' '.$folio;
	
	/*$diagFin=NULL;
	$antecedentesFin=NULL;
	$interrogatorioFin=NULL;

	//Query para jalar los datos de la nota de urgencias
	$queryAntec = "SELECT *
				  FROM notaUrg
				  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
				  LIMIT 1";

	$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
	while($rowA = mysqli_fetch_array($antec)){
		$antecOld= utf8_encode($rowA['antecedentes']);
		$antecedentesFin=addslashes ($antecOld);
		
		$interrogaOld= utf8_encode($rowA['interrogatorio']);
		$interrogatorioFin=addslashes ($interrogaOld);

		$diagOld= utf8_encode($rowA['diag']);
		$diagFin=addslashes ($diagOld);
		
	}*/
	
	if(isset($_REQUEST['enviar']))
	{
		$tiroides=NULL;
		$mama=NULL;
		$higado=NULL;
		$renal=NULL;
		$abdominal=NULL;
		$utero=NULL;
		$pelvico=NULL;
		$obstetrico=NULL;
		$vejiga=NULL;
		$tejidosBlandos=NULL;
		$transRectal=NULL;
		$transVaginal=NULL;
		$carotideoBi=NULL;
		$miembroSuperiorUnilateral=NULL;
		$miembroSuperiorBilateral=NULL;
		$miembroInferiorUnilateral=NULL;
		$miembroInferiorBilateral=NULL;
		$higadoHipertensionPortal=NULL;
		$regionSimple=NULL;
		$regionContrastada=NULL;
		$cortesSenosParanasales=NULL;
		$craneoSimple=NULL;
		$craneoContrastado=NULL;
		$oidoAxialyCoronal=NULL;
		$urotac=NULL;
		$regionesSimples=NULL;
		$regionesContrastadas=NULL;
		$columna=NULL;
		$craneo=NULL;
		$senosParanasales=NULL;
		$columnaCervical=NULL;
		$columnaDorsal=NULL;
		$columnaLumbar=NULL;
		$teledeTorax=NULL;
		$toraxOseo=NULL;
		$esternon=NULL;
		$abdomenSimple=NULL;
		$abdomendePie=NULL;
		$serieGastroDuodenal=NULL;
		$colonporEnema=NULL;
		$transitoIntestinal=NULL;
		$urografiaExcretora=NULL;
		$cristograma=NULL;
		$perfilograma=NULL;
		$watters=NULL;
		$articulacionesTemporamandibulares=NULL;
		$lateraldeCuello=NULL;
		$edadOsea=NULL;
		$ot=NULL;
		

		if (isset($_POST['expediente']))
		{
			$expediente=$_POST['expediente'];
		}
		if (isset($_POST['folio']))
		{
			$folio=$_POST['folio'];
		}
		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		
		if (isset($_POST['servicio']))
		{
			$servicio=utf8_decode($_POST['servicio']);
			$servicio=addslashes($servicio);
		}
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['datosClinicos']))
		{
			$datosClinicos=utf8_decode($_POST['datosClinicos']);
			$datosClinicos=addslashes($datosClinicos);
		}
		if (isset($_POST['diagnostico']))
		{
			$diagnostico=utf8_decode($_POST['diagnostico']);
			$diagnostico=addslashes($diagnostico);
		}
		#2
		if (isset($_POST['tiroides']))
		{
			$tiroides=utf8_decode($_POST['tiroides'].'_0');
		}
		if (isset($_POST['mama']))
		{
			$mama=utf8_decode($_POST['mama'].'_0');
		}
		if (isset($_POST['higadoVesiculayPancreas']))
		{
			$higado=utf8_decode($_POST['higadoVesiculayPancreas'].'_0');
		}
		if (isset($_POST['renal']))
		{
			$renal=utf8_decode($_POST['renal'].'_0');
		}
		if (isset($_POST['abdominal']))
		{
			$abdominal=utf8_decode($_POST['abdominal'].'_0');
		}
		if (isset($_POST['uteroOvariosyVejiga']))
		{
			$utero=utf8_decode($_POST['uteroOvariosyVejiga'].'_0');
		}
		if (isset($_POST['pelvico']))
		{
			$pelvico=utf8_decode($_POST['pelvico'].'_0');
		}
		if (isset($_POST['obstetrico']))
		{
			$obstetrico=utf8_decode($_POST['obstetrico'].'_0');
		}
		if (isset($_POST['vejiga']))
		{
			$vejiga=utf8_decode($_POST['vejiga'].'_0');
		}
		if (isset($_POST['tejidosBlandos']))
		{
			$tejidosBlandos=utf8_decode($_POST['tejidosBlandos'].'_0');
		}
		if (isset($_POST['transRectal']))
		{
			$transRectal=utf8_decode($_POST['transRectal'].'_0');
		}
		if (isset($_POST['transVaginal']))
		{
			$transVaginal=utf8_decode($_POST['transVaginal'].'_0');
		}
		if (isset($_POST['carotideoBi']))
		{
			$carotideoBi=utf8_decode($_POST['carotideoBi'].'_0');
		}
		if (isset($_POST['carotideoBiTxt']))
		{
			$carotideoBiTxt=utf8_decode($_POST['carotideoBiTxt']);
			$carotideoBiTxt=addslashes($carotideoBiTxt);
		}
		if (isset($_POST['miembroSuperiorUnilateral']))
		{
			$miembroSuperiorUnilateral=utf8_decode($_POST['miembroSuperiorUnilateral'].'_0');
		}
		if (isset($_POST['miembroSupUniTxt']))
		{
			$miembroSupUniTxt=utf8_decode($_POST['miembroSupUniTxt']);
			$miembroSupUniTxt=addslashes($miembroSupUniTxt);
		}
		if (isset($_POST['miembroSuperiorBilateral']))
		{
			$miembroSuperiorBilateral=utf8_decode($_POST['miembroSuperiorBilateral'].'_0');
		}
		if (isset($_POST['miembroSupBiTxt']))
		{
			$miembroSupBiTxt=utf8_decode($_POST['miembroSupBiTxt']);
			$miembroSupBiTxt=addslashes($miembroSupBiTxt);
		}
		if (isset($_POST['miembroInferiorUnilateral']))
		{
			$miembroInferiorUnilateral=utf8_decode($_POST['miembroInferiorUnilateral'].'_0');
		}
		if (isset($_POST['miembroInfUniTxt']))
		{
			$miembroInfUniTxt=utf8_decode($_POST['miembroInfUniTxt']);
			$miembroInfUniTxt=addslashes($miembroInfUniTxt);
		}
		if (isset($_POST['miembroInferiorBilateral']))
		{
			$miembroInferiorBilateral=utf8_decode($_POST['miembroInferiorBilateral'].'_0');
		}
		if (isset($_POST['miembroInfBiTxt']))
		{
			$miembroInfBiTxt=utf8_decode($_POST['miembroInfBiTxt']);
			$miembroInfBiTxt=addslashes($miembroInfBiTxt);
		}
		if (isset($_POST['higadoHipertensionPortal']))
		{
			$higadoHipertensionPortal=utf8_decode($_POST['higadoHipertensionPortal'].'_0');
		}
		if (isset($_POST['higadoPortTxt']))
		{
			$higadoPortTxt=utf8_decode($_POST['higadoPortTxt']);
			$higadoPortTxt=addslashes($higadoPortTxt);
		}
		
		if (isset($_POST['regionSimple']))
		{
			$regionSimple=utf8_decode($_POST['regionSimple'].'_0');
		}
		if (isset($_POST['regionSimp1Txt']))
		{
			$regionSimp1Txt=utf8_decode($_POST['regionSimp1Txt']);
			$regionSimp1Txt=addslashes($regionSimp1Txt);
		}
		if (isset($_POST['regionContrastada']))
		{
			$regionContrastada=utf8_decode($_POST['regionContrastada'].'_0');
		}
		if (isset($_POST['regionContr1Txt']))
		{
			$regionContr1Txt=utf8_decode($_POST['regionContr1Txt']);
			$regionContr1Txt=addslashes($regionContr1Txt);
		}
		if (isset($_POST['cortesSenosParanasales']))
		{
			$cortesSenosParanasales=utf8_decode($_POST['cortesSenosParanasales'].'_0');
		}
		if (isset($_POST['craneoSimple']))
		{
			$craneoSimple=utf8_decode($_POST['craneoSimple'].'_0');
		}
		if (isset($_POST['craneoContrastado']))
		{
			$craneoContrastado=utf8_decode($_POST['craneoContrastado'].'_0');
		}
		if (isset($_POST['oidoAxialyCoronal']))
		{
			$oidoAxialyCoronal=utf8_decode($_POST['oidoAxialyCoronal'].'_0');
		}
		if (isset($_POST['urotac']))
		{
			$urotac=utf8_decode($_POST['urotac'].'_0');
		}
		if (isset($_POST['regionesSimples']))
		{
			$regionesSimples=utf8_decode($_POST['regionesSimples'].'_0');
		}
		if (isset($_POST['regionesSimp2Txt']))
		{
			$regionesSimp2Txt=utf8_decode($_POST['regionesSimp2Txt']);
			$regionesSimp2Txt=addslashes($regionesSimp2Txt);
		}
		
		if (isset($_POST['regionesContrastadas']))
		{
			$regionesContrastadas=utf8_decode($_POST['regionesContrastadas'].'_0');
		}
		if (isset($_POST['regionesContr2Txt']))
		{
			$regionesContr2Txt=utf8_decode($_POST['regionesContr2Txt']);
			$regionesContr2Txt=addslashes($regionesContr2Txt);
		}
		if (isset($_POST['columna']))
		{
			$columna=utf8_decode($_POST['columna'].'_0');
		}
		if (isset($_POST['columnaTxt']))
		{
			$columnaTxt=utf8_decode($_POST['columnaTxt']);
			$columnaTxt=addslashes($columnaTxt);
		}
		
		if (isset($_POST['craneo']))
		{
			$craneo=utf8_decode($_POST['craneo'].'_0');
		}
		if (isset($_POST['craneoTxt']))
		{
			$craneoTxt=utf8_decode($_POST['craneoTxt']);
			$craneoTxt=addslashes($craneoTxt);
		}
		if (isset($_POST['senosParanasales']))
		{
			$senosParanasales=utf8_decode($_POST['senosParanasales'].'_0');
		}
		if (isset($_POST['columnaCervical']))
		{
			$columnaCervical=utf8_decode($_POST['columnaCervical'].'_0');
		}
		if (isset($_POST['columnaDorsal']))
		{
			$columnaDorsal=utf8_decode($_POST['columnaDorsal'].'_0');
		}
		if (isset($_POST['columnaLumbar']))
		{
			$columnaLumbar=utf8_decode($_POST['columnaLumbar'].'_0');
		}
		if (isset($_POST['teledeTorax']))
		{
			$teledeTorax=utf8_decode($_POST['teledeTorax'].'_0');
		}
		/*if (isset($_POST['teleTorxTxt']))
		{
			$teleTorxTxt=utf8_decode($_POST['teleTorxTxt']);
			$teleTorxTxt=addslashes($teleTorxTxt);
		}*/
		if (isset($_POST['toraxOseo']))
		{
			$toraxOseo=utf8_decode($_POST['toraxOseo'].'_0');
		}
		/*if (isset($_POST['toraxOseoTxt']))
		{
			$toraxOseoTxt=utf8_decode($_POST['toraxOseoTxt']);
			$toraxOseoTxt=addslashes($toraxOseoTxt);
		}*/
		if (isset($_POST['esternon']))
		{
			$esternon=utf8_decode($_POST['esternon'].'_0');
		}
		if (isset($_POST['abdomenSimple']))
		{
			$abdomenSimple=utf8_decode($_POST['abdomenSimple'].'_0');
		}
		if (isset($_POST['abdomenSimpTxt']))
		{
			$abdomenSimpTxt=utf8_decode($_POST['abdomenSimpTxt']);
			$abdomenSimpTxt=addslashes($abdomenSimpTxt);
		}
		if (isset($_POST['abdomendePie']))
		{
			$abdomendePie=utf8_decode($_POST['abdomendePie'].'_0');
		}
		if (isset($_POST['abdomenPieTxt']))
		{
			$abdomenPieTxt=utf8_decode($_POST['abdomenPieTxt']);
			$abdomenPieTxt=addslashes($abdomenPieTxt);
		}
		if (isset($_POST['serieGastroDuodenal']))
		{
			$serieGastroDuodenal=utf8_decode($_POST['serieGastroDuodenal'].'_0');
		}
		if (isset($_POST['serieGastroTxt']))
		{
			$serieGastroTxt=utf8_decode($_POST['serieGastroTxt']);
			$serieGastroTxt=addslashes($serieGastroTxt);
		}
		if (isset($_POST['colonporEnema']))
		{
			$colonporEnema=utf8_decode($_POST['colonporEnema'].'_0');
		}
		if (isset($_POST['colonEnemaTxt']))
		{
			$colonEnemaTxt=utf8_decode($_POST['colonEnemaTxt']);
			$colonEnemaTxt=addslashes($colonEnemaTxt);
		}
		if (isset($_POST['transitoIntestinal']))
		{
			$transitoIntestinal=utf8_decode($_POST['transitoIntestinal'].'_0');
		}
		if (isset($_POST['transitoIntesTxt']))
		{
			$transitoIntesTxt=utf8_decode($_POST['transitoIntesTxt']);
			$transitoIntesTxt=addslashes($transitoIntesTxt);
		}
		if (isset($_POST['urografiaExcretora']))
		{
			$urografiaExcretora=utf8_decode($_POST['urografiaExcretora'].'_0');
		}
		if (isset($_POST['urografiaExcrTxt']))
		{
			$urografiaExcrTxt=utf8_decode($_POST['urografiaExcrTxt']);
			$urografiaExcrTxt=addslashes($urografiaExcrTxt);
		}
		if (isset($_POST['cristograma']))
		{
			$cristograma=utf8_decode($_POST['cristograma'].'_0');
		}
		if (isset($_POST['cristogramaTxt']))
		{
			$cristogramaTxt=utf8_decode($_POST['cristogramaTxt']);
			$cristogramaTxt=addslashes($cristogramaTxt);
		}
		if (isset($_POST['perfilograma']))
		{
			$perfilograma=utf8_decode($_POST['perfilograma'].'_0');
		}
		if (isset($_POST['perfilogramaTxt']))
		{
			$perfilogramaTxt=utf8_decode($_POST['perfilogramaTxt']);
			$perfilogramaTxt=addslashes($perfilogramaTxt);
		}
		if (isset($_POST['watters']))
		{
			$watters=utf8_decode($_POST['watters'].'_0');
		}
		if (isset($_POST['wattersTxt']))
		{
			$wattersTxt=utf8_decode($_POST['wattersTxt']);
			$wattersTxt=addslashes($wattersTxt);
		}
		if (isset($_POST['articulacionesTemporamandibulares']))
		{
			$articulacionesTemporamandibulares=utf8_decode($_POST['articulacionesTemporamandibulares'].'_0');
		}
		if (isset($_POST['lateraldeCuello']))
		{
			$lateraldeCuello=utf8_decode($_POST['lateraldeCuello'].'_0');
		}
		if (isset($_POST['edadOsea']))
		{
			$edadOsea=utf8_decode($_POST['edadOsea'].'_0');
		}
		if (isset($_POST['otros']))
		{
			$ot=utf8_decode($_POST['otros'].'_0');
		}
		if (isset($_POST['otrosTxt']))
		{
			$otros=utf8_decode($_POST['otrosTxt']);
			$otros=addslashes($otros);
		}
		if (isset($_POST['nombreMedicoTratante']))
		{
			$nombreMedicoTratante=utf8_decode($_POST['nombreMedicoTratante']);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' '.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		//Insertamos en la tabla de imagen el nombre del estudio(id) y si existe txt complementario
		$queryInsImagen = "INSERT INTO imagenologia (id,numeroExpediente,folio,servicio,turno,datosClinicos,diagnostico,tiroides,mama,higadoVesiculayPancreas,renal,abdominal,uteroOvariosyVejiga,pelvico,
							obstetrico,vejigayProstata,tejidosBlandos,transrectal,transvaginal,carotideoBilateral,carotideoBiTxt,miembroSuperiorUnilateral,miembroSupUniTxt,miembroSuperiorBilateral,miembroSupBiTxt,
							miembroInferiorUnilateral,miembroInfUniTxt,miembroInferiorBilateral,miembroInfBiTxt,higadoHipertensionPortal,higadoPortTxt,regionSimple,regionSimp1Txt,regionContrastada,regionContr1Txt,
							cortesSenosParanasales,craneoSimple,craneoContrastado,oidoAxialyCoronal,urotac,regionesSimples,regionesSimp2Txt,regionesContrastadas,regionesContr2Txt,columna,columnaTxt,craneo,craneoTxt,
							senosParanasales,columnaCervical,columnaDorsal,columnaLumbar,teledeTorax,toraxOseo,esternon,abdomenSimple,abdomenSimpTxt,abdomendePie,abdomenPieTxt,serieGastroDuodenal,serieGastroTxt,
							colonporEnema,colonEnemaTxt,transitoIntestinal,transitoIntesTxt,urografiaExcretora,urografiaExcrTxt,cristograma,cristogramaTxt,perfilograma,perfilogramaTxt,watters,wattersTxt,
							articulacionesTemporamandibulares,lateraldeCuello,edadOsea,otros,otrosTxt,cedula,nombreMedicoTratante,usr)
							VALUES (NULL,'$expediente','$folio','$servicio','$turno','$datosClinicos','$diagnostico','$tiroides','$mama','$higado','$renal','$abdominal','$utero','$pelvico','$obstetrico','$vejiga',
							'$tejidosBlandos','$transRectal','$transVaginal','$carotideoBi','$carotideoBiTxt','$miembroSuperiorUnilateral','$miembroSupUniTxt','$miembroSuperiorBilateral','$miembroSupBiTxt',
							'$miembroInferiorUnilateral','$miembroInfUniTxt','$miembroInferiorBilateral','$miembroInfBiTxt','$higadoHipertensionPortal','$higadoPortTxt','$regionSimple','$regionSimp1Txt',
							'$regionContrastada','$regionContr1Txt','$cortesSenosParanasales','$craneoSimple','$craneoContrastado','$oidoAxialyCoronal','$urotac','$regionesSimples','$regionesSimp2Txt',
							'$regionesContrastadas','$regionesContr2Txt','$columna','$columnaTxt','$craneo','$craneoTxt','$senosParanasales','$columnaCervical','$columnaDorsal','$columnaLumbar','$teledeTorax','$toraxOseo',
							'$esternon','$abdomenSimple','$abdomenSimpTxt','$abdomendePie','$abdomenPieTxt','$serieGastroDuodenal','$serieGastroTxt','$colonporEnema','$colonEnemaTxt','$transitoIntestinal',
							'$transitoIntesTxt','$urografiaExcretora','$urografiaExcrTxt','$cristograma','$cristogramaTxt','$perfilograma','$perfilogramaTxt','$watters','$wattersTxt','$articulacionesTemporamandibulares',
							'$lateraldeCuello','$edadOsea','$ot','$otros','$cedula','$nombreMedicoTratante','$rol')";
		$result0 = mysqli_query($conexionMedico, $queryInsImagen);
		if(!$result0) {
			echo '!<br> ERROR al insertar IMAGENOLOGÍA <br>';
			echo 'QUERY: '.$queryInsImagen;
		} else {
			echo '<br>!!!! SE GUARDO LA SOLICITUD A IMAGENOLOGÍA CORRECTAMENTE !!!!<br>';
			//echo 'QUERY: '.$queryInsImagen;
			
			//Query para jalar el ultimo id insertado que sería el actual
			/*$queryIdImg = "SELECT MAX(id) AS id,tiroides,mama,higado,renal,abdominal,utero,pelvico,obstetrico,vejiga,tejidosBlandos,transRectal,transVaginal,carotideoBi
							FROM imagenologia
						  	WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
						  	LIMIT 1";

			$antec = mysqli_query($conexionMedico, $queryIdImg) or die (mysqli_error($conexionMedico));
			while($rowA = mysqli_fetch_array($antec)){
				$idImagen = $rowA['id'];
				$tiroidesImg = utf8_decode($rowA['tiroides']);
				$mamaImg = utf8_decode($rowA['mama']);
				$higadoImg = utf8_decode($rowA['higado']);
				$renalImg = utf8_decode($rowA['renal']);
				$abdominalImg = utf8_decode($rowA['abdominal']);
				$uteroImg = utf8_decode($rowA['utero']);
				$pelvicoImg = utf8_decode($rowA['pelvico']);
				$obstetricoImg = utf8_decode($rowA['obstetrico']);
				$vejigaImg = utf8_decode($rowA['vejiga']);
				$tejidosBlandosImg = utf8_decode($rowA['tejidosBlandos']);
				$transRectalImg = utf8_decode($rowA['transRectal']);
				$transVaginalImg = utf8_decode($rowA['transVaginal']);
				$carotideoBiImg = utf8_decode($rowA['carotideoBi']);
			}
			
			//Si se guardo correctamente metemos los datos a la tabla de datosimagenologia para saber el estatus del estudio
			$queryInsDImagen = "INSERT INTO datosimagenologia (id,idImagen,estudio,estatus)
							VALUES (NULL,'$idImagen','$folio','$servicio','$turno','$datosClinicos','$diagnostico')";
			$result = mysqli_query($conexionMedico, $queryInsDImagen);
			if(!$result) {
				echo '!<br> ERROR al insertar IMAGENOLOGÍA <br>';
				echo 'QUERY: '.$queryInsDImagen;
			} else {
				echo '<br>!!!! SE GUARDO LA SOLICITUD A IMAGENOLOGÍA CORRECTAMENTE !!!!<br>';
				echo 'QUERY: '.$queryInsDImagen;
			}*/
		}
		
	}
	

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IMAGENOLOGÍA</title>

        <!-- Google Font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<!-- BootStrap Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/bootstrap/css/bootstrap.min.css"-->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
		<!-- Font-Awesome Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/font-awesome/css/font-awesome.min.css"-->
		<link rel="stylesheet" href="./tabs_files/font-awesome.css">
		
		<!-- Plugin Custom Stylesheet -->
		<link rel="stylesheet" href="css/form-wizard-blue.css">
		<link href="css/switcher.css" rel="stylesheet">
		<!--*****
		If you need to change the form color then you have to just change the CSS file name!! Do it very simply, like as "form-wizard-red.css" for make it red color. Our template other colors name is there ( black, blue, red, pink, purple, teal, green, yellow, orange, brown, cyan, lime ). Replace the name and make it awesome!!!
		*****-->	
    </head>

    <body onunload="window.opener.location.reload()">
        <!-- main content -->
        <section class="form-box">
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-5 col-lg-12 col-lg-offset-15 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
						<?php 
							/*$prueba = eliminar_tildes('Hígado - Hipertensión Portal_0');
							$prueba = lcfirst($prueba);
							echo $prueba;*/
							
							/*$charset= 'UTF-8'; //'ISO-8859-1';
							$str=null;
							$str = iconv($charset, 'ASCII//TRANSLIT', 'Hígado, Vesícula y Páncreas');
							echo '   '.$str;*/
							
						?>
                    	<form role="form" action="" method="post">

                    		<h3>IMAGENOLOGÍA</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-3">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="50" data-number-of-steps="3" style="width: 50%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>DATOS</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 4 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>ESTUDIOS</p>
                    			</div>
								<!-- Step 4 -->
                    		</div>
							<!-- Form progress -->
                    		
							
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>DATOS: <span>Paso 1 - 2</span></h4>
								<div class="form-group">
                    			    <label>SERVICIO : <span>*</span></label>
                                    <br>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="UCI" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; UCI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="UCIPyN" style="width: 30px; height: 30px">&nbsp;&nbsp; UCIPyN
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Consulta Externa" style="width: 30px; height: 30px">&nbsp;&nbsp; Consulta Externa
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Urgencias" style="width: 30px; height: 30px" >&nbsp;&nbsp; Urgencias
									</label>
                                    <label class="radio-inline">
									  <input type="radio" name="servicio" value="Hospitalización" style="width: 30px; height: 30px" >&nbsp;&nbsp; Hospitalización
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Transoperatoria" style="width: 30px; height: 30px">&nbsp;&nbsp; Transoperatoria
									</label>
									<label class="radio-inline">
									  <input type="radio" name="servicio" value="Admisión" style="width: 30px; height: 30px">&nbsp;&nbsp; Admisión
									</label>
                                </div>
								<!--div class="form-group">
									<label>FECHA DE LA CIRUGÍA : <span>*</span></label>
									<input type="date" name="fecha" class="form-control required">
								</div-->
								<!--div class="form-group">
									<label>HORA DE LA CIRUGÍA : <span>*</span></label>
									<input type="time" name="hora" class="form-control required" autocomplete="off">
								</div-->
								<div class="form-group">
                    			   <label>TURNO : <span>*</span></label>
                                   <select id="turno" name="turno" class="form-control required">
										<option value="">Seleccione</option>
										<option value="M">Matutino</option>
										<option value="V">Vespertino</option>
										<option value="N">Nocturno</option>
									</select>
								</div>
								
								<div class="form-group">
                    			    <label>DATOS CLÍNICOS Y/O INDICACIONES ESPECIALES: <span>*</span></label>
                                    <textarea class="form-control required" name="datosClinicos" id="datosClinicos" cols="10" rows="3"></textarea>
                                </div>
								<div class="form-group">
									<label>DIAGNÓSTICO : <span>*</span></label>
									<textarea class="form-control required" name="diagnostico" id="diagnostico" cols="10" rows="3"></textarea>
								</div>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->
							<!-- Form Step 4 -->
							<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>ESTUDIOS : <span>Paso 2 - 2</span></h4>
								<div style="clear:both;"></div>
								<div class="form-group">
									<table style="width:100%" border="2px solid black" align="center" >
									<tbody>
										<tr>
											<h5>ULTRASONOGRAFÍA:</h5>
											
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="tiroides" style="width: 45px; height: 35px" value="Tiroides" >
											</td>
											<td>
												Tiroides</label>
											</td>
										
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="mama" style="width: 45px; height: 35px" value="Mama" >
											</td>
											<td>
												<br/>Mama</label>
											</td>
									
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="higadoVesiculayPancreas" style="width: 45px; height: 35px" value="Hígado, Vesícula y Páncreas" >
											</td>
											<td>
												<br/>Hígado, Vesícula y Páncreas</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="renal" style="width: 45px; height: 35px" value="Renal" >
											</td>
											<td>
												<br/>Renal</label>
											</td>
										</tr>

										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="abdominal" style="width: 45px; height: 35px" value="Abdominal" >
											</td>
											<td>
												Abdominal</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="uteroOvariosyVejiga" style="width: 45px; height: 35px" value="Útero, Ovarios y Vejiga" >
											</td>
											<td>
												Útero, Ovarios y Vejiga</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="pelvico" style="width: 45px; height: 35px" value="Pélvico" >
											</td>
											<td>
												Pélvico</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="obstetrico" style="width: 45px; height: 35px" value="Obstétrico" >
											</td>
											<td>
												Obstétrico</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="vejiga" style="width: 45px; height: 35px" value="Vejiga y Prostata" >
											</td>
											<td>
												Vejiga y Prostata</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="tejidosBlandos" style="width: 45px; height: 35px" value="Tejidos Blandos" >
											</td>
											<td>
												Tejidos Blandos</label>
											</td>
												<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="transRectal" style="width: 45px; height: 35px" value="Transrectal" >
											</td>
											<td>
												Transrectal</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="transVaginal" style="width: 45px; height: 35px" value="Transvaginal" >
											</td>
											<td>
												Transvaginal</label>
											</td>
										</tr>
										</tbody>
									</table>
									<br>
									<table style="width:100%" border="2px solid black" align="center" >
									<tbody>
										<tr>
											<h5>DOPPLER COLOR:</h5>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="carotideoBi" style="width: 45px; height: 35px" value="Carotideo Bilateral" >
											</td>
											<td>
												Carotideo Bilateral
												<br>
											<input type="text" name="carotideoBiTxt" >
											</label>
											</td>
										
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="miembroSuperiorUnilateral" style="width: 45px; height: 35px" value="Miembro Superior Unilateral" >
											</td>
											<td>
												Miembro Superior Unilateral
												<br>
												<input type="text" name="miembroSupUniTxt" >
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="miembroSuperiorBilateral" style="width: 45px; height: 35px" value="Miembro Superior Bilateral" >
											</td>
											<td>
												Miembro Superior Bilateral
												<br>
												<input type="text" name="miembroSupBiTxt" >
											</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="miembroInferiorUnilateral" style="width: 45px; height: 35px" value="Miembro Inferior Unilateral" >
											</td>
											<td>
												Miembro Inferior Unilateral
												<br>
												<input type="text" name="miembroInfUniTxt" >
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="miembroInferiorBilateral" style="width: 45px; height: 35px" value="Miembro Inferior Bilateral" >
											</td>
											<td>
												Miembro Inferior Bilateral
												<br>
												<input type="text" name="miembroInfBiTxt" >
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="higadoHipertensionPortal" style="width: 45px; height: 35px" value="Hígado - Hipertensión Portal" >
											</td>
											<td>
												Hígado - Hipertensión Portal
												<br>
												<input type="text" name="higadoPortTxt" >
											</label>
											</td>
										</tr>
									</tbody>
									</table>

									<br>
									<table style="width:100%" border="2px solid black" align="center" >
									<tbody>
										<tr>
											<h5>TOMOGRAFÍA:</h5>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="regionSimple" style="width: 45px; height: 35px" value="1 Región Simple" >
											</td>
											<td>
												1 Región simple
												<br>
											<input type="text" name="regionSimp1Txt" >
											</label>
											</td>
										
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="regionContrastada" style="width: 45px; height: 35px" value="1 Región Contrastada" >
											</td>
											<td>
												1 Región Contrastada
												<br>
												<input type="text" name="regionContr1Txt" >
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="cortesSenosParanasales" style="width: 45px; height: 35px" value="8 Cortes Senos Paranasales" >
											</td>
											<td>
												8 Cortes Senos Paranasales
											</label>
											</td>
										</tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="craneoSimple" style="width: 45px; height: 35px" value="Cráneo Simple" >
											</td>
											<td>
												Cráneo Simple
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="craneoContrastado" style="width: 45px; height: 35px" value="Cráneo Contrastado" >
											</td>
											<td>
												Cráneo contrastado
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="oidoAxialyCoronal" style="width: 45px; height: 35px" value="Oído Axial y Coronal" >
											</td>
											<td>
												Oído Axial y Coronal
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="urotac" style="width: 45px; height: 35px" value="UROTAC" >
											</td>
											<td>
												UROTAC
											</label>
											</td>
										<tr>
									
										</tr>

										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="regionesSimples" style="width: 45px; height: 35px" value="2 Regiones Simples" >
											</td>
											<td>
												2 Regiónes Simple
												<br>
												<input type="text" name="regionesSimp2Txt" >
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="regionesContrastadas" style="width: 45px; height: 35px" value="2 Regiones Contrastadas" >
											</td>
											<td>
												2 Regiónes Contrastada
												<br>
												<input type="text" name="regionesContr2Txt" >
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="columna" style="width: 45px; height: 35px" value="Columna" >
											</td>
											<td>
												Columna
												<br>
												<input type="text" name="columnaTxt" >
											</label>
											</td>
										</tr>
									</tbody>
									</table>
									<br>
									<table style="width:100%" border="2px solid black" align="center">
									<tbody>
										<tr>
											<h5>RADIOLOGÍA (Especificar Ap., Lat.oblicua):</h5>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="craneo" style="width: 45px; height: 35px" value="Cráneo" >
											</td>
											<td>
												Cráneo
												<br>
												<input type="text" name="craneoTxt" >
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="senosParanasales" style="width: 45px; height: 35px" value="Senos Paranasales" >
											</td>
											<td>
												Senos Paranasales
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="columnaCervical" style="width: 45px; height: 35px" value="Columna Cervical" >
											</td>
											<td>
												Columna Cervical
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="columnaDorsal" style="width: 45px; height: 35px" value="Columna Dorsal" >
											</td>
											<td>
												Columna Dorsal
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="columnaLumbar" style="width: 45px; height: 35px" value="Columna Lumbar" >
											</td>
											<td>
												Columna Lumbar
											</label>
											</td>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="teledeTorax" style="width: 45px; height: 35px" value="Tele de Tórax" >
											</td>
											<td>
												Tele de Tórax
												<!--br>
												<input type="text" name="teleTorxTxt" -->
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="toraxOseo" style="width: 45px; height: 35px" value="Tórax Óseo" >
											</td>
											<td>
												Tórax Óseo
												<!--br>
												<input type="text" name="toraxOseoTxt" -->
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="esternon" style="width: 45px; height: 35px" value="Esternón" >
											</td>
											<td>
												Esternón
											</label>
											</td>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="abdomenSimple" style="width: 45px; height: 35px" value="Abdomen Simple" >
											</td>
											<td colspan="3">
												Abdomen Simple
												<br>
												<input type="text" name="abdomenSimpTxt" >
											</label>

										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="abdomendePie" style="width: 45px; height: 35px" value="Abdomen de Pie" >
											</td>
											<td>
												Abdomen de Pie
												<br>
												<input type="text" name="abdomenPieTxt" >
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="serieGastroDuodenal" style="width: 45px; height: 35px" value="Serie Gastro-Duodenal" >
											</td>
											<td>
												Serie Gastro-Duodenal
												<br>
												<input type="text" name="serieGastroTxt" >
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="colonporEnema" style="width: 45px; height: 35px" value="Colon por Enema" >
											</td>
											<td>
												Colon por Enema
												<br>
												<input type="text" name="colonEnemaTxt" >
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="transitoIntestinal" style="width: 45px; height: 35px" value="Transito Intestinal" >
											</td>
											<td colspan="3">
												Transito Intestinal
												<br>
												<input type="text" name="transitoIntesTxt" >
											</label>
										</tr>
										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="urografiaExcretora" style="width: 45px; height: 35px" value="Urografía Excretora" >
											</td>
											<td>
												Urografía Excretora
												<br>
												<input type="text" name="urografiaExcrTxt" >
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="cristograma" style="width: 45px; height: 35px" value="Cristograma" >
											</td>
											<td>
												Cristograma
												<br>
												<input type="text" name="cristogramaTxt" >
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="perfilograma" style="width: 45px; height: 35px" value="Perfilograma" >
											</td>
											<td>
												Perfilograma
												<br>
												<input type="text" name="perfilogramaTxt" >
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="watters" style="width: 45px; height: 35px" value="Watters" >
											</td>
											<td colspan="3">
												Watters
												<br>
												<input type="text" name="wattersTxt" >
											</label>
										</tr>

										<tr>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="articulacionesTemporamandibulares" style="width: 45px; height: 35px" value="Articulaciónes Temporamandibulares" >
											</td>
											<td>
												Articulaciónes Temporamandibulares
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="lateraldeCuello" style="width: 45px; height: 35px" value="Lateral de Cuello" >
											</td>
											<td>
												Lateral de Cuello
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="edadOsea" style="width: 45px; height: 35px" value="Edad Ósea" >
											</td>
											<td>
												Edad Ósea
											</label>
											<label class="checkbox-inline">
											<td>
												<input type="checkbox" name="otros" id="otros"  onchange="mostrarOt()" style="width: 45px; height: 35px" value="Otros" >
											</td>
											<td>
												Otros (Especificar):</label>
											</td>
										</tr>
									</tbody>
									</table>
								</div>
									<div id="otro" style="display:none">
									<div class="form-group" style="height: 100px">
										<textarea class="form-control" name="otrosTxt" id="otrosTxt" cols="10" rows="3"></textarea>
									</div>
								</div>

								<div class="form-group">
									<h4>DATOS DEL MÉDICO TRATANTE:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :</p>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off">
									<br>
									<div id="suggestions1"></div>
								</div>
								<h6>*Si no conoce la cedula del medico tratante colocar el nombre, si ya colocó una cedula no llenar</h6>
								<div class="form-group">
                    			    <label>NOMBRE DEL MEDICO TRATANTE : </label>
                                    <input class="form-control " type="text"  name="nombreMedicoTratante" id="nombreMedicoTratante">
                                </div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>">
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>">
								<input name="folio" type="hidden" value="<?php echo $folio ?>">
                                <div class="form-wizard-buttons">
									<button type="button"  class="btn btn-previous">Anterior</button>
                                    <button id="add_button" type="submit" name="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 4 -->
                    	</form>
						</div>
						<!-- Form Wizard -->
                    </div>
                </div>
            </div>
			<input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 137px; height: 44px" />
			
			<a class="btn btn-primary" href="consultaSolImagen.php?rol=<?php echo $rol ?>&exp=<?php echo trim($expediente) ?>&folio=<?php echo $folio ?>" style="width: 240px; height: 40px" target="_blank"> VER SOLICITUDES </a>
        </section>

		<!-- main content -->

        <!-- Jquery JS -->
        <script src="../js/jquery-1.11.1.min.js"></script>
		<!-- bootStrap JS -->
		<script src="../js/bootstrap.min.js"></script>
		<script type="text/javascript">
		//Funcion para autocomplementar los Medicos
		var id1 = "";
		  $(document).ready(function(e) {
			$('#cedula').bind('input keyup', function(){
				//Obtenemos el value del input
				var cedula = $(this).val();
				var dataString0 = 'cedula='+cedula;
				
				var n = dataString0.length;
				if(n > 10){
					var dataString = dataString0;
				} else {
					var dataString = 'cedula=" "';
				}
				//Le pasamos el valor del input al ajax
				$.ajax({
		            type: "POST",
		            url: "autocompleteDR.php",
		            data: dataString,
		            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
		            //async: false,
		            success: function(data) {
						//Escribimos las sugerencias que nos manda la consulta
						$('#suggestions1').fadeIn(1000).html(data);
						//Al hacer click en alguna de las sugerencias
						$('.suggest-element').on('click', function(){
							//Obtenemos la id unica de la sugerencia pulsada
							id1 = $(this).attr('id1'); //id del Medicamento
							var valor = $(this).attr('data'); //Nombre del Medico
							var especialidad = $(this).attr('especialidad');
							var ced = $(this).attr('ced');
							//var idSal = $(this).attr('idSal');//id de la Sal
							//Editamos el valor del input con data de la sugerencia pulsada
							//$('#service').val($('#'+id).attr('data'));
							valor = valor.trim();
							$('#cedula').val(ced);
							//$('#telCirujano').val(tel);
							//$('#emailCirujano').val(email);
							//Hacemos desaparecer el resto de sugerencias
							$('#suggestions1').fadeOut(1000);
							//Add valor del id del elemento seleccionado
							//$('#idMedic').val(id1);
						});
		            }
		        });
		    });
		});
			function mostrarOt() {
				 element = document.getElementById("otro");
				check = document.getElementById("otros");
				if (check.checked) {
					element.style.display='block';
				} else {
					element.style.display='none';
				}
			}
		</script>
		
		<!-- Plugin Custom JS -->
        <script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script>
        <!-- Plugin Custom JS -->

    </body>

</html>

<?php
	function eliminar_tildes($cadena){

		//Codificamos la cadena en formato utf8 en caso de que nos de errores
		//$cadena = utf8_encode($cadena);

		//Ahora reemplazamos las letras
		$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
		);

		$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

		$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );

		$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );

		$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

		$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç', '-','_'),
			array('n', 'N', 'c', 'C', '', ''),
			$cadena
		);
		
		$cadena = preg_replace("/[^a-zA-Z\_\-]+/", "", $cadena);

		return $cadena;
	}
?>