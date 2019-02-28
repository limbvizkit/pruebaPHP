<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require_once "classes/pdf_to_image.php";
	require_once('../conexion/configGodady.php');
	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';
	

	$nombreArchivo = NULL;

 	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol]))
	{
	   // nos envía a la siguiente dirección en el caso de no poseer autorización
	   header("location: ../index.html");
	}
	//Funcion para add contraseña a documento PDF
	function pdfEncrypt ($origFile, $password, $destFile){

		require_once('../fpdf/fpdi/FPDI_Protection.php');
		$pdf = new FPDI_Protection();

		$pdf->FPDF("P", "in", array('8.27','11.69'));

		$pagecount = $pdf->setSourceFile($origFile);

		for ($loop = 1; $loop <= $pagecount; $loop++) {
			$tplidx = $pdf->importPage($loop);
			$pdf->addPage();
			$pdf->useTemplate($tplidx);
		}
			$pdf->SetProtection(array('print' => 'print'), $password, '');
			$pdf->Output($destFile,'F');

			return $destFile;
	}
		
	//$valor = $_SESSION[$rol];
//////////////////////////////////////////////////////  Subir los archivos, crear el usuario y los registros del archivo en la BD////////////////////////
	$pdf2image = new pdf2image();
	
	$formatos=array('.pdf','.doc','.docx','.xls','.xlsx','.jpg','.png');
	//$directorio='output';
	$contArchivos=0;
	$usuario = NULL;
	$pass = NULL;
	$expediente=NULL;
	$usuarioOld=NULL;
	$paciente=NULL;
	//Dejo esta variable afuera para que todos los pdf de una subida tengan el mismo password(a ver si es verdad :-o)
	$passPDF1 = mt_rand(1000, 9999);
	$passPDF = mt_rand(1000, 9999).base64_encode($passPDF1);

	if (isset($_POST['subir'])) {
		$arrArreas=NULL;
		//Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
		foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
		{
			$contArchivos++;
			$nombreArchivo0=$_FILES['archivo']['name'][$key];
			$nombreArchivo=mt_rand(1, 100).'_'.$nombreArchivo0;
			$nombreTmpArchivo=$_FILES['archivo']['tmp_name'][$key];
			#echo "<br> NOMBRE_ARCH_ANTS: ".$nombreArchivo;

			#Le quitamos caracteres extraños al nombre del archivo
			$nombreArchivo = $pdf2image->scanear_string(utf8_decode($nombreArchivo));
			#echo "<br> NOMBRE_ARCH_DESP: ".$nombreArchivo;

			#Sacamos el substring de la extension
			$ext=substr($nombreArchivo, strrpos($nombreArchivo, '.'));
			
			
			if ($_FILES['archivo']['size'][$key]>2000000)
			{
				echo '<span style="color:red">!!!ERROR!!! El archivo es mayor que 2MB, debes reducirlo antes de subirlo </span>';
			} else {
				#Verificamos que el archivo q se intenta subir tiene extension valida
				if (in_array($ext, $formatos)) {

					if($ext == '.pdf'){						
						//$passPDF = "12qwaszX";
						$origFile = $nombreTmpArchivo;
						$destFile = $nombreTmpArchivo;

						pdfEncrypt($origFile, $passPDF1, $destFile);
					}
					
					//Pasamos el archivo de local al servidor de Godaddy
					// Realizamos la conexion con el servidor FTP
					# Definimos las variables
					$host="23.229.165.72";
					$port=21;
					$user="vcondado";
					$password="Vc0nd4d0!";
					$ruta="/www/web/laboratorio/output/";
					
					$conn_id=@ftp_connect($host,$port);
					if($conn_id)
					{
						# Realizamos el login con nuestro usuario y contraseña
						if(@ftp_login($conn_id,$user,$password))
						{
							# Ingresamos al directorio especificado, si no existe marca error
							if(@ftp_chdir($conn_id,$ruta))
							{
								# Subimos el fichero
								if(@ftp_put($conn_id,$nombreArchivo,$nombreTmpArchivo,FTP_BINARY))
									echo "ARCHIVO subido correctamente";
								else
									echo "No ha sido posible subir el archivo";
							}else
								echo "No existe el directorio especificado";
						}else
							echo "El usuario o la contraseña son incorrectos";
						# Cerramos la conexion ftp
						ftp_close($conn_id);	
					

						if (isset($_POST['expediente']))
						{
							$expediente=$_POST['expediente'];
						}else {
							$expediente= NULL;
						}
						if (isset($_POST['paciente']))
						{
							$paciente=trim(utf8_decode($_POST['paciente']));
							$pacienteN=trim($_POST['paciente']);
						}else {
							$paciente= NULL;
						}

						/*if (isset($_POST['nombreDoc']))
						{
							$nombreDoc=utf8_decode($_POST['nombreDoc']);
						}else {
							$nombreDoc= NULL;
						}*/
						if (isset($_POST['notas']))
						{
							$notas = utf8_decode($_POST['notas']);
						} else {
							$notas = NULL;
						}

						if($contArchivos == 1){
							//Buscamos si existe un usuario para el expediente dado
							$queryUsr = "SELECT * FROM datosdocslab WHERE expediente = '$expediente'";
								$docs = mysqli_query($conexion, $queryUsr) or die (mysqli_error($conexion));

								while($row = mysqli_fetch_array($docs)){
									$usuarioOld = $row['usuario'];
								}

							$recorteNombr=strtok($paciente," ");
							$cadNormal=$pdf2image->scanear_string(utf8_decode($recorteNombr));
							$usuario = mt_rand(1, 1234).strtolower($cadNormal);
							$pass = strtolower($cadNormal).mt_rand(1, 1234);
							$passCod = md5($pass);

							$sql = "INSERT INTO usuarioslab (idUsr, nombreUsr, passwordUsr, rolUsr, idArea)
							 	VALUES (NULL, '$usuario', '$passCod', '14', '19')";

							$result = mysqli_query($conexion, $sql);
							if(!$result){
								echo'<span style="color:red">!ERROR al realizar inserción de datos de nuevo Usuario!</span>';
								echo '<br/>Query AddUsr: '.$sql;
							} else {
								echo '<br/>!!!! SE GUARDARON LOS DATOS CORRECTAMENTE !!!!<br>';
								//echo '<br/>Query AddUsr: '.$sql;
							}
						}

						$usuario=$usuario;
						$pass=$pass;
						$nomArch=utf8_decode($nombreArchivo0);

						/*echo ' !!! LLEGO !!!<br>
						Exp: '.$expediente.'<br>
						Paciente : '.$paciente.'<br>';*/

						$queryAddArchivoLab = "INSERT INTO datosdocslab (idDocumento, expediente, paciente, email, emailCopia, notas, nombreArchivo, rutaArchivo, fechaAlta, usuario, passPDF, estatus) 
							VALUES (NULL, '$expediente', '$paciente', '$emaildestino', '$emailCC', '$notas', '$nomArch', 'www.henridunant.com/web/laboratorio/output/$nombreArchivo', NULL, '$usuario','$passPDF','1')";
							$result0 = mysqli_query($conexion, $queryAddArchivoLab);

							if(!$result0){
								echo'<span style="color:red">!!! ERROR AL GUARDAR DOCUMENTO EN BD!!!</span>';
								echo '<br/>Query Add: '.$queryAddArchivoLab;
								exit;
							} /*else {
								echo '<br/><span class="auto-style3"><strong>!!!! SE GUARDO EL DOCUMENTO CORRECTAMENTE EN LA BD !!!!</strong></span><br>';
								//echo '<br/>Query Add: '.$queryAddArchivoLab;
							}*/
					}else{
						echo "<span style='color:red'>!!! ERROR AL SUBIR EL DOCUMENTO A LA CARPETA DEL SERVIDOR FAVOR DE VERIFICAR CON SISTEMAS !!!</span";
					}
					//closedir('output/'); //Cerramos el directorio de destino
				}else{
					echo '<span style="color:red">!!!ERROR!!! FORMATO DE ARCHIVO NO VALIDO SOLO SE ADMITE: pdf, doc, docx, xls, xlsx, .jpg y .png </span>';
				}
			}
		} //fin Foreach

		//Verificamos si el paciente ya existe segun su No. de Expediente
		$queryUpdArch = "UPDATE datosdocslab SET usuario = '$usuario' WHERE expediente = '$expediente'";
						$result1 = mysqli_query($conexion, $queryUpdArch);

						if(!$result1){
							echo "<span style='color:red'>!!! ERROR AL ACTUALIZAR EL USUARIO DE ANALISIS ANTERIORES. FAVOR DE VERIFICAR CON SISTEMAS !!!</span";
						}

		//Eliminamos el usuario viejito ya no sirve
		$queryDelUsr = "DELETE FROM usuarioslab WHERE nombreUsr = '$usuarioOld'";
						$result2 = mysqli_query($conexion, $queryDelUsr);

						if(!$result2){
							echo "<span style='color:red'>!!! ERROR AL BORRAR EL USUARIO DE ANALISIS ANTERIORES. FAVOR DE VERIFICAR CON SISTEMAS !!!</span";
						}
		//Mostramos por pantallas algunos avisos (comentar para producción?)
		echo '<br/> DATOS PARA QUE EL PACIENTE INICIE SESIÓN ! NO DEBEN ESTAR EN BLANCO !: <br/>';
		
		echo '<br/>USUARIO: '.$usuario;
		echo '<br/>PASSWORD_USR: '.$pass;
		echo '<br/>PASSWORD_PDF: '.$passPDF1;
		$msg = '';
//////////////////////////////////////////////  Aqui comenzamos con el envío de correo////////////////////////////////////////////////////////////////
		//if (isset ($_POST['emaildestino'])) {
			//Variable de correo
			if(isset ($_POST['emaildestino'])){
				$emaildestino= trim($_POST['emaildestino']);
			}else {
				$emaildestino= NULL;
			}
			
			if($emaildestino != '' && $emaildestino != NULL){
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
					$mail->Username = "laboratorio@henridunant.com.mx";   // SMTP username
					$mail->Password = "laboratorio0015";                  // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					//$mail->SMTPKeepAlive = true;
					//$mail->Mailer="smtp";


					// First handle the upload
					// Don't trust provided filename - same goes for MIME types
					// See http://php.net/manual/en/features.file-upload.php#114004 for more thorough upload validation
					//$uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name']));

					//$my_path = "quirofanoMini.pdf";

					// if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
					$mail->setFrom("laboratorio@henridunant.com.mx","Hospital Henri Dunant");
					//Email del destinatario
					$mail->addAddress($emaildestino, utf8_encode($paciente));
					//Email Con Copia
					$mail->AddCC($emailCC);
					//$mail->AddCC("laboratorio_shd@hotmail.com.mx");
					//$mail->AddCC("jmiranda@henridunant.com.mx");
					//$mail->AddCC("laboratorio@henridunant.com.mx");
					$mail->AddCC("jgomez@henridunant.com.mx");
					// Set email format to HTML
					$mail->isHTML(true);
					$mail->Subject = 'Resultados Laboratorio Hospital Henri Dunant';
					//Content
					$mail->AddEmbeddedImage('../img/logoNewPeque.jpg', 'logoHD');
					$mail->Body = 'Buen día <b> '.utf8_encode($paciente).' </b>
								<br>El presente correo es para informarle que puede consultar y descargar<br>
								los resultados de sus estudios de laboratorio ingresando a la siguiente liga:
								<br><br>
								<a href="https://www.henridunant.com/web/laboratorio/index.php"> RESULTADOS DE ESTUDIOS </a>
								<br><br>
								Si no funciona el link copiar el siguiente texto y pegarlo en su navegador: <br>
								https://www.henridunant.com/web/laboratorio/index.php
								<br><br> 
								Debe colocar los datos:<br>
								<b>USUARIO: '.$usuario.'<br>
								CONTRASEÑA: '.$pass.'<br>
								CONTRASEÑA PARA ABRIR PDF\'s: '.$passPDF1.'<br><br>
								La contraseña para abrir PDF solo es valida para los PDF con la fecha de envio de este correo, <br>
								si posee otros documentos en su listado de archivos favor de utilizar la contraseña proporcionada<br>
								en el correo correspondiente.
								<br><br>
								FAVOR DE CONFIRMAR EN CUANTO RECIBA ESTE CORREO</b>
								<br><br>
								Cualquier duda sobre sus resultados favor de informarlo inmediatamente
								respondiendo a este correo o a los teléfonos del Hospital.
								<br><br>
								(777) 322-2442 <br>
								(777) 316-7992 <br>
								(777) 316-0486
								<br><br>
								<b>AVISO: Los archivos tienen una vigencia de 15 días a partir de la fecha de recepción de este correo<br>
								después de este tiempo serán ELIMINADOS y no podrá consultarlos.</b>
								<br><br>
								Saludos cordiales.
								<br><br> <img alt="LogoDelHD" src="cid:logoHD" >';

					// Attach the uploaded file
					//$mail->addAttachment($my_path, 'Datos Cirugia_'.$date2.'.pdf');

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
		//}
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script type="text/jscript" src="js/bootstrap.min.js" crossorigin="anonymous"></script>
        <link rel=stylesheet href="css/stylo.css" type="text/css">
        <style type="text/css">
            .styleBD {
                background-image: url('../img/logoNew2Agua.jpg');
            }
            .auto-style2 {
                font-size: x-large;
            }
            .auto-style3 {
				font-weight: bold;
				font-size: medium;
			}
        </style>
    	 <script type="text/javascript">
        	function rellenar(quien,que){
				cadcero='';
				for(i=0;i<(8-que.length);i++){
					cadcero+='0';
				}
				quien.value=cadcero+que;
			}
        </script>
		<title>Carga de Doc Lab</title>
	</head>
    <body class="styleBD">
        <center>
            <div class="h">
                <div class="head">
					<img alt="LogoHD" src="../img/logoNew2.jpg">
                    <h1>CARGA DE DOCUMENTO DE LABORATORIO</h1>
                    <form action="" method="post" enctype="multipart/form-data">
                        <h1 class="auto-style2">Solo se permiten archivos* <br> (pdf, word, excel e imagenes. Tamaño Max: 2MB)</h1>
                        <input type="file" class="btn btn-primary" id="archivo[]" name="archivo[]" multiple="" required>
						<h1 class="auto-style2">Para subir más de 1 archivo seleccionarlos manteniendo presionada la tecla ctrl</h1>
                        <input type="hidden" name="rol" value="<?php echo $rol ?>" >
                        <br>
                        <br>
                        <strong><span>Número de Expediente* (Colocar un número de expediente real del paciente):</span></strong><br>
                        <input type="text" name="expediente" onblur='rellenar(this,this.value)' style="width: 160px" autocomplete='off' required>
                        <br>
                        <br>
                        <strong><span>Nombre del Paciente*:</span></strong><br>
                        <input type="text" name="paciente" style="width: 460px" required>
                        <br>
                        <br>
                        <strong><span>E-mail del Paciente* :</span></strong><br>
                        <input type="email" name="emaildestino" style="width: 460px" required>
                        <br>
                        <br>
						<strong><span>E-mail de copia (Opcional):</span></strong><br>
                        <input type="email" name="emailCC" autocomplete='off' style="width: 460px">
                        <br>
                        <br>
                        <strong><span>Comentarios, Notas u Observaciones (Opcional):</span></strong><br>
                        <textarea name="notas" cols="50" rows="2"></textarea>
                        <br>
                        <br>
                        <!--input type="hidden" name="rol" value="<?php #echo $rol ?>"-->
                        <input class="btn btn-success" type="submit" value="GUARDAR DATOS" name="subir" style="width: 208px; height: 40px">
                    </form>
                </div>
                <br>
            </div>

        </center>
        <br>
        <input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px">
    </body>

    </html>
