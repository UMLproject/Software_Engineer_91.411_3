<?php
	// Connect to MySQL database
	require_once('mysql_connect.php');
	
	// Get form variables from login form
	$username = $_POST['log_username'];
	$password = md5(md5("Feoa53Ag0a" . $_POST['log_password'] . "FEaefun3980af"));
	
	// Protect from SQL injection
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	
	
	// MySQL query
	$sql = "SELECT * FROM users WHERE Username='$username' AND Password='$password'";
	$query = mysql_query($sql);
	$numrows = mysql_num_rows($query);
	
	if($numrows == 1)
	{
		$rows = mysql_fetch_assoc($query);
		
		session_destroy();
		session_unset();
		session_start();
		
		$_SESSION["id"] = $rows['ID'];
		$_SESSION["username"] = $rows['Username'];
		
		header('Location: ../../dashboard.php');
	}
	else
	{
		header('Location: ../../login.php');
	}
	
?>