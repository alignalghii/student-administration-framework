<?php

namespace Entity;

/** @todo: Entity base class must go to a spearate Framework supernamespace, and StudyGroup to an App supernamespace */
use Entity\Entity;
use Utility\TextUtil;
use Utility\DateUtil;

class StudyGroup extends Entity
{
	const MOBILE_FIELDS = [
		'name'    => \PDO::PARAM_STR,   'leader'  => \PDO::PARAM_STR,
		'subject' => \PDO::PARAM_STR,   'created' => \PDO::PARAM_STR
	];

	/**
     * @todo: Too many responsibilities, dissect and delegate them to Entity, Form and Validator
	 * @todo: Make in into a non-static, real field values holding class, like in Symfony!
	 * @todo: Most functionalities here don't correspont to an Entity, rather, a Mapping!
	 */
	public static function validate($rawData)
	{
		$entity = $validationErrors = [];

		if (!self::isNew($rawData)) {
			$entity['id'] = $rawData['id'];
		}

		if (!TextUtil::isBlank($rawData['name'])) {
			$entity['name'] = $rawData['name'];
		} else {
			$validationErrors['name'] = 'Missing or empty';
		}

		if (!TextUtil::isBlank($rawData['leader'])) {
			$entity['leader'] = $rawData['leader'];
		}

		if (!TextUtil::isBlank($rawData['subject'])) {
			$entity['subject'] = $rawData['subject'];
		} else {
			$validationErrors['subject'] = 'Missing or empty';
		}

		if (!TextUtil::isBlank($rawData['created'])) {
			$date = $entity['created'] = $rawData['created'];
			if (!DateUtil::isValid($date)) {
				$validationErrors['created'] = 'Invalid date format';
			}
		} else {
			$validationErrors['created'] = 'Missing or empty';
		}

		return [$entity, $validationErrors];
	}
}
