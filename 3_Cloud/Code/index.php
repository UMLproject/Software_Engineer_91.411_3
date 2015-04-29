<?php
	// Start PHP session
	session_start();
	
	// If session already open
	if(isset($_SESSION['id']))
	{
		// Redirect if logged in
		header('Location: dashboard.php');
		exit();
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
	
	<!-- Instead of div container, HTML5 semantic tags -->
	<section class="container">
		<section class="inner">
			<article id="intro">
				<h2>Are you ready to Kinect with the world?</h2>
				<p>With KeyStroke, you can control your computer with a virtual keyboard, allowing you to interact with your computer in a completely new way.</p>
			</article>
			<hr />
			<article id="register">
				<h3>Want to get started? Just sign up below.</h3>
				<form action="app/php/mysql_register.php" method="POST" onsubmit="return validateForm()">
					<div class="form-group">
						<label for="username">Username</label>
						<input name="username"id="username" type="text" class="form-control" placeholder="Desired username" maxlength="25" autofocus required/>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input name="password" id="password" type="password" class="form-control" placeholder="Enter password" maxlength="25" required/>
					</div>
					<div class="form-group">
						<label for="checkPassword">Confirm Password</label>
						<input name="checkPassword" id="checkPassword" type="password" class="form-control" placeholder="Confirm password" required/>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input name="email" id="email" type="email" class="form-control" placeholder="Your Email" maxlength="100" required/>
					</div>
					<div class="form-group">
						<label for="checkEmail">Confirm Email</label>
						<input name="checkEmail" id="checkEmail" type="email" class="form-control" placeholder="Confirm email" required/>
					</div>
					<button type="submit" class="btn btn-default">Register</button>
				</form>
			</article>
				
			<article id="login">
				<h5>Already have an account?<br />Login instead!</h5>
				<form action="app/php/mysql_login.php" method="POST">
					<div class="form-group">
						<label for="log_username">Username</label>
						<input name="log_username" id="log_username" type="text" class="form-control" placeholder="Enter username" maxlength="25" required/>
					</div>
					<div class="form-group">
						<label for="log_password">Password</label>
						<input name="log_password" id="log_password" type="password" class="form-control" placeholder="Enter password" maxlength="25" required/>
					</div>
					<button type="submit" class="btn btn-default">Login</button>
				</form>
			</article>
			
			 <div style="clear: both;"></div> 
		</section>
	</section>
	
	<footer class="text-center" style="">
		<p>Copyright © 2015 Software Engineering I</p>
	</footer>
</body>
</html>