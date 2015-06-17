<?php
	session_start();
	// ob_start();

	$date = $_POST['month'] ."/". $_POST['day'] ."/". $_POST['year'];

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
			$stmt = $dbh->prepare("INSERT INTO photos (photoUrl, uploadedBy, title, description, albumId, date, people, tags)
				VALUES (:image, :by, :title, :description, :albumId, :date, :people, :tags)");
			$stmt->bindParam(":image",$_SESSION["uploadfile"]);
			$stmt->bindParam(":by",$_SESSION["user_id"]);
			$stmt->bindParam(":title", $_POST['title']);
			$stmt->bindParam(":description", $_POST['desc']);
			$stmt->bindParam(":albumId", $_POST['album']);
			$stmt->bindParam(":date", $date);
			$stmt->bindParam(":people", $_POST['people']);
			$stmt->bindParam(":tags", $_POST['tags']);
			$stmt->execute();
			$user_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

			
			$dbh2 = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
        	$dbh2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        	//select everything in the photo table where created by equals currently logged in user   
        	$stmt2 = $dbh2->prepare("UPDATE albums SET photoTotal = photoTotal + 1 WHERE id = ".$_POST['album']."");
        	$stmt2->execute();     
        
			
			//push back to their profile
			header("Location: home.php");
		}

		else{
			//if the upload failed	
			echo "Failed to upload.";
		}

?>