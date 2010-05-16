SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mybase` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
CREATE SCHEMA IF NOT EXISTS `new_schema1` ;

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
-- Table `mybase`.`login`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`login` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`login` (
  `idlogin` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(200) NULL ,
  `password` CHAR(32) NULL ,
  `name` VARCHAR(100) NULL ,
  `surname` VARCHAR(100) NULL ,
  `email` VARCHAR(200) NULL ,
  PRIMARY KEY (`idlogin`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`user` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`user` (
  `iduser` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idlogin` INT UNSIGNED NOT NULL ,
  `idaccount` INT UNSIGNED NOT NULL ,
  `idcompany` INT UNSIGNED NULL ,
  `email` VARCHAR(200) NULL COMMENT 'Příjmení' ,
  `mobile` VARCHAR(50) NULL COMMENT 'Číslo na mobil' ,
  `home` VARCHAR(50) NULL COMMENT 'Číslo do práce / kanceláře' ,
  `work` VARCHAR(50) NULL COMMENT 'Číslo domů' ,
  `im` VARCHAR(150) NULL COMMENT 'Uživatelské jméno / číslo v instant messengeru' ,
  `imservice` SET('aol','msn','icq','yahoo','jabber','skype','gtalk') NULL COMMENT 'Název instant messengeru' ,
  `owner` TINYINT(1)  NOT NULL DEFAULT 0 COMMENT 'Majitel účtu' ,
  `administrator` TINYINT(1)  NOT NULL DEFAULT 0 ,
  `status` TINYINT(1)  NOT NULL DEFAULT 0 ,
  `registered` DATE NOT NULL ,
  PRIMARY KEY (`iduser`, `idaccount`, `idcompany`, `idlogin`) ,
  INDEX `fk_account_user` (`idaccount` ASC) ,
  INDEX `fk_company_user` (`idcompany` ASC) ,
  INDEX `fk_login_user` (`idlogin` ASC) ,
  CONSTRAINT `fk_account_user`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_company_user`
    FOREIGN KEY (`idcompany` )
    REFERENCES `mybase`.`company` (`idcompany` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_login_user`
    FOREIGN KEY (`idlogin` )
    REFERENCES `mybase`.`login` (`idlogin` )
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
  `iduser` INT UNSIGNED NULL ,
  `idcompany` INT UNSIGNED NULL ,
  `name` VARCHAR(100) NOT NULL COMMENT 'Název projektu' ,
  `description` VARCHAR(255) NULL ,
  `img` VARCHAR(155) NULL ,
  `status` SET('active','complete','canceled') NOT NULL ,
  PRIMARY KEY (`idproject`, `idaccount`) ,
  INDEX `fk_account_project` (`idaccount` ASC) ,
  INDEX `fk_user_project` (`iduser` ASC) ,
  INDEX `fk_company_project` (`idcompany` ASC) ,
  CONSTRAINT `fk_account_project`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_project`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_company_project`
    FOREIGN KEY (`idcompany` )
    REFERENCES `mybase`.`company` (`idcompany` )
    ON DELETE SET NULL
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
  `permission` VARCHAR(255) NOT NULL COMMENT 'Oprávnění. Ukládá se serializované pole ve tvaru array(sekce => bitová maska, ...)' ,
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
-- Table `mybase`.`priority`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`priority` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`priority` (
  `idpriority` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idaccount` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(155) NOT NULL ,
  PRIMARY KEY (`idpriority`, `idaccount`) ,
  INDEX `fk_account_priority` (`idaccount` ASC) ,
  CONSTRAINT `fk_account_priority`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`milestone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`milestone` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`milestone` (
  `idmilestone` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idproject` INT UNSIGNED NOT NULL ,
  `iduser` INT UNSIGNED NULL ,
  `idpriority` INT UNSIGNED NULL ,
  `name` VARCHAR(150) NOT NULL ,
  `datetime` DATE NOT NULL ,
  `description` VARCHAR(255) NULL ,
  `status` SET('active','complete','canceled','paused') NOT NULL ,
  `parent` INT UNSIGNED NULL ,
  PRIMARY KEY (`idmilestone`, `idproject`) ,
  INDEX `fk_project_milestone` (`idproject` ASC) ,
  INDEX `fk_user_milestone` (`iduser` ASC) ,
  INDEX `fk_priority_milestone` (`idpriority` ASC) ,
  CONSTRAINT `fk_project_milestone`
    FOREIGN KEY (`idproject` )
    REFERENCES `mybase`.`project` (`idproject` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_milestone`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_priority_milestone`
    FOREIGN KEY (`idpriority` )
    REFERENCES `mybase`.`priority` (`idpriority` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`checklist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`checklist` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`checklist` (
  `idchecklist` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `iduser` INT UNSIGNED NULL ,
  `idproject` INT UNSIGNED NOT NULL ,
  `idmilestone` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(100) NOT NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`idchecklist`, `idproject`, `idmilestone`) ,
  INDEX `fk_user_checklist` (`iduser` ASC) ,
  INDEX `fk_project_checklist` (`idproject` ASC) ,
  INDEX `fk_milestone_checklist` (`idmilestone` ASC) ,
  CONSTRAINT `fk_user_checklist`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_checklist`
    FOREIGN KEY (`idproject` )
    REFERENCES `mybase`.`project` (`idproject` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_milestone_checklist`
    FOREIGN KEY (`idmilestone` )
    REFERENCES `mybase`.`milestone` (`idmilestone` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`category` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`category` (
  `idcategory` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idaccount` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(155) NOT NULL ,
  PRIMARY KEY (`idcategory`, `idaccount`) ,
  INDEX `fk_account_category` (`idaccount` ASC) ,
  CONSTRAINT `fk_account_category`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`milestoneuser`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`milestoneuser` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`milestoneuser` (
  `idmilestoneuser` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idmilestone` INT UNSIGNED NOT NULL ,
  `iduser` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idmilestoneuser`, `idmilestone`, `iduser`) ,
  INDEX `fk_milestone_MU` (`idmilestone` ASC) ,
  INDEX `fk_user_MU` (`iduser` ASC) ,
  CONSTRAINT `fk_milestone_MU`
    FOREIGN KEY (`idmilestone` )
    REFERENCES `mybase`.`milestone` (`idmilestone` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_MU`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`typ`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`typ` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`typ` (
  `idtyp` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idaccount` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(155) NOT NULL ,
  PRIMARY KEY (`idtyp`, `idaccount`) ,
  INDEX `fk_account_typ` (`idaccount` ASC) ,
  CONSTRAINT `fk_account_typ`
    FOREIGN KEY (`idaccount` )
    REFERENCES `mybase`.`account` (`idaccount` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`ticket`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`ticket` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`ticket` (
  `idticket` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idproject` INT UNSIGNED NOT NULL ,
  `iduser` INT UNSIGNED NULL ,
  `idmilestone` INT UNSIGNED NOT NULL ,
  `idtyp` INT UNSIGNED NULL ,
  `idcategory` INT UNSIGNED NULL ,
  `idpriority` INT UNSIGNED NULL ,
  `status` SET('active','complete','canceled','paused') NOT NULL ,
  `name` VARCHAR(150) NOT NULL ,
  `description` VARCHAR(255) NULL ,
  `datetime` DATETIME NOT NULL ,
  PRIMARY KEY (`idticket`, `idproject`, `idmilestone`) ,
  INDEX `fk_project_ticket` (`idproject` ASC) ,
  INDEX `fk_user_ticket` (`iduser` ASC) ,
  INDEX `fk_milestone_ticket` (`idmilestone` ASC) ,
  INDEX `fk_typ_ticket` (`idtyp` ASC) ,
  INDEX `fk_category_ticket` (`idcategory` ASC) ,
  INDEX `fk_priority_ticket` (`idpriority` ASC) ,
  CONSTRAINT `fk_project_ticket`
    FOREIGN KEY (`idproject` )
    REFERENCES `mybase`.`project` (`idproject` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_ticket`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_milestone_ticket`
    FOREIGN KEY (`idmilestone` )
    REFERENCES `mybase`.`milestone` (`idmilestone` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_typ_ticket`
    FOREIGN KEY (`idtyp` )
    REFERENCES `mybase`.`typ` (`idtyp` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_ticket`
    FOREIGN KEY (`idcategory` )
    REFERENCES `mybase`.`category` (`idcategory` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_priority_ticket`
    FOREIGN KEY (`idpriority` )
    REFERENCES `mybase`.`priority` (`idpriority` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`ticketuser`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`ticketuser` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`ticketuser` (
  `idticketuser` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idticket` INT UNSIGNED NOT NULL ,
  `iduser` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idticketuser`, `idticket`, `iduser`) ,
  INDEX `fk_ticket_TU` (`idticket` ASC) ,
  INDEX `fk_user_TU` (`iduser` ASC) ,
  CONSTRAINT `fk_ticket_TU`
    FOREIGN KEY (`idticket` )
    REFERENCES `mybase`.`ticket` (`idticket` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_TU`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mybase`.`task`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mybase`.`task` ;

CREATE  TABLE IF NOT EXISTS `mybase`.`task` (
  `idtask` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `iduser` INT UNSIGNED NULL ,
  `idproject` INT UNSIGNED NOT NULL ,
  `idmilestone` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(155) NOT NULL ,
  `status` SET('active','complete') NOT NULL ,
  `completed` DATETIME NULL ,
  PRIMARY KEY (`idtask`, `idproject`, `idmilestone`) ,
  INDEX `fk_user_task` (`iduser` ASC) ,
  INDEX `fk_project_task` (`idproject` ASC) ,
  INDEX `fk_milestone_task` (`idmilestone` ASC) ,
  CONSTRAINT `fk_user_task`
    FOREIGN KEY (`iduser` )
    REFERENCES `mybase`.`user` (`iduser` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_task`
    FOREIGN KEY (`idproject` )
    REFERENCES `mybase`.`project` (`idproject` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_milestone_task`
    FOREIGN KEY (`idmilestone` )
    REFERENCES `mybase`.`milestone` (`idmilestone` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Placeholder table for view `mybase`.`user_login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mybase`.`user_login` (`iduser` INT, `email` INT, `owner` INT, `administrator` INT, `name` INT, `surname` INT, `username` INT, `password` INT, `idaccount` INT);

-- -----------------------------------------------------
-- Placeholder table for view `mybase`.`user_meta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mybase`.`user_meta` (`name` INT, `surname` INT, `username` INT, `iduser` INT, `idaccount` INT, `idcompany` INT, `email` INT, `mobile` INT, `home` INT, `work` INT, `im` INT, `imservice` INT, `status` INT);

-- -----------------------------------------------------
-- View `mybase`.`user_login`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `mybase`.`user_login` ;
DROP TABLE IF EXISTS `mybase`.`user_login`;
CREATE  OR REPLACE VIEW `mybase`.`user_login` AS 
SELECT user.iduser, login.email, user.owner, user.administrator, login.name, login.surname, login.username, login.password, user.idaccount
FROM login
LEFT JOIN user ON login.idlogin = user.idlogin;

-- -----------------------------------------------------
-- View `mybase`.`user_meta`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `mybase`.`user_meta` ;
DROP TABLE IF EXISTS `mybase`.`user_meta`;
CREATE  OR REPLACE VIEW `mybase`.`user_meta` AS
SELECT login.name, login.surname, login.username, user.iduser, user.idaccount, user.idcompany, user.email, user.mobile, user.home, user.work, user.im, user.imservice, user.status
FROM login
LEFT JOIN user ON login.idlogin = user.idlogin;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
