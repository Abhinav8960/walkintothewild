<?php

namespace api\swagger\components\schemas;



use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ShareSafariParkItem",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=277),
 *     @OA\Property(property="title", type="string", example="Corbett Tiger Reserve"),
 *     @OA\Property(property="slug", type="string", example="corbett-tiger-reserve"),
 *     @OA\Property(
 *         property="feature_image_path",
 *         type="string",
 *         example="https://datqk0bl4e6qc.cloudfront.net/safaripark/277/park_feature_image1718179323.jpg"
 *     ),
 *     @OA\Property(
 *         property="quotation_form_note",
 *         type="string",
 *         example="Corbett National Park, nestled in the foothills of the Himalayas in Uttarakhand, India, is a pristine sanctuary renowned for its majestic landscapes and rich biodiversity."
 *     ),
 *     @OA\Property(property="template_code", type="integer", example=1)
 * )
 */

class ShareSafariParkItem {}
