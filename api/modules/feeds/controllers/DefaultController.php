<?php

namespace api\modules\feeds\controllers;

use api\behaviours\Apiauth;
use Yii;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\feeds\Feeds;
use api\models\feeds\FeedsSearch;
use api\models\sharesafari\ShareSafari;
use yii\db\Expression;
use yii\filters\AccessControl;

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
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'sighting-home'],
                'rules' => [
                    [
                        'actions' => ['index', 'sighting-home'],
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
                    'sighting-home' => ['GET']
                ],
            ],
        ];
    }


    /**
     * Get Feeds List
     *
     * @OA\Get(
     *     path="/feeds",
     *     tags={"Feeds"},
     *     summary="Get Feeds List",
     *     security={
     *             {"bearerAuth"={} },
     *             {"XDevice"={} },
     *             {"XPlatform"={} },
     *             {"XPlatformVersion"={} },
     *             {"XApplicationVersion"={} },
     *             {"XEncryption"={} }
     *            },
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *
     *                 @OA\Property(
     *                     property="summary",
     *                     ref="#/components/schemas/SummarySchema"
     *                 ),
     *
     *                 @OA\Property(
     *                     property="feeds",
     *                     type="array",
     *                     @OA\Items(
     *                         oneOf={
     *                             @OA\Schema(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=1051),
     *                                 @OA\Property(property="objective", type="string", example="share_safari"),
     *                                 @OA\Property(
     *                                     property="feed",
     *                                     ref="#/components/schemas/ShareSafariSchema"
     *                                 )
     *                             ),
     *
     *                             @OA\Schema(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=1052),
     *                                 @OA\Property(property="objective", type="string", example="package"),
     *                                 @OA\Property(
     *                                     property="feed",
     *                                     ref="#/components/schemas/PackageViewSchema"
     *                                 )
     *                             ),
     *
     *                             @OA\Schema(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=1048),
     *                                 @OA\Property(property="objective", type="string", example="post"),
     *                                 @OA\Property(
     *                                     property="feed",
     *                                     ref="#/components/schemas/PostDetailSchema"
     *                                 )
     *                             ),
     *
     *                             @OA\Schema(
     *                                 type="object",
     *                                 @OA\Property(property="objective", type="string", example="sighting"),
     *                                 @OA\Property(
     *                                     property="sighting_feeds",
     *                                     type="array",
     *                                     @OA\Items(
     *                                         type="object",
     *                                         @OA\Property(property="id", type="integer", example=318),
     *                                         @OA\Property(property="objective", type="string", example="sighting"),
     *                                         @OA\Property(
     *                                             property="feed",
     *                                             ref="#/components/schemas/SightingViewSchema"
     *                                         )
     *                                     )
     *                                 )
     *                             )
     *                         }
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Not Found")
     *         )
     *     )
     * )
     */

    public function actionIndex()
    {
        $fdIds = [274];

        $searchModel = new FeedsSearch();
        $searchModel->status = Feeds::STATUS_ACTIVE;

        $searchModel->load(\Yii::$app->getRequest()->getQueryParams());
        $searchModel->setAttributes(\Yii::$app->request->queryParams);

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['!=', 'collection', Feeds::MODEL_SIGHTING]);

        if (isset($this->query_params['pagination']) && $this->query_params['pagination'] == 0) {
            $dataProvider->pagination = false;
        }

        $data = [];
        if ($dataProvider->pagination) {
            $pageSize = 5;
            // $pageSize = $this->query_params['pageSize'] ?? 5;
            $dataProvider->pagination->pageSize = $pageSize;
            $dataProvider->pagination->validatePage = false;
            $data['data']['summary']['total'] = $dataProvider->getTotalCount();
            $data['data']['summary']['page'] = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
            $data['data']['summary']['pageSize'] = $dataProvider->pagination->pageSize;
            $data['data']['summary']['total_page'] = ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
        }

        $data['data']['summary']['query_params'] = $this->query_params;
        $data['data']['feeds'] = $this->serializeData($dataProvider->getModels());

        // Fixed Departure Extra Object
        $randomKey = array_rand($fdIds);
        $promotion_id = $fdIds[$randomKey];
        $promotionModel = new FeedsSearch();
        $promotionModel->status = Feeds::STATUS_ACTIVE;
        $promotionModel->collection_id = $promotion_id;
        $promotionModel->collection = Feeds::MODEL_SHARESFARI;
        $promotionProvider = $promotionModel->search(\Yii::$app->request->queryParams);
        $page = Yii::$app->request->get('page', 1);
        if (in_array($page, [1])) {
            $data['data']['feeds'] = array_merge(
                $data['data']['feeds'],
                $this->serializeData($promotionProvider->getModels())
            );
        }

        //Horizontal Feeds
        $types = ['sighting' => Feeds::MODEL_SIGHTING, 'package' => Feeds::MODEL_PACKAGE];
        $randomType = $this->getRandomArrayElement(array_keys($types));
        $horizontalModel = new FeedsSearch();
        $horizontalModel->status = Feeds::STATUS_ACTIVE;
        $horizontalModel->collection = $types[$randomType];
        $horizontalProvider = $horizontalModel->search(Yii::$app->request->getQueryParams());
        $horizontalProvider->query->orderBy(new \yii\db\Expression('RAND()'));
        $horizontalProvider->pagination->pageSize = 6;

        if (!empty($data['data']['feeds'])) {
            $hr = [
                "objective" => $randomType,
                $randomType . "_feeds" => $this->serializeData($horizontalProvider->getModels()),
            ];
            $data['data']['summary']['additional_feed'] = 1;
            array_push($data['data']['feeds'], $hr);
        }

        return Yii::$app->api->sendResponse($data);
    }


    //  public function actionIndex()
    // {
    //     $fdIds = [274];

    //     $page = (int)\Yii::$app->request->get('page', 1);
    //     $limit = 1;
    //     $offset = ($page - 1) * $limit;

    //     // ---- Sighting ----
    //     $sightingQuery = Feeds::find()
    //         ->where([
    //             'status' => Feeds::STATUS_ACTIVE,
    //             'collection' => Feeds::MODEL_SIGHTING
    //         ])
    //         ->offset($offset)
    //         ->limit($limit)
    //         ->orderBy(['id' => SORT_DESC]); // optional ordering

    //     $sightingData = $sightingQuery->all();

    //     // ---- Package ----
    //     $packageQuery = Feeds::find()
    //         ->where([
    //             'status' => Feeds::STATUS_ACTIVE,
    //             'collection' => Feeds::MODEL_PACKAGE
    //         ])
    //         ->offset($offset)
    //         ->limit($limit)
    //         ->orderBy(['id' => SORT_DESC]);

    //     $packageData = $packageQuery->all();

    //     // Main Feed that exclude Sighting and Package
    //     $searchModel = new FeedsSearch();
    //     $searchModel->status = Feeds::STATUS_ACTIVE;
    //     $searchModel->load(\Yii::$app->getRequest()->getQueryParams());
    //     $searchModel->setAttributes(\Yii::$app->request->queryParams);
    //     $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
    //     $dataProvider->query->andWhere(['!=', 'collection', Feeds::MODEL_SIGHTING]);
    //     $dataProvider->query->andWhere(['!=', 'collection', Feeds::MODEL_PACKAGE]);

    //     if (isset($this->query_params['pagination']) && $this->query_params['pagination'] == 0) {
    //         $dataProvider->pagination = false;
    //     }

    //     $data = [];
    //     // if ($dataProvider->pagination) {
    //     //     $pageSize = 5;
    //     //     $dataProvider->pagination->pageSize = $pageSize;
    //     //     $dataProvider->pagination->validatePage = false;
    //     //     $data['data']['summary']['total'] = $dataProvider->getTotalCount();
    //     //     $data['data']['summary']['page'] = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
    //     //     $data['data']['summary']['pageSize'] = $dataProvider->pagination->pageSize;
    //     //     $data['data']['summary']['total_page'] = ceil(($dataProvider->getTotalCount()) / ($dataProvider->pagination->pageSize));
    //     // }

    //     if ($dataProvider->pagination) {
    //         $pageSize = 5;
    //         $dataProvider->pagination->pageSize = $pageSize;
    //         $dataProvider->pagination->validatePage = false;
    //         $data['data']['summary']['total'] = $dataProvider->getTotalCount() + $packageQuery->count() + $sightingQuery->count();
    //         $data['data']['summary']['page'] = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
    //         $data['data']['summary']['pageSize'] = $dataProvider->pagination->pageSize;

    //         $total_page_count = 0;
    //         if ($dataProvider->getTotalCount() == 0) {
    //             $total_page_count = ceil(($packageQuery->count() + $sightingQuery->count()) / 2);
    //         } else if ($dataProvider->getTotalCount() > 0) {
    //             $normal_count = ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
    //             $sighting_package_count = ceil(($packageQuery->count() + $sightingQuery->count()) / 2);
    //             if ($sighting_package_count > $normal_count) {
    //                 $total_page_count = $sighting_package_count;
    //             } else {
    //                 $total_page_count = $normal_count;
    //             }
    //         }
    //         $data['data']['summary']['total_page'] = $total_page_count;
    //     }

    //     $data['data']['summary']['query_params'] = $this->query_params;
    //     $data['data']['feeds'] = $this->serializeData($sightingData);
    //     $data['data']['feeds'] = array_merge($data['data']['feeds'], $this->serializeData($packageData));
    //     $data['data']['feeds'] = array_merge($data['data']['feeds'], $this->serializeData($dataProvider->getModels()));


    //     // Fixed Departure Extra Object
    //     $randomKey = array_rand($fdIds);
    //     $promotion_id = $fdIds[$randomKey];
    //     $promotionModel = new FeedsSearch();
    //     $promotionModel->status = Feeds::STATUS_ACTIVE;
    //     $promotionModel->collection_id = $promotion_id;
    //     $promotionModel->collection = Feeds::MODEL_SHARESFARI;
    //     $promotionProvider = $promotionModel->search(\Yii::$app->request->queryParams);
    //     $page = Yii::$app->request->get('page', 1);
    //     if (in_array($page, [1])) {
    //         $data['data']['feeds'] = array_merge(
    //             $data['data']['feeds'],
    //             $this->serializeData($promotionProvider->getModels())
    //         );
    //     }

    //     //Horizontal Feeds
    //     $types = ['sighting' => Feeds::MODEL_SIGHTING, 'package' => Feeds::MODEL_PACKAGE];
    //     $randomType = $this->getRandomArrayElement(array_keys($types));
    //     $horizontalModel = new FeedsSearch();
    //     $horizontalModel->status = Feeds::STATUS_ACTIVE;
    //     $horizontalModel->collection = $types[$randomType];
    //     $horizontalProvider = $horizontalModel->search(Yii::$app->request->getQueryParams());
    //     $horizontalProvider->query->orderBy(new \yii\db\Expression('RAND()'));
    //     $horizontalProvider->pagination->pageSize = 6;

    //     if (!empty($data['data']['feeds'])) {
    //         $hr = [
    //             "objective" => $randomType,
    //             $randomType . "_feeds" => $this->serializeData($horizontalProvider->getModels()),
    //         ];
    //         $data['data']['summary']['additional_feed'] = 1;
    //         array_push($data['data']['feeds'], $hr);
    //     }

    //     return Yii::$app->api->sendResponse($data);
    // }

    public function actionSightingHome()
    {

        $searchModel = new FeedsSearch();
        $searchModel->status = Feeds::STATUS_ACTIVE;
        $searchModel->collection = $this->getRandomArrayElement([Feeds::MODEL_SIGHTING, Feeds::MODEL_PACKAGE]);

        $searchModel->load(\Yii::$app->getRequest()->getQueryParams());
        $searchModel->setAttributes(\Yii::$app->request->queryParams);

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(new Expression('RAND()'));

        if (isset($this->query_params['pagination']) && $this->query_params['pagination'] == 0) {
            $dataProvider->pagination = false;
        }

        $data = [];
        if ($dataProvider->pagination) {
            $pageSize = $this->query_params['pageSize'] ?? 3;
            $dataProvider->pagination->pageSize = $pageSize;
            $data['data']['summary']['total'] = $dataProvider->getTotalCount();
            $data['data']['summary']['page'] = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
            $data['data']['summary']['pageSize'] = $dataProvider->pagination->pageSize;
            $data['data']['summary']['total_page'] = ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
        }

        $data['data']['summary']['query_params'] = $this->query_params;
        $data['data']['feeds'] = $this->serializeData($dataProvider->getModels());

        return Yii::$app->api->sendResponse($data);
    }

    private function getRandomArrayElement($array)
    {
        $randomIndex = array_rand($array);
        $randomElement = $array[$randomIndex];
        return $randomElement;
    }
}
