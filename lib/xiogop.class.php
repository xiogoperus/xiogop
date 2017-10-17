<?php

defined('_XIO') or die('No direct script access allowed');

// include core class
require(dirname(__FILE__).'/core.class.php');

class Xiogop extends Core
{

	public function __toString() {
		return __CLASS__;
	}

}