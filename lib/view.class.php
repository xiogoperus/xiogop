<?php

defined('_XIO') or die('No direct script access allowed');

class View {

	protected $data;

	protected $path;

    protected $layoutPath;

    protected $router;

    public function getDefaultViewPath($router) {
        $controllerDir = $router->getController();
        $templateName = $router->getAction().'.html';
        return Xiogop::app()->config['viewPath'].$controllerDir.DS.$templateName;
    }

    public function getDefaultLayoutPath() {
        return Xiogop::app()->config['viewPath'].Xiogop::app()->config['viewLayout'].'.html';
    }

	function __construct($data = array(), $layoutPath = null, $path = null) {

        $this->router = Xiogop::app()->router;

        if (!$layoutPath) {
            $layoutPath = $this->getDefaultLayoutPath();
        }
        
        if (!$path) {
            $path = $this->getDefaultViewPath($this->router);
        }
        
        if (!file_exists($layoutPath)) {
            Xiogop::app()->logger->log('Template layout file is not found!', false);
        }
        if (!file_exists($path)) {
            Xiogop::app()->logger->log('Template "'.$path.'" file is not found!', false);
        }
        $this->data = $data;
        $this->layoutPath = $layoutPath;
        $this->path = $path;
   	}

    public function setData($data = array()) {
        $this->data = $data;
    }

    public function renderLayout($layout) {
		$data = $this->data;

        ob_start();
        
        include(Xiogop::app()->config['viewPath'].$layout.Xiogop::app()->config['viewLayout'].'.html');

        $content = ob_get_clean();

        return $content.PHP_EOL;
	}

    public function render($templateName = null, $data = array()) {
        if (!$this->router) {
            return false;
        }

        $data = is_array($data) ? $data : get_object_vars($data);

        $templateName = $templateName ? $templateName : $this->router->getAction();

        $this->data = count($this->data) ? $this->data : $data;

        $this->path = Xiogop::app()->config['viewPath'].$this->router->getMethodPrefix().$this->router->getController().DS.$templateName.'.html';

        ob_start();
        
        include($this->path);
        
        $result = ob_get_clean();

        return $result.PHP_EOL;
    }

	public function getAllData() {
		return $this->data;
	}

	public function getData($key = null) {
		return isset($this->data[$key]) ? $this->data[$key] : '';
	}

    public function getContent($value = null) {
        return $value && array_key_exists($value, $this->data) ? $this->data[$value] : '';
	}

    public function getPath() {
		return $this->path;
	}
    
}