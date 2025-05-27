
-- working


INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'UADR', 'User Account Delete Request', 'userAccountDeleteRequest-html', '1', '1716278771', '2', '1716289465', '2');
ALTER TABLE `sighting` CHANGE `post_datetime` `post_datetime` DATE NULL DEFAULT NULL;

ALTER TABLE `user` ADD `is_mobile_no_verified` BOOLEAN NOT NULL DEFAULT FALSE AFTER `mobile_no`;
ALTER TABLE `chat_message` ADD `is_quotation_message` BOOLEAN NOT NULL DEFAULT FALSE AFTER `message`, ADD `quotation_id` INT NULL DEFAULT NULL AFTER `is_quotation_message`, ADD `is_quotation_active` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotation_id`;
ALTER TABLE `sighting` ADD `show_in_front` INT NULL DEFAULT '0' AFTER `delete_reason`;

ALTER TABLE `prod_witw`.`chat_message` ADD INDEX (`chat_id`);
ALTER TABLE `prod_witw`.`chat` DROP INDEX `chat_hash`, ADD INDEX `chat_hash` (`chat_hash`, `user_id`, `recipient_user_id`) USING BTREE;

ALTER TABLE `prod_witw`.`share_safari_comment` ADD INDEX (`share_safari_id`);
ALTER TABLE `prod_witw`.`share_safari_comment` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`share_safari_comment` ADD INDEX (`parent_id`);

ALTER TABLE `prod_witw`.`safari_operator_park` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`safari_operator_park` ADD INDEX (`safari_operator_id`);
ALTER TABLE `prod_witw`.`safari_operator_park` ADD INDEX (`park_id`);
ALTER TABLE `prod_witw`.`share_safari_intrested` DROP INDEX `share_safari_id`, ADD INDEX `share_safari_id` (`share_safari_id`, `user_id`, `status`) USING BTREE;
ALTER TABLE `prod_witw`.`share_safari` ADD INDEX (`host_user_id`, `park_id`, `start_date`, `end_date`, `estimate_price_min`, `estimate_price_max`, `cost_per_person`, `total_seat`, `status`);
ALTER TABLE `prod_witw`.`package` ADD INDEX (`package_slug`, `start_date`, `end_date`, `stay_category_id`, `status`, `live_version`);
ALTER TABLE `prod_witw`.`feeds` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`sighting_comment` ADD INDEX (`user_id`, `safari_operator_id`, `sighting_id`, `flaged`, `status`);
ALTER TABLE `prod_witw`.`sighting` ADD INDEX (`user_id`, `safari_operator_id`, `status`, `show_in_front`);
ALTER TABLE `prod_witw`.`sighting_comment_like` ADD INDEX (`user_id`, `safari_operator_id`, `sighting_comment_id`, `status`);
ALTER TABLE `prod_witw`.`sighting_comment_flag` ADD INDEX (`sighting_id`, `sighting_comment_id`, `user_id`, `status`);

ALTER TABLE `prod_witw`.`safari_parks_animal` ADD INDEX (`safari_park_id`, `master_animal_id`);
ALTER TABLE `prod_witw`.`safari_park` ADD INDEX (`show_in_filter`);
ALTER TABLE `prod_witw`.`safari_park` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`safari_park` ADD INDEX (`sequence`);
ALTER TABLE `prod_witw`.`safari_park` ADD INDEX (`is_published`);
ALTER TABLE `prod_witw`.`safari_park` ADD INDEX (`is_shared_safari`);
ALTER TABLE `prod_witw`.`safari_park_accomodation` ADD INDEX (`safari_park_id`);
ALTER TABLE `prod_witw`.`safari_park_accomodation` ADD INDEX (`master_accomodation_id`);
ALTER TABLE `prod_witw`.`safari_park_bonus_experience` ADD INDEX (`safari_park_id`);
ALTER TABLE `prod_witw`.`safari_park_bonus_experience` ADD INDEX (`master_bonus_experience_id`);
ALTER TABLE `prod_witw`.`safari_park_flora_fauna` ADD INDEX (`safari_park_id`);
ALTER TABLE `prod_witw`.`safari_park_flora_fauna` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`safari_park_month` ADD INDEX (`safari_park_id`);
ALTER TABLE `prod_witw`.`safari_park_month` ADD INDEX (`month_id`);
ALTER TABLE `prod_witw`.`safari_park_month` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`safari_park_session` ADD INDEX (`safari_park_id`);
ALTER TABLE `prod_witw`.`safari_park_session` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`safari_park_session` ADD INDEX (`session_id`);
ALTER TABLE `prod_witw`.`safari_park_trip_slot` ADD INDEX (`safari_park_id`);
ALTER TABLE `prod_witw`.`safari_park_trip_slot` ADD INDEX (`status`);


ALTER TABLE `prod_witw`.`safari_suggestions` ADD INDEX (`is_approved`);
ALTER TABLE `prod_witw`.`safari_suggestions` ADD INDEX (`status`);
ALTER TABLE `prod_witw`.`share_safari_comment` ADD INDEX (`park_id`);
ALTER TABLE `prod_witw`.`share_safari_comment` ADD INDEX (`user_id`);
ALTER TABLE `prod_witw`.`share_safari_comment` ADD INDEX (`safari_operator_id`);
ALTER TABLE `prod_witw`.`share_safari_included` ADD INDEX (`status`);

ALTER TABLE `prod_witw`.`share_safari_park` ADD INDEX (`share_safari_id`);
ALTER TABLE `prod_witw`.`share_safari_park` ADD INDEX (`park_id`);
ALTER TABLE `prod_witw`.`share_safari_park` ADD INDEX (`status`);

ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`share_safari_id`);
ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`park_id`);
ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`request_token`);
ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`share_safari_comment_id`);
ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`user_id`);
ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`host_user_id`);
ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`is_filled`);
ALTER TABLE `prod_witw`.`share_safari_request_contact` ADD INDEX (`status`);


ALTER TABLE `prod_witw`.`chat` ADD INDEX (`lead_id`);
ALTER TABLE `prod_witw`.`chat` ADD INDEX (`user_id`);
ALTER TABLE `prod_witw`.`chat` ADD INDEX (`recipient_user_id`);
ALTER TABLE `prod_witw`.`chat` ADD INDEX (`chat_type`);
ALTER TABLE `prod_witw`.`chat` ADD INDEX (`park_id`);
ALTER TABLE `prod_witw`.`chat` ADD INDEX (`quote_id`);
ALTER TABLE `prod_witw`.`chat` ADD INDEX (`status`);


ALTER TABLE `user` ADD `mobile_no_verified_at` INT NULL DEFAULT NULL AFTER `is_mobile_no_verified`;
ALTER TABLE `user_session` ADD `verification_mobile_no` VARCHAR(50) NOT NULL AFTER `is_firebase_token_active`, ADD `verification_mobile_no_otp` VARCHAR(10) NOT NULL AFTER `verification_mobile_no`, ADD `verification_mobile_no_otp_expiry_datetime` DATETIME NULL DEFAULT NULL AFTER `verification_mobile_no_otp`;
ALTER TABLE `user_session` CHANGE `verification_mobile_no` `verification_mobile_no` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `verification_mobile_no_otp` `verification_mobile_no_otp` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

ALTER TABLE `package_version` ADD `original_image_filename` VARCHAR(512) NULL DEFAULT NULL AFTER `package_banner_image`, ADD `original_banner_filename` VARCHAR(512) NULL DEFAULT NULL AFTER `original_image_filename`;
ALTER TABLE `package` ADD `original_image_filename` VARCHAR(512) NULL DEFAULT NULL AFTER `package_banner_image`, ADD `original_banner_filename` VARCHAR(512) NULL DEFAULT NULL AFTER `original_image_filename`;
ALTER TABLE `package_day` ADD `original_filename` VARCHAR(512) NULL DEFAULT NULL AFTER `day_image`;

ALTER TABLE `user_posts` ADD `original_filename` VARCHAR(512) NULL DEFAULT NULL AFTER `safari_operator_id`;
ALTER TABLE `sighting` ADD `original_filename` VARCHAR(512) NULL DEFAULT NULL AFTER `safari_operator_id`;
ALTER TABLE `sighting` ADD `original_thumbnail` VARCHAR(512) NULL DEFAULT NULL AFTER `filepath`;

ALTER TABLE `firebase_notification_log` ADD `is_web_notification` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_cron_run`;

INSERT INTO `master_notification_template` (`id`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (13, 'New Safari Created', 'Check New Safari!', '1', '1735806556', '30', '1735806556', '30');
INSERT INTO `master_notification_template` (`id`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (14, 'Safari Updated', 'Safari is updated now !', '1', '1735806556', '30', '1735806556', '30');
UPDATE `master_notification_template` SET `type` = 'New Safari Created' WHERE `master_notification_template`.`id` = 13;
UPDATE `master_notification_template` SET `type` = 'Safari Updated' WHERE `master_notification_template`.`id` = 14;
UPDATE `master_notification_template` SET `message` = '{{username}} has created a Shared Safari! Join now and explore together.' WHERE `master_notification_template`.`id` = 13;
UPDATE `master_notification_template` SET `message` = 'Shared Safari in {{park_name}}! Do not miss out.' WHERE `master_notification_template`.`id` = 14;


UPDATE `master_sms_template` SET `route` = '1' WHERE `master_sms_template`.`id` = 1;
UPDATE `master_sms_template` SET `message` = 'Dear{{name}}, your OTP for mobile number verification with Walk Into The Wild is {{otp}}. Please enter this code to complete your verification. - Mediarc Technology' WHERE `master_sms_template`.`id` = 1;



<!-- --new -->
UPDATE `master_notification_template` SET `message` = '{{username}} has created a Shared Safari! Join now and explore together.' WHERE `master_notification_template`.`id` = 13;
UPDATE `master_notification_template` SET `message` = '{{var1}} commented on your {{var2}} !' WHERE `master_notification_template`.`id` = 3;
INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (15, 'Fixed Departure Created', 'Fixed Departure Created', 'Your safari {{safari_name}} is live! Spread the word to fill seats fast!', '1', '1735806556', '30', '1735806556', '30');
INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (16, 'Fixed Departure Updated', 'Fixed Departure Updated', 'Ready for a safari? {{operator_name}}\'s fixed departure is here!', '1', '1735806556', '30', '1735806556', '30');
INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'Package Created', 'Package Created', '{{username}} has created a Shared Safari! Join now and explore together.', '1', '1735806556', '30', '1735806556', '30');
INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'Package Updated', 'Package Updated', '{{username}} has updated their safari package! See what’s new.', '1', '1735806556', '30', '1735806556', '30')
ALTER TABLE `sms_log` ADD `service_id` INT NULL DEFAULT NULL AFTER `message_id`;
ALTER TABLE `sms_log` CHANGE `status` `status` INT NOT NULL DEFAULT '2';

ALTER TABLE `master_notification_template` ADD `module_type` INT NULL DEFAULT NULL COMMENT '1 => \'Package\', 2 => \'Safari\', 3 => \'Fixed Departure\', 4 => \'User\', 5 => \'Operator\', 6 =>\'Chat\', ' AFTER `id`;