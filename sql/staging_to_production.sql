CREATE TABLE `master_notification_template` (
  `id` int NOT NULL,
  `title` varchar(512) NOT NULL,
  `message` text NOT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `master_notification_template` (`id`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Joined Safari', 'New member alert : {{var1}} has joined your {{var2}} Visit the interested member section to review and connect for your trip planning.', 1, 1735733224, 30, 1735733224, 30),
(2, 'New Comment', 'A new comment has been posted in the {{var1}} Join the conversation to discuss and finalize the shared safari plans.', 1, 1735794886, 30, 1735794886, 30),
(3, 'New Comment', '{{var1}} new comment {{var2}}', 1, 1735796316, 30, 1735796316, 30),
(4, 'New Follower', '{{var1}} is now following you!', 1, 1735796519, 30, 1735796519, 30),
(5, 'Package Intrest', '{{var1}} has shown interest in your package.', 1, 1735806508, 30, 1735806508, 30),
(6, 'Quote Request', 'You have a new quote request!', 1, 1735806532, 30, 1735806532, 30),
(7, 'New Review', "You\'ve received a new review!", 1, 1735806556, 30, 1735806556, 30);


ALTER TABLE `master_notification_template`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `master_notification_template`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;



ALTER TABLE `firebase_notification_log` ADD `master_notification_template_id` INT NOT NULL AFTER `id`;
ALTER TABLE `firebase_notification_log` ADD `send_datetime` DATETIME NULL AFTER `status`;

ALTER TABLE `user_posts` ADD `v_size` INT NULL DEFAULT NULL AFTER `description`, ADD `v_duration` INT NULL DEFAULT NULL AFTER `v_size`;
