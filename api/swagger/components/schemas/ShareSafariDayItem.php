<?php

namespace api\swagger\components\schemas;


use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ShareSafariDayItem",
 *     type="object",
 *     @OA\Property(property="day", type="integer", example=1),
 *     @OA\Property(property="day_title", type="string", example="Welcome to Corbett National Park"),
 *     @OA\Property(
 *         property="day_description",
 *         type="string",
 *         example="<p>11am - Reach Ramnagar...</p>"
 *     ),
 *     @OA\Property(property="gallery_json", type="string", nullable=true, example=null),
 *     @OA\Property(property="gallery_version", type="string", nullable=true, example=null)
 * )
 */

class ShareSafariDayItem {}