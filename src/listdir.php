<?php
function main() {
	$path = $_POST["path"];
	$readtype = $_POST["readtype"];
	if ($readtype == "d") {
		$need_files = 0;
	} else if ($readtype == "f") {
		$need_files = 1;
	} else {
		return "2";
	}

	if (is_dir($path)) {
		$dirs = [];
		foreach (scandir($path) as $dir) {
			if (is_dir($path . "/" . $dir) xor $need_files) {
				if ($dir != "." and $dir != "..") {
					array_push($dirs, $dir);
				}
			}
		}
		if (count($dirs) != 0) {
			return json_encode($dirs);
		} else {
			return "[]";
		}
	} else {
		return "1";
	}
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// don't allow manually viewing this page
	echo '<html><meta http-equiv="refresh" content="0; url=/"></html>';
} else {
	echo main();
}
?>