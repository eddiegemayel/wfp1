<?php
	session_start();
	// ob_start();

	//make date the correct format
	$date = $_POST['month'] ."/". $_POST['day'] ."/". $_POST['year'];

	//path to upload directory
	$uploadDirectory = "./uploads/";

	//total upload path in db
	$_SESSION["uploadfile"] = $uploadDirectory.basename($_FILES["filename"]["name"]);

	//trying to explode tags
	// $tags = explode(" ",$_POST["tags"]);

	//if file is attempting to be uploaded
	if(isset($_FILES['filename'])) {
		//check for errors
    	$errors     = array();
    	$maxsize    = 3097152;
    	$acceptable = array(
        	'image/jpeg',
        	'image/jpg',
        	'image/gif',
        	'image/png'
    	);
    	//if filesize is too large
    	if(($_FILES['filename']['size'] >= $maxsize) || ($_FILES["filename"]["size"] == 0)) {
        	echo '<!DOCTYPE html>
					<html>
						<head>
							<title>Create</title>
							<meta charset="UTF-8">
							<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
							<link rel="stylesheet" href="css/main.css" type="text/css"/>
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
							<!-- Latest compiled and minified JavaScript -->
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
						</head>
	
						<body>
							<div class="wrapper tabs col-xs-12">
								<header class="navbar navbar-fixed-top col-xs-12">
									<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
										<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        									<li id="albums"><a title="Albums" href="home.php"></a></li>
        									<li id="add" class="active"><a title="Create" href="create.php"></a></li>
        									<li id="search"><a title="Search" href="searchPage.php"></a></li>
        									<li id="menu"><a title="Menu" href="menu.php"></a></li>
    									</ul>
									</nav>
								</header>
							<div class="content col-xs-12">
								<h3>File size too large, must be less than 3 megabytes. <a href="create.php">Upload another photo.</a></h3>


							</div><!-- end of content div-->
						</div><!-- end of wrapper div -->
					</body>
					<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
					<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
					<script type="text/javascript" src="main.js"></script>
				</html>';
    	}else{
    		//otherwise upload the file
        	move_uploaded_file($_FILES["filename"]["tmp_name"], $_SESSION["uploadfile"]);
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
	}else{
		echo '<!DOCTYPE html>
					<html>
						<head>
							<title>Create</title>
							<meta charset="UTF-8">
							<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
							<link rel="stylesheet" href="css/main.css" type="text/css"/>
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
							<!-- Latest compiled and minified JavaScript -->
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
						</head>
	
						<body>
							<div class="wrapper tabs col-xs-12">
								<header class="navbar navbar-fixed-top col-xs-12">
									<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
										<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        									<li id="albums"><a title="Albums" href="home.php"></a></li>
        									<li id="add" class="active"><a title="Create" href="create.php"></a></li>
        									<li id="search"><a title="Search" href="searchPage.php"></a></li>
        									<li id="menu"><a title="Menu" href="menu.php"></a></li>
    									</ul>
									</nav>
								</header>
							<div class="content col-xs-12">
								<h3>Error, <a href="create.php">please try again.</a></h3>


							</div><!-- end of content div-->
						</div><!-- end of wrapper div -->
					</body>
					<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
					<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
					<script type="text/javascript" src="main.js"></script>
				</html>';
	}

?>