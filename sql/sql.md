ALTER TABLE `firebase_notification_log` ADD `is_system_notification` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_web_notification`;


<!-- safari park Notes field added -->
ALTER TABLE `safari_park` ADD `notes` TEXT NULL DEFAULT NULL AFTER `safri_cost_note`;


ALTER TABLE `user_session` ADD `user_platform_version` VARCHAR(100) NULL DEFAULT NULL AFTER `user_platform`;
ALTER TABLE `site_api_request` ADD `platform_version` VARCHAR(100) NULL DEFAULT NULL AFTER `platform`;
ALTER TABLE `site_api_request` ADD `application_version` VARCHAR(100) NULL DEFAULT NULL AFTER `browser_version`;
ALTER TABLE `user_session` ADD `application_version` VARCHAR(100) NULL DEFAULT NULL AFTER `app_name`;