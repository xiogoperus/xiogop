<?php
// start session
ob_start();
session_start();
// xio true
define('_XIO', TRUE);
// mode
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;
	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	break;
	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1);
}

$reqFiles = array(
	"config" => dirname(__DIR__).'../config/common.config.php', 
	"dbConfig" => dirname(__DIR__).'../config/db.config.php',
	"logger" => dirname(__DIR__).'../lib/logger.class.php'
);

defined('XIO_DEBUG') or define('XIO_DEBUG',TRUE);

require_once(dirname(__DIR__).'../lib/xiogop.class.php');

Xiogop::createWebApp($reqFiles)->process();