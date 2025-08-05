ALTER TABLE `transaction`  ADD `source` INT NOT NULL DEFAULT '1' COMMENT '1=>Lead,2=>share safari'  AFTER `id`;
RENAME TABLE `share_safari_installment` TO `share_safari_lead_installment`;
ALTER TABLE `share_safari_lead_installment` ADD `installment` INT NOT NULL DEFAULT '1' AFTER `transaction_datetime`;
ALTER TABLE `share_safari_lead_installment` ADD `share_safari_lead_id` INT NOT NULL AFTER `id`;
ALTER TABLE `share_safari_lead` CHANGE `notes` `notes` INT NULL DEFAULT NULL;
ALTER TABLE `share_safari_lead` CHANGE `name` `name` VARCHAR(255) NOT NULL, CHANGE `email` `email` VARCHAR(255) NOT NULL, CHANGE `phone` `phone` VARCHAR(255) NOT NULL;

ALTER TABLE `share_safari_lead` CHANGE `payment_receipt` `payment_receipt` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `share_safari_lead` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `phone` `phone` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

ALTER TABLE `share_safari_lead_installment` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
