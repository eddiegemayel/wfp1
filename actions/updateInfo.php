<?php
	//start up session
	session_start();

	//make sure user is logged in
	if(!isset($_SESSION['username'])){ 
    	header("Location: ../index.html");
	}else{

		//update.php
		//connect to database
		$user="root";
		$pass="root";
		$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
		//update photo title
		$stmt = $dbh ->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
		//push new info entered by user
		$stmt->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
		$stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
		$stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();
 
    	//push user back to their profile
		header("Location: ../settings.php");

	}//end of logged in if statement

?>