<?php

namespace api\modules\park\controllers;

use api\controllers\RestController;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafari;
use api\models\park\SafariParkRatingSearch;
use api\behaviours\Verbcheck;
use api\models\operator\SafariOperatorSearch;
use api\models\park\SafariParkSearch;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
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
                    'view' => ['GET'],

                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariParkSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "SafariPark");
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            // return $this->redirect(['/park']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $searchModel = new SafariParkSearch();

        $searchModel->id = $model->id; // for show Selected Park name in search

        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
        
    }
}
