<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 *                      @OA\Schema(
 *                        schema="ParkViewSchema",
 *                        type="object",
 *
 *                         @OA\Property(property="id", type="integer", example=5),
 *                         @OA\Property(property="title", type="string", example="Bandhavgarh Tiger Reserve"),
 *                         @OA\Property(property="slug", type="string", example="bandhavgarh-tiger-reserve"),
 *                         @OA\Property(property="feature_image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/safaripark/6/park_feature_image1718179247.jpg"),
 *                         @OA\Property(property="animal_text", type="string", example="Tiger, Leopard, Wild dog, Wild cat, Hyena, Wolf, Elephant"),
 *                         @OA\Property(property="quotation_form_note", type="string", nullable=true, example=null),
 *                         @OA\Property(property="short_description", type="string", example="Situated in Madhya Pradesh, Bandhavgarh Tiger Reserve is famous for its high tiger density and historical significance."),
 *                         @OA\Property(property="avg_safari_price_min", type="integer", example=8000),
 *                         @OA\Property(property="avg_safari_price_max", type="integer", example=10000),
 *                         @OA\Property(
 *                             property="city",
 *                             type="object",
 *                             @OA\Property(property="id", type="integer", example=509),
 *                             @OA\Property(property="city_name", type="string", example="Umaria")
 *                         ),
 *                         @OA\Property(
 *                             property="state",
 *                             type="object",
 *                             @OA\Property(property="id", type="integer", example=16),
 *                             @OA\Property(property="state_name", type="string", example="Madhya Pradesh")
 *                         ),
 *                         @OA\Property(
 *                             property="location",
 *                             type="object",
 *                             @OA\Property(property="id", type="integer", example=1),
 *                             @OA\Property(property="title", type="string", example="Central India"),
 *                             @OA\Property(property="slug", type="string", example="central-india")
 *                         ),
 *                        @OA\Property(property="status", type="boolean", example=true),
 *                        @OA\Property(property="is_followed", type="boolean", example=false),
 *                        @OA\Property(property="template_code", type="integer", example=1),
 *                        @OA\Property(property="latitude", type="string", example=28.465838),
 *                        @OA\Property(property="longitude", type="string", example=80.619582),
 *                        @OA\Property(property="official_website", type="string", example="https://upecotourism.in/CheckAvailability.aspx"),
 *                        @OA\Property(
 *                             property="country",
 *                             type="object",
 *                             @OA\Property(property="id", type="integer", example=1),
 *                             @OA\Property(property="country_name", type="string", example="India")
 *                        ),
 *                        @OA\Property(property="pincode", type="string", example=0),
 *                        @OA\Property(property="about_title", type="string", example="Dudhwa Tiger Reserve"),
 *                        @OA\Property(property="about_description", type="string", example="<p>Dudhwa Tiger Reserve, situated in the Terai region of Uttar Pradesh, India, is a vital protected area known for its rich biodiversity and unique ecosystems. Established in 1978, the reserve covers approximately 1,284 square kilometers and includes the Dudhwa National Park, Kishanpur Wildlife Sanctuary, and Katarniaghat Wildlife Sanctuary. It forms an essential part of the Terai Arc Landscape, which stretches across India and Nepal, providing critical habitats for various wildlife species."),
 *                        @OA\Property(property="module_title", type="string", example="How to reach"),
 *                        @OA\Property(property="module_description", type="string", example="<p>Road : You can choose the route mentioned below as per your city connectivity.<br />\r\nDelhi - Moradabad - Bareilly - Pilibhit ( or Shahjahanpur)-Khutar -Mailani - Palia-Dudhwa (430 km).<br />\r\nShahjahanpur-Powayan-Khutar-Mailani-Palia-Dudhwa (107 km approx.)"),
 *                        @OA\Property(property="florafauna", type="string", example="<h3>Flora</h3>\r\n\r\n<p>The reserve&#39;s vegetation is dominated by the lush Terai ecosystem, characterized by dense sal forests, grasslands, and wetlands. Sal (Shorea robusta) trees form the backbone of the forest canopy, providing a verdant cover. These forests are interspersed with patches of tall elephant grass and swampy marshlands, creating a variety of habitats."),
 *                        @OA\Property(property="long_description", type="string", example="<p>Dudhwa Tiger Reserve, located in Uttar Pradesh, India, spans approximately 1,284 square kilometers and was established in 1978."),
 *                        @OA\Property(
 *                             property="months",
 *                             type="array",
 *                             @OA\Items(
 *                             @OA\Property(property="month", type="integer", example=7),
 *                             @OA\Property(property="month_name", type="string", example="July"),
 *                             @OA\Property(property="month_short_name", type="string", example="Jul")
 *                              )
 *                        ),
 *                        @OA\Property(
 *                             property="buffer_zones",
 *                             type="array",
 *                             @OA\Items(
 *                             @OA\Property(property="id", type="integer", example=7),
 *                             @OA\Property(property="master_zone_type_name", type="string", example="Buffer Zone\r\n"),
 *                             @OA\Property(property="zone_name", type="string", example="Salukapur"),
 *                             @OA\Property(property="entry_gate_name", type="string", example="Salukapur"),
 *                             @OA\Property(property="entry_gate_latitude", type="string", example=""),
 *                             @OA\Property(property="entry_gate_longitude", type="string", example=""),
 *                             @OA\Property(property="is_open_in_monsoon", type="boolean", example=true),
 *                             @OA\Property(property="open_after_date", type="string",nullable=true, example=null)
 *                            )
 *                        ),
 *                        @OA\Property(
 *                             property="core_zones",
 *                             type="array",
 *                             @OA\Items(
 *                             @OA\Property(property="id", type="integer", example=7),
 *                             @OA\Property(property="master_zone_type_name", type="string", example="Core Zone\r\n"),
 *                             @OA\Property(property="zone_name", type="string", example="Dudhwa"),
 *                             @OA\Property(property="entry_gate_name", type="string", example="Dudhwa"),
 *                             @OA\Property(property="entry_gate_latitude", type="string", example=""),
 *                             @OA\Property(property="entry_gate_longitude", type="string", example=""),
 *                             @OA\Property(property="is_open_in_monsoon", type="boolean", example=true),
 *                             @OA\Property(property="open_after_date", type="string",nullable=true, example=null)
 *                             )
 *                        ),
 *                        @OA\Property(property="nearest_bus_station", type="string",nullable=true, example=null),
 *                        @OA\Property(
 *                             property="airport",
 *                                  type="object",
 *                                  @OA\Property(property="id", type="integer", example=5),
 *                                  @OA\Property(property="name", type="string", example="Tirupati International Airport"),
 *                                  @OA\Property(property="slug", type="string", example="tirupati-international-airport"),
 *                                  @OA\Property(property="iata_code", type="string", example="TIR"),
 *                                  @OA\Property(property="icao_code", type="string", example="VOTP"),
 *                                  @OA\Property(property="city", type="string", nullable=true, example=null),
 *                                  @OA\Property(
 *                                      property="state",
 *                                      type="object",
 *                                      @OA\Property(property="id", type="integer", example=33),
 *                                      @OA\Property(property="state_name", type="string", example="Andhra Pradesh")
 *                                  ),
 *                                  @OA\Property(
 *                                      property="country",
 *                                      type="object",
 *                                      @OA\Property(property="id", type="integer", example=1),
 *                                      @OA\Property(property="country_name", type="string", example="India")
 *                                  )
 *                              
 *                          ),
 *                        @OA\Property(property="airport_list", type="string",example="Chaudhary Charan Singh International Airport"),
 *                        @OA\Property(
 *                                 property="vehicles",
 *                                 type="array",
 *                             @OA\Items(
 * 
 *                                 @OA\Property(property="id", type="integer", example=1),
 *                                 @OA\Property(property="vehicle_name", type="string", example="India"),
 *                                 @OA\Property(property="icon_path", type="string",  nullable=true, example=null),
 *                                 @OA\Property(property="original_icon_name", type="string",  nullable=true, example=null),
 *                                 @OA\Property(property="image_path", type="string", nullable=true, example=null),
 * )
 *                                ),
 *                        @OA\Property(property="safari_vehicles_list", type="string",example="Gypsy / Jeep, Other (Elephant, Boat)"),
 *                        @OA\Property(
 *                                      property="sessions",
 *                                      type="array",
 *                                      @OA\Items(
 *                                      @OA\Property(property="id", type="integer", example=1),
 *                                      @OA\Property(property="title", type="string", example="Morning"),
 *                                      )
 *                                  ),
 *                        @OA\Property(property="safari_sessions_list", type="string",example="Morning, Evening"),
 *                        @OA\Property(property="locked_months_list", type="string",example="July, August, September, October"),
 *                        @OA\Property(property="railway_station_list", type="string",example="Palia Kalan, Lucknow, Shahjehanpur"),
 *                        @OA\Property(
 *                                      property="locked_months",
 *                                      type="array",
 *  @OA\Items(
 *                                      @OA\Property(property="month", type="integer", example=7),
 *                                      @OA\Property(property="month_name", type="string", example="July"),
 *                                      @OA\Property(property="month_short_name", type="string", example="Jul"),
 * )
 *                                  ),
 *                        @OA\Property(property="google_rating", type="string",example=""),
 *                        @OA\Property(property="google_review_count", type="integer",example=0),
 *                        @OA\Property(
 *                             property="urls",
 *                             type="object",
 *                             @OA\Property(property="operators", type="string", example="http://api.walkintothewild.io/park/dudhwa-tiger-reserve/park-operator"),
 *                             @OA\Property(property="sharedsafari", type="string", example="http://api.walkintothewild.io/park/dudhwa-tiger-reserve/park-shared-safari"),
 *                             @OA\Property(property="packages", type="string", example="http://api.walkintothewild.io/park/dudhwa-tiger-reserve/park-package"),
 *                             @OA\Property(property="reviews", type="string", example="http://api.walkintothewild.io/park/dudhwa-tiger-reserve/reviewlist?sort_by=highest")
 *                         )
 * )
 */
class ParkViewSchema {}
