<?php
	session_start();
	ob_start();

	//collect user's inputs
	$new_username = $_POST['newUsername'];
	$new_password = $_POST['newPassword'];

	//check to make sure fields are not empty

	if($new_username != "" && $new_password != ""){
			//add user to the database
			//setup admin username and password for database
			$user="root";
			$pass="root";
			//calling out the specific database and tables
			$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);

			$stmt = $dbh->prepare("INSERT INTO users (username, password)
				VALUES (:name, :value)");
			$stmt->bindParam(":name",$new_username);
			$stmt->bindParam(":value",$new_password);

			//execute action
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// point them to home logged in page
			header("Location: home.html");
		}
		else{
			//something went wrong!
			echo "<p>Uh oh!</p>";
		}
			

	//if statement to see if user is already taken or not

?>