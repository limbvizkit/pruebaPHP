<?php
	header('Content-Type: text/html;charset=utf-8');
  	
	#Archivo con la conexion para MYSQL
	require_once('../conexion/configMedico.php');
	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('../conexion/funciones_db.php');

	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
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

	$fcFin=NULL;
	$frFin=NULL;
	$taFin=NULL;
	$tempFin=NULL;
	$soFin=NULL;
	$glucosaFin=NULL;
	$habExtFin=NULL;
	$cabezaFin=NULL;
	$toraxFin=NULL;
	$abdomenFin=NULL;
	$extremidadesFin=NULL;
	$tratamientoFin=NULL;
	$diagFin=NULL;
	$nombre_pac =NULL;
	$antecedentesFin=NULL;
	$interrogatorioFin=NULL;
	$acudeFin=NULL;
	//Query para jalar los datos de la consulta medica
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
		
		$fcFin=$rowA['fc'];
		$frFin=$rowA['fr'];
		$taFin=$rowA['ta'];
		$tempFin=$rowA['temp'];
		$soFin=$rowA['so'];
		$glucosaFin=$rowA['glucosa'];
		
		$habExtOld= utf8_encode($rowA['habExt']);
		$habExtFin=addslashes ($habExtOld);
		
		$cabezaOld= utf8_encode($rowA['cabeza']);
		$cabezaFin=addslashes ($cabezaOld);

		$toraxOld= utf8_encode($rowA['torax']);
		$toraxFin=addslashes ($toraxOld);
		
		$abdomenOld= utf8_encode($rowA['abdomen']);
		$abdomenFin=addslashes ($abdomenOld);

		$extremidadesOld= utf8_encode($rowA['extremidades']);
		$extremidadesFin=addslashes ($extremidadesOld);

		$tratamientoOld= utf8_encode($rowA['tratamientoFin']);
		$tratamientoFin=addslashes ($tratamientoOld);

		$diagOld= utf8_encode($rowA['diag']);
		$diagFin=addslashes ($diagOld);
		/*$vidaFin=$rowA['pronosticoVida'];
		$funcionFin=$rowA['pronosticoFuncion'];*/
		$acudeFin=$rowA['acude'];
		
	}
	if($expediente != NULL || $expediente != ''){
	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	$nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	}
	/*$expediente_pac = trim($resultado[0][0]['NO_EXP_PAC']);
	$folio_pac = $resultado[0][0]['FOLIO_PAC'];
	$edad_pac = $resultado[0][0]['EDAD_PAC'];
   	$sexo_pac = $resultado[0][0]['SEXO_PAC'];
	if($sexo_pac == 'M'){
		$sexo_pac='MASCULINO';
	} else {
		$sexo_pac='FEMENINO';
	}
	$obligado_pac = $resultado[0][0]['OBLI_PAC'];
 	$date2 = $resultado[0][0]['NACIO_PA'];
	//Sacar Edad Precisa en años o Meses
	$hoy = new DateTime();
	$anniosO = $hoy->diff($date2);
	//$annios = $annios->y;
	$annios = $anniosO->format('%y Año(s)');
	$anniosBool = $anniosO->format('%y');
	if($anniosBool == '0'){
		$annios = $anniosO->format('%m Mes(es)');
	}*/
	$val='0';
	if(isset($_REQUEST['enviar']))
	{
		$bhc=NULL;
		$qs=NULL;
		$tpt=NULL;
		$rx=NULL;
		$tac=NULL;
		$rm=NULL;
		$us=NULL;

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
		if (isset($_POST['hora']))
		{
			$hora=$_POST['hora'];
		}
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['acude']))
		{
			$acude=$_POST['acude'];
		}
		if (isset($_POST['nPaciente']))
		{
			$nPaciente=utf8_decode($_POST['nPaciente']);
		}
		if (isset($_POST['antecedentes']))
		{
			$antecedentes=utf8_decode($_POST['antecedentes']);
			$antecedentes=addslashes($antecedentes);
		}
		if (isset($_POST['tratamiento']))
		{
			$tratamiento=utf8_decode($_POST['tratamiento']);
			$tratamiento=addslashes($tratamiento);
		}
		if (isset($_POST['interrogatorio']))
		{
			$interrogatorio=utf8_decode($_POST['interrogatorio']);
			$interrogatorio=addslashes($interrogatorio);
		}
		#2		
		if (isset($_POST['fc']))
		{
			$fc=$_POST['fc'];
		}
		if (isset($_POST['fr']))
		{
			$fr=$_POST['fr'];
		}
		if (isset($_POST['ta']))
		{
			$ta=$_POST['ta'];
		}
		if (isset($_POST['temp']))
		{
			$temp=$_POST['temp'];
		}
		if (isset($_POST['so']))
		{
			$so=$_POST['so'];
		}
		if (isset($_POST['glucosa']))
		{
			$glucosa=$_POST['glucosa'];
		}
		//La suma de estos 3 da el total
		if (isset($_POST['respOcul']))
		{
			$respOcul=$_POST['respOcul'];
		}
		if (isset($_POST['respVerb']))
		{
			$respVerb=$_POST['respVerb'];
		}
		if (isset($_POST['respMot']))
		{
			$respMot=$_POST['respMot'];
		}
		
		if (isset($_POST['habExt']))
		{
			$habExt=utf8_decode($_POST['habExt']);
			$habExt=addslashes($habExt);
		}
		if (isset($_POST['cabeza']))
		{
			$cabeza=utf8_decode($_POST['cabeza']);
			$cabeza=addslashes($cabeza);
		}
		if (isset($_POST['torax']))
		{
			$torax=utf8_decode($_POST['torax']);
			$torax=addslashes($torax);
		}
		if (isset($_POST['abdomen']))
		{
			$abdomen=utf8_decode($_POST['abdomen']);
			$abdomen=addslashes($abdomen);
		}
		if (isset($_POST['extremidades']))
		{
			$extremidades=utf8_decode($_POST['extremidades']);
			$extremidades=addslashes($extremidades);
		}
		
		if (isset($_POST['bhc']))
		{
			$bhc=$_POST['bhc'];
		}
		if (isset($_POST['qs']))
		{
			$qs=utf8_decode($_POST['qs']);
			$qs=addslashes($qs);
		}
		if (isset($_POST['tpt']))
		{
			$tpt=utf8_decode($_POST['tpt']);
			$tpt=addslashes($tpt);
		}
		if (isset($_POST['rx']))
		{
			$rx=utf8_decode($_POST['rx']);
			$rx=addslashes($rx);
		}
		if (isset($_POST['tac']))
		{
			$tac=utf8_decode($_POST['tac']);
			$tac=addslashes($tac);
		}
		if (isset($_POST['rm']))
		{
			$rm=utf8_decode($_POST['rm']);
			$rm=addslashes($rm);
		}
		if (isset($_POST['us']))
		{
			$us=utf8_decode($_POST['us']);
			$us=addslashes($us);
		}
		if (isset($_POST['paraclin']))
		{
			$paraclin=utf8_decode($_POST['paraclin']);
			$paraclin=addslashes($paraclin);
		}
		#3
		if (isset($_POST['diag']))
		{
			$diag=utf8_decode($_POST['diag']);
			$diag=addslashes($diag);
		}
		/*if (isset($_POST['tratUtil']))
		{
			$tratUtil=utf8_decode($_POST['tratUtil']);
		}
		if (isset($_POST['tratUtilTxt']))
		{
			$tratUtilTxt=utf8_decode($_POST['tratUtilTxt']);
		}*/
		if (isset($_POST['interconsulta']))
		{
			$interconsulta=utf8_decode($_POST['interconsulta']);
			$interconsulta=addslashes($interconsulta);
		}
		if (isset($_POST['horaSol']))
		{
			$horaSol=$_POST['horaSol'];
		}
		if (isset($_POST['especialidad']))
		{
			$especialidad=utf8_decode($_POST['especialidad']);
			$especialidad=addslashes($especialidad);
		}
		/*if (isset($_POST['horaAcud']))
		{
			$horaAcud=$_POST['horaAcud'];
		}*/
		if (isset($_POST['vida']))
		{
			$vida=$_POST['vida'];
		}
		if (isset($_POST['funcion']))
		{
			$funcion=$_POST['funcion'];
		}
		if (isset($_POST['ingresa']))
		{
			$ingresa=utf8_decode($_POST['ingresa']);
			$ingresa=addslashes($ingresa);
		}
		if (isset($_POST['cedula']))
		{
			$cedula=$_POST['cedula'];
		}
		
		$totalValNeu = $respOcul + $respVerb + $respMot;
		
		/*echo 'LLEGO : '.$antecedentes.' '.$tratamiento.' '.$interrogatorio.' '.$hora.' '.$fc.' '.$fr.' '.$ta.' '.$temp.' '.$so.' '.$habExt.' '.$cabeza.' '.$torax.' '.$abdomen.' '.$extremidades.' '.$diag.' '.$tratamientoFin;*/
		
		$queryInsUrgCh = "INSERT INTO notaurgchoque (id,numeroExpediente,folio,hora,turno,acude,nPaciente,antecedentes,tratamiento,interrogatorio,
					fc,fr,ta,temp,so,glucosa,respOcul,respVerb,respMot,totalValNeu,habExt,cabeza,torax,abdomen,extremidades,bhc,qs,tpt,rx,tac,rm,us,
					paraclin,diag,interconsulta,horaSol,especialidad,vida,funcion,ingresa,cedula,usr)
					VALUES (NULL,'$expediente','$folio','$hora','$turno','$acude','$nPaciente','$antecedentes','$tratamiento','$interrogatorio','$fc',
					'$fr','$ta','$temp','$so','$glucosa','$respOcul','$respVerb','$respMot','$totalValNeu','$habExt','$cabeza','$torax','$abdomen',
					'$extremidades','$bhc','$qs','$tpt','$rx','$tac','$rm','$us','$paraclin','$diag','$interconsulta','$horaSol','$especialidad',
					'$vida','$funcion','$ingresa','$cedula','$rol')";
		
		$result0 = mysqli_query($conexionMedico, $queryInsUrgCh);
		if(!$result0) {
			echo '!<br> ERROR al insertar Nota de Urgencias Choque! <br>';
			echo 'QUERY: '.$queryInsUrgCh;
			/*if($ingresa != 'EGRESO'){
				$val='1';
			}*/
		} else {
			echo '<br>!!!! SE GUARDO LA NOTA DE URGENCIAS CHOQUE CORRECTAMENTE!!!!<br>';			
			if($ingresa != 'EGRESO'){
				$val='1';
			}
		}
		
	}
	

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NOTA URGENCIAS CHOQUE</title>

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

    <body onload="mostrarVent(<?php echo $val ?>)">
	<script type="text/javascript">
		function mostrar(v){
			if(v == '1'){
				document.getElementById('interconsul').style="display:block";
			} else {
				document.getElementById('interconsul').style="display:none";
			}
		}
		
		function suma(){
			var resultado = 0;
			var num1 = document.getElementById("respOcul").value;
			var num2 = document.getElementById("respVerb").value;
			var num3 = document.getElementById("respMot").value;

			resultado = (parseInt(num1) + parseInt(num2) + parseInt(num3));
			document.getElementById('total').innerHTML = resultado;
    	}
		
		function mostrarVent(s){
				if(s == '1'){
					window.open('notaTraslServ.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente?>&folio=<?php echo $folio ?>', '_blank');
				}
			}
	</script>
        <!-- main content -->
        <section class="form-box">
			<br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-classic form-body-classic">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
					
                    	<form role="form" action="" method="post">

                    		<h3>NOTA MEDICA DE URGENCIAS Y CHOQUE</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-4">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                    			</div>
								<!-- Step 1 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    				<p>Antecedentes</p>
                    			</div>
								<!-- Step 1 -->
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                    				<p>Exploración</p>
                    			</div>
								<!-- Step 2 -->
								
								<!-- Step 3 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-flask" aria-hidden="true"></i></div>
                    				<p>Diagnósticos</p>
                    			</div>
								<!-- Step 3 -->
								
								<!-- Step 4 -->
								<div class="form-wizard-step">
                    				<div class="form-wizard-step-icon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                    				<p>Pronóstico e Ingreso</p>
                    			</div>
								<!-- Step 4 -->
                    		</div>
							<!-- Form progress -->
                    		
							
							<!-- Form Step 1 -->
                    		<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
								  </div>
								</div>
								<!-- Progress Bar -->
                    		    <h4>ANTECEDENTES: <span>Paso 1 - 4</span></h4>
								<div class="form-group">
									<label>HORA DE INICIO DE CONSULTA : <span>*</span></label>
									<input type="time" name="hora" class="form-control required" autocomplete="off">
								</div>
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
                    			    <label>FORMA EN QUE ACUDE : <span>*</span></label>
                                   <select id="acude" name="acude" class="form-control required">
										<option value="<?php echo $acudeFin ?>"><?php echo $acudeFin ?></option>
										<option value="AMBULANCIA">Ambulancia</option>
										<option value="CAMINANDO">Caminando</option>
										<option value="BRAZOS">Brazos</option>
									   <option value="SILLA DE RUEDAS">Silla de Ruedas</option>
									</select>
								</div>
								<div class="form-group">
									<label>NOMBRE DEL PACIENTE : <span>*</span></label>
									<input type="text" name="nPaciente" class="form-control required" value="<?php echo $nombre_pac ?>" autocomplete="off">
								</div>
								<div class="form-group">
                    			    <label>ANTECEDENTES PERSONALES : <span>*</span></label>
                                    <textarea class="form-control required" name="antecedentes" id="antecedentes" cols="10" rows="3"><?php echo $antecedentesFin ?></textarea>
                                </div>
								
								 <div class="form-group">
                    			    <label>TRATAMIENTO (CONCILIACIÓN DE MEDICAMENTOS) : <span>*</span></label>
                                    <textarea class="form-control required" name="tratamiento" id="tratamiento" cols="10" rows="3"><?php echo $tratamientoFin ?></textarea>
                                </div>
								<h5>INTERROGATORIO</h5>
								<div class="form-group">
                    			    <label>PADECIMIENTO ACTUAL : <span>*</span></label>
									<textarea class="form-control required" name="interrogatorio" id="interrogatorio" cols="10" rows="3"><?php echo $interrogatorioFin ?></textarea>
                                </div>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 1 -->

							<!-- Form Step 2 -->
                            <fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>EXPLORACIÓN FISICA : <span>Paso 2 - 4</span></h4>
								<div class="container-fluid">
									<label>SIGNOS VITALES: <span></span></label>
									<div class="row form-inline">
										<!--div class="form-group col-md-6 col-xs-6">
											<label>HORA : <span>*</span></label>
											<input type="time" name="hora" class="form-control required" autocomplete="off">
										</div-->
										<div class="form-group col-md-6 col-xs-6">
											<label>FC : <span>*</span></label>
											<input type="text" placeholder="min" name="fc" class="form-control required" value="<?php echo $fcFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>FR : <span></span>*</label>
											<input type="text" placeholder="min" name="fr" class="form-control required" value="<?php echo $frFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>T/A : <span>*</span></label>
											<input type="text" name="ta" placeholder="mmHg" class="form-control required" value="<?php echo $taFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TEMP : <span>*</span></label>
											<input type="text" name="temp" placeholder="°C" class="form-control required" value="<?php echo $tempFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>SO2 : <span>*</span></label>
											<input type="text" name="so" class="form-control required" value="<?php echo $soFin ?>" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>GLUCOSA : <span></span></label>
											<input type="text" name="glucosa"  placeholder="mg/dl" class="form-control" value="<?php echo $glucosaFin ?>" autocomplete="off">
										</div>
									</div>
								</div>
								<br/>
								<div class="form-group">
                    			    <label>VALORACIÓN NEUROLÓGICA : <span></span></label><br/>
                                    <div class="container-fluid">
									<div class="row form-inline">
										<div class="form-group col-md-6 col-xs-6">
											<label>RESPUESTA OCULAR : <span></span></label>
											<input type="number" name="respOcul" id="respOcul" min="1" max="4" class="form-control" autocomplete="off" onchange="suma();">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>RESPUESTA VERBAL : <span></span></label>
											<input type="number" name="respVerb" id="respVerb" min="1" max="5" class="form-control" autocomplete="off" onchange="suma();">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>RESPUESTA MOTORIA : <span></span></label>
											<input type="number" name="respMot" id="respMot" min="1" max="6" class="form-control" autocomplete="off" onchange="suma();">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TOTAL : <span id="total"></span></label>
											<!--textarea class="form-control required" name="total"></textarea-->
										</div>
									</div>
								</div>
                                </div>
                                <div class="form-group">
                    			    <label>ESTADO MENTAL Y HABITUS EXTERIOR : <span>*</span></label>
									<textarea class="form-control required" name="habExt" id="habExt" cols="10" rows="3"><?php echo $habExtFin ?></textarea>
                                    <!--input type="text" name="habExt" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>CABEZA : <span>*</span></label>
									<textarea class="form-control required" name="cabeza" id="cabeza" cols="10" rows="3"><?php echo $cabezaFin ?></textarea>
                                    <!--input type="text" name="cabeza" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>TÓRAX : <span>*</span></label>
									<textarea class="form-control required" name="torax" id="torax" cols="10" rows="3"><?php echo $toraxFin ?></textarea>
                                    <!--input type="text" name="torax" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>ABDOMEN : <span>*</span></label>
									<textarea class="form-control required" name="abdomen" id="abdomen" cols="10" rows="3"><?php echo $abdomenFin ?></textarea>
                                    <!--input type="text" name="abdomen" class="form-control" autocomplete="off"-->
                                </div>
								<div class="form-group">
                    			    <label>EXTREMIDADES : <span>*</span></label>
									<textarea class="form-control required" name="extremidades" id="extremidades" cols="10" rows="3"><?php echo $extremidadesFin ?></textarea>
                                    <!--input type="text" name="extremidades" class="form-control" autocomplete="off"-->
                                </div>
                                <div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
							<!-- Form Step 2 -->

							<!-- Form Step 3 -->
                            <fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4><span>Paso 3 - 4</span></h4>
								<div class="form-group">
                    			    <label>PARACLÍNICOS: <span></span></label>
                                    <br>
                                    <label class="checkbox-inline"> BHC
									  <input type="checkbox" name="bhc" style="width: 45px; height: 35px" value="1" >
									</label>
									<label class="checkbox-inline">QS
									  <input type="checkbox" name="qs" style="width: 45px; height: 35px" value="1">
									</label>
									<label class="checkbox-inline">TPT
									  <input type="checkbox" name="tpt" style="width: 45px; height: 35px" value="1"> 
									</label>
									<label class="checkbox-inline"> RX
									  <input type="checkbox" name="rx" style="width: 45px; height: 35px" value="1"> 
									</label>
									<label class="checkbox-inline">TAC
									  <input type="checkbox" name="tac" style="width: 45px; height: 35px" value="1"> 
									</label>
									<div class="form-group">
										<br>
									</div>
									<label class="checkbox-inline">RESONANCIA MÁGNETICA
									  <input type="checkbox" name="rm" style="width: 45px; height: 35px" value="1"> 
									</label>
									<label class="checkbox-inline">ULTRASONIDO
									  <input type="checkbox" name="us" style="width: 45px; height: 35px" value="1"> 
									</label>
                                </div>
								<div class="form-group">
										<br>
									</div>
								<div class="form-group">
                    			    <label>INTERPRETACIÓN DE ESTUDIOS PARACLÍNICOS : <span></span></label>
									<textarea class="form-control" name="paraclin" id="paraclin" cols="15" rows="3"></textarea>
                                </div>
								<div class="form-group">
                    			    <label>DIAGNÓSTICOS : <span>*</span></label>
                                    <textarea class="form-control required" name="diag" id="diag" cols="15" rows="3"><?php echo $diagFin ?></textarea>
                                </div>
								<!--div class="form-group">
									<label>TRATAMIENTO UTILIZÓ : </label>
								</div>
								<div class="form-group">									
									<div class="form-group col-md-3 col-xs-3">
										<label>SI : </label>
										<input type="radio" name="tratUtil" value="SI" class="form-control" checked>
									</div>
									<div class="form-group col-md-3 col-xs-3">
										<label>NO : </label>
										<input type="radio" name="tratUtil" value="NO" class="form-control">
									</div>
									<br/>
									<div class="form-group">
										<textarea class="form-control" name="tratUtilTxt" id="tratUtilTxt" cols="15" rows="3"></textarea>
									</div>
								</div-->
								<div class="form-group">
										<label>INTERCONSULTA : <span></span></label>
								</div>
								<div class="form-group">
									<div class="form-group col-md-3 col-xs-3">
									<label>SI : </label>
										<input type="radio" name="interconsulta" onclick="mostrar('1')" value="SI" class="form-control">
									</div>
									<div class="form-group col-md-3 col-xs-3">
										<label>NO : </label>
										<input type="radio" name="interconsulta" onclick="mostrar('2')" value="NO" class="form-control" checked>
									</div>
								</div>
								<br/>
								<div id="interconsul" style="display:none">
									<div class="form-group">
										<br>
									</div>
									<div class="form-group">
										<br/>
									</div>
									<div class="form-group">
										<label>HORA DE SOLICITUD : </label>
										<input type="time" name="horaSol" class="form-control" autocomplete="off">
									</div>
									<div class="form-group">
										<label>ESPECIALIDAD : </label>
										<input type="text" name="especialidad" class="form-control" autocomplete="off">
									</div>
									<!--div class="form-group">
										<label>HORA EN QUE ACUDIÓ : </label>
										<input type="time" name="horaAcud" class="form-control" autocomplete="off">
									</div-->
								</div>
								<div class="form-wizard-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
								
								<!-- Form Step 4 -->
							<fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>PRONÓSTICO E INGRESO: <span>Paso 4 - 4</span></h4>
								<div style="clear:both;"></div>
								<h5>PRONÓSTICO : </h5>
								<div class="form-group">
                    			    <label>VIDA : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="vida" value="BUENO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; BUENO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="vida" value="MALO" style="width: 30px; height: 30px">&nbsp;&nbsp; MALO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="vida" value="RESERVADO" style="width: 30px; height: 30px">&nbsp;&nbsp; RESERVADO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>FUNCIÓN : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="funcion" value="BUENO" style="width: 30px; height: 30px" checked="checked">&nbsp;&nbsp; BUENO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="funcion" value="MALO" style="width: 30px; height: 30px">&nbsp;&nbsp; MALO
									</label>
									<label class="radio-inline">
									  <input type="radio" name="funcion" value="RESERVADO" style="width: 30px; height: 30px">&nbsp;&nbsp; RESERVADO
									</label>
                                </div>
								<div class="form-group">
                    			    <label>INGRESA A : <span>*</span></label>
                                    <br>
                                    <label class="radio-inline">
									  <input type="radio" name="ingresa" value="HOSPITALIZACIÓN" style="width: 30px; height: 30px" checked="checked"> &nbsp;&nbsp;HOSPITALIZACIÓN
									</label>
									<label class="radio-inline">
									  <input type="radio" name="ingresa" value="UCI" style="width: 30px; height: 30px">&nbsp;&nbsp; UCI
									</label>
									<label class="radio-inline">
									  <input type="radio" name="ingresa"alue="UCIPYN" style="width: 30px; height: 30px">&nbsp;&nbsp; UCIPYN
									</label>									
									<label class="radio-inline">
									  <input type="radio" name="ingresa" value="QUIRÓFANO" style="width: 30px; height: 30px">&nbsp;&nbsp; QUIRÓFANO
									</label>
									<!--label class="radio-inline">
									  <input type="radio" name="ingresa" id="ingresa" value="TRASLADO"> TRASLADO
									</label-->
									<label class="radio-inline">
									  <input type="radio" name="ingresa" value="EGRESO" style="width: 30px; height: 30px">&nbsp;&nbsp; EGRESO
									</label>
                                </div>
								<!--div class="form-group">
									<h4>DATOS DEL MÉDICO:</h4>
                    			    <label>CEDULA PROFESIONAL : <span>*</span></label>
									<input type="text" name="cedula" class="form-control required" autocomplete="off">
                                </div-->
								<div class="form-group">
									<h4>DATOS DEL MÉDICO:</h4>
									&nbsp;<p>&nbsp;&nbsp;&nbsp;&nbsp;CEDULA PROFESIONAL :<span>*</span></p>
									<input class="form-control" id="cedula" type="text" name="cedula" style="background-color:#9EE5D7" accept-charset="utf-8" placeholder="Número de cedula" autocomplete="off" required>
									<br>
									<div id="suggestions1"></div>
								</div>
								<br/>
								<input name="rol" type="hidden" value="<?php echo $rol ?>">								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
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
        </section>
		<!-- main content -->

        <!-- Jquery JS -->
        <script src="../js/jquery-1.11.1.min.js"></script>
		<!-- bootStrap JS -->
		<script src="../js/bootstrap.min.js"></script>
		<script type="text/javascript">
			//Mostrar recuadro si se selecc OTROS			
			//if ($("#ingresa").val() != null && document.getElementById("ingresa").value != null ) {
				//$(document).ready(function () {
					//$('#add_button').click(function () {
					//	window.open('notaTraslServ.php?rol=<?php echo $rol ?>&exp=<?php echo $expediente?>&folio=<?php echo $folio ?>', '_blank');
					//});
				//});
			//}
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
	</script>
		</script>
		
		<!-- Plugin Custom JS -->
        <script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script>
        <!-- Plugin Custom JS -->

    </body>

</html>