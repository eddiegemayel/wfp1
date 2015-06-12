<?php
	//retrieve session
	session_start();

	

	//just in case
	$_SESSION['username'] = '';
	$_SESSION['q'] = '';



	// var_dump($_SESSION['username']);	

	//end it
	session_destroy();

	//put them back to login screen
	header("Location: ../index.html");
?>