<?php

namespace Repository;

use Entity\Student;
use ORM\Statement;
use ORM\Builder;

class StudentRepository
{
	public static function find($id)
	{
		$statement = new Statement(
			'SELECT * FROM `student` WHERE `id` = :id',
			[':id' => [$id, \PDO::PARAM_INT]]
		);
		return $statement->queryOneOrAll(true);
	}

	public static function findAll()
	{
		$statement = new Statement('SELECT * FROM `student`', []);
		return $statement->queryOneOrAll(false);
	}

	public static function countAll()
	{
		$statement = new Statement('SELECT COUNT(*) AS `n` FROM `student`', []);
		return $statement->queryOneOrAll(true)['n'];
	}

	public static function create($validationEntity)
	{
		$builder = new Builder('student');
		$creationInfo = $builder->create($validationEntity, Student::MOBILE_FIELDS);
		extract($creationInfo); // $sql, $typedBindings
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}

	public static function update($formEntity, $id)
	{
		$builder = new Builder('student');
		$updateInfo = $builder->update($formEntity, Student::MOBILE_FIELDS);
		extract($updateInfo); // $sql, $typedBindings
		$typedBindings[':id'] = [$id, \PDO::PARAM_INT];
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}

	public static function delete($id)
	{
		$builder = new Builder('student');
		$deletionInfo = $builder->delete($id);
		extract($deletionInfo); // $sql, $typedBindings
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}
}
