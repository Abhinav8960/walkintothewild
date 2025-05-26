ALTER TABLE `lead_partner_quotes` ADD `quotation_filepath` VARCHAR(255) NULL DEFAULT NULL AFTER `rejection_reason`;
INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QABA', 'Quotation Approved By Admin', 'quotationApprovedByAdmin-html', '1', '1716278771', '2', '1716289465', '2');
UPDATE `master_mail_template` SET `code` = 'QAAU' WHERE `master_mail_template`.`id` = 37;
UPDATE `master_mail_template` SET `name` = 'Quotation Approved By Admin for User', `path` = 'quotationApprovedByAdminforUser-html' WHERE `master_mail_template`.`id` = 37;

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QAAU', 'Quotation Approved By Admin for Operator', 'quotationApprovedByAdminforOperator-html', '1', '1716278771', '2', '1716289465', '2');

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'QAAO', 'Quotation Approved By Admin for Operator', 'quotationApprovedByAdminforOperator-html', '1', '1716278771', '2', '1716289465', '2');


ALTER TABLE `lead_partner_quote_installments` ADD `qr_code_file_base64` TEXT NULL DEFAULT NULL AFTER `payment_hash`;
ALTER TABLE `lead_partner_quote_installments` CHANGE `qr_code_file_base64` `qr_code_file_base64` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;