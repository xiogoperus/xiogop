<?php

defined('_XIO') or die('No direct script access allowed');

class User extends Model {

    public $id;

    public $firstName;

    public $lastName;

    public $email;

    public $password;

    public $createdAt;

    function __construct($data = array()) {
        parent::__construct();
        if($data) {
            $this->setModel($data);
        }
        
   	}

    public function auth($email = '', $password = '') {
        $table = DB::findOne(  
            $this->tableName, 
            ' email = :email AND password = :password ', 
            [ ':email' => $email, ':password' => Crypt::base64Encode($password) ]  
        );
        if (is_null($table)) {
            return false;
        }
        return Auth::createToken($table->id);
	}

}