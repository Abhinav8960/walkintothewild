ALTER TABLE `firebase_notification_log` ADD `is_system_notification` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_web_notification`;
