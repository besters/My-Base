SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mybase` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `mybase`;

-- -----------------------------------------------------
-- Table `mybase`.`account`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`account` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`account` (
  `idaccount` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idplan` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(100) NOT NULL ,
  `url` VARCHAR(100) NOT NULL COMMENT 'Url adresa k účtu. Tvar - URL.mybase.cz' ,
  `registered` DATETIME NOT NULL COMMENT 'Datum a čas registrace' ,
  PRIMARY KEY (`idaccount`, `idplan`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`company` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`company` (
  `idcompany` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idaccount` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(100) NOT NULL COMMENT 'Název společnosti' ,
  `logo` VARCHAR(100) NULL COMMENT 'Logo společnosti' ,
  `phone` VARCHAR(50) NULL COMMENT 'Telefonní kontakt' ,
  `fax` VARCHAR(50) NULL COMMENT 'Číslo faxu' ,
  `website` VARCHAR(255) NULL COMMENT 'Webová stránka' ,
  `address1` VARCHAR(100) NULL COMMENT '1. řádek adresy' ,
  `address2` VARCHAR(100) NULL COMMENT '2. řádek adresy' ,
  `city` VARCHAR(100) NULL COMMENT 'Město' ,
  `state` VARCHAR(100) NULL COMMENT 'Stát (platí pro společnosti se sídlem v USA)' ,
  `zip` INT(5) UNSIGNED NULL COMMENT 'PSČ a pro USA ZIP' ,
  `country` VARCHAR(100) NULL COMMENT 'Stát' ,
  PRIMARY KEY (`idcompany`, `idaccount`) ,
  INDEX `fk_account_company` (`idaccount` ASC) ,
  CONSTRAINT `fk_account_company`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`user` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`user` (
  `iduser` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idaccount` INT UNSIGNED NOT NULL ,
  `idcompany` INT UNSIGNED NULL ,
  `title` VARCHAR(30) NULL COMMENT 'Titul - Ing, Mgr, atd.' ,
  `name` VARCHAR(100) NOT NULL COMMENT 'Křestní jméno' ,
  `surname` VARCHAR(100) NOT NULL COMMENT 'Příjmení' ,
  `email` VARCHAR(200) NOT NULL COMMENT 'E-mail' ,
  `username` VARCHAR(20) NOT NULL COMMENT 'Uživatelské jméno' ,
  `password` VARCHAR(50) NOT NULL COMMENT 'Heslo - MD5 hash' ,
  `mobile` VARCHAR(50) NULL COMMENT 'Číslo na mobil' ,
  `home` VARCHAR(50) NULL COMMENT 'Číslo do práce / kanceláře' ,
  `work` VARCHAR(50) NULL COMMENT 'Číslo domů' ,
  `fax` VARCHAR(50) NULL COMMENT 'Číslo faxu' ,
  `im` VARCHAR(150) NULL COMMENT 'Uživatelské jméno / číslo v instant messengeru' ,
  `imservice` SET('aol','msn','icq','yahoo','jabber','skype','gtalk') NULL COMMENT 'Název instant messengeru' ,
  `owner` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Majitel účtu' ,
  PRIMARY KEY (`iduser`, `idaccount`, `idcompany`) ,
  INDEX `fk_account_user` (`idaccount` ASC) ,
  INDEX `fk_company_user` (`idcompany` ASC) ,
  INDEX `email` (`email` ASC) ,
  CONSTRAINT `fk_account_user`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_company_user`
    FOREIGN KEY (`idcompany` )
    REFERENCES `mybase`.`company` (`idcompany` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`activity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`activity` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`activity` (
  `idactivity` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `iduser` INT UNSIGNED NOT NULL ,
  `datetime` DATETIME NULL COMMENT 'Čas poslední aktivity' ,
  PRIMARY KEY (`idactivity`, `iduser`) ,
  INDEX `fk_user_activity` (`iduser` ASC) ,
  CONSTRAINT `fk_user_activity`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`project` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`project` (
  `idproject` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idaccount` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(100) NOT NULL COMMENT 'Název projektu' ,
  PRIMARY KEY (`idproject`, `idaccount`) ,
  INDEX `fk_account_project` (`idaccount` ASC) ,
  CONSTRAINT `fk_account_project`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`acl`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`acl` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`acl` (
  `idacl` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `iduser` INT UNSIGNED NOT NULL ,
  `idproject` INT UNSIGNED NOT NULL ,
  `permission` VARCHAR(255) NULL COMMENT 'Oprávnění. Ukládá se serializované pole ve tvaru array(sekce => bitová maska, ...)' ,
  PRIMARY KEY (`idacl`, `iduser`, `idproject`) ,
  INDEX `fk_user_acl` (`iduser` ASC) ,
  INDEX `fk_project_acl` (`idproject` ASC) ,
  CONSTRAINT `fk_user_acl`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_acl`
    FOREIGN KEY (`idproject` )
    REFERENCES `mybase`.`project` (`idproject` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`plan`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`plan` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`plan` (
  `idplan` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL COMMENT 'Název plánu' ,
  PRIMARY KEY (`idplan`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`milestone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`milestone` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`milestone` (
  `idmilestone` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idproject` INT UNSIGNED NOT NULL ,
  `iduser` INT UNSIGNED NOT NULL ,
  `idpriority` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(150) NULL ,
  `datetime` DATETIME NULL ,
  `description` VARCHAR(255) NULL ,
  `assignee` VARCHAR(255) NULL ,
  `status` SET('active','complete','canceled','paused') NULL ,
  `parent` INT UNSIGNED NULL ,
  PRIMARY KEY (`idmilestone`, `idproject`, `iduser`, `idpriority`) ,
  INDEX `fk_project_milestone` (`idproject` ASC) ,
  CONSTRAINT `fk_project_milestone`
    FOREIGN KEY (`idproject` )
    REFERENCES `mybase`.`project` (`idproject` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
