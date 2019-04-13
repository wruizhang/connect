#!/usr/local/bin/php
<?php
	ob_start();
	session_name("Connect"); // specify session name
	session_start(); // continue session
	date_default_timezone_set('America/Los_Angeles'); // set time zone
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>store comments</title>
</head>

<body>

<?php	
	
	// create or open a database for storing user's comments
	try{
		$comment_manager = new SQLite3('user_comments.db');
	} 
	catch(Exception $exc){
		// catch exceptions and display message
		echo $exc->getMessage();
	}
	
	// open/create table to store comments
	$statement = 'CREATE TABLE IF NOT EXISTS comments(id INTEGER, username TEXT, comment TEXT, tstamp TEXT, posttime INTEGER);';
	$run = $comment_manager->query($statement);
	
	// if "submit" button is clicked, record timestamp, time, username, comment, and the id of the post the comment is for
	// I managed to store the data, but could not get it working properly to show messages on the specific post
	if (isset($_POST['message'])){
		$tstamp = date('Y-m-d H:i:s');
		$t = time();
		$username = $_SESSION['username'];
		$comment = $_POST['comment'];
		$id = $_SESSION['cur_post_to_comment'];
		
		
		$statement = "INSERT INTO comments(id, username, comment, tstamp, posttime) VALUES ('$id', '$username', '$comment', '$tstamp', '$t');";

		$run = $comment_manager->query($statement);
		
//		$statement = 'SELECT * FROM comments;';
//		$run = $comment_manager->query($statement);
//		if ($run){
//			while ($row = $run->fetchArray()){
//				echo'<p>', $row[0], ' | ', $row[1], ' | ', $row[2], ' | ', $row[3]. ' | ', $row[4], '</p>';
//			}
//		}
	}
		$cur_user = $_SESSION['username'];
		header("Location: homepage.php?user=$cur_user");
//	$comment_manager->close();
?>

</body>
</html>