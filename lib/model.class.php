<?php

defined('_XIO') or die('No direct script access allowed');

class Model extends RedBean_SimpleModel {

    public function __toString() {
		return __CLASS__;
	}

	function __construct() {
	   
   	}

	public function tableName() {
		return strtolower(get_called_class()).'s';
	}

	public function rules() {
		return array();
	}

	public function relations() {
		return array();
	}

	public function getOne($id) {
		$table = DB::load( $this->tableName(), $id );
		$objectArray = is_object($this) ? get_object_vars($this) : array();
        foreach ($objectArray as $key => $value) {
             $this->$key = $table->$key;
        }
		return $this;
	}

	public function select() {
		
	}

	public function filter() {

	}

	public function save($editId = null) {
		$tableName = $this->tableName();
		$table = $editId ? DB::load( $tableName, $editId ) : DB::dispense( $tableName );
		$objectArray = is_object($this) ? get_object_vars($this) : array();
        foreach ($objectArray as $key => $value) {
             $table->$key = $value;
        }
		$id = DB::store( $table );
		return $id;
	}

	public function remove($id = null) {
		if (!$id) {
			return false;
		}
		$table = DB::load( $this->tableName(), $id );
		DB::trash($table);
		return true;
	}
       
}