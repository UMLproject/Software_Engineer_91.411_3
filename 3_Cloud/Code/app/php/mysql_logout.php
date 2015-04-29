<?php
	require_once "mysql_connect.php";
	
	if($username && $userid)
	{
		session_unset();
		session_destroy();
		header('Location: ../../index.php');
		echo "Successfully logged out";
	}
	else
	{
		header('Location: ../../index.php');
	}
?>