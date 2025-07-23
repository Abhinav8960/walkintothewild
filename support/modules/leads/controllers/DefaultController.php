<?php

namespace support\modules\leads\controllers;

use api\models\chat\Chat as ApiChat;
use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\partnergallery\PartnerGallerySearch;
use common\models\chat\form\ChatForm;
use common\models\chat\form\GalleryChatForm;
use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use common\models\leads\LeadSearch;
use common\models\operator\SafariOperator;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGalleryVersion;
use common\models\User;
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
                        // 'allow' => $this->isOwner(),
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
        // $safari_operator = $this->module->operatormodel();
        $searchModel = new LeadSearch();
        $searchModel->custom_status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams, \Yii::$app->user->identity->operator->id);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                // 'safari_operator' => $safari_operator,
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
    public function actionPartnerLeadChat($id, $safari_operator_id)
    {
        $model = $this->findModel($id);
        $quotations = $model->quotation;
        $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
        $chat = ApiChat::find()->where(['lead_id' => $id])->andwhere(['or', ['user_id' => $safari_operator_model->user_id], ['recipient_user_id' => $safari_operator_model->user_id]])->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->limit(1)->one();

        return $this->render(
            'view',
            [
                'model' => $model,
                'quotations' => $quotations,
                'chat' => $chat,
                'safari_operator_model' => $safari_operator_model,
            ]
        );
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
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->one()) !== null) {
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


    public function actionSendGallery($id)
    {
        $model = $this->findModel($id);
        /**Gallery Section*/
        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        // $searchModel->status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->is_live = 1;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['not', ['live_images' => null]]);

        /**Chat Section*/
        $chat = Chat::find()->where(['status' => 1, 'lead_id' => $id])->andwhere(['or', ['user_id' => \Yii::$app->user->identity->id], ['recipient_user_id' => \Yii::$app->user->identity->id]])->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->limit(1)->one();
        if ($chat->chat_type == 2 && $chat->user_id == Yii::$app->user->identity->id) {
            Chat::MarkChatSeen($chat->id);
        }
        $chat_model = Chat::find()->andWhere(['or', ['user_id' => Yii::$app->user->identity->id, 'recipient_user_id' => $model->user_id], ['user_id' => $model->user_id, 'recipient_user_id' => Yii::$app->user->identity->id]])->andWhere(['chat_hash' => $chat->chat_hash, 'chat_type' => 2])->one();
        $gallery_selection_model = new GalleryChatForm();
        if ($this->request->isPost) {
            if ($gallery_selection_model->load($this->request->post())) {
                if ($gallery_selection_model->validate()) {
                    if (!empty($gallery_selection_model->gallery_slug)) {
                        $message = "Gallery";
                        $partnerGallery = PartnerGallery::find()->where(['slug' => $gallery_selection_model->gallery_slug])->one();
                        if ($partnerGallery) {
                            $partner_gallery_version = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $partnerGallery->id])->andWhere(['is_live' => 1])->limit(1)->one();
                            $gallery = $partnerGallery->live_images;
                        }
                        $this->storeMessage($chat_model->id, Yii::$app->user->identity->id, $message, $gallery, $data = NULL, Yii::$app->user->identity, $partner_gallery_version->id);
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
            }
        }

        return $this->renderAjax('_gallery_selection', [
            'model' => $model,
            'chat' => $chat,
            'gallery_selection_model' => $gallery_selection_model,
            'dataProvider' => $dataProvider
        ]);
    }

    private function storeMessage($chat_id, $user_id, $message, $gallery, $data = null, $login_user, $partner_gallery_version_id)
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
        $chat_message->partner_gallery_version_id = $partner_gallery_version_id;
        $chat_message->gallery = $gallery;
        $chat_message->data = $data;
        $chat_message->status = 1;
        $chat_message->created_by = Yii::$app->user->identity->id;

        if ($chat_message->save(false)) {
            $chat = Chat::find()->where(['id' => $chat_id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxWord($message);
            $chat->last_message_at = time();
            $chat->sender_id = Yii::$app->user->identity->id;
            $chat->call_id = null;
            $chat->is_call_request = false;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            $chat->save(false);
            return  \Yii::$app->session->setFlash('success', 'Message Sent Successfully');
        } else {
            return  \Yii::$app->session->setFlash('success', 'Message not Sent Successfully');
        }
    }

    public function actionMakeCallOnChat($id, $chat_hash)
    {

        $model = $this->findModel($id);
        $chat_model = Chat::find()->andWhere(['or', ['user_id' => Yii::$app->user->identity->id, 'recipient_user_id' => $model->user_id], ['user_id' => $model->user_id, 'recipient_user_id' => Yii::$app->user->identity->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();


        if ($chat_model->operator->is_phone_no_verified == 0 || empty($chat_model->operator->phone_no) || $chat_model->user->is_mobile_no_verified == 0 || empty($chat_model->user->mobile_no)) {
            \Yii::$app->session->setFlash('danger', 'You cannot perform this action, as phone is not available or verified for any of the chat members');
            return $this->redirect(['view', 'id' => $id]);
        }

        // Example parameters
        $transaction = Yii::$app->db->beginTransaction();
        try {

            if (!$chat_model->user->is_mobile_no_verified) {
                \Yii::$app->session->setFlash('danger', 'User number is not verified.');
                return $this->redirect(['view', 'id' => $id]);
            }


            $chat_id = $chat_model->id;
            $lead_id = $chat_model->lead_id;
            $call_initiated_user_id = Yii::$app->user->identity->id; // Example user ID who initiated the call
            $operator_user_id =  Yii::$app->user->identity->id; // Example operator user ID
            $call_initiated_partner_id = $chat_model->operator->id; // can be null
            $request_caller_1_no = $chat_model->user->mobile_no;
            $request_caller_1_user_id = $chat_model->user->id;
            $request_caller_2_no = $chat_model->operator->phone_no; // Optional
            $request_caller_2_user_id = $chat_model->operator->user_id; // Optional


            // Instantiate the CallingService
            $callingService = new \common\calling\services\CallingService(
                $chat_id,
                $lead_id,
                $operator_user_id,
                $call_initiated_user_id,
                $call_initiated_partner_id,
                $request_caller_1_no,
                $request_caller_1_user_id,
                $request_caller_2_no,
                $request_caller_2_user_id
            );
            // Call the callNow method
            $result = $callingService->callNow();
            $transaction->commit();
            \Yii::$app->session->setFlash('success', 'Call initiated successfully.');
            return $this->redirect(['view', 'id' => $id]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::$app->session->setFlash('danger', 'Failed to initiate the call.');
            return $this->redirect(['view', 'id' => $id]);
        }
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
