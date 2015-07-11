<?php
	//start session
	session_start();

	//if user is not logged in, push them back to index
if(!isset($_SESSION['username'])){ 
    header("Location: index.html");
}else{

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
				<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums" class="active"><a title="Albums" href="home.php"></a></li>
        				<li id="add" ><a title="Create" href="create.php"></a></li>
        				<li id="search"><a title="Search" href="searchPage.php"></a></li>
        				<li id="menu"><a title="Menu" href="menu.php"></a></li>
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

		echo '
		<div class="col-xs-12">
		<form method="POST" action="actions/update.php" >';

        foreach($results as $key){

?>
	
	 		<p>Title: <input class="inputStyled editRight" type="text" name="photoName" maxlength="14" value="<?=$key['title']?>"/></p>
	 		<p>Description: <input class="inputStyled editRight" type="text" name="photoDescription" maxlength="55" value="<?=$key['description']?>"/></p>
	 		<!--<p>Date: <input type="text" name ="photoName" value="<?=$key['date']?>"/></p>-->
	 		<p>People: <input class="inputStyled editRight" type="text" name ="photoPeople" maxlength="40" value="<?=$key['people']?>"/></p>
	 		<p>Tags: <input class="inputStyled editRight" type="text" name ="photoTags" maxlength="40" value="<?=$key['tags']?>"/></p>
						 
			<p><input class="searchBtn" type="submit" value ="Accept Edit"/></p>	
	
		


<?php
			}//end of forloop

	

?>

		</form> 
			</div>
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