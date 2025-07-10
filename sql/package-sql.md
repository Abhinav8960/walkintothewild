ALTER TABLE package_version ADD cost_per_two_person INT NULL DEFAULT NULL AFTER cost_per_person;


ALTER TABLE package_version ADD gallery_json JSON NULL DEFAULT NULL AFTER max_booking_date;



ALTER TABLE package_version ADD partner_gallery_id INT NULL DEFAULT NULL AFTER max_booking_date;



ALTER TABLE package_version CHANGE cost_per_two_person cost_per_two_person DECIMAL(10,2) NULL DEFAULT NULL;



ALTER TABLE package ADD partner_gallery_id INT NULL DEFAULT NULL AFTER max_booking_date, ADD gallery_json JSON NULL DEFAULT NULL AFTER partner_gallery_id;
ALTER TABLE package ADD cost_per_two_person DECIMAL(10,2) NULL DEFAULT NULL AFTER cost_per_person;

<!-- 10 July 2025 -->
ALTER TABLE package_day ADD partner_gallery_id INT NULL DEFAULT NULL AFTER day_note, ADD gallery_json JSON NULL DEFAULT NULL AFTER partner_gallery_id;

ALTER TABLE package ADD discount_type INT NOT NULL DEFAULT '0' AFTER editable_version, ADD discount_in_percentage DECIMAL(10,2) NOT NULL DEFAULT '0' AFTER discount_type, ADD discount_in_value DECIMAL(10,2) NOT NULL DEFAULT '0' AFTER discount_in_percentage;

ALTER TABLE package_faq ADD master_faq_id INT NULL DEFAULT NULL AFTER status;