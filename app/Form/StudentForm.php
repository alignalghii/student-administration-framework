<?php

namespace Form;

use Entity\Student;
use Repository\StudentRepository;
use Utility\ArrayUtil;

class StudentForm
{
	public static function blank()
	{
		$blankFormEntity = [];
		foreach (Student::MOBILE_FIELDS as $fieldName => $type) {
			$blankFormEntity[$fieldName] = $type == \PDO::PARAM_BOOL ? false : '';
		}
		return $blankFormEntity;
	}

	/** @todo: algebraic datatype `Maybe` */
	public static function saveOrHoldBack($rawData, $callbackSuccess, $callbackFailure, $idOrNull)
	{
		list($student, $validationErrors) = Student::validate($rawData);
		if (!$validationErrors) {
			self::saveForm($student, $idOrNull);
			$callbackSuccess();
		} else {
			$callbackFailure($student, $validationErrors);
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
