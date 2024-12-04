ALTER TABLE `safari_operator_park` ADD `show_in_front` TINYINT NULL DEFAULT '0' AFTER `park_id`;

-- 22-Nov-2024
INSERT INTO `meta_stay_category` (`id`, `title`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'No Required', '1', 1715926433, 1, 1715926433, 1);

-- 4-Dec-2024
ALTER TABLE `user` ADD `pop_up_message` VARCHAR(512) NULL AFTER `user_flaged`;