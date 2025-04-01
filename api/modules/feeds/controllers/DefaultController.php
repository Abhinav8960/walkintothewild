<?php

namespace api\modules\feeds\controllers;

use api\behaviours\Apiauth;
use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\feeds\Feeds;
use api\models\feeds\FeedsSearch;
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
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
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
                ],
            ],
        ];
    }


    public function actionIndex()
    {
       
        $searchModel = new FeedsSearch();
        $searchModel->status = Feeds::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "feeds");
    }


   
}
