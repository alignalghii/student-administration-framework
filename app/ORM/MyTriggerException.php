<?php

namespace ORM;

class MyTriggerException extends \Exception
{
	private $triggerLimit;
	private $sql;
	private $typedBindings;

	public function __construct($triggerLimit, $sql, $typedBindings)
	{
		$typedBindingsCode = json_encode($typedBindings);
		parent::__construct("Limit $triggerLimit in SQL $sql with bindings $typedBindingsCode");
		$this->triggerLimit  = $triggerLimit;
		$this->sql           = $sql;
		$this->typedBindings = $typedBindings;
	}

	public function getLimit()         {return $this->triggerLimit; }
	public function getSql()           {return $this->sql;          }
	public function getTypedBindings() {return $this->typedBindings;}
}
