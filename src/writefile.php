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

function allowed($login, $path, $writetype) {
	// file permissions
	$path = dirname($path);

	if ($path == "../classes") { return true; }
	if ((substr($path, 0, 11) == "../classes/") and (substr_count($path, "..") == 1)) { return true; }
	return false;
}

function main() {
	$path = $_POST["path"];
	$writetype = $_POST["writetype"];
	$write = $_POST["write"];
	$login = $_POST["login"];
	$pwd = $_POST["pwd"];

	// get the stored password
	$file = fopen("../users", "r");
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

	// compare password and check permissions to see if allowed to edit the file
	if (isset($encodedpwd)) {
		if ($encodedpwd == encode($pwd)) {
			if (allowed($login, $path, $writetype)) {
				if ($writetype == "d") {
					if (is_dir(dirname($path))) {
						if (!is_dir($path)) { mkdir($path); }
						return "0";
					}
					return "5";
				} else if ($writetype == "f") {
					if (!is_numeric($write)) return "6";
					if (file_exists($path)) { $file = fopen($path, "a"); }
					else { $file = fopen($path, "w"); }
					fwrite($file, $write);
					fclose($file);
					return "0";
				}
				return "4";
			}
			return "3";
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