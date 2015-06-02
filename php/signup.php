<?php
	//collect user's inputs
	$new_username = $_POST['newUsername'];
	$new_password = $_POST['newPassword'];

			$user="root";
			$pass="root";
			$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
			$stmt = $dbh->prepare("INSERT INTO users (username, password)
				VALUES (:name, :value)");
			$stmt->bindParam(":name",$new_username);
			$stmt->bindParam(":value",$new_password);

			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			//for developer
			echo "<p>DONE!!</p>";

			//redirect them to login page
			header("Location: home.html");

	//if statement to see if user is already taken or not

?>