<?php

defined('_XIO') or die('No direct script access allowed');

class General {
	private $reqFiles = null;
	public $router = null;
	public $logger = null;
	protected $config = array();
	function __construct($reqFiles) {
		$this->reqFiles = $reqFiles;
		foreach ($reqFiles as $path) {
			include_once($path);
		}
		$this->config = $config;
		Logger::$PATH = ROOT.DS.'logs';
		$logger = new Logger();
		$this->logger = $logger;
		spl_autoload_register(array($this, 'autoload'));
   	}
	public function getURI() {
		return $_SERVER['REQUEST_URI'];
	}
	private function autoload($class) {
		$libPath = ROOT.DS.'lib'.DS.strtolower($class).'.class.php';
		$controllerPath = ROOT.DS.'pattern\controllers'.DS.str_replace('controller', '', strtolower($class)).'Controller.php';
		$apiControllerPath = ROOT.DS.'pattern\apiControllers'.DS.str_replace('controller', '', strtolower($class)).'.php';
		$modelPath = ROOT.DS.'pattern\models'.DS.strtolower($class).'.php';
		if (file_exists($libPath)) {
			require_once($libPath);
		} elseif (file_exists($controllerPath)) {
			require_once($controllerPath);
		} elseif (file_exists($apiControllerPath)) {
			require_once($apiControllerPath);
		} elseif (file_exists($modelPath)) {
			require_once($modelPath);
		} else {
			$this->logger->log('Failed to include class ' . $class);
		}
	}
	public function process() {
		$this->router = new Router($this->config, $this->getURI());
		
		$controllerClass = ucfirst($this->router->getController().'Controller');
		$controllerMethod = strtolower($this->router->getMethodPrefix().$this->router->getAction());

		$controllerObject = new $controllerClass();

		if (method_exists($controllerClass, $controllerMethod)) {
			$result = $controllerObject->$controllerMethod();
		}
	}
}