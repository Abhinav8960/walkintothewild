<?php

namespace webhook\controllers;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\leads\LeadPartnerQuotes;
use common\models\transaction\Transaction;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii;

/**
 * Default controller for the `error` module
 */
class PayuController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['success', 'failed', 'refund', 'dispute'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'success' => ['POST', 'GET'],
                    'failed' => ['POST', 'GET'],
                    'refund' => ['POST', 'GET'],
                    'dispute' => ['POST', 'GET'],
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if (in_array($action->id, ['success', 'failed', 'refund', 'dispute'])) {
            // Disable CSRF validation for the payu-response action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionSucess()
    {
        $data = Yii::$app->request->post();

        \Yii::info('PayU Response Sucess: ' . json_encode($data), 'payu');
    }

    public function actionFailed()
    {
        $data = Yii::$app->request->post();

        \Yii::info('PayU Response Failed: ' . json_encode($data), 'payu');
    }

    public function actionRefund()
    {
        $data = Yii::$app->request->post();

        \Yii::info('PayU Response Refund: ' . json_encode($data), 'payu');
    }

    public function actionDispute()
    {
        $data = Yii::$app->request->post();

        \Yii::info('PayU Response Dispute: ' . json_encode($data), 'payu');
    }
}
