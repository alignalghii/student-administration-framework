<?php

/**
 * @todo: Entity base class must go to a spearate Framework supernamespace, and Student to an App supernamespace
 * @todo: Most functionalities here don't correspont to an Entity, rather, a Mapping!
 */
namespace Entity;

class Entity
{
	public static function isNew($rawData)
	{
		return !isset($rawData['id']);
	}

	/**
	 * @todo theoretical challange
	public abstract static function forceNullToMissingFields($entity)
	{
		... self::MOBILE_FIELDS ...
	}
	*/
}
