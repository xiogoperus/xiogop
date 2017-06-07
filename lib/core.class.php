<?php
defined('_XIO') or die('Possible hack attempt!');

defined('XIO_BEGIN_TIME') or define('XIO_BEGIN_TIME',microtime(true));
// his constant defines whether the application should be in debug mode or not. Defaults to false.
defined('XIO_DEBUG') or define('XIO_DEBUG',false);
// include core class

require(dirname(__FILE__).'/general.class.php');

class Core
{
	public static function getVersion()
	{
		return '1.1.0';
	}
	public static $app = null;
	public static function webApp()
	{
		return self::$app;
	}
	public static function createWebApp($config=null)
	{
		return self::createApp('General',$config);
	}
	public static function createApp($class,$config=null)
	{
		self::$app = new $class($config);
		return self::$app;
	}
}

