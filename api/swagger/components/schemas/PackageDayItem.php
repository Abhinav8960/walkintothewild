<?php

namespace api\swagger\components\schemas;


use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PackageDayItem",
 *     type="object",
 *     @OA\Property(property="day", type="integer", example=1),
 *     @OA\Property(property="day_title", type="string", example="Welcome to Corbett National Park"),
 *     @OA\Property(
 *         property="day_description",
 *         type="string",
 *         example="<p>11am - Reach Ramnagar...</p>"
 *     ),
 *     @OA\Property(property="start_location", type="string", nullable=true, example=""),
 *     @OA\Property(property="end_location", type="string", nullable=true, example=""),
 *     @OA\Property(property="latitude", type="number", format="float", nullable=true, example=null),
 *     @OA\Property(property="longitude", type="number", format="float", nullable=true, example=null),
 *     @OA\Property(property="hotel_name", type="string", nullable=true, example=""),
 *     @OA\Property(property="original_filename", type="string", nullable=true, example=null),
 *     @OA\Property(property="partner_gallery_id", type="integer", nullable=true, example=null),
 *     @OA\Property(property="gallery_json", type="string", nullable=true, example=null),
 *     @OA\Property(property="gallery_version", type="string", nullable=true, example=null),
 *     @OA\Property(property="image_path", type="string", example=""),
 *
 *     @OA\Property(
 *         property="image_thumbnails",
 *         type="array",
 *         @OA\Items(type="string", example="https://example.com/thumb1.jpg")
 *     )
 * )
 */

class PackageDayItem {}