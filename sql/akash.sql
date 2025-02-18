ALTER TABLE `firebase_notification_log` ADD `master_notification_template_id` INT NOT NULL AFTER `id`;
ALTER TABLE `firebase_notification_log` ADD `send_datetime` DATETIME NULL AFTER `status`;



ALTER TABLE `user_posts` ADD `v_size` INT NULL DEFAULT NULL AFTER `description`, ADD `v_duration` INT NULL DEFAULT NULL AFTER `v_size`;