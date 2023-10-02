<html>
	<head>
		<title>GradeFear</title>
		<link rel="stylesheet" href="../src/common.css">
		<link rel="stylesheet" href="../src/dashboard.css">
		<script src="../src/login-utils.js"></script>
		<script src="../src/dashboard.js"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	</head>

	<body>
		<?php include("../src/header.php"); ?>
		<h1>Dashboard - </h1>
		<div id="main">
			<div id="col1">
				<div id="stats" class="block">
					<h2>Grade statistics</h2>
				</div>
			</div>
			<div id="col2">
				<div id="tools" class="block">
					<h2>Tools</h2>
					<br>
					<div class="line">
						<p>Enter new grade</p>
						<a href="../newgrade">New grade</a>
					</div>
					<br>
					<div class="line">
						<p>Terms, privacy policy</p>
						<a href="../terms">Terms</a>
					</div>
					<br>
					<div class="line">
						<p>Log out and clear login cache</p>
						<a href="javascript:logout()">Log out</a>
					</div>
					<br>
					<div class="danger">
						<h2 class="danger">Danger zone</h2>
						<br>
						<div class="line">
							<p>Remove all local data linked to your profile</p>
							<a href="javascript:clear()">Clear data</a>
						</div>
						<br>
						<div class="line">
							<p>Log out and remove all local data</p>
							<a href="javascript:clear();logout()">Clear all data</a>
						</div>
						<br>
						<div class="line">
							<p>Delete profile and remove all data</p>
							<a href="javascript:deleteProfile()">Delete profile and data</a>
						</div>
						<br>
					</div>
				</div>
			</div>
		</div>
		<script>init()</script>
	</body>
</html>