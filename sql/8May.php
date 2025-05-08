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