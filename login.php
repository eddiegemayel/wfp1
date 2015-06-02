<?php
	//login page
	//grab user and password from inputs
	$username = $_POST['username'];
	$password = $_POST['password'];

	try{
        //connnect to database, check login against users table in the database
		$user="root";
		$pass="root";
		//make new database connection
		$dbh=new PDO('mysql:host=localhost; dbname=Retrospective; port=8889;', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//sets the error mode to exceptions        
		$stmt = $dbh ->prepare("SELECT id,username, password FROM users WHERE username = :username and password = :password");
		$stmt->bindParam(':username', $username , PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        //execute the connection
        $stmt->execute();
        $results= $stmt->fetchAll(PDO::FETCH_ASSOC);

        //check the id
        $id = $results[0]['id'];
        $user_name = $results[0]['username'];
        $pass_word =  $results[0]['password'];
      	
      	//see if the user exists
        if($id == false){
                //if they are not in database tell them the error
                echo '<p>You are not in our database.</p>	';
       	}
       	//if the login is correct store into session variables for easy global access across all php files
        else{
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $user_name;
                // $_SESSION['password']= $pass_word;
               
               //go their profile page
               header('Location: home.html'); 
        }
	} catch(Exception $e) {
    	echo 'Error -'. $e->getMessage();
    }
	
?>