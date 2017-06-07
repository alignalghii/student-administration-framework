CREATE TABLE `student` (
	`id`             INT          NOT NULL AUTO_INCREMENT,
	`name`           VARCHAR(255) NOT NULL,
	`is_male`        BOOLEAN      NOT NULL,
	`place_of_birth` VARCHAR(255),
	`date_of_birth`  DATE,
	`email`          VARCHAR(255) NOT NULL UNIQUE,
	PRIMARY KEY (`id`)
);
