ALTER DATABASE wildwalks CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
ALTER TABLE firebase_notification_log CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE firebase_notification_log MODIFY message TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE chat MODIFY last_message TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;