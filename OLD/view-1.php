<?php
require("db.php");
mysqli_select_db($conn, $database);
$id =$_REQUEST['id'];

$result = mysqli_query($conn, "SELECT * FROM `books` WHERE `id`  = $id");
$test = mysqli_fetch_array($result);
if (!$result) 
		{
		die("Error: Data not found..");
		}
				$Title=$test['title'] ;
				$Author= $test['author'] ;					
				$PublisherName=$test['date'] ;
				$CopyrightYear=$test['CopyrightYear'] ;

if(isset($_POST['save']))
{	
	$title_save = $_POST['title'];
	$author_save = $_POST['author'];
	$name_save = $_POST['name'];
	$copy_save = $_POST['copy'];

	mysqli_query($conn, "UPDATE books SET Title ='$title_save', Author ='$author_save',
		 PublisherName ='$name_save',CopyrightYear ='$copy_save' WHERE BookID = '$id'")
				or die(mysql_error()); 
	echo "Saved!";
	
	header("Location: index2.php");			
}
mysqli_close($conn);
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form method="post">
<table>
	<tr>
		<td>Title:</td>
		<td><input type="text" name="title" value="<?php echo $Title ?>"/></td>
	</tr>
	<tr>
		<td>Author</td>
		<td><input type="text" name="author" value="<?php echo $Author ?>"/></td>
	</tr>
	<tr>
		<td>Publisher Name</td>
		<td><input type="text" name="name" value="<?php echo $PublisherName ?>"/></td>
	</tr>
	<tr>
		<td>Copyright Year</td>
		<td><input type="text" name="copy" value="<?php echo $CopyrightYear ?>"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="save" value="save" /></td>
	</tr>
</table>
</body>
</html>
