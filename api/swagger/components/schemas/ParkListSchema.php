<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ParkListSchema",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=277),
 *     @OA\Property(property="title", type="string", example="Corbett Tiger Reserve"),
 *     @OA\Property(property="slug", type="string", example="corbett-tiger-reserve"),
 *
 *     @OA\Property(
 *         property="feature_image_path",
 *         type="string",
 *         example="https://d2oqzs36p95tb4.cloudfront.net/safaripark/277/park_feature_image1718179323.jpg"
 *     ),
 *
 *     @OA\Property(
 *         property="animal_text",
 *         type="string",
 *         example="Tiger, Leopard, Wild cat, Elephant, Yellow Throated Marten"
 *     ),
 *
 *     @OA\Property(
 *         property="quotation_form_note",
 *         type="string",
 *         example="Night stay and Canter safari are unavailable due to the monsoon season. Forest Rest House remains closed from 15 June to 15 November."
 *     ),
 *
 *     @OA\Property(
 *         property="short_description",
 *         type="string",
 *         example="Located in Uttarakhand, Corbett Tiger Reserve is India's oldest national park, established in 1936. It is renowned for its rich biodiversity and large tiger population..."
 *     ),
 *
 *     @OA\Property(property="avg_safari_price_min", type="integer", example=7000),
 *     @OA\Property(property="avg_safari_price_max", type="integer", example=8000),
 *
 *     @OA\Property(
 *         property="city",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=511),
 *         @OA\Property(property="city_name", type="string", example="Ramnagar")
 *     ),
 *
 *     @OA\Property(
 *         property="state",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=31),
 *         @OA\Property(property="state_name", type="string", example="Uttarakhand")
 *     ),
 *
 *     @OA\Property(
 *         property="location",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=3),
 *         @OA\Property(property="title", type="string", example="North India"),
 *         @OA\Property(property="slug", type="string", example="location-agra")
 *     ),
 *
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="is_followed", type="boolean", example=false),
 *     @OA\Property(property="template_code", type="integer", example=1)
 * )
 */
class ParkListSchema {}
