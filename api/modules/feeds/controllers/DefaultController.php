<?php

namespace api\modules\feeds\controllers;

use api\behaviours\Apiauth;
use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\feeds\Feeds;
use api\models\feeds\FeedsSearch;
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


    public function actionIndex()
    {

        $searchModel = new FeedsSearch();
        $searchModel->status = Feeds::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "feeds");
    }

    public function actionSightingHome()
    {

        $searchModel = new FeedsSearch();
        $searchModel->status = Feeds::STATUS_ACTIVE;
        $searchModel->collection = Feeds::MODEL_SIGHTING;

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
}
