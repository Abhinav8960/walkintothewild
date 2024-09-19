<?php

namespace api\modules\master\controllers;

use Yii;
use yii\filters\AccessControl;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\meta\MetaAccommodationSearch;


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
                ],
            ],
        ];
    }


    public function actionAccommodation()
    {
        $searchModel = new MetaAccommodationSearch();
        return $this->dataProviderSender($searchModel, $rootIndexName = "TravelStyleTag", $additionalSearchQueryParams = ["travelStyleTag"]);

    }

   
}
