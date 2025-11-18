<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PartnerSchema",
 *     type="object",
 *     @OA\Property(property="business_name", type="string"),
 *     @OA\Property(property="phone_no", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="operator_phone_no", type="string"),
 *     @OA\Property(property="operator_email", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(property="register_comapany_name", type="string"),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="google_rating", type="string"),
 *     @OA\Property(property="google_review_count", type="integer"),
 *     @OA\Property(property="about_business", type="string"),
 *     @OA\Property(property="image_path", type="string"),
 *     @OA\Property(property="park_count", type="integer"),
 *     @OA\Property(property="package_count", type="integer"),
 *     @OA\Property(property="shared_safari_count", type="integer"),
 *     @OA\Property(property="follower_list_count", type="integer"),
 *     @OA\Property(property="category_title", type="string"),
 *     @OA\Property(property="is_followed", type="boolean"),
 *     @OA\Property(property="status", type="boolean"),
 *     @OA\Property(property="has_direct_call", type="boolean"),
 *     @OA\Property(property="direct_call_no", type="string", nullable=true),
 *     @OA\Property(
 *         property="review_url",
 *         type="object",
 *         @OA\Property(property="reviews", type="string")
 *     ),
 *     @OA\Property(property="show_lead_phone_number", type="boolean")
 * )
 */
class PartnerSchema {}
