<?php
	//login page
	//grab user and password from inputs
	session_start();
	ob_start();

  //store username and password entered
	$username = $_POST['email'];
	$password = md5($_POST['password']);

  //default album sort settings
  $_SESSION['sortVariable1'] = 'albumYear';
  $_SESSION['sortVariable2'] = 'DESC';

	try{
    //connnect to database, check login against users table in the database
		$user="root";
		$pass="root";
		//make new database connection
		$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
		$stmt = $dbh ->prepare("SELECT id,email, password FROM users WHERE email = :email and password = :password");

		//grab a user that matched
		$stmt->bindParam(':email', $username , PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);

    //execute the connection
    $stmt->execute();
    $results= $stmt->fetchAll(PDO::FETCH_ASSOC);

    //store into variables
    $id = $results[0]['id'];
  
      	
    //see if the user exists
    if($id == false){
            header("Location: ../loginfail.html");
            //if they are not in database tell them the error
            $_SESSION['loginFail'] = true;
            
      }
      //if the login is correct store into session variables for easy global access across all php files
    else{
              $_SESSION['user_id'] = $id;
              $_SESSION['username'] = $username;
          
              //go their profile page
              header('Location: ../home.php'); 
        }
  //if something goes wrong
	} catch(Exception $e) {
    	echo 'Error -'. $e->getMessage();
  }
	
?>