#!/usr/local/bin/php
<?php
	ob_start();
	session_name("Connect");  // specify session name
	session_start(); // continue the session
	
	// the user has not registered
	$_SESSION['registered'] = false;

	$found = false;

	try{
		$users = new SQLite3("userinfo.db");  //open the database, if not exits, create one
	} catch (Exception $ex){     // catch any exceptions and display error message
		echo $ex->getMessage();
	}
	

	
	// open the table that stores user info, if not exists, create a new table
	$statement = "CREATE TABLE IF NOT EXISTS users(name TEXT, password TEXT);";
	$run = $users->query($statement);
	
	// get the username of the current user
	$current_user = $_POST['username'];

	// check if the username has already been registered
	$search_user = "SELECT COUNT(name) FROM users WHERE name = '$current_user';";
	$run = $users->query($search_user);
	$num = $run->fetchArray();

	// if we find a match in the database set $found to true
	if($num[0] !== 0){
		$found = true;
	}
	
	// if the username already exists
	if($found){
		$input_pass = hash('md2', $_POST['pass']);
		$get_pass = "SELECT password FROM users WHERE name = '$current_user';";
		$run = $users->query($get_pass);
		$true_pass = $run->fetchArray();
		// first check if the user already has an account (since the password matches.) If so, ask them to go back and log in
		if($true_pass[0] === $input_pass){
			echo "Your've already registered, please go back to log in!";
			$_SESSION['registered'] = true;
		} else {
			// if the password does not match, it means the username already been used, ask user to register with a different name
			echo "The username already exists. Please register with a different name!";
		}
		
	} else {
		// if the user does not have an account, create an account by adding their login info to database
		$new_user = $_POST['username'];
		$pw = hash('md2', $_POST['pass']);
		$statement = "INSERT INTO users(name, password) VALUES('$new_user', '$pw');";
		$run = $users->query($statement);
		//header("Location: login.php");
		// after registration, user has to return to login page and log in
		echo "You're now registered! Please go back to log in!";
		$_SESSION['registered'] = true;
	}

	$users->close();

?>


<!DOCTYPE html>
<html>
<head>
	<title>register</title>
</head>

<body>
</body>
</html>
