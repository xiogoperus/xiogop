<?php

defined('_XIO') or die('No direct script access allowed');

class Auth {
        protected static $token;

        protected static $user;

        public static function setToken($value) {
            self::$user = $user;
        }

        public static function getUser() {
            return !is_null(self::$user) ? self::$user : (new Object());
        }

        public static function getToken() {
            return !is_null(self::$token) ? self::$token : (new Object());
        }
}