<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SummarySchema",
 *     type="object",
 *     @OA\Property(property="total", type="integer", example=32),
 *     @OA\Property(property="page", type="integer", example=1),
 *     @OA\Property(property="pageSize", type="integer", example=5),
 *     @OA\Property(property="total_page", type="integer", example=7),
 *     @OA\Property(property="query_params", type="array", @OA\Items(type="string"))
 * )
 */
class SummarySchema {}