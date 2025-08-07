ALTER TABLE `transaction`  ADD `source` INT NOT NULL DEFAULT '1' COMMENT '1=>Lead,2=>share safari'  AFTER `id`;
RENAME TABLE `share_safari_installment` TO `share_safari_lead_installment`;
ALTER TABLE `share_safari_lead_installment` ADD `installment` INT NOT NULL DEFAULT '1' AFTER `transaction_datetime`;
ALTER TABLE `share_safari_lead_installment` ADD `share_safari_lead_id` INT NOT NULL AFTER `id`;
ALTER TABLE `share_safari_lead` CHANGE `notes` `notes` INT NULL DEFAULT NULL;
ALTER TABLE `share_safari_lead` CHANGE `name` `name` VARCHAR(255) NOT NULL, CHANGE `email` `email` VARCHAR(255) NOT NULL, CHANGE `phone` `phone` VARCHAR(255) NOT NULL;

ALTER TABLE `share_safari_lead` CHANGE `payment_receipt` `payment_receipt` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `share_safari_lead` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `phone` `phone` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

ALTER TABLE `share_safari_lead_installment` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

ALTER TABLE `transaction` CHANGE `lead_partner_quotes_id` `lead_partner_quotes_id` INT NULL DEFAULT NULL, CHANGE `lead_partner_quote_installments_id` `lead_partner_quote_installments_id` INT NULL DEFAULT NULL, CHANGE `lead_partner_id` `lead_partner_id` INT NULL DEFAULT NULL;

ALTER TABLE `transaction` CHANGE `payment_gateway_tracking_id` `payment_gateway_tracking_id` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `bank_reference_no` `bank_reference_no` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

ALTER TABLE `transaction_events` CHANGE `lead_partner_quote_id` `lead_partner_quote_id` INT NULL DEFAULT NULL;

ALTER TABLE `share_safari_lead_installment` ADD `is_payment_received` BOOLEAN NOT NULL DEFAULT FALSE AFTER `installment`;

ALTER TABLE `booking` CHANGE `lead_partner_quotes_id` `lead_partner_quotes_id` INT NULL DEFAULT NULL;
ALTER TABLE `booking` CHANGE `lead_partner_id` `lead_partner_id` INT NULL DEFAULT NULL;
ALTER TABLE `transaction` CHANGE `source` `source` TINYINT NOT NULL DEFAULT '1' COMMENT '1=>Lead,2=>share safari';
ALTER TABLE `booking` ADD `source` TINYINT NOT NULL DEFAULT '1' COMMENT '\'1=>Lead,2=>share safari\';' AFTER `id`;

ALTER TABLE `booking` ADD `share_shafari_lead_id` INT NULL DEFAULT NULL AFTER `source`, ADD `share_shafari_id` INT NULL DEFAULT NULL AFTER `share_shafari_lead_id`, ADD `share_shafari_version` INT NULL DEFAULT NULL AFTER `share_shafari_id`;

ALTER TABLE `booking` ADD `share_safari_lead_installment_id` INT NULL DEFAULT NULL AFTER `share_shafari_lead_id`;
ALTER TABLE `transaction` CHANGE `addtional_data` `addtional_data` LONGTEXT NULL DEFAULT NULL;

ALTER TABLE `transaction` ADD `share_shafari_lead_id` INT NULL DEFAULT NULL AFTER `source`, ADD `share_safari_lead_installment_id` INT NULL DEFAULT NULL AFTER `share_shafari_lead_id`, ADD `share_shafari_id` INT NULL DEFAULT NULL AFTER `share_safari_lead_installment_id`, ADD `share_shafari_version` INT NULL DEFAULT NULL AFTER `share_shafari_id`;

ALTER TABLE `booking` CHANGE `share_shafari_version` `share_safari_version` INT NULL DEFAULT NULL;
ALTER TABLE `transaction` CHANGE `share_shafari_id` `share_safari_id` INT NULL DEFAULT NULL;
ALTER TABLE `transaction` CHANGE `share_shafari_lead_id` `share_safari_lead_id` INT NULL DEFAULT NULL;
ALTER TABLE `transaction` CHANGE `share_shafari_version` `share_safari_version` INT NULL DEFAULT NULL;
ALTER TABLE `booking` CHANGE `share_shafari_lead_id` `share_safari_lead_id` INT NULL DEFAULT NULL, CHANGE `share_shafari_id` `share_safari_id` INT NULL DEFAULT NULL;
ALTER TABLE `share_safari_lead_installment` ADD `payment_receipt` VARCHAR(255) NULL DEFAULT NULL AFTER `is_payment_received`;
ALTER TABLE `chat` CHANGE `chat_type` `chat_type` TINYINT NOT NULL DEFAULT '1' COMMENT '1=>direct chat, 2 =>lead chat,3=>share safari chat';

ALTER TABLE `share_safari` ADD `booked_seat` INT NOT NULL DEFAULT '0' AFTER `share_seat`;
