<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("America/New_york");
$conn = mysqli_connect('127.0.0.1', 'root', '');
$TABLE = $_REQUEST['TABLE'];
$database = $_REQUEST['DATABASE'];
$id = $_GET['id'];
$id = trim($id);
$TABLE = trim($TABLE);
$database = trim($database);
mysqli_select_db($conn, $database);
$fields = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
$fields = mysqli_fetch_array($fields);

$result = mysqli_query($conn, "SELECT * FROM $TABLE WHERE $fields[0] = $id");
$row = mysqli_fetch_array($result);
if (!$result) 
		{
		die("Error: Data not found..");
		}
		$column = array();
			$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	while($result2 = mysqli_fetch_row($result)){
	array_push($column, $result2[0]);
	$length = count($column);
	}

if(isset($_POST['save']))
{	
	
	echo $TABLE;
	mysqli_select_db($conn, $database);
	$number = 0;
	while($number < $length){
	$col = $column[$number]; 
	$pdata = $_POST[$column[$number]];
	$pdata = trim($pdata);
	$col = trim($col);
	var_dump($pdata);
	$v = "UPDATE $TABLE SET $col = '$pdata' WHERE id = '$id'";
	mysqli_query($conn, $v);
	echo '<br/>';
	$number++;
	}
	
	// mysqli_query($conn, "UPDATE $TABLE SET Title ='$title_save', Author ='$author_save',
		 // PublisherName ='$name_save',CopyrightYear ='$copy_save' WHERE BookID = '$id'")
				// or die(mysql_error()); 
	echo "Saved!";
	//header("Location: index2.php");			
}
	if (!mysqli_query($conn, "UPDATE $TABLE SET $col = '$pdata' WHERE id = '$id'")) {
    print_r(mysqli_error_list($conn));
};
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Record</title>
</head>
<body>
<form method="post">
<table>
<tr><td>Table: </td><td><?php echo $TABLE ?></td></tr>
<tr><td>Database: </td><td><?php echo $database ?></td></tr>
<?PHP

$count = 0;
while ($count < $length){
echo '<tr><td>' . $column[$count] . '</td>';
echo '<td><input type="text" name="' . $column[$count] . '" value="' . $row[$column[$count]] . '"></td></tr>';
$count++;
}
?>
<td>&nbsp;</td><td><input type="submit" name="save" value="save" /></td></tr> 
</table>
</body>
</html>