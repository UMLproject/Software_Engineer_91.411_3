<?php
	// Start PHP session
	session_start();
	
	// If session already open
	if(isset($_SESSION['id']))
	{
		// Save user variables to show
		$userID = $_SESSION['id'];
		$username = $_SESSION['username'];
		
		// Show logged in menu
		$logged = "<li><a href='dashboard.php'>Dashboard</a></li>
				   <li><a href='about.php'>About</a></li>
				   <li><a href='settings.php'>Settings</a></li>
				   <li><a href='app/php/mysql_logout.php'>Logout</a></li>";
	}
	else
	{
		// Redirect if not logged in
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KeyStroke - Your Dashboard</title>

    <!-- Library Style Sheets -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.css">
	
    <!-- Library Scripts -->
    <script src="app/js/users.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</head>
<body>
	<header class="jumbotron slideInDown animated" style="width: 75%; padding: 2%; margin: auto; border-radius: 0 0 30px 30px;">
		<h1>KeyStroke</h1>
		<p>Virtual Kinect Keyboard.</p>
		<nav class="navmenu">
			<ul>
				<?php echo $logged ?>
			</ul>
		</nav>
	</header>
	<section class="container">
		<section class="inner">
			<h3>Welcome to your Dashboard, <?php echo $username ?>.</h3>
			 <div style="clear: both;"></div> 
		</section>
	</section>
	<footer class="text-center" style="">
		<p>Copyright © 2015 Software Engineering I</p>
	</footer>
</body>
</html>