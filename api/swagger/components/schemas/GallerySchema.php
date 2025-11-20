<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="GallerySchema",
 *     type="object",
 *     @OA\Property(property="title", type="string", example="SOUL TREE"),
 *     @OA\Property(property="slug", type="string", example="soul-tree"),
 *     @OA\Property(property="private_url", type="string", example="http://api.walkintothewild.io/manage/gallery/soul-tree/gallery-images"),
 *     @OA\Property(property="thumbnail", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/partner_gallery/2508/19/83_1754369115.jpeg"),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="can_share", type="boolean", example=true),
 *     @OA\Property(property="gallery_image_count", type="integer", example=5),
 *     @OA\Property(property="live_image_count", type="integer", example=5),
 *     @OA\Property(property="can_send_for_approval", type="boolean", example=false),
 *     @OA\Property(property="can_edit", type="boolean", example=false),
 *     @OA\Property(property="gallery_status_label", type="string", example="Approved")
 * )
 */
class GallerySchema {}
