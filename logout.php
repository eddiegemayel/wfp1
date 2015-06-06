<?php
	session_start();

	session_destroy();

	// var_dump($_SESSION['username']);
	header("Location: index.html");
?>