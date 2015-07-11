<?php
	//always start session
	session_start();
	//if user is not logged in, push them back to index
if(!isset($_SESSION['username'])){ 
    header("Location: index.html");
}else{

	//This page displays an album a user has clicked on and all the photos inside it
	//Get the albums information from the GET anchor link
	$albumId = $_GET['albumId'];
	$albumTitle = $_GET['albumTitle'];
	$albumYear = $_GET['albumYear'];
	$idCount = 0;

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

//display the header and nav
echo '<!DOCTYPE html>
<html>
	<head>
		<title>'.$albumTitle.'</title>
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
        				<li id="add"><a title="Create" href="create.php"></a></li>
        				<li id="search"><a title="Search" href="searchPage.php"></a></li>
        				<li id="menu"><a title="Menu" href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>

			<div class="content col-xs-12">
			<h2 id="normalFont">'.$albumTitle.' ('.$albumYear.') <a class="deleteBtn" href="actions/deleteAlbum.php" title="Delete This Album" ><img src="images/icons/delete.svg" width="30px" height="33px"/></a></h2>';
			
		if(!empty($results)){
			echo'<form id="deleteMultipleForm" method="POST" action="actions/multiple.php">
				<select id="deleteMultiple" name="multiple[]" multiple required>';
				//loop and display all albums this user has created
        		foreach($results as $key){
         	
           				echo '<option value='.$key['id'].'>"'.$key['title'].'"</option>';
        		}
		echo'	</select>
				<input id="delete" class="deleteBtn hidden" type="submit" value="Delete Selected" title="Delete All Selected Photos"/>
			</form>
			';


        //store ids in session variable to be referenced later when picture is deleted
        $_SESSION['deleteResults'] = $_GET['albumId'];

        
           foreach($results as $key){
         	// $idCount = $idCount + 1; 
            echo ' <div class="clearfix visible-xs-block"></div>

            <a id="photoDiv"  class="col-lg-1 col-md-1 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-3 col-xs-offset-3" href="image.php?id='.$key['id'].'" >
            	<div id="'.$idCount.'" class="imageInAlbum2">
        			<div class="flip-containerSmall " id="flip-toggle">
						<div class="flipperSmall" id="photo">
							<div class="frontSmall one-edge-shadow">
								<!--FRONT -->
								<img height="150px" width="150px" src="'.$key['photoUrl'].'"/>
								<h3 id="handwriting">'.$key['title'].'</h3>
							</div>
						<div class="backSmall one-edge-shadow">
							<!-- BACK-->
							<p class="wordWrap"><strong>Description:</strong> <em id="handwriting">'.$key['description'].'</em></p>';
							if($key['date'] != '//'){
							echo'<p class="wordWrap"><strong>Date:</strong> <em id="handwriting">'.$key['date'].'</em></p>';
							}
							else{
								echo '<p class="wordWrap"><strong>Date:</strong> <em id="handwriting">N/A</em></p>';
							}
							echo' <p class="wordWrap"><strong>People:</strong> <em id="handwriting">'.$key['people'].'</em></p>
							<p class="wordWrap"><strong>Tags:</strong> <em id="handwriting">'.$key['tags'].'</em></p>
						</div>
					</div>
			
					</div><!-- End of flip div -->
				</div><!-- End of whole image div -->
		</a>';
         
        }
    }else{
    	echo '<p>This Album Is Lonely! Go <a href="create.php">Add Some Photos</a>!</p>';
    }
       
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