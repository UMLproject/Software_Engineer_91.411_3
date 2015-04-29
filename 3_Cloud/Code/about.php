<?php
	// Start PHP session
	session_start();
	
	// If session already open
	if(isset($_SESSION['id']))
	{
		// Show logged in menu
		$logged = "<li><a href='dashboard.php'>Dashboard</a></li>
				   <li><a href='about.php'>About</a></li>
				   <li><a href='settings.php'>Settings</a></li>
				   <li><a href='app/php/mysql_logout.php'>Logout</a></li>";
	}
	else
	{
		// Show logged out menu
		$logged = "<li><a href='index.php'>Home</a></li>
				   <li><a href='about.php'>About</a></li>
				   <li><a href='register.php'>Register</a></li>
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
				<?php echo $logged ?>
			</ul>
		</nav>
	</header>
	<section class="container">
		<section class="inner">
			<article id="intro">
				<h2>What is KeyStroke?</h2>
				<p>KeyStroke is an easy to use, customizable virtual keyboard that you can use with a <a href="https://www.microsoft.com/en-us/kinectforwindows/">Microsoft© Kinect</a>. 
				With KeyStroke, you get a virtual keyboard displayed on your screen just the way you want. This allows you
				to exercise while typing anything from a school paper to a business report.</p>
				<h2>What software do I need?</h2>
				<p>KeyStroke is currently under development so the final requirements may change. But for now all you need
				to do is download our executable file and you're good to go! Our executable file will install the KeyStroke
				Virtual Keyboard application, as well as any drivers you will need to run your Kinect on you PC. We developed 
				KeyStroke using the free <a href="http://www.unity.com/">Unity Game Engine</a> and we are currently exploring making a web application.
				If that happens all you will need to install is a free Unity web plug-in.</p>
				<h2>How do I get started?</h2>
				<p>Simple! Just go to our <a href="register.php">register page</a> and sign up for <b>free</b>.</p>
			</article>
			 <div style="clear: both;"></div> 
		</section>
	</section>
	<footer class="text-center" style="">
		<p>Copyright © 2015 Software Engineering I</p>
	</footer>
</body>
</html>