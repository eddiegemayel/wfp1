<?php 
	session_start();
	$_SESSION['sortVariable'] = $_POST['sort'];

	header("Location: home.php");
?>