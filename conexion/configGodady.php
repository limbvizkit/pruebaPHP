<?php

define('DB_SERVER', '23.229.165.72');
define('DB_SERVER_USERNAME', 'jgomez');
define('DB_SERVER_PASSWORD', '12qwaszX');
define('DB_DATABASE', 'login_archivos');

$conexion = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
if (!$conexion) {
			echo '!!!! NO se pudo conectar a la base de datos login_archivos!!!!'. PHP_EOL;
			echo "ERROR de depuración: " . mysqli_connect_error() . PHP_EOL;
	    	exit;
}
#mysql_select_db(DB_DATABASE, $conexion);

?>