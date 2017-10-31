<?php

defined('_XIO') or die('No direct script access allowed');

class UserAdminController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($req, $params) {
        $this->app->setTitle($this->app->t('User'));

        $model = new User();
        $model->getOne(count($params) ? $params[0] : -1);
        return $this->app->view->render('index', array('model' => $model));
    }

    public function add($req, $params) {
        $model = new User(array(
            'firstName' => 'Vasssa',
            'lastName' => 'Petrssv',
            'email' => 'Vadov@gmail.com',
            'password' => Crypt::base64Encode('gfdsgf'),
            'createdAt' => '09-12-2014'
        ));
        $id = $model->save(null, 'email');
        if(!is_null($id)) {
            $this->app->redirect('user', 'index', array($id));
        } else {
            $this->app->errorCode(500, '- Email already exists', true);
        }
    }

    public function update($req, $params) {
        $model = new User(array(
            'firstName' => 'Faina',
            'lastName' => 'Rudes',
            'email' => 'fr@gmail.com',
            'createAt' => '09-12-2011'
        ));
        
        $id = $model->save(count($params) ? $params[0] : -1);
        $this->app->redirect('user', 'index', array($id));
    }

    public function delete($req, $params) {
        $model = new User();
        $isRemoved = $model->remove(count($params) ? $params[0] : -1);
        $this->app->redirect('user', 'index', array($id));
    }
}