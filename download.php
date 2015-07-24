<?php
	session_start();

	//start session
	session_start();

	$file = $_GET['url'];
	// $size = filesize($file);

	if(is_file($file)){
		//allows user to download selected image
		//url is passed through anchor tag and retrieved in this file
		header('Content-Description: File Transfer');
		header("Content-type:application/pdf");
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Length: ' . filesize($file));
		readfile($_GET['url']); 
	}else{
		echo 'Error! <a href="home.php">Try again</a>.';
	}

?>