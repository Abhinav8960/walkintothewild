<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PostCommentSchema",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=219),
 *     @OA\Property(property="safari_operator_id", type="integer", nullable=true, example=null),
 *     @OA\Property(property="comment", type="string", example="Aap jim corbett ki books par sakte h vo hindi aur english dono m available h"),
 *     @OA\Property(property="dateTime", type="string", example="2025-09-09 12:44:53"),
 *     @OA\Property(property="flaged", type="boolean", example=false),
 *     @OA\Property(property="timestamp", type="integer", example=1757402093),
 *
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/UserSchema"
 *     ),
 *
 *     @OA\Property(
 *         property="replies",
 *         type="array",
 *         example={},
 *         @OA\Items(type="object",ref="#/components/schemas/PostCommentSchema")   
 *     ),
 *
 *     @OA\Property(property="is_liked", type="boolean", example=false),
 *     @OA\Property(property="liked_count", type="integer", example=1)
 * )
 */
class PostCommentSchema {}
