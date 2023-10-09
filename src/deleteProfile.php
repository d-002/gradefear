<?php
function encode($s) {
	$newS = "";
	$x = 0;
	foreach(str_split($s) as $char) {
		$newS .= ($x += strval(ord($char)*4477375789) % 1048576);
	}
	return $newS;
}

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

function main() {
	$login = $_POST["login"];
	$pwd = $_POST["pwd"];

	// get the stored password
	$file = fopen("../users", "r");
	$lines = [];
	while (!feof($file)) {
		$line = trim(fgets($file), "\n");
		array_push($lines, $line);
		if (empty($line)) { continue; }
		$i = strpos($line, " ");
		$_login = substr($line, 0, $i);
		if ($login == $_login) {
			$encodedpwd = substr($line, $i+1);
		}
	}
	fclose($file);

	// compare password and check permissions to see if allowed to edit the file
	if (isset($encodedpwd)) {
		if ($encodedpwd == encode($pwd)) {
			$file = fopen("../users", "w");
			$first = true;
			for ($i = 0; $i < count($lines); $i++) {
				if (substr($lines[$i], 0, strlen($login)) != $login) {
					if (!$first) { fwrite($file, "\n"); }
					fwrite($file, $lines[$i]);
					$first = false;
				}
			}
			fclose($file);
			return "0";
		}
		return "2";
	}
	return "1";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// don't allow manually viewing this page
	echo '<html><meta http-equiv="refresh" content="0; url=/"></html>';
} else {
	echo main();
}
?>