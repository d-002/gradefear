<html>
	<head>
		<title>New grade - GradeFear</title>
		<link rel="stylesheet" href="../src/common.css">
		<link rel="stylesheet" href="../src/newgrade.css">
		<script src="../src/login-utils.js"></script>
		<script src="../src/newgrade.js"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
		<script>classes = [<?php
		foreach (scandir("../classes") as $dir) {
			if (is_dir($dir)) {
				if ($dir != "." and $dir != "..") {
					echo '"' . basename($file) . '",';
				}
			}
		}
		?>];</script>
	</head>

	<body>
		<?php include("../src/header.php"); ?>
		<h1>New grade</h1>
		<div id="main">
			<p>Be constructive and logical when creating new elements! This website has been designed to be easily editable by and for the community, so please respect others!</p>
			<a href="../terms" class="blue">Read more...</a>
			<p class="error" id="error" style="display: none;"></p>
			<p id="comment"></p>
			<form action="javascript:step1()">
				<h2>Step 1 - select the date and class</h2>
				<p>Select a test date:</p>
				<input type="date" id="date">
				<p>Select an existing class:</p>
				<select id="classes"></select>
				<p>Or create a new class:</p>
				<input type="text" id="class" placeholder="Class name">
				<input type="submit" value="Select">
			</form>
			<form action="javascript:step2()" class="closed">
				<h2>Step 2 - select the test name</h2>
				<p>Select an existing test:</p>
				<select id="tests"></select>
				<p>Or create a new test:</p>
				<p>Be careful to check the date and avoid creating duplicate tests</p>
				<input type="text" id="test" placeholder="Test name">
				<input type="number" step="0.01" min="0" max="1000000" id="max-grade" placeholder="Max grade">
				<input type="submit" value="Select">
			</form>
			<form action="javascript:step3()" class="closed">
				<h2>Step 3 - enter your grade</h2>
				<p>Add a grade:</p>
				<input type="number" step="0.01" min="0" max="1000000" id="grade">
				<input type="submit" value="Submit">
			</form>
			<form action="../dashboard" class="closed">
				<h2>Step 4 - see statistics</h2>
				<p>Your grade has been safely and anonymously recorded. You can view the full statistics over all recorded grades in your profile page.</p>
				<input type="submit" value="Go to Dashboard">
			</form>
		</div>
		<script>init()</script>
	</body>
</html>