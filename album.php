<?php
	//always start session
	session_start();

	//This page displays an album a user has clicked on and all the photos inside it
	//Get the albums information from the GET anchor link
	$albumId = $_GET['albumId'];
	$albumTitle = $_GET['albumTitle'];
	$albumYear = $_GET['albumYear'];


//display the header and nav
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
			<h2>'.$albumTitle.'</h2>
			<h3>('.$albumYear.')</h3>
			';

		//connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh->prepare("SELECT * from photos WHERE albumId = :id");
        $stmt->bindParam(':id', $albumId, PDO::PARAM_STR);
        $stmt->execute();     

        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

           foreach($results as $key){
         
            echo '
            <a id="photoDiv" href="image.php?id='.$key['id'].'" >
            <div class="imageInAlbum col-xs-3">
        <div class="flip-containerSmall" id="flip-toggle">
			<div class="flipperSmall" id="photo">
				<div class="frontSmall">
					<!--FRONT -->
					<img height="150px" width="150px" src="'.$key['photoUrl'].'"/>
					<h3>'.$key['title'].'</h3>
				</div>
				<div class="backSmall">
					<!-- BACK-->
					<p><strong>Description:</strong> '.$key['description'].'</p>
					<p><strong></strong></p>
				</div>
			</div>
			
			</div><!-- End of flip div -->
		</div><!-- End of whole image div -->
		</a>';
         
        }


?>


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>