ALTER TABLE `park` ADD `park_type_id` INT NULL DEFAULT NULL AFTER `slug`;
ALTER TABLE `master_airport` ADD `iata_code` VARCHAR(255) NULL DEFAULT NULL AFTER `city_id`;
ALTER TABLE `master_airport` ADD `icao_code` VARCHAR(255) NULL DEFAULT NULL AFTER `iata_code`;
