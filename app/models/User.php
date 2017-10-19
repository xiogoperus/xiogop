<?php

defined('_XIO') or die('No direct script access allowed');

class User extends Model {

    public $firstName;

    public $lastName;

    public $email;

    public $password;

    public $createAt;

    function __construct($data = array()) {
        if($data) {
            $this->firstName = $data['firstName'];
            $this->lastName = $data['lastName'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->createAt = $data['createAt'];
        }
        
   	}

}