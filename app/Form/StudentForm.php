<?php

namespace Form;

use Entity\Student;
use Repository\StudentRepository;
use Utility\ArrayUtil;

class StudentForm
{
	public static function blankMissingFields($incompleteEntity = [])
	{
		$blankFormEntity = [];
		foreach (Student::MOBILE_FIELDS as $fieldName => $type) {
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
		list($validationEntity, $validationErrors) = Student::validate($rawData);
		$formEntity = self::blankMissingFields($validationEntity);
		if (!$validationErrors) {
			self::saveForm($idOrNull, $formEntity, $validationEntity);
			$callbackSuccess();
		} else {
			$callbackFailure($formEntity, $validationErrors);
		}
	}

	/** @todo: algebraic datatype `Maybe` */
	public static function saveForm($idOrNull, $formEntity, $validationEntity)
	{
		if (isset($idOrNull)) {
			$id = $idOrNull; // $id <- Just $id
			StudentRepository::update($formEntity, $id);
		} else {
			StudentRepository::create($validationEntity);
		}
	}

}
