<?php
	$user = "root";
	$password = "";
	$database = "sia1";
	$con = mysqli_connect("127.0.0.1",$user,$password);
	mysqli_select_db($con, $database);
?>