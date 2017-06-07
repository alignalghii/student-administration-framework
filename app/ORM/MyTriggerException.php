<?php

namespace ORM;

class MyTriggerException extends \Exception
{
	private $sql;
	private $typedBindings;
	private $triggerLimit;

	public function __construct( $sql, $typedBindings, $triggerLimit)
	{
		$typedBindingsCode = json_encode($typedBindings);
		parent::__construct("Limit $triggerLimit in SQL $sql with bindings $typedBindingsCode");
		$this->sql           = $sql;
		$this->typedBindings = $typedBindings;
		$this->triggerLimit  = $triggerLimit;
	}

	public function getSql()           {return $this->sql;          }
	public function getTypedBindings() {return $this->typedBindings;}
	public function getTriggerLimit()  {return $this->triggerLimit; }
}
