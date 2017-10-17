<?php

defined('_XIO') or die('No direct script access allowed');

class View {

	protected $data;

	protected $path;

    public static function getDefaultViewPath() {
        $router = Xiogop::$app->router;
        $isRouter = $router->getRouter();
        if (!$isRouter) {
            return false;
        }
        $controllerDir = $router->getController();
        $templateName = $router->getMethodPrefix().$router->getAction().'.html';
        return Xiogop::$app->config['viewPath'].$controllerDir.DS.$templateName;
    }

	function __construct($data = array(), $path = null) {
        if (!$path) {
            $path = self::getDefaultViewPath();
        }
        if (!file_exists($path)) {
            Xiogop::$app->logger->log('Template file is not found!', false);
        }
        $this->data = $data;
        
        $this->path = $path;
   	}

    public function render() {
		$data = $this->data;

        ob_start();
        
        include($this->path);
        $content = ob_get_clean();

        return $content.PHP_EOL;
	}

	public function getData() {
		return $this->data;
	}

    public function getContent($value = null) {
        return $value && array_key_exists($value, $this->data) ? $this->data[$value] : '';
	}

    public function getPath() {
		return $this->path;
	}
    
}