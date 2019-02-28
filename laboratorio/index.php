<!DOCTYPE html> 
<html>
<head>
  <title>Login Intranet</title>
  <meta charset="utf-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap.min.css" >
  <!--link rel="stylesheet" href="assets/css/main.css" /-->
  <style type="text/css">
	  .auto-style1 {
		  text-align: center;
	  }
	  .auto-style1a {
		  text-align: center;
		  background-image: url('img/1280x768-A.JPG');
		  color: #FFFFFF; 
		  font-size: xx-large;
	  }
	  .auto-style2 {
		  font-size: x-large;
	  }
	  .styleBD {
			background-image: url('img/logoNew2Agua.jpg');
		}
  </style>
</head>
<body class="styleBD"> 
	<h1 class="auto-style1a" >RESULTADO DE ESTUDIOS DE LABORATORIO</h1>
	<p class="auto-style1" >
		<img alt="logo1" src="img/logoNew.jpg" style="width: 800px; height: 300px"> 
	</p>
	<br>
	<form method="post" action="acces.php" class="auto-style1" autocomplete="off">
		<div class="auto-style1">
			<span class="auto-style2">Usuario:</span>
			<br class="auto-style2">
			<input type="text" name="usuario" placeholder="Nombre de usuario" required style="width: 230px; height: 50px">
			<br>
			<br>
			<span class="auto-style2">Contraseña:</span>
			<br class="auto-style2">
			<input type="password" name="password" placeholder="Contraseña" required style="width: 230px; height: 50px">
			<br>
			<br>
			<input class="btn-primary" type="submit" name="enviar" value="INGRESAR" style="width: 159px; height: 63px">
		</div>
	</form>
	<br/>
	<!--br/>
	&nbsp;&nbsp;&nbsp;<a href="mailto:jgomez@henridunant.com.mx?Subject=Usuario%20y%20Password" target="_top">jgomez@henridunant.com.mx</a>
	<br/>
	<br/>
	<p><strong>&nbsp;&nbsp;Especificando nombre completo, área, nombre de jefe directo y motivo del correo (Nuevo Usr y Pass o recuperación de datos)</strong></p>
	<br/>
	<br/>
	<footer>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Sistema de Intranet del Hospital Henri Dunant&copy;
    </footer-->
</body>
</html>