<?php
	
	
	$db_name="quirofano";
	$mysql_username="root";
	$mysql_password="";
	$server_name="localhost";
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name);

//$servername = "localhost";
//$username = "root";
//$password = "";

// Create connection
//$conn = new mysqli($servername, $username, $password);

// Check connection
	if($conn){
		$conn->set_charset('utf8');
	}else{
		echo "conexion fallida";
}
?>