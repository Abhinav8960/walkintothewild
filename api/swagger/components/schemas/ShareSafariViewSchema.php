<?php

namespace api\swagger\components\schemas;



use OpenApi\Annotations as OA;

/**
 *     @OA\Schema(
 *         schema="ShareSafariViewSchema",
 *         type="object",
 *         @OA\Property(property="share_safari_title", type="string", example="Catamaran"),
 *         @OA\Property(property="slug", type="string", example="bhitarkanika-by-catamaran"),
 *         @OA\Property(property="no_of_safari", type="integer", example=1),
 *         @OA\Property(property="start_date", type="string", format="date", example="2026-01-23"),
 *         @OA\Property(property="end_date", type="string", format="date", example="2026-01-26"),
 *         @OA\Property(property="cut_off_date", type="string", nullable=true, example= "2025-11-14"),
 *         @OA\Property(property="types", type="string", example="Fixed Departure"),
 *         @OA\Property(property="organized_by_name", type="string", example="Vivek Bharti"),
 *         @OA\Property(property="organized_by_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/2390_profile_1762259111.jpg"),
 *         @OA\Property(property="organized_slug", type="string", example="vivek-bharti_2"),
 *         @OA\Property(property="shared_image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/share_safari/2510/323_1759905900.jpg"),
 *         @OA\Property(property="seat_full_status", type="boolean", example=false),
 *         @OA\Property(property="park_title", type="string", example="Dudhwa Tiger Reserve"),
 *         @OA\Property(property="park_slug", type="string", example="dudhwa-tiger-reserve"),
 *         @OA\Property(property="cost_per_person", type="number", example=2000),
 *         @OA\Property(property="estimate_price_min", type="number", example=28000),
 *         @OA\Property(property="estimate_price_max", type="number", example=100000),
 *         @OA\Property(property="breakfast_included", type="boolean", example=true),
 *         @OA\Property(property="lunch_included", type="boolean", example=true),
 *         @OA\Property(property="dinner_included", type="boolean", example=true),
 *         @OA\Property(property="meal_not_included", type="boolean", example=true),
 *         @OA\Property(property="meals_label", type="string", example="Breakfast, Lunch, Dinner"),
 *         @OA\Property(property="share_safari_inclusion", type="string", example="Inclusion"),
 *         @OA\Property(property="share_safari_exclusion", type="string", example="Exclusion"),
 *         @OA\Property(property="getting_there", type="string", example="Getting There"),
 *         @OA\Property(property="safari_plan", type="string", example="Safari Plan"),
 *         @OA\Property(property="share_safari_agenda", type="string", example="Photography"),
 *         @OA\Property(property="share_safari_agenda_id", type="integer", example=1),
 *         @OA\Property(property="stay_category_display", type="string", example="Economical"),
 *         @OA\Property(property="stay_category_id", type="integer", example=3),
 * 
 *         @OA\Property(
 *             property="faqs",
 *             type="array",
 *             @OA\Items(
 *                ref="#/components/schemas/ShareSafariFaqItem"
 *             )
 *         ),
 *         @OA\Property(
 *             property="parks",
 *             type="array",
 *             @OA\Items(
 *                ref="#/components/schemas/ShareSafariParkItem"
 *             )
 *         ),
 *         @OA\Property(
 *             property="includeds",
 *             type="array",
 *             @OA\Items(
 *                ref="#/components/schemas/MasterShareSafariWithIncluded"
 *             )
 *         ),
 *         @OA\Property(
 *             property="share_safari_days",
 *             type="array",
 *             @OA\Items(
 *                ref="#/components/schemas/ShareSafariDayItem"
 *             )
 *         ),
 *         @OA\Property(property="partner_gallery_id", type="integer", example=1),
 *         @OA\Property(
 *            property="gallery_json",
 *            type="string",
 *            example=""
 *          ),
 *         @OA\Property(property="gallery_version", type="number", example=1),
 * 
 *         @OA\Property(property="have_you_joined", type="boolean", example=false),
 *         @OA\Property(property="is_wishlist", type="boolean", example=false),
 *         @OA\Property(property="is_followed", type="boolean", example=false),
 *         @OA\Property(property="interseted_user_count", type="integer", example=3),
 *         @OA\Property(property="resource_uri", type="string", example="https://staging.../sharedsafari/bhitarkanika-by-catamaran"),
 *         @OA\Property(property="can_comment", type="boolean", example=true),
 *         @OA\Property(property="can_reply", type="boolean", example=true),
 *         @OA\Property(property="total_seat", type="integer", example=4),
 *         @OA\Property(property="share_seat", type="integer", example=3),
 *         @OA\Property(
 *            property="partner",
 *            ref="#/components/schemas/PartnerSchema"
 *         ),
 *
 *         @OA\Property(
 *                property="interested_users",
 *                type="array",
 *                @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="username", type="string", example="aayushsaini9999@gmail.com"),
 *                 @OA\Property(property="name", type="string", example="Aayush Saini"),
 *                 @OA\Property(property="email", type="string", example="aayushsaini9999@gmail.com"),
 *                 @OA\Property(property="is_support_user", type="integer", example=1),
 *                 @OA\Property(property="is_safari_operator", type="boolean", example=false),
 *                 @OA\Property(property="is_account_manager", type="integer", example=1),
 *                 @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
 *                 @OA\Property(property="is_developer", type="integer", example=1),
 *                 @OA\Property(property="google_avatar_image", type="string", example="32_google_avatar.jpg"),
 *                 @OA\Property(property="user_handle", type="string", example="aayushsaini"),
 *                 @OA\Property(property="gender", type="string", nullable=true, example=null),
 *                 @OA\Property(property="account_type", type="integer", example=1),
 *                 @OA\Property(property="gender_privacy", type="integer", example=1),
 *                 @OA\Property(property="email_privacy", type="integer", example=1),
 *                 @OA\Property(property="status", type="integer", example=10),
 *                 @OA\Property(property="profile_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/32_profile_1748334745.jpg"),
 *                 @OA\Property(property="cover_display_image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/user/profile/32_cover_1748334732.jpg"),
 *                 @OA\Property(property="display_name", type="string", example="Aayush Saini"),
 *                 @OA\Property(property="is_followed", type="boolean", example=false),
 *                 @OA\Property(property="user_activity_count", type="integer", example=4),
 *                 @OA\Property(property="operator_slug", type="string", example=""),
 *                 @OA\Property(property="user_followers_count", type="integer", example=3),
 *                 @OA\Property(property="user_followings_count", type="integer", example=2),
 *                 @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=false),
 *                 @OA\Property(property="joined_at", type="integer", example=1762144211)
 *                         )
 *                     ),
 *
 *         @OA\Property(
 *         property="urls",
 *         type="object",
 *             @OA\Property(property="intrested_users", type="string", example="https://staging-api.walkintothewild.in/.../intrested-user"),
 *             @OA\Property(property="comments", type="string", example="https://staging-api.walkintothewild.in/.../comment-view")
 *         ),
 *
 *         @OA\Property(property="comments_count", type="integer", example=12),
 *         @OA\Property(property="witw_average_rating", type="integer", example=0),
 *         @OA\Property(property="witw_review_count", type="integer", example=0),
 *         @OA\Property(property="is_safari_operator", type="boolean", example=false),
 *         @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
 *         @OA\Property(property="status", type="integer", example=0)
 *   )
 * )
 */
class ShareSafariViewSchema {}
