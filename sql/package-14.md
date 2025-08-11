ALTER TABLE `package` CHANGE `owned_by_id` `safari_operator_id` INT NULL DEFAULT NULL;
ALTER TABLE `package` ADD `edit_status` INT NOT NULL DEFAULT '0' AFTER `editable_version`, ADD `pending_status` INT NOT NULL DEFAULT '0' AFTER `edit_status`;
ALTER TABLE `package` ADD `static_json` LONGTEXT NULL DEFAULT NULL AFTER `price_after_discount`;
ALTER TABLE `package` ADD `user_id` INT NOT NULL AFTER `safari_operator_id`;

ALTER TABLE `package_version` CHANGE `owned_by_id` `safari_operator_id` INT NULL DEFAULT NULL;
ALTER TABLE `package_version` ADD `user_id` INT NOT NULL AFTER `safari_operator_id`;
ALTER TABLE `package` ADD `gallery_version` INT NULL DEFAULT NULL AFTER `gallery_json`;
ALTER TABLE `package_version` ADD `gallery_version` INT NULL DEFAULT NULL AFTER `gallery_json`;
ALTER TABLE `package_day` ADD `gallery_version` INT NULL DEFAULT NULL AFTER `gallery_json`;

php yii package-temp/step-1;
php yii package-temp/step-2;