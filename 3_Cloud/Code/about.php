<?php
	session_start();
	if(isset($_SESSION['id']))
	{
		$userID = $_SESSION['id'];
		$username = $_SESSION['username'];
		$logged = "<li><a href='settings.php'>Settings</a></li>
				   <li><a href='app/php/mysql_logout.php'>Logout</a></li>";
	}
	else
	{
		$logged = "<li><a href='register.php'>Register</a></li>
				   <li><a href='login.php'>Login</a></li>";
	}
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KeyStroke - A New Experience</title>

    <!-- Library Style Sheets -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.css">
	
    <!-- Library Scripts -->
    <script src="app/js/validateForm.js"></script>
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
				<li><a href="index.php">Home</a></li>
				<li><a href="about.php">About</a></li>
				<?php echo $logged ?>
			</ul>
		</nav>
	</header>
	<section class="container">
		<section class="inner">
			<article id="intro">
				<h2>Are you ready to Kinect with the world?</h2>
				<p>With KeyStroke, you can control your computer with a virtual keyboard, allowing you to interact with your computer in a completely new way.</p>
			</article>
			 <div style="clear: both;"></div> 
		</section>
	</section>
	<footer class="text-center" style="">
		<p>Copyright © 2015 Software Engineering I</p>
	</footer>
</body>
</html>