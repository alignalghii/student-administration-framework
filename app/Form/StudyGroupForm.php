<?php

namespace Form;

use Entity\StudyGroup;
use ORM\MyUniquenessException;
use Repository\StudyGroupRepository;
use Utility\ArrayUtil;

class StudyGroupForm
{
	public static function blankMissingFields($incompleteEntity = [])
	{
		$blankFormEntity = [];
		foreach (StudyGroup::MOBILE_FIELDS as $fieldName => $type) {
			$blankFormEntity[$fieldName] = $incompleteEntity[$fieldName] ?? self::defaultFor($type);
		}
		return $blankFormEntity;
	}

	private static function defaultFor($type)
	{
		return $type == \PDO::PARAM_BOOL ? false : '';
	}

	/** @todo: algebraic datatype `Maybe` */
	public static function saveOrHoldBack($rawData, $callbackSuccess, $callbackFailure, $idOrNull = null)
	{
		list($validationEntity, $validationErrors) = StudyGroup::validate($rawData);
		$formEntity = self::blankMissingFields($validationEntity);
		if (!$validationErrors) {
			try {
				self::saveForm($idOrNull, $formEntity, $validationEntity);
				$callbackSuccess();
			} catch (MyUniquenessException $uniquenessException) {
				$validationErrors['name'] = "Duplicate entry";
				$callbackFailure($formEntity, $validationErrors);
			}
		} else {
			$callbackFailure($formEntity, $validationErrors);
		}
	}

	/** @todo: algebraic datatype `Maybe` */
	public static function saveForm($idOrNull, $formEntity, $validationEntity)
	{
		if (isset($idOrNull)) {
			$id = $idOrNull; // $id <- Just $id
			StudyGroupRepository::update($formEntity, $id);
		} else {
			StudyGroupRepository::create($validationEntity);
		}
	}

}
