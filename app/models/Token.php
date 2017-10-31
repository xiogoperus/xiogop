<?php

defined('_XIO') or die('No direct script access allowed');

class Token extends Model {

    public $userId;

    public $value;

    public $auth;

    public $createdAt;

    function __construct($id = null, $auth = true) {
        parent::__construct();
        if($id) {
            $this->userId = $id;
            $this->auth = !!$auth;
            $this->value = Crypt::randomEncode();
            $this->createdAt = date('Y-m-d');
        }  
   	}

    public function getValue() {
        return $this->value;
    }

}