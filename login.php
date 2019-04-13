#!/usr/local/bin/php
<?php
	ob_start(); 
	session_name("Connect");   // specify session name
	session_start(); // start a session
	$_SESSION['loggedin'] = false;  // not logged in yet

	// check if password has been filled in, if so, check if the user has already registered an account 
	if (isset($_POST['pw'])){
		$password = $_POST['pw'];
		validate_user($password);
	}

	/**
	This function takes the password user entered and check if they have an account. If they've entered the correct info, log in to homepage. If account does not exist, give an error message telling them if they need to register or that the credentials do not match
	
	@param string $password takes in the password user entered on the form
	
	@return n/a
	*/

	function validate_user($password) {
		// first try to establish connection with database storing user login info, if doesn't exist, create one
		try{
			$users = new SQLite3('userinfo.db');
		} 
		catch(Exception $exc){ 
			// catch any exceptions thrown and display error message
			echo $exc->getMessage();
		}
		
		
		// get the user's input (username)
		$username = $_POST['user'];
		
		// search for a match in the data table
		$search_user = "SELECT COUNT(name) FROM users WHERE name = '$username';";
		$run = $users->query($search_user);
		$num = $run->fetchArray();

		// get the password corresponding to the username
		$statement = "SELECT password FROM users WHERE name = '$username';";
		$run = $users->query($statement);
		$true_pass = $run->fetchArray();
		
		// hash the user's input password for comparison
		$pw = hash('md2', $password);
		
		// if the username isn't found, asks user to register for an account
		if($num[0] === 0){
			echo 'You do not have an account yet, please go back to register!';
		} else if($pw === $true_pass[0]){
			// if password match, direct the user to their homepage
			$_SESSION['loggedin'] = true;
			$user = $_POST['user'];
			header("Location: homepage.php?user=$user");
		}else{
			// if username is found in database but password does not match, ask user to go back to login page to re-enter credentials
			echo "Incorrect password! Please go back and retry." ;
		}
	}
	// remember the user by storing a $_SESSION variable
	$_SESSION['username'] = $_POST['user'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>login</title>
</head>

<body>
	<main>	
	</main>
</body>
</html>