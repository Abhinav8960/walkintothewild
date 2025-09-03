ALTER TABLE `prod_witw`.`booking` ADD UNIQUE (`transaction_id`);

<!-- 3 Sep 2025 -->

ALTER TABLE share_safari_version ADD cancellation_reason TEXT NULL DEFAULT NULL AFTER gallery_version;