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

	public static function getId($entity) {return $entity['id'];}

	public static function getAllIds($entities)
	{
		return array_map([self::class, 'getId'], $entities);
	}

	/**
	 * @todo theoretical challange
	public abstract static function forceNullToMissingFields($entity)
	{
		... self::MOBILE_FIELDS ...
	}
	*/
}
