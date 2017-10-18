<?php

defined('_XIO') or die('No direct script access allowed');

class HomeController extends Controller {
    public function index() {
        $this->app->setTitle($this->app->t('home'));
        return $this->app->view->render('index');
    }
    public function test() {
        return $this->app->view->render();
    }
}