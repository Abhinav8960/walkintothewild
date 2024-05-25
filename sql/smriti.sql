ALTER TABLE `park` ADD `park_type_id` INT NULL DEFAULT NULL AFTER `slug`;
ALTER TABLE `master_airport` ADD `iata_code` VARCHAR(255) NULL DEFAULT NULL AFTER `city_id`;
ALTER TABLE `master_airport` ADD `icao_code` VARCHAR(255) NULL DEFAULT NULL AFTER `iata_code`;


ALTER TABLE `master_location`
  DROP `country_id`,
  DROP `state_id`,
  DROP `city_id`;


ALTER TABLE `master_state` ADD `location_id` INT NULL DEFAULT NULL AFTER `state_name`;
