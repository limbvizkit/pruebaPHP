<?php

	define('DB_SERVERE', 'localhost');
	define('DB_SERVER_USERNAMEE', 'root');
	define('DB_SERVER_PASSWORDE', '');
	define('DB_DATABASEE', 'medico');

	$conexionMedico = mysqli_connect(DB_SERVERE, DB_SERVER_USERNAMEE, DB_SERVER_PASSWORDE, DB_DATABASEE);
	if (!$conexionMedico) {
				echo '!!!! NO se pudo conectar a la base de datos Medico!!!!'. PHP_EOL;
				echo "ERROR de depuración: " . mysqli_connect_error() . PHP_EOL;
				exit;
	}
	#mysql_select_db(DB_DATABASE, conexionMedico);

?>