<?php

namespace api\modules\feeds\controllers;

use api\behaviours\Apiauth;
use Yii;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\feeds\Feeds;
use api\models\feeds\FeedsSearch;
use api\models\sharesafari\ShareSafari;
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
        $promotions = Feeds::find()
            ->where(['collection' => 1, 'status' => 1])
            ->andWhere(['>=', 'date_time', date('Y-m-d')])
            ->orderBy(['id' => SORT_DESC])
            ->limit(3)
            ->all();
        $fdIds = [];
        foreach ($promotions as $promotion) {
            $fixed_departure = ShareSafari::find()->where(['id' => $promotion->collection_id, 'type' => ShareSafari::TYPE_FIXED_DEPARTURE])->limit(1)->one();
            if ($fixed_departure) {
                $fdIds[] = $fixed_departure->id;
            }
        }

        $searchModel = new FeedsSearch();
        $searchModel->status = Feeds::STATUS_ACTIVE;

        $searchModel->load(\Yii::$app->getRequest()->getQueryParams());
        $searchModel->setAttributes(\Yii::$app->request->queryParams);

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['!=', 'collection', Feeds::MODEL_SIGHTING]);

        if (isset($this->query_params['pagination']) && $this->query_params['pagination'] == 0) {
            $dataProvider->pagination = false;
        }

        $data = [];
        if ($dataProvider->pagination) {
            $pageSize = 5;
            // $pageSize = $this->query_params['pageSize'] ?? 5;
            $dataProvider->pagination->pageSize = $pageSize;
            $dataProvider->pagination->validatePage = false;
            $data['data']['summary']['total'] = $dataProvider->getTotalCount();
            $data['data']['summary']['page'] = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
            $data['data']['summary']['pageSize'] = $dataProvider->pagination->pageSize;
            $data['data']['summary']['total_page'] = ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
        }

        $data['data']['summary']['query_params'] = $this->query_params;
        $data['data']['feeds'] = $this->serializeData($dataProvider->getModels());

        // Fixed Departure Extra Object
        $randomKey = array_rand($fdIds);
        $promotion_id = $fdIds[$randomKey];
        $promotionModel = new FeedsSearch();
        $promotionModel->status = Feeds::STATUS_ACTIVE;
        $promotionModel->collection_id = $promotion_id;
        $promotionModel->collection = Feeds::MODEL_SHARESFARI;
        $promotionProvider = $promotionModel->search(\Yii::$app->request->queryParams);
        $page = Yii::$app->request->get('page', 1);
        if (in_array($page, [1])) {
            $data['data']['feeds'] = array_merge(
                $data['data']['feeds'],
                $this->serializeData($promotionProvider->getModels())
            );
        }

        //Horizontal Feeds
        $types = ['sighting' => Feeds::MODEL_SIGHTING, 'package' => Feeds::MODEL_PACKAGE];
        $randomType = $this->getRandomArrayElement(array_keys($types));
        $horizontalModel = new FeedsSearch();
        $horizontalModel->status = Feeds::STATUS_ACTIVE;
        $horizontalModel->collection = $types[$randomType];
        $horizontalProvider = $horizontalModel->search(Yii::$app->request->getQueryParams());
        $horizontalProvider->query->orderBy(new \yii\db\Expression('RAND()'));
        $horizontalProvider->pagination->pageSize = 6;

        if (!empty($data['data']['feeds'])) {
            $hr = [
                "objective" => $randomType,
                $randomType . "_feeds" => $this->serializeData($horizontalProvider->getModels()),
            ];
            $data['data']['summary']['additional_feed'] = 1;
            array_push($data['data']['feeds'], $hr);
        }

        return Yii::$app->api->sendResponse($data);
    }

    public function actionSightingHome()
    {

        $searchModel = new FeedsSearch();
        $searchModel->status = Feeds::STATUS_ACTIVE;
        $searchModel->collection = $this->getRandomArrayElement([Feeds::MODEL_SIGHTING, Feeds::MODEL_PACKAGE]);

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

    private function getRandomArrayElement($array)
    {
        $randomIndex = array_rand($array);
        $randomElement = $array[$randomIndex];
        return $randomElement;
    }
}
