<?php
//start the session
session_start();


//display their collection
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Create</title>
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
        				<li id="albums" ><a href="home.php"></a></li>
        				<li id="add" class="active"><a href="create.php"></a></li>
        				<li id="search"><a href="searchPage.php"></a></li>
        				<li id="menu"><a href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>';


			//connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh->prepare("SELECT * from albums WHERE createdBy = :username ORDER BY ".$_SESSION['sortVariable']." DESC");
        $stmt->bindParam(':username', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();     

        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


			echo'	<!------------------------------------------------------------------------------------------------------------	 Tab 2(Add) Content Begins -->
				<div class="wrapper col-xs-12">
					<div class="content" />
					<div class="col-xs-6">
						<form method="POST" action="actions/upload.php" enctype="multipart/form-data">
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
						<form method="POST" action="actions/albumCreate.php">
							<p><input type="text" name="albumTitle" placeholder="Album Title Here"/></p>
							<p><input type="text" name="albumYear" placeholder="Album Year"/></p>
							<input type="Submit"/>
						</form>
					</div>
				</div>';

?>


		</div><!-- end of content div-->
		</div><!-- end of wrapper div -->
	</body>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</html>