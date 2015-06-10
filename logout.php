<?php
	//retrieve session
	session_start();

	//end it
	session_destroy();

	//just in case
	$_SESSION['username'] = '';
	// var_dump($_SESSION['username']);

	//put them back to login screen
	header("Location: index.html");
?>