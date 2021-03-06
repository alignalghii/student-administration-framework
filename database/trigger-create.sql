DELIMITER //

CREATE TRIGGER `membership_limit_before_create` BEFORE INSERT ON `student_study_group_membership`
FOR EACH ROW
IF
	(
		SELECT COUNT(*)
		FROM `student_study_group_membership`
		WHERE `student_id` = NEW.`student_id`
	) >= 4
	THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Membership limit of 4 exceeded';
END IF;

CREATE TRIGGER `membership_limit_before_update` BEFORE UPDATE ON `student_study_group_membership`
FOR EACH ROW
IF
	(
		SELECT COUNT(*)
		FROM `student_study_group_membership`
		WHERE `student_id` = NEW.`student_id`
	) >= 4
	THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Membership limit of 4 exceeded';
END IF;

//

DELIMITER ;
