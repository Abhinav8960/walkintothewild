ALTER TABLE package_version ADD cost_per_two_person INT NULL DEFAULT NULL AFTER cost_per_person;


ALTER TABLE package_version ADD gallery_json JSON NULL DEFAULT NULL AFTER max_booking_date;



ALTER TABLE package_version ADD partner_gallery_id INT NULL DEFAULT NULL AFTER max_booking_date;



ALTER TABLE package_version CHANGE cost_per_two_person cost_per_two_person DECIMAL(10,2) NULL DEFAULT NULL;



ALTER TABLE package ADD partner_gallery_id INT NULL DEFAULT NULL AFTER max_booking_date, ADD gallery_json JSON NULL DEFAULT NULL AFTER partner_gallery_id;
ALTER TABLE package ADD cost_per_two_person DECIMAL(10,2) NULL DEFAULT NULL AFTER cost_per_person;

<!-- 10 July 2025 -->
ALTER TABLE package_day ADD partner_gallery_id INT NULL DEFAULT NULL AFTER day_note, ADD gallery_json JSON NULL DEFAULT NULL AFTER partner_gallery_id;

ALTER TABLE package ADD discount_type INT NOT NULL DEFAULT '0' AFTER editable_version, ADD discount_in_percentage DECIMAL(10,2) NOT NULL DEFAULT '0' AFTER discount_type, ADD discount_in_value DECIMAL(10,2) NOT NULL DEFAULT '0' AFTER discount_in_percentage;

ALTER TABLE package_faq ADD master_faq_id INT NULL DEFAULT NULL AFTER status;

ALTER TABLE safari_operator_faq ADD park_id INT NOT NULL AFTER safari_operator_id;

ALTER TABLE `package` ADD `price_after_discount_in_percentage` DECIMAL(10,2) NULL DEFAULT '0' AFTER `discount_in_value`, ADD `price_after_discount_in_value` DECIMAL(10,2) NULL DEFAULT '0' AFTER `price_after_discount_in_percentage`;

ALTER TABLE `package` CHANGE `price_after_discount_in_percentage` `price_after_discount_in_percentage` DECIMAL(10,2) NOT NULL DEFAULT '0.00';

ALTER TABLE `package` CHANGE `price_after_discount_in_value` `price_after_discount_in_value` DECIMAL(10,2) NOT NULL DEFAULT '0.00';

ALTER TABLE `package` DROP `price_after_discount_in_value`;
ALTER TABLE `package` CHANGE `price_after_discount_in_percentage` `price_after_discount` DECIMAL(10,2) NOT NULL DEFAULT '0.00';

<!-- 14 July 2025 -->
ALTER TABLE `partner_gallery` ADD `park_id` INT NULL DEFAULT NULL AFTER `safari_operator_id`;

ALTER TABLE `partner_gallery` ADD `in_draft` INT NULL DEFAULT '0' AFTER `live_images`, ADD `is_approved` INT NULL DEFAULT '0' AFTER `in_draft`, ADD `send_for_approval` INT NULL DEFAULT '0' AFTER `is_approved`;

ALTER TABLE `partner_gallery_version` ADD `in_draft` INT NULL DEFAULT '0' AFTER `live_images`, ADD `is_approved` INT NULL DEFAULT '0' AFTER `in_draft`, ADD `send_for_approval` INT NULL DEFAULT '0' AFTER `is_approved`;

ALTER TABLE partner_gallery ADD is_live TINYINT NOT NULL DEFAULT '0' AFTER can_send_for_approval;

ALTER TABLE `partner_gallery` ADD `live_gallery_images_count` INT NOT NULL DEFAULT '0' AFTER `live_images`, ADD `gallery_images_count` INT NOT NULL DEFAULT '0' AFTER `live_gallery_images_count`;

ALTER TABLE `partner_gallery_version` ADD `live_gallery_images_count` INT NOT NULL DEFAULT '0' AFTER `live_images`, ADD `gallery_images_count` INT NOT NULL DEFAULT '0' AFTER `live_gallery_images_count`;