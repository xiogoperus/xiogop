<?php

defined('_XIO') or die('No direct script access allowed');

class General {

	public $router = null;

	public $logger = null;

	public $view = null;

	public $config = array();

	function __construct() {
		// load congig files
		$files=glob(ROOT_DIR.DS.'config'.DS.'*.config.php');
		foreach ($files as $filename)
			require_once $filename;
		// autoload class files
		spl_autoload_register(array($this, 'autoload'));
		// init variables
		$this->config = $config;
		Logger::$PATH = ROOT_DIR.DS.'logs';
		$logger = new Logger();
		$this->logger = $logger;
   	}

	public function getURI() {
		return $_SERVER['REQUEST_URI'];
	}

	private function autoload($class) {
		$libPath = ROOT_DIR.DS.'lib'.DS.strtolower($class).'.class.php';
		$controllerPath = ROOT_DIR.DS.'pattern\controllers'.DS.str_replace('controller', '', strtolower($class)).'Controller.php';
		$apiControllerPath = ROOT_DIR.DS.'pattern\apiControllers'.DS.str_replace('controller', '', strtolower($class)).'ApiController.php';
		$modelPath = ROOT_DIR.DS.'pattern\models'.DS.strtolower($class).'.php';
		if (file_exists($libPath)) {
			require_once($libPath);
		} elseif (file_exists($controllerPath)) {
			require_once($controllerPath);
		} elseif (file_exists($apiControllerPath)) {
			require_once($apiControllerPath);
		} elseif (file_exists($modelPath)) {
			require_once($modelPath);
		} else {
			$this->logger->log('Failed to include class ' . $class, false);
		}
	}

	public function process() {
		$this->router = new Router($this->config, $this->getURI());

		$this->view = new View();

		$controllerClass = ucfirst($this->router->getController().'Controller');
		$apiControllerClass = ucfirst($this->router->getApiController().'ApiController');

		if (class_exists($controllerClass)) {
			$controllerObject = new $controllerClass();

			$controllerMethod = strtolower($this->router->getMethodPrefix().$this->router->getAction());
			if (method_exists($controllerClass, $controllerMethod)) {
				$viewPath = $controllerObject->$controllerMethod();
				$viewObject = new View($controllerObject->getData(), $viewPath);
				$content = $viewObject->render();
			}

			$layout = $this->config['viewLayout'];
			$layoutPath = $this->config['viewPath'].$this->config['viewLayout'].'.html';
			$layoutViewObject = new View(compact('content'), $layoutPath);
			$this->view = $layoutViewObject;
			echo $layoutViewObject->render();
		} elseif (class_exists($apiControllerClass)) {
			$controllerObject = new $apiControllerClass();

			$apiControllerMethod = strtolower($this->router->getMethodPrefix().$this->router->getApiAction());
			if (method_exists($apiControllerClass, $apiControllerMethod)) {
				echo '{}';
			}
		} else {
			include($this->config['viewPath'].'error404.html');
		}
	}
	
}