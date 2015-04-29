<?php
	// Start PHP session 
	session_start();
	
	// Unset variables and destroy session
	$_SESSION = array();
	session_unset();
	session_destroy();
	
	// Redirect
	header('Location: ../../login.php');
	exit();
?>