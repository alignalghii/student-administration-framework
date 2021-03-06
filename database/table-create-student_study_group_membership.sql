CREATE TABLE `student_study_group_membership` (
	`id`             INT NOT NULL AUTO_INCREMENT,
	`student_id`     INT NOT NULL,
	`study_group_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`student_id`)     REFERENCES `student`     (`id`) ON DELETE CASCADE,
	FOREIGN KEY (`study_group_id`) REFERENCES `study_group` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_membership` (`student_id`, `study_group_id`)
);
