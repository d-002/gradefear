<html>
	<head>
		<title>GradeFear</title>
		<link rel="stylesheet" href="../src/common.css">
		<link rel="stylesheet" href="../src/error.css">
		<script src="src/login-utils.js"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	</head>

	<body>
		<?php include("../src/header.php"); ?>
		<?php
		$error = $_GET["type"];
		if (!isset($error)) { echo '<meta http-equiv="refresh" content="0; url=/">'; }
		else { $error = htmlspecialchars($error); }
		?>
		<h1>GradeFear - <?php echo $error ?></h1>
		<h2>This is an error.</h2>
		<div id="buttons">
			<a href="/"class="button2">Go back to homepage</a>
		</div>
		<script>initLogin()</script>
	</body>
</html>	