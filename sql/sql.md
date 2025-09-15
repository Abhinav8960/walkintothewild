ALTER TABLE `call_log` ADD `is_dedicated` BOOLEAN NOT NULL DEFAULT FALSE AFTER `service`;

ALTER TABLE `safari_operator` ADD `has_direct_call` BOOLEAN NOT NULL DEFAULT FALSE AFTER `logo`, ADD `direct_call_no` INT NULL DEFAULT NULL AFTER `has_direct_call`;
ALTER TABLE `call_log_numbers_details` CHANGE `ctc` `ctc` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `call_log_numbers_details` CHANGE `node_id` `node_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;