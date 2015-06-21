<?php
	//initiate session
	session_start();

	//retrieve album info for deletion
	$results = $_SESSION['deleteResults'];


	//photo database connect
	$user="root";
	$pass="root";
	$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
	//delete based on unique photoid in the GET
	$dbh3 = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
    $dbh3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

	
	//loop through each photo id that the user wants to delete
	foreach ($_POST['multiple'] as $key ) {
		//delete each one by one in the loop
		$stmt = $dbh ->prepare("DELETE FROM photos where id = :id");
		$stmt->bindParam(':id', $key, PDO::PARAM_STR);
    	$stmt->execute();   

    	//each time a photo is deleted, subtract 1 from the total photo count of the album 
    	$stmt3 = $dbh3->prepare("UPDATE albums SET photoTotal = photoTotal - 1 WHERE id = :id");
    	$stmt3->bindParam(':id', $results[0]['albumId']);
    	$stmt3->execute();  
	}
	//put user back to home
	header("Location: ../home.php");

?>