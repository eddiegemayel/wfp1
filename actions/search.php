<?php
	
	session_start();

	$q = $_POST['q'];

	$_SESSION['q'] = $q;


	$user="root";
	$pass="root";
	$dbh = new PDO("mysql:host=localhost; dbname=Retrospective; port=8889;", $user,$pass);
	//display anything that matches what user searched for.
	//tags, photoname, username, whatever they searched for
	$stmt = $dbh->prepare("SELECT * FROM photos WHERE (title = :title)");
	$stmt->bindParam(":title", $_SESSION['q'], PDO::PARAM_STR);
	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	//store results into session to be referenced later
	$_SESSION['searchResults'] = $results;

	// var_dump($_SESSION['searchResults'])
	
	header('Location: ../searchPage.php');
?>

<!-- <script type="text/javascript" src="main.js">
// test();

// </script>-->