<?php
	//initiate session
	session_start();

	//retrieve album info for deletion
	$results = $_SESSION['deleteResults'];


	// //connect to database
	$user="root";
	$pass="root";
	$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
	//delete based on unique photoid in the GET

	// var_dump($_POST['multiple']);

	foreach ($_POST['multiple'] as $key ) {
		// echo ''.$key.' ';
		
		$stmt = $dbh ->prepare("DELETE FROM photos where id = :id");
		$stmt->bindParam(':id', $key, PDO::PARAM_STR);
    	$stmt->execute();   
	}

	header("Location: home.php");




	  

		// $stmt = $dbh ->prepare("DELETE FROM photos WHERE id IN ((1,2),(3,4),(5,6))");
   	

	// $dbh3 = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
 //    $dbh3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
 //    //select everything in the photo table where created by equals currently logged in user   
 //    $stmt3 = $dbh3->prepare("UPDATE albums SET photoTotal = photoTotal - 1 WHERE id = :id");
 //    $stmt3->bindParam(':id', $results[0]['albumId']);
 //    $stmt3->execute();     

?>