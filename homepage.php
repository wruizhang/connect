#!/usr/local/bin/php
<?php
	ob_start();
	session_name("Connect"); //specify session name
	session_start(); // start the session
	date_default_timezone_set('America/Los_Angeles'); //set time zone

	// connect to database, if not exists, create a new one
	try{
		$post_manager = new SQLite3('userposts.db');
	} 
	catch(Exception $exc){ 
		// catch thrown exceptions and display error message
		echo $exc->getMessage();
	}
	
	// open or create data table for writing
	$statement = 'CREATE TABLE IF NOT EXISTS project_proposals(username TEXT, project_name TEXT, project_description TEXT, skills TEXT, project_tags TEXT, images TEXT, tstamp TEXT, posttime INTEGER, id INTEGER PRIMARY KEY AUTOINCREMENT);';
	$run = $post_manager->query($statement);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<!--	<meta http-equiv="refresh" content="10;">-->
	<title>welcome!</title>
	<script src = "post_update_manager.js" defer> </script>
	<link rel= "stylesheet" type = "text/css" href = "page_style.css"/>
</head>

<body> 
<header>
<!--displaying top navigation menu -->
<div class = "top_menu">
	<div class = "menu_float_to_right">
		<nav>
			<ul>
				<li class = "tooltip">
					<button type="button">
						<img src = "images/discover.svg" width="40px" alt = "discover">
					</button> 
					<div class = "nav_tool_text">discover</div>
				</li>
				<li class = "tooltip">
					<a href = "write_project_proposal.php?user=<?php echo $_SESSION['username'];?>"> 
						<img src = "images/addpost.svg" width="40px" alt = "addpost">
					</a>
					<div class = "nav_tool_text">add proposal</div> 
				</li>
				<li class = "tooltip">
					<a href = "#myprojects"> 
						<img src = "images/myprojects.svg" width="40px" alt = "my projects">
					</a> 
					<div class = "nav_tool_text">my projects</div>
				</li>
				<li class = "tooltip">
						<button type="button" id = "user-options">
							<img src = "images/user.svg" width="40px" alt = "user">
						</button> 
						<div class = "nav_tool_text">user</div>

				</li>
				<li class = "tooltip">
					<a id = "logout" href = "logout.php?user=<?php echo $_SESSION['username'];?>"> 
						<p>
							log out
						</p>
					</a> 
				</li>
			</ul>
		</nav>
	</div>
</div>
</header>

<main>
	<section class = "home_page_section">
		<div>
			<a id = "newsfeed" href = "#news" > news feed </a>
		</div>
	</section>
	<section class = "newsfeed_content">
	
		<?php
		// tried to use pass php variables to javascript, could not get it to work :(
		
//			class Comment{
//				var $pid;
//				var $uname;
//				var $com;
//				var $ptime;
//									
//				public function __construct($pid, $uname, $com, $ptime){
//					$this->pid = $pid;
//					$this->uname = $uname;
//					$this->com = $com;
//					$this->ptime = $uname;
//				}
//			}
		
		
		
			// select project proposals by post time
			$statement = 'SELECT * FROM project_proposals ORDER BY posttime DESC;';
			$run = $post_manager->query($statement);
			// if successfully fetched data
			if ($run){
				// display each row/ project stored in database (in a specific format)
				while ($row = $run->fetchArray()){
					$post_id = $row[8];
			?>
				<article id = "post<?echo $post_id; ?>">
					<div class = "post_display_container">
					<div class = "image_box" style = "background-image: url(<?php echo $row[5];?>)"> 
						<div class = "arrow"></div>
					</div>
					
					<div class = "post_box"> 
						<div class = "text_area">
							<p>
					 		 	<?php echo $row[0], '<br/>', $row[6];?>
							</p>
							<br>
							<p>
				 		 		project name: 
					 		 	<?php echo $row[1];?>
							</p>
							<br>
							<p>
				 		 		project description:
					 		 	<?php echo $row[2];?>
							</p>
							<br>
							<p>
				 		 		looking for:
					 		 	<?php echo $row[3];?>
							</p>
							<br>
							<p>
				 		 		project tags: 
					 		 	<?php echo $row[4];?>
							</p>
						</div>
					</div>
					

				<div class = "reply_box"> 
					<div class = "reply_area">
					 	<p id = "all_the_comments<?echo $post_id; ?>">
					 		<?php	
								// ignore this, trying to pass php data to JS
								if(isset($_POST['message'])){
									$cur_id = $post_id;
									$cur_uname = $_SESSION['username'];
									$cur_msg = $_POST['message'];
									$cur_time = date('Y-m-d H:i:s');
									
									$php_json_id = json_encode($cur_id);
									$php_json_uname = json_encode($cur_uname);
									$php_json_msg = json_encode($cur_msg);
									$php_json_time = json_encode($cur_time );
								}
								echo $cur_msg;
							?>
							
					 	</p>
					</div>
					<div class= "add_comment">
						 <form method = "post" action = "comment_manager.php">
					 		<input type = "text" id = "comment" name = "comment" placeholder="send a message"/>
					 		<input type = "submit" value = "send" name = "message" onclick = "alert("hhh");"/>
					 		<script type='text/javascript'>
								let uid = JSON.parse('<?php echo $php_json_id; ?>');
								let uname = JSON.parse('<?php echo $php_json_uname; ?>');
								let msg = JSON.parse('<?php echo $php_json_msg; ?>');
								let time = JSON.parse('<?php echo $php_json_time; ?>');
								alert("hihi");
							</script>
					 	</form>
						</div>
				</div>
				</div>
		</article>
	<?php			
			}
		}
	?>			

				

		</section>
	
	</main> 
</body>
</html>