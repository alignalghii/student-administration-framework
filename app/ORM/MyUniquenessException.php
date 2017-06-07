<?php

namespace ORM;

class MyUniquenessException extends \Exception
{
	private $sql;
	private $typedBindings;
	private $keyName;
	private $value;

	public function __construct($sql, $typedBindings, $keyName, $value)
	{
		$typedBindingsCode = json_encode($typedBindings);
		parent::__construct("Unique key constraint `$keyName` broken broken with value(2) `$value` in SQL $sql with bindings $typedBindingsCode");
		$this->sql           = $sql;
		$this->typedBindings = $typedBindings;
		$this->keyName       = $keyName;
		$this->value         = $value;
	}

	public function getSql()           {return $this->sql;          }
	public function getTypedBindings() {return $this->typedBindings;}
	public function getkeyName()       {return $this->keyName;      }
	public function getkeyValue()      {return $this->value;        }
}
