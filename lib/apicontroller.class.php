<?php

defined('_XIO') or die('No direct script access allowed');

class ApiController {

	protected $data;

	protected $model;

    protected $params;

	function __construct($data = array()) {
	   $this->data = $data;
       $this->params = Xiogop::$app->router->getParams();
   	}

	public function getData() {
		return $this->data;
	}

    public function getModel() {
		return $this->model;
	}

    public function getParams() {
		return $this->params;
	}
	
}