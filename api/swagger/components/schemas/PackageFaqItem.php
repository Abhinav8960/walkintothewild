<?php

namespace api\swagger\components\schemas;



use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PackageFaqItem",
 *     type="object",
 *     @OA\Property(property="question", type="string", example="Are meals included in the Package?"),
 *     @OA\Property(property="answer", type="string", example="No: Meals are not included; it will be charged additionally.")
 * )
 */

class PackageFaqItem {}