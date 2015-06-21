<?php
//start the session
session_start();

//display the header and nav
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Albums</title>
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
				<nav class="col-lg-10 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums" class="active"><a href="home.php"></a></li>
        				<li id="add" ><a href="create.php"></a></li>
        				<li id="search" ><a href="searchPage.php"></a></li>
        				<li id="menu" ><a href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>

			<div class="content col-xs-12">
				<!--------------------------------------------------------------------------------------------------------------------	Tab 1(Album Feed) Content -->
				<div id="tab1" class="tab active">
				<form action="actions/sort.php" method="POST">
				<p>Sort By:</p>
					<select name="sort">
						<option value="albumYear">Most Recent</option>
						<option value="albumTitle">Title</option>
					</select>
					<input type="submit" value="Sort"/>
				</form>
					<p>Welcome, '.$_SESSION['username'].'</p>';

		//connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh->prepare("SELECT * from albums WHERE createdBy = :username ORDER BY ".$_SESSION['sortVariable1']." ".$_SESSION['sortVariable2']." ");
        $stmt->bindParam(':username', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();     

        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        //loop and display albums
        foreach($results as $key){
         	
            echo '<a id="albumDiv" class="album col-lg-6 col-lg-offset-3 col-md-10 col-sm-12 col-xs-12" href="album.php?albumId='.$key['id'].'&albumTitle='.$key['albumTitle'].'&albumYear='.$key['albumYear'].'">
            	<h3>'.$key['albumTitle'].'</h3>
            	<p>('.$key['albumYear'].')</p>';

				$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
				//display anything that matches what user searched for.
				//tags, photoname, username, whatever they searched for
				$stmt = $dbh->prepare("SELECT * FROM photos WHERE (albumId = :albumId) LIMIT 4");
				$stmt->bindParam(":albumId", $key['id'], PDO::PARAM_STR);
				$stmt->execute();
				$photoResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

				// var_dump($count($photoResults, COUNT_RECURSIVE));
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
            	//check to see how many photos are in this album
            	if($key['photoTotal'] > 4){
            		//Subtract four to show user how many more photos are in the album
            		$total = $key['photoTotal'] - 4 ;
            		//echo it out
            		echo '<p><span class="highlight">+'.$total.'</span> More...</p>';
            	}else{
            		echo '';
            	}
			echo '</a><!-- End of whole album div -->';
        }
		echo '
				</div><!--  Tab 1 Content Ends -->'; 
?>  

		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>