<?php
	// Start PHP session 
	session_start();
	
	// Connect to MySQL and database
	require_once "mysql_connect.php";
	
	// Set some variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	
	// Check if username already in database
	$sql = "SELECT * FROM users WHERE Username='$username'";
	$query = mysql_query($sql);
	$numrows = mysql_num_rows($query);
	
	// If found then exit
	if($numrows > 0)
	{
		echo "Username already taken. <a href='../../register.php'>Try again</a>.";
		exit();
	}
	else
		{
		// Check if email already in database
		$sql = "SELECT * FROM users WHERE Email='$email'";
		$query = mysql_query($sql);
		$numrows = mysql_num_rows($query);
		
		// If found then exit
		if($numrows > 0)
		{
			echo "Email already in use. <a href='../../register.php'>Try again</a>.";
			exit();
		}
		else
		{
			// Insert data into database
			$sql = "INSERT INTO users VALUES (
				'',
				'$username',
				'$password',
				'$email'
			)";
			$query = mysql_query($sql);
			
			// Check if successfully added to database
			$sql = "SELECT * FROM users WHERE Username='$username'";
			$query = mysql_query($sql);
			$numrows = mysql_num_rows($query);
			
			// Email confirmation if successfully added to database
			if($numrows > 0)
			{
				$webmaster = "KeyStroke Team <admin@keystroke.com>";
				$header = "From: $webmaster";
				$subject = "KeyStroke Registration";
				$message = "Thanks for joining us here at KeyStroke.\n";
				$message .= "Username: $username\n";
				$message .= "Password: $password\n\n";
				$message .= "Want to begin your KeyStroke experience now? http://www.keystroke.com/login.php";
				
				if(mail($email, $subject, $message, $header))
				{
					echo "Confirmation email sent to $email. <a href='../../login.php'>You can still log in here</a>.";
					$username = "";
					$email = "";
				}
				else
				{
					echo "Automatic email confirmation not sent. Just an error, but don't worry. <a href='../../login.php'>You can still log in here</a>.";
					exit();
				}
			}
			else
			{
				echo "Account couldn't be created. <a href='../../register.php'>Try again</a>.";
				exit();
			}
		}
	}	
?>