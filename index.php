<?php 
/*******************************************************************************
========  ==========  ==========  ==========  ==========  ==========  ==========
Xiogop is an open source Content Management System (CMS) provided free for use
 under the GNU General Public License.					
                                             === xiogoperus@gmail.com ===
========  ==========  ==========  ==========  ==========  ==========  ==========
*******************************************************************************/

/**************************************************************************
===========================================================================
                         Create Web Application
===========================================================================
**************************************************************************/

// start session
ob_start();
session_start();
// XIO Security
define('_XIO', TRUE);

// change the following paths if necessary
$config=dirname(__FILE__).'/config/common.php';
$xiogop=dirname(__FILE__).'/app/system/core/xiogop.php';

// remove the following line when in production mode
defined('XIO_DEBUG') or define('XIO_DEBUG',TRUE);

require_once($xiogop);
Xiogop::createWebApp($config)->process();
?>