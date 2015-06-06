<?php
	session_start();
	ob_start();

	//collect user's inputs
	$new_username = $_POST['newUsername'];
	$new_password = $_POST['newPassword'];
	$new_email = $_POST['newEmail'];

	//check to make sure fields are not empty

	if($new_username != "" && $new_password != ""){
			//add user to the database
			//setup admin username and password for database
			$user="root";
			$pass="root";
			//calling out the specific database and tables
			$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);

			$stmt = $dbh->prepare("INSERT INTO users (username, password, email)
				VALUES (:name, :pass, :email)");
			$stmt->bindParam(":name",$new_username);
			$stmt->bindParam(":pass",$new_password);
			$stmt->bindParam(":email", $new_email);

			//execute action
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$_SESSION['username'] = $new_username;

			// point them to home logged in page
			header("Location: home.php");
		}
		else{
			//something went wrong!
			echo "<p>User already exists</p>";
		}
			

	//if statement to see if user is already taken or not

?>