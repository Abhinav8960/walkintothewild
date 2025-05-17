<!-- 17 May -->
ALTER TABLE `sighting` ADD `show_in_front` INT NULL DEFAULT '0' AFTER `delete_reason`;

<!-- 16 may -->
ALTER TABLE `chat_message` ADD `is_quotation_message` BOOLEAN NOT NULL DEFAULT FALSE AFTER `message`, ADD `quotation_id` INT NULL DEFAULT NULL AFTER `is_quotation_message`, ADD `is_quotation_active` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotation_id`;
ALTER TABLE `user` ADD `is_mobile_no_verified` BOOLEAN NOT NULL DEFAULT FALSE AFTER `mobile_no`;
<!-- 14 may -->
ALTER TABLE `sighting` CHANGE `post_datetime` `post_datetime` DATE NULL DEFAULT NULL;