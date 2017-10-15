<?php 
	
defined('_XIO') or die('No direct script access allowed');

// root dir
define('ROOT', dirname(__DIR__));
// http root
define('HTTP_ROOT', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '_UNKNOWN_'));
// directory separator
define('DS', DIRECTORY_SEPARATOR);
// config
$config = array(
	'defaultLanguage' => 'en',
	'defaultRoute' => 'default',
	'defaultController' => 'home',
	'defaultAction' => 'index',
	'viewPath' => ROOT.DS.'pattern\view'.DS,
	'languages' => array('en', 'ru', 'fr'),
	'keyRoutes' => array(
		'default' => '', 
		'admin' => 'admin', 
		'dev' => 'dev'
	),
	'defaultPageStructures' => array(
		'header' => 'header.php', 
		'main' => 'main.php', 
		'footer' => 'footer.php'
	)
);