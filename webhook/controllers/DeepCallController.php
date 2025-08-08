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
class DeepCallController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST', 'GET']
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if (in_array($action->id, ['index'])) {
            // Disable CSRF validation for the payu-response action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        \Yii::info('deep-call webhook: ' . date('Y-m-d H:i A') . '' . json_encode($data), 'deep-call');
        return "GODBLESSYOU";
    }
}
