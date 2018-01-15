<?php

defined('_XIO') or die('No direct script access allowed');

class AuthAdminController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
        $this->model = new User();
   	}

    public function index($req, $res, $params) {
        $this->app->setTitle('Admin Login');
        if(count($params) && Lang::hasKey($params[0], 'validations')) {
           Session::setFlash(Lang::t($params[0], 'validations')); 
        }
        
        if (!Auth::isLogin()) {
            return $this->app->view->render('index');
        } else {
            $res->redirect('home', 'index');
        }
    }

    public function login($req, $res, $params) {
        if ($req->isMethod('POST')) {
            $data = $req->getData();
            if (empty($data['email']) || empty($data['password'])) {
                $res->redirect('auth', 'index', array('emptyFields'));
            }
            if ($this->model->auth($data['email'], $data['password'])) {
                $token = Auth::getToken();
                if (!is_null($token)) {
                    $res->createCookie('token', $token->value);
                    $res->redirect('home', 'index');
                } else {
                    $res->redirect('auth', 'index');
                }
            } else {
                $res->redirect('auth', 'index', array('userNotFound'));
            }
        } else {
            $res->errorCode(404);
        }
    }

    public function logout($req, $res, $params) {
        if ($req->isMethod('GET')) {
            $res->removeCookie('token');
            Auth::clearToken();
            $token = Auth::getToken();
            $res->redirect('auth', 'index');
        } else {
            $res->errorCode(404);
        }
    }
}