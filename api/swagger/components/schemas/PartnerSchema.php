<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 *                     @OA\Schema(
 *                         schema="PartnerSchema",
 *                         type="object",
 *                         @OA\Property(property="business_name", type="string", example="Shivsakti"),
 *                         @OA\Property(property="phone_no", type="string", example="8825317553"),
 *                         @OA\Property(property="email", type="string", example="annu@gmail.com"),
 *                         @OA\Property(property="operator_phone_no", type="string", example="9090909090"),
 *                         @OA\Property(property="operator_email", type="string", example="annu@gmail.com"),
 *                         @OA\Property(property="slug", type="string", example="shivsakti-94"),
 *                         @OA\Property(property="register_comapany_name", type="string", example="Shivsakti"),
 *                         @OA\Property(property="address", type="string", example="Noida sector 62"),
 *                         @OA\Property(property="google_rating", type="string", example="4.5"),
 *                         @OA\Property(property="google_review_count", type="integer", example=2),
 *                         @OA\Property(property="about_business", type="string", example="Just for testing."),
 *                         @OA\Property(property="image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/operator-registration/2025-07/9_logo_1751378227.jpeg"),
 *                         @OA\Property(property="park_count", type="integer", example=44),
 *                         @OA\Property(property="package_count", type="integer", example=18),
 *                         @OA\Property(property="shared_safari_count", type="integer", example=0),
 *                         @OA\Property(property="follower_list_count", type="integer", example=9),
 *                         @OA\Property(property="category_title", type="string", example="Safari Tour Operator"),
 *                         @OA\Property(property="is_followed", type="boolean", example=true),
 *                         @OA\Property(property="status", type="boolean", example=true),
 *                         @OA\Property(property="has_direct_call", type="boolean", example=true),
 *                         @OA\Property(property="direct_call_no", type="integer", example=7557178166),
 *                         @OA\Property(
 *                             property="review_url",
 *                             type="object",
 *                             @OA\Property(property="reviews", type="string", example="https://staging-api.walkintothewild.in/operator/eagle-safaris/reviewlist?sort_by=highest")
 *                         ),
 *                         @OA\Property(property="show_lead_phone_number", type="boolean", example=false)
 * )
 */
class PartnerSchema {}
