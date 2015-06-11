<?php
//start the session
session_start();

//display their collection
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
		<div class="wrapper tabs col-xs-12">
			<header class="navbar navbar-fixed-top col-xs-12">
				<!-- Logo here -->
				<nav class="col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4">
        				<li id="albums" class="active"><a href="#tab1"></a></li>
        				<li id="add"><a href="#tab2"></a></li>
        				<li id="search"><a href="#tab3"></a></li>
        				<li id="menu"><a href="#tab4"></a></li>
    				</ul>
				</nav>
			</header>

			<div class="content tab-content col-xs-12">
				<!-- Tab 1 Content -->
				<div id="tab1" class="tab active">
				<button click="test();">Hello</button>
					<p>Welcome, '.$_SESSION['username'].'</p>';

		//connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh->prepare("SELECT * from photos  WHERE uploadedBy = :username ORDER BY id DESC");
        $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();     

        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        //loop and display recent images
        foreach($results as $key){
         	
            echo '<div class="image col-lg-6 col-lg-offset-4">
        		<div class="flip-container" id="flip-toggle">
					<div class="flipper" id="photo">
						<div class="front">
							<!--FRONT -->
							<img height="150px" width="150px" src="'.$key['photoUrl'].'"/>
							<h3>'.$key['title'].'</h3>
						</div>
						<div class="back">
							<!-- BACK-->
							<p><strong>Uploaded By:</strong> '.$key['uploadedBy'].'</p>
							<p><strong>Description:</strong> '.$key['description'].'</p>
						</div>
					</div>
					<button id="toggle" onclick="$(\'#flip-toggle\').toggleClass(\'active\');">Flip</button>
				</div><!-- End of flip div -->
				<p><a href="delete.php?photoId='.$key['id'].'">Delete</a> </p>
			</div><!-- End of whole image div -->';
         
        }

		echo '
				</div><!--  Tab 1 Content Ends -->

				<!-- Tab 2 Content Begins -->
				<div id="tab2" class="tab">
					<form method="POST" action="upload.php" enctype="multipart/form-data">
						<p>Upload</p>
						<p><input type="file" name="filename" accept="image/*" capture="camera"/></p>
						<p><input type="text" name="title" placeholder="Title of Image"/></p>
						<p><input type="text" name="desc" placeholder="Description"/></p>
						<!--<input type="text" />-->
						<input type="submit"/>
					</form>
				</div>

				<div id="tab3" class="tab">
					<p>Search</p>
					<form id="searchForm" method="POST" action="search.php" >
						<input type="text" placeholder="Search.." name="q"/>
						<input type="Submit" value="Search" />
					</form>';


			//onSubmit="$test();"


		//if statement to see if the user has searched for anything
		if($_SESSION['searchResults'] != ''){

			//if so, echo the results
			echo '<h3>Search Results for: "'.$_SESSION['q'].'"</h3>';

			//loop through results
			foreach($_SESSION['searchResults'] as $searchKey){
				echo '<div class="image col-lg-6 col-lg-offset-4">
        		<div class="flip-container" id="flip-toggle">
					<div class="flipper">
						<div class="front">
							<!--FRONT -->
							<img height="300px" width="300px" src="'.$searchKey['photoUrl'].'"/>
							<h3>'.$searchKey['title'].'</h3>
						</div>
						<div class="back">
							<!-- BACK-->
							<p><strong>Uploaded By:</strong> '.$searchKey['uploadedBy'].'</p>
							<p><strong>Description:</strong> '.$searchKey['description'].'</p>
						</div>
					</div>
					<button id="toggleFlip" >Flip</button>
				</div>
				<p><a href="delete.php?photoId='.$searchKey['id'].'">Delete</a> </p>
			</div>';
			}
		}
		else{

			//tell them if there are no results
			echo 'No search Results!';
		}

		echo '</div>

			<div id="tab4" class="tab">
				<a href="logout.php"><p>Logout</p></a>
				<a><p>Settings</p></a>
			</div>';

			echo 'hi';
?>  


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="jquery.flip.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>