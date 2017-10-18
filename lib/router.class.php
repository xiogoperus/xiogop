<?php

defined('_XIO') or die('No direct script access allowed');

class Router {

	protected $uri;

	protected $routerName;

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
	   $this->routerName = $config['defaultRouter'];
	   $this->controller = $config['defaultController'];
	   $this->apiController = $config['defaultApiController'];
	   $this->methodPrefix = $config['keyRouters'][isset($this->routerName) ? $this->routerName : $config['defaultRouter']];
	   $this->action = $config['defaultAction'];
	   $this->apiAction = $config['defaultApiAction'];
	   $this->language = $config['defaultLanguage'];

	   $uriParts = explode('?', $this->$uri);
	   
	   // get path
	   $path = $uriParts[0];

	   $pathParts = explode('/', $path);
	   
	   if (count($pathParts)) {
		   $isApi = false;
		   if (in_array(strtolower(current($pathParts)), array_keys($config['keyRouters']))) {
			   $isApi = strtolower(current($pathParts)) == 'api';

			   $this->routerName = $isApi ? str_replace('api', '', strtolower(current($pathParts))) : strtolower(current($pathParts));
			   
			   $this->methodPrefix = $isApi ? $config['keyRouters']['api'] : $config['keyRouters'][isset($this->routerName) ? $this->routerName : $config['defaultRouter']];
			   
			   array_shift($pathParts);
		   } elseif (in_array(strtolower(current($pathParts)), $config['languages'])) {
			   $this->language = strtolower(current($pathParts));
			   array_shift($pathParts);
		   }
		   if (current($pathParts)) {
				if (!$isApi)
					$this->controller = strtolower(current($pathParts));
				else 
					$this->apiController = strtolower(current($pathParts));
				array_shift($pathParts);
		   }
		   if (current($pathParts)) {
				if (!$isApi)
					$this->action = strtolower(current($pathParts));
				else
					$this->apiAction = strtolower(current($pathParts));
			   
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

	public function getApiController() {
		return $this->apiController;
	}

    public function getApiAction() {
		return $this->apiAction;
	}

    public function getApiParams() {
		return $this->apiParams;
	}

	public function getRouter() {
		return $this->routerName;
	}

    public function getMethodPrefix() {
		return $this->methodPrefix;
	}

    public function getLanguage() {
		return $this->language;
	}
	
}