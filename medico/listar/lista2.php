<?php 
	#Archivo con la conexion para MYSQL
	require_once('../../conexion/configMedico.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../../conexion/funciones_db.php');
	#Configuracion para colocar día y mes en español
	date_default_timezone_set('America/Mexico_City');//America/Mexico_City   UTC
	setlocale(LC_ALL,'');
	
	$fechaA=date('Y-m-d');
	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
	$usuario1 = new FuncionesDB();
	#La funcion retorna un arreglo lo mandamos a una variable
	$resultado[] = $usuario1->listaConsulta($fechaA);
	#El arreglo esta vacio 
	if (!empty($resultado[0])) {
		$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	}
	#echo 'NOMBREEEEEE: '.$nombre_pac;

	//$resultado=$mysqli->query($query);
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="refresh" content="60"; URL=lista2.php >
    <script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../css/datatables.min.css" >
	<script type="text/javascript" src="../../js/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#simple').dataTable({
				"pageLength": "20",
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
		background-color:mediumturquoise;
	}
</style>
	<title>Hospital Henri Dunant</title>
</head>
<body style="background-image: url(../../img/logoNew2Agua.jpg)">
<center>
	<div class="in" id="cuadro">
		&nbsp;<div id="titulo">
		<h1>PACIENTES REGISTRADOS PARA CONSULTA</h1>
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
		<b><p>No Atendido</p> <p class="auto-style5"> Atendido </p> <p class="auto-style6"> Ingresó a Triage </p></b>
		<table id="simple">
			<thead>
				<tr class="centro">
				    <td class="auto-style3">No.</td>
					<!--td class="auto-style3">Hora</td-->
					<td class="auto-style3">EXPEDIENTE</td>
					<td class="auto-style3">FOLIO</td>
					<td class="auto-style3">NOMBRE DEL PACIENTE</td>
					<td class="auto-style3">HORA DE INGRESO</td>
				</tr>
			</thead>
			<tbody>
			 <?php $c=1; ?>
				<?php for($r=0;$r<count($resultado[0]);$r++){
					$turnoFin = NULL;
					$turnoFin1 = NULL;
					$fechaFin  = NULL;
					$expediente = $resultado[0][$r]['NO_EXP_PAC'];
					$folio = $resultado[0][$r]['FOLIO_PAC'];
					$pasa= FALSE;
					$triage=FALSE;
	
					$queryAntec = "SELECT *
								  FROM notaUrgchoque
								  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
								  LIMIT 1";
					//echo '01: '.$queryAntec;
					$antec = mysqli_query($conexionMedico, $queryAntec) or die (mysqli_error($conexionMedico));
					while($rowA = mysqli_fetch_array($antec)){
						$turnoFin=$rowA['turno'];
						//$fechaFin =substr($rowA['fecha'],0,10);
						$pasa=TRUE;
						//echo '1: '.$queryAntec;
					}
	
					if($turnoFin== NULL || $turnoFin == ''){
						$queryAntec1 = "SELECT *
								  FROM notaUrg
								  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
								  LIMIT 1";
						$antec1 = mysqli_query($conexionMedico, $queryAntec1) or die (mysqli_error($conexionMedico));
						while($rowB = mysqli_fetch_array($antec1)) {
							$turnoFin1=$rowB['turno'];
							//$fechaFin =substr($rowA['fecha'],0,10);
							$pasa=TRUE;
							//echo '2: '.$queryAntec;
						}
					}
	
					if($turnoFin1 == NULL || $turnoFin1 == ''){
						$queryAntec2 = "SELECT *
								  FROM notaurgtriage
								  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
								  LIMIT 1";
						$antec2 = mysqli_query($conexionMedico, $queryAntec2) or die (mysqli_error($conexionMedico));
						while($rowC = mysqli_fetch_array($antec2)) {							
							$turnoFin=$rowC['turno'];
							//$fechaFin =substr($rowA['fecha'],0,10);
							$pasa=TRUE;
							$triage=TRUE;
							//echo '2: '.$queryAntec;
						}
					}
					if($pasa){
						$color='auto-style5';
					} else {
						$color='auto-style4';
					}
	
					if($triage && $rowA == NULL && $rowB == NULL ){
						$color='auto-style6';
					}
				?>
					<tr>
						<td class=<?php echo $color?>>
						<strong><?php echo $c++ ?>
						</strong>
						</td>							
						<td class=<?php echo $color?>>
							<strong>
							<?php echo $resultado[0][$r]['NO_EXP_PAC']?>
							</strong>
						</td>
						<td class=<?php echo $color?>>
							<strong>
							<?php echo $resultado[0][$r]['FOLIO_PAC']?>
							</strong>
						</td>
						<td class=<?php echo $color?>>
							<strong>
							<?php echo $resultado[0][$r]['NOMBRE']?>
							</strong>
						</td>
						<td class=<?php echo $color?>>
							<strong>
							<?php $newDate =$resultado[0][$r]['HR_ING_PAC'];
								$newDate = $newDate->format('H:i');
								echo $newDate.' hrs';?>
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
