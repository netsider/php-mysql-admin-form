<?php 
error_reporting(E_ALL ^ E_NOTICE);
$host = '127.0.0.1';
$user = 'root';
$pwd = '';
if(isset($_POST)){
		$_COOKIE["DATABASE"] = $_POST["DATABASE"];
			if (isset($_POST['TABLE'])){
			$_COOKIE["TABLE"] = $_POST["TABLE"];
}}
if(isset($_COOKIE["DATABASE"])){
$database = addslashes($_COOKIE["DATABASE"]);
}else{
$database = "updayte";
}
if(isset($_COOKIE["TABLE"])){
$TABLE = addslashes($_COOKIE["TABLE"]);
}else{
$TABLE = 'books';
}
$conn = mysqli_connect($host, $user, $pwd, $database);
if(isset($_POST['deletebutton'])){ // delete button (delete's array of checked box's using a foreach loop)
		$values = $_POST['deletebox'];
		foreach($_POST['deletebox'] as $checked) 
		{
			mysqli_select_db($conn, $database);
			$fields = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
			$fields = mysqli_fetch_array($fields);
			mysqli_query($conn, "DELETE FROM $TABLE WHERE $fields[0] = '$checked'");
		} 
}
if (isset($_POST['add']))
	{	  
	mysqli_select_db($conn, $database);
	$results = array();
	$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	while($result2 = mysqli_fetch_row($result)){
	
	array_push($results, $result2[0]);
	$length = count($results);
	}	
		var_export($results[1]);
		echo '<br/>';
		var_export($results[2]);
		echo '<br/>';
		var_export($results[3]);
		echo '<br/>';
		var_export($results[4]);
		echo '<br/>';
		var_export($results[5]);
	
		$data1 = $_POST[$results[1]];
		$data2 = $_POST[$results[2]];					
		$data3 = $_POST[$results[3]];
		$data4 = $_POST[$results[4]];
		 mysqli_query($conn, "INSERT INTO $TABLE($results[1],$results[2],$results[3],$results[4]) 
		 VALUES ('$data1','$data2','$data3','$data4')"); 
}
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PHP Admin Panel</title>
</head><body><center>
<h2>Russell's Simple Custom PHP/MySQL Form</h2>
<form method="post" name="options">
<table border="1" width="25%" bordercolor="green">
<tr><th><b>Field</b></th><th><b>Value</b></th></tr>
<?PHP //New Row Form
	$results2 = array();
	$conn = mysqli_connect($host, $user, $pwd, $database);
	mysqli_select_db($conn, $database);
	$result = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
	while($result1 = mysqli_fetch_row($result)){ //loop fetches one row per pass until end above query's result
	array_push($results2, $result1[0]);
	}
	echo '<br/>';
	var_export($results2);
	foreach($results2 as $colname){ // generates form names/elements for current table based on the results of above query
	echo '<tr><td align="center">' . $colname . '</td><td align="center"><input type="text" name=""' . $colname . '" size="50"></td></tr>';
	echo '<br/>';
	}
?>
	<tr>
		<td>&nbsp;</td>
		<td align=center><input type="submit" name="add" value="Add Record/Row" /></td>
	</tr>
</table>
<br/>
<table border="1" width="50%" bordercolor="blue">
<tr><td colspan=8 align=center><input type="submit" name="changeDB" value="Change Database/Table" /> Database: <select name="DATABASE">
<?php 
	$Z = mysqli_query($conn, "SHOW DATABASES");
	while($table = mysqli_fetch_array($Z)) 
		{
			if($table[0] == $database)
			{
				echo '<option value="' . $table[0] .'" selected=selected>'. $table[0] .'</option>';
			}else{
				echo '<option value="' . $table[0] .'">'. $table[0] .'</option>';
			}
		}
?>
</select> Table:<select name="TABLE">
<?PHP
	mysqli_select_db($conn, $database);
	$Q = mysqli_query($conn, "SHOW TABLES");
	while($table = mysqli_fetch_array($Q)) 
			{
				if($table[0] == $TABLE)
				{
					echo '<option value="' . $table[0] .'" selected=selected>'. $table[0] .'</option>';
				}else{
					echo '<option value="' . $table[0] .'">'. $table[0] .'</option>';
				}
			}
?>
</select></td></tr>
<?php
	//$result=mysqli_query($conn, "SELECT * FROM $TABLE ORDER BY date");
	$result=mysqli_query($conn, "SELECT * FROM $TABLE");
	if($result){
			while($test = mysqli_fetch_array($result))
			{
			$fields = mysqli_query($conn, "SHOW COLUMNS FROM $TABLE");
			$fields = mysqli_fetch_array($fields);
				$id = $test[$fields[0]];	
				echo "<tr align='center'>";	
				echo"<td><font color='black'>" .$test[0]."</font></td>";
				echo"<td><font color='black'>" .$test[1]."</font></td>";
				echo"<td><font color='black'>". $test[2]. "</font></td>";
				echo"<td><font color='black'>". $test[3]. "</font></td>";
				if(isset($test['source'])){				
				echo '<td><font color=black><a href=' . $test['source']. '>' . $test['source'] . '</font></td>';
				}else{
				echo '<td><font color=black>' . $test[4] . '</td>';
				}
				echo"<td> <a href ='view.php?id=$id&DATABASE=$database&TABLE=$TABLE'>Edit</a></td>";
				// echo"<td> <a href ='del.php?id=$id'><center>Delete</center></a>";
				echo '<td><input type="checkbox" name="deletebox[]" value="' . $test[0] . '"></td>';
				echo "</tr>";
			}
		}
?>
<tr align=center><td colspan=3><input type="submit" name="test" value="Debug Button" /></td>
<td colspan=4><input type="submit" name="deletebutton" value="Delete Selected" /></td></tr>
</form></table><br/>
<?PHP
				if (isset($_POST['test']))
				{	  
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
					echo '</table>';
				}
				
			if(isset($_POST['deletebutton'])){ // So it prints delete notifications below the form
				foreach($_POST['deletebox'] as $checked) 
					{
						echo '<b><font color="red">ID <font color="blue">' . $checked . '</font> has been successfully deleted!</b><br></font>';
					} 
				echo '<br/>'; 
			}	
?>
</center>
</body>
</html>