<?php
	//start session
	session_start();

	//if user is not logged in, push them back to index
if(!isset($_SESSION['username'])){ 
    header("Location: index.html");
}else{

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
			<header id="header" class="navbar navbar-fixed-top col-xs-12">
				<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums" class="active"><a title="Albums" href="home.php"></a></li>
        				<li id="add"><a title="Create" href="create.php"></a></li>
        				<li id="search"><a title="Search" href="searchPage.php"></a></li>
        				<li id="menu"><a title="Menu" href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>
			<div class="content container-fluid col-xs-12">
				
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
        //loop through only image
           foreach($results as $key){
         
            echo '
           
            <div class="image col-lg-2 col-lg-offset-4">
        <div class="flip-container" id="flip-toggle">
			<div class="flipper" id="photo">
				<div class="front one-edge-shadow">
					<!--FRONT -->
					<img height="390px" width="454px" src="'.$key['photoUrl'].'" style="padding-top:3px;"/>
					<h1 id="handwriting">'.$key['title'].'</h1>
				</div>
				<div class="back one-edge-shadow">
					<!-- BACK-->
					<h2>Description:</h2><h4 id="handwriting">'.$key['description'].'</h4>';
					if($key['date'] != '//'){
						echo'<h2>Date:</h2> <h4 id="handwriting">'.$key['date'].'</h4>';
					}
					else{
						echo '<h2>Date:</h2> <h4 id="handwriting">N/A</h4>';
					}
					echo'<h2>People:</h2><h4 id="handwriting">'.$key['people'].' </h4>
					<h2>Tags:</h2><h4 id="handwriting">'.$key['tags'].'</h4>
					<a class="editBtn " href="edit.php?photoId='.$key['id'].'"><img src="images/icons/pencil.svg" width="30px" height="33px" title="Edit"/></a>
				</div>
			</div>
				
			</div><!-- End of flip div -->


		</div><!-- End of whole image div -->
		
		
		';
        }


        echo '
        	<div class="buttons container">
				<a class="deleteBtn" href="actions/delete.php?photoId='.$key['id'].'" ><img src="images/icons/delete.svg" width="30px" height="33px" title="Delete"/></a>
        		<a class="downloadBtn" href="actions/download.php?url='.$key['photoUrl'].'"><img src="images/icons/download.svg" width="30px" height="33px" title="Download"/></a>
        		<a class="flipBtn" id="toggle" onclick="$(\'#flip-toggle\').toggleClass(\'active\');"><img src="images/icons/arrow.svg" width="30px" height="33px" title="Flip"/></a>
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
<?php
	}//end of logged in if statement
?>