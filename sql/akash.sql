ALTER TABLE `share_safari` ADD `share_safari_title` VARCHAR(50) NOT NULL AFTER `id`;
ALTER TABLE `share_safari` ADD `cut_off_date` DATE NULL AFTER `end_date`;

UPDATE meta_stay_category
SET status = -1
WHERE id=2;

-- 3-sep-2024

ALTER TABLE `article_comment` DROP `is_approved`;
ALTER TABLE `article_comment`
  DROP `ip_address`,
  DROP `device_type`,
  DROP `browser`,
  DROP `os`;

ALTER TABLE `article_comment_report`
  DROP `user_device`,
  DROP `user_agent`,
  DROP `user_platform`,
  DROP `user_browser`,
  DROP `user_ip_address`;

ALTER TABLE `package_comment`
  DROP `user_device`,
  DROP `user_agent`,
  DROP `user_platform`,
  DROP `user_browser`,
  DROP `user_ip_address`;

  ALTER TABLE `package_comment_report`
  DROP `user_device`,
  DROP `user_agent`,
  DROP `user_platform`,
  DROP `user_browser`,
  DROP `user_ip_address`;

  ALTER TABLE `share_safari_comment`
  DROP `user_device`,
  DROP `user_agent`,
  DROP `user_platform`,
  DROP `user_browser`,
  DROP `user_ip_address`;

  ALTER TABLE `share_safari_comment_report`
  DROP `user_device`,
  DROP `user_agent`,
  DROP `user_platform`,
  DROP `user_browser`,
  DROP `user_ip_address`;


  -- 4-Sep-2024

  ALTER TABLE `article_comment` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;
  ALTER TABLE `package_comment` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;
  ALTER TABLE `share_safari_comment` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;
  ALTER TABLE `safari_operator_rating` ADD `is_deleted` INT NULL DEFAULT '0' AFTER `flaged`;

  -- ALTER TABLE `article` ADD `user_status` INT NULL DEFAULT '0' AFTER `sequence`;


  -- 11-sep-2024

  ALTER TABLE `share_safari` ADD `delete_reason_id` INT NULL AFTER `updated_by`;

-- this query one by one
  UPDATE share_safari SET status = 0 where status = 2;
  UPDATE share_safari SET status = 2 where status = 3;

  -- 12-sep-2024


  UPDATE master_package_feature SET status = 0 WHERE status = 2;
UPDATE master_package_include SET status = 0 WHERE status = 2;
UPDATE package SET status = 0 WHERE status = 2;
UPDATE package_comment SET status = 0 WHERE status = 2;
UPDATE package_comment_report SET status = 0 WHERE status = 2;
UPDATE package_day SET status = 0 WHERE status = 2;
UPDATE package_enquiry SET status = 0 WHERE status = 2;
UPDATE package_faq SET status = 0 WHERE status = 2;
UPDATE package_feature SET status = 0 WHERE status = 2;
UPDATE package_gallery SET status = 0 WHERE status = 2;
UPDATE package_included SET status = 0 WHERE status = 2;
UPDATE package_quote SET status = 0 WHERE status = 2;
UPDATE package_safari_park SET status = 0 WHERE status = 2;

ALTER TABLE `package` ADD `delete_reason_id` INT NULL AFTER `popular_package`, ADD `delete_reason` TEXT NULL AFTER `delete_reason_id`;

-- 14-sep-2024




UPDATE safari_park
SET status = 0
WHERE status = 2;


UPDATE safari_park_accomodation
SET status = 0
WHERE status = 2;

UPDATE safari_parks_animal
SET status = 0
WHERE status = 2;

UPDATE safari_park_flora_fauna
SET status = 0
WHERE status = 2;

UPDATE safari_park_gallery
SET status = 0
WHERE status = 2;

UPDATE safari_park_month
SET status = 0
WHERE status = 2;

UPDATE safari_park_rating
SET status = 0
WHERE status = 2;

UPDATE safari_park_session
SET status = 0
WHERE status = 2;

UPDATE safari_parks_vehicle
SET status = 0
WHERE status = 2;

UPDATE safari_park_bonus_experience
SET status = 0
WHERE status = 2;


-- 13-sep-2024


UPDATE share_safari_included
SET status = 0
WHERE status = 2;

UPDATE share_safari_gallery
SET status = 0
WHERE status = 2;

UPDATE share_safari_faq
SET status = 0
WHERE status = 2;

UPDATE share_safari_day
SET status = 0
WHERE status = 2;



UPDATE master_railway_station
SET status = 0
WHERE status = 2;
UPDATE master_airport
SET status = 0
WHERE status = 2;
UPDATE master_bonus_experience
SET status = 0
WHERE status = 2;
UPDATE master_animal
SET status = 0
WHERE status = 2;
UPDATE master_city
SET status = 0
WHERE status = 2;
UPDATE master_operator_category
SET status = 0
WHERE status = 2;
UPDATE master_suggestion_category	
SET status = 0
WHERE status = 2;
UPDATE master_review_flag
SET status = 0
WHERE status = 2;
UPDATE master_share_safari_reason
SET status = 0
WHERE status = 2;
UPDATE master_mail_template	
SET status = 0
WHERE status = 2;


UPDATE master_frontend_banner
SET status = 0
WHERE status = 2;
UPDATE banner
SET status = 0
WHERE status = 2;
UPDATE 	content_management
SET status = 0
WHERE status = 2;
UPDATE faqs
SET status = 0
WHERE status = 2;
UPDATE faq_category
SET status = 0
WHERE status = 2;
UPDATE master_faq
SET status = 0
WHERE status = 2;
UPDATE master_article_tag	
SET status = 0
WHERE status = 2;
UPDATE master_article_topic
SET status = 0
WHERE status = 2;
UPDATE 	article_tag
SET status = 0
WHERE status = 2;
UPDATE article_topic	
SET status = 0
WHERE status = 2;


	