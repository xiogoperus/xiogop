<?php

defined('_XIO') or die('No direct script access allowed');

class Lang {

    protected static $languageData = null;

    protected static $location = null;

    public static function load() {
        $langCode = Xiogop::app()->router->getLanguage();
        $langFilePath = ROOT_DIR.DS.'lang'.DS.strtolower($langCode).'.php';
		if(file_exists($langFilePath)) {
			self::$languageData = include($langFilePath);
            return true;
		} else {
			return false;
		}
	}

	public static function change($langCode = 'en') {
		self::$location = Xiogop::app()->config['baseUrl'].'/'
							.$langCode.'/'
							.Xiogop::app()->router->getController().'/'
							.Xiogop::app()->router->getAction().'/'
							.implode('/', Xiogop::app()->router->getParams());
		return self::$location;
	}

    public static function hasKey($key, $prefix = null) {
        if (!is_null($prefix)) {
            return isset(self::$languageData[strtolower($prefix)]) && !is_null(self::findT($key, self::$languageData));
        } else {
            return !is_null(self::findT($key, self::$languageData));
        }
	}

    protected static function findT($tKey, $array = array()) {
        foreach($array as $key => $value) {
            if (gettype($value) == 'array') {
                return self::findT($tKey, $value);
            } elseif ($key == $tKey) {
                return $value;
            }
        }
        return null;
    }

	public static function t($key, $prefix = null, $defaultValue = 'en') {
        if (!is_null($prefix)) {
            $fArray = array_key_exists($prefix, self::$languageData) ? self::$languageData[strtolower($prefix)] : array();
        } else {
            $fArray = self::$languageData;
        }
        if (isset($fArray[strtolower($key)])) {
            return $fArray[strtolower($key)];
        } else {
            return self::findT($key, $fArray);
        }
    }

}
