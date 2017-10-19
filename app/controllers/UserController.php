<?php

defined('_XIO') or die('No direct script access allowed');

class UserController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($params) {
        $this->app->setTitle($this->app->t('User'));

        $model = new User();
        $model->getOne(count($params) ? $params[0] : -1);
        
        return $this->app->view->render('index', array('model' => $model));
    }

    public function add() {
        $model = new User(array(
            'firstName' => 'Vasya',
            'lastName' => 'Petrov',
            'email' => 'VasyaPetrov@gmail.com',
            'password' => 'gfdsgf',
            'createAt' => '09-12-2024'
        ));
        $id = $model->save();
        $this->app->redirect('user', 'index', array($id));
    }

    public function update($params) {
        $model = new User(array(
            'firstName' => 'Faina',
            'lastName' => 'Rudes',
            'email' => 'fr@gmail.com',
            'password' => 'fdsgsgf',
            'createAt' => '09-12-2011'
        ));
        
        $id = $model->save(count($params) ? $params[0] : -1);
        $this->app->redirect('user', 'index', array($id));
    }

    public function delete($params) {
        $model = new User();
        $isRemoved = $model->remove(count($params) ? $params[0] : -1);
        return $this->app->view->render('test', array('ok' => 'trushed: '.$isRemoved));
    }
}