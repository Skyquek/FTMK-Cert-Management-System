<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cert";
	
	$connect = mysqli_connect($servername, $username, $password, $dbname);
	
	//check connection
	if(!$connect){
		die("Connection failed: ".mysqli_connect_error());
	}
?>