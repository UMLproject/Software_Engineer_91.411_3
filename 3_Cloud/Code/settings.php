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
    <title>KeyStroke - Your Settings</title>

    <!-- Library Style Sheets -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.css">
	
    <!-- Library Scripts -->
    <script language="javascript" src="app/js/validateChange.js"></script>
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
			<article id="settings">
				<h3>Change Your Settings</h3>
				<form action="app/php/mysql_settings.php" method="POST" onsubmit="return validateChange()">
					<div class="form-group">
						<label for="oldPassword">Old Password</label>
						<input name="oldPassword" id="password" type="password" class="form-control" placeholder="Enter password" maxlength="25" required/>
					</div>
					<div class="form-group">
						<label for="NewPassword">New Password</label>
						<input name="NewPassword" id="password" type="password" class="form-control" placeholder="Enter new password" maxlength="25" />
					</div>
					<div class="form-group">
						<label for="checkNewPassword">Confirm New Password</label>
						<input name="checkNewPassword" id="checkPassword" type="password" class="form-control" placeholder="Confirm new password" />
					</div>
					<div class="form-group">
						<label for="email">Change Email</label>
						<input name="email" id="email" type="email" class="form-control" placeholder="Change Email" maxlength="100" />
					</div>
					<div class="form-group">
						<label for="checkEmail">Confirm Changed Email</label>
						<input name="checkEmail" id="checkEmail" type="email" class="form-control" placeholder="Confirm changed email" />
					</div>
					<button type="submit" class="btn btn-default">Change Settings</button>
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