<?php
	
	session_start();
	//if user is not logged in, push them back to index
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
		$stmt = $dbh ->prepare("UPDATE photos SET title = :title, description = :description, people = :people, tags = :tags WHERE id = :id");
		//push new info entered by user
		$stmt->bindParam(':title', $_POST["photoName"], PDO::PARAM_STR);
		$stmt->bindParam(':id', $_SESSION["photoId"], PDO::PARAM_STR);
		$stmt->bindParam(':description', $_POST["photoDescription"], PDO::PARAM_STR);
		$stmt->bindParam(':people', $_POST["photoPeople"], PDO::PARAM_STR);
		$stmt->bindParam(':tags', $_POST["photoTags"], PDO::PARAM_STR);
        $stmt->execute();


        // var_dump($stmt);     
    	//push user back to their profile
		header("Location: ../home.php");

	}//end of logged in if statement

?>