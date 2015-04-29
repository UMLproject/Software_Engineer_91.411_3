<?php
	// Start PHP session 
	session_start();
	
	// Connect to MySQL database
	require_once('mysql_connect.php');
	
	// Get form variables from login form
	$username = $_POST['log_username'];
	$password = $_POST['log_password'];
	
	// Protect from SQL injection
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	
	// Salt and hash with basic MD5 ( not working :( )
	//$password = md5(md5("6lP|+wZKEdApE3cwGOV~imShK=RxhZ6sCm1y2C-ZNSP2dF4VggKz8kmU4C~h".$password."Wik8lSlOKizAfTBa6~iXCAgKmdKCBsWN5cPMIHlFql42riBKq*C4s hu8ot+"));
	
	// MySQL query
	$sql = "SELECT * FROM users WHERE Username='$username' AND Password='$password'";
	$query = mysql_query($sql);
	$numrows = mysql_num_rows($query);
	
	// If result is found from query
	if($numrows == 1)
	{
		// Get the results
		$rows = mysql_fetch_assoc($query);
		
		// Set session up
		$_SESSION["id"] = $rows['ID'];
		$_SESSION["username"] = $rows['Username'];
		
		// Redirect
		header('Location: ../../dashboard.php');
		exit();
	}
	else
	{
		// Redirect
		header('Location: ../../login.php');
		exit();
	}
?>