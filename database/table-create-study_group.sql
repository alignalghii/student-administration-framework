CREATE TABLE `study_group` (
	`id`      INT          NOT NULL AUTO_INCREMENT,
	`name`    VARCHAR(255) NOT NULL,
	`leader`  VARCHAR(255),
	`subject` VARCHAR(255) NOT NULL,
	`created` DATETIME     NOT NULL,
	PRIMARY KEY (`id`)
);
