Take Backup For production and staging both


1. run command php yii data-copy/package-table-copy
2. run sql from leads.md
3. run sql from master_notification_template.md
4. run sql from moderation.md // only if you need moderation table on server
5. run sql from sighting_comment_flag.php
6. run sql from user_post_comment_flag.md
7. run sql from site_api_request.md
8. run sql from user_posts_history.md
9. run  sql from safari_park_follower
10. run  sql from master_sms_template.md
11. run  sql from sms_log.md
    
   
12. Run These Queries

TRUNCATE package;
TRUNCATE package_comment;
TRUNCATE package_comment_report;
TRUNCATE package_day;
TRUNCATE package_enquiry;
TRUNCATE package_faq;
TRUNCATE package_feature;
TRUNCATE package_gallery;
TRUNCATE package_included;
TRUNCATE package_quote;
TRUNCATE package_safari_park;

10.  Read file stegaing_to_production, and find "prod_witw" and replace with your database name,and run all queries, 

11. Run Command ------------  
php yii package-to-production/prepare-data



12.TRUNCATE feeds;

13.Run Command ------------  
php yii data-copy/safari
php yii data-copy/package
php yii feed-date-time/share-safari
php yii feed-date-time/disable
php yii package-assign/package
php yii operator-removal/remove
php yii operator-removal/fixed-assign
php yii  package-assign/approval-time


14. run query below -------------
DROP TABLE `pp_package`, `pp_package_comment`, `pp_package_comment_report`, `pp_package_day`, `pp_package_enquiry`, `pp_package_faq`, `pp_package_feature`, `pp_package_gallery`, `pp_package_included`, `pp_package_quote`, `pp_package_safari_park`;



