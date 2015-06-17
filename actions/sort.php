<?php 
	//start session
	session_start();

	//if user sorts by year
	if($_POST['sort'] ==='albumYear'){
		$_SESSION['sortVariable1'] = '';
		$_SESSION['sortVariable1'] = $_POST['sort'];
		$_SESSION['sortVariable2'] = 'DESC';
	}
	//if user sorts by title
	else if($_POST['sort']==='albumTitle'){
		$_SESSION['sortVariable1'] = '';
		$_SESSION['sortVariable1'] = $_POST['sort'];
		$_SESSION['sortVariable2'] = 'ASC';
	}

	//push them back to home page
	header("Location: ../home.php");
?>