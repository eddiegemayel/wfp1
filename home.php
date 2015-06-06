<?php
session_start();
ob_start();
//display their profile page populated with their unique information
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="css/main.css" type="text/css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</head>
	
	<body>
		<div class="wrapper">
			<header class="navbar navbar-fixed-top">
				<!-- Logo here -->
				<nav>
					<h1 class="col-xs-12">navbar</h1>
				</nav>
			</header>

			<div class="content col-xs-12">
				<p>Albums with pictures will be displayed here</p>
				
					 <p>Welcome, '.$_SESSION['username'].'</p>
				
				<form method="POST" action="upload.php" enctype="multipart/form-data">
					<p>Upload</p>
					<input  type="file" name="filename" accept="image/*" capture="camera"/>
					<button type="submit">Submit</button>
				</form>
			

'
            ;

         //connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh ->prepare("SELECT * from photos  WHERE uploadedBy = :username ORDER BY id DESC");
        $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();     
        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($results);
        
        //loop and display
        foreach($results as $key){
         	// var_dump($key);
            echo '<div class="image">'; 
            // echo '<h3>'.$key['id'].'</h3>';
            echo '<img height="300px" width="300px" src="'.$key['photoUrl'].'"/>';
            echo '<p><strong>Uploaded By:</strong> '.$key['uploadedBy'].'</p>';
            echo '<p><a href="delete.php?photoId='.$key['id'].'">Delete</a></p>';
            echo '</div>';
         
        }

?>
		</div>
		</div>
	</body>
</html>