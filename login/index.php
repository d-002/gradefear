<html>
	<head>
		<title>Log in - GradeFear</title>
		<link rel="stylesheet" href="../src/common.css">
		<link rel="stylesheet" href="../src/login.css">
		<script src="../src/login-utils.js"></script>
		<script src="../src/login.js"></script>
		<script><?php
		function encode($s) {
			$newS = "";
			$x = 0;
			foreach (mb_str_split($s) as $char) {
				$x += (mb_ord($char)*4477375789) % 1048576;
				$newS .= strval($x);
			}
			return $newS;
		}

		$signup = ($_GET["signup"] == 1);
		// log in / sign up

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$login = htmlspecialchars($_POST["login"]);
			$pwd = $_POST["pwd"];
			$pwd_hash = hash("sha256", encode($pwd));

			$file = fopen("../users", "r");
			while (!feof($file)) {
				$line = trim(fgets($file), "\n");
				if (empty($line)) { continue; }
				$i = strpos($line, " ");
				$_login = substr($line, 0, $i);
				$_pwd = substr($line, $i+1);
				if ($login == $_login) {
					$foundpwd = $_pwd;
					break;
				}
			}
			fclose($file);

			$error = "";
			if ($signup) {
				if ($pwd != $_POST["pwd2"]) { $error .= "Passwords must be identical. "; }
				if (empty($login)) { $error .= "Username must not be empty. "; }
				if (empty($pwd)) { $error .= "Password must not be empty. "; }
				if (isset($foundpwd)) { $error .= "This username exists. "; }
				if (!preg_match("/^[a-zA-Z-0-9'_.-]*$/",$login)) { $error .= "Username contains invalid characters. "; }

				if (empty($error)) {
					// successfully created account
					$file = fopen("../users", "a");
					fwrite($file, "\n" . $login . " " . $pwd_hash);
					fclose($file);
				}
			} else {
				if (!isset($foundpwd)) { $error .= "This username doesn't exist. "; }
				elseif ($pwd_hash != $foundpwd) { $error .= "Wrong password. "; }
			}

			if (empty($error)) {
				echo 'signedIn("' . $login . '", "' . encode($pwd) . '");';
			}
		} ?></script>
	</head>

	<body>
		<?php include("../src/header.php"); ?>
		<h1><?php if ($signup) { echo "Sign up"; } else { echo "Log in"; } ?> to GradeFear</h1>
		<form action=<?php if ($signup) { $add = "?signup=1"; } else { $add = ""; } echo htmlspecialchars($_SERVER["PHP_SELF"]) . $add; ?> method="POST" class="area">
			<?php if (!empty($error)) { echo '<p class="error">' . $error . "</p>"; } ?>
			<label for="login">Username</label>
			<?php if ($signup) { echo '<a href="javascript:randomUser()" class="blue">Generate random username</a>'; } ?>
			<input type="text" id="login" name="login" value=<?php echo $login; ?>>
			<br>
			<label for="pwd">Password</label>
			<input type="password" id="pwd" name="pwd">
			<br>
			<?php if ($signup) { echo '<label for="pwd2">Re-enter password</label><input type="password" id="pwd2" name="pwd2"><br>'; } ?>
			<input type="submit" value="<?php if ($signup) { echo "Sign up"; } else { echo "Log in"; } ?>">
		</form>
		<div class="area">
		<div><?php if ($signup) { echo '<span>Already have an account?</span> <a href="/login" class="blue">Log in</a>'; } else { echo '<span>New to GradeFear?</span> <a href="/login?signup=1" class="blue">Sign up</a>'; } ?></div>
		<?php if ($signup) { echo '<div><span>By creating an account, you agree to the <a href="../terms" class="blue">terms and conditions</a></span></div>'; } ?>
		</div>
	</body>
</html>