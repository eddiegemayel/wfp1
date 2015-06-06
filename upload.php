<?php
	session_start();
	// ob_start();

	//path to upload directory
	$uploadDirectory = "./uploads/";

	//total upload path in db
	$_SESSION["uploadfile"] = $uploadDirectory.basename($_FILES["filename"]["name"]);

	//trying to explode tags
	// $tags = explode(" ",$_POST["tags"]);

	// //if file uploads successfully
	if(move_uploaded_file($_FILES["filename"]["tmp_name"], $_SESSION["uploadfile"])){

			//connect to database
			$user="root";
			$pass="root";
			$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
			//insert photo and info
			$stmt = $dbh->prepare("INSERT INTO photos (photoUrl, uploadedBy)
				VALUES (:image, :by)");
			// $stmt->bindParam(":name",$_POST["title"]);
			$stmt->bindParam(":image",$_SESSION["uploadfile"]);
			$stmt->bindParam(":by",$_SESSION["username"]);
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
			header("Location: home.php");
		}

		else{
			//if the upload failed	
			echo "Failed to upload.";
		}

?>