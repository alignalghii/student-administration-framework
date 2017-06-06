<?php

namespace Form;

use Entity\StudentStudyGroupMembership;
use ORM\MyTriggerException;
use Repository\StudentStudyGroupMembershipRepository;
use Utility\ArrayUtil;

class StudentStudyGroupMembershipForm
{
	public static function blankMissingFields($incompleteEntity = [])
	{
		$blankFormEntity = [];
		foreach (StudentStudyGroupMembership::MOBILE_FIELDS as $fieldName => $type) {
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
		list($validationEntity, $validationErrors) = StudentStudyGroupMembership::validate($rawData);
		$formEntity = self::blankMissingFields($validationEntity);
		if (!$validationErrors) {
			try {
				self::saveForm($idOrNull, $formEntity, $validationEntity);
				$callbackSuccess();
			}  catch (MyTriggerException $triggerException) {
				$limit = $triggerException->getLimit();
				$validationErrors['student_id'] = "Limit of attendable study groups is $limit";
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
			StudentStudyGroupMembershipRepository::update($formEntity, $id);
		} else {
			StudentStudyGroupMembershipRepository::create($validationEntity);
		}
	}

}
