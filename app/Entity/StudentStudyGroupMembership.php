<?php

namespace Entity;

/** @todo: Entity base class must go to a spearate Framework supernamespace, and StudentStudyGroupMembership to an App supernamespace */
use Entity\Entity;
use Utility\TextUtil;

class StudentStudyGroupMembership extends Entity
{
	const MOBILE_FIELDS = [
		'student_id'    => \PDO::PARAM_INT,   'study_group_id'  => \PDO::PARAM_INT,
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

		if (!TextUtil::isBlank($rawData['student_id'])) {
			$entity['student_id'] = $rawData['student_id'];
		} else {
			$validationErrors['student_id'] = 'Missing or empty';
		}

		if (!TextUtil::isBlank($rawData['study_group_id'])) {
			$entity['study_group_id'] = $rawData['study_group_id'];
		} else {
			$validationErrors['study_group_id'] = 'Missing or empty';
		}

		return [$entity, $validationErrors];
	}
}
