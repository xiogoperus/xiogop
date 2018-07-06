<?php

defined('_XIO') or die('No direct script access allowed');

class HomeAdminController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($req, $res, $params) {
        $this->app->setTitle('Admin Home');
        if (Auth::isLogin()) {
            $token = Auth::getCurrentUser();
            return $this->app->view->render('index', $token);
        } else {
            $res->redirect('auth', 'index');
        }
    }
}