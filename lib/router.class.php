<?php

defined('_XIO') or die('No direct script access allowed');

class Router {
	protected $uri;

	protected $route;

    protected $controller;

    protected $action;

    protected $params;

	protected $apiController;

    protected $apiAction;

	protected $apiParams;

	protected $methodPrefix;

	protected $language;

	protected $config;

	function __construct($config, $uri) {
	   $this->$uri = urldecode(trim($uri, '/'));
	   $this->config = $config;
	   // get defaults
	   $this->route = $config['defaultRoute'];
	   $this->controller = $config['defaultController'];
	   $this->methodPrefix = $config['keyRoutes'][isset($this->route) ? $this->route : $config['defaultRoute']];
	   $this->action = $config['defaultAction'];
	   $this->language = $config['defaultLanguage'];

	   $uriParts = explode('?', $this->$uri);
	   // get path
	   $path = $uriParts[0];

	   $pathParts = explode('/', $path);

	   if (count($pathParts)) {
		   if (in_array(strtolower(current($pathParts)), array_keys($config['keyRoutes']))) {
			   $this->route = strtolower(current($pathParts));
			   $this->methodPrefix = $config['keyRoutes'][isset($this->route) ? $this->route : $config['defaultRoute']];
			   array_shift($pathParts);
		   } elseif (in_array(strtolower(current($pathParts)), $config['languages'])) {
			   $this->language = strtolower(current($pathParts));
			   array_shift($pathParts);
		   }
		   if (current($pathParts)) {
			   $this->controller = strtolower(current($pathParts));
			   array_shift($pathParts);
		   }
		   if (current($pathParts)) {
			   $this->action = strtolower(current($pathParts));
			   array_shift($pathParts);
		   }
		   $this->params = $pathParts;
	   }
   	}

	public function getUri() {
		return $this->uri;
	}

    public function getController() {
		return $this->controller;
	}

    public function getAction() {
		return $this->action;
	}

    public function getParams() {
		return $this->params;
	}

	public function getRoute() {
		return $this->route;
	}

    public function getMethodPrefix() {
		return $this->methodPrefix;
	}

    public function getLanguage() {
		return $this->language;
	}
}