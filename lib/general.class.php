<?php

defined('_XIO') or die('No direct script access allowed');

class General {

	public $router = null;

	public $logger = null;

	public $view = null;

	public $api = null;

	public $config = array();

	public $dbConfig = array();

	public $db = null;

	public $languageData;

	public $title;

	public function __toString() {
		return "General";
	}

	function __construct() {
		// load congig files
		$files=glob(ROOT_DIR.DS.'config'.DS.'*.config.php');
		foreach ($files as $filename)
			require_once $filename;
		// autoload class files
		spl_autoload_register(array($this, 'autoload'));
		// init variables
		$this->config = $config;
		$this->dbConfig = $dbConfig;
		// Logger init
		Logger::$PATH = ROOT_DIR.DS.'logs';
		$logger = new Logger();
		$this->logger = $logger;
		$this->title = $config['siteName'];
		// Router init
		$this->router = new Router($config, $this->getURI());
		// Db congig
		$conectionString = 'mysql:host='.$dbConfig['dbHost'].';dbname='.$dbConfig['dbname'];
        Db::setup($conectionString, $dbConfig['user'], $dbConfig['password']);
        Db::addDatabase($dbConfig['dbname'], $conectionString, $dbConfig['user'], $dbConfig['password'], true);
        Db::selectDatabase($dbConfig['dbname']);
		$test = Db::dispense(typeOrBeanArray: 'test');
		$test->name = 'hello';
		$test->gg = 'keke';
		Db::store('ds');
		Db::store($test);
   	}

	public function getURI() {
		return $_SERVER['REQUEST_URI'];
	}

	private function autoload($class) {
		$libPath = ROOT_DIR.DS.'lib'.DS.strtolower($class).'.class.php';
		$controllerPath = ROOT_DIR.DS.'pattern\controllers'.DS.$class.'.php';
		$apiControllerPath = ROOT_DIR.DS.'pattern\apiControllers'.DS.$class.'.php';
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
			$this->logger->log('Failed to include class ' . $apiControllerPath, false);
		}
	}

	public function process() {
		if ($this->router->getMethodPrefix() == 'api') {
			$this->api = new Api();
			$apiControllerClass = ucfirst($this->router->getApiController().'ApiController');
			if (class_exists($apiControllerClass)) {
				$controllerObject = new $apiControllerClass();
				
				$apiControllerMethod = strtolower($this->router->getApiAction());
				if (method_exists($apiControllerClass, $apiControllerMethod)) {
					$data = $controllerObject->$apiControllerMethod();
					print($data);
				}
			} else {
				Xiogop::$app->redirect('home', 'index');
			}
		} else {
			$this->view = new View();
			$this->loadLanguage($this->router->getLanguage());
			$controllerClass = ucfirst($this->router->getController().'Controller');
			if (class_exists($controllerClass)) {
				$controllerObject = new $controllerClass();

				$controllerMethod = strtolower($this->router->getMethodPrefix().$this->router->getAction());
				if (method_exists($controllerClass, $controllerMethod)) {
					$content = $controllerObject->$controllerMethod();
				}
				$this->view->setData(compact('content'));
				print($this->view->renderLayout());
			} else {
				$this->errorCode(404);
			}
		}
	}

	public function loadLanguage($langCode = 'en') {
		$langFilePath = ROOT_DIR.DS.'lang'.DS.strtolower($langCode).'.php';

		if(file_exists($langFilePath)) {
			$this->languageData = include($langFilePath);
		} else {
			$this->logger->log('Language file not found: '.$langFilePath, false);
		}
	}

	public function t($key, $defaultValue = '') {
		return isset($this->languageData[strtolower($key)]) ? $this->languageData[strtolower($key)] : $defaultValue;
	}

	public function redirect($controller, $method = "index", $args = array()) {
        $location = $this->config['baseUrl'] . "/" . $controller . "/" . $method . "/" . implode("/",$args);

        header("Location: " . $location);
        exit;
    }

	public function redirectUrl($url) {
        header("Location: " . $url);
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

	public function loadExtension($path = '') {
		$loadPath = ROOT_DIR.DS.'lib\extension'.DS.strtolower($path).'.php';

		if (file_exists($loadPath)) {
            include($loadPath);
        } else {
            $this->logger->log('Failed to include '.$loadPath, true);
        }
	}

	public function errorCode($code= 404) {
		$path = $this->config['viewPath'].'error'.$code.'.html';
		if (file_exists($path)) {
			include($path);
		} else {
			$this->logger->log('Failed to include '.$this->config['viewPath'].'error'.$code.'.html', true);
		}
	}
}