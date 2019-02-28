<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Quirofano Email</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
		<link href="../../css/bootstrap.min.css" rel="stylesheet" >
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		
        <style type="text/css">
            label, input{
                display: block;
            }
            input{
                margin-bottom: 20px;
            }
            input[type="email"]{
                margin-bottom: 20px;
                padding: 5px;
                font-size: 16px;
                width: 270px;
            }
            input[type="submit"]{
                background-color: #4caf50;
                border-radius: 5px;
                padding: 5px 10px;
                color: #ffffff;
                cursor: pointer;
                font-size: 16px;
                border: none;
            }
            input[type="submit"]:hover{
                background-color: #2f9233;
            }
        </style>
</head>
<body style="background-image:url(../../laboratorio/img/logoNew2Agua.jpg)">
<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../../PHPMailer/src/Exception.php';
	require '../../PHPMailer/src/PHPMailer.php';
	require '../../PHPMailer/src/SMTP.php';
	
	$msg = '';
	
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

	if(isset ($_GET['emailDoc'])){
		$emailDoc= $_GET['emailDoc'];
	}else {
		$emailDoc= NULL;
	}
	
	if(isset ($_GET['fecha'])){
		$fechaDoc = $_GET['fecha'];
		$date1 = date_create_from_format('Y-m-d',$fechaDoc)->format('d/m/Y');
		$date2 = date_create_from_format('Y-m-d',$fechaDoc)->format('d-m-Y');
		//$fechaDoc = $date->format('d-m-Y');
	}else {
		$fechaDoc= NULL;
	} 

	if(isset ($_GET['hora'])){
		$hora = $_GET['hora'];
		$hora1 = substr($hora, 0, -3);
	}else {
		$hora= NULL;
	}
		
	if(isset ($_GET['cirujano'])){
		$cirujano= $_GET['cirujano'];
	}else {
		$cirujano= NULL;
	} 
		
	if(isset ($_GET['estaus'])){
		$estaus= $_GET['estaus'];
		if($estaus == '4'){
			echo '<h2> NO ES POSIBLE ENVIAR CORREO DE UNA CIRUGÍA CANCELADA </h2>
					<br/><br/>
					<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>';
			exit;
		}
	}else {
		$estaus= NULL;
	}

if (isset ($_POST['emaildestino'])) {
	//Variable de correo
	if(isset ($_POST['emaildestino'])){
		$emaildestino= $_POST['emaildestino'];
	}else {
		$emaildestino= NULL;
	}
	if(isset ($_POST['emailCC'])){
		$emailCC= $_POST['emailCC'];
	}else {
		$emailCC= NULL;
	}
	
	$mail = new PHPMailer();                              // Passing `true` enables exceptions
	try {
		//Server settings
		$mail->CharSet = 'utf-8';
		$mail->Encoding = "base64";
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
		$mail->Username = "quirofano@henridunant.com.mx";     // SMTP username
		$mail->Password = "Quirofano018";                     // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		//$mail->SMTPKeepAlive = true;
		//$mail->Mailer="smtp";
		
	
		// First handle the upload
		// Don't trust provided filename - same goes for MIME types
		// See http://php.net/manual/en/features.file-upload.php#114004 for more thorough upload validation
		//$uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name']));
		$my_path = "quirofanoMini.pdf";
		// if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		$mail->setFrom("quirofano@henridunant.com.mx","Hospital Henri Dunant");
		//Email del destinatario
		$mail->addAddress($emaildestino, $cirujano);
		//Email Con Copia
		$mail->AddCC($emailCC);
		//$mail->AddCC("pgomez@henridunant.com.mx");
		$mail->AddCC("jmiranda@henridunant.com.mx");
		$mail->AddCC("quirofano@henridunant.com.mx");
		// Set email format to HTML
		$mail->isHTML(true);
		$mail->Subject = 'Programación de cirugía en el Hospital Henri Dunant';
		//$mail->Body = 'Mi Cuerpo del MSJ';
		//Content
		$mail->AddEmbeddedImage('../../img/logoNew.jpg', 'logoHD');
		$mail->Body = 'Buen día <b> '.$cirujano.' </b>
		 			el presente correo es para informarle que tiene programada una cirugía para el día <b>'
					.$date1.'</b> a las <b>'.$hora1.' horas </b> en el quirófano del Hospital Henri Dunant.<br><br>
					Se anexa un archivo con los datos de la cirugía, cualquier error o duda sobre los datos favor de informarlo inmediatamente
					respondiendo a este correo o a los telefonos del Hospital.
					<br>
					<br>
					(777) 315-3411 <br>
					(777) 316-0486 <br>
					(777) 316-7992 <br>
					(777) 322-2442 
					<br><br>
					Saludos cordiales.
					<br><br> <img alt="LogoDelHD" src="cid:logoHD" >';

		// Attach the uploaded file
		$mail->addAttachment($my_path, 'Datos Cirugia_'.$date2.'.pdf');
		if (!$mail->send()) {
			$msg .= "Error del Mailer1 : " . $mail->ErrorInfo;
		} else {
			$msg .= '<h2>Correo Enviado a:<h2> '.$emaildestino;
		}
		/*$msg .= 'BODY: Buen día <b> '.$cirujano.' </b>
		 			El presente correo es para informarle que tiene programada una círugía para el día '
					.$date1.' a las '.$hora.' hrs. en el Hospital Henri Dunant.<br><br> Se anexa archivo con todos los datos de la cirugía,
					cualquier error o duda sobre los datos favor de informarlo inmediatamente. <br><br> Saludos cordiales.';*/
    } catch (Exception $e) {
    	echo 'El mensaje no se pudo enviar. Mailer Error2: ', $mail->ErrorInfo;
	}
}
?>

<?php if (empty($msg)) { ?>
	<div align="center">
    <form method="post" enctype="multipart/form-data">
		<h2> Enviar Correo a Cirujano con datos de Cirugía </h2>
		<label>Correo destinatario (Puede editarlo):</label>
            <input type="email" name="emaildestino" value="<?php echo $emailDoc ?>" autocomplete="off"/>
		<label>Si desea enviar una copia del Correo a otra dirección de correo, añadir la dirección en el siguiente recuadro:</label>
            <input type="email" name="emailCC" autocomplete="off"/>
        <!--input type="hidden" name="MAX_FILE_SIZE" value="100000"> Enviar este Archivo: <input name="userfile" type="file"-->
        <input type="submit" value="Enviar Email" style="width: 140px; height: 60px" >
    </form>
		<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>
<?php } else {
    echo $msg; ?>
	<br/><br/>
		<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>
<?php } ?>
	</div>
</body>
</html>