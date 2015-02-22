<?php
	ini_set('session.hash_function','whirlpool');
	session_start(); 
	echo 'Session ID: ';
	echo $id = session_id();
	
	function get_index($table){
	$table = 'links';
		$conn = mysqli_connect('127.0.0.1', 'root', '');
		$database = 'updayte';
		mysqli_select_db($conn, $database);
		// $q = 'SELECT * FROM `links` WHERE paged != "false"';
		$q = 'SELECT * FROM `links` WHERE paged != 0'; // Gets the True Row
		$result = mysqli_query($conn, $q);
		$data = mysqli_fetch_row($result);
		$counter = $data[0];
		$v = "UPDATE $table SET paged = 0 WHERE id = '$counter'"; // Sets OLD ID to Zero
		mysqli_query($conn, $v); 
		// mysqli_query($conn, "UPDATE `$table` SET paged = false WHERE id = $data");  
		$w = "select MAX(id) from $table";
		$max_id = mysqli_query($conn, $w);
		$max_id = mysqli_fetch_row($max_id);
		$next_id = $counter + 1; 
		if($next_id >= $max_id){
			$q = "select MIN(id) from $table";
			$next_id = mysqli_query($conn, $q);
			echo $next_id;
		}
		$v = "UPDATE $table SET paged = 1 WHERE id = '$next_id'";
		mysqli_query($conn, $v);  // CHeck if data is correct
		$q = "SELECT * FROM `links` WHERE id = '$next_id' LIMIT 1"; // Gets the True Row
		$result = mysqli_query($conn, $q);
		return $result;
	}
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
	function crawl($target_url, $mhave, $mnot, $rurl, $index=0){
		if (strpos($target_url,'www.amazon.com') == 0 AND strpos($target_url,'http://') == 0) { // Add URL prefix if not exist
			$target_url = $rurl . $target_url;
			}else{
			$target_url = $target_url;
		}
		$html = new simple_html_dom();
		$html->load_file($target_url);
		$array = array();
		global $count;
		foreach($html->find('a') as $link)
		{
			if (empty($link->href) || empty($link)){
				continue;
			}
			if (strpos($link->href,'www.amazon.com') == 0 AND strpos($link->href,'http://') == 0) { // Add Link Prefix if not exist
				$url = $rurl . urldecode($link->href);
			}else{
				$url = $link->href;
			}
			$pattern2  = '/' . implode('|', array_map('preg_quote', $mhave)) . '/i';
			if(preg_match($pattern2, $url) <> 1) {
				continue;
			}
			$pattern  = '/' . implode('|', array_map('preg_quote', $mnot)) . '/i';
			if(preg_match($pattern, $link) > 0) {
				continue;
			}
			$link_href = $link->href;
			$array[$index]['url'] = $url;
			$array[$index]['parent'] = $target_url;
			$array[$index]['original'] = $link_href;
			$index++;
			echo '</font>';
		}
	return $array;
	}
	
	//Variables/Etc
	$current_index = read('current2.txt');
	include_once('simple_html_dom.php');
	$exclude = ['.mx', '.br', '.au', 'https', 'Media-Player', 'redirect', 'product-reviews', 'services.amazon', 'aws.amazon', '#', 'fresh.amazon', 'nav_a', 'onload=', 'void(0)', 'adobe.com', 'javascript', 'footer_logo', 'pd_pyml_rhf', 'gno_joinprmlogo', 'ref=gno_logo', 'Thread=', 'customer-media'];
	$include = ['www.amazon.com'];
	$root_url = 'http://www.amazon.com';
	if (!isset($index)){
		$index = 0;
	}
	if(isset($_SESSION['data'])){
		$data = $_SESSION['data'];
	}
	
	//$_POST
	if(isset($_POST['plus'])){
		write('current2.txt', $current_index + 1);
		header('Location: ' . $_SERVER['PHP_SELF']);
	}
	if(isset($_POST['minus'])){
		if ($current_index > 0){
		write('current2.txt', $current_index - 1);
		header('Location: ' . $_SERVER['PHP_SELF']);
	}
	}
	if(isset($_POST['clear'])){
		$_SESSION = NULL;
		session_destroy();
		header('Location: ' . $_SERVER['PHP_SELF']);
	}
	if(isset($_SESSION['data'])){
		$index = count($_SESSION['data']);
	}
	if(isset($_POST['submit'])){
		if (isset($_SESSION['data'])){
			// echo 'Using Session URL';
			$url = $_SESSION['data'][$current_index]['original'];
	}else{
			$url = 'http://www.amazon.com/movies';
	}
	$array1 = crawl($url, $include, $exclude, $root_url, $index);
	if (isset($data)){
		$_SESSION['data'] = array_merge($data, $array1);
		$data = $_SESSION['data'];
	}else{
		$_SESSION['data'] = $array1;
		$data = $_SESSION['data'];
	}}
?>
	<html lang = "en">
	<head>
		<meta charset = "utf-8">
	</head>
	<body><center>
	<form method="post">
	<table border="1" width="25%" bordercolor="blue">
	<tr>
	<td><?PHP if (isset($index)){echo '$index: ' . $index; } ?><td colspan=2><?PHP echo 'page_counter: ' . $current_index; ?></td>
	</tr>
		<tr>
			<td align=center><input type="submit" name="submit" value="Run" /><input type="submit" name="clear" value="Clear" /></td>
			<td align=center><input type="submit" name="plus" value="+" /></td>
			<td align=center><input type="submit" name="minus" value="-" /></td>
		</tr>
	</table>
	</form>
	<?php  
	if (isset($_SESSION['data'])){
	echo 'Target URL: '; 
	print_r($_SESSION['data'][$current_index]['url']);
	}
	?>
	</center>
	</body>
</html>
<?PHP
		echo '<br/>';
		
		if(isset($_SESSION['data'])){
		echo '<pre>';
		echo '$_SESSION[data]';
		var_export($_SESSION['data']);
		echo '</pre>';
		}
		echo '<br/>';
		$a = get_index('links');
		print_r($a);
		// var_dump($a);'
		foreach($a as $as){
		// echo $as;
		print_r($as['url']);
		}
		
?>
