<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Walk Into The Wild API",
 *   description="API docs"
 * )
 * @OA\Server(url="https://api.walkintothewild.io", description="Development")
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */

/**
 * A minimal path to satisfy validator and verify scanning works.
 * @OA\PathItem(
 *   path="/swagger-ping",
 *   @OA\Get(
 *     tags={"Swagger"},
 *     summary="Swagger ping",
 *     @OA\Response(response=200, description="OK")
 *   )
 * )
 */


