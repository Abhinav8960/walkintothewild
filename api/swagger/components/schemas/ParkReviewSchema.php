<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ParkReviewSchema",
 *     type="object",
 *     @OA\Property(property="rating", type="integer", example=5),
 *     @OA\Property(property="review", type="string", example="test"),
 *     @OA\Property(property="flaged", type="integer", example=0),
 *     @OA\Property(property="user", ref="#/components/schemas/UserSchema"),
 *     @OA\Property(property="review_date", type="string", example="August 20, 2025 at 18:17 PM")
 * )
 */

class ParkReviewSchema {}