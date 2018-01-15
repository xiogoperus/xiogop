<?php

defined('_XIO') or die('No direct script access allowed');

class MainApiController extends ApiController {
    public function index($req, $res, $params) {
        if ($req->isMethod('GET')) {
            $user = new User();
            $user->getOne(count($params) ? $params[0] : -1);
            return $res->objectToJson($user);
        } else {
            $res->errorCode(404, 'This method not allowed');
        }
    }
}