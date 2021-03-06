<?php

defined('_XIO') or die('No direct script access allowed');

class Db extends \RedBeanPHP\Facade {
	public static function isSetDatabase($dbConfig = null, $logger = null) {
		if (!$dbConfig && !$logger) {
			return;
		}

		$database = isset($dbConfig['dbname']) ? $dbConfig['dbname'] : 'xiogop';
		// Connect to MySQL
		try {
			$link = mysqli_connect($dbConfig['dbHost'], $dbConfig['user'], $dbConfig['password']);
			if ($link) {
				$db_selected = mysqli_select_db($link, $database);

				if (!$db_selected) {
					$sql = 'CREATE DATABASE '.$database;

					if (mysqli_query($link, $sql)) {
						$logger->log('Database '.$database.' created successfully\n', false);
					} else {
						$logger->log('Error creating database: ' . mysqli_error($link) . '\n', false);
					}
				}

				mysqli_close($link);
			} else {
				throw new Exception('Could not connect ');
			}
		} catch (Exception $e) {
			print($e->getMessage());
		}
		
	}
}