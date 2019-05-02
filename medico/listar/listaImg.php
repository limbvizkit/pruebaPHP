<?php 
	#Archivo con la conexion para MYSQL
	require_once('../../conexion/configMedico.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../../conexion/funciones_db.php');
	#Configuracion para colocar día y mes en español
	date_default_timezone_set('America/Mexico_City');//America/Mexico_City   UTC
	setlocale(LC_ALL,'');

	$fechaA=date('Y-m-d 00:00:00');
	$fechaB=date('Y-m-d 23:59:00');

	//Query para jalar los estudios solicitados
	$queryEstudios = "SELECT * FROM( SELECT id, numeroExpediente, folio, fechaGuardado, tiroides as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(tiroides) AND tiroides != '' 
						AND CASE WHEN SUBSTR(tiroides, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, mama as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(mama) AND mama != '' 
						AND CASE WHEN SUBSTR(mama, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION
						SELECT id, numeroExpediente, folio, fechaGuardado, higadoVesiculayPancreas as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(higadoVesiculayPancreas) AND higadoVesiculayPancreas != '' 
						AND CASE WHEN SUBSTR(higadoVesiculayPancreas, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, renal as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(renal) AND renal != '' 
						AND CASE WHEN SUBSTR(renal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION
						SELECT id, numeroExpediente, folio, fechaGuardado, abdominal as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(abdominal) AND abdominal != '' 
						AND CASE WHEN SUBSTR(abdominal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, uteroOvariosyVejiga as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(uteroOvariosyVejiga) AND uteroOvariosyVejiga != '' 
						AND CASE WHEN SUBSTR(uteroOvariosyVejiga, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION
						SELECT id, numeroExpediente, folio, fechaGuardado, pelvico as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(pelvico) AND pelvico != '' 
						AND CASE WHEN SUBSTR(pelvico, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, obstetrico as estudio, '' FROM imagenologia WHERE NOT ISNULL(obstetrico) AND obstetrico != '' 
						AND CASE WHEN SUBSTR(obstetrico, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION
						SELECT id, numeroExpediente, folio, fechaGuardado, vejigayProstata as estudio, '' FROM imagenologia WHERE NOT ISNULL(vejigayProstata) AND vejigayProstata != '' 
						AND CASE WHEN SUBSTR(vejigayProstata, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, tejidosBlandos as estudio, '' FROM imagenologia WHERE NOT ISNULL(tejidosBlandos) AND tejidosBlandos != '' 
						AND CASE WHEN SUBSTR(tejidosBlandos, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION
						SELECT id, numeroExpediente, folio, fechaGuardado, transrectal as estudio, '' FROM imagenologia WHERE NOT ISNULL(transrectal) AND transrectal != '' 
						AND CASE WHEN SUBSTR(transrectal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, transvaginal as estudio, '' FROM imagenologia WHERE NOT ISNULL(transvaginal) AND transvaginal != '' 
						AND CASE WHEN SUBSTR(transvaginal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, carotideoBilateral as estudio, carotideoBiTxt AS txt FROM imagenologia WHERE NOT ISNULL(carotideoBilateral) AND carotideoBilateral != '' 
						AND CASE WHEN SUBSTR(carotideoBilateral, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, miembroSuperiorUnilateral as estudio, miembroSupUniTxt AS txt FROM imagenologia WHERE NOT ISNULL(miembroSuperiorUnilateral) AND miembroSuperiorUnilateral != '' 
						AND CASE WHEN SUBSTR(miembroSuperiorUnilateral, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, miembroSuperiorBilateral as estudio, miembroSupBiTxt AS txt FROM imagenologia WHERE NOT ISNULL(miembroSuperiorBilateral) AND miembroSuperiorBilateral != '' 
						AND CASE WHEN SUBSTR(miembroSuperiorBilateral, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, miembroInferiorUnilateral as estudio, miembroInfUniTxt AS txt FROM imagenologia WHERE NOT ISNULL(miembroInferiorUnilateral) AND miembroInferiorUnilateral != '' 
						AND CASE WHEN SUBSTR(miembroInferiorUnilateral, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, miembroInferiorBilateral as estudio, miembroInfBiTxt AS txt FROM imagenologia WHERE NOT ISNULL(miembroInferiorBilateral) AND miembroInferiorBilateral != '' 
						AND CASE WHEN SUBSTR(miembroInferiorBilateral, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, higadoHipertensionPortal as estudio, higadoPortTxt AS txt FROM imagenologia WHERE NOT ISNULL(higadoHipertensionPortal) AND higadoHipertensionPortal != '' 
						AND CASE WHEN SUBSTR(higadoHipertensionPortal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, regionSimple as estudio, regionSimp1Txt AS txt FROM imagenologia WHERE NOT ISNULL(regionSimple) AND regionSimple != '' 
						AND CASE WHEN SUBSTR(regionSimple, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, regionContrastada as estudio, regionContr1Txt AS txt FROM imagenologia WHERE NOT ISNULL(regionContrastada) AND regionContrastada != '' 
						AND CASE WHEN SUBSTR(regionContrastada, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, cortesSenosParanasales as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(cortesSenosParanasales) AND cortesSenosParanasales != '' 
						AND CASE WHEN SUBSTR(cortesSenosParanasales, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, craneoSimple as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(craneoSimple) AND craneoSimple != '' 
						AND CASE WHEN SUBSTR(craneoSimple, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, craneoContrastado as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(craneoContrastado) AND craneoContrastado != '' 
						AND CASE WHEN SUBSTR(craneoContrastado, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, oidoAxialyCoronal as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(oidoAxialyCoronal) AND oidoAxialyCoronal != '' 
						AND CASE WHEN SUBSTR(oidoAxialyCoronal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, urotac as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(urotac) AND urotac != '' 
						AND CASE WHEN SUBSTR(urotac, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, regionesSimples as estudio, regionesSimp2Txt AS txt FROM imagenologia WHERE NOT ISNULL(regionesSimples) AND regionesSimples != '' 
						AND CASE WHEN SUBSTR(regionesSimples, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, regionesContrastadas as estudio, regionesContr2Txt AS txt FROM imagenologia WHERE NOT ISNULL(regionesContrastadas) AND regionesContrastadas != '' 
						AND CASE WHEN SUBSTR(regionesContrastadas, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, columna as estudio, columnaTxt AS txt FROM imagenologia WHERE NOT ISNULL(columna) AND columna != '' 
						AND CASE WHEN SUBSTR(columna, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, craneo as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(craneo) AND craneo != '' 
						AND CASE WHEN SUBSTR(craneo, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, senosParanasales as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(senosParanasales) AND senosParanasales != '' 
						AND CASE WHEN SUBSTR(senosParanasales, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, columnaCervical as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(columnaCervical) AND columnaCervical != '' 
						AND CASE WHEN SUBSTR(columnaCervical, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, columnaDorsal as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(columnaDorsal) AND columnaDorsal != '' 
						AND CASE WHEN SUBSTR(columnaDorsal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, columnaLumbar as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(columnaLumbar) AND columnaLumbar != '' 
						AND CASE WHEN SUBSTR(columnaLumbar, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, teledeTorax as estudio, teleTorxTxt AS txt FROM imagenologia WHERE NOT ISNULL(teledeTorax) AND teledeTorax != '' 
						AND CASE WHEN SUBSTR(teledeTorax, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, toraxOseo as estudio, toraxOseoTxt AS txt FROM imagenologia WHERE NOT ISNULL(toraxOseo) AND toraxOseo != '' 
						AND CASE WHEN SUBSTR(toraxOseo, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, esternon as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(esternon) AND esternon != '' 
						AND CASE WHEN SUBSTR(esternon, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, abdomenSimple as estudio, abdomenSimpTxt AS txt FROM imagenologia WHERE NOT ISNULL(abdomenSimple) AND abdomenSimple != '' 
						AND CASE WHEN SUBSTR(abdomenSimple, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, abdomendePie as estudio, abdomenPieTxt AS txt FROM imagenologia WHERE NOT ISNULL(abdomendePie) AND abdomendePie != '' 
						AND CASE WHEN SUBSTR(abdomendePie, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, serieGastroDuodenal as estudio, serieGastroTxt AS txt FROM imagenologia WHERE NOT ISNULL(serieGastroDuodenal) AND serieGastroDuodenal != '' 
						AND CASE WHEN SUBSTR(serieGastroDuodenal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, colonporEnema as estudio, colonEnemaTxt AS txt FROM imagenologia WHERE NOT ISNULL(colonporEnema) AND colonporEnema != '' 
						AND CASE WHEN SUBSTR(colonporEnema, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, transitoIntestinal as estudio, transitoIntesTxt AS txt FROM imagenologia WHERE NOT ISNULL(transitoIntestinal) AND transitoIntestinal != '' 
						AND CASE WHEN SUBSTR(transitoIntestinal, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, urografiaExcretora as estudio, urografiaExcrTxt AS txt FROM imagenologia WHERE NOT ISNULL(urografiaExcretora) AND urografiaExcretora != '' 
						AND CASE WHEN SUBSTR(urografiaExcretora, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, toraxOseo as estudio, toraxOseoTxt AS txt FROM imagenologia WHERE NOT ISNULL(toraxOseo) AND toraxOseo != '' 
						AND CASE WHEN SUBSTR(toraxOseo, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, cristograma as estudio, cristogramaTxt AS txt FROM imagenologia WHERE NOT ISNULL(cristograma) AND cristograma != '' 
						AND CASE WHEN SUBSTR(cristograma, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, perfilograma as estudio, perfilogramaTxt AS txt FROM imagenologia WHERE NOT ISNULL(perfilograma) AND perfilograma != '' 
						AND CASE WHEN SUBSTR(perfilograma, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, watters as estudio, wattersTxt AS txt FROM imagenologia WHERE NOT ISNULL(watters) AND watters != '' 
						AND CASE WHEN SUBSTR(watters, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, articulacionesTemporamandibulares as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(articulacionesTemporamandibulares) AND articulacionesTemporamandibulares != '' 
						AND CASE WHEN SUBSTR(articulacionesTemporamandibulares, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, lateraldeCuello as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(lateraldeCuello) AND lateraldeCuello != '' 
						AND CASE WHEN SUBSTR(lateraldeCuello, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, edadOsea as estudio, '' AS txt FROM imagenologia WHERE NOT ISNULL(edadOsea) AND edadOsea != '' 
						AND CASE WHEN SUBSTR(edadOsea, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						UNION 
						SELECT id, numeroExpediente, folio, fechaGuardado, ot as estudio, otros AS txt FROM imagenologia WHERE NOT ISNULL(ot) AND ot != '' 
						AND CASE WHEN SUBSTR(ot, -1) = '1' THEN fechaGuardado BETWEEN '$fechaA' AND '$fechaB' ELSE fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 3 DAY) AND NOW() END
						
					) AS T ORDER BY fechaGuardado;";

	$estudios = mysqli_query($conexionMedico, $queryEstudios) or die (mysqli_error($conexionMedico));
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../css/datatables.min.css">
	<script type="text/javascript" src="../../js/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
				$('#simple').dataTable({
					"language": {
						"lengthMenu": "Mostrar _MENU_ Filas",
						"zeroRecords": "Sin Resultados - Intente otra frase",
						"info": "Página _PAGE_ de _PAGES_ <br> TOTAL DE NOTAS _MAX_",
						"infoEmpty": "Sin Tomas",
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
	<script type="text/jscript" src="../../js/bootstrap.min.js" ></script>
	<link rel="stylesheet" href="../../css/tabAz.css" />
	<link rel="stylesheet" href="../../css/bootstrap.min.css" />
    
<style type="text/css">
	/* Datagrid */
	*{
		box-sizing: border-box;
	}
	.menu {
    width: 50%;
    float: right;
    padding-left:  15px;
    
	}
	.main {
    width: 100%;
    float: left;
    padding: 15px;
    
	}
	body {
		text-align: center;
   		background-color: #E8F0FE;
    	font-family: Helvetica,Arial,sans-serif;
  		 	
		}
	table {
	float:left;
	width: 50%;
  	box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  	font-size: 15px;
	  
	}
	.table > thead > tr > th,
	.table > tbody > tr > th,
	.table > tfoot > tr > th,
	.table > thead > tr > td,
	.table > tbody > tr > td,
	.table > tfoot > tr > td {
  	padding: 4px;
  	line-height: 1.42857143;
  	vertical-align: top;
  	border-top: 1px solid #ddd;
}

	th, td {
  	padding: 0.25rem;
  	text-align: center;
  	/*min-width: 40px;
  	max-width: auto;*/
	  	
	}
	/*lo de la tabla*/
	.centro{
  	padding: 0.5rem;
  	background: #4285F4 ;
  	color: white;
  	text-align: center;
	  font-size: 21px;

	}
	video{
		padding-left: 25px;
		padding-top: 10px;
		
	}
	label{
		visibility: hidden;
	}
	#cajon1{
		float:left;
		width: 50%;
		background:#F8F8F8;
	}
	#cajon2{
		float:right;
		width: 50%;
		background:#F8F8F8;

	}
	#cajon3{
		clear: both;
		background: #F8F8F8;
	}
	#cuadro{
		width: 90%;
		height: 100%;
		background-image:url('../../img/logoNew2.jpg') ;
		padding: 10px;
		margin: 5px auto;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	
	}
	#titulo{
		float:left;
		width: 100%;
		background: #4285F4;
		color:white;

	}
	.auto-style3 {
		border-left: 1px solid #FFFFFF;
		border-right: 1px solid #FFFFFF;
		border-top-color: #FFFFFF;
		border-bottom: 1px solid #FFFFFF;
	}
	.auto-style4 {
		border-left: 1px solid #D4D4D4;
		border-right: 1px solid #D4D4D4;
		border-top-width: 2px;
		border-bottom: 1px solid #D4D4D4;
		border-top-color: #D4D4D4;
		background-color: #FFFFFF;
	}
	.auto-style5 {
		border-left: 1px solid #D4D4D4;
		border-right: 1px solid #D4D4D4;
		border-top-width: 2px;
		border-bottom: 1px solid #D4D4D4;
		border-top-color: #D4D4D4;
		background-color: limegreen;
	}
	.auto-style6 {
		border-left: 1px solid #D4D4D4;
		border-right: 1px solid #D4D4D4;
		border-top-width: 2px;
		border-bottom: 1px solid #D4D4D4;
		border-top-color: #D4D4D4;
		background-color:#F03437;
	}
</style>
	<title>Hospital Henri Dunant</title>
</head>
<body style="background-image: url(../../img/logoNew2Agua.jpg)">
<center>
	<div class="in" id="cuadro">
		&nbsp;<div id="titulo">
		<h1>SOLICITUDES PARA IMAGENOLOGÍA</h1>
		<script type="text/javascript">
			function makeArray() {
				for (i = 0; i<makeArray.arguments.length; i++)
					this[i + 1] = makeArray.arguments[i];
			}
			var months = new makeArray('Enero','Febrero','Marzo','Abril','Mayo',
			'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			var date = new Date();
			var day = date.getDate();
			var month = date.getMonth() + 1;
			var yy = date.getYear();
			var year = (yy < 1000) ? yy + 1900 : yy;
			document.write("Hoy es "+ day + " de " + months[month] + " del " + year);
		</script>
		</div>
		<table id="simple" class="display">
			<thead>
				<tr class="centro">
				    <td class="auto-style3">No.</td>
					<td class="auto-style3">No. EXP.</td>
					<td class="auto-style3">FOLIO</td>
					<td class="auto-style3">NOMBRE</td>
					<td class="auto-style3">SOLICITUD</td>
					<td class="auto-style3">ESTUDIO</td>
					<td class="auto-style3">TEXTO COMPLEMENTARIO</td>
				</tr>
			</thead>
			<tbody>
			 <?php $c=1; ?>
				<?php while($rowA = mysqli_fetch_array($estudios)){
						$subSTR = substr($rowA['estudio'],-1);
						if($subSTR == '0'){
							$color='auto-style6';
						} else {
							$color='auto-style5';
						}
					$expediente = $rowA['numeroExpediente'];
					$folio = $rowA['folio'];
					$usuario1 = new FuncionesDB();
					#La funcion retorna un arreglo lo mandamos a una variable
					$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
					$nombre_pac = $resultado[0][0]['NOMBRE'];
				?>
					<tr>
						<td class=<?php echo $color?> >
						<strong><?php echo $c++ ?>
						</strong>
						</td>							
						<td class=<?php echo $color?>>
							<strong>
							<?php echo $rowA['numeroExpediente']?>
							</strong>
						</td>
						<td class=<?php echo $color?> >
							<strong>
							<?php echo $rowA['folio']?>
							</strong>
						</td>
						<td class=<?php echo $color?> >
							<strong>
							<?php echo $nombre_pac; ?>
							</strong>
						</td>
						<td class=<?php echo $color?> >
							<strong>
							<?php //echo substr($rowA['fechaGuardado'],0,-3) 
								$newDate = new DateTime ($rowA['fechaGuardado']);
								$newDate = $newDate->format('d/m/Y H:i').'Hrs';
								echo $newDate;
								?>
							</strong>
						</td>
						<td class=<?php echo $color?> >
							<strong>
							<?php echo utf8_encode(substr($rowA['estudio'],0,-2)) ?>
							</strong>
						</td>
						<td class=<?php echo $color?> >
							<strong>
							<?php echo utf8_encode($rowA['txt'])?>
							</strong>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<!--img alt="sesion" src="sesion.png" height="450" width="724" -->
		<!--/div-->
	</div>
	<br>
	<h3 ><font color="gray"><strong> Henri Dunant </strong></font></h3>
</center>
</body>
</html>
