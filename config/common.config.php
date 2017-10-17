<?php 
	
defined('_XIO') or die('No direct script access allowed');

// config
$config = array(
	'defaultLanguage' => 'en',
	'defaultRouter' => 'default',
	'defaultController' => 'home',
	'defaultAction' => 'index',
	'defaultApiController' => 'main',
	'defaultApiAction' => 'index',
	'viewPath' => ROOT_DIR.DS.'pattern\views'.DS,
	'viewLayout' => 'master',
	'languages' => array('en', 'ru', 'fr'),
	'keyRouters' => array(
		'default' => '',
		'api' => 'api',
		'admin' => 'admin', 
		'dev' => 'dev'
	)
);