<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PartnerDetailSchema",
 *     type="object",
 *     @OA\Property(property="business_name", type="string", example="Ankit KanKane Safaris"),
 *     @OA\Property(property="phone_no", type="string", example="8319393633"),
 *     @OA\Property(property="email", type="string", example="ankit.kankane.safaris@gmail.com"),
 *     @OA\Property(property="operator_phone_no", type="string", example="8319393633"),
 *     @OA\Property(property="operator_email", type="string", example="ankit.kankane123@gmail.com"),
 *     @OA\Property(property="slug", type="string", example="ankit-kankane-safaris"),
 *     @OA\Property(property="register_comapany_name", type="string", example="Ankit Kankane Safaris"),
 *     @OA\Property(property="address", type="string", example="BANDHAVGARH NATIONAL PARK"),
 *     @OA\Property(property="google_rating", type="string", example="5"),
 *     @OA\Property(property="google_review_count", type="integer", example=5),
 *     @OA\Property(
 *         property="about_business",
 *         type="string",
 *         example="We are in safari tour operation business from past 12 Years. We are currently operating in Bandhvagarh, Kanha, Panna And Sanjay Dubri Tiger Reserve. Our Customize tour plan are best in class and our safari expert team are best in each of the park. So to make your Safari exciting and memorable reach us at 9753331234/8319393633 ANKIT KANKANE SAFARIS"
 *     ),
 *     @OA\Property(property="image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/operator-registration/2025-05/10_logo_1751379931.jpg"),
 *     @OA\Property(property="park_count", type="integer", example=8),
 *     @OA\Property(property="package_count", type="integer", example=7),
 *     @OA\Property(property="shared_safari_count", type="integer", example=3),
 *     @OA\Property(property="follower_list_count", type="integer", example=304),
 *     @OA\Property(property="category_title", type="string", example="Safari Tour Operator"),
 *     @OA\Property(property="is_followed", type="boolean", example=false),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="has_direct_call", type="boolean", example=false),
 *     @OA\Property(property="direct_call_no", type="integer", nullable=true, example=null),
 *     @OA\Property(
 *         property="review_url",
 *         type="object",
 *         @OA\Property(property="reviews", type="string", example="http://api.walkintothewild.io/operator/ankit-kankane-safaris/reviewlist?sort_by=highest")
 *     ),
 *     @OA\Property(property="show_lead_phone_number", type="boolean", example=false),
 *     @OA\Property(
 *         property="park",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Dudhwa Tiger Reserve"),
 *             @OA\Property(property="slug", type="string", example="dudhwa-tiger-reserve"),
 *             @OA\Property(property="feature_image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/safaripark/1/park_feature_image1718179650.jpg"),
 *             @OA\Property(property="quotation_form_note", type="string", example=""),
 *             @OA\Property(property="template_code", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Property(property="is_approved", type="boolean", example=true),
 *     @OA\Property(property="has_cancellation_policy", type="boolean", example=true),
 *     @OA\Property(property="budget", type="string", example="Premium , Standard , Economical"),
 *     @OA\Property(
 *         property="other_wildlife_activity",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=3),
 *             @OA\Property(property="title", type="string", example="Wildlife Safari")
 *         )
 *     ),
 *     @OA\Property(property="facebook_url", type="string", example=""),
 *     @OA\Property(property="youtube_link", type="string", example=""),
 *     @OA\Property(property="instagram_url", type="string", example="https://www.instagram.com/shivshakti/"),
 *     @OA\Property(property="website", type="string", example=""),
 *     @OA\Property(
 *         property="urls",
 *         type="object",
 *         @OA\Property(property="parks", type="string", example="http://api.walkintothewild.io/operator/shivshakti/operator-park"),
 *         @OA\Property(property="sharedsafari", type="string", example="http://api.walkintothewild.io/operator/shivshakti/operator-shared-safari"),
 *         @OA\Property(property="packages", type="string", example="http://api.walkintothewild.io/operator/shivshakti/operator-packages"),
 *         @OA\Property(property="reviews", type="string", example="http://api.walkintothewild.io/operator/shivshakti/reviewlist?sort_by=highest")
 *     )
 * )
 */

class PartnerDetailSchema {}
