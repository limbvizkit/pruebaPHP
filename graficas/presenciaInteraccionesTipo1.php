<?php 
	if(isset($_GET['tipo'])){
		$tipo= $_GET['tipo'];
	} else {
		$tipo=NULL;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>PresenciaInteraccionesTipo1</title>
</head>

<body>
	<img src="presenciaInteraccionesTipo.php?tipo=<?php echo $tipo ?>" alt="GraficaTipo" border="0" /> <br />
	<br/>
	<input type="image" src="../img/reg.png" value="REGRESAR" onclick=location.href="javascript:history.back(-1)" height="75" width="161"></input>

</body>

</html>
