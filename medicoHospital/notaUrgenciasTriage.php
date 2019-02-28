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

	if(isset($_REQUEST['enviar']))
	{
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
		
		if (isset($_POST['fecha']))
		{
			$fecha=$_POST['fecha'];
		} else {
			$fecha=date('Y-m-d');
		}
		if (isset($_POST['hora']))
		{
			$hora=utf8_decode($_POST['hora']);
		}
		if (isset($_POST['horaFin']))
		{
			$horaFin=utf8_decode($_POST['horaFin']);
		}
		if (isset($_POST['turno']))
		{
			$turno=$_POST['turno'];
		}
		if (isset($_POST['acude']))
		{
			$acude=$_POST['acude'];
		}
		if (isset($_POST['motivo']))
		{
			$motivo=utf8_decode($_POST['motivo']);
			$motivo=addslashes($motivo);
		}
		if (isset($_POST['ta']))
		{
			$ta=$_POST['ta'];
		}
		if (isset($_POST['fc']))
		{
			$fc=$_POST['fc'];
		}
		if (isset($_POST['fr']))
		{
			$fr=$_POST['fr'];
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
		if (isset($_POST['peso']))
		{
			$peso=utf8_decode($_POST['peso']);
			$peso=addslashes($peso);
		}
		if (isset($_POST['talla']))
		{
			$talla=utf8_decode($_POST['talla']);
			$talla=addslashes($talla);
		}
		if (isset($_POST['color']))
		{
			$color=$_POST['color'];
		}
		if (isset($_POST['realizo']))
		{
			$realizo=utf8_decode($_POST['realizo']);
			$realizo=addslashes($realizo);
		}
		
		//echo 'LLEGO : '.$expediente.' '.$folio.' '.$rol.' '.$hora.' '.$motivo.' '.$ta.' '.$fc.' '.$fr.' '.$temp.' '.$so.' '.$peso.' '.
			//$talla.' '.$color.' '.$realizo;
		
		$queryInsUrgT = "INSERT INTO notaUrgTriage (id,numeroExpediente,folio,fecha,hora,turno,acude,motivo,ta,fc,fr,temp,so,glucosa,peso,talla,color,horaFin,realizo,usr)
		VALUES (NULL,'$expediente','$folio','$fecha','$hora','$turno','$acude','$motivo','$ta','$fc','$fr','$temp','$so','$glucosa','$peso','$talla','$color',
				'$horaFin','$realizo','$rol')";
		
			$result0 = mysqli_query($conexionMedico, $queryInsUrgT);
			if(!$result0) {
				echo '!<br> ERROR al insertar Nota de Urgencias de Triage! <br>';
				echo 'QUERY: '.$queryInsUrgT;
			} else {
				echo '<br>!!!! SE GUARDO LA NOTA DE URGENCIAS DE TRIAGE CORRECTAMENTE!!!!<br>';
			}
		
	}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DATOS TRIAGE</title>

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

    <body>

        <!-- main content -->
        <section class="form-box">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1">
					
						<!-- Form Wizard -->
						<div class="form-wizard form-header-stylist form-body-material">
						<!-- 
						Just change the class name for make it with different style of design.

						Use anyone class "form-header-classic" or "form-header-modarn" or "form-header-stylist" for set your form header design.
						
						Use anyone class "form-body-classic" or "form-body-material" or "form-body-stylist" for set your form element design.
						-->
						
                    	<form role="form" action="" method="post">

                    		<h3>DATOS DE TRIAGE</h3>
                    		<p></p>
							
							<!-- Form progress -->
                    		<div class="form-wizard-steps form-wizard-tolal-steps-1">
                    			<div class="form-wizard-progress">
                    			    <div class="form-wizard-progress-line" data-now-value="100" data-number-of-steps="4" style="width: 100%;"></div>
                    			</div>								
								
								<!-- Step 2 -->
                    			<div class="form-wizard-step active">
                    				<div class="form-wizard-step-icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                    				<p>Exploración</p>
                    			</div>
								<!-- Step 2 -->
                    		</div>
							<!-- Form progress -->

							<!-- Form Step 2 -->
                            <fieldset>
								<!-- Progress Bar -->
								<div class="progress">
								  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								  </div>
								</div>
								<!-- Progress Bar -->
                                <h4>EXPLORACIÓN FISICA : <span>Paso 1 - 1</span></h4>
								<h5>TRIAGE </h5>
								<div class="form-group">
                    			    <label>FECHA : <span>*</span></label>
                                    <input type="date" name="fecha" class="form-control required" >
									<!--input type="date" name="fecha" class="form-control required" value="<?php #echo date("Y-m-d");?>"-->
                                </div>
								<div class="form-group">
									<label>HORA INICIO: <span>*</span></label>
									<input type="time" name="hora" id="hora" class="form-control required" >
									<!--input type="text" name="hora" id="hora" class="form-control required" autocomplete="off" -->
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
										<option value="">Seleccione</option>
										<option value="AMBULANCIA">Ambulancia</option>
										<option value="CAMINANDO">Caminando</option>
										<option value="BRAZOS">Brazos</option>
									   <option value="SILLA DE RUEDAS">Silla de Ruedas</option>
									</select>
								</div>
								<div class="container-fluid">
										<div class="form-group">
											<label>MOTIVO DE ATENCIÓN : <span>*</span></label>
											<input type="text" name="motivo" class="form-control required" autocomplete="off">
										</div>
									<div class="row form-inline">
										<div class="form-group col-md-6 col-xs-6">
											<label>T/A : <span></span></label>
											<input type="text" name="ta" placeholder="mmHg" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>FC : <span></span></label>
											<input type="text" placeholder="min" name="fc" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>FR : <span></span></label>
											<input type="text" placeholder="min" name="fr" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TEMP : <span></span></label>
											<input type="text" name="temp" placeholder="°C" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>SO2 : <span></span></label>
											<input type="text" name="so" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>GLUCOSA : <span></span></label>
											<input type="text" name="glucosa" placeholder="mg/dl" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>PESO (Kg) : <span></span></label>
											<input type="number" step="0.01" name="peso" class="form-control" autocomplete="off">
										</div>
										<div class="form-group col-md-6 col-xs-6">
											<label>TALLA (Mts) : <span></span></label>
											<input type="number" step="0.01" name="talla" class="form-control" autocomplete="off">
										</div>
									</div>
									<br>
									<div class="form-group">
										<label>COLOR : </label>
									</div>
									<div class="form-group col-md-3 col-xs-3">
										<label style="color: red">ROJO : </label>
										<input type="radio" name="color" value="ROJO" class="form-control" checked>
									</div>
									<div class="form-group col-md-4 col-xs-3">
										<label style="color:gold">AMARILLO : </label>
										<input type="radio" name="color" value="AMARILLO" class="form-control">
									</div>
									<div class="form-group col-md-3 col-xs-8">
										<label style="color: green">VERDE : </label>
										<input type="radio" name="color" value="VERDE" class="form-control">
									</div>
									<br/>
									<div class="form-group">
									<label>HORA FIN: <span>*</span></label>
									<input type="time" name="horaFin" id="horaFin" class="form-control required" >
									<!--input type="text" name="horaFin" id="horaFin" class="form-control required" autocomplete="off" -->
								</div>
									<div class="form-group">
											<label>REALIZÓ : <span>*</span></label>
											<input type="text" name="realizo" class="form-control required" autocomplete="off">
										</div>
								</div>
								<br/>
                                <input name="rol" type="hidden" value="<?php echo $rol ?>" >								
								<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
								<input name="folio" type="hidden" value="<?php echo $folio ?>" >
                                <div class="form-wizard-buttons">
                                    <button type="submit" name="enviar" id="enviar" class="btn btn-submit">Guardar</button>
                                </div>
                            </fieldset>
							<!-- Form Step 2 -->
                    	
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
		
		
		<!-- Plugin Custom JS -->
        <script src="./js/form-wizard.js"></script>
		<script src="./js/switcher.js"></script>
        <!-- Plugin Custom JS -->
		<script type="text/javascript">
			/*Evento Click Botón Enviar Nota Urg*/
			$("#enviar").click(function(evento){
				//evento.preventDefault(); //Evitamos que el formulario se vaya

			/*Validación con RegEx para una dirección de correo, aunque en html5 ya existe el input email que valida por nosotros*/
				var yearreg = /([0-2][0-9]):[0-5][0-9](:[0-5][0-9])?/;   //Creamos las reglas para validar la fecha YYY-MM-DD

				$(".error").fadeOut().remove();

				if ($("#hora").val() == "" || !yearreg.test($("#hora").val())) { 
					$("#hora").focus().after('<span class="error" style="color:red"> Colocar una Hora Valida </span>');
					return false;
				} else 	if ($("#horaFin").val() == "" || !yearreg.test($("#horaFin").val())) {
					$("#horaFin").focus().after('<span class="error" style="color:red"> Colocar una Hora Valida </span>');
					return false;
				 } else {
					 return true;
				 }
			});
		</script>
    </body>

</html>