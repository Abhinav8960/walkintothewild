ALTER TABLE `call_log` ADD `is_dedicated` BOOLEAN NOT NULL DEFAULT FALSE AFTER `service`;

ALTER TABLE `safari_operator` ADD `has_direct_call` BOOLEAN NOT NULL DEFAULT FALSE AFTER `logo`, ADD `direct_call_no` INT NULL DEFAULT NULL AFTER `has_direct_call`;
