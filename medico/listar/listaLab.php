<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="refresh" content="60"; URL=listaImg.php >
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
	.auto-style7 {
		border-left: 1px solid #D4D4D4;
		border-right: 1px solid #D4D4D4;
		border-top-width: 2px;
		border-bottom: 1px solid #D4D4D4;
		border-top-color: #D4D4D4;
		background-color:cornflowerblue;
	}
</style>
	<title>Hospital Henri Dunant</title>
</head>
	

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
	$queryEstudios = "SELECT * FROM laboratorio where fechaGuardado BETWEEN date_sub(NOW(), INTERVAL 5 DAY) AND NOW() ORDER BY fechaGuardado;";

	$estudios = mysqli_query($conexionMedico, $queryEstudios) or die (mysqli_error($conexionMedico));
	
 ?>


<body style="background-image: url(../../img/logoNew2Agua.jpg)">
<center>
	<div class="in" id="cuadro">
		&nbsp;<div id="titulo">
		<h1>SOLICITUDES PARA LABORATORIO</h1>
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
		<table id="simple">
			<thead>
				<tr class="centro">
				    <td class="auto-style3">No.</td>
					<td class="auto-style3">No. EXP.</td>
					<td class="auto-style3">FOLIO</td>
					<td class="auto-style3">NOMBRE</td>
					<td class="auto-style3">SOLICITUD</td>
					<td class="auto-style3">SERVICIO</td>
					<td class="auto-style3">ESTUDIO(S)</td>
					<!--td class="auto-style3">DIAGNÓSTICO</td-->
					<td class="auto-style3">OPCIONES</td>
				</tr>
			</thead>
			<tbody>
			 <?php $c=0; ?>
				<?php while($rowA = mysqli_fetch_array($estudios)){
						$c=$c+1;
						 
					$expediente = $rowA['numeroExpediente'];
					$folio = $rowA['folio'];
					$usuario1 = new FuncionesDB();
					$nombre_pac = NULL;
					$resultado = array();
					#La funcion retorna un arreglo lo mandamos a una variable
					$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
					$nombre_pac = $resultado[0][0]['NOMBRE'];
					$queryArea = "SELECT * FROM datosdocslab WHERE expediente = '$expediente' AND folio = '$folio'";
					$ar = mysqli_query($conexionMedico, $queryArea);
					$area = mysqli_fetch_array($ar);
					//$subSTR = substr($rowA['estatus'],-1);
						if($area != NULL && $area != ''){
							$color='auto-style5';
						} 
	 					if($area == NULL || $area == ''){
							$color='auto-style6';
						} 
						/*if($subSTR == '2'){
							$color='auto-style7';
						}*/
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
							<?php echo utf8_encode($rowA['servicio']) ?>
							</strong>
						</td>
						<td class=<?php echo $color?> >
							<strong>
							<pre><?php echo utf8_encode($rowA['examenes']) ?></pre>
							</strong>
						</td>
						<!--td class=<?php //echo $color?> >
							<strong>
							<pre><?php //echo utf8_encode($rowA['diagnostico'])?></pre>
							</strong>
						</td-->
						<td>
							<input type="button" value="Subir Resultado(s)" class="btn btn-primary" onClick=window.open("../../laboratorio/guardarDoc.php?expediente=<?php echo $rowA['numeroExpediente'] ?>&folio=<?php echo $rowA['folio'] ?>&rol=lab") >
							<?php 
								//$areaFin = $area[0];
								if($area != NULL && $area != ''){ ?>
							<input type="button" value="Ver Resultado(s)" class="btn btn-success" onClick=window.open("../../laboratorio/visorEstudios.php?expediente=<?php echo $rowA['numeroExpediente'] ?>&folio=<?php echo 
							$rowA['folio'] ?>&rol=lab") >
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		&nbsp;&nbsp;<input type="image" src="../../img/regresa.png" value="REGRESAR" onclick=location.href="../../index.html" height="90" width="160"/>
		<!--img alt="sesion" src="sesion.png" height="450" width="724" -->
		<!--/div-->
	</div>
	<br>
	<h3 ><font color="gray"><strong> Henri Dunant </strong></font></h3>
</center>
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
