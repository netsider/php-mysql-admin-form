<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("America/New_york");
$conn = mysqli_connect('127.0.0.1', 'root', '');
$TABLE = $_GET['TABLE'];
$database = $_GET['DATABASE'];
$id = $_GET['id'];
$id = trim($id);
$TABLE = trim($TABLE);
$database = trim($database);
mysqli_select_db($conn, $database);
$fields = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
$fields = mysqli_fetch_row($fields);
	echo '<pre>$GLOBALS: ';
	var_dump($GLOBALS);
	echo '</pre>';
echo '<br/>';
var_export($fields);
echo '<br/>';
echo $fields = $fields[0];
echo '<br/>';
$result = mysqli_query($conn, "SELECT * FROM $TABLE WHERE $fields = $id");
var_export($result);
//$row = mysqli_fetch_array($result);
if (!$result) {
		die("Error: Data not found26..");
		}
		$column = array();
			$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	while($result2 = mysqli_fetch_row($result)){
	array_push($column, $result2[0]);
	$length = count($column);
	}
	
	
if(isset($_POST['save']))
{	
	echo 'Button Pressed!';
	echo '<br/>';
	mysqli_select_db($conn, $database);
	$number = 0;
	while($number < $length){
	$col = $columns[$number]; 
	$col = trim($col);
	$pdata = $_POST[$col][$number];
	$v = "UPDATE $TABLE SET $col = '$pdata' WHERE id = '$id'";
	mysqli_query($conn, $v);
	
	echo '<br/>';
	$number++;
	}
	echo '<b><font color="green">Saved!</font></b>';
}


$result = mysqli_query($conn, "SELECT * FROM $TABLE WHERE $fields = $id");
$row = mysqli_fetch_array($result);
if (!$result) 
		{
		die("Error: Data not found60..");
		}
		$columns = array();
			$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	while($result2 = mysqli_fetch_row($result)){
	array_push($columns, $result2[0]);
	$length = count($columns);
	}
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Record</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
    <style>
		.button-xsmall {
            font-size: 70%;
        }
        .button-success,
        .button-error,
        .button-warning,
        .button-secondary {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }
        .button-success {
            background: rgb(28, 184, 65); /* this is a green */
        }
        .button-error {
            background: rgb(202, 60, 60); /* this is a maroon */
        }
        .button-warning {
            background: rgb(223, 117, 20); /* this is an orange */
        }
        .button-secondary {
            background: rgb(66, 184, 221); /* this is a light blue */
        }
		.button-small {
            font-size: 85%;
        }
    </style>
</head>
<body>
<center>
<br/>
<form method="post" class="pure-form">
<table border="1" width="25%" class="pure-table pure-table-horizontal">
<tr><td>Table: </td><td><?php echo $TABLE ?></td></tr>
<tr><td>Database: </td><td><?php echo $database ?></td></tr>
<?PHP
$count = 0;
while ($count < $length){
echo '<tr><td>' . $column[$count] . '</td>';
echo '<td><input type="text" name="' . $column[$count] . '" placeholder="' . $row[$column[$count]] . '" class="pure-input-2-3" size="75"></td></tr>';
$count++;
}
?>
<td align="center"><a class="pure-button pure-button-primary button-small" href="index84-working.php">Back</a></td><td align="center"><button class="button-success pure-button button-small" id="save" name="save">Save/Edit Record</button></td></tr> 
</table>
</center><?PHP
					echo '<b>$_REQUEST:</b> ';
					print_r($_REQUEST);
					echo '<br/>';
					echo '<b>$_COOKIE:</b> ';
					print_r($_COOKIE);
					echo '<br/>';
					echo '<b>POST:</b>:';
					print_r($_POST);
					echo '<br/>';
					if(!empty($_SESSION))
						{
							echo '$_SESSION: ';
							print_r($_SESSION);
						}
					echo '<br/>';
					echo '<table width="25%" border="1"><tr><td colspan="2" align=center><font color=blue><b>$_SERVER Superglobal</b>:</font></td></tr><tr><td><b>Key</b></td><td><b>Value</b></td></tr>';
					foreach ($_SERVER as $key => $value){
					echo '<tr><td><b>' . $key . '</b></td>';
					echo '<td>' . $value . '</td>';
					echo '</tr>';
					}
					echo '</table><br/>';
					if($_SERVER['REMOTE_ADDR'] = '127.0.0.1'){
					phpinfo();
					}
					?>
</body>
</html>