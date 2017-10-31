<?php

defined('_XIO') or die('No direct script access allowed');

class Model extends RedBean_SimpleModel {
	public $id = null;

	protected $tableName = null;

	protected $bean = null;

    public function __toString() {
		return __CLASS__;
	}

	public function getModel() {
		return __CLASS__;
	}

	function __construct() {
		$this->tableName = strtolower(get_called_class()).'s';
   	}

	public function tableName() {
		return strtolower($this->tableName);
	}

	public function rules() {
		return array();
	}

	public function relations() {
		return array();
	}

	public function getOne($id) {
		$table = DB::load( $this->tableName, $id );
        $this->setModel($table);
	}

	public function getAll() {
		return DB::getAll( 'SELECT * FROM '.$this->tableName );
	}

	public function select($array, $orderByValue = null, $orderBy = 'ASC') {
		if (!is_array($array)) {
			return array();
		}
		if (!is_null($orderByValue)) {
			$table = DB::findLike( $this->tableName, $array, ' ORDER BY '.$orderByValue.' '.$orderBy.' ' );
		} else {
			$table = DB::findLike( $this->tableName, $array );
		}
		return $table;
	}

	public function filter() {

	}

	public function save($editId = null, $prop = null) {
		$tableName = $this->tableName;
		$table = $editId ? DB::load( $tableName, $editId ) : DB::dispense( $tableName );
		$objectArray = is_object($this) ? get_object_vars($this) : array();
        foreach ($objectArray as $key => $value) {
			if ($key != 'id') {
				$table->$key = $value;
			}
        }
		$exists = null;
		if (!is_null($prop)) {
			$exists = DB::findOne( $tableName, ' '.$prop.' = :prop ', [ ':prop' => $table->$prop ] );
		}
		if (!is_null($exists) && !is_null($exists->id) && $exists->id > 0) {
			return null;
		}
		$id = DB::store($table);
		$this->setModel($table);
		return $id;
	}

	public function remove($id = null) {
		if (!$id) {
			return false;
		}
		$table = DB::load( $this->tableName, $id );
		DB::trash($table);
		return true;
	}

	protected function setModel($table = null) {
		if (is_null($table)) {
			return false;
		}
		if (is_array($table)) {
			foreach ($this as $key => $value) {
				if (array_key_exists($key, $table)) {
					$this->$key = $table[$key];
				}
			}
		} else {
			foreach ($this as $key => $value) {
				$this->$key = $table->$key;
			}
		}
		return true;
	}
       
}