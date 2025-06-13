<?php

namespace business\modules\leads\controllers;

use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use common\models\leads\LeadSearch;
use common\models\partnergallery\PartnerGallery;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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
                        'allow' => $this->isOwner(),
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
        $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams, \Yii::$app->user->identity->operator->id);
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
        $quotations = $model->getQuotation()->where(['partner_id' => \Yii::$app->user->identity->operator->id])->all();

        $chat = Chat::find()->where(['status' => 1, 'lead_id' => $id])->andwhere(['or', ['user_id' => \Yii::$app->user->identity->id], ['recipient_user_id' => \Yii::$app->user->identity->id]])->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->limit(1)->one();
        // if ($chat->chat_type == 2 && $chat->user_id == $this->userinfo->id) {
        //     Chat::MarkChatSeen($chat->id);
        // }

        return $this->render('view', [
            'model' => $model,
            'quotations' => $quotations,
            'chat' => $chat,
        ]);
    }

    public function actionQuotation($id)
    {

        $m = $this->findModel($id);
        $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => \Yii::$app->user->identity->operator->id])->one();
        // $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => 87])->one();
        $model = new LeadPartnerQuotationForm();
        $model->lead_id = $m->id;
        $model->park_id = $m->park_id;
        $model->lead_partner_id = $lead_partner->id;
        $model->partner_id = $lead_partner->partner_id;
        $model->action_url = '/leads/default/quotation?id=' . $id;
        $model->action_validate_url = '/leads/default/quotation-validate?id=' . $id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    if ($model->request(\Yii::$app->user->identity)) {
                        \Yii::$app->session->setFlash('success', 'Quotation Submitted Successfully');
                        return  $this->redirect(Yii::$app->request->referrer);
                    }
                } else {
                    return  $this->redirect(Yii::$app->request->referrer);
                }
            }
            return  $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_quotation_form', [
                'model' => $model,
                'lead' => $m,
            ]);
        }
    }

    public function actionQuotationValidate($id)
    {
        $m = $this->findModel($id);
        $model = new LeadPartnerQuotationForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }
    }

    protected function findModel($id)
    {
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->joinWith(['assignOperator' => function ($q) {
            $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => \Yii::$app->user->identity->operator->id]);
            // $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => 87]);
        }])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function isOwner()
    {
        $id = \Yii::$app->request->get('id');
        if (!empty($id)) {
            return Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->joinWith(['assignOperator' => function ($q) {
                $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => \Yii::$app->user->identity->operator->id]);
                // $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => 87]);
            }])->exists();
        }
        return false;
    }

    public function actionLeadChatList($id)
    {
        $model = $this->findModel($id);
        $chat = Chat::find()->where(['status' => 1, 'lead_id' => $id])->andwhere(['or', ['user_id' => \Yii::$app->user->identity->operator->id], ['recipient_user_id' => \Yii::$app->user->identity->operator->id]])->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->limit(1)->one();

        if (!$chat) {
            \Yii::$app->session->setFlash('danger', 'Chat Not Found!!!');
            return $this->redirect(Yii::$app->request->referrer);
        }

        // if ($chat->chat_type == 2 && $chat->user_id == $this->userinfo->id) {
        //     Chat::MarkChatSeen($chat->id);
        // }

        $dataProvider = new ActiveDataProvider([
            'query' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderBy(['created_at' => SORT_ASC]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->render(
            '_chat',
            [
                'model' => $model,
                'chat' => $chat,
                'dataProvider' => $dataProvider,
            ]
        );
    }


    public function actionSendMessage($user_handle, $chat_hash)
    {
        $login_user = $this->userinfo;
        $individual_user = $this->individualuser($user_handle);

        if (!empty($chat_hash)) {
            $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
        }

        $message = Yii::$app->request->post('message') ?? null;
        $gallery  = NULL;
        if (empty($message) && empty($gallery_slug)) {
            return Yii::$app->api->sendResponse([], ['message' => 'Message is required'], 400);
        }
        if (!empty($gallery_slug)) {
            $message = "Gallery";
            $partnerGallery = PartnerGallery::find()->where(['slug' => $gallery_slug])->one();
            if ($partnerGallery) {
                $gallery = $partnerGallery->live_images;
            }
        }

        return $this->storeMessage($chat_model->id, $this->userinfo->id, $message, $gallery, $data = NULL, $login_user);
    }


    private function storeMessage($chat_id, $user_id, $message, $gallery, $data = null, $login_user)
    {

        $chat = Chat::find()->andWhere(['id' => $chat_id])->one();

        if (is_array($data)) {
            $data = json_encode($data);
        }
        $chat = Chat::find()->where(['id' => $chat_id])->limit(1)->one();

        if ($login_user->partner) {
            if ($chat->chat_type == 2) {
                Chat::markChatStarted($chat, $login_user->partner->id);
            }
        }


        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_id;
        $chat_message->message = $message;
        $chat_message->gallery = $gallery;
        $chat_message->data = $data;
        $chat_message->status = 1;
        $chat_message->created_by = $this->userinfo->id;

        if ($chat_message->save(false)) {
            $chat = Chat::find()->where(['id' => $chat_id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxWord($message);
            $chat->last_message_at = time();
            $chat->sender_id = $this->userinfo->id;
            $chat->call_id = null;
            $chat->is_call_request = false;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            $chat->save(false);
            return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Message Send", 'chat_hash' => $chat->chat_hash]);
        } else {
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Message not sent"]);
        }
    }
}
