<?php
	session_start();

	// //connect to database
	$user="root";
	$pass="root";
	$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
	//delete based on unique photoid in the GET
	$stmt = $dbh ->prepare("DELETE FROM photos where id = :id");
	$stmt->bindParam(':id', $_GET["photoId"], PDO::PARAM_STR);
    $stmt->execute();     


    //store this for the album id. That way I know which album to subtract 1 from the photo total
   	$results =    $_SESSION['deleteResults'];
	$dbh3 = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
    $dbh3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    //select everything in the photo table where created by equals currently logged in user   
    $stmt3 = $dbh3->prepare("UPDATE albums SET photoTotal = photoTotal - 1 WHERE id = :id");
    $stmt3->bindParam(':id', $results[0]['albumId']);
    $stmt3->execute();     

    //push them back to profile php with updated information
	header("Location: ../home.php");

?>