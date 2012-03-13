
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- posts
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL,
	`slug` VARCHAR(255) NOT NULL,
	`excerpt` TEXT NOT NULL,
	`content` TEXT NOT NULL,
	`published` TINYINT(1) DEFAULT 0 NOT NULL,
	`locked` TINYINT(1) DEFAULT 0 NOT NULL,
	`created_by` INTEGER NOT NULL,
	`published_by` INTEGER,
	`locked_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `posts_FI_1` (`created_by`),
	INDEX `posts_FI_2` (`published_by`),
	CONSTRAINT `posts_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `posts_FK_2`
		FOREIGN KEY (`published_by`)
		REFERENCES `users` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- comments
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`post_id` INTEGER,
	`content` TEXT NOT NULL,
	`created_by` INTEGER NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `comments_FI_1` (`post_id`),
	INDEX `comments_FI_2` (`created_by`),
	CONSTRAINT `comments_FK_1`
		FOREIGN KEY (`post_id`)
		REFERENCES `posts` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `comments_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255),
	`salt` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`roles` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `users_U_1` (`username`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
