<?php

defined('_XIO') or die('No direct script access allowed');

class UserAdminController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($req, $res, $params) {
        $this->app->setTitle($this->app->t('User'));

        $model = new User();
        $model->getOne(count($params) ? $params[0] : -1);
        return $this->app->view->render('index', array('model' => $model));
    }

    public function add($req, $res, $params) {
        $model = new User(array(
            'firstName' => 'Vasssa',
            'lastName' => 'Petrssv',
            'email' => 'Vadov@gmail.com',
            'password' => Crypt::base64Encode('gfdsgf'),
            'createdAt' => '09-12-2014'
        ));
        $id = $model->save(null, 'email');
        if(!is_null($id)) {
            $res->redirect('user', 'index', array($id));
        } else {
            $res->errorCode(500, '- Email already exists', true);
        }
    }
//// helper form ---------------------------------
    public function update($req, $res, $params) {
        $model = new User(array(
            'firstName' => 'Faina',
            'lastName' => 'Rudes',
            'email' => 'fr@gmail.com',
            'createAt' => '09-12-2011'
        ));
        
        $id = $model->save(count($params) ? $params[0] : -1);
        $res->redirect('user', 'index', array($id));
    }

    public function delete($req, $res, $params) {
        $model = new User();
        $isRemoved = $model->remove(count($params) ? $params[0] : -1);
        $res->redirect('user', 'index', array($id));
    }
}