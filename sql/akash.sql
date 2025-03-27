
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
