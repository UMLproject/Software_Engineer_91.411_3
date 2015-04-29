<?php
	// Start PHP session 
	session_start();
	
	// Connect to MySQL database
	require_once('mysql_connect.php');
	
	// Get form variables from login form
	$username = $_SESSION['username'];
	$OldPassword = $_POST['oldPassword'];
	$NewPassword = $_POST['NewPassword'];
	$confPassword = $_POST['checkNewPassword'];
	$email = $_POST['email'];
	$confEmail = $_POST['checkEmail'];
	
	// Validate Form
	if($NewPassword != $confPassword)
	{
		// Redirect
		echo "New passwords don't match. <a href='../../settings.php'>Go back</a>.";
		mysql_close($conn);
		exit();
	}
	if($email != $confEmail)
	{
		// Redirect
		echo "New emails don't match. <a href='../../settings.php'>Go back</a>.";
		mysql_close($conn);
		exit();
	}
	
	// Protect from SQL injection
	$OldPassword = stripcslashes($OldPassword);
	$NewPassword = stripcslashes($NewPassword);
	$email = stripcslashes($email);
	$OldPassword = mysql_real_escape_string($OldPassword);
	$NewPassword = mysql_real_escape_string($NewPassword);
	$email = mysql_real_escape_string($email);
	
	// Salt and hash with basic MD5 ( not working :( )
	//$password = md5(md5("6lP|+wZKEdApE3cwGOV~imShK=RxhZ6sCm1y2C-ZNSP2dF4VggKz8kmU4C~h".$password."Wik8lSlOKizAfTBa6~iXCAgKmdKCBsWN5cPMIHlFql42riBKq*C4s hu8ot+"));
	
	// MySQL query
	$sql = "SELECT * FROM users WHERE Username='$username' AND Password='$OldPassword'";
	$query = mysql_query($sql);
	$numrows = mysql_num_rows($query);
	
	// If result is found from query
	if($numrows == 1)
	{
		$sql = "UPDATE users SET ";
		
		if($NewPassword != NULL)
			$sql .= "Password='$NewPassword'";
		if($email != NULL)
			$sql .= "Email='$email'";
		if($NewPassword != NULL && $email != NULL)
			$sql = "UPDATE users SET Password='$NewPassword', Email='$email'";
		
		$sql .= " WHERE Username='$username'";
		
		$query = mysql_query($sql);
		
		// Redirect
		echo "Changed settings. <a href='../../settings.php'>Go back</a>.";
		mysql_close($conn);
		exit();
	}
	else
	{
		// Redirect
		echo "Couldn't change settings. Check your password. <a href='../../settings.php'>Go back</a>.";
		mysql_close($conn);
		exit();
	}
?>