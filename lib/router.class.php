<?php
class Router {
	protected $uri;

    protected $controller;

    protected $action;

    protected $params;

	function __construct($uri) {
	   $this->$uri = urldecode(trim($uri, '/'));
	   
	   // get defaults
	   echo $routeArray;
   	}

	public static function getUri() {
		return $this->uri;
	}

    public static function getController() {
		return $this->controller;
	}

    public static function getAction() {
		return $this->action;
	}

    public static function getParams() {
		return $this->params;
	}
}
?>