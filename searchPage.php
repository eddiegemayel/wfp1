<?php
	//starts up the session
	session_start();


//display the header and nav
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
				<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums" ><a title="Albums" href="home.php"></a></li>
        				<li id="add" ><a title="Create" href="create.php"></a></li>
        				<li id="search" class="active"><a title="Search" href="searchPage.php"></a></li>
        				<li id="menu"><a title="Menu" href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>';




	echo'			

			<div class="content col-xs-12"/>
				<div >
				<!-----------------------------------------------------------------------------------------	 Tab 3(Search) Content Begins -->
					<form id="searchForm" method="POST" action="actions/search.php" >
						<input type="text" placeholder="Search.." name="q"/>
						<input class="searchBtn" type="Submit" value="Search" />
					</form>';


			//onSubmit="$test();"


		//if statement to see if the user has searched for anything
		if($_SESSION['searchResults'] != ''){

			//if so, echo the results
			echo '<h3 id="normalFont">Results for: "'.$_SESSION['q'].'"</h3>';

			//loop through results
			foreach($_SESSION['searchResults'] as $searchKey){
				echo '<div class="clearfix visible-xs-block"></div>
				 <a id="photoDiv"  class="col-lg-1 col-md-1 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-3 col-xs-offset-3" href="image.php?id='.$searchKey['id'].'" >
            	<div class="imageInAlbum2">
        			<div class="flip-containerSmall" id="flip-toggle">
						<div class="flipperSmall" id="photo">
							<div class="frontSmall">
								<!--FRONT -->
								<img height="150px" width="150px" src="'.$searchKey['photoUrl'].'"/>
								<h3 id="handwriting">'.$searchKey['title'].'</h3>
							</div>
						<div class="backSmall">
							<!-- BACK-->
							<p id="handwriting"><strong>Description:</strong> <em>'.$searchKey['description'].'</em></p>
							<p id="handwriting"><strong>Date:</strong> <em>'.$searchKey['date'].'</em></p>
							<p id="handwriting"><strong>People:</strong> <em>'.$searchKey['people'].'</em></p>
							<p id="handwriting"><strong>Tags:</strong> <em>'.$searchKey['tags'].'</em></p>
						</div>
					</div>
			
					</div><!-- End of flip div -->
				</div><!-- End of whole image div -->
		</a>';
			}
		}
		else{

			//tell them if there are no results
			echo '<p id="normalFont">No Search Results!</p>';
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