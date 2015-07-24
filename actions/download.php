<?php
	session_start();

	// $size = filesize($file);

	//allows user to download selected image
	//url is passed through anchor tag and retrieved in this file
	header('Content-Description: File Transfer');
	// header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$_GET['url'].'"');
	// header('Content-Transfer-Encoding: binary');
// header('Connection: Keep-Alive');
// header('Expires: 0');
// header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
// header('Pragma: public');
// header('Content-Length: ' . $size);
	readfile($_GET['url']); 

?>