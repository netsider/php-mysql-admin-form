<?php
  include("db.php");  

	$id =$_GET['row'];
	$parent=$_GET['parent'];
	// $id =$_REQUEST['BookID'];
	mysql_query("SELLECT FROM $parent_table WHERE BookID = '$id'") or die(mysql_error());  	
	
	mysql_query("DELETE FROM books WHERE BookID = '$id'") or die(mysql_error());  	
	
	header("Location: admin-index.php");
?>