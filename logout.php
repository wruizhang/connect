#!/usr/local/bin/php
<?php
	ob_start();
	session_name('Connect'); // continue the session
	session_start(); // start a session
	// clear all session variables and end session
	session_unset();
	session_destroy();
	
	// direct user back to login page
	header("Location: index.html");

?>