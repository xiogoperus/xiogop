<?php

defined('_XIO') or die('No direct script access allowed');

class AuthAdminController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
        $this->model = new User();
   	}

    public function index($req, $params) {
        $this->app->setTitle('Admin Login');
        $this->model->save();
        //$this->model->select(array('create_at' => '09-12-2011'), 'first_name', 'ASC');
        return $this->app->view->render('index');
    }

    public function submit($req, $params) {
        if ($req->isMethod('POST')) {
            $data = $req->getData();
            $this->model->auth($data['login'], $data['pass']);
        } else {
            $this->app->errorCode(404);
        }
    }
}