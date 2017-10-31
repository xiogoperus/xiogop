<?php

defined('_XIO') or die('No direct script access allowed');

class Crypt {
        protected static $encodeValue;

        protected static $decodeValue;

        public static function base64Encode($value = '', $key = 'crypt') {
            $encrypt = base64_encode($value) . base64_encode($key);
            self::$encodeValue = bin2hex($encrypt);
            return self::$encodeValue;
        }

        public static function base64Decode($value = '', $key = 'crypt') {
            if (!ctype_xdigit($value)) {
                return null;
            }
            $decrypt = hex2bin($value);
            $decrypt = str_replace(base64_encode($key), '', $decrypt);
            self::$decodeValue = base64_decode($decrypt);
            return self::$decodeValue;
        }

        public static function randomEncode($start = 1000, $end = 9999) {
            $bytes = mt_rand($start, $end);
            self::$encodeValue = self::base64Encode($bytes, 'key'.$bytes);
            return self::$encodeValue;
        }
}