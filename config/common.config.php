<?php 
	
defined('_XIO') or die('No direct script access allowed');

// config
$config = array(
	'baseUrl' => PROTOCOL.ROOT_URL,
	'siteName' => 'Xiogop',
	'defaultLanguage' => 'en',
	'defaultRouter' => 'default',
	'defaultController' => 'home',
	'defaultAction' => 'index',
	'defaultApiController' => 'main',
	'defaultApiAction' => 'index',
	'viewPath' => ROOT_DIR.DS.'pattern\views'.DS,
	'viewLayout' => 'master',
	'languages' => array('en', 'ru'),
	'keyRouters' => array(
		'default' => '',
		'api' => 'api',
		'admin' => 'admin'
	)
);