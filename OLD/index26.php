<?php error_reporting(E_ALL ^ E_NOTICE);
$host = '127.0.0.1';
$user = 'root';
$pwd = '';

if(isset($_POST['changeDB'])){
$_COOKIE['DATABASE'] = $_POST['DATABASE'];
}
if(isset($_POST['changetab'])){
$_COOKIE['TABLE'] = $_POST['TABLE'];
}

if(isset($_COOKIE['DATABASE'])){
$database = $_COOKIE['DATABASE'];
}else{
$database = 'updayte';
}
if(isset($_COOKIE['TABLE'])){
$TABLE = $_COOKIE['TABLE'];
}else{
$TABLE = 'books';
}
echo $database . '+ ';
echo $TABLE;
$conn = mysqli_connect($host, $user, $pwd, $database);
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PHP Admin Panel</title>
</head>
<body>
<center>
<h2>Russell's Simple Custom PHP/MySQL Form</h2>
<form method="post">
<table border="1" width="25%" bordercolor="green">
	<tr><td>Title:</td><td align=center><input type="text" name="title" /></td></tr>
	<tr>
		<td>Author</td>
		<td align=center><input type="text" name="author" /></td>
	</tr>
	<tr>
		<td>Title</td>
		<td align=center><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>Date</td>
		<td align=center><input type="text" name="copy" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align=center><input type="submit" name="add" value="Add Record/Row" /></td>
	</tr>
</table>
</form>
<br/>
<?php
	if (isset($_POST['add']))
	{	  
			 		$title=$_POST['title'] ;
					$author= $_POST['author'] ;					
					$date=$_POST['date'] ;
					$platform=$_POST['platform'] ;
		mysqli_select_db($conn, $database);										
		 mysqli_query($conn, "INSERT INTO $TABLE(title,author,date,platform) 
		 VALUES ('$title','$author','$date','$platform')"); 
	}
	if(isset($_POST['deletebutton']))
	{
		$values = $_POST['deletebox'];
		foreach($_POST['deletebox'] as $checked) 
		{
			mysqli_query($conn, "DELETE FROM $TABLE WHERE id = '$checked'");
			echo '<b><font color="red">Book with ID <font color="blue">' . $checked . '</font> has been successfully deleted!</b><br></font>';
		} 
	echo '<br/>'; 
	mysqli_close($conn);
	}
?>
<table border="1" width="50%" bordercolor="blue">
<form method="post" name="options">
<tr><td colspan=8 align=center><input type="submit" name="changeDB" value="Change Database" /> Database: <select name="DATABASE">
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
</select><input type="submit" name="changetab" value="Change Table"/> Table:<select name="TABLE">
<?PHP
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
	mysqli_select_db($conn, $database);
	$result=mysqli_query($conn, "SELECT * FROM $TABLE ORDER BY date");
	if($result){
			while($test = mysqli_fetch_array($result))
			{
				$id = $test['id'];	
				echo "<tr align='center'>";	
				echo"<td><font color='black'>" .$test['id']."</font></td>";
				echo"<td><font color='black'>" .$test['title']."</font></td>";
				echo"<td><font color='black'>". $test['author']. "</font></td>";
				echo '<td><font color=black><a href=' . $test['source']. '>' . $test['source'] . '</font></td>';
				echo"<td><font color='black'>". $test['platform']. "</font></td>";	
				echo '<td><font color=black>' . $test['date'] . '</td>';
				echo"<td> <a href ='view.php?id=$id&DATABASE=$database&TABLE=$TABLE'>Edit</a></td>";
				// echo"<td> <a href ='del.php?id=$id'><center>Delete</center></a>";
				echo '<td><input type="checkbox" name="deletebox[]" value="' . $test['id'] . '"></td>';
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
						echo '<b><font color="red">Book with ID <font color="blue">' . $checked . '</font> has been successfully deleted!</b><br></font>';
					} 
				echo '<br/>'; 
			}	
?>
</center>
</body>
</html>