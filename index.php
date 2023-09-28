<html>
	<head>
		<title>GradeFear</title>
		<link rel="stylesheet" href="src/common.css">
		<link rel="stylesheet" href="src/homepage.css">
		<script src="src/login-utils.js"></script>
		<script src="src/homepage.js"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	</head>

	<body>
		<?php include("src/header.php"); ?>
		<h1>Welcome to GradeFear</h1>
		<h2>THE place to share and track your school progress</h2>
		<div id="buttons">
			<a href="login?signup=1"class="button">Sign up</a>
			<a href="login" class="button2">Log in</a>
		</div>
		<div id="notice">
			<h3>Important notice</h3>
			<p>This website allows you to enter your grades to compare them with those of the rest of your class. You obviously can add any grade anywhere, but this website has been created to allow you to roughly see if you need help in a certain area.</p>
			<p>Here at GradeFear, we do not encourage competition. Everything is sent anonymously to the database. Do not enter any data if you feel unconfortable with it, especially it you are tempted to do so because you feel weak of anxious about your capabilities.</p>
			<p>Remember that at the end of the day, there's no contest, only progress. If you feel you need it, go and talk to someone who can help you with this bad situation, so pretty much anyone.</p>
		</div>
		<script>init()</script>
	</body>
</html>	