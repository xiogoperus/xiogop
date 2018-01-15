<?php

defined('_XIO') or die('No direct script access allowed');

class Request {
        protected static $requestData;

        protected static $method;

        public static function getRequestData() {
            self::$requestData = new RequestData(self::getMethod());
            return self::$requestData;
        }

        public static function getMethod() {
            return $_SERVER['REQUEST_METHOD'];
        }
}

class RequestData {
    protected $data = null;

    protected $cookie = null;

    protected $method = null;

    public function __toString() {
		return 'RequestData';
	}

    function __construct($method) {
        $this->method = $method;
        switch ($method) {
            case 'GET':
                $this->data = $_GET;
            break;
            case 'POST':
            {            
                if (empty($_POST)) {
                    $postData = file_get_contents('php://input');
                    $this->data = json_decode($postData, true);
                } else {
                    $this->data = $_POST;
                }
            }
                break;
            case 'PUT':
            {
                $putData = file_get_contents('php://input');
                $this->data = json_decode($putData, true);
            }
            break;
            case 'DELETE':
            {
                $deleteData = file_get_contents('php://input');
                $this->data = json_decode($deleteData, true);
            }
            break;
        }
   	}

    public function getMethod() {
        return $this->method;
    }

    public function getCookieToken() {
        if(isset($_COOKIE['token'])) {
            return $_COOKIE['token'];
        }
        return null;
    }

    public function getCookie($key) {
        if(isset($_COOKIE[$key])) {
            $this->cookie = $_COOKIE[$key];
            return $this->cookie;
        }
        return null;
    }

    public function isMethod($method = null) {
        return $this->method == $method;
    }

    public function getData() {
        return $this->data;
    }
}