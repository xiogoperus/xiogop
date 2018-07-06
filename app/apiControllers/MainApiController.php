<?php

defined('_XIO') or die('No direct script access allowed');

class MainApiController extends ApiController {
    public function index($req, $res, $params) {
        if ($req->isMethod('POST')) {
        	$data = $req->getData();
        	$id = $data['id'];
            $user = new User();
            $user->getOne($id);
            return $res->arrayToJson(array(
            	"firstName" => $user->firstName,
            	"lastName" => $user->lastName
        	));
        } else {
            $res->errorCode(404, 'This method not allowed');
        }
    }
}