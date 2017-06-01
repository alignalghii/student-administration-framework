CREATE TABLE `student` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`is_male` BOOLEAN NOT NULL,
	`place_of_birth` VARCHAR(255),
	`date_of_birth` VARCHAR(255),
	`email` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
);
