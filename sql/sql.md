ALTER TABLE partner_registration CHANGE is_legal_entity_phone_verified is_phone_no_verified TINYINT NULL DEFAULT '0';


<!-- safari Park Field Added on 18 June -->
ALTER TABLE `safari_park` ADD `notes` TEXT NULL DEFAULT NULL AFTER `safri_cost_note`;