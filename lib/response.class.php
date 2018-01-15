<?php

defined('_XIO') or die('No direct script access allowed');

class Response extends Api {
	public $app = null;

    public $errorMessage = null;

	function __construct($app = null) {
		$this->app = $app;
	}

    public function errorCode($code = 404, $message = '', $temp = false) {
		http_response_code($code);
		$this->errorMessage = $message;
		if (empty($message) || !!$temp) {
			$path = $this->app->config['viewPath'].'error'.$code.'.html';
			if (file_exists($path)) {
				ob_start();
				include($path);
				$result = ob_get_clean();
				print($result);
			} else {
				$this->app->logger->log('Failed to include '.$this->app->config['viewPath'].'error'.$code.'.html', true);
			}
		} else {
			print($message);
		}
		exit;
	}

	public function createCookie($name, $value, $time = null) {
		if (is_null($time)) {
			$time = Config::get('timeCookie');
		}
		if (!empty($name) && !empty($value)) {
			setcookie($name, $value, time() + $time, '/');
		}
	}

	public function removeCookie($name, $time = null) {
		if (is_null($time)) {
			$time = Config::get('timeCookie');
		}
		if (isset($_COOKIE[$name])) {
			unset($_COOKIE[$name]);
			setcookie($name, '', time() - $time, '/');
		}
	}

    public function redirect($controller, $method = 'index', $args = array()) {
        $location = $this->app->config['baseUrl'] . '/' . $this->app->router->getMethodPrefix() . '/' . $controller . '/' . $method . '/' . implode('/',$args);

        header('Location: ' . $location);
        exit;
    }

	public function redirectUrl($url) {
        header('Location: ' . $url);
        exit;
    }
}