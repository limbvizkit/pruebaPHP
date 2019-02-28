<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL  	
	require_once('../conexion/configMedico.php');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_GET['exp']))
	{
		$expediente=$_GET['exp'];
	}
	if (isset($_GET['folio']))
	{
		$folio=$_GET['folio'];
	}
	$queryDocs = "SELECT *
			  FROM historiaclinica
			  WHERE numeroExpediente='$expediente' AND folio='$folio' AND estatus='1'
			  ORDER BY fecha, hora";
	$docs = mysqli_query($conexionMedico, $queryDocs) or die (mysqli_error($conexionMedico));
	$c=1;
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CONSULTA HISTORIA CLÍNICA</title>
        <!-- Google Font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<!-- BootStrap Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/bootstrap/css/bootstrap.min.css"-->
		<!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" >
		<!-- Font-Awesome Stylesheet -->
        <!--link rel="stylesheet" href="assets/external/font-awesome/css/font-awesome.min.css"-->
		<!--link rel="stylesheet" href="./tabs_files/font-awesome.css"-->
		
		<!-- Plugin Custom Stylesheet -->
		<link rel="stylesheet" href="css/form-wizard-blue.css">
		<link href="css/switcher.css" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css">

		<!--*****
		If you need to change the form color then you have to just change the CSS file name!! Do it very simply, like as "form-wizard-red.css" for make it red color. Our template other colors name is there ( black, blue, red, pink, purple, teal, green, yellow, orange, brown, cyan, lime ). Replace the name and make it awesome!!!*****-->
    </head>
    <body>		
        <!-- main content -->
        <section class="form-box">
            <div class="container">
                <!--div class="row"-->
                    <!--div class="col-sm-20"-->
						<!-- Form Wizard -->
						<!--div class="form-wizard form-header-stylist form-body-stylist"-->
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
							<h1>HISTORIA CLÍNICA</h1>
							<span>*Si desea ver todos los campos, modificar o borrar un registro dar click cobre el</span>
						<table id="simple" class="display">
							<thead>
								<tr>
									<th >No.</th>
									<th style="display: none">ID</th>
									<th>FECHA</th>
									<th>HORA</th>
									<th>Tipo de Interrogatorio</th>
									<th>Antecedentes Heredo Familiares</th>
									<th style="display: none">1</th>
									<th style="display: none">2</th>
									<th style="display: none">3</th>
									<th style="display: none">4</th>
									<th style="display: none">5</th>
									<th style="display: none">6</th>
									<th style="display: none">7</th>
									<th style="display: none">8</th>
									<th style="display: none">9</th>
									<th style="display: none">10</th>
									<th style="display: none">11</th>
									<th style="display: none">12</th>
									<th style="display: none">13</th>
									<th style="display: none">14</th>
									<th style="display: none">15</th>
									<th style="display: none">16</th>
									<th style="display: none">17</th>
									<th style="display: none">18</th>
								</tr>
							</thead>
							<tbody>
								<?php
									while($row = mysqli_fetch_array($docs)){
										$fecha = strtotime($row['fecha']);
										$fechaFin = date('d/m/Y',$fecha);
										
										$fecha1 = strtotime($row['fecha']);
										$fechaFin1 = date('Y-m-d',$fecha1);
										
										$hora = strtotime($row['hora']);
										$horaFin = date('H:i',$hora);
								?>
								<tr id="nota">
									<td><?php echo $c++ ?></td>
									<td style="display: none"><?php echo $row['id'] ?></td>
									<td><?php echo $fechaFin ?></td>
									<td><?php echo $horaFin.'hrs' ?></td>
									<td ><?php echo $row['tipoInterroga'] ?></td>
									<td><?php echo utf8_encode($row['antecedentesHeredo']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['edoCivil']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['ocupacion']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['lugarOrigen']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['escolaridad']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['religion']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['grupoRH']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['habitacion']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['habitos']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['alimentacion']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['actividadFisica']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['inmunizaciones']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['antecedentesPatologicos']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['conciliacionMedicamentos']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['antecedentesGineco']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['antecedentesPediatricos']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['padecimientoActual']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['sintomas']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['respiratorio']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['musculoEsquele']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['digestivo']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['genital']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['endocrino']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['nervioso']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['hematologico']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['psicologico']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['urinario']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['cardiocirculatorio']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['pielFaneras']) ?></td>
									<td style="display: none"><?php echo $row['fc'] ?></td>
									<td style="display: none"><?php echo $row['fr'] ?></td>
									<td style="display: none"><?php echo $row['ta'] ?></td>
									<td style="display: none"><?php echo $row['temp'] ?></td>
									<td style="display: none"><?php echo $row['so'] ?></td>
									<td style="display: none"><?php echo $row['glucosa'] ?></td>
									<td style="display: none"><?php echo $row['peso'] ?></td>
									<td style="display: none"><?php echo $row['talla'] ?></td>
									<td style="display: none"><?php echo utf8_encode($row['habExt']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['cabeza']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['cuello']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['abdomen']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['extremidades']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['genitales']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['neurologico']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['pielFaneras2']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['columnavertebral']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['estudiosGabinete']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['terapeutica']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['criteriosEspecializadas']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['educacionEspecial']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['gestionEquipo']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['procesosAdmin']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['diagnostico']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['pronosticoVida']) ?></td>
									<td style="display: none"><?php echo utf8_encode($row['pronosticoFuncion']) ?></td>
									<td style="display: none"><?php echo $row['cedula'] ?></td>
									<td style="display: none"><?php echo $fechaFin1 ?></td>
									<td style="display: none"><?php echo $row['hora'] ?></td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
						<!--/div-->
						<!-- Form Wizard -->
                    <!--/div-->
					<div class="div_User" id="div_User"></div>
                <!--/div-->
            </div>
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-primary" value="RECARGAR LISTADO" onclick ="location.reload()" style="width: 200px; height: 61px"/>
			<!--form action="excel.php" method = "post">
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><span class="auto-style7">HISTORICO TEMPERATURA EN EXCEL 
			<br/></span> <br/>
			&nbsp;&nbsp;<span class="auto-style7">DEL&nbsp; </span>
			&nbsp;<input type="date" name="fecha1" style="height: 40px" required/>
			<span class="auto-style7">&nbsp;&nbsp;&nbsp;&nbsp;AL&nbsp;</span>&nbsp;
			<input type="date" name="fecha2" style="height: 40px" required /></strong>
			<br/>
			<br/>
			<input type="hidden" name="nombre" value="MedicionesTemperatura" />
			&nbsp;&nbsp;<input id="btPerfilFT" class="btn-success" type="submit" value = "EXCEL" style="height: 50px; width: 303px" />
			<br/>
			</form-->
			<br/>
			<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-danger" type="button" value="CERRAR" onClick="window.close()" style="width: 200px; height: 61px" />
        </section>

		<!-- main content -->

        <!-- Jquery JS -->
        <!--script src="../js/jquery-1.11.1.min.js"></script-->
		<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
		
		<!-- bootStrap JS -->
		<script src="../js/bootstrap.min.js"></script>
		
		<!-- Plugin Custom JS -->
        <!--script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script-->
        <!-- Plugin Custom JS -->
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
          		$("#div_User").hide();
        	});
			
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
			 //Evaluamos los clic en los registros
			$(document).ready(function() {
			  //$('#tblUser tbody tr').live('click', function () {
			  $('#simple').on('click', '#nota', function () {
					//var sTitle;
				var nTds = $('td', this);
				idHistClin = $(nTds[1]).text();
				fecha = $(nTds[2]).text();
				hora = $(nTds[3]).text();
				tipoInterroga  = $(nTds[4]).text();
				antecedentesHeredo  = $(nTds[5]).text();
				edoCivil  = $(nTds[6]).text();
				ocupacion  = $(nTds[7]).text();
				lugarOrigen  = $(nTds[8]).text();
				escolaridad  = $(nTds[9]).text();
				religion  = $(nTds[10]).text();
				grupoRH  = $(nTds[11]).text();
				habitacion  = $(nTds[12]).text();
				habitos  = $(nTds[13]).text();
				alimentacion  = $(nTds[14]).text();
				actividadFisica  = $(nTds[15]).text();
				inmunizaciones  = $(nTds[16]).text();
				antecedentesPatologicos  = $(nTds[17]).text();
				conciliacionMedicamentos  = $(nTds[18]).text();
				antecedentesGineco  = $(nTds[19]).text();
				antecedentesPediatricos  = $(nTds[20]).text();
				padecimientoActual  = $(nTds[21]).text();
				sintomas  = $(nTds[22]).text();
				respiratorio  = $(nTds[23]).text();
				musculoEsquele  = $(nTds[24]).text();
				digestivo  = $(nTds[25]).text();
				genital  = $(nTds[26]).text();
				endocrino  = $(nTds[27]).text();
				nervioso  = $(nTds[28]).text();
				hematologico  = $(nTds[29]).text();
				psicologico  = $(nTds[30]).text();
				urinario  = $(nTds[31]).text();
				cardiocirculatorio  = $(nTds[32]).text();
				pielFaneras  = $(nTds[33]).text();
				fc  = $(nTds[34]).text();
				fr  = $(nTds[35]).text();
				ta  = $(nTds[36]).text();
				temp  = $(nTds[37]).text();
				so  = $(nTds[38]).text();
				glucosa  = $(nTds[39]).text();
				peso  = $(nTds[40]).text();
				talla  = $(nTds[41]).text();
				habEx  = $(nTds[42]).text();
				cabeza  = $(nTds[43]).text();
				cuello  = $(nTds[44]).text();
				abdomen  = $(nTds[45]).text();
				extremidades  = $(nTds[46]).text();
				genitales = $(nTds[47]).text();
				neurologico = $(nTds[48]).text();
				pielFaneras2 = $(nTds[49]).text();
				columnavertebral = $(nTds[50]).text();
				estudiosGabinete = $(nTds[51]).text();
				terapeutica = $(nTds[52]).text();
				criteriosEspecializadas = $(nTds[53]).text();
				educacionEspecial = $(nTds[54]).text();
				gestionEquipo = $(nTds[55]).text();
				procesosAdmin = $(nTds[56]).text();
				diagnostico  = $(nTds[57]).text();
				pronosticoVida  = $(nTds[58]).text();
				pronosticoFuncion  = $(nTds[59]).text();
				cedula  = $(nTds[60]).text();
				fechaFin  = $(nTds[61]).text();
				horaFin  = $(nTds[62]).text();
				

				$("#div_User").fadeIn();
				$("#div_User").html("<div id='cargando' style='display:none; color: green;text-align:center' width='100%' height='100%'><img width='16' height='16' src='../img/ajax-loader.gif' /> Cargando...</b></div>");
				$("#cargando").css("margin-left", "auto");
				$("#cargando").css("margin-right", "auto");
				$("#cargando").css("display", "inline");
				$("#div_User").load("modificarHistClin.php",{idHistClin:idHistClin,fecha:fecha,hora:hora,tipoInterroga:tipoInterroga,antecedentesHeredo:antecedentesHeredo,edoCivil:edoCivil,ocupacion:ocupacion,lugarOrigen:lugarOrigen,escolaridad:escolaridad,religion:religion,grupoRH:grupoRH,habitacion:habitacion,habitos:habitos,alimentacion:alimentacion,actividadFisica:actividadFisica,inmunizaciones:inmunizaciones,antecedentesPatologicos:antecedentesPatologicos,conciliacionMedicamentos:conciliacionMedicamentos,antecedentesGineco:antecedentesGineco,antecedentesPediatricos:antecedentesPediatricos,padecimientoActual:padecimientoActual,sintomas:sintomas,respiratorio:respiratorio,musculoEsquele:musculoEsquele,digestivo:digestivo,genital:genital,endocrino:endocrino,nervioso:nervioso,hematologico:hematologico,psicologico:psicologico,urinario:urinario,cardiocirculatorio:cardiocirculatorio,pielFaneras:pielFaneras,fc:fc,fr:fr,ta:ta,temp:temp,so:so,glucosa:glucosa,peso:peso,talla:talla,habEx:habEx,cabeza:cabeza,cuello:cuello,abdomen:abdomen,extremidades:extremidades,genitales:genitales,neurologico:neurologico,pielFaneras2:pielFaneras2,columnavertebral:columnavertebral,estudiosGabinete:estudiosGabinete,terapeutica:terapeutica,criteriosEspecializadas:criteriosEspecializadas,educacionEspecial:educacionEspecial,gestionEquipo:gestionEquipo,procesosAdmin:procesosAdmin,diagnostico:diagnostico,pronosticoVida:pronosticoVida,pronosticoFuncion:pronosticoFuncion,cedula:cedula,fechaFin:fechaFin,horaFin:horaFin},function(){
				  $("#cargando").css("display", "none");
				});
			  });
			 });
		</script>
		
		<style type="text/css">
		  .div_User{
			position: absolute;
			top: 5%;
			left: 25%;
			width: 60%;
			height: 90%;
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