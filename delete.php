<?php
	session_start();

	//connect to database
	$user="root";
	$pass="root";
	$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
	//delete based on unique photoid in the GET
	$stmt = $dbh ->prepare("DELETE FROM photos where id = :id");
	$stmt->bindParam(':id', $_GET["photoId"], PDO::PARAM_STR);
    $stmt->execute();     
    //push them back to profile php with updated information
	header("Location: home.php");

?>