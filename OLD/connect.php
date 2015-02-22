<?php
	$mysql_host = 'localhost';
	$mysql_user = 'root';
	$mysql_password = '';
	$mysql_database = 'books';

	$con = mysqli_connect($mysql_host, $mysql_user, $mysql_password);
	mysqli_select_db($con, $mysql_database);

	// Check connection
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

?>