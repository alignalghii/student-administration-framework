<?php

namespace ORM;

use ORM\DbConn;

class Statement
{
	private $dbh;
	private $stmt;

	public function __construct($sql, $typedBindings)
	{
		$this->dbh  = DbConn::get();
		$this->stmt = $this->dbh->prepare($sql);
		if ($this->stmt) {
			foreach ($typedBindings as $placeholder => $typedValue) {
				list($value, $type) = $typedValue;
				$this->stmt->bindValue($placeholder, $value, $type);
			}
			$this->stmt->execute();
		} else {
			throw new \Exception('ORM problem');
		}
	}

	public function queryOneOrAll($one)
	{
		if ($one) {
			return $this->stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
	}
}
