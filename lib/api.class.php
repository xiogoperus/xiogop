<?php

defined('_XIO') or die('No direct script access allowed');

class Api {

	function __construct() {
        
   	}
    
	public function send($data = '') {
		return $data;
	}

	public function objectToJson($object) {
		return is_object($object) ? json_encode($object) : '{}';
	}

	public function arrayToJson($array) {
		return is_array($array) ? json_encode($array) : '[]';
	}

	public function jsonToObject($string) {
		return is_string($string) ? json_decode($string) : (new Object());
	}

	public function jsonToArray($string) {
		return is_string($string) ? json_decode($string) : array();
	}
}