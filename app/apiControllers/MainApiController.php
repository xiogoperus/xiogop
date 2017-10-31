<?php

defined('_XIO') or die('No direct script access allowed');

class MainApiController extends ApiController {
    public function index($req) {
        if ($req->isMethod('POST')) {
            $model = new User();
            $model->getOne(12);
            var_dump($req->getData());
            return $this->app->api->arrayToJson($req->getData());
        } else {
            $this->app->errorCode(404, 'This method not allowed');
        }
    }
}