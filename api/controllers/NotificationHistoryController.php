<?php

namespace api\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\models\FirebaseNotificationLog;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class NotificationHistoryController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors +  [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
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
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        if ($this->userinfo) {
            $dataProvider = new ActiveDataProvider([
                'query' => FirebaseNotificationLog::find()->where([
                    'user_id' => $this->userinfoId,
                    'status' => 1,
                ]),
                'pagination' => false,
                'sort' => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                    ]
                ],
            ]);

            return $this->querySender($dataProvider, $rootIndexName = "notification_history");
        }

        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not logged in!!"]);
    }
}
