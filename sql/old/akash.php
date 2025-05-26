ALTER TABLE `share_safari` ADD `version` INT NOT NULL DEFAULT '1' AFTER `id`;
ALTER TABLE `share_safari_history` ADD `version` INT NOT NULL DEFAULT '1' AFTER `id`;
ALTER TABLE `share_safari_comment` ADD `version` INT NOT NULL DEFAULT '1' AFTER `id`;

ALTER TABLE `user_posts` ADD `version` INT NOT NULL DEFAULT '1' AFTER `id`;
ALTER TABLE `user_post_comment` ADD `version` INT NOT NULL DEFAULT '1' AFTER `id`;
ALTER TABLE `user_post_like` ADD `version` INT NOT NULL DEFAULT '1' AFTER `id`;

ALTER TABLE `package_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';
ALTER TABLE `share_safari_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';

ALTER TABLE `sighting_comment` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;
ALTER TABLE `sighting_comment_flag` ADD `reason` VARCHAR(512) NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `sighting_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';

ALTER TABLE `user_post_comment` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;
ALTER TABLE `user_post_comment_flag` ADD `reason` VARCHAR(512) NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `user_post_comment` CHANGE `is_deleted` `deleted_by` INT NULL DEFAULT '0';


php yii feed-date-time/share-safari
php yii feed-date-time/disable
php yii package-assign/package
php yii operator-removal/remove
php yii operator-removal/fixed-assign