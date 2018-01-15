<?php

defined('_XIO') or die('No direct script access allowed');

class General {
	public $router = null;

	public $logger = null;

	public $view = null;

	public $config = array();

	public $dbConfig = array();

	public $db = null;

	public $languageData;

	public $title;

	public function __toString() {
		return 'General';
	}

	function __construct() {
		// load congig files
		$files=glob(ROOT_DIR.DS.'config'.DS.'*.config.php');
		foreach ($files as $filename)
			require_once $filename;
		// autoload class files
		spl_autoload_register(array($this, 'autoload'));
		// Logger init
		Logger::$PATH = ROOT_DIR.DS.'logs';
		$logger = new Logger();
		$this->logger = $logger;
		$this->title = $config['siteName'];
		// config
		$this->config = $config;
		$this->dbConfig = $dbConfig;
		// is set database
		Utils::loadExtension('rb\rb', $logger);
		Db::isSetDatabase($this->dbConfig, $this->logger);
		// Router init
		$this->router = new Router($config, $this->getURI());
   	}

	private function autoload($class) {
		$libPath = ROOT_DIR.DS.'lib'.DS.strtolower($class).'.class.php';
		$controllerPath = ROOT_DIR.DS.'app\controllers'.DS.$class.'.php';
		$apiControllerPath = ROOT_DIR.DS.'app\apiControllers'.DS.$class.'.php';
		$modelPath = ROOT_DIR.DS.'app\models'.DS.strtolower($class).'.php';
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
		try {
			//process config 
			Config::set('timeCookie', 3600);
			// start session
			Session::start();
			// Db setup
			$conectionString = 'mysql:host='.$this->dbConfig['dbHost'].';dbname='.$this->dbConfig['dbname'];
			Db::setup($conectionString, $this->dbConfig['user'], $this->dbConfig['password']);
			$response = new Response($this);
			$request = Request::getRequestData();
			$cookieToken = $request->getCookieToken();
        	Auth::setToken($cookieToken);
			if ($this->router->getMethodPrefix() == 'api') {
				$apiControllerClass = ucfirst($this->router->getApiController().'ApiController');
				if (class_exists($apiControllerClass)) {
					$controllerObject = new $apiControllerClass($this);
					$apiControllerMethod = strtolower($this->router->getApiAction());
					if (method_exists($apiControllerClass, $apiControllerMethod)) {
						$actionMethod = $controllerObject->$apiControllerMethod($request, $response, $this->router->getParams());
						print($actionMethod);
					} else {
						$response->errorCode(404, '"'.$apiControllerMethod.'"- action not allowed');
					}
				} else {
					$response->errorCode(404, '"'.$this->router->getApiController().'"- controller not allowed');
				}
			} else {
				$this->view = new View($this);
				if (!Lang::load($this)) {
					$this->logger->log('Language file not found: '.$langFilePath, false);
				}
				$controllerClass = ucfirst($this->router->getController()).ucfirst($this->router->getMethodPrefix()).'Controller';
				if (class_exists($controllerClass)) {
					$controllerObject = new $controllerClass($this);
					$controllerMethod = strtolower($this->router->getAction());
					if (method_exists($controllerClass, $controllerMethod)) {
						$content = $controllerObject->$controllerMethod($request, $response, $this->router->getParams());
						$this->view->setData(compact('content'));
						print($this->view->renderLayout($this->router->getMethodPrefix()));
					} else {
						$response->errorCode(404);
					}
				} else {
					$response->errorCode(404);
				}
			}
		}
		catch (Exception $e) {
			$this->logger->log('Error: ' . $e, true);
		}
		
	}

	private function getURI() {
		return $_SERVER['REQUEST_URI'];
	}

	public function link($controller = '', $action = '') {
		$ds = $controller && $action ? '/' : '';
		$prefixLang = !empty($this->router->getMethodPrefix()) ? $this->router->getMethodPrefix() : $this->router->getLanguage();
		return $ds.$prefixLang.$ds.$controller.$ds.$action;
    }

	public function setTitle($text = '') {
		$this->title = $text;
    }

	public function getTitle() {
		return $this->title;
    }
}