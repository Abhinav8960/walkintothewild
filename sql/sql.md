ALTER TABLE `prod_witw`.`booking` ADD UNIQUE (`transaction_id`);

<!-- 3 Sep 2025 -->

ALTER TABLE share_safari_version ADD cancellation_reason TEXT NULL DEFAULT NULL AFTER gallery_version;

INSERT INTO master_mail_template (id, code, name, path, status, created_at, created_by, updated_at, updated_by) VALUES (NULL, 'OSFA', 'Send For Approval', 'sendforapproval-html', '1', NULL, NULL, '1716971669', '1');