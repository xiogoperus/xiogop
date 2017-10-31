<?php

defined('_XIO') or die('No direct script access allowed');

class General {
	public $errorMessage = null;

	public $router = null;

	public $request = null;

	public $logger = null;

	public $view = null;

	public $api = null;

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
		// init variables
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
			// start session
			Session::start();
			// Db setup
			$conectionString = 'mysql:host='.$this->dbConfig['dbHost'].';dbname='.$this->dbConfig['dbname'];
			Db::setup($conectionString, $this->dbConfig['user'], $this->dbConfig['password']);

			if ($this->router->getMethodPrefix() == 'api') {
				$this->api = new Api();
				$apiControllerClass = ucfirst($this->router->getApiController().'ApiController');
				if (class_exists($apiControllerClass)) {
					$controllerObject = new $apiControllerClass();
					$apiControllerMethod = strtolower($this->router->getApiAction());
					if (method_exists($apiControllerClass, $apiControllerMethod)) {
						$actionMethod = $controllerObject->$apiControllerMethod(Request::getMethodData(), $this->router->getParams());
						print($actionMethod);
					} else {
						$this->errorCode(404, '"'.$apiControllerMethod.'"- action not allowed');
					}
				} else {
					$this->errorCode(404, '"'.$this->router->getApiController().'"- controller not allowed');
				}
			} else {
				$this->view = new View();
				$this->loadLanguage($this->router->getLanguage());
				$controllerClass = ucfirst($this->router->getController()).ucfirst($this->router->getMethodPrefix()).'Controller';
				if (class_exists($controllerClass)) {
					$controllerObject = new $controllerClass();
					$controllerMethod = strtolower($this->router->getAction());
					if (method_exists($controllerClass, $controllerMethod)) {
						$content = $controllerObject->$controllerMethod(Request::getRequestData(), $this->router->getParams());
						$this->view->setData(compact('content'));
						print($this->view->renderLayout($this->router->getMethodPrefix()));
					} else {
						$this->errorCode(404);
					}
				} else {
					$this->errorCode(404);
				}
			}
		}
		catch (Exception $e) {
			$this->logger->log('Error: ' . $e, true);
		}
		
	}

	public function getURI() {
		return $_SERVER['REQUEST_URI'];
	}

	public function loadLanguage($langCode = 'en') {
		$langFilePath = ROOT_DIR.DS.'lang'.DS.strtolower($langCode).'.php';

		if(file_exists($langFilePath)) {
			$this->languageData = include($langFilePath);
		} else {
			$this->logger->log('Language file not found: '.$langFilePath, false);
		}
	}

	public function swithLanguage($langCode = 'en') {
		$location = $this->config['baseUrl'].'/'
		.$langCode.'/'.$this->router->getController().'/'.$this->router->getAction().'/'
		.implode('/', $this->router->getParams());
		return $location;
	}

	public function t($key, $defaultValue = '') {
		return isset($this->languageData[strtolower($key)]) ? $this->languageData[strtolower($key)] : $defaultValue;
	}

	public function redirect($controller, $method = 'index', $args = array()) {
        $location = $this->config['baseUrl'] . '/' . $this->router->getMethodPrefix() . '/' . $controller . '/' . $method . '/' . implode('/',$args);

        header('Location: ' . $location);
        exit;
    }

	public function redirectUrl($url) {
        header('Location: ' . $url);
        exit;
    }

	public function link($controller = '', $action = '') {
		$ds = $controller && $action ? '/' : '';
		return $ds.$this->router->getLanguage().$ds.$controller.$ds.$action;
    }

	public function setTitle($text = '') {
		$this->title = $text;
    }

	public function getTitle() {
		return $this->title;
    }

	public function errorCode($code = 404, $message = '', $temp = false) {
		http_response_code($code);
		$this->errorMessage = $message;
		if (empty($message) || !!$temp) {
			$path = $this->config['viewPath'].'error'.$code.'.html';
			if (file_exists($path)) {
				ob_start();
				include($path);
				$result = ob_get_clean();
				print($result);
			} else {
				$this->logger->log('Failed to include '.$this->config['viewPath'].'error'.$code.'.html', true);
			}
		} else {
			print($message);
		}
		exit;
	}
}