<?php
	//start session
	session_start();

	//This page displays a specific photo a user has clicked on
	//retrieve the id of the photo here to display it
	$photoId = $_GET['photoId'];
	$_SESSION["photoId"] = $photoId;

//display the header and nav
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Edit</title>
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
        				<li id="add" ><a href="create.php"></a></li>
        				<li id="search" ><a href="searchPage.php"></a></li>
        				<li id="menu"><a href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>
			<div class="content col-xs-12">
		
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

        	echo '<form method="POST" action="update.php" >';

?>
	
	 		<p>Title: <input type="text" name ="photoName" value="<?=$key['title']?>"/></p>
	 		<p>Description: <input type="text" name ="photoDescription" value="<?=$key['description']?>"/></p>
	 		<!--<p>Date: <input type="text" name ="photoName" value="<?=$key['date']?>"/></p>-->
	 		<p>People: <input type="text" name ="photoPeople" value="<?=$key['people']?>"/></p>
	 		<p>Tags: <input type="text" name ="photoTags" value="<?=$key['tags']?>"/></p>
						 
			<p><input type="submit" value ="Update"/></p>	
	
		</form> 


<?php
			}

?>


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>