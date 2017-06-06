<?php

namespace Repository;

use Entity\StudentStudyGroupMembership;
use ORM\Statement;
use ORM\Builder;

class StudentStudyGroupMembershipRepository
{
	public static function find($id)
	{
		$statement = new Statement(
			'SELECT * FROM `student_study_group_membership` WHERE `id` = :id',
			[':id' => [$id, \PDO::PARAM_INT]]
		);
		return $statement->queryOneOrAll(true);
	}

	public static function findAll()
	{
		$statement = new Statement('SELECT * FROM `student_study_group_membership`', []);
		return $statement->queryOneOrAll(false);
	}

	public static function create($validationEntity)
	{
		$builder = new Builder('student_study_group_membership');
		$creationInfo = $builder->create($validationEntity, StudentStudyGroupMembership::MOBILE_FIELDS);
		extract($creationInfo); // $sql, $typedBindings
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}

	public static function update($formEntity, $id)
	{
		$builder = new Builder('student_study_group_membership');
		$updateInfo = $builder->update($formEntity, StudentStudyGroupMembership::MOBILE_FIELDS);
		extract($updateInfo); // $sql, $typedBindings
		$typedBindings[':id'] = [$id, \PDO::PARAM_INT];
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}

	public static function delete($id)
	{
		$builder = new Builder('student_study_group_membership');
		$deletionInfo = $builder->delete($id);
		extract($deletionInfo); // $sql, $typedBindings
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}
}
