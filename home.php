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
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums" class="active"><a href="#tab1"></a></li>
        				<li id="add"><a href="#tab2"></a></li>
        				<li id="search"><a href="#tab3"></a></li>
        				<li id="menu"><a href="#tab4"></a></li>
    				</ul>
				</nav>
			</header>

			<div class="content tab-content col-xs-12">
				<!--------------------------------------------------------------------------------------------------------------------	Tab 1(Album Feed) Content -->
				<div id="tab1" class="tab active">
				<!--<button click="test();">Hello</button>-->
					<p>Welcome, '.$_SESSION['username'].'</p>';

		//connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh->prepare("SELECT * from albums WHERE createdBy = :username ORDER BY id DESC");
        $stmt->bindParam(':username', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();     

        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        //loop and display albums
        foreach($results as $key){
         	
            echo '<div class="album col-lg-6 col-lg-offset-3">
            	<h3>'.$key['albumTitle'].'</h3>
            	<p>('.$key['albumYear'].')</p>';

				$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
				//display anything that matches what user searched for.
				//tags, photoname, username, whatever they searched for
				$stmt = $dbh->prepare("SELECT * FROM photos WHERE (albumId = :albumId)");
				$stmt->bindParam(":albumId", $key['id'], PDO::PARAM_STR);
				$stmt->execute();
				$photoResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            	foreach($photoResults as $photoKey){
            		      echo '<div class="imageInAlbum">
        					<div class="flip-ContainerSmall" id="flip-toggle">
							<div class="flipperSmall" id="photo">
							<div class="frontSmall">
								<!--FRONT -->
								<img height="100px" width="100px" src="'.$photoKey['photoUrl'].'"/>
								<h3>'.$photoKey['title'].'</h3>
							</div>
							<!--<div class="backSmall">
								<!-- BACK-->
								<!--<p><strong>Description:</strong> '.$photoKey['description'].'</p> 
							</div>-->
							</div><!-- end of small flipper div -->
							</div><!-- End of small flip container-->
						</div><!-- End of whole image div -->';
         
            	}
        		
			echo '</div><!-- End of whole album div -->';
         
        }

		echo '
				</div><!--  Tab 1 Content Ends -->

				<!------------------------------------------------------------------------------------------------------------	 Tab 2(Add) Content Begins -->
				<div id="tab2" class="tab">
					<div class="col-xs-6">
						<form method="POST" action="upload.php" enctype="multipart/form-data">
							<p>Upload</p>
							<p><input type="file" name="filename" accept="image/*" capture="camera"/></p>
							<p><input type="text" name="title" placeholder="Title of Image"/></p>
							<p><input type="text" name="desc" placeholder="Description"/></p>
							<p>
								<select name="album" required>';
        							//loop and display all albums this user has created
        							foreach($results as $key){
         	
           				 				echo '<option value='.$key['id'].'>'.$key['albumTitle'].' ('.$key['albumYear'].')</option>';
        							}

						echo '			
								</select>

							</p>
							<input type="submit"/>
						</form>
					</div>
					<div class="col-xs-6">
						<p>Create an Album</p>
						<form method="POST" action="albumCreate.php">
							<p><input type="text" name="albumTitle" placeholder="Album Title Here"/></p>
							<p><input type="text" name="albumYear" placeholder="Album Year"/></p>
							<input type="Submit"/>
						</form>
					</div>
				</div>

				<div id="tab3" class="tab">
				<!------------------------------------------------------------------------------------------------------------	 Tab 3(Search) Content Begins -->
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

		echo '</div>

			<div id="tab4" class="tab">
			<!------------------------------------------------------------------------------------------------------------	 Tab 4 Logout Content Begins -->
				<a href="logout.php"><p>Logout</p></a>
				<a><p>Settings</p></a>
			</div>';
?>  


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="jquery.flip.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>