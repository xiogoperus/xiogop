<?php 
	define("LOCAL_PATH_ROOT", getcwd());
	define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

	$structArray = array(
		"header" => LOCAL_PATH_ROOT."/includes/header.php", 
		"main" => LOCAL_PATH_ROOT."/includes/main.php", 
		"footer" => LOCAL_PATH_ROOT."/includes/footer.php");

?>