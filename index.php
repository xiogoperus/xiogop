<?php
// start session
ob_start();
session_start();
// Security
define('_XIO', TRUE);

$config = dirname(__FILE__).'/config/common.config.php';

$dbConfig = dirname(__FILE__).'/config/db.config.php';

$xiogop = dirname(__FILE__).'/lib/xiogop.class.php';

defined('XIO_DEBUG') or define('XIO_DEBUG',TRUE);

require_once($xiogop);

Xiogop::createWebApp($config)->process();
?>