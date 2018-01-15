<?php

defined('_XIO') or die('No direct script access allowed');

class MainApiController extends ApiController {
    public function index($req, $res) {
        if ($req->getMethod() == 'POST') {
            $this->app->setTitle($this->app->t('home'));
            // $model = new User();
            // $model->getOne(12);
            // return $res->objectToJson($model);
        } else {
            $res->errorCode(404, false);
        }
    }
}