<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserSchema",
 *     type="object",
 *
 *     @OA\Property(property="username", type="string", example="test@gmail.com"),
 *     @OA\Property(property="name", type="string", example="Mahaveer Singh"),
 *     @OA\Property(property="email", type="string", example="test@gmail.com"),
 *     @OA\Property(property="is_support_user", type="integer", example=0),
 *     @OA\Property(property="is_safari_operator", type="boolean", example=false),
 *     @OA\Property(property="is_account_manager", type="integer", example=0),
 *     @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
 *     @OA\Property(property="is_developer", type="integer", example=0),
 *     @OA\Property(property="google_avatar_image", type="string", example="3096_google_avatar.jpg"),
 *     @OA\Property(property="user_handle", type="string", example="mahaveer-singh"),
 *     @OA\Property(property="gender", type="integer", example=1),
 *     @OA\Property(property="account_type", type="integer", example=1),
 *     @OA\Property(property="gender_privacy", type="integer", example=1),
 *     @OA\Property(property="email_privacy", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=10),
 *     @OA\Property(property="profile_display_image", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/user/profile/3096_google_avatar.jpg"),
 *     @OA\Property(property="cover_display_image", type="string", nullable=true, example=null),
 *     @OA\Property(property="display_name", type="string", example="Mahaveer Singh"),
 *     @OA\Property(property="is_followed", type="boolean", example=false),
 *     @OA\Property(property="user_activity_count", type="integer", example=0),
 *     @OA\Property(property="operator_slug", type="string", example=""),
 *     @OA\Property(property="user_followers_count", type="integer", example=0),
 *     @OA\Property(property="user_followings_count", type="integer", example=1),
 *     @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=false)
 * )
 */
class UserSchema {}
