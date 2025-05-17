<!-- 17may -->
ALTER TABLE `witw_staging_1705`.`share_safari_comment` ADD INDEX (`share_safari_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_comment` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`share_safari_comment` ADD INDEX (`parent_id`);

ALTER TABLE `witw_staging_1705`.`safari_operator_park` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`safari_operator_park` ADD INDEX (`safari_operator_id`);
ALTER TABLE `witw_staging_1705`.`safari_operator_park` ADD INDEX (`park_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_intrested` DROP INDEX `share_safari_id`, ADD INDEX `share_safari_id` (`share_safari_id`, `user_id`, `status`) USING BTREE;
ALTER TABLE `witw_staging_1705`.`share_safari` ADD INDEX (`host_user_id`, `park_id`, `start_date`, `end_date`, `estimate_price_min`, `estimate_price_max`, `cost_per_person`, `total_seat`, `status`);
ALTER TABLE `witw_staging_1705`.`package` ADD INDEX (`package_slug`, `start_date`, `end_date`, `stay_category_id`, `status`, `live_version`);
ALTER TABLE `witw_staging_1705`.`feeds` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`sighting_comment` ADD INDEX (`user_id`, `safari_operator_id`, `sighting_id`, `flaged`, `status`);
ALTER TABLE `witw_staging_1705`.`sighting` ADD INDEX (`user_id`, `safari_operator_id`, `status`, `show_in_front`);
ALTER TABLE `witw_staging_1705`.`sighting_comment_like` ADD INDEX (`user_id`, `safari_operator_id`, `sighting_comment_id`, `status`);
ALTER TABLE `witw_staging_1705`.`sighting_comment_flag` ADD INDEX (`sighting_id`, `sighting_comment_id`, `user_id`, `status`);

ALTER TABLE `witw_staging_1705`.`safari_parks_animal` ADD INDEX (`safari_park_id`, `master_animal_id`);
ALTER TABLE `witw_staging_1705`.`safari_park` ADD INDEX (`show_in_filter`);
ALTER TABLE `witw_staging_1705`.`safari_park` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`safari_park` ADD INDEX (`sequence`);
ALTER TABLE `witw_staging_1705`.`safari_park` ADD INDEX (`is_published`);
ALTER TABLE `witw_staging_1705`.`safari_park` ADD INDEX (`is_shared_safari`);
ALTER TABLE `witw_staging_1705`.`safari_park_accomodation` ADD INDEX (`safari_park_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_accomodation` ADD INDEX (`master_accomodation_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_bonus_experience` ADD INDEX (`safari_park_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_bonus_experience` ADD INDEX (`master_bonus_experience_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_flora_fauna` ADD INDEX (`safari_park_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_flora_fauna` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`safari_park_month` ADD INDEX (`safari_park_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_month` ADD INDEX (`month_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_month` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`safari_park_session` ADD INDEX (`safari_park_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_session` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`safari_park_session` ADD INDEX (`session_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_trip_slot` ADD INDEX (`safari_park_id`);
ALTER TABLE `witw_staging_1705`.`safari_park_trip_slot` ADD INDEX (`status`);


ALTER TABLE `witw_staging_1705`.`safari_suggestions` DROP INDEX `park_id`, ADD INDEX `park_id` (`park_id`) USING BTREE;
ALTER TABLE `witw_staging_1705`.`safari_suggestions` ADD INDEX (`is_approved`);
ALTER TABLE `witw_staging_1705`.`safari_suggestions` ADD INDEX (`status`);ALTER TABLE `witw_staging_1705`.`safari_suggestions` ADD INDEX (`status`);
ALTER TABLE `witw_staging_1705`.`share_safari_comment` ADD INDEX (`park_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_comment` ADD INDEX (`user_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_comment` ADD INDEX (`safari_operator_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_included` ADD INDEX (`status`);

ALTER TABLE `witw_staging_1705`.`share_safari_park` ADD INDEX (`share_safari_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_park` ADD INDEX (`park_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_park` ADD INDEX (`status`);

ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`share_safari_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`park_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`request_token`);
ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`share_safari_comment_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`user_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`host_user_id`);
ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`is_filled`);
ALTER TABLE `witw_staging_1705`.`share_safari_request_contact` ADD INDEX (`status`);


ALTER TABLE `witw_staging_1705`.`chat` ADD INDEX (`lead_id`);
ALTER TABLE `witw_staging_1705`.`chat` ADD INDEX (`user_id`);
ALTER TABLE `witw_staging_1705`.`chat` ADD INDEX (`recipient_user_id`);
ALTER TABLE `witw_staging_1705`.`chat` ADD INDEX (`chat_type`);
ALTER TABLE `witw_staging_1705`.`chat` ADD INDEX (`park_id`);
ALTER TABLE `witw_staging_1705`.`chat` ADD INDEX (`quote_id`);
ALTER TABLE `witw_staging_1705`.`chat` ADD INDEX (`status`);


ALTER TABLE `witw_staging_1705`.`chat` DROP INDEX `chat_hash_2`, ADD INDEX `chat_hash_2` (`chat_hash`, `user_id`, `recipient_user_id`) USING BTREE;
ALTER TABLE `witw_staging_1705`.`chat_message` ADD INDEX (`chat_id`);

<!-- 16 may -->
ALTER TABLE `chat_message` ADD `is_quotation_message` BOOLEAN NOT NULL DEFAULT FALSE AFTER `message`, ADD `quotation_id` INT NULL DEFAULT NULL AFTER `is_quotation_message`, ADD `is_quotation_active` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotation_id`;
ALTER TABLE `user` ADD `is_mobile_no_verified` BOOLEAN NOT NULL DEFAULT FALSE AFTER `mobile_no`;
<!-- 14 may -->
ALTER TABLE `sighting` CHANGE `post_datetime` `post_datetime` DATE NULL DEFAULT NULL;