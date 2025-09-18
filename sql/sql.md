ALTER TABLE `call_log` ADD `is_dedicated` BOOLEAN NOT NULL DEFAULT FALSE AFTER `service`;

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'FDBO', 'share safari booked for operator', 'payment_received_against_fixed_departure_for_operator-html', '1', NULL, NULL, '1716971669', '1');

INSERT INTO `master_mail_template` (`id`, `code`, `name`, `path`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (NULL, 'FDBU', 'share safari booked for User', 'payment_received_against_fixed_departure_for_user-html', '1', NULL, NULL, '1716971669', '1');