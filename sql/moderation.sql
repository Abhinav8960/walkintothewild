-- 19 march
ALTER TABLE `moderation_text_personal` ADD `is_personal` INT NOT NULL DEFAULT '0' AFTER `moderation_text_id`, ADD `is_link` INT NOT NULL DEFAULT '0' AFTER `is_personal`;