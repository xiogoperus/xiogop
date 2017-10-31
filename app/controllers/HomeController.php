<?php

defined('_XIO') or die('No direct script access allowed');

class HomeController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($req, $params) {
        $this->app->setTitle($this->app->t('home'));
         $id = count($params) ? $params[0] : -1;
         $user = new User();
         $user->getOne($id);
        // $token = new Token($id);
        // $token->save();
        return $this->app->view->render('index', array('model' => $user));
    }

    public function aboutus($req, $params) {
        return $this->app->view->render('xren', array('hello' => 'Hello world'));
    }
}