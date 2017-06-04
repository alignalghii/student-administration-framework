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

	public static function create($student)
	{
		echo '---create---';
		var_dump($student);
	}

	public static function update($student, $id)
	{
		$builder = new Builder('student');
		$updateInfo = $builder->update($student, Student::MOBILE_FIELDS);
		extract($updateInfo); // $sql, $typedBindings
		$typedBindings[':id'] = [$id, \PDO::PARAM_INT];
		new Statement($sql, $typedBindings); // object not used, but statement execution is a side effect
	}
}
