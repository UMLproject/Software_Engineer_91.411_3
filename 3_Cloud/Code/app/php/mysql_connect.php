<?php
	// MySQL info
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db   = "keystroke";
	
	// Connect to MySQL and select correct database
	$conn = mysql_connect("$host", "$user", "$pass") or die("Cannot connect to MySQL database.");
	mysql_select_db("$db") or die("Cannot select MySQL Database.");
?>