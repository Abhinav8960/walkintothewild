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
     * @OA\GET(
     *     tags={"Master"},
     *     path="/master/airport",
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     description="Fetches the list of animals based on required filters.",
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
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
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
     * @OA\Get(
     *     path="/master/bonus-experience",
     *     tags={"Master"},
     *     summary="Get active bonus experience list",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="master_bonus_experience", type="object",
     *                 @OA\Property(property="summary", type="object",
     *                     @OA\Property(property="total", type="integer", example=3),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=5),
     *                     @OA\Property(property="total_page", type="integer", example=1),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"))
     *                 ),
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Sharing Safari")
     *                     )
     *                 )
     *             )
     *         )
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *     @OA\Response(
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
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
     *        response=200,
     *        description="successful operation",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Not Found"
     *     )
     * )
     */
    public function actionPrivacyOptions()
    {
        $options = GeneralModel::privacyoptions();

        return $this->dataSender($options, 'privacy_options');
    }
}
