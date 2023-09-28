<?php
function encode($s) {
	$newS = "";
	$x = 0;
	foreach(str_split($s) as $char) {
		$newS .= ($x += strval(ord($char)*4477375789) % 1048576);
	}
	return $newS;
}

function allowed($login, $path) {
	// file permissions
	$path = basename($path);
	if ($path == "classes") { return true; }
	else { return false; }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// don't allow manually viewing this page
	echo '<html><meta http-equiv="refresh" content="0; url=/"></html>';
} else {
	$path = $_POST["path"];
	$pathtype = $_POST["pathtype"];
	$write = $_POST["write"];
	$login = $_POST["login"];
	$pwd = $_POST["pwd"];

	// get the stored password
	$file = fopen("http://gradefear.42web.io/users", "r");
	while (!feof($file)) {
		$line = trim(fgets($file), "\n");
		if (empty($line)) { continue; }
		$i = strpos($line, " ");
		$_login = substr($line, 0, $i);
		if ($login == $_login) {
			$encodedpwd = substr($line, $i+1);
			break;
		}
	}
	fclose($file);

	// compate password and check permissions to see if allowed to edit the file
	if (isset($encodedpwd)) {
		if ($encodedpwd == encode($pwd) and allowed($login, $path)) {
			if ($pathtype == "d") {
				if ($mkdir) {
					mkdir($path);
				}
				echo "0";
			} else if ($pathtype == "f") {
				if (file_exists($path)) { $file = fopen($path, "a"); }
				else { $file = fopen($path, "w"); }
				fwrite($file, $write);
				$fclose($file);
				echo "0";
			} else {
				echo "3";
			}
		} else {
			echo "2";
		}
	} else {
		echo "1";
	}
}
?>