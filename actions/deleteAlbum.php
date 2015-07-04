<?php
	//start session
	session_start();

	// //connect to database
	$user="root";
	$pass="root";
	$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions    

    //store this for the album id. That way I know which album to subtract 1 from the photo total
   	$results =  $_SESSION['deleteResults'];
  
    //subtract 1 from total photo count of specific album  
    $stmt = $dbh->prepare("DELETE FROM albums WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['deleteResults']);
    $stmt->execute();     

    //push them back to profile php with updated information
	header("Location: ../home.php");

?>