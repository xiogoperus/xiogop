<?php

defined('_XIO') or die('No direct script access allowed');

class HomeAdminController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($req, $params) {
        $this->app->setTitle('Admin Home');
        return $this->app->view->render('index');
    }

    public function login($req) {
        $this->app->setTitle('Auth Home');
        return 'Good';
    }
}