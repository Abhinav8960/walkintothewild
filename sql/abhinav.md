ALTER TABLE `lead_partners` ADD `reminder_note` TEXT NULL DEFAULT NULL AFTER `transaction_datetime`, ADD `reminder_datetime` DATETIME NULL DEFAULT NULL AFTER `reminder_note`, ADD `lead_category` TINYINT NULL DEFAULT '0' COMMENT '0 => not_in_use, 1 => hot_lead, -1=> cold_lead ' AFTER `reminder_datetime`;
ALTER TABLE `chat_message` ADD `is_reminder` TINYINT NOT NULL DEFAULT '0' AFTER `is_call_request`;
ALTER TABLE `chat_message` ADD `reminder_note` TEXT NULL DEFAULT NULL AFTER `is_call_request`, ADD `reminder_datetime` DATETIME NULL DEFAULT NULL AFTER `reminder_note`;





















ALTER TABLE `compliance_documents` ADD `banner_image` VARCHAR(255) NULL DEFAULT NULL AFTER `effective_date`;
ALTER TABLE `compliance_documents_version` ADD `banner_image` VARCHAR(255) NULL DEFAULT NULL AFTER `effective_date`;
ALTER TABLE `compliance_documents_version` CHANGE `content` `content` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `compliance_documents` CHANGE `content` `content` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
