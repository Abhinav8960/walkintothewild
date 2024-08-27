ALTER TABLE `share_safari` ADD `share_safari_title` VARCHAR(50) NOT NULL AFTER `id`;
ALTER TABLE `share_safari` ADD `cut_off_date` DATE NULL AFTER `end_date`;

UPDATE meta_stay_category
SET status = -1
WHERE id=2;