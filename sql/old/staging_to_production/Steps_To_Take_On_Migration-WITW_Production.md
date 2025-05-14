Take Backup For production and staging both


And create new table of related to packages add prefix of "pp_" in all related tables 


1 :: Read file stegaing_to_production, and find "wildwalks" and replace with your database name,insert tables names in queries, 
2 :: Add moderation Table
3 :: Add Site Api Request Table 


4 :: Run These Queries below Also rename

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
TRUNCATE package_version;
TRUNCATE TABLE feeds;

Change in the code for tables 

5 :: Run Command ------  php yii package-to-production/prepare-data


7 :: Run Console Command ----   php yii data-copy/safari
                                php yii data-copy/package


8 :: Run Command ------------  
 
php yii feed-date-time/share-safari
php yii feed-date-time/disable
php yii package-assign/package
php yii operator-removal/remove
php yii operator-removal/fixed-assign

9 :: run query below -------------
DROP TABLE `pp_package`, `pp_package_comment`, `pp_package_comment_report`, `pp_package_day`, `pp_package_enquiry`, `pp_package_faq`, `pp_package_feature`, `pp_package_gallery`, `pp_package_included`, `pp_package_quote`, `pp_package_safari_park`;



