# Création de la base de données
DROP DATABASE IF EXISTS `Garage_VParrot`;
CREATE DATABASE `Garage_VParrot`;
USE `Garage_VParrot`;

# Création des tables
CREATE TABLE `garage` (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `schedule_id` INT DEFAULT NULL,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone_number` VARCHAR(20) DEFAULT NULL,
    `address` VARCHAR(255) NOT NULL,
    INDEX `IDX_garage_scheduleID` (schedule_id)
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE car (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `created_by_id` INT DEFAULT NULL,
    `garage_id` INT DEFAULT NULL,
    `constructor` VARCHAR(50) NOT NULL,
    `model` VARCHAR(50) NOT NULL,
    `engine` VARCHAR(50) NOT NULL,
    `license_plate` VARCHAR(9) NOT NULL,
    `registration_year` INT NOT NULL,
    `mileage` INT NOT NULL,
    `price` DOUBLE NOT NULL,
    `created_at` DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    `modified_at` DATETIME on update CURRENT_TIMESTAMP,
    `published` TINYINT(1) NOT NULL,
    INDEX `IDX_car_createdByID` (created_by_id),
    INDEX `IDX_car_garageID` (garage_id)
) DEFAULT CHARSET=utf8mb4;;

CREATE TABLE contact_message (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `car_id` INT DEFAULT NULL,
    `name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `subject` VARCHAR(100) NOT NULL,
    `message` LONGTEXT NOT NULL,
    `terms_accepted` TINYINT(1) NOT NULL,
    `created_at` DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    INDEX `IDX_contact_message_carId` (car_id)
) DEFAULT CHARSET=utf8mb4;;

CREATE TABLE photo (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `car_id` INT NOT NULL,
    `filename` VARCHAR(255) NOT NULL,
    `alt` VARCHAR(255) DEFAULT NULL,
    `image_size` INT NOT NULL,
    `mime_type` VARCHAR(10) NOT NULL,
    `modified_at` DATETIME on update CURRENT_TIMESTAMP,
    INDEX `IDX_photo_carID` (car_id)
) DEFAULT CHARSET=utf8mb4;;

CREATE TABLE schedule (
    `id` INT PRIMARY KEY NOT NULL,
    `opened_days` JSON DEFAULT NULL
) DEFAULT CHARSET=utf8mb4;;

CREATE TABLE service (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `created_by_id` INT DEFAULT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` LONGTEXT NOT NULL,
    `price` INT DEFAULT NULL,
    `image_name` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    `modified_at` DATETIME on update CURRENT_TIMESTAMP,
    `published` TINYINT(1) NOT NULL,
    INDEX `IDX_service_createdByID` (created_by_id)
 ) DEFAULT CHARSET=utf8mb4;;

CREATE TABLE service_garage (
    `service_id` INT NOT NULL,
    `garage_id` INT NOT NULL,
    INDEX `IDX_service_garage_serviceID` (service_id),
    INDEX `IDX_service_garage_garageID` (garage_id),
    PRIMARY KEY (service_id, garage_id)
) DEFAULT CHARSET=utf8mb4;;

CREATE TABLE testimonial (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `created_by_id` INT DEFAULT NULL,
    `approved_by_id` INT DEFAULT NULL,
    `author` VARCHAR(255) NOT NULL,
    `comment` LONGTEXT NOT NULL,
    `note` SMALLINT NOT NULL,
    `is_approved` TINYINT(1) NOT NULL,
    `created_at` DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    `modified_at` DATETIME on update CURRENT_TIMESTAMP,
    INDEX `IDX_testimonial_createdByID` (created_by_id),
    INDEX `IDX_testimonial_approvedByID` (approved_by_id)
) DEFAULT CHARSET=utf8mb4;;

CREATE TABLE user (
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `garage_id` INT DEFAULT NULL,
    `email` VARCHAR(180) NOT NULL,
    `password` VARCHAR(60) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `roles` JSON NOT NULL,
    UNIQUE INDEX `UNIQ_user_email` (email),
    INDEX `IDX_user_garageID` (garage_id)
) DEFAULT CHARSET=utf8mb4;;

# Déclaration des clés étrangères
ALTER TABLE car ADD CONSTRAINT `FK_car_createdByID_user_id` FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL;
ALTER TABLE car ADD CONSTRAINT `FK_car_garageID_garage_id` FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE SET NULL;
ALTER TABLE contact_message ADD CONSTRAINT `FK_contactMessage_carID_car_id` FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL;
ALTER TABLE garage ADD CONSTRAINT `FK_garage_scheduleID_schedule_id` FOREIGN KEY (schedule_id) REFERENCES schedule (id);
ALTER TABLE photo ADD CONSTRAINT `FK_photo_carID_car_id` FOREIGN KEY (car_id) REFERENCES car (id);
ALTER TABLE service ADD CONSTRAINT `FK_service_createdByID_user_id` FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL;
ALTER TABLE service_garage ADD CONSTRAINT `FK_serviceGarage_serviceID_service_id` FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE;
ALTER TABLE service_garage ADD CONSTRAINT `FK_serviceGarage_garageID_garage_id` FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE;
ALTER TABLE testimonial ADD CONSTRAINT `FK_testimonial_createdByID_user_id` FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL;
ALTER TABLE testimonial ADD CONSTRAINT `FK_testimonial_approvedByID_user_id` FOREIGN KEY (approved_by_id) REFERENCES user (id) ON DELETE SET NULL;
ALTER TABLE user ADD CONSTRAINT `FK_user_garageID_garage_id` FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE SET NULL;


# Insertion des données initiales (un schedule, un garage, un user)
INSERT INTO `schedule` (`id`, `opened_days`) VALUES (1,
    '{
    "1" : "Lun : 08h00 - 12h00, 13h00 - 17h00",
    "2" : "Mar : 08h00 - 12h00, 13h00 - 17h00",
    "3" : "Mer : 09h30 - 13h30, 14h30 - 17h30",
    "4" : "Jeu : 08h00 - 12h00, 13h00 - 17h00",
    "5" : "Ven : 08h00 - 12h00, 13h00 - 17h00",
    "6" : "Sam : 10h00 - 12h00, 13h00 - 16h00",
    "7" : "Dim : fermé"
    }'
);

INSERT INTO `garage` VALUES (NULL, 1, 'Siège Social', 'vincentParrot@VP.com', '0123456789', '7 avenue du vase de Soissons, 31000 Toulouse');
SET @garage_id = (SELECT `id` FROM `garage` WHERE id = 1);
INSERT INTO  `user` VALUES (NULL, @garage_id, 'vincentParrot@VP.com', '$2y$13$CreVardVkrC8Xxr3fed.KeRLLYxZ3Eid0FX3q.4g6ymryTiuyiLiu', 'Vincent', 'Parrot', '["ROLE_SUPER_ADMIN"]' );