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
                    'accommodation' => ['GET'],
                    'animal-type' => ['GET'],
                    'bird-type' => ['GET'],
                    'location' => ['GET'],
                    'operator-credibility' => ['GET'],
                ],
            ],
        ];
    }


    public function actionAccommodation()
    {
        $searchModel = new MetaAccommodationSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaAccommodation");
    }

    public function actionAnimalType()
    {
        $searchModel = new MetaAnimalTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaAnimalType");
    }

    public function actionBirdType()
    {
        $searchModel = new MetaBirdTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaBirdType");
    }

    public function actionLocation()
    {
        $searchModel = new MetaLocationSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaLocation");
    }

    public function actionOperatorCredibility()
    {
        $searchModel = new MetaOperatorCredibilitySearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaOperatorCredibility");
    }

    public function actionOtherWildlifeActivities()
    {
        $searchModel = new MetaOtherWildlifeActivitiesSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaOtherWildlifeActivities");
    }
}
