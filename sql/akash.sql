ALTER TABLE `firebase_notification_log` ADD `master_notification_template_id` INT NOT NULL AFTER `id`;
ALTER TABLE `firebase_notification_log` ADD `send_datetime` DATETIME NULL AFTER `status`;



ALTER TABLE `user_posts` ADD `v_size` INT NULL DEFAULT NULL AFTER `description`, ADD `v_duration` INT NULL DEFAULT NULL AFTER `v_size`;


ALTER TABLE `user_posts` ADD `video_thumbnail` TEXT NULL DEFAULT NULL AFTER `filepath`, ADD `video_thumbnail_path` VARCHAR(512) NULL DEFAULT NULL AFTER `video_thumbnail`, ADD `video_thumbnail_etag` VARCHAR(512) NULL DEFAULT NULL AFTER `video_thumbnail_path`;