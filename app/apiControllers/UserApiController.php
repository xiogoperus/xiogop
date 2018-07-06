<?php

defined('_XIO') or die('No direct script access allowed');

class UserApiController extends ApiController {
    public function index($req, $res) {
        if ($req->getMethod() == 'GET') {
            $model = new User();
            $model->getOne(1);
            return $res->objectToJson($model);
        } else {
            $res->errorCode(404, false);
        }
    }
}