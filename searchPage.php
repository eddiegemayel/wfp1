<?php
	session_start();


//display their collection
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Search</title>
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
        				<li id="albums"><a href="home.php"></a></li>
        				<li id="add"><a href="create.php"></a></li>
        				<li id="search" class="active"><a href="searchPage.php"></a></li>
        				<li id="menu"><a href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>';




	echo'			

			<div class="content col-xs-12"/>
				<div >
				<!------------------------------------------------------------------------------------------------------------	 Tab 3(Search) Content Begins -->
					<form id="searchForm" method="POST" action="actions/search.php" >
						<input type="text" placeholder="Search.." name="q"/>
						<input type="Submit" value="Search" />
					</form>';


			//onSubmit="$test();"


		//if statement to see if the user has searched for anything
		if($_SESSION['searchResults'] != ''){

			//if so, echo the results
			echo '<h3>Results for: "'.$_SESSION['q'].'"</h3>';

			//loop through results
			foreach($_SESSION['searchResults'] as $searchKey){
				echo '
				<div class="image col-lg-6 col-lg-offset-4">
        		<div class="flip-container" id="flip-toggle">
					<div class="flipper">
						<div class="front">
							<!--FRONT -->
							<img height="300px" width="300px" src="'.$searchKey['photoUrl'].'"/>
							<h3>'.$searchKey['title'].'</h3>
						</div>
						<div class="back">
							<!-- BACK-->
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

		echo '</div>';


?>


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>