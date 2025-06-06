<?php

namespace api\modules\chat\controllers;

use api\behaviours\Apiauth;
use Yii;
use api\models\User;
use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\chat\ChatSearch;
use api\models\package\Package;
use api\models\park\SafariPark;
use api\models\MailLog;
use api\models\GeneralModel;
use api\controllers\RestController;
use yii\filters\AccessControl;
use api\behaviours\Verbcheck;
use api\models\leads\Lead;
use api\models\leads\LeadPartners;
use api\models\operator\SafariOperator;
use api\models\partnergallery\PartnerGallery;
use api\models\partnergalleryimage\PartnerGalleryImage;
use api\models\partnergalleryimage\PartnerGalleryImageSearch;
use api\models\sales\SalesQuote;
use common\models\GeneralModel as ModelsGeneralModel;
use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\MailLog as ModelsMailLog;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `chat` module
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
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'direct-user-chat', 'quatation-chat', 'operator-list', 'user-list', 'send', 'quotations', 'messages', 'send-message', 'send-quote-message', 'chat-user-list', 'gallery-images', 'profile-chat', 'make-call'],
                'rules' => [
                    [
                        'actions' => ['index', 'direct-user-chat', 'quatation-chat', 'operator-list', 'user-list', 'send', 'quotations', 'messages', 'send-message', 'send-quote-message', 'chat-user-list', 'gallery-images', 'profile-chat', 'make-call'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'direct-user-chat' => ['GET'],
                    'quotation-chat' => ['GET'],
                    'quotations' => ['GET'],
                    'chat-user-list' => ['GET'],
                    'operator-list' => ['GET'],
                    'user-list' => ['GET'],
                    'send' => ['POST'],
                    'send-message' => ['POST'],
                    'messages' => ['GET'],
                    'gallery-images' => ['GET'],
                    'profile-chat' => ['GET'],
                    'make-call' => ['POST'],
                ],
            ],
        ];
    }



    public function actionDirectUserChat()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Chat::find()->where(['status' => 1])->andwhere('user_id =' . $this->userinfo->id . ' OR recipient_user_id=' . $this->userinfo->id)->andWhere(['chat_type' => 1]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "chats");
    }

    public function actionQuatationChat()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Chat::find()->where(['status' => 1])->andwhere('user_id =' . $this->userinfo->id . ' OR recipient_user_id=' . $this->userinfo->id)->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "quotations");
    }

    public function actionQuotations()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Chat::find()->where(['status' => 1])->andwhere('user_id =' . $this->userinfo->id . ' OR recipient_user_id=' . $this->userinfo->id)->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "quotations");
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionOperatorList()
    {
        $searchModel = new ChatSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->dataProviderSender($searchModel, $rootIndexName = "operators");
    }

    public function actionUserList()
    {
        $searchModel = new ChatSearch();
        return $this->dataProviderSender($searchModel, $rootIndexName = "contcats", $additionalSearchQueryParams = [$this->userinfo->id], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "directchatcontcatsearch");
    }

    public function actionMessages($chat_hash)
    {
        $chat = Chat::find()->where(['chat_hash' => $chat_hash])->andWhere(['or', ['user_id' => $this->userinfo->id], ['recipient_user_id' => $this->userinfo->id]])->one();
        if (!$chat) {
            return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
        }
        if ($chat->chat_type == 1 && $chat->sender_id != $this->userinfo->id) {
            Chat::MarkChatSeen($chat->id);
        }
        if ($chat->chat_type == 2 && $chat->user_id == $this->userinfo->id) {
            Chat::MarkChatSeen($chat->id);
        }
        // $dataProvider = new ActiveDataProvider([
        //     'query' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderby(['last_message_at' => SORT_DESC]),
        //     'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        // ]);

        $dataProvider = new ActiveDataProvider([
            'query' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderBy(['created_at' => SORT_ASC]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            // 'pagination' => [
            //     'pageSize' => 5, // Adjust the page size as needed
            //     'page' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->count() / 10 - 1, // Calculate the last page
            // ],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "chat_messages", $singleRecord = false,  $in_reverse = true);
    }



    public function actionSendMessage($user_handle, $chat_hash = NULL)
    {
        $login_user = $this->userinfo;
        $individual_user = $this->individualuser($user_handle);
        if (!$individual_user) {
            // return Yii::$app->api->sendFailedResponse([], 'User not found', 400);
            return Yii::$app->api->sendResponse([], ['message' => 'User not found'], 400);
        }

        if (!empty($chat_hash)) {

            // $chat_model = Chat::find()->andWhere(['or', ['user_id' => [$individual_user->id, $this->userinfo->id]], ['recipient_user_id' => [$individual_user->id, $this->userinfo->id]]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
            $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
            if (empty($chat_model)) {
                return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
            }
        } else {
            $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_type' => 1])->one();
        }

        if (!$chat_model) {
            $chat_model = new Chat();
            $chat_model->generateChatHash();
            $chat_model->user_id = $this->userinfo->id;
            $chat_model->recipient_user_id = $individual_user->id;
            $chat_model->last_message = '';
            $chat_model->last_message_at = time();
            $chat_model->sender_id = $this->userinfo->id;
            $chat_model->status = 1;
            $chat_model->is_seen = 0;
            $chat_model->chat_type = 1;
            $chat_model->created_at = time();
            $chat_model->created_by = $this->userinfo->id;
            $chat_model->updated_at = time();
            $chat_model->updated_by = $this->userinfo->id;
            $chat_model->save(false);
        }

        $message = Yii::$app->request->post('message');
        $gallery_url = Yii::$app->request->post('gallery_url') ?? null;
        if ($message == '' && empty($gallery_url)) {
            return Yii::$app->api->sendResponse([], ['message' => 'Message is required'], 400);
        }
        if (!empty($gallery_url)) {
            $message = "Gallery";
        }

        return $this->storeMessage($chat_model->id, $this->userinfo->id, $message, $gallery_url, $data = NULL, $login_user);
    }

    private function storeMessage($chat_id, $user_id, $message, $gallery_url, $data = null, $login_user)
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
        $chat_message->gallery_url = $gallery_url;
        $chat_message->data = $data;
        $chat_message->status = 1;
        $chat_message->created_by = $this->userinfo->id;

        if ($chat_message->save(false)) {
            $chat = Chat::find()->where(['id' => $chat_id])->one();
            $chat->last_message = \common\models\GeneralModel::strMaxWord($message);
            $chat->last_message_at = time();
            $chat->sender_id = $this->userinfo->id;
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            $chat->save(false);
            return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Message Send", 'chat_hash' => $chat->chat_hash]);
        } else {
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Message not sent"]);
        }
    }


    /**
     * Induvidual User Model
     */
    protected function individualuser($user_handle)
    {
        return User::find()->where(['user_handle' => $user_handle])->andWhere(['!=', 'id', $this->userinfo->id])->limit(1)->one();
    }

    // public function actionSendQuoteMessage($user_handle)
    // {

    //     $individual_user = $this->individualuser($user_handle);
    //     if (!$individual_user) {
    //         return Yii::$app->api->sendFailedResponse([], 'User not found', 400);
    //     }
    //     $chat_model = Chat::find()->andWhere(['or', ['user_id' => [$individual_user->id, $this->userinfo->id]], ['recipient_user_id' => [$individual_user->id, $this->userinfo->id]]])->andWhere(['chat_type' => 2])->one();
    //     if (!$chat_model) {
    //         return Yii::$app->api->sendFailedResponse([], 'you can not send quote on this chat', 400);
    //     }
    //     $model = new SalesQuote();
    //     $model->load(\Yii::$app->request->post());
    //     $model->setAttributes(\Yii::$app->request->post());
    //     $model->quotation_id = $chat_model->quote_id;
    //     if (!empty($chat_model->package_id)) {
    //         $model->is_package_quote = 1;
    //     }
    //     if (!empty($chat_model->park_id)) {
    //         $model->is_operator_quote = 1;
    //     }
    //     $model->chat_id = $chat_model->id;
    //     $model->generateHash();
    //     $model->payment_link = "https://www.walkintothewild.in/payment/quote/" . $model->hash;

    //     if ($model->validate()) {
    //         if ($model->save()) {
    //             // $message = "Park: " . @$chat_model->park->title;
    //             // $message .= "<br>";
    //             $this->expirePaymentLink($chat_model->id);
    //             $message = "Safaris: " . $model->safari;
    //             $message .= "<br>";
    //             $message .= "Travelers: " . $model->travelers;
    //             $message .= "<br>";
    //             $message .= "Stay Category: " . @\common\models\GeneralModel::staycategoryoption()[$model->stay_category_id];
    //             $message .= "<br>";
    //             $message .= "Start Date: " . date('M d, Y', strtotime($model->start_date));
    //             $message .= "<br>";
    //             $message .= "End Date: " . date('M d, Y', strtotime($model->end_date));
    //             $message .= "<br>";
    //             $message .= "<b>Note</b>";
    //             $message .= "<br>";
    //             $message .= $model->additional_notes;
    //             $data = [
    //                 'id' => $model->id,
    //                 'quote_hash' => $model->hash,
    //                 'final_quote' => $model->final_quote,
    //                 // 'quote_price_max' => $model->quote_price_max,
    //                 'is_package_quote' => $model->is_package_quote,
    //                 'is_operator_quote' => $model->is_operator_quote,
    //                 'quotation_id' => $model->quotation_id,
    //                 'safari' => $model->safari,
    //                 'payment_link' => $model->payment_link,
    //                 'travelers' => $model->travelers,
    //                 'stay_category_id' => $model->stay_category_id,
    //                 'stay_category' => @\common\models\GeneralModel::staycategoryoption()[$model->travelers],
    //                 'start_date' => $model->start_date,
    //                 'end_date' => $model->end_date,
    //                 'additional_notes' => $model->additional_notes,
    //             ];

    //             // $this->storeMessage($chat_model->id, $this->userinfo->id, $message, $data);
    //             $chat_message = new ChatMessage();
    //             $chat_message->chat_id = $chat_model->id;
    //             $chat_message->message = $message;
    //             $chat_message->data = json_encode($data);
    //             $chat_message->status = 1;
    //             $chat_message->created_by = $this->userinfo->id;

    //             if ($chat_message->save(false)) {
    //                 $chat = Chat::find()->where(['id' => $chat_model->id])->one();
    //                 $chat->last_message = $message;
    //                 $chat->last_message_at = time();
    //                 $chat->status = 1;
    //                 $chat->is_seen = 0;
    //                 $chat->created_at = time();
    //                 $chat->save(false);
    //                 return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "message sent successfully"]);
    //             }
    //             return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Quote Send successfully"]);
    //         }
    //         return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Quote not Send successfully"]);
    //     }

    //     return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    // }

    public function actionSendQuoteMessage($lead_id)
    {
        $partner = SafariOperator::find()->where(['user_id' => $this->userinfo->id])->one();

        $m = $this->findLeadModel($lead_id, $partner);
        $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => $partner->id])->one();
        // $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => 87])->one();
        $model = new LeadPartnerQuotationForm();
        $model->attributes = $this->request;
        $model->lead_id = $m->id;
        $model->lead_partner_id = $lead_partner->id;
        $model->partner_id = $lead_partner->partner_id;

        if ($model->validate()) {

            if ($model->request($this->userinfo)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Quatation Send for approval to admin"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);

        // return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Message not Send"]);
    }

    protected function findLeadModel($id, $partner)
    {

        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->joinWith(['assignOperator' => function ($q) use ($partner) {
            $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => $partner->id]);
            // $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => 87]);
        }])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    private function expirePaymentLink($chat_id)
    {
        $model = SalesQuote::find()->where(['chat_id' => $chat_id])->one();
        if ($model) {
            $model->status = 0;
            $model->save(false);
        }
    }

    public function actionGalleryImages($slug)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->status = PartnerGalleryImage::STATUS_ACTIVE;
        $searchModel->partner_gallery_id = $partner_gallery_model->id;

        return $this->dataProviderSender($searchModel, $rootIndexName = "partner_gallery_images");
    }

    public function actionProfileChat($user_handle)
    {
        $individual_user = $this->individualuser($user_handle);
        if (!$individual_user) {
            return Yii::$app->api->sendResponse([], ['message' => 'User not found'], 400);
        }

        $chat = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_type' => 1])->one();
        if (!$chat) {
            return Yii::$app->api->sendResponse($data = ['status' => 0,], ['message' => 'Chat Not Found!!!'], 400);
        }


        return Yii::$app->api->sendResponse($data = ['status' => 1, 'chat_hash' => $chat->chat_hash], ['message' => 'Chat Found!!!']);
    }

    // public function actionMakeCall($user_handle, $chat_hash)
    public function actionMakeCall()
    {

        // $login_user = $this->userinfo;
        // $individual_user = $this->individualuser($user_handle);
        // if (!$individual_user) {
        //     // return Yii::$app->api->sendFailedResponse([], 'User not found', 400);
        //     return Yii::$app->api->sendResponse([], ['message' => 'User not found'], 400);
        // }

        // if (!empty($chat_hash)) {

        //     // $chat_model = Chat::find()->andWhere(['or', ['user_id' => [$individual_user->id, $this->userinfo->id]], ['recipient_user_id' => [$individual_user->id, $this->userinfo->id]]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
        //     $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
        //     if (empty($chat_model)) {
        //         return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
        //     }
        // } else {
        //     return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
        // };

        // if ($chat_model->chat_type == Chat::CHAT_TYPE_DIRECT) {
        //     return Yii::$app->api->sendResponse([], ['message' => 'You can not perform this action'], 403);
        // }

        // Example parameters
        $chat_id = '84';
        $lead_id = '16';
        $operator_user_id = 2015; // Example operator user ID
        $call_initiated_user_id = 2015; // Example user ID who initiated the call
        $call_initiated_partner_id = 3; // can be null
        $request_caller_1_no = '9958858979';
        $request_caller_1_user_id = 2014;
        $request_caller_2_no = 9650901148; // Optional
        $request_caller_2_user_id = 2015; // Optional

        // Instantiate the CallingService
        $callingService = new \common\calling\services\CallingService(
            $chat_id,
            $lead_id,
            $operator_user_id,
            $call_initiated_user_id,
            $call_initiated_partner_id,
            $request_caller_1_no,
            $request_caller_1_user_id,
            // $request_caller_2_no,
            // $request_caller_2_user_id
        );


        // Call the callNow method
        $result = $callingService->callNow();

        // Handle the result
        if ($result) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Call initiated successfully.']);
        } else {
            return Yii::$app->api->sendResponse($data = ['status' => 0,], ['message' => 'Failed to initiate the call.']);
        }
    }


    public function actionMakeCallOnChat($user_handle, $chat_hash)
    {

        $login_user = $this->userinfo;
        $individual_user = $this->individualuser($user_handle);
        if (!$individual_user) {
            // return Yii::$app->api->sendFailedResponse([], 'User not found', 400);
            return Yii::$app->api->sendResponse([], ['message' => 'User not found'], 400);
        }

        if (!empty($chat_hash)) {

            // $chat_model = Chat::find()->andWhere(['or', ['user_id' => [$individual_user->id, $this->userinfo->id]], ['recipient_user_id' => [$individual_user->id, $this->userinfo->id]]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
            $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
            if (empty($chat_model)) {
                return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
            }
        } else {
            return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
        };

        if ($chat_model->chat_type == Chat::CHAT_TYPE_DIRECT) {
            return Yii::$app->api->sendResponse([], ['message' => 'You can not perform this action'], 403);
        }

        // if user is normal user then he only raise call request
        if ($chat_model->user_id == $this->userinfo->id) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // $message = "Call Request raised by " . $this->userinfo->name;
                $message = "Call Request raised";
                $chat_message = new ChatMessage();
                $chat_message->chat_id = $chat_model->id;
                $chat_message->message = $message;
                $chat_message->is_call_request = true;
                $chat_message->status = 1;
                $chat_message->sender_id = $this->userinfo->id;

                if ($chat_message->save(false)) {

                    $chat = Chat::find()->where(['id' => $chat_model->id])->one();
                    $chat->last_message = \common\models\GeneralModel::strMaxlength($message);
                    $chat->last_message_at = time();
                    $chat_message->is_call_request = true;
                    $chat->sender_id = $this->userinfo->id;
                    $chat->status = 1;
                    $chat->is_seen = 0;
                    $chat->created_at = time();
                    $chat->save(false);
                    $transaction->commit();
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Call request raised successfully.']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return Yii::$app->api->sendResponse([], ['message' => 'Failed to initiate the call.'], 400);
            }
        } else {
            // Example parameters
            $transaction = Yii::$app->db->beginTransaction();
            try {

                if(!$chat_model->user->is_mobile_no_verified){
                    return Yii::$app->api->sendResponse([], ['message' => 'User number is not verified.'], 403);
                }

                $chat_id = $chat_model->id;
                $lead_id = $chat_model->lead_id;
                $call_initiated_user_id = $this->userinfo->id; // Example user ID who initiated the call
                $operator_user_id =  $this->userinfo->id; // Example operator user ID
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
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Call initiated successfully.']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return Yii::$app->api->sendResponse($data = ['status' => 0,], ['message' => 'Failed to initiate the call.']);
            }
        }
    }
}
