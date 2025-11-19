<?php

namespace api\swagger\components\schemas;


use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PackageViewSchema",
 *     type="object",
 *     @OA\Property(property="package_display_name", type="string", example="Dhikala FRH 3N stay with 06 Safaris - Corbett"),
 *     @OA\Property(property="package_name", type="string", example="Dhikala FRH 3N stay with 06 Safaris"),
 *     @OA\Property(property="package_slug", type="string", example="eagle-safaris-by-banzaara-3n-4d-stay-with-06-safaris-8f1846-31723645810-safari-package"),
 *     @OA\Property(property="primary_park", type="string", example="Jim Corbett National Park"),
 *     @OA\Property(property="primary_park_slug", type="string", example="jim-corbett-national-park"),
 *     @OA\Property(property="no_of_day", type="integer", example=4),
 *     @OA\Property(property="no_of_night", type="integer", example=3),
 *     @OA\Property(property="no_of_safari", type="integer", example=6),
 *     @OA\Property(property="cost_per_person", type="number", example=15000),
 *     @OA\Property(property="cost_per_two_person", type="number", example=30000),
 *     @OA\Property(property="total_price", type="number", example=45000),
 *     @OA\Property(property="package_description", type="string", example="Experience the wild like never before with our exclusive 4-day, 3-night package at Dhikala Forest Rest House in Jim Corbett National Park. This package includes 6 thrilling safaris that will take you deep into the heart of the park, offering unparalleled opportunities to witness its diverse flora and fauna."),
 *     @OA\Property(property="image_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/safaripark/277/logo1732599316.jpg"),
 *     @OA\Property(property="image_banner_path", type="string" , example="https://datqk0bl4e6qc.cloudfront.net/package/22/package_banner_image-1723825652.jpg"),
 *     @OA\Property(property="package_day_night_labels", type="string" ,example="3 Nights, 4Days"),
 *     @OA\Property(property="pick_and_drop", type="boolean", example=true),
 *     @OA\Property(property="pick_and_drop_display", type="string", example="Not Included"),
 *     @OA\Property(property="stay_category_id", type="integer", example=1),
 *     @OA\Property(property="stay_category_display", type="string", example="Premium"),
 *     @OA\Property(property="meals_listing", type="string", example="Breakfast, Lunch, Dinner"),
 *     @OA\Property(property="breakfast_included", type="boolean", example=true),
 *     @OA\Property(property="lunch_included", type="boolean", example=true),
 *     @OA\Property(property="dinner_included", type="boolean", example=true),
 *     @OA\Property(property="meal_not_included", type="boolean", example=false),
 *     @OA\Property(property="start_location", type="string", example="Ram Nagar, Jim Corbett National Park")),
 *     @OA\Property(property="end_location", type="string", example="Ram Nagar, Jim Corbett National Park")),
 *     @OA\Property(property="start_date", type="string", format="date"),
 *     @OA\Property(property="end_date", type="string", format="date"),
 *     @OA\Property(property="package_itinerary_overview", type="string", example="Experience the wild like never before with our exclusive 4-day, 3-night package at Dhikala Forest Rest House in Jim Corbett National Park. This package includes 6 thrilling safaris that will take you deep into the heart of the park, offering unparalleled opportunities to witness its diverse flora and fauna."),
 *     @OA\Property(property="package_inclusion", type="string", example="Experience the wild like never before with our exclusive 4-day, 3-night package at Dhikala Forest Rest House in Jim Corbett National Park. This package includes 6 thrilling safaris that will take you deep into the heart of the park, offering unparalleled opportunities to witness its diverse flora and fauna."),
 *     @OA\Property(property="package_exclusion", type="string", example="Experience the wild like never before with our exclusive 4-day, 3-night package at Dhikala Forest Rest House in Jim Corbett National Park. This package includes 6 thrilling safaris that will take you deep into the heart of the park, offering unparalleled opportunities to witness its diverse flora and fauna."),
 *     @OA\Property(property="getting_there", type="string", example="Experience the wild like never before with our exclusive 4-day, 3-night package at Dhikala Forest Rest House in Jim Corbett National Park. This package includes 6 thrilling safaris that will take you deep into the heart of the park, offering unparalleled opportunities to witness its diverse flora and fauna."),
 *     @OA\Property(property="meals", type="string", example="Not Included"),
 *     @OA\Property(property="meals_label", type="string", example="Not Included"), 
 *     @OA\Property(property="type", type="integer", example=0), 
 *     @OA\Property(property="master_vehicle_id", type="string", example=2), 
 *     @OA\Property(property="safari_type", type="string", example=2), 
 *     @OA\Property(property="gst_percentage", type="integer", example="18"), 
 *     @OA\Property(property="package_agenda_id", type="integer", example=3), 
 *     @OA\Property(property="max_booking_date", type="string", format="date", example="2024-12-31"), 
 *     @OA\Property(
 *        property="package_park",
 *        type="array",
 *        @OA\Items(
 *        ref="#/components/schemas/PackageParkItem"
 *       )
 *     ), 
 *     @OA\Property(
 *        property="master_package_with_included",
 *        type="array",
 *        @OA\Items(
 *        ref="#/components/schemas/MasterPackageWithIncluded"
 *       )
 *     ),
 *     @OA\Property(
 *        property="package_days",
 *        type="array",
 *        @OA\Items(
 *        ref="#/components/schemas/PackageDayItem"
 *      )
 *     ),
 *     @OA\Property(
 *        property="faqs",
 *        type="array",
 *        @OA\Items(
 *        ref="#/components/schemas/PackageFaqItem"
 *       )
 *     ),
 *     @OA\Property(
 *        property="package_features_name",
 *         type="array",
 *         @OA\Items(
 *        ref="#/components/schemas/PackageFeatureItem"
 *      )
 *     ),
 * 
 *     @OA\Property(property="partner_gallery_id", type="integer", example=1),
 *     @OA\Property(
 *        property="gallery_json",
 *        type="string",
 *        example=""
 *        ),
 *     @OA\Property(property="gallery_version", type="number", example=1),
 *     @OA\Property(property="tag_type", type="number" , example=1),
 * 
 *     @OA\Property(property="custom_activity_message", type="string", example="Enjoy exclusive activities during your stay."),
 *     @OA\Property(property="custom_price_message", type="string", example="Special discounted price available!"),
 *     @OA\Property(property="cost_per_person_strike_off", type="number" , example=17000),
 *     @OA\Property(property="price_after_discount", type="number" , example=13500),
 *
 *     @OA\Property(
 *         property="partner",
 *         ref="#/components/schemas/PartnerSchema"
 *     ),
 *     @OA\Property(property="is_wishlist", type="boolean", example=false),
 *     @OA\Property(property="is_best_deal", type="integer", example=1),
 *     @OA\Property(property="comment_count", type="integer", example=12),
 *     @OA\Property(property="resource_uri", type="string", example="https://staging.d27737z6qvbtbo.amplifyapp.com/package/eagle-safaris-by-banzaara-3n-4d-stay-with-06-safaris-8f1846-31723645810-safari-package"),
 *     @OA\Property(property="can_comment", type="boolean", example=true),
 *     @OA\Property(property="can_reply", type="boolean", example=true),
 *
 *     @OA\Property(
 *         property="urls",
 *         type="object",
 *         @OA\Property(property="comments", type="string", example="https://staging-api.walkintothewild.in/package/eagle-safaris-by-banzaara-3n-4d-stay-with-06-safaris-8f1846-31723645810-safari-package/comment-view"),
 *     ),
 *
 *     @OA\Property(property="custom_term_and_condition", type="string", example="Custom terms and conditions for this package."),
 *     @OA\Property(property="template_code", type="integer", example=2),
 *     @OA\Property(property="package_tag", type="string", example="Best Seller"),
 *     @OA\Property(property="package_tag_color", type="string", example="#FF5733"),
 *
 *     @OA\Property(
 *         property="image_thumbnails",
 *         type="object",
 *         @OA\Property(property="high", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/high/package/22/v1_package_image-1723825652.jpg"),
 *         @OA\Property(property="standard", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/standard/package/22/v1_package_image-1723825652.jpg"),
 *         @OA\Property(property="medium", type="string" , example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/medium/package/22/v1_package_image-1723825652.jpg"),
 *         @OA\Property(property="low", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/low/package/22/v1_package_image-1723825652.jpg")
 *     )
 *
 *     @OA\Property(
 *         property="banner_thumbnails",
 *         type="object",
 *         @OA\Property(property="high", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/high/package/22/package_banner_image-1723825652.jpg"),
 *         @OA\Property(property="standard", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/standard/package/22/package_banner_image-1723825652.jpg"),
 *         @OA\Property(property="medium", type="string" , example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/medium/package/22/package_banner_image-1723825652.jpg"),
 *         @OA\Property(property="low", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/low/package/22/package_banner_image-1723825652.jpg")
 *     )
 * )
 */
class PackageViewSchema {}
