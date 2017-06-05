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
			self::saveForm($formEntity, $idOrNull);
			$callbackSuccess();
		} else {
			$callbackFailure($formEntity, $validationErrors);
		}
	}

	/** @todo: algebraic datatype `Maybe` */
	public static function saveForm($student, $idOrNull)
	{
		if (isset($idOrNull)) {
			self::updateForm($student, $idOrNull); // $id <- Just $id
		} else {
			StudentRepository::create($student);
		}
	}

	public static function updateForm($student, $id)
	{
		//Student::forceNullToMissingFields($student);
		$updaterStudent = ArrayUtil::reshapeAs($student, array_keys(Student::MOBILE_FIELDS));
		StudentRepository::update($updaterStudent, $id);
	}

}
