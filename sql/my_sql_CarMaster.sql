CREATE TABLE IF NOT EXISTS `car_owner`
(
    `owner_id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `first_name`   VARCHAR(20)        NOT NULL,
    `last_name`    VARCHAR(20)        NOT NULL,
    `email`        VARCHAR(30) UNIQUE NOT NULL,
    `phone_number` INT      NOT NULL,
    `password`     CHAR(60)            NOT NULL,
    `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted_at`   DATETIME  DEFAULT NULL

);
# one-to-many 1 владелец может иметь много машин. внешний ключ owner_id
CREATE TABLE IF NOT EXISTS `car`
(
    `vehicle_id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `owner_id`         INT UNSIGNED,
    `license_plate`    CHAR(60) NOT NULL,
    `year_manufacture` INT      NOT NULL,
    `brand`            CHAR(60) NOT NULL,
    `body_type`        CHAR(60) NOT NULL,
    `created_at`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted_at`       DATETIME  DEFAULT NULL,
    FOREIGN KEY (`owner_id`) REFERENCES car_owner (`owner_id`)
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
    vehicle_id        INT UNSIGNED,
    spare_part_id INT UNSIGNED,
    FOREIGN KEY (vehicle_id) REFERENCES car (vehicle_id),
    FOREIGN KEY (spare_part_id) REFERENCES spare_part (spare_part_id),
    PRIMARY KEY (vehicle_id, spare_part_id)
);

INSERT INTO spare_part (name_part, model_part, price_part) VALUES ('Part 1', 'Model 1', 100.00);
INSERT INTO spare_part (name_part, model_part, price_part) VALUES ('Part 2', 'Model 2', 100.00);
INSERT INTO spare_part (name_part, model_part, price_part) VALUES ('Part 3', 'Model 3', 100.00);
INSERT INTO spare_part (name_part, model_part, price_part) VALUES ('Brake Pad', 'Toyota Camry', 100.00);




SELECT s0_.spare_part_id AS spare_part_id_0, s0_.name_part AS name_part_1, s0_.model_part AS model_part_2,
       s0_.price_part AS price_part_3 FROM spare_part s0_ INNER JOIN car_spares_parts c2_ ON s0_.spare_part_id =
                                                                                             c2_.spare_part_id INNER JOIN vehicle v1_ ON v1_.vehicle_id = c2_.vehicle_id AND v1_.type IN ('Car') WHERE
    v1_.brand = ?
