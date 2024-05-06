CREATE TABLE IF NOT EXISTS `car_owner`
(
    `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `first_name`   VARCHAR(255)        NOT NULL,
    `last_name`    VARCHAR(255)        NOT NULL,
    `email`        VARCHAR(320) UNIQUE NOT NULL,
    `phone_number` VARCHAR(20) UNIQUE  NOT NULL,
    `password`     CHAR(60)            NOT NULL,
    `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted_at`   DATETIME  DEFAULT NULL

);
# one-to-many 1 владелец может иметь много машин. внешний ключ owner_id
CREATE TABLE IF NOT EXISTS `car`
(
    `car_id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `owner_id`         INT UNSIGNED,
    `license_plate`    CHAR(60) NOT NULL,
    `year_manufacture` INT      NOT NULL,
    `brand`            CHAR(60) NOT NULL,
    `body_type`        CHAR(60) NOT NULL,
    `created_at`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted_at`       DATETIME  DEFAULT NULL,
    FOREIGN KEY (`owner_id`) REFERENCES car_owner (`id`)
);
CREATE TABLE IF NOT EXISTS `spare_part`
(
    `spare_part_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name_part`     CHAR(60) NOT NULL,
    `model_part`    CHAR(60) NOT NULL,
    `price_part`    FLOAT    NOT NULL,
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted_at`    DATETIME  DEFAULT NULL
);
# many-to-many: 1 машина имеет множество деталей, 1 деталь может относиться к разным машинам.
CREATE TABLE IF NOT EXISTS car_spares_parts
(
    car_id        INT UNSIGNED,
    spare_part_id INT UNSIGNED,
    FOREIGN KEY (car_id) REFERENCES car (car_id),
    FOREIGN KEY (spare_part_id) REFERENCES spare_part (spare_part_id),
    PRIMARY KEY (car_id, spare_part_id)
);

