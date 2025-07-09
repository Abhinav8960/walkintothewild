ALTER TABLE package_version ADD cost_per_two_person INT NULL DEFAULT NULL AFTER cost_per_person;


ALTER TABLE package_version ADD gallery_json JSON NULL DEFAULT NULL AFTER max_booking_date;



ALTER TABLE package_version ADD partner_gallery_id INT NULL DEFAULT NULL AFTER max_booking_date;



ALTER TABLE package_version CHANGE cost_per_two_person cost_per_two_person DECIMAL(10,2) NULL DEFAULT NULL;



ALTER TABLE package ADD partner_gallery_id INT NULL DEFAULT NULL AFTER max_booking_date, ADD gallery_json JSON NULL DEFAULT NULL AFTER partner_gallery_id;
ALTER TABLE package ADD cost_per_two_person DECIMAL(10,2) NULL DEFAULT NULL AFTER cost_per_person;