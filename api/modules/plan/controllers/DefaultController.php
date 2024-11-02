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
        $feature_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->orderBy(['sequence' => SORT_ASC])->asArray()->all();
        return $this->dataSender($feature_park, $rootIndexName = "Feature Park");
    }


    public function actionRareAnimal()
    {
        $rare_exotic_animal =  MasterAnimal::find()->where(['status' => MasterAnimal::STATUS_ACTIVE])->andWhere(['!=', 'is_feature_sequence', ''])->limit(10)->orderBy(['is_feature_sequence' => SORT_ASC])->asArray()->all();
        return $this->dataSender($rare_exotic_animal, $rootIndexName = "Rare Animal Exotic");
    }
}
