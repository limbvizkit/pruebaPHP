<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Consultar</title>

<!-- en html5 no necesitas indicar el cierre de la etiqueta -->
<style type="text/css">
/* Datagrid */
	body {
  	text-align: center;
    	background-color: #E8F0FE;
    	font-family: Helvetica,Arial,sans-serif;
		background-image: url(../img/logoNew2Agua.jpg);
    }
	table {
	  border-collapse: collapse;
	  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	}
	th, td {
	  padding: 0.25rem;
	  text-align: center;
	}
	tbody tr:nth-child(odd) {
	  background: #eee;
	  width: 40px;
	}
	.centro{
	  padding: 0.5rem;
	  background: #4285F4 ;
	  color: white;
	  text-align: center;
	  font-size: 21px;
	
	}
	#cuadro{
		width: 90%;
		background: #F8F8F8 ;
		padding: 25px;
		margin: 5px auto;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	}
	#titulo{
		width: 100%;
		background: #4285F4;
		color:white;
	
	}
	.autoStyle4 {
			color: #FF0000;
			font-size: medium;
	}
	.suggest-element:hover {
		background-color:#999999;
		color:#FFFFFF;
	}

	#suggestions {
		width:475px;
		height:165px;
		overflow: auto;
		
	}

	#suggestions .item{
		float: left;
		width: 470px;
	}

	#result {
		background-color: #EDEDED;
		clear: both;
		color: #999999;
		margin-bottom: 10px;
		padding: 5px;
		width: 500px;
	}
</style>
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';
	require_once('../conexion/configLogin.php');
	
	
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}

	if(isset ($_GET['id'])){
		$id= $_GET['id'];
	}else {
		$id= NULL;
	}
	if (isset($_POST['id']))
	{
		$id=$_POST['id'];
	}
	
	//Query para sacar los datos de la solicitud en concreto
	$query="SELECT * FROM formvacaciones WHERE idSolicitud='$id' GROUP BY idSolicitud";
	$res = mysqli_query($conexion, $query) or die (mysqli_error($conexion));
		
	//Cuando NO SE ACEPTA actualizar los datos con el boton de Guardar
	if(isset($_REQUEST['noAceptar']))
	{
		$queryUpdNoAcep = "UPDATE formvacaciones SET estatus='3' WHERE idSolicitud='$id'";
		$result = mysqli_query($conexion, $queryUpdNoAcep) or die (mysqli_error($conexion));
		
		if(!$result){
			echo 'OCURRIO UN ERROR, INFORMAR A SISTEMAS';
			echo $queryUpdNoAcep;
		} else {
			echo 'SE GUARDARON LOS DATOS DE NO ACEPTADO';
			echo $queryUpdNoAcep;
		}

	}
	
	//Cuando SE ACEPTA actualizar los datos con el boton de Guardar
	if(isset($_REQUEST['aceptar']))
	{
		$queryUpdAcep = "UPDATE formvacaciones SET estatus='2' WHERE idSolicitud='$id'";
		$result0 = mysqli_query($conexion, $queryUpdAcep) or die (mysqli_error($conexion));
		
		if(!$result0){
			echo 'OCURRIO UN ERROR, INFORMAR A SISTEMAS';
			echo $queryUpdAcep;
		} else {
			echo 'SE GUARDARON LOS DATOS DE ACEPTADO';
			echo $queryUpdAcep;
		/////////////////////////////////////////////  Aqui comenzamos con el envío de correo//////////////////////////////////////////////////
			$mail = new PHPMailer();                              // Passing `true` enables exceptions
			$msg = '';
			try {
				$dato = mysqli_fetch_array($res);
				$empleado = $dato['nombreEmpleado'];
				$emaildestino='jgomez@henridunant.com.mx';
				//Server settings
				$mail->CharSet = 'utf-8';
				//$mail->Encoding = "base64";
				// Set mailer to use SMTP
				$mail->isSMTP();
				$mail->SMTPOptions = array( 
					'ssl' => array( 
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
				); 
				// Enable verbose debug output
				$mail->SMTPDebug = 0;
				$mail->Host = "mail.henridunant.com.mx";     		  // Specify main and backup SMTP servers
				$mail->Port = 587;                                    // TCP port to connect to
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = "quirofano@henridunant.com.mx";   // SMTP username
				$mail->Password = "Quirofano018";                  // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				//$mail->SMTPKeepAlive = true;
				//$mail->Mailer="smtp";


				// First handle the upload
				// Don't trust provided filename - same goes for MIME types
				// See http://php.net/manual/en/features.file-upload.php#114004 for more thorough upload validation
				//$uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name']));

				//$my_path = "quirofanoMini.pdf";

				// if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
				$mail->setFrom("jgomez@henridunant.com.mx","SISTEMAS Hospital Henri Dunant");
				//Email del destinatario
				$mail->addAddress($emaildestino, "RH");
				//Email Con Copia
				//$mail->AddCC($emailCC);
				//$mail->AddCC("laboratorio_shd@hotmail.com.mx");
				//$mail->AddCC("jmiranda@henridunant.com.mx");
				//$mail->AddCC("laboratorio@henridunant.com.mx");
				//$mail->AddCC("jgomez@henridunant.com.mx");
				// Set email format to HTML
				$mail->isHTML(true);
				$mail->Subject = 'Solicitud de vacaciones: '.$empleado;
				//Content
				$mail->AddEmbeddedImage('../img/logoNewPeque.jpg', 'logoHD');
				$mail->Body = 'Buen día <b>Recursos Humanos</b>
							<br>El presente correo es para informarle que se aceptaron las vacaciones del empleado<br>
							<b>'.$empleado.'</b>
							<br><br>
							El formato lo puede consultar ingresando a la siguiente liga:<br>
							<a href="http://10.12.0.44/conectaSQLSRV/pdf/creaPDFformatos.php?name=vacaciones&idSolicitud='.$id.'"> FORMATO VACACIONES </a>
							<br><br>
							Si no funciona el link copiar el siguiente texto y pegarlo en su navegador: <br>
							http://10.12.0.44/conectaSQLSRV/pdf/creaPDFformatos.php?name=vacaciones&idSolicitud='.$id.'
							<br><br>
							Cualquier duda o error sobre el formato generado, favor de informarlo inmediatamente
							al área de sistemas o respondiendo a este correo.
							<br><br>
							Saludos cordiales.
							<br><br> <img alt="LogoDelHD" src="cid:logoHD" >';

				// Attach the uploaded file
				//$mail->addAttachment($my_path, 'Datos Cirugia_'.$date2.'.pdf');

				if (!$mail->send()) {
					echo "  Error del Mailer1 : " . $mail->ErrorInfo;
				} else {
					echo '  <h2>Correo Enviado CORRECTAMENTE a RH<h2> ';
				}
				/*$msg .= 'BODY: Buen día <b> '.$cirujano.' </b>
							El presente correo es para informarle que tiene programada una círugía para el día '
							.$date1.' a las '.$hora.' hrs. en el Hospital Henri Dunant.<br><br> Se anexa archivo con todos los datos de la cirugía,
							cualquier error o duda sobre los datos favor de informarlo inmediatamente. <br><br> Saludos cordiales.';*/
			} catch (Exception $e) {
				echo 'El mensaje no se pudo enviar. Mailer Error2: ', $mail->ErrorInfo;
			}
		}//Si se guardaron los datos del query Estatus = 2 ACEPTADO
	}
	
	
	
?>

<script type="text/javascript">
	function noAcepta()
	{
		var agree=confirm("¿Está seguro de NO ACEPTAR esta solicitud? !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
		 	return true;
		}else{
		 	return false;
		}
	}
	
	function acepta()
	{
		var agree=confirm("¿Está seguro de ACEPTAR esta solicitud? !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
			return true;
		} else {
			return false;
		}
	}
</script>
	
	</head>
	<body>
	<div id="cuadro">
		<center><img src="../img/logoNew2.jpg" height="200" width="200"><br />
		<div id="titulo">
		<center><h1>Solicitud de Vacaciones</h1></center>
		</div>
		
		<form method="post" action="verMas.php">
		<table class="table table-bordered">
			<thead>
				<tr class="centro">
				    <td>ID</td>
					<td>FECHA</td>
					<td>NÚMERO DEL EMPLEADO</td>
					<td>NOMBRE DEL EMPLEADO</td>
					<td>DEPARTAMENTO</td>
					<td>JEFE DIRECTO</td>
				</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_array($res)){ 
							$estatus = $row['estatus'];
					?>
						<tr>
							<td>
								<?php echo $row['id'];?>
							</td>
							<td>
								<?php $fechaMostrar=substr($row['fecha'],0, -9); ?>
								<input id="fecha" name="fecha" type="date" style="width:140px; text-align: center" value="<?php echo $fechaMostrar;?>" disabled />
								<?php 
									$fechaDoc = $row['fecha'];
								?>
							</td>
							<td>
								<input id="numEmp" name="numEmp" type="number" style="width:60px; text-align: center" value="<?php echo $row['numeroEmpleado'];?>" disabled />
								<?php 
									$numeroEmpleadoDoc = $row['numeroEmpleado'];
								?>
							</td>
							<td>
								<input id="nombre" name="nombre" type="text" style="width:350px; text-align: center" value="<?php echo utf8_encode($row['nombreEmpleado']); ?>" disabled />
								<?php 
									$nombreEmpleado = utf8_encode($row['nombreEmpleado']);
								?>
							</td>
							<td>
								<?php 
									$areaEmpl = $row['area'];
									//Consultamos los datos del area del empleado
									$queryArea = "SELECT * FROM areas WHERE idArea = '$areaEmpl'";
									$ar = mysqli_query($conexion, $queryArea);
									$area = mysqli_fetch_array($ar);
									$nombAreaEmpl = utf8_encode($area[1]);
								?>
								<select id="area" name="area" class="form-control" disabled>
									    <option value="<?php echo $areaEmpl ?>"> <?php echo $nombAreaEmpl ?> </option>
									</select>
								
							</td>
							<td>
								<input id="nombreJefe" name="nombreJefe" type="text" style="width:350px; text-align: center" value="<?php echo utf8_encode($row['nombreJefe']); ?>" disabled />
								<?php 
									$nombreJefe = utf8_encode($row['nombreJefe']);
								?>
							</td>
						</tr>
				</tbody>
			</table>
					
			<table class="table table-bordered">
				<thead>
				<tr class="centro">
					<td>DÍAS QUE LE CORRESPONDEN</td>							
					<td>DÍAS A DISFRUTAR</td>
					<td>DÍAS PENDIENTES</td>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<input id="diasCorre" name="diasCorre" type="number" style="width:50px; text-align: center" value="<?php echo $row['diasCorresponden'];?>" disabled />
					</td>
					<td>
						<input id="diasDisfr" name="diasDisfr" type="number" style="width:50px; text-align: center" value="<?php echo $row['diasDisfrutar'];?>" disabled />
					</td>
					<td>
						<input id="diasPend" name="diasPend" type="number" style="width:50px; text-align: center" value="<?php echo $row['diasPendientes'];?>" disabled />
					</td>						
					</tr>
				</tbody>
			</table>
			<table class="table table-bordered">
				<thead>
					<tr class="centro">
						<td>DÍAS DE VACACIONES</td>
					</tr>
				</thead>
				<tbody>
					<?php
						//$resultado1 = mysqli_fetch_array($res);
						$idSol = $row['idSolicitud'];
					
						$query1="SELECT * FROM formvacaciones WHERE idSolicitud='$idSol'";
						$res1 = mysqli_query($conexion, $query1);
	
					while($row1 = mysqli_fetch_array($res1)){
					?>
					<tr>
						<td>
							<input id="anestQx" name="anestQx" type="text" style="width:100px; text-align: center" value="<?php 
								$date1 = date_create_from_format('Y-m-d 00:00:00',$row1['diaVacaciones'])->format('d-m-Y');
								echo $date1 ?>" disabled />
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		
			<table class="table table-bordered">
						<thead>
						<tr class="centro">
							<td>REGRESANDO A LABORAR EL DÍA</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<input id="diaRegreso" name="diaRegreso" type="text" style="width:100px; text-align: center" value="<?php $date2 = date_create_from_format('Y-m-d 00:00:00',$row['regresaLaborar'])->format('d-m-Y');
								echo $date2 ?>" disabled />
							</td>
						</tr>
				</tbody>
			</table>
			
			<table class="table table-bordered">
					<thead>
					<tr class="centro">						
						<td>OPCIONES</td>
					</tr>
					</thead>
			<tbody>
				<tr>
					<td>							
						<input id="id" name="id" type="hidden" value="<?php echo $id ?>" />
						<input id="rol" name="rol" type="hidden" value="<?php echo $rol ?>" />
						<input id="estatus" name="estatus" type="hidden" value="<?php echo $row['estatus'] ?>" />
						<?php //if($rol == 'quirofano') { ?>
							<!--input  class="btn btn-primary" type="button" value="MODIFICAR" onclick ="dsblqModifDss()" /-->
							<input type="submit" id="btAcepta" class="btn btn-success" name="aceptar" value="ACEPTAR" onClick="return acepta()" disabled/>
							<input type="submit" id="btNoAcepta" class="btn btn-danger" name="noAceptar" value="NO ACEPTAR" onClick="return noAcepta()" disabled/>
						<?php //} ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		</form>
		<br />
		<p> <strong>EXTRAS</strong></p>
		<a  class="btn btn-info" href="../pdf/creaPDFformatos.php?name=vacaciones&idSolicitud=<?php echo $id ?>" target="_blank">Generar Formato PDF</a>
		<!--a  class="btn btn-primary" href="emailHD.php?rol=<?php #echo $rol ?>&id=<?php #echo $id ?>&emailDoc=<?php #echo $emailDoc ?>&fecha=<?php #echo $fechaDoc ?>&cirujano=<?php# echo $nomCirg ?>&hora=<?php #echo $horaDoc ?>&estaus=<?php #echo $estatusCirugia0 ?>" target="_blank" onClick="return confirmSubmit()">Enviar E-mail</a-->
		<a  class="btn btn-danger" href="javascript:window.history.go(-1);">Regresar</a>
	</center>
</div>
		
		<script type="text/javascript">
			window.onload = function() {
				if(document.getElementById('estatus').value == '1'){
					document.getElementById('btAcepta').disabled=false;
					document.getElementById('btNoAcepta').disabled=false;
				}
			}
		</script>
</body>
</html>	