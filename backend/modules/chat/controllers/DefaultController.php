<?php

namespace backend\modules\leads\controllers;

use api\models\chat\Chat as ApiChat;
use common\models\chat\Chat;
use api\models\chat\ChatMessage;
use common\models\GeneralModel;
use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadAssignForm;
use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use common\models\leads\LeadSearch;
use common\models\operator\SafariOperator;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends  Controller
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
        $searchModel = new LeadSearch();
        $searchModel->status = Lead::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams, 87);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $quotations = $model->quotation;
        return $this->render('view', [
            'model' => $model,
            'quotations' => $quotations,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

   
    public function actionSendNotification($chat_hash)
    {
        if (Yii::$app->request->isPost) {
            $chat = Chat::find()->where(['chat_hash' => $chat_hash])->one();
            $reciverId = $chat->user_id;
            $sender_user_id = $chat->recipient_user_id;
            $sender_user_handle = User::find()->where(['id' => $sender_user_id])->one();
            $safari_operator_model = SafariOperator::find()->where(['user_id' => $sender_user_id])->one();
            $message = Yii::$app->request->post('message');

            if (empty($message)) {
                Yii::$app->session->setFlash('error', 'Message cannot be empty.');
                return $this->redirect(Yii::$app->request->referrer);
            }
            new \common\events\systemnotification\LeadChatMessageNotification([$reciverId], $safari_operator_model->business_name, $sender_user_handle->user_handle, \common\models\GeneralModel::strMaxWord($message), $chat->chat_hash, $chat);
            Yii::$app->session->setFlash('success', 'Notification sent successfully.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('_notification_form');
    }

}
