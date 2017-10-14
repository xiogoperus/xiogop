<?php 
	// root dir
	define("ROOT", dirname(__DIR__));
	// http root
	define("HTTP_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
	// directory separator
	define("DS", DIRECTORY_SEPARATOR);
	// default cotroller
	define("CONTROLLERDEFAULT", 'Main');
	// default action
	define("ACTIONDEFAULT", 'Index');
	// page structure
	$structArray = array(
		"header" => "header.php", 
		"main" => "main.php", 
		"footer" => "footer.php"
	);
	// routes
	$routeArray = array(
		"default" => "", 
		"admin" => "admin", 
		"dev" => "dev"
	);

?>