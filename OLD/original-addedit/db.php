<?php  
	$conn = mysqli_connect('127.0.0.1', 'root', '', 'updayte');
	// mysqli_select_db($conn, $database);	 
	if (!$conn)
    {
	 die('Could not connect: ' . mysql_error());
	}
?>

