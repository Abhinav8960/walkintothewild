					
ALTER TABLE `lead_partner_quotes` ADD `quotation_filepath` VARCHAR(255) NULL DEFAULT NULL AFTER `rejection_reason`;
INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QABA', 'Quotation Approved By Admin', 'quotationApprovedByAdmin-html', '1', '1716278771', '2', '1716289465', '2');
UPDATE `master_mail_template` SET `code` = 'QAAU' WHERE `master_mail_template`.`id` = 37;
UPDATE `master_mail_template` SET `name` = 'Quotation Approved By Admin for User', `path` = 'quotationApprovedByAdminforUser-html' WHERE `master_mail_template`.`id` = 37;

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QAAU', 'Quotation Approved By Admin for Operator', 'quotationApprovedByAdminforOperator-html', '1', '1716278771', '2', '1716289465', '2');

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QAAO', 'Quotation Approved By Admin for Operator', 'quotationApprovedByAdminforOperator-html', '1', '1716278771', '2', '1716289465', '2');


ALTER TABLE `lead_partner_quote_installments` ADD `qr_code_file` TEXT NULL DEFAULT NULL AFTER `payment_hash`;
ALTER TABLE `lead_partner_quote_installments` CHANGE `qr_code_file` `qr_code_file` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

UPDATE `lead_partner_quote_installments` SET `qr_code_file_base64`=NULL;

ALTER TABLE `lead_partner_quote_installments` CHANGE `qr_code_file` `qr_code_file` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

-- 29052025

ALTER TABLE `lead_partner_quote_installments` CHANGE `status` `status` INT NOT NULL DEFAULT '0' COMMENT '0=>not received, 1=> received';
ALTER TABLE `lead_partner_quotes` ADD `is_payment_received` BOOLEAN NOT NULL DEFAULT FALSE AFTER `created_at`;
ALTER TABLE `lead_partner_quote_installments` ADD `transaction_id` VARCHAR(255) NULL DEFAULT NULL AFTER `status`, ADD `transaction_datetime` DATETIME NULL DEFAULT NULL AFTER `transaction_id`;
ALTER TABLE `lead_partner_quote_installments` ADD `payment_gateway` INT NULL DEFAULT NULL COMMENT '1=>payu,2=>hdfc' AFTER `status`;
ALTER TABLE `lead_partner_quotes` ADD `transaction_id` VARCHAR(255) NULL DEFAULT NULL AFTER `is_payment_received`, ADD `transaction_datetime` DATETIME NULL DEFAULT NULL AFTER `transaction_id`, ADD `payment_gateway` INT NULL DEFAULT NULL COMMENT '1=>payu,2=>hdfc' AFTER `transaction_datetime`;

ALTER TABLE `lead` ADD `is_payment_received` BOOLEAN NOT NULL DEFAULT FALSE AFTER `status`, ADD `booked_operator_id` INT NOT NULL AFTER `is_payment_received`, ADD `transaction_id` VARCHAR(255) NULL DEFAULT NULL AFTER `booked_operator_id`, ADD `transaction_datetime` DATETIME NULL DEFAULT NULL AFTER `transaction_id`, ADD `payment_gateway` INT NOT NULL COMMENT '1=>payu,2=>hdfc' AFTER `transaction_datetime`;


ALTER TABLE `user` ADD `google_avatar_image` VARCHAR(512) NULL DEFAULT NULL AFTER `avatar`;	

ALTER TABLE `lead_partner_quotes` CHANGE `permit_booking_date_time` `permit_booking_date` DATE NULL DEFAULT NULL;

ALTER TABLE `lead_partner_quotes` CHANGE `validity_date_time` `validity_date` DATE NULL DEFAULT NULL;



INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QPRU', 'Quotation Payment Received', 'quotationPaymentReceived-html', '1', '1716278771', '2', '1716289465', '2')

UPDATE `master_mail_template` SET `name` = 'Quotation Payment Received For User', `path` = 'quotationPaymentReceivedForUser-html' WHERE `master_mail_template`.`code` = 'QPRU';


INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QPRP', 'Quotation Payment Received For Partner', 'quotationPaymentReceivedForPartner-html', '1', '1716278771', '2', '1716289465', '2')


ALTER TABLE `partner_gallery_image` ADD `set_as_thumbnail` INT NULL DEFAULT '0' AFTER `sequence`;
ALTER TABLE `chat_message` ADD `gallery_url` VARCHAR(512) NULL DEFAULT NULL AFTER `data`;


ALTER TABLE `chat_message` CHANGE `message` `message` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

ALTER TABLE `lead` ADD `user_notes` VARCHAR(1000) NULL DEFAULT NULL AFTER `addional_notes`;
