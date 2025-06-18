ALTER TABLE `firebase_notification_log` ADD `is_system_notification` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_web_notification`;


<!-- safari park Notes field added -->
ALTER TABLE `safari_park` ADD `notes` TEXT NULL DEFAULT NULL AFTER `safri_cost_note`;