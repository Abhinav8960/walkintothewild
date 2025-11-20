<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PostDetailSchema",
 *     type="object",
 *         @OA\Property(property="id", type="integer", example=651),
 *         @OA\Property(property="version", type="integer", example=1),
 *         @OA\Property(property="user_id", type="integer", example=9832),
 *         @OA\Property(property="safari_operator_id", type="integer", nullable=true, example=null),
 *         @OA\Property(property="original_filename", type="string", example="Screenshot from 2025-11-13 12-12-52.png"),
 *         @OA\Property(property="thumbnail", type="string", nullable=true, example=null),
 *         @OA\Property(property="delete_reason", type="string", nullable=true, example=null),
 *         @OA\Property(property="created_at", type="integer", example=1757323490),
 *         @OA\Property(property="updated_at", type="integer", example=1757402093),
 *         @OA\Property(property="full_image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/post/2511/33_1763617364.png"),
 *
 *         @OA\Property(
 *             property="comments",
 *            type="array",
 *            @OA\Items(type="object",ref="#/components/schemas/PostCommentSchema")
 *         ),
 *         @OA\Property(property="is_liked", type="boolean", example=false),
 *         @OA\Property(property="liked_count", type="integer", example=1),
 *         @OA\Property(
 *             property="post_user_detail",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="WN Documentary"),
 *             @OA\Property(property="subtitle", type="string", example="wn-documentary"),
 *             @OA\Property(property="image", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/user/profile/9832_google_avatar.jpg"),
 *             @OA\Property(property="is_followed", type="boolean", example=false),
 *             @OA\Property(property="is_safari_operator", type="boolean", example=false),
 *             @OA\Property(property="operator_slug", type="string", example=""),
 *             @OA\Property(property="is_blue_badge_verified", type="boolean", example=false)
 *         ),
 *
 *         @OA\Property(property="resource_uri", type="string", example="http://walkintothewild.io/posts/NjUx"),
 *         @OA\Property(property="thumbnails", type="string", nullable=true, example=null),
 *         @OA\Property(property="caption", type="string", example="Something About Wildlife"),
 *     
 * )
 */
class PostDetailSchema {}
