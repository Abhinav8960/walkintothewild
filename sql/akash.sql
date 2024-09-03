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