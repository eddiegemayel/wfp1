<?php
	session_start();

	//allows user to download selected image
	//url is passed through anchor tag and retrieved in this file
	header('Content-Disposition: attachment; filename="'.$_GET['url'].'"'); 
	readfile($_GET['url']); 

?>