<?php

namespace api\modules\plan\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\master\animal\MasterAnimal;
use api\models\master\animal\MasterAnimalSearch;
use api\models\park\SafariPark;
use api\models\park\SafariParkSearch;
use Yii;
use yii\filters\AccessControl;

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
                    'featured-park' => ['GET'],
                    'rare-animal' => ['GET'],
                ],
            ],
        ];
    }


    /**
     * 
     * Get Feature Park List
     *
     *
     * @OA\Get(
     *     path="/featured-park",
     *     tags={"Plan"},
     *     summary="Get Feature Park List",
     *     description="Return paginated Feature Park List",
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
     *         description="Feature Park fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="feature_park",
     *                 type="object",
     *                 @OA\Property(property="summary", ref="#/components/schemas/SummarySchema"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ParkListSchema")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function actionFeaturedPark()
    {
        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;

        $condition = ['!=', 'sequence', ''];
        $defaultsort = ['sequence' => SORT_ASC];
        return $this->dataProviderSenderWithCondition($searchModel, $rootIndexName = "feature_park", $condition, $defaultsort);
    }


     /**
     * 
     * Get Rare Animal List
     *
     *
     * @OA\Get(
     *     path="/rare-animal",
     *     tags={"Plan"},
     *     summary="Get Rare Animal List",
     *     description="Return paginated Rare Animal List",
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
     *         description="Rare Animal fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="rare_animal_exotic",
     *                 type="object",
     *                 @OA\Property(property="summary", ref="#/components/schemas/SummarySchema"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/AnimalSchema")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function actionRareAnimal()
    {
        $searchModel = new MasterAnimalSearch();
        $searchModel->status = MasterAnimalSearch::STATUS_ACTIVE;
        $defaultsort = ['is_feature_sequence' => SORT_ASC];
        $condition = ['!=', 'is_feature_sequence', ''];

        return $this->dataProviderSenderWithCondition($searchModel, $rootIndexName = "rare_animal_exotic", $condition, $defaultsort);
        // $rare_exotic_animal =  MasterAnimal::find()->where(['status' => MasterAnimal::STATUS_ACTIVE])->andWhere(['!=', 'is_feature_sequence', ''])->limit(10)->orderBy(['is_feature_sequence' => SORT_ASC])->asArray()->all();
        // return $this->dataSender($rare_exotic_animal, $rootIndexName = "Rare Animal Exotic");
    }
}
