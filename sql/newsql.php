ALTER TABLE `sighting` ADD `comment_count` INT NULL DEFAULT '0' AFTER `v_duration`, ADD `like_count` INT NULL DEFAULT '0' AFTER `comment_count`;
ALTER TABLE `user_posts` ADD `comment_count` INT NULL DEFAULT '0' AFTER `delete_reason`, ADD `like_count` INT NULL DEFAULT '0' AFTER `comment_count`;

ALTER TABLE `partner_registration`
  DROP `state`,
  DROP `gst_number`,
  DROP `gst_upload`;
-- UPDATE `safari_operator` SET `operator_name` = 'The Eagle Safaris' WHERE `safari_operator`.`id` = 3;
-- UPDATE `safari_operator` SET `operator_name` = 'Ankit Kankane' WHERE `safari_operator`.`id` = 4;
-- UPDATE `safari_operator` SET `operator_name` = 'Shivsakti' WHERE `safari_operator`.`id` = 23;
-- UPDATE `safari_operator` SET `operator_name` = 'TravellersCo' WHERE `safari_operator`.`id` = 76;
ALTER TABLE `safari_operator` DROP `operated_park`;
