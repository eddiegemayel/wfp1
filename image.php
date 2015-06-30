<?php
	//start session
	session_start();

	//This page displays a specific photo a user has clicked on
	//retrieve the id of the photo here to display it
	$photoId = $_GET['id'];

//display the header and nav
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Photo View</title>
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
        				<li id="albums" class="active"><a title="Albums" href="home.php"></a></li>
        				<li id="add" ><a title="Create" href="create.php"></a></li>
        				<li id="search" ><a title="Search" href="searchPage.php"></a></li>
        				<li id="menu"><a title="Menu" href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>
			<div class="content container-fluid col-xs-12">
				<!--<button class="editBtn" id="toggle" onclick="$(\'#flip-toggle\').toggleClass(\'active\');">Flip</button>-->
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
            <div class="row">
            <div class="image col-lg-2 col-lg-offset-4">
        <div class="flip-container" id="flip-toggle">
			<div class="flipper" id="photo">
				<div class="front">
					<!--FRONT -->
					<img height="350px" width="350px" src="'.$key['photoUrl'].'"/>
					<h1 id="handwriting">'.$key['title'].'</h1>
					<a class="editBtn frontFlip" id="toggle" onclick="$(\'#flip-toggle\').toggleClass(\'active\');"><-</a>
				</div>
				<div class="back">
					<!-- BACK-->
					<h3 id="handwriting">Description:</h3><p id="handwriting">'.$key['description'].'</p>
					<h3 id="handwriting">Date:</h3><p id="handwriting">'.$key['date'].' </p>
					<h3 id="handwriting">People:</h3><p id="handwriting">'.$key['people'].' </p>
					<h3 id="handwriting">Tags:</h3><p id="handwriting">'.$key['tags'].'</p>
					<a class="editBtn backFlip" id="toggle" onclick="$(\'#flip-toggle\').toggleClass(\'active\');">-></a>
				</div>
			</div>
				
			</div><!-- End of flip div -->


		</div><!-- End of whole image div -->

		</div><!-- end of row -->
		';
        }


        echo '
        	<div class="buttons container">
				<a class="deleteBtn" href="actions/delete.php?photoId='.$key['id'].'">Delete</a>
        		<a class="downloadBtn" href="actions/download.php?url='.$key['photoUrl'].'">Download</a>
        		<a class="editBtn " href="edit.php?photoId='.$key['id'].'">Edit</a>
        	</div>
        	'; 
?>


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>