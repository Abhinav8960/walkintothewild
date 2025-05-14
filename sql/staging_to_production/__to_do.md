1 create a function to make package table copy with prefix of "pp_".






















//////////////////////////////Check for MODERATION DB///////////////////////////////////////////////////////
ALTER TABLE `moderation` ADD `duration_flag` BOOLEAN NULL DEFAULT NULL AFTER `text`;
ALTER TABLE `video_audio`
  DROP `info_id`,
  DROP `info_position`;

ALTER TABLE `moderation`  ADD `model` VARCHAR(255) NULL DEFAULT NULL  AFTER `updated_by`,  ADD `model_id` INT NULL DEFAULT NULL  AFTER `model`;
ALTER TABLE `moderation` CHANGE `model` `model` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `type`, CHANGE `model_id` `model_id` INT NULL DEFAULT NULL AFTER `model`;
ALTER TABLE `moderation` CHANGE `model` `collection` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `model_id` `collection_id` INT NULL DEFAULT NULL;


ALTER TABLE `moderation` ADD `is_api_failed` INT NULL DEFAULT '0' AFTER `duration_flag`;
