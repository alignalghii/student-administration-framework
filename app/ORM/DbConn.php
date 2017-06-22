<?php

namespace ORM;

use Config;

class DbConn
{
	const REUSE = true;

	static $conn = null;

	public static function get()
	{
		if (!self::$conn || !self::REUSE) {
			self::$conn = new \PDO('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME, Config::DB_USER, Config::DB_PWD);
			self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
		return self::$conn;
	}
}
