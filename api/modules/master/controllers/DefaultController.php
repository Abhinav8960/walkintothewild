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
     *     summary="Get Airport List (NIU)",
     *     description = "This API is used to retrieve all airports within a specified state. Pagination is supported through the page parameter, which can be passed in the request to fetch results in pages.",
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
     *     description = "This API is used to fetch the list of animals available in the application.",
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
     *     @OA\Parameter(
     *         name="is_filter",
     *         in="query",
     *         description="Used for filtering the data",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="animal_type",
     *         in="query",
     *         description="Used for filtering the data",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns paginated animal list. <br> The data returned is used in multiple places such as <b>Park List, AutoComplete Animals, Plan Screen, Add Sighting Bottom Sheet </b>, and <b>Sighting Filter Bottom Sheet.</b>",
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
     *                         @OA\Property(property="animal_type", type="integer", example=1),
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
     *     summary="Get Bonus Experience List (NIU)",
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
     *     summary ="Get City List (NIU)",
     *     description = "This API returns all cities for a given country. Currently, the API only supports India, but additional countries may be supported in the future.",
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
     *     summary = "Ger Country List (NIU)",
     *     description ="This API returns all country. Currently, the API only supports <b>India</b>, but additional countries may be supported in the future.",
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
     *     summary = "Get Faq List (NIU)",
     *     description = "This API is used to fetch the list of all FAQs. Each FAQ entry contains a <b>question</b> and its corresponding <b>answer</b>.",
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
     *     description = "This API is used to fetch the list of locations available in the application.<br>The data returned is used in multiple places such as <b>Park Screen, AutoComplete Location,</b> and <b>Plan Screen</b>.<br>Currently, we are using only the <i>title</i> field from the response, so other unused fields can be removed from the API response to optimize payload size and performance.",
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
     *                         @OA\Property(property="id", type="integer", example=7),
     *                         @OA\Property(property="title", type="string", example="Central India"),
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
     *     summary = "Get Month (NIU)",
     *     description = "The <b>Month API</b> provides a complete list of all months available in the system.<br>This endpoint is commonly used in modules such as <b>Plan Safari, Package Creation,</b> and <b>Seasonal Filters</b>, where month selection is required for booking or filtering safari experiences based on the time of year.",
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
     *     description = "The <b>Package Feature API</b> provides a categorized list of package features available in the application.These features are used in multiple modules such as <b>Add/Update Package, Overview Tab,</b> and <b>Safari Package</b> screens.This endpoint is used to retrieve package feature options (e.g., <b>“Private Room”</b>, <b>“Shared Room”</b>, etc.), which are displayed in the UI as selectable choices.",
     *   @OA\Parameter(
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
     *     description = "The <b>Package Include API</b> provides a categorized list of package inclusions available in the application.<br>These inclusions are used across various modules, such as the <b>Package Filter Bottom Sheet</b> screen.<br>This endpoint helps retrieve package inclusion options like <b>“Accommodation,” “Pick & Drop,” “Permit,”</b> etc., which are displayed in the UI as selectable filtering or selection options.",
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
     *                         @OA\Property(property="title", type="string", example="Accommodation"),
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
     *     summary = "Get Railway Station List (NIU)",
     *     description = "This API returns all Railway stations in a city. Currently, the API only supports <b>India</b>, but additional countries may be supported in the future.",
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
     *     summary = "Get Share Safari Reason (NIU)",
     *     description = "This API returns all Safari reason.",
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
     *     summary = "Get State List (NIU)",
     *     description = "This API returns all state in a country. Currently, the API only supports <b>India</b>, but additional countries may be supported in the future.",
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
     *     description = "The <b>Suggestion Category API</b> provides a categorized list of suggestion types used within the application.These categories are primarily utilized in modules such as the <b>Submit Correction Tab</b>, enabling users to select predefined suggestion categories like <b>“General Information,” “Flora/Fauna,”</b> etc.",
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
     *     description ="The <b>Master Vehicle API</b> provides a categorized list of all vehicle types available for safari and package creation modules within the application.These vehicle options are commonly used across screens such as <b>Add/Update Package, Plan Safari,</b> and the <b>Overview Tab</b>, allowing users to select their preferred mode of transport (e.g., <b>Jeep, Bus, Elephant,</b> etc.).",
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
     *                         @OA\Property(property="vehicle_name", type="string", example="Gypsy/Jeep"),
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
     *     summary = "Get Privacy Options (NIU)",
     *     description = "This API returns all privacy options.",
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
