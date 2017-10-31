<?php

defined('_XIO') or die('No direct script access allowed');

class Utils {

        public static function toCamelCase($value) {
            $value = ucwords(str_replace(array('-', '_'), ' ', $value));
            $value = str_replace(' ', '', $value);
            return lcfirst($value);
        }

        public static function toSnikeCase($value) {
            $value = preg_replace('/(?<=\\w)(?=[A-Z])/', '_$1', $value); 
            return strtolower($value);
        }

        public static function toTrainCase($value) {
            $value = preg_replace('/(?<=\\w)(?=[A-Z])/', '-$1', $value); 
            return strtolower($value);
        }

        public static function loadExtension($path = '', $logger = null) {
            $loadPath = ROOT_DIR.DS.'lib\extension'.DS.strtolower($path).'.php';

            if (file_exists($loadPath)) {
                include($loadPath);
            } else {
                if (!is_null($logger)) {
                    $logger->log('Failed to include '.$loadPath, true);
                }
            }
        }

}