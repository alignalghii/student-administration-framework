<?php

namespace Repository;

use ORM\Builder;
use ORM\Statement;
use Utility\TextUtil;

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

	public static function search($namePattern, $groupIds, $includeAlsoGrouplessStudents)
	{
		$gId_is_in_groupIds = Builder::IN("`g`.`id`", $groupIds);     // `g`.`id` IN (...) -- also protects $groupIds against SQL-injection
		$groupCondition     = $includeAlsoGrouplessStudents ? "(`g`.`id` IS NULL OR $gId_is_in_groupIds)"
		                                                    : $gId_is_in_groupIds;
		$typedBindings = [':namePattern' => ["%$namePattern%", \PDO::PARAM_STR]];
		$sql = "
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
				WHERE
					`s`.`name` LIKE :namePattern AND
					$groupCondition
				GROUP BY `s`.`id`
		";

		$statement = new Statement($sql, $typedBindings);
		return $statement->queryOneOrAll(false);
	}
}
