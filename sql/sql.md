ALTER TABLE `firebase_notification_log` ADD `is_system_notification` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_web_notification`;


<!-- safari park Notes field added -->
ALTER TABLE `safari_park` ADD `notes` TEXT NULL DEFAULT NULL AFTER `safri_cost_note`;


ALTER TABLE `user_session` ADD `user_platform_version` VARCHAR(100) NULL DEFAULT NULL AFTER `user_platform`;
ALTER TABLE `site_api_request` ADD `platform_version` VARCHAR(100) NULL DEFAULT NULL AFTER `platform`;
ALTER TABLE `site_api_request` ADD `application_version` VARCHAR(100) NULL DEFAULT NULL AFTER `browser_version`;
ALTER TABLE `user_session` ADD `application_version` VARCHAR(100) NULL DEFAULT NULL AFTER `app_name`;



<!-- quotation send by operator mail_template -->
INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QSBO', 'Quotation Send By Operator', 'quotationSendByOperator-html', '1', '1730710897', '30', '1730710897', '30');
<!-- notes change to quotation_form_note -->
ALTER TABLE `safari_park` ADD `notes` TEXT NULL DEFAULT NULL AFTER `safri_cost_note`;
ALTER TABLE `safari_park` CHANGE `notes` `quotation_form_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

<!-- june 23,2025 -->
ALTER TABLE `chat_message` ADD `is_edited` BOOLEAN NOT NULL DEFAULT FALSE AFTER `gallery`;

<!-- 25 June 2025 -->

ALTER TABLE `lead_partners` ADD `is_assign_by_admin` INT NULL DEFAULT FALSE AFTER `is_chat_started`;
ALTER TABLE `lead` ADD `is_payment_link_send` BOOLEAN NOT NULL DEFAULT FALSE AFTER `assigned_operator_count`;
ALTER TABLE lead_partners ADD assign_by_admin_date_time INT NULL DEFAULT NULL AFTER is_assign_by_admin;
ALTER TABLE `lead_partners` ADD `is_payment_link_send` BOOLEAN NOT NULL DEFAULT FALSE AFTER `assign_by_admin_date_time`;
ALTER TABLE `lead_partner_quotes` ADD `is_payment_link_send` BOOLEAN NOT NULL DEFAULT FALSE AFTER `payment_gateway`;



<!-- 01 july 2025 -->
ALTER TABLE `transaction` CHANGE `installment` `installment` INT NOT NULL DEFAULT '1' COMMENT 'Installment_id';
ALTER TABLE `transaction` ADD `user_id` INT NOT NULL AFTER `id`;
ALTER TABLE `transaction` CHANGE `status` `status` INT NULL DEFAULT '1' COMMENT '0=>initiated,1=>Success,2=>Failed,3=>Hold,4=>Refunded';


<!-- 02072025 -->
ALTER TABLE `lead_partners` ADD `is_payment_received` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_payment_link_send`;
ALTER TABLE `lead_partners` ADD `transaction_id` INT NULL DEFAULT NULL AFTER `is_payment_received`, ADD `transaction_datetime` DATETIME NULL DEFAULT NULL AFTER `transaction_id`;
ALTER TABLE `lead_partners` ADD `payment_gateway` INT NULL DEFAULT NULL AFTER `is_payment_link_send`;
ALTER TABLE `lead_partner_quote_installments` ADD `is_payment_received` INT NOT NULL DEFAULT '0' AFTER `status`;


ALTER TABLE `booking` ADD `lead_partner_quotes_id` INT NOT NULL AFTER `id`;

<!-- 03072025 -->
ALTER TABLE `chat` ADD `is_closed` BOOLEAN NOT NULL DEFAULT FALSE AFTER `status`;
ALTER TABLE `lead_partner_quote_installments` ADD `is_payment_expired` BOOLEAN NOT NULL DEFAULT FALSE AFTER `status`;


<!-- 04072025 -->
INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'PRQU', 'Payment Received Against Quotation For User', 'payment_received_against_quotation_for_user-html', '1', '1716278771', '2', '1716289465', '2');

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'PRQO', 'Payment Received Against Quotation For Operator', 'payment_received_against_quotation_for_operator-html', '1', '1716278771', '2', '1716289465', '2');


ALTER TABLE `lead_partner_quote_installments` ADD `payment_expired_datetime` DATETIME NULL DEFAULT NULL AFTER `is_payment_expired`, ADD `payment_expired_reason` VARCHAR(255) NULL DEFAULT NULL AFTER `payment_expired_datetime`;


ALTER TABLE `lead_partner_quotes` ADD `is_payment_expired` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_payment_link_send`, ADD `payment_expired_datetime` DATETIME NULL DEFAULT NULL AFTER `is_payment_expired`, ADD `payment_expired_reason` VARCHAR(255) NULL DEFAULT NULL AFTER `payment_expired_datetime`;

ALTER TABLE `booking` ADD `payment_receipt` VARCHAR(255) NULL DEFAULT NULL AFTER `param5`;
ALTER TABLE `lead` ADD `payment_receipt` VARCHAR(255) NULL DEFAULT NULL AFTER `is_payment_received`;
ALTER TABLE `lead_partner_quotes` ADD `payment_receipt` VARCHAR(255) NULL DEFAULT NULL AFTER `is_payment_received`;
ALTER TABLE `lead_partner_quote_installments` ADD `payment_receipt` VARCHAR(255) NULL DEFAULT NULL AFTER `is_payment_received`;

ALTER TABLE `chat_message` ADD `is_system_generated` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_edited`;

<!-- 14 july Notification template -->
ALTER TABLE `master_notification_template` CHANGE `module_type` `module_type` INT NULL DEFAULT NULL COMMENT '1 => \'Package\', 2 => \'Safari\', 3 => \'Fixed Departure\', 4 => \'User\', 5 => \'Operator\', 6 =>\'Chat\',\r\n7 => \'comment/review\',\r\n8 =>\'quote\' ,\r\n9 => \'post\',\r\n10 => \'sighting\'';
INSERT INTO `master_notification_template` (`id`, `module_type`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, '9', 'New Post', '{{username}} just shared a new post.', 'Take a look!', '1', '1735806556', '30', '1735806556', '30');
INSERT INTO `master_notification_template` (`id`, `module_type`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, '10', 'New Sighting', 'New sighting alert!', 'Tap to see the latest update.', '1', '1735806556', '30', '1735806556', '30');


<!-- support user column added -->
ALTER TABLE `user` ADD `is_support_user` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_admin`;

ALTER TABLE `safari_park` ADD `short_name` VARCHAR(255) NULL DEFAULT NULL AFTER `title`;

ALTER TABLE `partner_gallery` DROP `can_send_for_approval`;
ALTER TABLE `partner_gallery_version` DROP `can_send_for_approval`;

ALTER TABLE `partner_gallery` ADD `user_id` INT NOT NULL AFTER `safari_operator_id`;
ALTER TABLE `partner_gallery_version` ADD `user_id` INT NOT NULL AFTER `safari_operator_id`;

ALTER TABLE partner_gallery_image
DROP original_filename,
DROP file;

ALTER TABLE `partner_gallery` ADD `delete_reason` VARCHAR(512) NULL DEFAULT NULL AFTER `remark`;





<!-- qutation new template -->
INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QUME', 'Quotation Message', 'quotationchatemail-html', '1', '1716278771', '2', '1716289465', '2');


ALTER TABLE safari_operator_rating CHANGE status status INT NULL DEFAULT '10' COMMENT '10 =>\'Create\'\r\n1 => \'Active\'\r\n0 => \'Inactive\'\r\n-1 => \'Delete\'';