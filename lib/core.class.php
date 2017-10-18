<?php

defined('_XIO') or die('No direct script access allowed');

require_once(dirname(__FILE__).'/general.class.php');

class Core
{

	public static function getVersion() {
		return 'Xiogop v1.2.1';
	}

	public static $app = null;

	public static $reqFiles = null;

	public static function webApp() {
		return self::$app;
	}

	public static function createWebApp($reqFiles=null) {
		self::$reqFiles = $reqFiles;
		return self::createApp('General');
	}

	public static function createApp($class) {
		self::$app = new $class(self::$reqFiles);
		return self::$app;
	}
	
}

