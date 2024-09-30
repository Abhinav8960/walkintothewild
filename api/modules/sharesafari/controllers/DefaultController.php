<?php

namespace api\modules\sharesafari\controllers;

use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;

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
                    'index' => ['GET'],

                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        $searchModel->status =  ShareSafariSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Share Safari");
    }
}
