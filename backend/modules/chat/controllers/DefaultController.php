<?php

namespace backend\modules\chat\controllers;

use api\models\chat\Chat;
use common\models\chat\ChatDisplaySearch;
use common\models\leads\Lead;
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
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
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
        $searchModel->chat_type = [Chat::CHAT_TYPE_QUOTE,Chat::CHAT_TYPE_SHARE_SAFARI];
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
        if (($model = Chat::find()->where(['id'=>$id])->one()) !== null) {
            return $model;
        }
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }

    public function actionViewLeadDetails($chat_id)
    {      
        $model = $this->findModel($chat_id);
        $lead = $this->findLeadModel($model->lead_id);
       
        return $this->renderAjax('_view_lead_details', [
            'model' => $model,
            'lead' =>$lead,
        ]);
    }


    protected function findLeadModel($id)
    {
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->one()) !== null) {
            return $model;
        }
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
