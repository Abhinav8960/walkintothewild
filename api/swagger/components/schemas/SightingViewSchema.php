<?php 

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     schema="SightingViewSchema",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=33),
 *     @OA\Property(property="user_id", type="integer", example=2384),
 *     @OA\Property(property="safari_operator_id", type="integer", example=95),
 *     @OA\Property(property="original_filename", type="string", example="trimmed_video_2025_8_19_11_1_47.mp4"),
 *     @OA\Property(property="original_thumbnail", type="string", nullable=true, example=null),
 *     @OA\Property(property="master_animal_id", type="integer", example=19),
 *     @OA\Property(property="safari_session_id", type="integer", example=1),
 *     @OA\Property(property="post_datetime", type="string", format="date", example="2025-09-08"),
 *     @OA\Property(property="zone_id", type="integer", example=2),
 *     @OA\Property(property="delete_reason", type="string", nullable=true, example=null),
 *     @OA\Property(property="show_in_front", type="integer", example=0),
 *     @OA\Property(property="location_name", type="string", example="Bor Tiger Reserve"),
 *     @OA\Property(property="full_file_path", type="string", example="https://datqk0bl4e6qc.cloudfront.net/watchpost/2509/2384_1758259935.mp4"),
 *     
 *     @OA\Property(property="is_liked", type="boolean", example=false),
 *     @OA\Property(property="likes_count", type="integer", example=5),
 *     @OA\Property(property="comments_count", type="integer", example=37),
 *     @OA\Property(
 *             property="comments",
 *            type="array",
 *            @OA\Items(type="object",ref="#/components/schemas/SightingCommentSchema")
 *     ),
 *     @OA\Property(
 *         property="sighting_user_detail",
 *         type="object",
 *         @OA\Property(property="name", type="string", example="Shivsakti"),
 *         @OA\Property(property="subtitle", type="string", example="annu-singh"),
 *         @OA\Property(property="image", type="string", example="https://datqk0bl4e6qc.cloudfront.net/operator-registration/2506/2384_logo_1749545731.png"),
 *         @OA\Property(property="is_followed", type="boolean", example=true),
 *         @OA\Property(property="is_safari_operator", type="boolean", example=true),
 *         @OA\Property(property="operator_slug", type="string", example="shivsakti-94")
 *     ),
 * 
 *     @OA\Property(property="resource_uri", type="string", example="https://staging.d27737z6qvbtbo.amplifyapp.com/sighting/MzM="),
 *     @OA\Property(property="thumbnail", type="string", example="https://datqk0bl4e6qc.cloudfront.net/watchpost/2509/thumbnail/2384_1758259935.jpg"),
 * 
 *     @OA\Property(
 *         property="thumbnails",
 *         type="object",
 *         @OA\Property(property="high", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/high/watchpost/2509/2384_1758259935.jpg"),
 *         @OA\Property(property="standard", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/standard/watchpost/2509/2384_1758259935.jpg"),
 *         @OA\Property(property="medium", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/medium/watchpost/2509/2384_1758259935.jpg"),
 *         @OA\Property(property="low", type="string", example="https://d380xe4djfiuu3.cloudfront.net/thumbnail/low/watchpost/2509/2384_1758259935.jpg")
 *     ),
 * 
 *     @OA\Property(property="animal_label", type="string", example="Hyena"),
 *     @OA\Property(property="safari_session_label", type="string", example="Morning"),
 *     @OA\Property(property="description", type="string", example="Saurabh singh")
 * )
 */

class SightingViewSchema {}