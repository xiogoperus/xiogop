<?php

defined('_XIO') or die('No direct script access allowed');

class HomeController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($params) {
        $this->app->setTitle($this->app->t('home'));
        
        //$test = $this->model->save(9);
        //var_dump($this->model->getOne(9));
        $model = new User();
        $model->getOne(count($params) ? $params[0] : -1);
        
        return $this->app->view->render('index', array('model' => $model));
    }

    public function xren($params) {
        return $this->app->view->render('xren', array('hello' => 'Hello world'));
    }
}