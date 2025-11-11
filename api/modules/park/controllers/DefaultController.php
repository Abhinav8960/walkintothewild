<?php

namespace api\modules\park\controllers;

use api\behaviours\Apiauth;
use api\controllers\RestController;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafari;
use api\behaviours\Verbcheck;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorSearch;
use api\models\package\Package;
use api\models\package\PackageSafariPark;
use api\models\package\PackageVersionSearch;
use api\models\park\SafariParkRating;
use api\models\park\SafariParkRatingSearch;
use api\models\park\SafariParkSearch;
use api\models\sharesafari\ShareSafariSearch;
use api\models\suggestions\SafariSuggestions;
use common\Helper\FirebaseNotificationHelper;
use api\models\package\PackageSearch;
use api\models\park\ParkStayCategory;
use api\models\park\ParkStayCategorySearch;
use api\models\park\SafariParkAccomodation;
use api\models\park\SafariParkAccomodationSearch;
use api\models\park\SafariParkFollower;
use common\events\park\ParkReviewApprovalEvent;
use common\models\GeneralModel;
use common\models\leads\form\ParkLeadForm;
use common\models\suggestions\form\SafariSuggestionsForm;
use frontend\models\OperatorQuoteForm;
use frontend\models\SafariParkReviewForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['index', 'view', 'filter-parklist', 'reviewlist', 'park-operator', 'park-shared-safari', 'park-package', 'park-stay-category', 'trip-budget', 'planning-type'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['suggestion', 'park-follow', 'park-unfollow', 'quotesrequest'],
                'rules' => [
                    [
                        'actions' => ['suggestion', 'park-follow', 'park-unfollow', 'quotesrequest'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'filter-parklist' => ['GET'],
                    'reviewlist' => ['GET'],
                    'suggestion' => ['POST'],
                    'park-operator' => ['GET'],

                    'park-shared-safari' => ['GET'],
                    'park-package' => ['GET'],
                    'quotesrequest' => ['POST'],
                    'park-follow' => ['POST'],
                    'park-unfollow' => ['POST'],
                    'park-stay-category' => ['GET'],
                    'trip-budget' => ['GET'],
                    'planning-type' => ['GET'],

                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */

    /**
     * Get Park List
     *
     *
     * @OA\Get(
     *     path="/park",
     *     tags={"Park"},
     *     summary="Get Park List",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Park list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="parks",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=10),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=5),
     *                     @OA\Property(property="total_page", type="integer", example=39),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
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
     *                        @OA\Property(
     *                             property="top_operators",
     *                             type="object",
     *                             @OA\Property(property="business_name", type="string", example="Ankit Kankane Safaris"),
     *                             @OA\Property(property="phone_no", type="integer", example="9999999999"),
     *                             @OA\Property(property="email", type="string", example="ankitsafari@gmail.com"),
     *                             @OA\Property(property="operator_phone_no", type="integer", example="9999999999"),
     *                             @OA\Property(property="operator_email", type="string", example="ankitsafari@gmail.com"),
     *                             @OA\Property(property="slug", type="string", example="ankit-kankane-safaris"),
     *                             @OA\Property(property="register_comapany_name", type="string", example="Ankit Kankane Safaris"),
     *                             @OA\Property(property="address", type="string", example="BANDHAVGARH NATIONAL PARK"),
     *                             @OA\Property(property="google_rating", type="integer", example="5"),
     *                             @OA\Property(property="google_review_count", type="integer", example="5"),
     *                             @OA\Property(property="about_business", type="string", example="We are in safari tour operation business from past 12 Years. We are currently operating in Bandhvagarh, Kanha , Panna And Sanjay Dubri Tiger Reserve."),
     *                             @OA\Property(property="image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/operator-registration/2025-05/10_logo_1751379931.jpg"),
     *                             @OA\Property(property="park_count", type="integer", example="8"),
     *                             @OA\Property(property="package_count", type="integer", example="8"),
     *                             @OA\Property(property="shared_safari_count", type="integer", example="0"),
     *                             @OA\Property(property="follower_list_count", type="integer", example="303"),
     *                             @OA\Property(property="category_title", type="string", example="Safari Tour Operator"),
     *                             @OA\Property(property="is_followed", type="boolean", example=false),
     *                             @OA\Property(property="status", type="boolean", example=true),
     *                             @OA\Property(property="has_direct_call", type="boolean", example=false),
     *                             @OA\Property(property="direct_call_no", type="string", nullable=true, example=null),
     *                             @OA\Property(
     *                                  property="review_url",
     *                                  type="object",
     *                                  @OA\Property(property="reviews", type="string", example="http://api.walkintothewild.io/operator/ankit-kankane-safaris/reviewlist?sort_by=highest"),
     *                             ),
     *                             @OA\Property(property="show_lead_phone_number", type="boolean", example="false")
     *                         ),
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionIndex()
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_WITH_TOP_OPERATORS;
        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "parks");
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    // public function actionView($slug)
    // {

    //     $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FULL;
    //     $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (!$model) {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    //     $searchModel = new SafariParkSearch();

    //     $searchModel->id = $model->id; // for show Selected Park name in search
    //     $searchModel->is_single = true; // for show Selected Park name in search

    //     return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    // }

    /**
     * Get Park List
     *
     *
     * @OA\Get(
     *     path="/park/{slug}",
     *     tags={"Park"},
     *     summary="Get Single Park List",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query single park list",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Single Park list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="parks",
     *                 type="object",
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
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
     *                             type="object",
     *                             @OA\Property(property="month", type="integer", example=7),
     *                             @OA\Property(property="month_name", type="string", example="July"),
     *                             @OA\Property(property="month_short_name", type="string", example="Jul")
     *                        ),
     *                        @OA\Property(
     *                             property="buffer_zones",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=7),
     *                             @OA\Property(property="master_zone_type_name", type="string", example="Buffer Zone\r\n"),
     *                             @OA\Property(property="zone_name", type="string", example="Salukapur"),
     *                             @OA\Property(property="entry_gate_name", type="string", example="Salukapur"),
     *                             @OA\Property(property="entry_gate_latitude", type="string", example=""),
     *                             @OA\Property(property="entry_gate_longitude", type="string", example=""),
     *                             @OA\Property(property="is_open_in_monsoon", type="boolean", example=true),
     *                             @OA\Property(property="open_after_date", type="string",nullable=true, example=null)
     *                        ),
     *                        @OA\Property(
     *                             property="core_zones",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=7),
     *                             @OA\Property(property="master_zone_type_name", type="string", example="Core Zone\r\n"),
     *                             @OA\Property(property="zone_name", type="string", example="Dudhwa"),
     *                             @OA\Property(property="entry_gate_name", type="string", example="Dudhwa"),
     *                             @OA\Property(property="entry_gate_latitude", type="string", example=""),
     *                             @OA\Property(property="entry_gate_longitude", type="string", example=""),
     *                             @OA\Property(property="is_open_in_monsoon", type="boolean", example=true),
     *                             @OA\Property(property="open_after_date", type="string",nullable=true, example=null)
     *                        ),
     *                        @OA\Property(property="nearest_bus_station", type="string",nullable=true, example=null),
     *                        @OA\Property(
     *                             property="airport",
     *                             type="array",
     *                             @OA\Items(
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
     *                              )
     *                          ),
     *                        @OA\Property(property="airport_list", type="string",example="Chaudhary Charan Singh International Airport"),
     *                        @OA\Property(
     *                                 property="vehicles",
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="vehicle_name", type="string", example="India"),
     *                                 @OA\Property(property="icon_path", type="string",  nullable=true, example=null),
     *                                 @OA\Property(property="original_icon_name", type="string",  nullable=true, example=null),
     *                                 @OA\Property(property="image_path", type="string", nullable=true, example=null),
     *                                ),
     *                        @OA\Property(property="safari_vehicles_list", type="string",example="Gypsy / Jeep, Other (Elephant, Boat)"),
     *                        @OA\Property(
     *                                      property="sessions",
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="title", type="string", example="Morning")
     *                                  ),
     *                        @OA\Property(property="safari_sessions_list", type="string",example="Morning, Evening"),
     *                        @OA\Property(property="locked_months_list", type="string",example="July, August, September, October"),
     *                        @OA\Property(property="railway_station_list", type="string",example="Palia Kalan, Lucknow, Shahjehanpur"),
     *                        @OA\Property(
     *                                      property="locked_months",
     *                                      type="object",
     *                                      @OA\Property(property="month", type="integer", example=7),
     *                                      @OA\Property(property="month_name", type="string", example="July"),
     *                                      @OA\Property(property="month_short_name", type="string", example="Jul")
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
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */

    public function actionView($slug)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FULL;
        $model = SafariPark::find()->where(['slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($model->status != SafariPark::STATUS_ACTIVE) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_in_use', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = ['data' => $model->toArray()], ['message' => $message]);
        }
        return Yii::$app->api->sendResponse($data = ['data' => $model->toArray()]);
    }


    /**
     * Get Filter Park List
     *
     *
     * @OA\Get(
     *     path="/filter-parklist",
     *     tags={"Park"},
     *     summary="Get Filter Park List",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated filter park list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="parks",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=5),
     *                         @OA\Property(property="title", type="string", example="Bandhavgarh Tiger Reserve"),
     *                         @OA\Property(property="slug", type="string", example="bandhavgarh-tiger-reserve"),
     *                         @OA\Property(property="feature_image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/safaripark/6/park_feature_image1718179247.jpg"),
     *                         @OA\Property(property="quotation_form_note", type="string", example=""),
     *                         @OA\Property(property="template_code", type="integer", nullable=true, example=1)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */

    public function actionFilterParklist()
    {
        $this->layout = \common\interfaces\NewStatusInterface::PARK_API_LAYOUT_FOR_FILTER_PARK;

        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        $condition = ['template_code' => 1];
        return $this->dataProviderSenderConditionWithoutPagination($searchModel, "parks", $condition);
        // return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "parks");
    }


    /**
     * Get Park Review List
     *
     *
     * @OA\Get(
     *     path="/park/{slug}/reviewlist",
     *     tags={"Park"},
     *     summary="Get Park Review List",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query park review list",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated park review list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="parks",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=194),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=5),
     *                     @OA\Property(property="total_page", type="integer", example=39),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=5),
     *                         @OA\Property(property="title", type="string", example="Bandhavgarh Tiger Reserve"),
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionReviewlist($slug, $sort_by = null)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        // $my_review = SafariParkRating::find()->where(['safari_park_id' => $model->id, 'user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->one();

        $searchModel = new SafariParkRatingSearch();
        $searchModel->safari_park_id = $model->id;
        $searchModel->status = 1;
        $searchModel->custom_sort_by = $sort_by;

        return $this->dataProviderSender($searchModel, $rootIndexName = "reviews");
    }


    /**
     * Post Park Suggestion 
     *
     *
     * @OA\Post(
     *     path="/park/{slug}/suggestion",
     *     tags={"Park"},
     *     summary="Post Park Suggestion",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query park list",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="master_suggestion_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="details",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="submitted successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Missing or invalid Bearer token"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionSuggestion($slug)
    {
        $safari_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$safari_park) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        if ($this->userinfo) {
            $model = new SafariSuggestionsForm();
            $model->status = SafariSuggestions::STATUS_ACTIVE;
            $model->is_approved = 0;
            $model->park_id = $safari_park->id;
            $model->name = $this->userinfo->name;
            $model->email = $this->userinfo->email;
            $model->phone = $this->userinfo->mobile_no;
            $model->ip_address = Yii::$app->request->getRemoteIP();

            $model->attributes = $this->request;
            if ($model->validate()) {
                $model->initializeForm();
                if ($model->safari_suggestion_model->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.submit', ['{var}' => 'Suggestion']);
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.not_submit', ['{var}' => 'Suggestion']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    /**
     * Post Park Review 
     *
     *
     * @OA\Post(
     *     path="/park/{slug}/review",
     *     tags={"Park"},
     *     summary="Post Park Review",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query park list",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="rating",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="review",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Review submitted successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Missing or invalid Bearer token"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionReview($slug)
    {
        $safari_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$safari_park) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $my_review = SafariParkRating::find()->where(['safari_park_id' => $safari_park->id, 'user_id' => $this->userinfo ? $this->userinfoId : null])->limit(1)->one();
        if (!$my_review) {
            $model = new SafariParkReviewForm();
            $model->safari_park_id = $safari_park->id;
            $model->status = SafariParkRating::STATUS_SUSPEND;
            $model->attributes = $this->request;
            if ($model->validate()) {
                $model->initializeForm();
                if ($model->rating_model->save(false)) {
                    new ParkReviewApprovalEvent($safari_park->title, $model->rating_model->review);
                    Yii::$app->session->setFlash('success', 'Thanks for Review! Your review sent for approval');
                    $message = Yii::$app->api->messageManager->getMessage('park.review.review_submitted');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('park.review.review_failed');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
            return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        } else {
            $message = Yii::$app->api->messageManager->getMessage('park.review.review_already_submitted');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
    }


    public function actionParkOperator($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }
        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;


        return $this->dataProviderSender($operatorsearchModel, $rootIndexName = "operators", $additionalSearchQueryParams = [$park_id = $model->id]);
    }

    public function actionParkSharedSafari($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $searchModel = new ShareSafariSearch();
        $searchModel->park_id = $model->id;
        $searchModel->status = ShareSafari::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "shared_safari");
    }

    public function actionParkPackage($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $safaripackages = PackageSafariPark::find()->where(['park_id' => $model->id, 'status' => 1])->all();
        $packageIds = array_column($safaripackages, 'package_id');
        $searchModel = new PackageSearch();
        $searchModel->id = $packageIds;
        $searchModel->status = Package::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, "packages");
    }

            /**
     * Post Qoute Request Park  
     *
     *
     * @OA\Post(
     *     path="/park/{slug}/quotesrequest",
     *     tags={"Park"},
     *     summary="Qoute Request Park",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query park list",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="safaris",type="integer",example=1),
     *                 @OA\Property(property="travelers",type="integer",example=4),
     *                 @OA\Property(property="stay_category_id",type="integer",example=12),
     *                 @OA\Property(property="start_date",type="string",example="2025-12-05"),
     *                 @OA\Property(property="end_date",type="string",example="2025-12-06"),
     *                 @OA\Property(property="user_notes",type="string",example="Park Quotes Check"),
     *                 @OA\Property(property="planning_type",type="integer",example=2),
     *                 @OA\Property(property="trip_budget",type="integer",example=20256)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Quote Request Sent!"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Missing or invalid Bearer token"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */

    public function actionQuotesrequest($slug)
    {
        if ($this->userinfo->is_mobile_no_verified == 0) {
            $message = Yii::$app->api->messageManager->getMessage('common.mobile_verification_required');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 403);
        }

        if ($this->userinfo) {
            $safari_operator = SafariOperator::find()->where(['user_id' => $this->userinfoId])->limit(1)->one();
            if ($safari_operator) {
                $message = Yii::$app->api->messageManager->getMessage('park.quote_request.operator_restricted');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }

        $sf = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$sf) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }


        $model = new ParkLeadForm();
        if ($this->userinfo) {
            $model->email = $this->userinfo->email;
            $model->full_name = $this->userinfo->name;
            $model->phone_no = $this->userinfo->mobile_no;
        }
        $model->attributes = $this->request;
        $model->safari_park_id = $sf->id;
        if ($model->validate()) {
            if ($park_quote = $model->request($this->userinfo)) {
                // FirebaseNotificationHelper::operatorquoterequest($operator, $this->userinfo);
                $message = Yii::$app->api->messageManager->getMessage('park.quote_request.request_sent');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        } else {
            return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }

        if (count($sf->operator) < 1) {
            $message = Yii::$app->api->messageManager->getMessage('park.quote_request.no_verified_operators');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        // return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    /**
     * Post Park Follow 
     *
     *
     * @OA\Post(
     *     path="/park/{slug}/park-follow",
     *     tags={"Park"},
     *     summary="Park Follow",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query park list",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Followed successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Missing or invalid Bearer token"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */

    public function actionParkFollow($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($this->userinfo) {
            $park_follower = SafariParkFollower::find()->where(['user_id' => $this->userinfoId, 'safari_park_id' => $model->id])->limit(1)->one();
            if (!$park_follower) {
                $park_follower = new SafariParkFollower();
            }
            $park_follower->user_id = $this->userinfoId;
            $park_follower->safari_park_id = $model->id;
            $park_follower->follow_datetime = time();
            $park_follower->status = 1;
            if ($park_follower->save(false)) {
                $message = Yii::$app->api->messageManager->getMessage('common.follow_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.follow_failed');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_logged_in');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }


        /**
     * Post Park Unfollow 
     *
     *
     * @OA\Post(
     *     path="/park/{slug}/park-unfollow",
     *     tags={"Park"},
     *     summary="Park Unfollow",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="slug to query park list",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Unfollowed successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Missing or invalid Bearer token"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionParkUnfollow($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        if ($this->userinfo) {
            $park_follower = SafariParkFollower::find()->where(['user_id' => $this->userinfoId, 'safari_park_id' => $model->id])->limit(1)->one();
            if ($park_follower) {
                $park_follower->unfollow_datetime = time();
                $park_follower->status = 0;
                if ($park_follower->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.unfollow_success');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.follow_failed');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_logged_in');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }


        /**
     * Get Stay Category Option
     * 
     * @OA\GET(
     *     tags={"Park"},
     *     path="/park/{park.slug}/park-stay-category",
     *     summary="Get Stay Category Option",
     *     @OA\Parameter(
     *         name="park.slug",
     *         in="path",
     *         required=true,
     *         description="slug to query Stay Category Option",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *       name="page",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *       )
     *     ),
     *     @OA\Parameter(
     *       name="pageSize",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *       )
     *     ), 
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation. Returns stay category option.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example="zjJkXdyjkOSHWUR8IVUmdo+QP/nrK+NczhCbkhm1NmrbwGCnOSVhFFfJHvHqv7fLeU3x1vHaphfJiQEq+H1xEf/RUKnwK+lCWjM9hj6PsMr0R6kDGMOy5Zq78MPzZy3RcnsgbSrUbxFV7hUUuXBPRFoe6ZXYbJvhwu4f8p0nHkRM0vVilmBd1ar8qWF0VTlzJpEyhmvnMQKLGtDp7gfgMzG+FW88JCh55v6rV6BGNRmu9Ye2riqzzIwGxQIIKjQ2xQnuGicVq8z0mM8S8cdzX1U+fshPtxmfdPvEmr+xdn32HzH076iErJkOLrk8QiBg2kTo/ud99u0ZfhWFeM8BUk+iN0iHtl4zWw+eP0cF+oU=",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
     * )
     */

    public function actionParkStayCategory($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Park']);
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        }

        $searchModel = new SafariParkAccomodationSearch();
        $searchModel->safari_park_id = $model->id;
        $searchModel->status = SafariParkAccomodation::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "stay_category_options");
    }

    // public function actionParkStayCategory($slug)
    // {
    //     $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (!$model) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Park Not Found!!!"]);
    //     }

    //     $searchModel = new SafariParkAccomodationSearch();
    //     $searchModel->safari_park_id = $model->id;
    //     $searchModel->status = SafariParkAccomodation::STATUS_ACTIVE;

    //     $data = [];
    //     $searchModel->load(\Yii::$app->request->queryParams);
    //     $searchModel->setAttributes(\Yii::$app->request->queryParams);

    //     $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);



    //     $dataProvider->pagination = false;

    //     $data['stay_category_options']['summary']['query_params'] = $this->query_params;
    //     $data['stay_category_options']['data'] = $this->serializeData($dataProvider->getModels());
    //     return Yii::$app->api->sendResponse($data);
    // }


    /**
     * Get Trip Budget
     * 
     * @OA\GET(
     *     tags={"Park"},
     *     path="/trip-budget",
     *     summary="Get Park Trip Budget List",
     *     @OA\Parameter(
     *       name="page",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *       )
     *     ),
     *     @OA\Parameter(
     *       name="pageSize",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *       )
     *     ), 
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation. Returns park trip budget list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="trip_budget",
     *                 type="object",
     *                 @OA\Property(property="1", type="string", example="Under ₹20,000"),
     *                 @OA\Property(property="2", type="string", example="₹20,000 - ₹40,000"),
     *                 @OA\Property(property="3", type="string", example="₹40,000 - ₹70,000"),
     *                 @OA\Property(property="4", type="string", example="₹70,000 - ₹1,00,000"),
     *                 @OA\Property(property="5", type="string", example="Above ₹1,00,000"),            
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
     * )
     */
    public function actionTripBudget()
    {
        $data['data'] = GeneralModel::tripbudget();
        return Yii::$app->api->sendResponse($data);
    }

    /**
     * Get Planning Type
     * 
     * @OA\GET(
     *     tags={"Park"},
     *     path="/planning-type",
     *     summary="Get Park Planning Type List",
     *     @OA\Parameter(
     *       name="page",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *       )
     *     ),
     *     @OA\Parameter(
     *       name="pageSize",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *       )
     *     ), 
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation. Returns planning type list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="planning_type",
     *                 type="object",
     *                 @OA\Property(
     *                 property="planning_type",
     *                 type="object",
     *                 @OA\Property(property="1", type="string", example="Immediately / This Week"),
     *                 @OA\Property(property="2", type="string", example="Within this month"),
     *                 @OA\Property(property="3", type="string", example="₹40,000 - ₹70,000"),
     *                 @OA\Property(property="4", type="string", example="Just checking options"),
     *                 @OA\Property(property="5", type="string", example="Not Planning right now"),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
     * )
     */

    public function actionPlanningType()
    {
         $data['data'] = GeneralModel::planningtype();
        return Yii::$app->api->sendResponse($data);
    }
}
