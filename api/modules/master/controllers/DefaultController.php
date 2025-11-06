<?php

namespace api\modules\master\controllers;

use Yii;
use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\master\airport\MasterAirportSearch;
use api\models\master\animal\MasterAnimalSearch;
use api\models\master\bird\MasterBirdSearch;
use api\models\master\bonusexperience\MasterBonusExperienceSearch;
use api\models\master\city\MasterCitySearch;
use api\models\master\country\MasterCountrySearch;
use api\models\master\faq\MasterFaqSearch;
use api\models\master\location\MasterLocationSearch;
use api\models\master\message\MasterMessageSearch;
use api\models\master\month\MasterMonthSearch;
use api\models\master\operatorcategory\MasterOperatorCategorySearch;
use api\models\master\packagefeature\MasterPackagefeatureSearch;
use api\models\master\packageinclude\MasterPackageIncludeSearch;
use api\models\master\railwaystation\MasterRailwayStationSearch;
use api\models\master\sharesafarireason\MasterShareSafariReasonSearch;
use api\models\master\state\MasterStateSearch;
use api\models\master\suggetioncategory\MasterSuggestionCategorySearch;
use api\models\master\vehicle\MasterVehicleSearch;
use api\models\meta\MetaAccommodationSearch;
use common\models\GeneralModel;
use OpenApi\Annotations as OA;

/**
 * Site controller
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
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'airport' => ['GET'],
                    'animal' => ['GET'],
                    'bird' => ['GET'],
                    'bonus-experience' => ['GET'],
                    'city' => ['GET'],
                    'country' => ['GET'],
                    'faq' => ['GET'],
                    'location' => ['GET'],
                    'month' => ['GET'],
                    'operator-category' => ['GET'],
                    'package-feature' => ['GET'],
                    'package-include' => ['GET'],
                    'railway-station' => ['GET'],
                    'share-safari-reason' => ['GET'],
                    'state' => ['GET'],
                    'suggestion-category' => ['GET'],
                    'vehicle' => ['GET'],
                    'privacy-options' => ['GET'],

                ],
            ],
        ];
    }

    /**
     * Get Airport List
     *
     *
     * @OA\Get(
     *     path="/master/airport",
     *     tags={"Master"},
     *     summary="Get Airport List",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated airport list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_airport",
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
     *                         @OA\Property(property="name", type="string", example="Tirupati International Airport"),
     *                         @OA\Property(property="slug", type="string", example="tirupati-international-airport"),
     *                         @OA\Property(property="iata_code", type="string", example="TIR"),
     *                         @OA\Property(property="icao_code", type="string", example="VOTP"),
     *                         @OA\Property(property="city", type="string", nullable=true, example=null),
     *                         @OA\Property(
     *                             property="state",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=33),
     *                             @OA\Property(property="state_name", type="string", example="Andhra Pradesh")
     *                         ),
     *                         @OA\Property(
     *                             property="country",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="country_name", type="string", example="India")
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
    public function actionAirport()
    {
        $searchModel = new MasterAirportSearch();
        $searchModel->status =  MasterAirportSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_airport");
    }

    /**
     * Get Animal List
     * 
     * @OA\Get(
     *     path="/master/animal",
     *     tags={"Master"},
     *     summary="Get Animal List",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="is_filter",
     *         in="query",
     *         description="Required, must be 1",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             enum={1},
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="animal_type",
     *         in="query",
     *         description="Required, must be 1",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             enum={1},
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated animal list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_animal",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=5),
     *                     @OA\Property(property="total_page", type="integer", example=1),
     *                     @OA\Property(
     *                         property="query_params",
     *                         type="array",
     *                         @OA\Items(type="object",
     *                            @OA\Property(property="is_filter", type="integer", example=1),
     *                            @OA\Property(property="animal_type", type="integer", example=1),                         
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Red Panda"),
     *                         @OA\Property(property="slug", type="string", example="red-panda"),
     *                         @OA\Property(property="short_description", type="string", example="The red panda, native to the eastern Himalayas and southwestern China, is known for its distinctive red fur, bushy tail, and bamboo diet."),
     *                         @OA\Property(property="banner", type="string", example="45_rareanimal_banner_1749820918.jpg"),
     *                         @OA\Property(property="feature_image", type="string", example="45_rareanimal_feature_image_1749820918.png"),
     *                         @OA\Property(property="know_as", type="string", example=""),
     *                         @OA\Property(property="animal_type", type="integer", example=1),
     *                         @OA\Property(property="is_feature_sequence", type="integer", example=1),
     *                         @OA\Property(property="is_filter", type="boolean", example=false),
     *                         @OA\Property(property="is_filter_sequence", type="int", example=0),
     *                         @OA\Property(property="is_searchable", type="boolean", example=false),
     *                         @OA\Property(property="total_view", type="integer", example=0),
     *                         @OA\Property(property="image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/rareanimal/2506/45_rareanimal_feature_image_1749820918.png"),
     *                         @OA\Property(property="banner_image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/rareanimal/2506/45_rareanimal_feature_image_1749820918.png"),
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
    public function actionAnimal()
    {
        $searchModel = new MasterAnimalSearch();
        $searchModel->status =  MasterAnimalSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_animal");
    }

    // public function actionBird()
    // {
    //     $searchModel = new MasterBirdSearch();
    //     $searchModel->status =  MasterBirdSearch::STATUS_ACTIVE;
    //     return $this->dataProviderSender($searchModel, $rootIndexName = "master_bird");
    // }

    /**
     * Get Bonus Experience List
     *
     *
     * @OA\Get(
     *     path="/master/bonus-experience",
     *     tags={"Master"},
     *     summary="Get Bonus Experience List",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated bonus experience list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_bonus_experience",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Sharing Safari"),
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
    public function actionBonusExperience()
    {
        $searchModel = new MasterBonusExperienceSearch();
        $searchModel->status =  MasterBonusExperienceSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_bonus_experience");
    }


    /**
     * Get City List
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/city",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated city list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_city",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="city_name", type="string", example="Dhuburi"),
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
    public function actionCity()
    {
        $searchModel = new MasterCitySearch();
        $searchModel->status =  MasterCitySearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_city");
    }

     /**
     * Get Country List
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/country",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated country list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_country",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="country_name", type="string", example="India"),
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
    public function actionCountry()
    {
        $searchModel = new MasterCountrySearch();
        $searchModel->status =  MasterCountrySearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_country");
    }

    /**
     * Get Faq List
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/faq",
      *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Faq list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_faq",
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
     *                         @OA\Property(property="question", type="string", example="Which zone is Best in tadoba tiger reserve"),
     *                         @OA\Property(property="answer", type="string", example="Close Moharli and Kolara Zone is Best for Tiger Sighting. It is also Popular for offering Good Accommodation facilities to the Tourists."),
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
    public function actionFaq()
    {
        $searchModel = new MasterFaqSearch();
        $searchModel->status =  MasterFaqSearch::STATUS_ACTIVE;
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "master_faq");
    }

    /**
     * Get Location
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/location",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Location list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_location",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="country_name", type="string", example="Central India"),
     *                         @OA\Property(property="slug", type="string", example="central-india"),
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
    public function actionLocation()
    {
        $searchModel = new MasterLocationSearch();
        $searchModel->status =  MasterLocationSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_location");
    }

    /**
     * Get Month
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/month",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Month list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_month",
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
     *                         @OA\Property(property="month", type="integer", example=1),
     *                         @OA\Property(property="month_name", type="string", example="January"),
     *                         @OA\Property(property="month_short_name", type="string", example="Jan"),
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
    public function actionMonth()
    {
        $searchModel = new MasterMonthSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "master_month");
    }

    public function actionOperatorCategory()
    {
        $searchModel = new MasterOperatorCategorySearch();
        $searchModel->status =  MasterOperatorCategorySearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_operator_category");
    }

     /**
     * Get Package Feature
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/package-feature",
     *   @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Package Feature list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_package_feature",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Multiple park"),
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
    public function actionPackageFeature()
    {
        $searchModel = new MasterPackagefeatureSearch();
        $searchModel->status =  MasterPackagefeatureSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_package_feature");
    }

    /**
     * Get Package Include
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/package-include",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Package Include list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_package_include",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Multiple park"),
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
    public function actionPackageInclude()
    {
        $searchModel = new MasterPackageIncludeSearch();
        $searchModel->status =  MasterPackageIncludeSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_package_include");
    }

    /**
     * Get Railway Station List
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/railway-station",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Railway Station list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_railway_station",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Abhayapuri"),
     *                         @OA\Property(property="station_code", type="string", example="AYU"),
     *                         @OA\Property(property="city",  type="string", nullable=true, example=null, description="City name (can be null)"),
     *                         @OA\Property(
     *                             property="state",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="state_name", type="string", example="Assam")
     *                         ),
     *                         @OA\Property(
     *                             property="country",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="country_name", type="string", example="India")
     *                         )
     *                     )
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
    public function actionRailwayStation()
    {
        // ini_set("memory_limit", "-1");
        $searchModel = new MasterRailwayStationSearch();
        $searchModel->status =  MasterRailwayStationSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_railway_station");
    }

     /**
     * Get Share Safari Reason
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/share-safari-reason",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Share Safari Reason list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_share_safari_reason",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="reason", type="string", example="Not Valid"),
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
    public function actionShareSafariReason()
    {
        $searchModel = new MasterShareSafariReasonSearch();
        $searchModel->status =  MasterShareSafariReasonSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_share_safari_reason");
    }


     /**
     * Get State List
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/state",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated State list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_state",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="state_name", type="string", example="Arunachal Pradesh"),
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
    public function actionState()
    {
        $searchModel = new MasterStateSearch();
        $searchModel->status =  MasterStateSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_state");
    }

    /**
     * Get Suggestion Category
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/suggestion-category",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Suggestion list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_suggestion_category",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="General Information"),
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
    public function actionSuggestionCategory()
    {
        $searchModel = new MasterSuggestionCategorySearch();
        $searchModel->status =  MasterSuggestionCategorySearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_suggestion_category");
    }

    /**
     * Get Vehicle
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/vehicle",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated Vehicle list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="master_vehicle",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=5),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=1),
     *                     @OA\Property(property="total_page", type="integer", example=5),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="vehicle_name", type="string", example="General Information"),
     *                         @OA\Property(property="icon_path", type="string", nullable=true, example=null, description="Icon Path (can be null)"),
     *                         @OA\Property(property="original_icon_name", type="string", nullable=true, example=null, description="Original Icon Name (can be null)"),
     *                         @OA\Property(property="image_path", type="string", nullable=true, example=null, description="Image Path (can be null)"),
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
    public function actionVehicle()
    {
        $searchModel = new MasterVehicleSearch();
        $searchModel->status =  MasterVehicleSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_vehicle");
    }

     /**
     * Get Privacy Options
     * 
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/privacy-options",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="privacy_options",
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
     *                         @OA\Property(property="1", type="string", example="Public"),
     *                         @OA\Property(property="2", type="string", example="Only me"),
     *                         @OA\Property(property="3", type="string", example="My Follower"),
     *                        
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
    public function actionPrivacyOptions()
    {
        $options = GeneralModel::privacyoptions();

        return $this->dataSender($options, 'privacy_options');
    }
}
