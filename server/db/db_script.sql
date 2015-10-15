SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `virtualtour` DEFAULT CHARACTER SET utf8 ;
USE `virtualtour` ;

-- -----------------------------------------------------
-- Table `virtualtour`.`maps`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `virtualtour`.`maps` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `src` VARCHAR(255) NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  `position` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `virtualtour`.`stops`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `virtualtour`.`stops` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `room` VARCHAR(45) NOT NULL,
  `content` VARCHAR(10240) NULL DEFAULT NULL,
  `position` INT(11) NOT NULL,
  `map_x` DOUBLE NULL DEFAULT NULL,
  `map_y` DOUBLE NULL DEFAULT NULL,
  `qr_id` VARCHAR(255) NULL DEFAULT NULL,
  `active` TINYINT(4) NULL DEFAULT '1',
  `map_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_stops_maps_idx` (`map_id` ASC),
  CONSTRAINT `fk_stops_maps`
    FOREIGN KEY (`map_id`)
    REFERENCES `virtualtour`.`maps` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `virtualtour`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `virtualtour`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `admin` TINYINT(4) NOT NULL DEFAULT '0',
  `created_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
