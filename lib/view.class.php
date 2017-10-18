<?php

defined('_XIO') or die('No direct script access allowed');

class View {

	protected $data;

	protected $path;

    protected $layoutPath;

    protected $router;

    public static function getDefaultViewPath($router) {
        $isRouter = $router->getRouter();
        $controllerDir = $router->getController();
        $templateName = $router->getMethodPrefix().$router->getAction().'.html';
        return Xiogop::$app->config['viewPath'].$controllerDir.DS.$templateName;
    }

    public static function getDefaultLayoutPath() {
        return Xiogop::$app->config['viewPath'].Xiogop::$app->config['viewLayout'].'.html';
    }

	function __construct($data = array(), $layoutPath = null, $path = null) {
        $this->router = Xiogop::$app->router;
        if (!$layoutPath) {
            $layoutPath = self::getDefaultLayoutPath();
        }
        if (!$path) {
            $path = self::getDefaultViewPath($this->router);
        }
        if (!file_exists($layoutPath)) {
            Xiogop::$app->logger->log('Template layout file is not found!', false);
        }
        if (!file_exists($path)) {
            Xiogop::$app->logger->log('Template file is not found!', false);
        }
        $this->data = $data;
        $this->layoutPath = $layoutPath;
        $this->path = $path;
   	}

    public function setData($data = array()) {
        $this->data = $data;
    }

    public function renderLayout() {
		$data = $this->data;

        ob_start();
        
        include($this->layoutPath);

        $content = ob_get_clean();

        return $content.PHP_EOL;
	}

    public function render($templateName = null) {
        if (!$this->router) {
            return false;
        }

        $templateName = $templateName ? $templateName : $this->router->getAction();

        $data = $this->data;

        $this->path = Xiogop::$app->config['viewPath'].$this->router->getController().DS.$this->router->getMethodPrefix().$templateName.'.html';

        ob_start();
        
        include($this->path);
        
        $result = ob_get_clean();

        return $result.PHP_EOL;
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