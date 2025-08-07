ALTER TABLE partner_gallery ADD version INT NULL DEFAULT NULL AFTER id;
ALTER TABLE partner_gallery
  DROP user_id,
  DROP is_live,
  DROP in_draft,
  DROP is_approved,
  DROP send_for_approval;
ALTER TABLE partner_gallery ADD edit_status INT NOT NULL DEFAULT '0' COMMENT '0 => Nothing ,\r\n1 => \'Edit Mode\',\r\n2=>\'Send For Approval\',' AFTER gallery_images_count;
ALTER TABLE partner_gallery CHANGE status listing_status INT NULL DEFAULT '1' COMMENT '10 => \'created\',\r\n1=>\'Active\',\r\n0=>\'Inactive\',\r\n-1 =>\'Delete\'';
ALTER TABLE partner_gallery ADD send_for_approval_time DATETIME NULL DEFAULT NULL AFTER listing_status;
ALTER TABLE partner_gallery_version
  DROP user_id,
  DROP live_gallery_images_count,
  DROP gallery_images_count,
  DROP in_draft,
  DROP is_approved,
  DROP send_for_approval,
  DROP is_live;

ALTER TABLE partner_gallery_version ADD send_for_approval_time DATETIME NULL DEFAULT NULL AFTER live_images, ADD approved_at DATETIME NULL DEFAULT NULL AFTER send_for_approval_time;
ALTER TABLE partner_gallery_version CHANGE status listing_status INT NULL DEFAULT '1' COMMENT '1 => \'Create\',\r\n2 =>\'Send For Approval\',\r\n3=>\'Approved\',\r\n-1 =>\'Terminated\'';