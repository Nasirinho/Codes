-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Farming vendor
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Farming vendor
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Farming vendor` DEFAULT CHARACTER SET utf8 ;
USE `Farming vendor` ;

-- -----------------------------------------------------
-- Table `Farming vendor`.`Farmer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Farming vendor`.`Farmer` (
  `farmer_id` INT NOT NULL AUTO_INCREMENT,
  `farm_name` VARCHAR(60) NOT NULL,
  `farmer_first_name` VARCHAR(45) NOT NULL,
  `farmer_last_name` VARCHAR(45) NOT NULL,
  `farm_address` VARCHAR(120) NULL,
  `phone` VARCHAR(45) NULL,
  `email` VARCHAR(77) NULL,
  PRIMARY KEY (`farmer_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Farming vendor`.`Product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Farming vendor`.`Product` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(50) NOT NULL,
  `category` VARCHAR(45) NULL,
  `measurement` VARCHAR(45) NULL,
  `price` DECIMAL(10,2) NULL,
  PRIMARY KEY (`product_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Farming vendor`.`Customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Farming vendor`.`Customer` (
  `customer_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`customer_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Farming vendor`.`Transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Farming vendor`.`Transaction` (
  `transaction_id` INT NOT NULL AUTO_INCREMENT,
  `transaction_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_amount` DECIMAL(10,2) NULL,
  `customer_id` INT NOT NULL,
  PRIMARY KEY (`transaction_id`),
  INDEX `customer_id_idx` (`customer_id` ASC) VISIBLE,
  CONSTRAINT `customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `Farming vendor`.`Customer` (`customer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Farming vendor`.`Transaction_per_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Farming vendor`.`Transaction_per_item` (
  `item_id` INT NOT NULL AUTO_INCREMENT,
  `quantity` DECIMAL(10,2) NOT NULL,
  `price_at_sale` DECIMAL(10,2) NOT NULL,
  `transaction_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `farmer_id` INT NOT NULL,
  PRIMARY KEY (`item_id`),
  INDEX `transaction_id_idx` (`transaction_id` ASC) VISIBLE,
  INDEX `product_id_idx` (`product_id` ASC) VISIBLE,
  INDEX `farmer_id_idx` (`farmer_id` ASC) VISIBLE,
  CONSTRAINT `transaction_id`
    FOREIGN KEY (`transaction_id`)
    REFERENCES `Farming vendor`.`Transaction` (`transaction_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `product_id`
    FOREIGN KEY (`product_id`)
    REFERENCES `Farming vendor`.`Product` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `farmer_id`
    FOREIGN KEY (`farmer_id`)
    REFERENCES `Farming vendor`.`Farmer` (`farmer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
