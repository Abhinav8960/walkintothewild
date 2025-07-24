ALTER TABLE `share_safari_day` ADD `partner_gallery_id` INT NULL DEFAULT NULL AFTER `day_note`, ADD `gallery_json` JSON NULL DEFAULT NULL AFTER `partner_gallery_id`;

ALTER TABLE `share_safari_faq` ADD `master_faq_id` INT NULL DEFAULT NULL AFTER `id`;