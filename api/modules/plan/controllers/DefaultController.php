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
     * @return string
     */
    public function actionFeaturedPark()
    {
        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;

        $condition = ['!=', 'sequence', ''];
        $defaultsort = ['sequence' => SORT_ASC];
        return $this->dataProviderSenderWithCondition($searchModel, $rootIndexName = "FeaturePark", $condition, $defaultsort);
    }


    public function actionRareAnimal()
    {
        $searchModel = new MasterAnimalSearch();
        $searchModel->status = MasterAnimalSearch::STATUS_ACTIVE;
        $defaultsort = ['is_feature_sequence' => SORT_ASC];
        $condition = ['!=', 'is_feature_sequence', ''];

        return $this->dataProviderSenderWithCondition($searchModel, $rootIndexName = "RareAnimalExotic", $condition, $defaultsort);
        // $rare_exotic_animal =  MasterAnimal::find()->where(['status' => MasterAnimal::STATUS_ACTIVE])->andWhere(['!=', 'is_feature_sequence', ''])->limit(10)->orderBy(['is_feature_sequence' => SORT_ASC])->asArray()->all();
        // return $this->dataSender($rare_exotic_animal, $rootIndexName = "Rare Animal Exotic");
    }
}
