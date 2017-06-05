<?php

namespace Repository;

use Entity\StudyGroup;
use ORM\Statement;
use ORM\Builder;

class StudyGroupRepository
{
	public static function find($id)
	{
		$statement = new Statement(
			'SELECT * FROM `study_group` WHERE `id` = :id',
			[':id' => [$id, \PDO::PARAM_INT]]
		);
		return $statement->queryOneOrAll(true);
	}

	public static function findAll()
	{
		$statement = new Statement('SELECT * FROM `study_group`', []);
		return $statement->queryOneOrAll(false);
	}

	public static function create($validationEntity)
	{
		$builder = new Builder('study_group');
		$creationInfo = $builder->create($validationEntity, StudyGroup::MOBILE_FIELDS);
		extract($creationInfo); // $sql, $typedBindings
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}

	public static function update($formEntity, $id)
	{
		$builder = new Builder('study_group');
		$updateInfo = $builder->update($formEntity, StudyGroup::MOBILE_FIELDS);
		extract($updateInfo); // $sql, $typedBindings
		$typedBindings[':id'] = [$id, \PDO::PARAM_INT];
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}

	public static function delete($id)
	{
		$builder = new Builder('study_group');
		$deletionInfo = $builder->delete($id);
		extract($deletionInfo); // $sql, $typedBindings
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}
}
