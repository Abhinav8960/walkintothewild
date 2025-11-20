<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="AnimalSchema",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=39),
 *     @OA\Property(property="name", type="string", example="Snow Leopard"),
 *     @OA\Property(property="slug", type="string", example="snow-leopard"),
 *     @OA\Property(
 *         property="short_description",
 *         type="string",
 *         example="The snow leopard, found in India's Himalayas, is an elusive big cat with thick fur and a long tail, perfectly adapted to cold, rocky terrains."
 *     ),
 *     @OA\Property(property="banner", type="string", example="39_rareanimal_banner_1749820916.jpg"),
 *     @OA\Property(property="feature_image", type="string", example="39_rareanimal_feature_image_1749820916.png"),
 *     @OA\Property(property="know_as", type="string", example=""),
 *     @OA\Property(property="animal_type", type="integer", example=2),
 *     @OA\Property(property="is_feature_sequence", type="integer", example=1),
 *     @OA\Property(property="is_filter", type="boolean", example=false),
 *     @OA\Property(property="is_filter_sequence", type="integer", example=0),
 *     @OA\Property(property="is_searchable", type="boolean", example=false),
 *     @OA\Property(property="total_view", type="integer", example=25),
 *
 *     @OA\Property(
 *         property="image_path",
 *         type="string",
 *         example="https://d2oqzs36p95tb4.cloudfront.net/rareanimal/2506/39_rareanimal_feature_image_1749820916.png"
 *     ),
 *
 *     @OA\Property(
 *         property="banner_image_path",
 *         type="string",
 *         example="https://d2oqzs36p95tb4.cloudfront.net/rareanimal/2506/39_rareanimal_banner_1749820916.jpg"
 *     )
 * )
 */
class AnimalSchema {}
