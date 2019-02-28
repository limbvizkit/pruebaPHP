<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>SubeImagenResguardo</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>

<body background="../img/logoNew2Agua.jpg">
<?php
	#Archivo con la conexion para MYSQL
  	require_once('../conexion/configRepo.php');
  	$msg = NULL;
  	
  	if(isset ($_POST['idMater'])){
		$idMater = $_POST['idMater'];
	} else {
		$idMater = NULL;
	}
  	
	$uploadedfileload="true";
	$uploadedfile_size=$_FILES['uploadedfile']['size'];
	$uploadedfile_name=$_FILES['uploadedfile']['name'];
	
	if ($uploadedfile_size > 2000000)
	{
		$msg=$msg."<br /><h1>El archivo es mayor que 2MB, debe reducirlo antes de subirlo</h1><br />";
		$uploadedfileload="false";
	}
	
	if (!($_FILES['uploadedfile']['type'] =="image/jpeg" /*OR $_FILES['uploadedfile']['type'] =="image/gif" OR $_FILES['uploadedfile']['type'] =="image/png"*/))
	{
		$msg=$msg." <br /><h2>Tu imagen tiene que ser JPG. Otros formatos no son permitidos</h2><br />";
		$uploadedfileload="false";
	}
	
	$file_name=$_FILES['uploadedfile']['name'];
	$add="../img/$file_name";
	
	if($uploadedfileload=="true"){
		if(move_uploaded_file ($_FILES['uploadedfile']['tmp_name'], $add)){
			echo " <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SE CARGO LA IMAGEN <strong>".$uploadedfile_name."</strong> CORRECTAMENTE <br/>";
			$queryUpdImg="UPDATE materiaresguardo SET idImagen = '$add' WHERE materiaresguardo.idMaterial = $idMater";
			$result0 = mysqli_query($conexion, $queryUpdImg);
			if(!$result0){
				echo'!! ERROR AL INSERTAR IMAGEN EN LA BD !!<br/>';
				echo '<br/>Query UPD: '.$queryUpdImg;
				exit;
			} else {
				echo '<br/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp!!!! SE INSERTO LA IMAGEN EN BD CORRECTAMENTE!!!!</strong><br/>';
				#echo '<br/>Query UPD: '.$queryUpdImg;
			}
		}else {
			echo "Error al subir el archivo";
		}
	}else {
		echo $msg; 
	}
?>
<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> SALIR </a>
</body>
</html>

