<?php
	$srv='SIHOWINSRV';
	$opc=array("Database"=>"SIHOWINXE", "CharacterSet"=>"UTF-8", "UID"=>"jgomez", "PWD"=>"12qwaszX");
	$con=sqlsrv_connect($srv,$opc) or die(print_r(sqlsrv_errors(), true));
	
?>