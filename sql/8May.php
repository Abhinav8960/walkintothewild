<!-- 14 May 2025 -->
ALTER TABLE `user_posts` ADD `version` INT NOT NULL DEFAULT '1' AFTER `id`;
ALTER TABLE `user_post_comment` ADD `version` INT NOT NULL AFTER `id`;
ALTER TABLE `user_post_like` ADD `version` INT NOT NULL AFTER `id`;

<!-- 13 May 2025 -->
ALTER TABLE `package_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';
ALTER TABLE `share_safari_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';

ALTER TABLE `sighting_comment` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;
ALTER TABLE `sighting_comment_flag` ADD `reason` VARCHAR(512) NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `sighting_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';

ALTER TABLE `user_post_comment` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;
ALTER TABLE `user_post_comment_flag` ADD `reason` VARCHAR(512) NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `user_post_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';


ALTER TABLE `chat` ADD `lead_id` INT NULL DEFAULT NULL AFTER `id`; // need to run on server
ALTER TABLE `lead_partner_quotes` ADD `is_approved_by_admin` BOOLEAN NOT NULL DEFAULT FALSE AFTER `addtional_data`;
ALTER TABLE `lead_partner_quotes` ADD `datetime_of_approval_by_admin` DATETIME NULL DEFAULT NULL AFTER `is_approved_by_admin`;
INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES ('12', 'Partner Quotation Received', 'Partner Quotation Received', 'Quotation Received: {{park_name}} by {{user_name}}!', '1', '1746790635', '30', '1746790635', '30')
INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (11, 'Package Quotation Received', 'Package Quotation Received', 'Quotation Received on package: {{package_name}} by {{user_name}}!', '1', '1746790635', '30', '1746790635', '30');


ALTER TABLE `master_notification_template` ADD `type` VARCHAR(255) NULL DEFAULT NULL AFTER `id`;
UPDATE `master_notification_template` SET `type` = 'Joined Safari' WHERE `master_notification_template`.`id` = 1;
UPDATE `master_notification_template` SET `type` = 'New Comment' WHERE `master_notification_template`.`id` = 2;
UPDATE `master_notification_template` SET `type` = 'New Comment' WHERE `master_notification_template`.`id` = 3;
UPDATE `master_notification_template` SET `type` = 'New Follower' WHERE `master_notification_template`.`id` = 4;
UPDATE `master_notification_template` SET `type` = 'Package Intrest' WHERE `master_notification_template`.`id` = 5;
UPDATE `master_notification_template` SET `type` = 'Quote Request' WHERE `master_notification_template`.`id` = 6;
UPDATE `master_notification_template` SET `type` = 'New Review' WHERE `master_notification_template`.`id` = 7;
INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'chat message received', '{{sender}}', '{{message}}', '1', '1735806556', '30', '1735806556', '30');


CREATE TABLE `wildwalks`.`lead_partners` ( `id` INT NOT NULL AUTO_INCREMENT , `lead_id` INT NOT NULL , `partner_id` INT NOT NULL COMMENT 'safari_operator' , `status` BOOLEAN NOT NULL DEFAULT TRUE , `created_by` INT NOT NULL , `updated_by` INT NOT NULL , `created_at` INT NOT NULL , `updated_at` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `wildwalks`.`lead_partners` ADD UNIQUE (`lead_id`, `partner_id`);



ALTER TABLE `sighting` ADD `delete_reason` VARCHAR(512) NULL DEFAULT NULL AFTER `v_duration`;
ALTER TABLE `user_posts` ADD `delete_reason` VARCHAR(512) NULL DEFAULT NULL AFTER `width`;


ALTER TABLE `user_post_comment` ADD `flaged` INT NULL DEFAULT NULL AFTER `dateTime`;
ALTER TABLE `sighting_comment` ADD `flaged` INT NULL DEFAULT NULL AFTER `dateTime`;