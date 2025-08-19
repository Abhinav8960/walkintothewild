ALTER TABLE `user` DROP `is_adminstrator`;
ALTER TABLE `external_operator` ADD `comment` VARCHAR(500) NULL DEFAULT NULL AFTER `is_mail_send`;
ALTER TABLE `external_operator_history` ADD `comment` VARCHAR(500) NULL DEFAULT NULL AFTER `is_mail_send`;