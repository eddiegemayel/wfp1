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
				<nav class="col-lg-8 col-lg-offset-2 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-3 col-xs-12">
					<ul class="tab-links col-md-7 col-md-offset-4 col-xs-12">
        				<li id="albums"><a title="Albums" href="home.php"></a></li>
        				<li id="add" class="active"><a title="Create" href="create.php"></a></li>
        				<li id="search"><a title="Search" href="searchPage.php"></a></li>
        				<li id="menu"><a title="Menu" href="menu.php"></a></li>
    				</ul>
				</nav>
			</header>';

		//connect to database
        $user="root";
        $pass="root";
        $dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

        //select everything in the photo table where created by equals currently logged in user   
        $stmt = $dbh->prepare("SELECT * from albums WHERE createdBy = :username ORDER BY albumTitle DESC");
        $stmt->bindParam(':username', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->execute();     

        //fetch all the results and put them into an associative arraay
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


			echo'<!------------------------------------------------------------------------------	 Tab 2(Add) Content Begins -->
				<div class="wrapper col-xs-12">
					<div class="content col-xs-12" >
					<div class="col-xs-6 uploadPicture">
						<form method="POST" action="upload.php" enctype="multipart/form-data">
							<h2 id="normalFont">Upload Photo</h2>
							<p><input class="inputRestrict" id="upload" type="file" name="filename" accept="image/*" capture="camera" required/></p>
							<p><input class="inputStyled" type="text" name="title" placeholder="Title" maxlength="14" required/></p>
							<p><textarea name="desc" placeholder="Description" required maxlength="55"></textarea></p>
							<p><input class="inputRestrict" id="month" type="text" name="month" placeholder="MM" maxlength="2"/> - <input class="inputRestrict" id="day" type="text" name="day" placeholder="DD" maxlength="2"/> - <input class="inputRestrict" id="year" type="text" name ="year" placeholder="YYYY" maxlength="4"/></p>
							<p><input class="inputStyled" type="text" name="people" placeholder="People" maxlength="40"/></p>
							<p><input class="inputStyled" type="text" name="tags" placeholder="Tags" required maxlength="40"/></p>
							<p>
								<select name="album" required>
								';
        							//loop and display all albums this user has created
        							foreach($results as $key){
         	
           				 				echo '<option value='.$key['id'].'>'.$key['albumTitle'].' ('.$key['albumYear'].')</option>';
        							}

						echo '			
								</select>

							</p>
							<input class="uploadBtn" type="submit" value="Upload"/>
						</form>
					</div>
					<div class="col-xs-6 createAlbum">
						<h2 id="normalFont">Create Album</h2>
						<form method="POST" action="actions/albumCreate.php">
							<p><input class="inputStyled" type="text" name="albumTitle" placeholder="Album Title Here"/></p>
							<p><input class="inputStyled inputRestrict" type="text" name="albumYear" placeholder="Album Year"/></p>

							<input class="createBtn" type="submit" value="Create"/>
						</form>
					</div>
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