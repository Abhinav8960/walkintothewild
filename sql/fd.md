ALTER TABLE `share_safari` ADD `live_version` INT NULL DEFAULT NULL AFTER `pined_safari`, ADD `pending_for_approval_version` INT NULL DEFAULT NULL AFTER `live_version`, ADD `editable_version` INT NULL DEFAULT NULL AFTER `pending_for_approval_version`, ADD `partner_gallery_id` INT NULL DEFAULT NULL AFTER `editable_version`, ADD `gallery_json` JSON NULL DEFAULT NULL AFTER `partner_gallery_id`;


ALTER TABLE share_safari_day ADD version VARCHAR(255) NULL DEFAULT NULL AFTER share_safari_id;
ALTER TABLE share_safari_day ADD partner_gallery_id INT NULL DEFAULT NULL AFTER day_note, ADD gallery_json JSON NULL DEFAULT NULL AFTER partner_gallery_id;
ALTER TABLE share_safari_day DROP INDEX share_safari_id, ADD UNIQUE share_safari_id (share_safari_id, day, version) USING BTREE;

ALTER TABLE `share_safari_faq` ADD `master_faq_id` INT NULL DEFAULT NULL AFTER `id`;


ALTER TABLE share_safari_faq ADD version VARCHAR(255) NULL DEFAULT NULL AFTER share_safari_id;
ALTER TABLE share_safari_included ADD version VARCHAR(255) NULL DEFAULT NULL AFTER id;
ALTER TABLE share_safari_included DROP INDEX share_safari_id, ADD UNIQUE share_safari_id (share_safari_id, include_id, version) USING BTREE;
ALTER TABLE share_safari_park ADD version VARCHAR(255) NULL DEFAULT NULL AFTER id;


ALTER TABLE `share_safari` DROP `image`;
ALTER TABLE `share_safari` CHANGE `filepath` `image_filepath` VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `share_safari` DROP `share_safari_request_id`;
ALTER TABLE `share_safari` DROP `mail_sent`;
ALTER TABLE `share_safari`
  DROP `share_safari_terms_condtition`,
  DROP `privacy_policy`,
  DROP `change_policy`,
  DROP `what_you_must_carry`,
  DROP `date_change_policy`,
  DROP `refund_policy`;

ALTER TABLE `share_safari` ADD `host_partner_id` INT NULL DEFAULT NULL AFTER `host_user_id`, ADD `user_id` INT NOT NULL AFTER `host_partner_id`;

ALTER TABLE `share_safari` CHANGE `host_user_id` `host_user_id` INT NULL DEFAULT NULL;

ALTER TABLE `share_safari` DROP INDEX `host_user_id`, ADD INDEX `host_user_id` (`park_id`, `start_date`, `end_date`, `estimate_price_min`, `estimate_price_max`, `cost_per_person`, `total_seat`, `status`) USING BTREE;

