<?php
// fix php version
if (version_compare(PHP_VERSION, '5.6.3', '<') ) {
  exit("Xiogop will only run on PHP version 5 or greater!\n");
}

// xio true
define('_XIO', TRUE);
// directory separator
define('DS', DIRECTORY_SEPARATOR);
// mode
define('ENVIRONMENT', isset($_SERVER['_XIO_ENV']) ? $_SERVER['_XIO_ENV'] : 'dev');
// root dir
define('ROOT_DIR', dirname(__DIR__));
// http root
define('ROOT_URL', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '_UNKNOWN_'));
// protocol
define('PROTOCOL', stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://');
// stream contents
define('STDIN', 'php://input');
switch (ENVIRONMENT)
{
	case 'dev':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;
	case 'test':
	case 'prod':
		ini_set('display_errors', 0);
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	break;
	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1);
}

require_once(dirname(__DIR__).'../lib/xiogop.class.php');

Xiogop::createWebApp()->process();