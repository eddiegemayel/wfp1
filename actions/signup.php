<?php
	//start up session
	session_start();
	ob_start();

	//collect user's inputs
	$new_password = md5($_POST['newPassword']);
	$new_email = $_POST['newEmail'];

	try{
        //connnect to database, check login against users table in the database
		$user="root";
		$pass="root";
		//make new database connection
		$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
		$stmt = $dbh ->prepare("SELECT id,email, password FROM users WHERE email = :email");

		//grab a user that matched
		$stmt->bindParam(':email', $new_email , PDO::PARAM_STR);
    	// $stmt->bindParam(':password', $new_password, PDO::PARAM_STR);

    	//execute the connection
    	$stmt->execute();
    	$results= $stmt->fetchAll(PDO::FETCH_ASSOC);

    	//store into variables
    	$id = $results[0]['id'];

    	//see if the user exists
    	if($id){
               		//something went wrong!
			echo '<!DOCTYPE html>
<html>
	<head>
		<title>Retrospective</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="../css/main.css" type="text/css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="icon" type="image/png" href="../images/icons/favicon.png" />
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</head>
	<body id="landingPageContent">
		<div id="bgWrapper">
		<div id="logoContainer" class="col-xs-12 col-lg-8 col-lg-offset-2">
			<img id="logo" class="img-responsive" height="307" width="959" src="../images/logoMain.png"/>
		</div>

		<div class="wrapper col-xs-12">
			<div class="CTA col-xs-12">
				<div class="success col-xs-4 col-xs-offset-4">
					<h1 class="white" id="normalFont">Sign up Failed!</h1>
					<h2 class="white">Email already taken, please <a href="../index.html" class="highlight" >enter</a> another.</h2>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>';
      	}
      	//if the login is correct store into session variables for easy global access across all php files
    	else{
    		$_SESSION['sortVariable1'] = 'albumYear';
  			$_SESSION['sortVariable2'] = 'DESC';
			$_SESSION['user_id'] = $id;
			$_SESSION['username'] = $new_email;
			$stmt2 = $dbh->prepare("INSERT INTO users (email, password)
				VALUES (:email, :pass)");
			$stmt2->bindParam(":email", $new_email);
			$stmt2->bindParam(":pass",$new_password);
			
			//execute action
			$stmt2->execute();
			// $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			

			// point them to home logged in page
			header("Location: ../home.php");
        }
  	//if something goes wrong
	} catch(Exception $e) {
    	echo 'Error -'. $e->getMessage();
  	}

	
		// 	//add user to the database
		// 	//setup admin username and password for database
		// 	$user="root";
		// 	$pass="root";
		// 	//calling out the specific database and tables
		// 	$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);

			
		// }
	// 	else{
	
	// 	}
			

	// //if statement to see if user is already taken or not

?>