<?php

namespace api\modules\meta\controllers;

use Yii;
use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\meta\MetaAccommodationSearch;
use api\models\meta\MetaAnimalTypeSearch;
use api\models\meta\MetaBirdTypeSearch;
use api\models\meta\MetaLocationSearch;
use api\models\meta\MetaOperatorCredibilitySearch;
use api\models\meta\MetaOtherWildlifeActivitiesSearch;
use api\models\meta\MetaPackageRangeSearch;
use api\models\meta\MetaParkTripSlotSearch;
use api\models\meta\MetaSafariSessionSearch;
use api\models\meta\MetaStayCategorySearch;
use api\models\meta\MetaTermConditionTypeSearch;
use api\models\meta\MetaZoneTypeSearch;
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
                    'all' => ['GET'],
                    'accommodation' => ['GET'],
                    'animal-type' => ['GET'],
                    'bird-type' => ['GET'],
                    'location' => ['GET'],
                    'operator-credibility' => ['GET'],
                    'other-wildlife-activities' => ['GET'],
                    'package-range' => ['GET'],
                    'park-trip-slot' => ['GET'],
                    'safari-session' => ['GET'],
                    'stay-category' => ['GET'],
                    'term-condition-type' => ['GET'],
                    'zone-type' => ['GET'],

                ],
            ],
        ];
    }


    private function readFolderAndFiles($directory)
    {
        if (!is_dir($directory)) {
            echo "Error: $directory is not a valid directory.\n";
            return;
        }

        $fileContent = [];

        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $directory . '/' . $file;
            if (is_dir($filePath)) {
                $this->readFolderAndFiles($filePath); // Recursively read subdirectories
            } else {
                $content =  file_get_contents($filePath);
                $fileContent[] = json_decode($content, true);
            }
        }
        return $fileContent;
    }

    public function actionAll()
    {

        $directory = Yii::getAlias('@app') . '/web/json';
        $data = $this->readFolderAndFiles($directory);

        return Yii::$app->api->sendResponse($data);
    }
  
     /**
     * Get Accommodation 
     *
     *
     * @OA\Get(
     *     path="/meta/accommodation",
     *     tags={"Meta"},
     *     summary="Get Accommodation List",
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
     *         response=200,
     *         description="Successful operation. Returns paginated Accommodation list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaAccommodation",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Hotels"),
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

    public function actionAccommodation()
    {
        $searchModel = new MetaAccommodationSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaAccommodation");
    }

    /**
     * Get Animal Type
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/animal-type",
     *     summary="Get AnimalType List",
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
     *        description="Successful operation. Returns paginated Animal Type list.",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaAnimalType",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Rare/Extinct"),
     *                     )
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
    public function actionAnimalType()
    {
        $searchModel = new MetaAnimalTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaAnimalType");
    }

    // public function actionBirdType()
    // {
    //     $searchModel = new MetaBirdTypeSearch();
    //     return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaBirdType");
    // }

    // public function actionLocation()
    // {
    //     $searchModel = new MetaLocationSearch();
    //     return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaLocation");
    // }


     /**
     * Get Operator Credibilty
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/operator-credibility",
     *     summary="Get Operator Credibility List",
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
     *        description="Successful operation. Returns paginated Operator Credibility list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaOperatorCredability",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Wildlife Photographer"),
     *                     )
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

    public function actionOperatorCredibility()
    {
        $searchModel = new MetaOperatorCredibilitySearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaOperatorCredibility");
    }

    /**
     * Get Other WildLife Activities
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/other-wildlife-activities",
     *     summary="Get Wildlife Activities List",
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
     *        description="Successful operation. Returns paginated Other Wildlife Activities list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaOtherWildlifeActivities",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Trekking"),
     *                     )
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
    public function actionOtherWildlifeActivities()
    {
        $searchModel = new MetaOtherWildlifeActivitiesSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaOtherWildlifeActivities");
    }

    /**
     * Get Package Range
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/package-range",
     *     summary="Get Package Range List",
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
     *        description="Successful operation. Returns paginated Package Range list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaPackageRange",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Economical"),
     *                         @OA\Property(property="min-range", type="integer", example="1000"),
     *                         @OA\Property(property="max-range", type="integer", example="5000"),
     *                     )
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
    public function actionPackageRange()
    {
        $searchModel = new MetaPackageRangeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaPackageRange");
    }

    /**
     * Get Park Trip Slot
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/park-trip-slot",
     *     summary="Get Park Trip Slot List",
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
     *        description="Successful operation. Returns paginated Park Trip Slot list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaParkTripSlot",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Morning"),
     *                     )
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

    public function actionParkTripSlot()
    {
        $searchModel = new MetaParkTripSlotSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaParkTripSlot");
    }

    /**
     * Get Safari Session
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/safari-session",
     *     summary="Get Safari Session List",
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
     *        description="Successful operation. Returns paginated Safari Session list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaSafariSession",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Morning"),
     *                     )
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

    public function actionSafariSession()
    {
        $searchModel = new MetaSafariSessionSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaSafariSession");
    }



    // public function actionStayCategory()
    // {
    //     $searchModel = new MetaStayCategorySearch();
    //     $searchModel->status = 1;
    //     return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaStayCategory");
    // }

    /**
     * Get Term Condition Type
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/term-condition-type",
     *     summary="Get Term Condition Type List",
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
     *        description="Successful operation. Returns paginated Term Condition Type list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaTermConditionType",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Safari Operator Type"),
     *                     )
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

    public function actionTermConditionType()
    {
        $searchModel = new MetaTermConditionTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaTermConditionType");
    }

    /**
     * Get Zone Type
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/zone-type",
     *     summary="Get Zone Type List",
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
     *        description="Successful operation. Returns paginated Zone Type list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaZone",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Buffer Zone"),
     *                         @OA\Property(property="color_code", type="string", example="Red"),
     *                     )
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

    public function actionZoneType()
    {
        $searchModel = new MetaZoneTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaZoneType");
    }


    /**
     * Get Stay Category
     * 
     * @OA\GET(
     *     tags={"Meta"},
     *     path="/meta/stay-category",
     *     summary="Get Stay Category List",
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
     *        description="Successful operation. Returns paginated Stay Category list.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="MetaStayCategory",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"), example={})
     *                 ),
     *                 @OA\Property(
     *                     property="shared_safari",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Economical"),
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="package",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="standard"),
     *                     )
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
    public function actionStayCategory()
    {
        $shareSafariModel = new MetaStayCategorySearch();
        $shareSafariModel->status = 1;

        $shareSafariModel->load(\Yii::$app->getRequest()->getQueryParams());
        $shareSafariModel->setAttributes(\Yii::$app->request->queryParams);

        $dataProvider = $shareSafariModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['!=', 'sequence_for_share_safari', 0]);

        if (isset($this->query_params['pagination']) && $this->query_params['pagination'] == 0) {
            $dataProvider->pagination = false;
        }

        $data = [];
        $data['MetaStayCategory']['summary']['query_params'] = $this->query_params;
        $data['MetaStayCategory']['shared_safari'] = $this->serializeData($dataProvider->getModels());

        $packageModel =  new MetaStayCategorySearch();
        $packageModel->status = 1;

        $packageModel->load(\Yii::$app->getRequest()->getQueryParams());
        $packageModel->setAttributes(\Yii::$app->request->queryParams);

        $dataProvider = $packageModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['!=', 'sequence_for_package', 0]);

        if (isset($this->query_params['pagination']) && $this->query_params['pagination'] == 0) {
            $dataProvider->pagination = false;
        }

        $data['MetaStayCategory']['package'] = $this->serializeData($dataProvider->getModels());
        return Yii::$app->api->sendResponse($data);
    }
}
