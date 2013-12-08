<?php
/*******************************************************************************
========  ==========  ==========  ==========  ==========  ==========  ==========
Xiogop is an open source Content Management System (CMS) provided free for use
 under the GNU General Public License.					
                                             === xiogoperus@gmail.com ===
========  ==========  ==========  ==========  ==========  ==========  ==========
*******************************************************************************/
defined('_XIO') or die('Possible hack attempt!');
// include core class
require(dirname(__FILE__).'/core.php');

class Xiogop extends Core
{
	public function __toString()
	{
		return __CLASS__;
	}
}