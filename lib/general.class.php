<?php
class General {
	private $includes = null;
	private $logger = null;
	function __construct($includes) {
       $this->includes = $includes;
	   foreach ($includes as $path) {
		    include_once($path);
		}
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
		$controllerPath = ROOT.DS.'pattern/controllers'.DS.str_replace('controller', '', strtolower($class)).'.class.php';
		$apiControllerPath = ROOT.DS.'pattern/apiControllers'.DS.str_replace('controller', '', strtolower($class)).'.class.php';
		$modelPath = ROOT.DS.'pattern/models'.DS.strtolower($class).'.php';
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
		$router = new Router($this->getURI());
		// foreach ($structArray as $view) {
		//     self::render($view);
		// }
	}
	public function render($view) 
	{
		include_once($view);
	}
	public function renderPage($view) 
	{
		include($view);
	}

}
?>