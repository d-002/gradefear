<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// don't allow manually viewing this page
	echo '<html><meta http-equiv="refresh" content="0; url=/"></html>';
} else {
	$path = $_POST["path"];

	if (is_dir($path)) {
		$dirs = [];
		foreach (scandir($path) as $dir) {
			if (is_dir($dir)) {
				if ($dir != "." and $dir != "..") {
					array_push($dirs, basename($file));
				}
			}
		}
		if (count($arr) != 0) {
			echo json_encode($arr);
		} else {
			echo "[]";
		}
	} else {
		echo "1";
	}
}
?>