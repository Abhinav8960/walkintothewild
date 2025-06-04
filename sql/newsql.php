ALTER TABLE `sighting` ADD `comment_count` INT NULL DEFAULT '0' AFTER `v_duration`, ADD `like_count` INT NULL DEFAULT '0' AFTER `comment_count`;
ALTER TABLE `user_posts` ADD `comment_count` INT NULL DEFAULT '0' AFTER `delete_reason`, ADD `like_count` INT NULL DEFAULT '0' AFTER `comment_count`;

ALTER TABLE `partner_registration`
  DROP `state`,
  DROP `gst_number`,
  DROP `gst_upload`;
-- UPDATE `safari_operator` SET `operator_name` = 'The Eagle Safaris' WHERE `safari_operator`.`id` = 3;
-- UPDATE `safari_operator` SET `operator_name` = 'Ankit Kankane' WHERE `safari_operator`.`id` = 4;
-- UPDATE `safari_operator` SET `operator_name` = 'Shivsakti' WHERE `safari_operator`.`id` = 23;
-- UPDATE `safari_operator` SET `operator_name` = 'TravellersCo' WHERE `safari_operator`.`id` = 76;
ALTER TABLE `safari_operator` DROP `operated_park`;


-- 3 JUNE --

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'CPBU', 'Comment on Post by User', 'postcomment-html', '1', '1730794695', '30', '1730794695', '30');


UPDATE `master_notification_template` SET `module_type` = '2' WHERE `master_notification_template`.`id` = 1;
UPDATE `master_notification_template` SET `module_type` = '7' WHERE `master_notification_template`.`id` = 2;
UPDATE `master_notification_template` SET `module_type` = '7' WHERE `master_notification_template`.`id` = 3;
UPDATE `master_notification_template` SET `module_type` = '4' WHERE `master_notification_template`.`id` = 4;
UPDATE `master_notification_template` SET `module_type` = '1' WHERE `master_notification_template`.`id` = 5;
UPDATE `master_notification_template` SET `module_type` = '8' WHERE `master_notification_template`.`id` = 6;
UPDATE `master_notification_template` SET `module_type` = '7' WHERE `master_notification_template`.`id` = 7;
UPDATE `master_notification_template` SET `module_type` = '6' WHERE `master_notification_template`.`id` = 8;
UPDATE `master_notification_template` SET `module_type` = '2' WHERE `master_notification_template`.`id` = 9;
UPDATE `master_notification_template` SET `module_type` = '5' WHERE `master_notification_template`.`id` = 10;
UPDATE `master_notification_template` SET `module_type` = '1' WHERE `master_notification_template`.`id` = 11;
UPDATE `master_notification_template` SET `module_type` = '8' WHERE `master_notification_template`.`id` = 12;
UPDATE `master_notification_template` SET `module_type` = '2' WHERE `master_notification_template`.`id` = 13;
UPDATE `master_notification_template` SET `module_type` = '2' WHERE `master_notification_template`.`id` = 14;
UPDATE `master_notification_template` SET `module_type` = '3' WHERE `master_notification_template`.`id` = 15;
UPDATE `master_notification_template` SET `module_type` = '3' WHERE `master_notification_template`.`id` = 16;
UPDATE `master_notification_template` SET `module_type` = '1' WHERE `master_notification_template`.`id` = 17;
UPDATE `master_notification_template` SET `module_type` = '1' WHERE `master_notification_template`.`id` = 18;
ALTER TABLE `master_notification_template` CHANGE `module_type` `module_type` INT NULL DEFAULT NULL COMMENT '1 => \'Package\', 2 => \'Safari\', 3 => \'Fixed Departure\', 4 => \'User\', 5 => \'Operator\', 6 =>\'Chat\',\r\n7 => \'comment/review\',\r\n8 =>\'quote\' ';


<!-- 4 June -->
UPDATE `master_notification_template` SET `message` = '{{username}} has created a new Safari Package! Join now and explore together.' WHERE `master_notification_template`.`id` = 17;
INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'OUNP', 'Operator Updated Package', 'updatepackage-html', '1', '1726655386', '19', '1726655386', '19')