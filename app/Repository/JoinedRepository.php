<?php

namespace Repository;

use ORM\Statement;

class JoinedRepository
{
	public static function countActiveStudents()
	{
		$statement = new Statement('SELECT COUNT(DISTINCT `student_id`) AS `n` FROM `student_study_group_membership`', []);
		return $statement->queryOneOrAll(true)['n'];
	}
}
