<?php

namespace api\modules\operator\controllers;

use api\behaviours\Apiauth;
use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorSearch;
use frontend\models\OperatorQuoteForm;
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
                'exclude' => ['index', 'view'],
            ],
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => [],
            //     'rules' => [
            //         [
            //             'actions' => [],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],

            //     ],
            // ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                ],
            ],
        ];
    }

    public function actionView($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
        }
        $searchModel = new SafariOperatorSearch();
        $searchModel->id = $operator->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
        // return $this->dataSender($operator, $rootIndexName = "Operator");
    }


    // public function actionQuotesrequest($slug)
    // {
    //     $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (!$operator) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
    //     }
    //     $model = new OperatorQuoteForm();
    //     if ($this->userinfo) {
    //         $model->email = $this->userinfo->email;
    //         $model->full_name = $this->userinfo->name;
    //         $model->phone_no = $this->userinfo->mobile_no;
    //     }
    //     $model->attributes = $this->request;
    //     if ($model->validate()) {
    //         if ($operator_quote = $model->request($operator)) {
    //             // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
    //         }
    //         return Yii::$app->api->sendResponse($data = [$model->attributes], ['message' => 'Quote request sent!']);
    //     }
    // }
}
