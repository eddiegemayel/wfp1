<?php
	session_start();

	$photoId = $_GET['id'];

//display their collection
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
				<!-- Logo here -->
				<nav class="col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums" class="active"><a href="home.php"></a></li>
        				<li id="add"><a href="create.php"></a></li>
        				<li id="search"><a href="searchPage.php"></a></li>
        				<li id="menu"><a href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>
			<div class="content col-xs-12">
		
			';


			//connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh->prepare("SELECT * from photos WHERE id = :id");
        $stmt->bindParam(':id', $photoId, PDO::PARAM_STR);
        $stmt->execute();     

        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

           foreach($results as $key){
         
            echo '
            <div class="image col-xs-3 col-xs-offset-4">
        <div class="flip-container" id="flip-toggle">
			<div class="flipper" id="photo">
				<div class="front">
					<!--FRONT -->
					<img height="300px" width="300px" src="'.$key['photoUrl'].'"/>
					<h3>'.$key['title'].'</h3>
				</div>
				<div class="back">
					<!-- BACK-->
					<p><strong>Description:</strong> '.$key['description'].'</p>
				</div>
			</div>
			<!--<button id="toggle" onclick="$(\'#flip-toggle\').toggleClass(\'active\');">Flip</button>-->
			</div><!-- End of flip div -->
			<!--<p><a href="delete.php?photoId='.$key['id'].'">Delete</a> </p>-->
		</div><!-- End of whole image div -->
		';
        	
        	  echo '<div>

        	<p><a href="download.php?url='.$key['photoUrl'].'">Download</a></p>


        	</div>
        	'; 


        }




?>