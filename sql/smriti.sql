ALTER TABLE `park` ADD `park_type_id` INT NULL DEFAULT NULL AFTER `slug`;
ALTER TABLE `master_airport` ADD `iata_code` VARCHAR(255) NULL DEFAULT NULL AFTER `city_id`;
ALTER TABLE `master_airport` ADD `icao_code` VARCHAR(255) NULL DEFAULT NULL AFTER `iata_code`;


ALTER TABLE `master_location`
  DROP `country_id`,
  DROP `state_id`,
  DROP `city_id`;


ALTER TABLE `master_state` ADD `location_id` INT NULL DEFAULT NULL AFTER `state_name`;
RENAME TABLE `walkintothewild`.`meta_operator_category` TO `walkintothewild`.`master_operator_category`;
ALTER TABLE `master_operator_category` ADD `type_id` INT NULL DEFAULT NULL AFTER `title`;



ALTER TABLE `safari_operator_request` CHANGE `operator_email` `operator_email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `birding_operator_request` CHANGE `operator_email` `operator_email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `safari_operator_request` ADD `is_agree` INT NOT NULL DEFAULT '1' AFTER `comment`;
ALTER TABLE `birding_operator_request` ADD `is_agree` INT NOT NULL DEFAULT '1' AFTER `comment`;



ALTER TABLE `safari_operator_request` ADD `registration_platform` INT NULL DEFAULT NULL AFTER `operator_email`;
ALTER TABLE `birding_operator_request` ADD `registration_platform` INT NULL DEFAULT NULL AFTER `operator_email`;




May 30 


ALTER TABLE `safari_park` ADD `logo` VARCHAR(255) NULL DEFAULT NULL AFTER `long_description`, ADD `feature_image` VARCHAR(255) NULL DEFAULT NULL AFTER `logo`;
ALTER TABLE `safari_park` ADD `avg_safari_price_max` VARCHAR(255) NULL DEFAULT NULL AFTER `avg_safari_price`;
ALTER TABLE `safari_park` CHANGE `avg_safari_price` `avg_safari_price_min` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `safari_park` ADD `pincode` INT NULL DEFAULT NULL AFTER `city_id`;
ALTER TABLE `safari_park` ADD `about_title` VARCHAR(255) NULL DEFAULT NULL AFTER `meta_keywords`, ADD `about_description` LONGTEXT NULL DEFAULT NULL AFTER `about_title`;
ALTER TABLE `safari_park_gallery` CHANGE `image_caption` `image_caption` VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `safari_park` ADD `module_title` VARCHAR(255) NULL DEFAULT NULL AFTER `about_description`, ADD `module_description` LONGTEXT NULL DEFAULT NULL AFTER `module_title`;
ALTER TABLE `safari_park` ADD `nearest_railway_station_two` VARCHAR(255) NULL DEFAULT NULL AFTER `nearest_airport_distance`, ADD `nearest_railway_station_distance_two` INT NULL DEFAULT NULL AFTER `nearest_railway_station_two`, ADD `nearest_airport_two` VARCHAR(255) NULL DEFAULT NULL AFTER `nearest_railway_station_distance_two`, ADD `nearest_airport_distance_two` INT NULL DEFAULT NULL AFTER `nearest_airport_two`;
ALTER TABLE `safari_park_zone` CHANGE `master_zone_type_name` `master_zone_type_name` VARCHAR(255) NULL DEFAULT NULL;


new TABLE for safari

1 Flora and fauna
2 month
3 session
4 accomodation



ALTER TABLE `birding_park` ADD `logo` VARCHAR(255) NULL DEFAULT NULL AFTER `long_description`, ADD `feature_image` VARCHAR(255) NULL DEFAULT NULL AFTER `logo`;
ALTER TABLE `birding_park` ADD `avg_safari_price_max` VARCHAR(255) NULL DEFAULT NULL AFTER `avg_safari_price`;
ALTER TABLE `birding_park` CHANGE `avg_safari_price` `avg_safari_price_min` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `birding_park` ADD `pincode` INT NULL DEFAULT NULL AFTER `city_id`;
ALTER TABLE `birding_park` ADD `about_title` VARCHAR(255) NULL DEFAULT NULL AFTER `meta_keywords`, ADD `about_description` LONGTEXT NULL DEFAULT NULL AFTER `about_title`;
ALTER TABLE `birding_park_gallery` CHANGE `image_caption` `image_caption` VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `birding_park` ADD `module_title` VARCHAR(255) NULL DEFAULT NULL AFTER `about_description`, ADD `module_description` LONGTEXT NULL DEFAULT NULL AFTER `module_title`;
ALTER TABLE `birding_park` ADD `nearest_railway_station_two` VARCHAR(255) NULL DEFAULT NULL AFTER `nearest_airport_distance`, ADD `nearest_railway_station_distance_two` INT NULL DEFAULT NULL AFTER `nearest_railway_station_two`, ADD `nearest_airport_two` VARCHAR(255) NULL DEFAULT NULL AFTER `nearest_railway_station_distance_two`, ADD `nearest_airport_distance_two` INT NULL DEFAULT NULL AFTER `nearest_airport_two`;
ALTER TABLE `birding_park_zone` CHANGE `master_zone_type_name` `master_zone_type_name` VARCHAR(255) NULL DEFAULT NULL;


new TABLE for birding

1 Flora and fauna
2 month
3 session
4 accomodation



 31 May 

 ALTER TABLE `birding_park` ADD `is_published` TINYINT NOT NULL DEFAULT '1' AFTER `longitude`;
ALTER TABLE `safari_park` ADD `is_published` TINYINT NOT NULL DEFAULT '1' AFTER `longitude`;


new table 

meta_bird_type
master_bird



3 June 2024

ALTER TABLE `deployment_phase` ADD `commit_no` VARCHAR(255) NULL DEFAULT NULL AFTER `version`, ADD `migration` LONGTEXT NULL DEFAULT NULL AFTER `commit_no`;
