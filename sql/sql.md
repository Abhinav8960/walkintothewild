ALTER TABLE `firebase_notification_log` ADD `is_system_notification` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_web_notification`;


<!-- safari park Notes field added -->
ALTER TABLE `safari_park` ADD `notes` TEXT NULL DEFAULT NULL AFTER `safri_cost_note`;


ALTER TABLE `user_session` ADD `user_platform_version` VARCHAR(100) NULL DEFAULT NULL AFTER `user_platform`;
ALTER TABLE `site_api_request` ADD `platform_version` VARCHAR(100) NULL DEFAULT NULL AFTER `platform`;
ALTER TABLE `site_api_request` ADD `application_version` VARCHAR(100) NULL DEFAULT NULL AFTER `browser_version`;
ALTER TABLE `user_session` ADD `application_version` VARCHAR(100) NULL DEFAULT NULL AFTER `app_name`;



<!-- quotation send by operator mail_template -->
INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QSBO', 'Quotation Send By Operator', 'quotationSendByOperator-html', '1', '1730710897', '30', '1730710897', '30')
<!-- notes change to quotation_form_note -->
ALTER TABLE `safari_park` ADD `notes` TEXT NULL DEFAULT NULL AFTER `safri_cost_note`;
ALTER TABLE `safari_park` CHANGE `notes` `quotation_form_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

<!-- june 23,2025 -->
ALTER TABLE `chat_message` ADD `is_edited` BOOLEAN NOT NULL DEFAULT FALSE AFTER `gallery`;

<!-- 25 June 2025 -->

ALTER TABLE `lead_partners` ADD `is_assign_by_admin` INT NULL DEFAULT NULL AFTER `is_chat_started`;
ALTER TABLE `lead` ADD `is_payment_link_send` BOOLEAN NOT NULL DEFAULT FALSE AFTER `assigned_operator_count`;
ALTER TABLE `lead_partners` ADD `is_payment_link_send` BOOLEAN NOT NULL DEFAULT FALSE AFTER `assign_by_admin_date_time`;
ALTER TABLE `lead_partner_quotes` ADD `is_payment_link_send` BOOLEAN NOT NULL DEFAULT FALSE AFTER `payment_gateway`;