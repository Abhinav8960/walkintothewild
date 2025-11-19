<?php

namespace api\swagger\components\schemas;


use OpenApi\Annotations as OA;
/**
 * @OA\Schema(
 *     schema="MasterPackageWithIncluded",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Accommodation"),
 *     @OA\Property(property="option", type="string", example="Optional")
 * )
 */

class MasterPackageWithIncluded {}