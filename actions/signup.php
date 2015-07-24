<?php
	//start up session
	session_start();
	ob_start();

	//collect user's inputs
	$new_username = $_POST['newUsername'];
	$new_password = md5($_POST['newPassword']);
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
			header("Location: ../signup.html");
		}
		else{
			//something went wrong!
			echo '<!DOCTYPE html>
<html>
	<head>
		<title>Retrospective</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="css/main.css" type="text/css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="icon" type="image/png" href="images/icons/favicon.png" />
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</head>
	<body id="landingPageContent">
		<div id="bgWrapper">
		<div id="logoContainer" class="col-xs-12 col-lg-8 col-lg-offset-2">
			<img id="logo" class="img-responsive" height="307" width="959" src="images/logoMain.png"/>
		</div>

		<div class="wrapper col-xs-12">
			<div class="CTA col-xs-12">
				<p>Sorry, there was a stupid error! Please <a href="../index.html">try again.</a></p>
			</div>
		</div>
	</div>
	</body>
</html>


			';
		}
			

	//if statement to see if user is already taken or not

?>