<?php
require('conexion.php');
	
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
	
	if(isset ($_GET['fechaDoc'])){
		$fechaDoc= $_GET['fechaDoc'];
		$fechaDoc = $date->format('d-m-Y');
	}else {
		$fechaDoc= NULL;
	}
	
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //solo ingreso a este bloque de código si el método con el que solicita la página es POST
    $tiempoEspera = 10; //tiempo de espera para recargar la página (aplicado en la lógica de refresh)
    if (!isset($_POST['emaildestino'])) { //validación basica del campo email
        echo 'El email del destinatario es requerido, la página será recargada en ' . $tiempoEspera . ' segundos.';
        echo '<meta http-equiv="refresh" content="' . $tiempoEspera . '">';
        exit();
    }
    if (!isset($_FILES['archivo']) || !isset($_FILES['archivo']['tmp_name']) || strlen($_FILES['archivo']['tmp_name']) < 3) { //validación básica del campo "archivo adjunto"
        echo 'El archivo a ser enviado es requerido, la página será recargada en ' . $tiempoEspera . ' segundos.';
        echo '<meta http-equiv="refresh" content="' . $tiempoEspera . '">';
        exit();
    }
    $origenNombre = 'Hospital Henri Dunant'; //nombre que visualiza el receptor del email como "origen" del email (es quien envía el email)
    $origenEmail = 'jgomez@henridunant.com.mx';//email que visualiza el receptor del email como "origen" del email (es quien envía el email)
    $destinatarioEmail = $_POST['emaildestino']; //destinatario del email, o sea, a quien le estamos enviando el email
    $archivoNombre = $_FILES['archivo']['name']; //nombre del archivo a ser enviado (sin la ruta, solo el nombre con la extensión, por ejemplo: imagen.jpg)
    $archivo = $_FILES['archivo']['tmp_name']; //ruta temporal del archivo a ser adjuntado (ubicación fisica del archivo subido en el servidor)
    $archivo = file_get_contents($archivo); //leeo del origen temporal el archivo y lo guardo como un string en la misma variable (piso la variable $archivo que antes contenía la ruta con el string del archivo)
    $archivo = chunk_split(base64_encode($archivo)); //codifico el string leido del archivo en base64 y la fragmento segun RFC 2045
    $uid = md5(uniqid(time())); //frabrico un ID único que usaré para el "boundary"
    
    $asuntoEmail = 'Programación de Cirugía para '.$fechaDoc .' en Hospital Henri Dunant'; //asunto del email
    
    //cuerpo del email:
    $cuerpoMensaje = "Este es el cuerpo del email\r\n";
    $cuerpoMensaje .= "Esta es la segunda línea del cuerpod\r\n";
    $cuerpoMensaje .= "Tercera línea\r\n";
    $cuerpoMensaje .= "Etc...\r\n";
    //fin cuerpo del email.
    
    //cabecera del email (forma correcta de codificarla)
    $header = "From: " . $origenNombre . " <" . $origenEmail . ">\r\n";
    $header .= "Reply-To: " . $origenEmail . "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
    //armado del mensaje y attachment
    $mensaje = "--" . $uid . "\r\n";
    $mensaje .= "Content-type:text/plain; charset=utf-8\r\n";
    $mensaje .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $mensaje .= $cuerpoMensaje . "\r\n\r\n";
    $mensaje .= "--" . $uid . "\r\n";
    $mensaje .= "Content-Type: application/octet-stream; name=\"" . $archivoNombre . "\"\r\n";
    $mensaje .= "Content-Transfer-Encoding: base64\r\n";
    $mensaje .= "Content-Disposition: attachment; filename=\"" . $archivoNombre . "\"\r\n\r\n";
    $mensaje .= $archivo . "\r\n\r\n";
    $mensaje .= "--" . $uid . "--";
    //envio el email y verifico la respuesta de la función "email" (true o false)
    if (mail($destinatarioEmail, $asuntoEmail, $mensaje, $header)) {
        echo 'El archivo fue enviado correctamente';
    } else {
        echo 'Error, no se pudo enviar el email';
    }
    echo ', la página será recargada en ' . $tiempoEspera . ' segundos.';
    echo '<meta http-equiv="refresh" content="' . $tiempoEspera . '">';
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
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
    <body>
        <form method="POST" enctype="multipart/form-data">
            <h2> &nbsp;&nbsp;Enviar E-mail a Cirujano con archivo adjunto </h2>
            <label>&nbsp;&nbsp;Email destinatario:</label>
            &nbsp;&nbsp;<input type="email" name="emaildestino" value="<?php echo $emailDoc ?>"/>
            <label>&nbsp;&nbsp;Seleccione un archivo:</label>
            &nbsp;&nbsp;<input type="file" name="archivo" />
            &nbsp;&nbsp;<input type="submit" value="Enviar Archivo"/>
        </form>
    </body>
</html>