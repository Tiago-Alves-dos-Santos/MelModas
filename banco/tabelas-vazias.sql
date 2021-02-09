-- MySQL Workbench Forward Engineering

-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mel_modas
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mel_modas
-- -----------------------------------------------------
-- CREATE SCHEMA IF NOT EXISTS `mel_modas` DEFAULT CHARACTER SET utf8 ;
-- USE `mel_modas` ;

-- -----------------------------------------------------
-- Table `mel_modas`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `nome` VARCHAR(255) NULL,
  `senha` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `mel_modas`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`cliente` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `nome` VARCHAR(255) NULL,
  `rua` VARCHAR(255) NULL,
  `bairro` VARCHAR(255) NULL,
  `numero_casa` INT NULL,
  `complemento` TEXT NULL,
  `data_nasc` DATE NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `mel_modas`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`produto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `codigo` VARCHAR(255) NULL,
  `nome` VARCHAR(255) NULL,
  `quantidade` INT NULL,
  `marca` VARCHAR(255) NULL,
  `foto` VARCHAR(45) NULL,
  `valor_compra` DOUBLE NULL,
  `valor_venda` DOUBLE NULL,
  `descricao` TEXT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `mel_modas`.`cliente_produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`cliente_produto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente_id` INT NOT NULL,
  `produto_id` INT NOT NULL,
  `valor_total` DOUBLE NULL,
  `forma_pagamento` VARCHAR(255) NULL,
  `parcelamento` VARCHAR(255) NULL,
  `estado_compra` VARCHAR(45) NULL,
  `descricao` VARCHAR(255) NULL,
  `cliente_anonimo` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  INDEX `fk_cliente_has_produto_produto1_idx` (`produto_id` ASC) ,
  INDEX `fk_cliente_has_produto_cliente_idx` (`cliente_id` ASC) ,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cliente_has_produto_cliente`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `mel_modas`.`cliente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_has_produto_produto1`
    FOREIGN KEY (`produto_id`)
    REFERENCES `mel_modas`.`produto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mel_modas`.`nota_promissoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`nota_promissoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `cliente_produto_id` INT NOT NULL,
  PRIMARY KEY (`id`, `cliente_produto_id`),
  INDEX `fk_nota_promissoria_cliente_produto1_idx` (`cliente_produto_id` ASC) ,
  CONSTRAINT `fk_nota_promissoria_cliente_produto1`
    FOREIGN KEY (`cliente_produto_id`)
    REFERENCES `mel_modas`.`cliente_produto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mel_modas`.`promocao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`promocao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `desconto_porcento` INT NULL,
  `valor_atingir` DOUBLE NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `mel_modas`.`cliente_promocao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`cliente_promocao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente_id` INT NOT NULL,
  `promocao_id` INT NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `mes_antigido` DATE NULL,
  `valor_atual` DOUBLE NULL,
  INDEX `fk_cliente_has_promocao_promocao1_idx` (`promocao_id` ASC) ,
  INDEX `fk_cliente_has_promocao_cliente1_idx` (`cliente_id` ASC) ,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cliente_has_promocao_cliente1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `mel_modas`.`cliente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_has_promocao_promocao1`
    FOREIGN KEY (`promocao_id`)
    REFERENCES `mel_modas`.`promocao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table `mel_modas`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mel_modas`.`telefone` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `telefone` VARCHAR(255) NULL,
  `cliente_id` INT NOT NULL,
  PRIMARY KEY (`id`, `cliente_id`),
  INDEX `fk_telefone_cliente1_idx` (`cliente_id` ASC) ,
  CONSTRAINT `fk_telefone_cliente1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `mel_modas`.`cliente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
