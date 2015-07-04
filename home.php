<?php
//start the session
session_start();

//if user is not logged in, push them back to index
if(!isset($_SESSION['username'])){ 
    header("Location: index.html");
}else{

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
		<div class="wrapper container-fluid tabs col-xs-12">
			<header class="navbar navbar-fixed-top col-xs-12">
				<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
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
				<h2 id="normalFont">Welcome, "'.$_SESSION['username'].'"!</h2>
				<form action="actions/sort.php" method="POST">
					<select name="sort">
						<option value="">Sort Albums</option>
						<option value="albumYear">Most Recent</option>
						<option value="albumTitle">Title</option>
					</select>
					<input class="sortBtn" type="submit" value="Sort"/>
				</form>
					';

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

        //if users have no albums
        if($results == null){
        	echo'<h4 style="margin-top:50px;">You Have No Albums Yet!</h4>
        			<h5>Create an <a href="create.php">Album</a> First, Then Upload Some Photos!</h5>';
        }else{
        	//loop and display albums
        	foreach($results as $key){
         	
            	echo '<a id="albumDiv" class="album col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1 col-sm-12 col-xs-12" href="album.php?albumId='.$key['id'].'&albumTitle='.$key['albumTitle'].'&albumYear='.$key['albumYear'].'">
            		<h3 id="normalFont">'.$key['albumTitle'].'</h3>
            		<p id="normalFont">('.$key['albumYear'].')</p>';

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
        				
								<div class="flipperSmall" id="photo">
									<div class="frontSmall">
										<!--FRONT -->
										<img height="150px" width="150px" src="'.$photoKey['photoUrl'].'"/>
										<h3 id="handwriting">'.$photoKey['title'].'</h3>
									</div>
								
								</div><!-- end of small flipper div -->
			
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
    	}//end of if statement
		echo '</div><!--  Tab 1 Content Ends -->'; 
	
?>  

		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>

<?php
}//end of logged in if statement
?>