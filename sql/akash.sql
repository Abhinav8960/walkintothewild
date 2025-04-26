-- 26 APRIL 
ALTER TABLE `partner_registration` CHANGE `legal_entity_whatsapp` `legal_entity_whatsapp` BIGINT NULL DEFAULT NULL;
ALTER TABLE `partner_registration` CHANGE `registration_number` `registration_number` BIGINT NULL DEFAULT NULL;
ALTER TABLE `partner_gst_details` CHANGE `gst_number` `gst_number` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `partner_registration` CHANGE `billing_phone` `billing_phone` BIGINT NULL DEFAULT NULL;
ALTER TABLE `partner_registration` CHANGE `account_number` `account_number` BIGINT NULL DEFAULT NULL;
ALTER TABLE `partner_registration` CHANGE `kyc_phone` `kyc_phone` BIGINT NULL DEFAULT NULL, CHANGE `kyc_whatsapp` `kyc_whatsapp` BIGINT NULL DEFAULT NULL, CHANGE `aadhar_number` `aadhar_number` BIGINT NULL DEFAULT NULL;
ALTER TABLE `partner_registration` ADD `is_sendforapproval` TINYINT NOT NULL DEFAULT '0' AFTER `form5_status`;
ALTER TABLE `partner_registration` CHANGE `is_sendforapproval` `is_sendforapproval` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `partner_registration` ADD `is_step_1_approved` INT NULL DEFAULT '0' AFTER `is_sendforapproval`, ADD `is_step_2_approved` INT NULL DEFAULT '0' AFTER `is_step_1_approved`, ADD `is_step_3_approved` INT NULL DEFAULT '0' AFTER `is_step_2_approved`, ADD `is_step_4_approved` INT NULL DEFAULT '0' AFTER `is_step_3_approved`, ADD `is_step_5_approved` INT NULL DEFAULT '0' AFTER `is_step_4_approved`, ADD `updated_time_step_1` DATETIME NULL DEFAULT NULL AFTER `is_step_5_approved`, ADD `updated_time_step_2` DATETIME NULL DEFAULT NULL AFTER `updated_time_step_1`, ADD `updated_time_step_3` DATETIME NULL DEFAULT NULL AFTER `updated_time_step_2`, ADD `updated_time_step_4` DATETIME NULL DEFAULT NULL AFTER `updated_time_step_3`, ADD `updated_time_step_5` DATETIME NULL DEFAULT NULL AFTER `updated_time_step_4`, ADD `final` INT NULL DEFAULT NULL AFTER `updated_time_step_5`, ADD `final_approved` INT NULL DEFAULT '0' AFTER `final`, ADD `updated_time_final_approved` DATETIME NULL DEFAULT NULL AFTER `final_approved`, ADD `updated_time_final` DATETIME NULL DEFAULT NULL AFTER `updated_time_final_approved`, ADD `status` INT NULL DEFAULT '0' AFTER `updated_time_final`;

---
-- 12 April Anurag
ALTER TABLE `share_safari` ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `status`, ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_api`;
ALTER TABLE `safari_park` ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `google_review_count`, ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_web`;
ALTER TABLE `package` ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `updated_by`, ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_web`;
-- XXXXXXXXXXXXXXXXXXXXXXXX --

ALTER TABLE `user_post_comment` CHANGE `message` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
ALTER TABLE `user_post_comment` CHANGE `comment_datetime` `dateTime` DATETIME NOT NULL;
ALTER TABLE `sighting_comment` CHANGE `comment_datetime` `dateTime` DATETIME NOT NULL;
ALTER TABLE `sighting_comment` CHANGE `message` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
-- 10 April

ALTER TABLE `user_posts`
  DROP `type_of_post`,
  DROP `video_thumbnail`,
  DROP `video_thumbnail_path`,
  DROP `video_thumbnail_etag`,
  DROP `like_count`,
  DROP `latitude`,
  DROP `longitude`,
  DROP `location`,
  DROP `description`,
  DROP `master_animal_id`,
  DROP `safari_session_id`,
  DROP `post_datetime`,
  DROP `zone_id`,
  DROP `v_size`,
  DROP `v_duration`;

  ALTER TABLE `user_posts` ADD `size` INT NULL AFTER `etag`;
-- 29 March


  ALTER TABLE `user_posts` ADD `master_animal_id` INT NULL AFTER `description`, ADD `safari_session_id` INT NULL AFTER `master_animal_id`, ADD `post_datetime` INT NULL AFTER `safari_session_id`, ADD `zone_id` INT NULL AFTER `post_datetime`;
ALTER TABLE `user_posts` DROP `location`;
ALTER TABLE `user_posts` ADD `location` INT NULL AFTER `longitude`;
-- 28 March



ALTER TABLE `moderation` CHANGE `model` `collection` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `model_id` `collection_id` INT NULL DEFAULT NULL;


ALTER TABLE `moderation` ADD `is_api_failed` INT NULL DEFAULT '0' AFTER `duration_flag`;
-- 26 march
ALTER TABLE `moderation`  ADD `model` VARCHAR(255) NULL DEFAULT NULL  AFTER `updated_by`,  ADD `model_id` INT NULL DEFAULT NULL  AFTER `model`;
ALTER TABLE `moderation` CHANGE `model` `model` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `type`, CHANGE `model_id` `model_id` INT NULL DEFAULT NULL AFTER `model`
-- 25 March
ALTER TABLE `moderation` ADD `duration_flag` BOOLEAN NULL DEFAULT NULL AFTER `text`;
ALTER TABLE `video_audio`
  DROP `info_id`,
  DROP `info_position`;

-- 21 March
ALTER TABLE `video_gore` CHANGE `real` `gore_real` FLOAT NULL DEFAULT NULL;
ALTER TABLE `video_selfharm` CHANGE `real` `self_harm_real` FLOAT NULL DEFAULT NULL;
ALTER TABLE `video_audio_profanity` CHANGE `match` `profanity_match` VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;



--Previous
ALTER TABLE `firebase_notification_log` ADD `master_notification_template_id` INT NOT NULL AFTER `id`;
ALTER TABLE `firebase_notification_log` ADD `send_datetime` DATETIME NULL AFTER `status`;



ALTER TABLE `user_posts` ADD `v_size` INT NULL DEFAULT NULL AFTER `description`, ADD `v_duration` INT NULL DEFAULT NULL AFTER `v_size`;


ALTER TABLE `user_posts` ADD `video_thumbnail` TEXT NULL DEFAULT NULL AFTER `filepath`, ADD `video_thumbnail_path` VARCHAR(512) NULL DEFAULT NULL AFTER `video_thumbnail`, ADD `video_thumbnail_etag` VARCHAR(512) NULL DEFAULT NULL AFTER `video_thumbnail_path`;
