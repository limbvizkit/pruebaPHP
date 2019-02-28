<?php

define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', 'farmacia');

$conexion = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
if (!$conexion) {
			echo '!!!! NO se pudo conectar a la base de datos !!!!'. PHP_EOL;
			echo "ERROR de depuración: " . mysqli_connect_error() . PHP_EOL;
	    	exit;
}
#mysql_select_db(DB_DATABASE, $conexion);

?>