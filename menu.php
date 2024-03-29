<?php
//start session
session_start();

//if user is not logged in, push them back to index
if(!isset($_SESSION['username'])){ 
    header("Location: index.html");
}else{

//this page links user to edit settings or logout

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
        				<li id="albums" ><a title="Albums" href="home.php"></a></li>
        				<li id="add" ><a title="Create" href="create.php"></a></li>
        				<li id="search" ><a title="Search" href="searchPage.php"></a></li>
        				<li id="menu" class="active"><a title="Menu" href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>';


			echo'

			<div class="content col-xs-12"/>
			<div>
			<!------------------------------------------------------------------------------------------------------------	 Tab 4 Logout Content Begins -->
				<a href="actions/logout.php"><p>Logout</p></a>
				<a href="settings.php"><p>Settings</p></a>
			</div>';

		}//end of logged in if statement

?>


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>