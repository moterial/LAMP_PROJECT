SET time_zone = "+08:00";

CREATE TABLE `myDb`.`Users` (`userId` INT UNSIGNED NOT NULL AUTO_INCREMENT , `ac` VARCHAR(20) NOT NULL , `pw` VARCHAR(255) NOT NULL , `email` VARCHAR(60) NOT NULL , `privilege` VARCHAR(20) NOT NULL DEFAULT 'user' , `parentId` INT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , `deleted_at` DATETIME NOT NULL , PRIMARY KEY (`userId`)) ENGINE = InnoDB;
CREATE TABLE `myDb`.`Tasks` (`taskId` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
`role` VARCHAR(20) NOT NULL , 
`content` VARCHAR(255) NOT NULL ,
 `status` BOOLEAN NOT NULL DEFAULT FALSE ,
  `parentId` INT NULL , `userId` INT NULL , 
  `created_at` DATETIME NOT NULL , 
  `updated_at` DATETIME NOT NULL , 
  `deleted_at` DATETIME NOT NULL , 
  PRIMARY KEY (`taskId`), 
  `finished` INT NOT NULL DEFAULT 0) ENGINE = InnoDB;

-- 1. create log table .....
CREATE TABLE `myDb`.`Logs` (`eventId` INT UNSIGNED NOT NULL AUTO_INCREMENT , `userID` INT UNSIGNED NOT NULL, 
`content` VARCHAR(255) NOT NULL, `datetime` DATETIME NOT NULL, PRIMARY KEY (`eventId`)) ENGINE = InnoDB;


CREATE USER 'dev'@'%' IDENTIFIED BY 'comp3335';
GRANT ALL PRIVILEGES ON myDb.* TO 'dev'@'%' WITH GRANT OPTION;