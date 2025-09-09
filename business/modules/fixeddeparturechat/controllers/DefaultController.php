<?php

namespace business\modules\fixeddeparturechat\controllers;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\chat\ChatSearch;
use api\models\partnergallery\PartnerGallery;
use api\models\partnergallery\PartnerGallerySearch;
use common\models\chat\form\ChatForm;
use common\models\chat\form\GalleryChatForm;
use common\models\partnergallery\PartnerGalleryVersion;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `fixeddeparturechat` module
 */
class DefaultController extends  Controller
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
                        'actions' => ['index', 'view'],
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
        $safari_operator = $this->module->operatormodel();
        $searchModel = new ChatSearch();
        $searchModel->chat_type = Chat::CHAT_TYPE_SHARE_SAFARI;
        $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams, \Yii::$app->user->identity->operator->user_id);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'safari_operator' => $safari_operator,
            ]
        );
    }

    public function actionView($id)
    {
        $chat_model = Chat::find()->where(['id' => $id])->andWhere(['chat_type' => Chat::CHAT_TYPE_SHARE_SAFARI])->limit(1)->one();
        if ($chat_model->chat_type == Chat::CHAT_TYPE_SHARE_SAFARI && $chat_model->recipient_user_id == Yii::$app->user->identity->id) {
            Chat::MarkChatSeen($chat_model->id);
        }

        $chat_message_model = new ChatForm();
        if ($this->request->isPost) {
            if ($chat_message_model->load($this->request->post())) {
                if ($chat_message_model->validate()) {
                    $chat_message_model->initializeForm();
                    $this->storeMessage($chat_model->id, Yii::$app->user->identity->id, $chat_message_model->chat_form_model->message, $gallery = NULL, $data = NULL, Yii::$app->user->identity, $partner_gallery_version_id = NULL, $partner_gallery_version = NULL);
                    $chat_message_model->message = '';
                }
            }
        }

        return $this->render('view', [
            'chat_model' => $chat_model,
            'chat_message_model' => $chat_message_model,
        ]);
    }


    private function storeMessage($chat_id, $user_id, $message, $gallery, $data = null, $login_user, $partner_gallery_version_id, $partner_gallery_version)
    {

        $chat = Chat::find()->andWhere(['id' => $chat_id])->limit(1)->one();

        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_id;
        $chat_message->message = $message;
        $chat_message->partner_gallery_version_id = $partner_gallery_version_id;
        $chat_message->partner_gallery_version = isset($partner_gallery_version->version) ? $partner_gallery_version->version : null;
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

        $chat_model = Chat::find()->where(['id' => $id])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => Chat::CHAT_TYPE_SHARE_SAFARI])->limit(1)->one();


        if ($chat_model->operator->is_phone_no_verified == 0 || empty($chat_model->operator->phone_no) || $chat_model->user->is_mobile_no_verified == 0 || empty($chat_model->user->mobile_no)) {
            \Yii::$app->session->setFlash('danger', 'You cannot perform this action, as phone is not available or verified for any of the chat members');
            return $this->redirect(['view', 'id' => $id]);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if (!$chat_model->user->is_mobile_no_verified) {
                \Yii::$app->session->setFlash('danger', 'User number is not verified.');
                return $this->redirect(['view', 'id' => $id]);
            }


            $chat_id = $chat_model->id;
            $lead_id = $chat_model->lead_id;
            $call_initiated_user_id = Yii::$app->user->identity->id;
            $operator_user_id =  Yii::$app->user->identity->id;
            $call_initiated_partner_id = $chat_model->operator->id;
            $request_caller_1_no = $chat_model->user->mobile_no;
            $request_caller_1_user_id = $chat_model->user->id;
            $request_caller_2_no = $chat_model->operator->phone_no;
            $request_caller_2_user_id = $chat_model->operator->user_id;

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


    public function actionSendGallery($id)
    {

        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        $searchModel->listing_status = 1;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $chat = Chat::find()->where(['id' => $id])->andWhere(['chat_type' => Chat::CHAT_TYPE_SHARE_SAFARI])->limit(1)->one();
        if ($chat->chat_type == Chat::CHAT_TYPE_SHARE_SAFARI && $chat->user_id == Yii::$app->user->identity->id) {
            Chat::MarkChatSeen($chat->id);
        }

        $gallery_selection_model = new GalleryChatForm();
        if ($this->request->isPost) {
            if ($gallery_selection_model->load($this->request->post())) {
                if ($gallery_selection_model->validate()) {
                    if (!empty($gallery_selection_model->gallery_slug)) {
                        $message = "Gallery";
                        $partnerGallery = PartnerGallery::find()->where(['slug' => $gallery_selection_model->gallery_slug])->one();
                        if ($partnerGallery) {
                            $partner_gallery_version = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $partnerGallery->id])->andWhere(['version' => $partnerGallery->version])->limit(1)->one();
                            $gallery = $partnerGallery->live_images;
                        }
                        $this->storeMessage($chat->id, Yii::$app->user->identity->id, $message, $gallery, $data = NULL, Yii::$app->user->identity, $partner_gallery_version->id, $partner_gallery_version);
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
            }
        }

        return $this->renderAjax('_gallery_selection', [
            'chat' => $chat,
            'gallery_selection_model' => $gallery_selection_model,
            'dataProvider' => $dataProvider
        ]);
    }
}
