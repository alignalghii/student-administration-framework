<?php

namespace Repository;

use ORM\Statement;

class JoinedRepository
{
	public static function findAllStudentsWithTheirGroupListForEach()
	{
		$statement = new Statement("
			SELECT
				`s`.`id` AS `id`,
				`s`.`name`, `s`.`is_male`, `s`.`place_of_birth`, `s`.`date_of_birth`, `s`.`email`,
				COALESCE(
					GROUP_CONCAT(`g`.`id` ORDER BY `g`.`id` SEPARATOR ' ~|!>~ '),
					''
				) AS `groupIdsText`,
				COALESCE(
					GROUP_CONCAT(`g`.`name` ORDER BY `g`.`id` SEPARATOR ' ~|!>~ '),
					''
				) AS `groupNamesText`
			FROM `student` AS `s`
				LEFT JOIN `student_study_group_membership` AS `sg`
					ON `sg`.`student_id` = `s`.`id`
				LEFT JOIN `study_group` AS `g`
					ON `g`.`id` = `sg`.`study_group_id`
			GROUP BY `s`.`id`
		");
		return $statement->queryOneOrAll(false);
	}
}
