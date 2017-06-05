<?php

namespace Entity;

/** @todo: Entity base class must go to a spearate Framework supernamespace, and Student to an App supernamespace */
use Entity\Entity;
use Utility\TextUtil;
use Utility\DateUtil;

class Student extends Entity
{
	const MOBILE_FIELDS = [
		'name'           => \PDO::PARAM_STR,    'is_male'       => \PDO::PARAM_BOOL,
		'place_of_birth' => \PDO::PARAM_STR,    'date_of_birth' => \PDO::PARAM_STR,
		'email'          => \PDO::PARAM_STR
	];

	/**
     * @todo: Too many responsibilities, dissect and delegate them to Entity, Form and Validator
	 * @todo: Make in into a non-static, real field values holding class, like in Symfony!
	 */
	public static function validate($rawData)
	{
		$entity = $validationErrors = [];

		if (self::isNew($rawData)) {
			$entity['id'] = $rawData['id'];
		}

		if (!TextUtil::isBlank($rawData['name'])) {
			$entity['name'] = $rawData['name'];
		} else {
			$validationErrors['name'] = 'Missing or empty';
		}

		$entity['is_male'] = array_key_exists('is_male', $rawData);

		if (!empty($rawData['place_of_birth'])) {
			$entity['place_of_birth'] = $rawData['place_of_birth'];
		}

		if (!TextUtil::isBlank($rawData['date_of_birth'])) {
			$date = $entity['date_of_birth'] = $rawData['date_of_birth'];
			if (!DateUtil::isValid($date)) {
				$validationErrors['date_of_birth'] = 'Invalid date format';
			}
		}

		if (!TextUtil::isBlank($rawData['email'])) {
			$entity['email'] = $rawData['email'];
		} else {
			$validationErrors['email'] = 'Missing or empty';
		}

		return [$entity, $validationErrors];
	}
}
