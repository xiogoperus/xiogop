<?php

defined('_XIO') or die('No direct script access allowed');

class Auth {
        protected static $token = null;

        public static function createToken($userId = null) {
            if (is_null($userId)) {
                return false;
            }
            self::$token = new Token($userId);
            if (!is_null(self::$token)) {
                self::$token->save();
                return true;
            }
            return false;
        }

        public static function clearToken() {
            if (isset(self::$token)) {
                self::$token->auth = false;
                self::$token->save(self::$token->id);
                self::$token = null;
                return true;
            }
            return false;
        }

        public static function setToken($value) {
            self::$token = new Token();
            self::$token->setToken($value);
        }

        public static function getToken() {
            return self::$token;
        }

        public static function getCurrentUser() {
            if (!is_null(self::$token)) {
                $user = new User();
                $user->getOne(self::$token->userId);
                return $user;
            }
            return null;
        }

        public static function isLogin() {
            return !is_null(self::$token) && !is_null(self::$token->id);
        }

}