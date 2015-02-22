<?php 
error_reporting(E_ALL ^ E_NOTICE);
$host = '127.0.0.1';
$user = 'root';
$pwd = '';
	function write($fn, $text){
		$file = fopen($fn, 'w');
		fwrite($file, $text);
		fclose($file);
	}
	function read($fn){
		$file = fopen($fn,"r");
		$contents = fread($file,filesize($fn));
		fclose($file);
		return $contents;
	}
// echo '$database: ';
$database = read("database.txt");
// echo '<br/>';
//echo '$TABLE: '; 
$TABLE = read("TABLE.txt");
// echo '<br/>';
if(isset($_POST["changeTABLE"])){
		$TABLE = $_POST['TABLE'];
		$database = read('database.txt');
		write ('database.txt', $database);
		write('TABLE.txt', $TABLE);
}
if(isset($_POST['changeDB'])){
		$database = $_POST['DATABASE'];
		write('database.txt', $database);
}
$conn = mysqli_connect($host, $user, $pwd);
if(isset($_POST['deletebutton']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
		$values = $_POST['deletebox'];
		foreach($_POST['deletebox'] as $checked) 
		{
			mysqli_select_db($conn, $database);
			$fields = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
			$fields = mysqli_fetch_array($fields);
			mysqli_query($conn, "DELETE FROM $TABLE WHERE $fields[0] = '$checked'");
		}}
		
if (isset($_POST['add'])){	  
	$TABLE = read("TABLE.txt");
	$database = read("database.txt");
	$conn = mysqli_connect($host, $user, $pwd);
	mysqli_select_db($conn, $database);
	$results = array();
	$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	if (!mysqli_query($conn, "SHOW COLUMNS FROM $TABLE")) {
    print_r(mysqli_error_list($conn));
};
	
	while($result2 = mysqli_fetch_row($result)){
	array_push($results, $result2[0]);
	}	
	echo '$results: ';
	var_export($results);
			 $data1 = '';
			 $data2 = '';
			 $data3 = '';
			 $data4 = '';
		mysqli_query($conn, "INSERT INTO $TABLE($results[1],$results[2],$results[3],$results[4]) 
		 VALUES ('$data1','$data2','$data3','$data4')"); 
}
mysqli_select_db($conn, $database);
$Y = mysqli_query($conn, "SHOW TABLES");
	$tablearray = array();
	while($table = mysqli_fetch_array($Y)){
		array_push($tablearray, $table[0]);
	}
	// echo '<pre>';
	// print_r($tablearray);
	// echo '</pre>';
		if (count($tablearray) <> 0){
		$index = count($tablearray) - 1;
			$TABLE_GEN = $tablearray[$index];
		}else{
		echo "That <b>database</b> contains no <b>tables</b>.<br/>";
		}
if ($TABLE === 'Russell'){
	$TABLE = $TABLE_GEN;
}
//echo 
$database = read("database.txt");
//echo 
$TABLE = read("TABLE.txt");
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PHP Admin Panel</title>
<link rel="stylesheet" href="pure.min.css">
<link rel="stylesheet" href="sheet.css">
</head>
<body>
<center>
<h3>Russell's Simple Custom PHP/MySQL Form<br/>By: Russell Rounds</h3>
<form method="post" name="options" class="pure-form">
<table border="0" width="25%" bordercolor="green" align="center" class="pure-table">
<tr><th><b>Field</b></th><th><b>Value</b></th></tr>
<?PHP //Form
	$results2 = array();
	$conn = mysqli_connect($host, $user, $pwd);
	mysqli_select_db($conn, $database);
	$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	if ($result){
		while($result1 = mysqli_fetch_row($result)){
		array_push($results2, $result1[0]);
	}}
	
	if (!$result){ // If Table Doesn't Exist
	if (isset($TABLE_GEN)){
	$TABLE = $TABLE_GEN;
	$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	while($result1 = mysqli_fetch_row($result)){
	array_push($results2, $result1[0]);
	}
	}}
	echo "$results2";
	// var_export($results2);
	foreach($results2 as $colname){
	echo '<tr><td align="center">' . $colname . '</td><td align="center"><input type="text" name=""' . $colname . '" size="50"></td></tr>';
	}
?>
	<tr>
		<td>&nbsp;</td>
		<td align=center><input type="submit" name="add" value="Add Record/Row" class="button-success pure-button button-small"/></td>
	</tr>
</table><br/>
<table border="1" width="50%" bordercolor="blue" class="pure-table pure-table-horizontal">
<tr><td colspan=8 align=center><input type="submit" name="changeDB" value="Change/Set Database" class="pure-button-primary pure-button button-small"  id="SDB"/> Database: <select name="DATABASE" id="DBdropdown" onchange="myFunction2(true)">
<?php 
	mysqli_select_db($conn, $database);
	$Z = mysqli_query($conn, "SHOW DATABASES");
	while($DATABASE = mysqli_fetch_array($Z)) 
		{
			if($DATABASE[0] == $database)
			{
				echo '<option value="' . $DATABASE[0] .'" selected=selected>'. $DATABASE[0] .'</option>';
			}else{
				echo '<option value="' . $DATABASE[0] .'">'. $DATABASE[0] .'</option>';
			}
		}
?>
</select><label for="table_"> Table:</label>
<input type="submit" name="changeTABLE" value="Display Table" class="pure-button-primary pure-button button-small" id="TDB"/> <select name="TABLE" id="TABLE" onchange="myFunction(true)" >
<?PHP
	mysqli_select_db($conn, $database);
	$Q = mysqli_query($conn, "SHOW TABLES");
	while($table = mysqli_fetch_array($Q)){
				if($table[0] == $TABLE){
					echo '<option value="' . $table[0] .'" selected=selected>'. $table[0] .'</option>';
				}else{
					echo '<option value="' . $table[0] .'">'. $table[0] .'</option>';
				}
				$table[0] = $TABLE;
				// $TABLE = $table[0];
			}
?>
</select></td></tr>
<?php
	mysqli_select_db($conn, $database);
	$result=mysqli_query($conn, "SELECT * FROM $TABLE");
	if (!$result){
		echo '<tr><td colspan="7" align="center"><b><font color="red">"';
		echo $database . '->' . $TABLE;
		echo '" Not Found.  Using Default Table "';
		echo $database . '->' . $TABLE_GEN;
		echo '" instead.</b></td></tr>';
		$TABLE = $TABLE_GEN;
		$result=mysqli_query($conn, "SELECT * FROM $TABLE");
	}
	 if($result){
			while($test = mysqli_fetch_array($result)){
			$fields = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
			$fields = mysqli_fetch_array($fields);
				$id = $test[$fields[0]]; // $id for the deletebutton 	
				echo "<tr align='center'>";	
				echo"<td><font color=black>" .$test[0]."</font></td>";
				echo"<td><font color='black'>" .$test[1]."</font></td>";
				echo"<td><font color='black'>". $test[2]. "</font></td>";
				echo"<td><font color='black'>";
				if (isset($test[3])){
				echo $test[3];
				}
				echo " </font></td>";
				if(isset($test['source'])){				
					echo '<td><font color=black><a href=' . $test['source']. '>' . $test['source'] . '</font></td>';
				}else{
					echo '<td>';
					if (isset($test[4])){
						echo '<font color=black>' . $test[4];
					}else{
						echo '&nbsp;';
					}
				echo '</td>';
				}
				echo "<td> <a href ='view-row.php?id=$id&DATABASE=$database&TABLE=$TABLE' class='button-warning pure-button button-xsmall'>Edit</a></td>";
				// echo"<td> <a href ='del.php?id=$id'><center>Delete</center></a>";
				echo '<label for="terms" class="pure-checkbox">';
				echo '<td><input type="checkbox" name="deletebox[]" value="' . $test[0] . '"></td>';
				echo '</label>';
				echo "</tr>";
			}	}
?>
<tr align=center><td colspan=3><input type="submit" name="test" value="Debug Button" class="button-secondary pure-button"/></td>
<td colspan=4><input type="submit" name="deletebutton" value="Delete Selected" class="button-error pure-button" /></td></tr>
</form></table><br/>
<?PHP
	
				if (isset($_POST['test']))
				{	  
					echo '<pre>$GLOBALS: ';
					var_dump($GLOBALS);
					echo '</pre>';
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
				}
			if(isset($_POST['deletebutton'])){ // So it prints delete notifications below the form
				foreach($_POST['deletebox'] as $checked) 
					{
						echo '<b><font color="red">Row with ID <font color="blue">' . $checked . '</font> has been successfully deleted!</b><br></font>';
					} 
				echo '<br/>'; 
			}	
?>
</center>
<script>
<!-- Functions to Show/Hide Buttons/Lists-->
function myFunction(blurbool) {
    document.getElementById("SDB").disabled = blurbool;
	document.getElementById("DBdropdown").disabled = blurbool;
}
function myFunction2(blurbool) {
    document.getElementById("TDB").disabled = blurbool;
	document.getElementById("TABLE").disabled = blurbool;
}
</script>
</body>
</html>