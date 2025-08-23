ALTER TABLE `user` DROP `is_adminstrator`;
ALTER TABLE `external_operator` ADD `comment` VARCHAR(500) NULL DEFAULT NULL AFTER `is_mail_send`;
ALTER TABLE `external_operator_history` ADD `comment` VARCHAR(500) NULL DEFAULT NULL AFTER `is_mail_send`;

ALTER TABLE `transaction` ADD `transaction_type` CHAR(1) NOT NULL DEFAULT 'c' COMMENT 'c=>Credit,d=debit' AFTER `utm_source`, ADD `parent_id` INT NULL AFTER `transaction_type`, ADD `remark` TEXT NULL DEFAULT NULL AFTER `parent_id`;