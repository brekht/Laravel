-- MySQL Workbench Forward Engineering

-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema nature
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema nature
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `nature` DEFAULT CHARACTER SET utf8 ;
USE `nature` ;

-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::

-- Users
-- ---------------------

-- -----------------------------------------------------
-- Table `nature`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(128) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `isAdmin` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `root` TINYINT(1) UNSIGNED NULL,
  `isConfirm` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::

-- Essences & Properties
-- ---------------------

-- -----------------------------------------------------
-- Table `nature`.`essences`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`essences` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `first_author` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`num_property`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`num_property` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `num` SMALLINT UNSIGNED NOT NULL,
  `essences_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `first_author` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_num_property_essences_idx` (`essences_id` ASC),
  UNIQUE INDEX `essences_id_UNIQUE` (`essences_id` ASC),
  CONSTRAINT `fk_num_property_essences`
    FOREIGN KEY (`essences_id`)
    REFERENCES `nature`.`essences` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`desc_property`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`desc_property` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desc` VARCHAR(100) NOT NULL,
  `essences_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `first_author` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_desc_property_essences_idx` (`essences_id` ASC),
  UNIQUE INDEX `essences_id_UNIQUE` (`essences_id` ASC),
  CONSTRAINT `fk_desc_property_essences`
    FOREIGN KEY (`essences_id`)
    REFERENCES `nature`.`essences` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`img_property`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`img_property` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `img` VARCHAR(50) NOT NULL,
  `essences_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `first_author` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_img_property_essences_idx` (`essences_id` ASC),
  UNIQUE INDEX `essences_id_UNIQUE` (`essences_id` ASC),
  UNIQUE INDEX `img_UNIQUE` (`img` ASC),
  CONSTRAINT `fk_img_property_essences`
    FOREIGN KEY (`essences_id`)
    REFERENCES `nature`.`essences` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`freeproperties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`freeproperties` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `col_prop` VARCHAR(100) NOT NULL,
  `col_desc` VARCHAR(100) NOT NULL,
  `essences_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `first_author` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fp_essences_idx` (`essences_id` ASC),
  CONSTRAINT `fk_fp_essences`
    FOREIGN KEY (`essences_id`)
    REFERENCES `nature`.`essences` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::
-- :::::::::::::::::::::::::::::::::::::::::::::::::::::

-- Articles & Categories
-- ---------------------

-- -----------------------------------------------------
-- Table `nature`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `desc` VARCHAR(100) NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`))
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`articles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`articles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `short_text` VARCHAR(200) NOT NULL,
  `full_text` MEDIUMTEXT NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`))
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`category_articles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`category_articles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT UNSIGNED NOT NULL,
  `article_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_category_articles_categories_idx` (`category_id` ASC),
  INDEX `fk_category_articles_articles_idx` (`article_id` ASC),
  CONSTRAINT `fk_category_articles_categories`
    FOREIGN KEY (`category_id`)
    REFERENCES `nature`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_articles_articles`
    FOREIGN KEY (`article_id`)
    REFERENCES `nature`.`articles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nature`.`comments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `comment` TINYTEXT NOT NULL,
  `article_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_comments_articles_idx` (`article_id` ASC),
  INDEX `fk_comments_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_comments_articles`
    FOREIGN KEY (`article_id`)
    REFERENCES `nature`.`articles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `nature`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
-- ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nature`.`migrations`
-- -----------------------------------------------------


-- -----------------------------------------------------
-- Table `nature`.`password_resets`
-- -----------------------------------------------------


-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
