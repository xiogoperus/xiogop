<?php
/*******************************************************************************
========  ==========  ==========  ==========  ==========  ==========  ==========
Xiogop is an open source Content Management System (CMS) provided free for use
 under the GNU General Public License.					
                                             === xiogoperus@gmail.com ===
========  ==========  ==========  ==========  ==========  ==========  ==========
*******************************************************************************/
defined('_XIO') or die('Possible hack attempt!');

// gets the application start timestamp.
defined('XIO_BEGIN_TIME') or define('XIO_BEGIN_TIME',microtime(true));
// his constant defines whether the application should be in debug mode or not. Defaults to false.
defined('XIO_DEBUG') or define('XIO_DEBUG',false);

class Core
{
	public static function getVersion()
	{
		return '1.0.0';
	}

	public static function createWebApp($config=null)
	{
		return self::createApp('Test',$config);
	}

	public static function createApp($class,$config=null)
	{
		return new $class($config);
	}
}
class Test
{
	public function process()
	   {
	   		echo "ok";
	   }
}