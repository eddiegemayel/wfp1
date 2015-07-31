<?php
session_start();

		//connect to database
		$user="root";
		$pass="root";
		$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
		//insert photo and info
		$stmt = $dbh->prepare("INSERT INTO albums (albumTitle, albumYear, createdBy)
			VALUES (:title, :year, :by)");
		// $stmt->bindParam(":name",$_POST["title"]);
		$stmt->bindParam(":title",$_POST['albumTitle']);
		$stmt->bindParam(":year",$_POST['albumYear']);
		$stmt->bindParam(":by", $_SESSION['user_id']);

		// $stmt->bindParam(":tags",$_POST["tags"]);
		$stmt->execute();
		$user_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

		//for dev
		// echo "<p>DONE!!</p>";

		// var_dump($_SESSION["username"]);
		//redirect them to login page

		// foreach ($tags as $item) {
   		// 	echo "<li>$item</li>";
		// }
			
		//push back to their profile
		header("Location: ../home.php");

		// var_dump( $_SESSION['user_id']);


?>