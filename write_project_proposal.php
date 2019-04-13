#!/usr/local/bin/php
<?php
	ob_start();
	session_name("Connect"); // specify session name
	session_start(); // continue the session
	date_default_timezone_set('America/Los_Angeles'); // set time zone 
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>new proposal</title>
	<link rel= "stylesheet" type = "text/css" href = "page_style.css"/>
</head>

<body>
<header>
	<a href = " homepage.php?user=<?php echo $_SESSION['username']; ?>"> 
		<img src = "images/home.svg" width="40px" alt = "home">
	</a> 
</header>
<main>
	<h2> get started on a new project! </h2>
	
	<div class = "container">
		<form method = "post" enctype="multipart/form-data" action = "<?php echo $_SERVER['PHP_SELF'];?>">
			<label for = "fileupload"> 
			upload a flyer or promotion image
			</label>
			<br>
			<br>
			<input type = "file" accept = "image/*" name = "media"/>
				<br>
				<br>
				<label for = "ptitle">project name</label>
				<br>
				<input type = "text" id = "ptitle" name = "proj_name" required>
				<br>
				<br>
				<textarea id = "pdescription" name = "description" rows = "15" cols = "68" placeholder="write a description for your project" required></textarea>
				<br>
				<br>
				<label for = "pskill"> looking for... </label>
				<br>
				<input type = "text" id = "pskill" name = "skill" placeholder="i.e. mentor, co-leader, specific skills, etc.">

				<br>
				<br>
				<label for = "ptags">project tags</label> 
				
				<br>
				<input type = "checkbox" id = "1" value = "art and design" name = "ptags[]"/>
				<label for = "1">art + design</label>
				<br>
				<input type = "checkbox" id = "2" value = "technology" name = "ptags[]"/>
				<label for = "1">technology</label>
				
				<br>
				<input type = "checkbox" id = "3" value = "sustainable living" name = "ptags[]"/>
				<label for = "1">sustainable living</label>
				
				<br>
				<input type = "checkbox" id = "4" value = "life science" name = "ptags[]"/>
				<label for = "1">life science</label>
				
				<br>
				<input type = "checkbox" id = "5" value = "film and media art" name = "ptags[]"/>
				<label for = "1">film and media art</label>
				<br>
				<br>
				<input type = "submit" value = "publish project proposal" name = "publish">

		</form>
	</div>
</main>





<?php
	// open the database for storing user posts, create one if doesn't exist
	try{
		$post_manager = new SQLite3('userposts.db');
	} 
	catch(Exception $exc){
		// catch exceptions and display error message
		echo $exc->getMessage();
	}
	
	
	// if the user clicked "publish" button (i.e. they're ready to post)
	if (isset($_POST['publish'])){
		// make a timestamp (string)
		$timestamp = date('Y-m-d H:i:s');  
		// record time for sorting & displaying posts in chronological order 
		$time = time();
		// get the current user's name (string)
		$username = $_SESSION['username'];
		// get name of the project (string)
		$proj_name = $_POST['proj_name'];
		//	get project description (a string)
		$proj_des = $_POST['description']; 
		// get skills the user is looking for (string)
		$proj_skills = $_POST['skill'];
		// get all the project tags selected (array)
		$p_t = $_POST['ptags'];
		// default image location is none, the user is not required to upload an image
		$img_location = 'none';
		// upload image files
		$proj_image = $_FILES['media']['name'];
		$saveLocation = dirname(realpath(__FILE__)) . '/uploads/' . $proj_image;
		move_uploaded_file($_FILES['media']['tmp_name'], $saveLocation);
		// record the location where image is stored
		$img_location = 'uploads/'.$proj_image;
		
		
		// if user selects any tags, turn them into a string
		if(isset($_POST['ptags'])){
			$proj_tags = implode(", ", $p_t);
		} else {
			// if no tag is selected, set to empty string
			$proj_tags = "";
		}
		
		// create a data table to store info about project proposals
		$statement = 'CREATE TABLE IF NOT EXISTS project_proposals(username TEXT, project_name TEXT, project_description TEXT, skills TEXT, project_tags TEXT, images TEXT, tstamp TEXT, posttime INTEGER, id INTEGER PRIMARY KEY AUTOINCREMENT);';
		$run = $post_manager->query($statement);
		
		// add the info to data table
		$statement = "INSERT INTO project_proposals(username, project_name, project_description, skills, project_tags, images, tstamp, posttime) VALUES ('$username', '$proj_name', '$proj_des', '$proj_skills', '$proj_tags', '$img_location', '$timestamp', '$time');";

		$run = 	$post_manager->query($statement);
	}
		// close database after finish writing into it
		$post_manager->close();
?>


</body>
</html>


