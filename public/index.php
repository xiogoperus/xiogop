<?php
// start session
ob_start();
session_start();
// Security
define('_XIO', TRUE);

$incArray = array(
		"config" => dirname(__DIR__).'../config/common.config.php', 
		"dbConfig" => dirname(__DIR__).'../config/db.config.php',
        "logger" => dirname(__DIR__).'../lib/logger.class.php'
		);

$xiogop = dirname(__DIR__).'../lib/xiogop.class.php';

defined('XIO_DEBUG') or define('XIO_DEBUG',TRUE);

require_once($xiogop);

Xiogop::createWebApp($incArray)->process();
?>