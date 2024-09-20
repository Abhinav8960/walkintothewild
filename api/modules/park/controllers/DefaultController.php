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

        $searchModel->id = $model->slug; // for show Selected Park name in search
        $dataProvider = $searchModel->search($this->request->queryParams);


        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;
        $operatordataProvider = $operatorsearchModel->search($this->request->queryParams, $model->id);
        $operators = $operatordataProvider->getModels();

        // $shared_safaries = ShareSafari::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'park_id' => $model->id])->limit(4)->all();



        $ratingsearchModel = new SafariParkRatingSearch();
        $ratingsearchModel->safari_park_id = $model->id;
        $ratingsearchModel->status = 1;
        $ratingdataProvider = $ratingsearchModel->search($this->request->queryParams);
        $reviews = $ratingdataProvider->getModels();

        return $this->render(
            'view',
            [
                'model' => $model,
                // 'first_month' => $first_month,
                // 'last_month' => $last_month,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'suggestionmodel' => $suggestionmodel,

                'operatorsearchModel' => $operatorsearchModel,
                'operatordataProvider' => $operatordataProvider,
                'operators' => $operators,
                // 'shared_safaries' => $shared_safaries,
                'device' => $this->device(),
                'reviews' => $reviews
            ]
        );
    }
}
