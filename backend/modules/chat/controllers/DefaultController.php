<?php

namespace backend\modules\chat\controllers;

use api\models\chat\Chat as ApiChat;
use api\models\chat\ChatMessage;
use common\models\chat\Chat;
use common\models\chat\ChatDisplaySearch;
use common\models\leads\Lead;
use common\models\leads\LeadSearch;
use common\models\operator\SafariOperator;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return $behaviors + [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'quotation', 'quotation-validate'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'quotation', 'quotation-validate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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

        $searchModel = new ChatDisplaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($chat_id,$user_id, $recipient_id)
    {
        $model = $this->findModel($chat_id);
        $user = User::find()->where(['id'=>$user_id])->one();
        $recipient = User::find()->where(['id'=>$recipient_id])->one();

        return $this->renderAjax('view', [
            'model' => $model,
            'user' => $user,
            'recipient' => $recipient,
        ]);
    }


    protected function findModel($id)
    {
        // print_r($id);
        // die();
        if (($model = Chat::find()->where(['id'=>$id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
