<?php

defined('_XIO') or die('No direct script access allowed');

require '\extension\rb\rb.php';

class Db extends R {
	public static function isSetDatabase($dbConfig = null, $logger = null) {
		if (!$dbConfig && !$logger) {
			return;
		}

		$database = isset($dbConfig['dbname']) ? $dbConfig['dbname'] : 'xiogop';
		// Connect to MySQL
		$link = mysqli_connect($dbConfig['dbHost'], $dbConfig['user'], $dbConfig['password']);

		if (!$link) {
            $logger->log('Could not connect: ' . mysqli_error($link) . '\n', false);
		} else {
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
		}
	}
}