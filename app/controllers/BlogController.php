<?php

defined('_XIO') or die('No direct script access allowed');

class BlogController extends Controller {

    public function __construct($data = array()) {
        parent::__construct($data);
   	}

    public function index($req, $res, $params) {
        return $this->app->view->render('index');
    }

}