<?php
//start session
session_start();
 
 //if user is not logged in, push them back to index
if(!isset($_SESSION['username'])){ 
    header("Location: index.html");
}else{

 //connect to database
 $user="root";
 $pass="root";
 $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

 //select everything in the photo table where created by equals currently logged in user   
 $stmt = $dbh->prepare("SELECT * from users WHERE id = :id");
 $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_STR);
 $stmt->execute();     

 //fetch all the results and put them into an associative arraay
 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


//this page allows user to edit email or username

//display the header and nav
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Menu</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="css/main.css" type="text/css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="icon" type="image/png" href="images/icons/favicon.png" />
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</head>
	
	<body>
		<div class="wrapper tabs col-xs-12">
			<header class="navbar navbar-fixed-top col-xs-12">
				<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums" ><a href="home.php"></a></li>
        				<li id="add" ><a href="create.php"></a></li>
        				<li id="search" ><a href="searchPage.php"></a></li>
        				<li id="menu" class="active"><a href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>

			<div class="content col-xs-12"/>
			
			<!------------------------------------------------------------	 Tab 4 Logout Content Begins -->
				<h2>Settings</h2>';
				echo '<form method="POST" action="actions/updateInfo.php" >';
 				foreach($results as $key){
				?>
				<p id="normalFont">Current Email:</p><p> <input class="inputStyled" type="email" name ="email" value="<?=$key['email']?>"/></p>
	 			<!-- <p id="normalFont">Current Username:</p><p> <input class="inputStyled" type="text" name ="username" value="<?=$key['username']?>"/></p> -->
				<p><input class="uploadBtn" type="submit" value ="Update Info"/></p>
			</form> 

<?php 
			}//end of forloop
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