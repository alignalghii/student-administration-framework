<?php

namespace Form;

use Entity\Student;
use ORM\MyUniquenessException;
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
			try {
				self::saveForm($idOrNull, $formEntity, $validationEntity);
				$callbackSuccess();
			} catch (MyUniquenessException $uniquenessException) {
				$validationErrors['email'] = "Duplicate entry";
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
			StudentRepository::update($formEntity, $id);
		} else {
			StudentRepository::create($validationEntity);
		}
	}

}
