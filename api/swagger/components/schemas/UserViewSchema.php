<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserViewSchema",
 *     type="object",
 * 
 *                 @OA\Property(property="username", type="string", example="akashprajapatiak05@gmail.com"),
 *                 @OA\Property(property="name", type="string", example="Akash Kumar"),
 *                 @OA\Property(property="mobile_no", type="string", example="9315723354"),
 *                 @OA\Property(property="is_mobile_no_verified", type="boolean", example=true),
 *                 @OA\Property(property="mobile_no_verified_at", type="integer", example=1756205685),
 *                 @OA\Property(property="email", type="string", example="akashprajapatiak05@gmail.com"),
 *                 @OA\Property(property="is_support_user", type="integer", example=1),
 *                 @OA\Property(property="is_safari_operator", type="boolean", example=false),
 *                 @OA\Property(property="is_account_manager", type="integer", example=1),
 *                 @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
 *                 @OA\Property(property="is_developer", type="integer", example=1),
 *                 @OA\Property(property="google_avatar_image", type="string", example="33_google_avatar.jpg"),
 *                 @OA\Property(property="user_handle", type="string", example="akash_kumar_2"),
 *                 @OA\Property(property="facebook_url", type="string", example=""),
 *                 @OA\Property(property="whatsapp_url", type="string", nullable=true, example=null),
 *                 @OA\Property(property="x_url", type="string", example=""),
 *                 @OA\Property(property="insta_url", type="string", example=""),
 *                 @OA\Property(property="website_url", type="string", example=""),
 *                 @OA\Property(property="youtube_url", type="string", example=""),
 *                 @OA\Property(property="about", type="string", example=""),
 *                 @OA\Property(property="user_bio", type="string", example="I am writer"),
 *                 @OA\Property(property="date_of_birth", type="string", format="date", example="2000-11-07"),
 *                 @OA\Property(property="gender", type="integer", example=1),
 *                 @OA\Property(property="account_type", type="integer", example=1),
 *                 @OA\Property(property="gender_privacy", type="integer", example=1),
 *                 @OA\Property(property="email_privacy", type="integer", example=1),
 *                 @OA\Property(property="user_flaged", type="string", nullable=true, example=null),
 *                 @OA\Property(property="pop_up_message", type="string", example=""),
 *                 @OA\Property(property="status", type="integer", example=10),
 *                 @OA\Property(property="profile_display_image", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/user/profile/33_profile_1751555645.jpg"),
 *                 @OA\Property(property="cover_display_image", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/user/profile/33_cover_1751555705.jpg"),
 *                 @OA\Property(property="display_name", type="string", example="Akash Kumar"),
 *                 @OA\Property(property="is_followed", type="boolean", example=false),
 *                 @OA\Property(property="user_activity_count", type="integer", example=0),
 *                 @OA\Property(property="operator_slug", type="string", example=""),
 *                 @OA\Property(property="user_followers_count", type="integer", example=0),
 *                 @OA\Property(property="user_followings_count", type="integer", example=1),
 *                 @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=false),
 *                 @OA\Property(property="organized_safari_count", type="integer", example=0),
 *                 @OA\Property(property="joined_safari_count", type="integer", example=0),
 *                 @OA\Property(
 *                     property="park_visited",
 *                     type="array",
 *                     @OA\Items(type="string"),
 *                     example={}
 *                 ),
 *                 @OA\Property(
 *                     property="operator_type",
 *                     type="object",
 *                     @OA\Property(property="status", type="integer", example=0)
 *                 ),
 *                 @OA\Property(property="operator_status", type="integer", example=0),
 *                 @OA\Property(
 *                     property="urls",
 *                     type="object",
 *                     @OA\Property(property="followers_list", type="string", example="http://api.walkintothewild.io/profile/akash_kumar_2/followers-list"),
 *                     @OA\Property(property="followings_list", type="string", example="http://api.walkintothewild.io/profile/akash_kumar_2/followings-list")
 *                 ),
 *                 @OA\Property(property="is_mobile_verification_mandatory", type="boolean", example=false)
 *             )
 *         )
 *
 */
class UserViewSchema {}
