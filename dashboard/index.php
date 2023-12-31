<html>
	<head>
		<title>Dashboard - GradeFear</title>
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
				<div id="last" class="block">
					<h2>In-depth statistics</h2>
				</div>
				<div id="lasts" class="block">
					<h2>Last grades</h2>
					<p>Click on a grade to show more</p>
				</div>
			</div>
			<div id="col2">
				<div id="stats" class="block">
					<h2>Grade statistics</h2>
					<canvas width="400" height="150"></canvas>
				</div>
				<div id="tools" class="block">
					<h2>Tools</h2>
					<br>
					<div class="line">
						<p>Enter new grade</p>
						<a href="../newgrade">New grade</a>
					</div>
					<br>
					<div class="line">
						<p>Dark theme</p>
						<a href="#">Upcoming</a>
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
							<a href="javascript:clear(); document.location.reload()">Clear data</a>
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