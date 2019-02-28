<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	
</style>
	<title>Hospital Henri Dunant</title>
	<meta http-equiv="refresh" content="1500">
	<link rel=stylesheet href="stylo.css" type="text/css">
</head>
<body >
<center>
<div class="head">
		<h1>Archivos existentes</h1>
		<?php 
		$pos = NULL;
		$directorio='archivos';
		$contArchivos=0;
		if ($dir = opendir($directorio)) {
			while ($archiv = readdir($dir)) {
				if ($archiv != '.'&& $archiv != '..') {
					$contArchivos++;
					$pos = strpos($$archiv, '.pdf');
					echo "<h2>$archiv</h2>";
					if($pos !== true){
						echo "<embed src='archivos/$archiv#toolbar=0'  width='800' height='985' href='$archiv'></embed><br>";
					}else{
						echo '<img src="archivos/$archiv" alt="" />';
					}
				}
			}
			echo "Total de archivos: <strong> $contArchivos </strong>";
		}
		 ?>
	</div>
</center>
</body>
</html>