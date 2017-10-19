<?php

defined('_XIO') or die('No direct script access allowed');

class MainApiController extends ApiController {
    public function index() {
        return $this->app->api->send('hello pupsik');
    }
    public function test() {
        return $this->app->api->send('{"name": "blabla"}');
    }
}