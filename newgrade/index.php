<html>
	<head>
		<title>GradeFear</title>
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
		<p>Be constructive and logical when creating new elements! This website has been designed to be easily editable by and for the community, so please respect others! GradeFear is not responsible for any sort of blahbahblah</p>
		<p>TODO: terms and policy, handle all empty</p>
		<form action="javascript:step1()">
			<p>Select a test date:</p>
			<input type="date" id="date">
			<p>Select a class from the dropdown:</p>
			<select id="classes"></select>
			<p>Or create a new class:</p>
			<input type="text" id="class">
			<input type="submit" value="Select">
		</form>
		<form action="javascript:step2()">
			<p>Existing tests:</p>
			<select id="tests"></select>
			<p>Create a new test:</p>
			<p>Be careful to check the date and avoid creating duplicate tests</p>
			<input type="text" id="test">
			<input type="submit" value="Select">
		</form>
		<script>init()</script>
	</body>
</html>