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
use common\models\partnergallery\PartnerGalleryVersion;
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
                'only' => ['index', 'direct-user-chat', 'quatation-chat', 'operator-list', 'user-list', 'send', 'quotations', 'messages', 'send-message', 'send-quote-message', 'chat-user-list', 'gallery-images', 'profile-chat', 'make-call', 'edit-message', 'delete-message', 'make-call-on-chat'],
                'rules' => [
                    [
                        'actions' => ['index', 'direct-user-chat', 'quatation-chat', 'operator-list', 'user-list', 'send', 'quotations', 'messages', 'send-message', 'send-quote-message', 'chat-user-list', 'gallery-images', 'profile-chat', 'make-call', 'edit-message', 'delete-message', 'make-call-on-chat'],
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


    /**
     * Get Quotation Chat List or Operator List without chat hash
     *
     * @OA\Get(
     *     path="/chat/quatation-chat",
     *     tags={"Chat"},
     *     summary="Get Quotation Chat List or Operator List without chat hash",
     *     description = "Retrieves <b>the quotation chat list</b> without requiring a <b>chat hash</b>, including pagination, <b>last message</b> details, related <b>lead</b> information, and <b>boperator</b> profile data.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="chat_hash",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Quotation chat list retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="quotations",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=10),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=5),
     *                     @OA\Property(property="total_page", type="integer", example=2),
     *                     @OA\Property(property="query_params", type="array", @OA\Items(type="string"),example={})
     *                 ),
     *
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=3104),
     *                         @OA\Property(property="chat_hash", type="string", example="loYDnu1763451526SOu4-"),
     *                         @OA\Property(property="last_message", type="string", example="Hi, I am interested in \nPark: Anamalai Tiger Reserve\n"),
     *                         @OA\Property(property="last_message_datetime", type="integer", example=1763451526),
     *                         @OA\Property(property="chat_type", type="integer", example=2),
     *                         @OA\Property(property="is_seen", type="boolean", example=true),
     *
     *                         @OA\Property(
     *                             property="contact",
     *                             type="object",
     *                             @OA\Property(property="username", type="string", example="ankit.kankane.safaris@gmail.com"),
     *                             @OA\Property(property="name", type="string", example="ANKIT KANKANE SAFARIS"),
     *                             @OA\Property(property="email", type="string", example="ankit.kankane.safaris@gmail.com"),
     *                             @OA\Property(property="is_support_user", type="integer", example=0),
     *                             @OA\Property(property="is_safari_operator", type="boolean", example=true),
     *                             @OA\Property(property="is_account_manager", type="integer", example=0),
     *                             @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *                             @OA\Property(property="is_developer", type="integer", example=0),
     *                             @OA\Property(property="google_avatar_image", type="string", example="10_google_avatar.jpg"),
     *                             @OA\Property(property="user_handle", type="string", example="ankit_kankane_safaris"),
     *                             @OA\Property(property="gender", type="string", nullable=true,example=null),
     *                             @OA\Property(property="account_type", type="integer", example=3),
     *                             @OA\Property(property="gender_privacy", type="integer", example=1),
     *                             @OA\Property(property="email_privacy", type="integer", example=1),
     *                             @OA\Property(property="status", type="integer", example=10),
     *                             @OA\Property(property="profile_display_image", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/operator-registration/2025-05/10_logo_1751379931.jpg"),
     *                             @OA\Property(property="cover_display_image", type="string", nullable=true,example=null),
     *                             @OA\Property(property="display_name", type="string", example="Ankit Kankane Safaris"),
     *                             @OA\Property(property="is_followed", type="boolean", example=true),
     *                             @OA\Property(property="user_activity_count", type="integer", example=40),
     *                             @OA\Property(property="operator_slug", type="string", example="ankit-kankane-safaris"),
     *                             @OA\Property(property="user_followers_count", type="integer", example=304),
     *                             @OA\Property(property="user_followings_count", type="integer", example=2),
     *                             @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=false)
     *                         ),
     *
     *                         @OA\Property(
     *                             property="lead",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1255),
     *                             @OA\Property(property="source", type="integer", example=3),
     *                             @OA\Property(property="source_label", type="string", example="Operator"),
     *                             @OA\Property(property="name", type="string", example="Abhinav Pal"),
     *                             @OA\Property(property="email", type="string", example="abhinavpal8960@gmail.com"),
     *                             @OA\Property(property="phone", type="string", example="8960896089"),
     *                             @OA\Property(property="destination", type="string", nullable=true,example=null),
     *                             @OA\Property(property="from_date", type="string", example="2025-12-14"),
     *                             @OA\Property(property="to_date", type="string", example="2025-12-15"),
     *                             @OA\Property(property="travelers", type="integer", example=3),
     *
     *                             @OA\Property(
     *                                 property="staycatgory",
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=2),
     *                                 @OA\Property(property="title", type="string", example="Standard"),
     *                                 @OA\Property(property="min_range", type="integer", example=10000),
     *                                 @OA\Property(property="max_range", type="integer", example=50000)
     *                             ),
     *
     *                             @OA\Property(property="transport", type="string", nullable=true,example=null),
     *                             @OA\Property(property="user_notes", type="string", example="Buy me a coffee!!!"),
     *
     *                             @OA\Property(
     *                                 property="operator",
     *                                 type="object",
     *                                 @OA\Property(property="business_name", type="string", example="Ankit Kankane Safaris"),
     *                                 @OA\Property(property="phone_no", type="string", example="8319393633"),
     *                                 @OA\Property(property="email", type="string", example="ankit.kankane.safaris@gmail.com"),
     *                                 @OA\Property(property="operator_phone_no", type="string", example="8319393633"),
     *                                 @OA\Property(property="operator_email", type="string", example="ankit.kankane123@gmail.com"),
     *                                 @OA\Property(property="slug", type="string", example="ankit-kankane-safaris"),
     *                                 @OA\Property(property="register_comapany_name", type="string", example="Ankit Kankane Safaris"),
     *                                 @OA\Property(property="address", type="string", example="BANDHAVGARH NATIONAL PARK"),
     *                                 @OA\Property(property="google_rating", type="string", example="5"),
     *                                 @OA\Property(property="google_review_count", type="integer", example=5),
     *                                 @OA\Property(property="about_business", type="string", example="We are in safari tour operation business..."),
     *                                 @OA\Property(property="image_path", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/operator-registration/2025-05/10_logo_1751379931.jpg"),
     *                                 @OA\Property(property="park_count", type="integer", example=8),
     *                                 @OA\Property(property="package_count", type="integer", example=7),
     *                                 @OA\Property(property="shared_safari_count", type="integer", example=3),
     *                                 @OA\Property(property="follower_list_count", type="integer", example=304),
     *                                 @OA\Property(property="category_title", type="string", example="Safari Tour Operator"),
     *                                 @OA\Property(property="is_followed", type="boolean", example=true),
     *                                 @OA\Property(property="status", type="boolean", example=true),
     *                                 @OA\Property(property="has_direct_call", type="boolean", example=false),
     *                                 @OA\Property(property="direct_call_no", type="string", nullable=true , example=null),
     *                                 @OA\Property(
     *                                     property="review_url",
     *                                     type="object",
     *                                     @OA\Property(property="reviews", type="string", example="http://api.walkintothewild.io/operator/ankit-kankane-safaris/reviewlist?sort_by=highest")
     *                                 ),
     *                                 @OA\Property(property="show_lead_phone_number", type="boolean", example=false)
     *                             )
     *                         ),
     *
     *                         @OA\Property(property="is_call_request", type="boolean", example=false),
     *                         @OA\Property(property="call", type="string", nullable=true,example=null),
     *                         @OA\Property(property="can_call", type="boolean", example=true),
     *                         @OA\Property(property="is_closed", type="boolean", example=false),
     *                         @OA\Property(property="calling_no", type="string", nullable=true,example=null)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Access token not found")
     *         )
     *     ),
     * )
     */
    public function actionQuatationChat($chat_hash = null)
    {
        if (isset($this->userinfo->partner) && !empty($this->userinfo->partner)) {
            $query = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $this->userinfo->id . ' OR recipient_user_id=' . $this->userinfo->id)->andWhere(['chat_type' => [Chat::CHAT_TYPE_QUOTE, Chat::CHAT_TYPE_SHARE_SAFARI]])->orderby(['last_message_at' => SORT_DESC]);
        } else {
            $query = Chat::find()->where([
                'status' => 1,
                // 'is_lead_chat_open_for_user' => 1
            ])->andwhere('user_id =' . $this->userinfo->id . ' OR recipient_user_id=' . $this->userinfo->id)->andWhere(['chat_type' => [Chat::CHAT_TYPE_QUOTE, Chat::CHAT_TYPE_SHARE_SAFARI]])->orderby(['last_message_at' => SORT_DESC]);
        }

        if (!empty($chat_hash)) {
            $query = $query->andWhere(['chat_hash' => $chat_hash]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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


    /**
     * Get User List
     *
     * @OA\Get(
     *     path="/chat/user-list",
     *     tags={"Chat"},
     *     summary="Get chat user list",
     *     description = "This API is used to retrieve the chat user list.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Successful operation. Returns paginated quotation chat list.",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="contacts",
     *             type="object",
     *             @OA\Property(
     *                 property="summary",
     *                 type="object",
     *                 @OA\Property(property="total", type="integer", example=3),
     *                 @OA\Property(property="page", type="integer", example=1),
     *                 @OA\Property(property="pageSize", type="integer", example=5),
     *                 @OA\Property(property="total_page", type="integer", example=1),
     *                 @OA\Property(property="query_params",type="array",@OA\Items(type="string"),example={})
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=3083),
     *                     @OA\Property(property="chat_hash", type="string", example="lvo-371759815534PQpV3"),
     *                     @OA\Property(property="last_message", type="string", example="Hi, I am interested in\nPark: Dudhwa Tiger Reserve"),
     *                     @OA\Property(property="last_message_datetime", type="integer", example=1759815534),
     *                     @OA\Property(property="chat_type", type="integer", example=1),
     *                     @OA\Property(property="is_seen", type="boolean", example=true),
     *
     *                     @OA\Property(
     *                         property="contact",
     *                         type="object",
     *                         @OA\Property(property="username", type="string", example="info@bigwholidays.com"),
     *                         @OA\Property(property="name", type="string", example="Big W Holidays"),
     *                         @OA\Property(property="email", type="string", example="info@bigwholidays.com"),
     *                         @OA\Property(property="is_support_user", type="integer", example=0),
     *                         @OA\Property(property="is_safari_operator", type="boolean", example=true),
     *                         @OA\Property(property="is_account_manager", type="integer", example=0),
     *                         @OA\Property(property="is_blue_badge_verified", type="boolean", example=false),
     *                         @OA\Property(property="is_developer", type="integer", example=0),
     *                         @OA\Property(property="google_avatar_image", type="string", nullable=true, example=null),
     *                         @OA\Property(property="user_handle", type="string", example="big-w-holidays"),
     *                         @OA\Property(property="gender", type="string", nullable=true, example=null),
     *                         @OA\Property(property="account_type", type="integer", example=3),
     *                         @OA\Property(property="gender_privacy", type="integer", example=1),
     *                         @OA\Property(property="email_privacy", type="integer", example=1),
     *                         @OA\Property(property="status", type="integer", example=10),
     *                         @OA\Property(property="profile_display_image", type="string", example="https://d2oqzs36p95tb4.cloudfront.net/operator-registration/2506/4280_logo_1749314336.jpeg"),
     *                         @OA\Property(property="cover_display_image", type="string", nullable=true, example=null),
     *                         @OA\Property(property="display_name", type="string", example="Big W Holidays"),
     *                         @OA\Property(property="is_followed", type="boolean", example=false),
     *                         @OA\Property(property="user_activity_count", type="integer", example=0),
     *                         @OA\Property(property="operator_slug", type="string", example="big-w-holidays"),
     *                         @OA\Property(property="user_followers_count", type="integer", example=0),
     *                         @OA\Property(property="user_followings_count", type="integer", example=0),
     *                         @OA\Property(property="is_privacy_policy_acknowledged", type="boolean", example=false)
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Access token not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat Not Found!"
     *     )
     * )
     */

    public function actionUserList()
    {
        $searchModel = new ChatSearch();
        return $this->dataProviderSender($searchModel, $rootIndexName = "contcats", $additionalSearchQueryParams = [$this->userinfo->id], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "directchatcontcatsearch");
    }

    /**
     * Get Chat Messages
     *
     * @OA\Get(
     *     path="/chat/messages/{chat_hash}",
     *     tags={"Chat"},
     *     summary="Get Chat Messages",
     *     description = "Retrieve chat messages by providing the chat hash in the request parameters.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="chat_hash",
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="chat_messages",
     *                 type="object",
     *                 @OA\Property(
     *                     property="summary",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=1),
     *                     @OA\Property(property="page", type="integer", example=1),
     *                     @OA\Property(property="pageSize", type="integer", example=5),
     *                     @OA\Property(property="total_page", type="integer", example=1),
     *                     @OA\Property(property="query_params",type="array", @OA\Items(type="string"),example={})
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=8064),
     *                         @OA\Property(property="message", type="string", example="Hi, I am interested in \nPark: Anamalai Tiger Reserve\nSafaries: 5\nTravelers: 3\nAccommodation: Standard\nStart Date: Dec 14, 2025\nEnd Date: Dec 15, 2025\nNotes:Buy me a coffee!!!\n"),
     *                         @OA\Property(property="is_edited", type="boolean", example=false),
     *                         @OA\Property(property="is_deleted", type="boolean", example=false),
     *                         @OA\Property(property="is_system_generated", type="boolean", example=false),
     *                         @OA\Property(property="message_datetime", type="integer", example=1763451526),
     *                         @OA\Property(property="is_message_sent_by_you", type="boolean", example=true)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat not found")
     *         )
     *     ),
     * )
     */
    public function actionMessages($chat_hash)
    {
        $chat = Chat::find()->where(['chat_hash' => $chat_hash])->andWhere(['or', ['user_id' => $this->userinfo->id], ['recipient_user_id' => $this->userinfo->id]])->one();
        if (!$chat) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Chat']);
            return Yii::$app->api->sendResponse([], ['message' => $message], 400);
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
            // 'query' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderBy(['created_at' => SORT_ASC]),
            'query' => ChatMessage::find()->where(['chat_id' => $chat->id])->orderBy(['created_at' => SORT_ASC]),
            // 'query' => ChatMessage::find()->where(['chat_id' => $chat->id])->orderBy(['created_at' => SORT_ASC]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            // 'pagination' => [
            //     'pageSize' => 5, // Adjust the page size as needed
            //     'page' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->count() / 10 - 1, // Calculate the last page
            // ],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "chat_messages", $singleRecord = false, $in_reverse = true);
    }


    /**
     * Send Message
     *
     * Allows users to send a message in a chat.
     *
     * @OA\Post(
     *     path="/chat/send-message/{user_handle}",
     *     tags={"Chat"},
     *     summary="Send Message",
     *     description="Allows users to send a <b>message</b> and upload <b>gallery</b> items by providing the <b>gallery slug</b> in the request body within a chat.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user_handle",
     *         in="path",
     *         required=true,
     *         description="User Handle",
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="chat_hash",
     *         in="query",
     *         required=true,
     *         description="Unique hash identifier of the chat",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"message"},
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Message text to send",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="gallery_slug",
     *                     type="string",
     *                     description="Optional gallery slug if sending a media message",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message sent!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Message Sent!"),
     *             @OA\Property(property="chat_hash", type="string", example="loYDnu1763451526SOu4-")
     *         )
     *     ),
    *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat not found")
     *         )
     *     )
     * )
     */
    public function actionSendMessage($user_handle, $chat_hash = null)
    {
        $login_user = $this->userinfo;
        $individual_user = $this->individualuser($user_handle);
        if (!$individual_user) {
            // return Yii::$app->api->sendFailedResponse([], 'User not found', 400);
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'User']);
            return Yii::$app->api->sendResponse([], ['message' => $message], 400);
        }

        if (!empty($chat_hash)) {
            // $chat_model = Chat::find()->andWhere(['or', ['user_id' => [$individual_user->id, $this->userinfo->id]], ['recipient_user_id' => [$individual_user->id, $this->userinfo->id]]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
            $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => [2, 3]])->one();
            if (empty($chat_model)) {
                $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Chat']);
                return Yii::$app->api->sendResponse([], ['message' => $message], 400);
            }
            // if ($chat_model->is_closed == 1) {
            //     return Yii::$app->api->sendResponse([], ['message' => 'Chat is closed, you can not reply'], 400);
            // }
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
            $chat_model->call_id = null;
            $chat_model->is_call_request = false;
            $chat_model->status = 1;
            $chat_model->is_seen = 0;
            $chat_model->chat_type = 1;
            $chat_model->created_at = time();
            $chat_model->created_by = $this->userinfo->id;
            $chat_model->updated_at = time();
            $chat_model->updated_by = $this->userinfo->id;
            $chat_model->save(false);
        }



        $message = Yii::$app->request->post('message') ?? null;
        $gallery_slug = Yii::$app->request->post('gallery_slug') ?? null;
        $gallery = null;
        $partner_gallery_version_id = null;
        $partner_gallery_version = null;
        if (empty($message) && empty($gallery_slug)) {
            $message = Yii::$app->api->messageManager->getMessage('common.message_required');
            return Yii::$app->api->sendResponse([], ['message' => $message], 400);
        }
        if (!empty($gallery_slug)) {
            $message = "Gallery";
            $this->layout = PartnerGallery::PARTNER_GALLERY_API_LAYOUT_FULL;
            $partnerGallery = PartnerGallery::find()->where(['slug' => $gallery_slug])->one();
            if ($partnerGallery) {
                // Safely call toArray() if $gallery is not null
                //  $gallery = json_encode($partnerGallery->PrepareFullResponse());
                $partner_gallery_version = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $partnerGallery->id])->andWhere(['version' => $partnerGallery->version])->limit(1)->one();
                $partner_gallery_version_id = $partner_gallery_version->id;
                $partner_gallery_version = $partnerGallery->version;
                $gallery = $partnerGallery->live_images;
            }
        }

        return $this->storeMessage($chat_model->id, $this->userinfo->id, $message, $gallery, $data = null, $login_user, $partner_gallery_version_id, $partner_gallery_version);
    }

    private function storeMessage($chat_id, $user_id, $message, $gallery, $data = null, $login_user, $partner_gallery_version_id, $partner_gallery_version)
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
        $chat_message->partner_gallery_version_id = $partner_gallery_version_id ?? null;
        $chat_message->partner_gallery_version = $partner_gallery_version ?? null;
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

            // is_lead_chat_open_for_user
            if ($chat->chat_type == Chat::CHAT_TYPE_QUOTE && $chat->recipient_user_id == $this->userinfo->id) {
                $chat->is_lead_chat_open_for_user = 1;
            }


            $chat->is_seen = 0;
            $chat->created_at = time();
            $chat->save(false);
            $message = Yii::$app->api->messageManager->getMessage('common.message_send');
            return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message, 'chat_hash' => $chat->chat_hash]);
        } else {
            $message = Yii::$app->api->messageManager->getMessage('common.message_not_sent');
            return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
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


    /**
     * Send Quote
     *
     * Allows operator to send quote
     *
     * @OA\Post(
     *     path="/chat/send-quote-message/{lead_id}",
     *     tags={"Manage"},
     *     summary="Send Quote (Draft)",
     *     description="Allows Operator to Send Quote.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="lead_id",
     *         in="path",
     *         required=true,
     *         description="Id of lead",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"safaris","travelers","stay_category_id","partner_selling_price","park_id","addional_notes","start_date","end_date","validity_date","permit_booking_date"},
     *                 @OA\Property(
     *                     property="safaris",
     *                     type="integer",
     *                     description="Enter safaris",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="travelers",
     *                     type="integer",
     *                     description="Enter travelers",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="stay_category_id",
     *                     type="integer",
     *                     description="Enter stay category id",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="partner_selling_price",
     *                     type="integer",
     *                     description="Enter Partner Selling Price",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="park_id",
     *                     type="integer",
     *                     description="Enter Park Id",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="addional_notes",
     *                     type="string",
     *                     description="Enter Additional Notes",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="start_date",
     *                     type="string",
     *                     format="date",
     *                     description="Enter start date",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="end_date",
     *                     type="string",
     *                     format="date",
     *                     description="Enter End Date",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="validity_date",
     *                     type="string",
     *                     format="date",
     *                     description="Enter Validity Date",
     *                     example="",
     *                 ),
     *                  @OA\Property(
     *                     property="permit_booking_date",
     *                     type="string",
     *                     format="date",
     *                     description="Enter Permit Booking Date",
     *                     example="",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment submitted successfully!"
     *     )
     * )
     */
    public function actionSendQuoteMessage($lead_id)
    {
        $partner = SafariOperator::find()->where(['user_id' => $this->userinfo->id])->one();

        $m = $this->findLeadModel($lead_id, $partner);
        // if ($m->is_payment_received == 1) {
        //     return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "This lead is closed. You can not send quotation."]);
        // }
        $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => $partner->id])->one();
        // $lead_partner = LeadPartners::find()->where(['lead_id' => $m->id, 'partner_id' => 87])->one();
        $model = new LeadPartnerQuotationForm();
        $model->attributes = $this->request;
        $model->lead_id = $m->id;
        $model->lead_partner_id = $lead_partner->id;
        $model->partner_id = $lead_partner->partner_id;

        if ($model->validate()) {
            if ($model->request($this->userinfo)) {
                $message = Yii::$app->api->messageManager->getMessage('common.send_for_approval', ['{var}' => 'Quatation']);
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);

        // return  Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Message not Send"]);
    }








    protected function findLeadModel($id, $partner)
    {

        if (
            ($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->joinWith(['assignOperator' => function ($q) use ($partner) {
                $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => $partner->id]);
                // $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => 87]);
            }])->one()) !== null
        ) {
            return $model;
        }
        $message = Yii::$app->api->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
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
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->status = PartnerGalleryImage::STATUS_ACTIVE;
        $searchModel->partner_gallery_id = $partner_gallery_model->id;

        return $this->dataProviderSender($searchModel, $rootIndexName = "partner_gallery_images");
    }


    /**
     * Get Profile Chat
     *
     * @OA\Get(
     *     path="/chat/profile-chat/{user_handle}",
     *     tags={"Chat"},
     *     summary="Get Profile Chat",
     *     description="Retrieves the <b>chat hash</b> for a direct message conversation with the specified <b>user handle</b>.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user_handle",
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chat Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="chat_hash", type="string", example="Ssxn1J1748250756cYaHy"),
     *             @OA\Property(property="message", type="string", example="Chat Found!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="User Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User Not Found!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="message", type="string", example="Chat Not Found!")
     *         )
     *     )
     * )
     */

    public function actionProfileChat($user_handle)
    {
        $individual_user = $this->individualuser($user_handle);
        if (!$individual_user) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'User']);
            return Yii::$app->api->sendResponse([], ['message' => $message], 400);
        }

        $chat = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_type' => 1])->one();
        if (!$chat) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Chat']);
            return Yii::$app->api->sendResponse($data = ['status' => 0,], ['message' => $message], 200);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.found', ['{var}' => 'Chat']);
        return Yii::$app->api->sendResponse($data = ['status' => 1, 'chat_hash' => $chat->chat_hash], ['message' => $message]);
    }


    /**
     * Make Call Chat
     *
     * Allows users to make a call request or operators to initiate a call.
     *
     * @OA\Post(
     *     path="/chat/make-call-on-chat/{user_handle}",
     *     tags={"Chat"},
     *     summary="Make Call Request",
     *     description="Allows users to make a call request or operators to initiate a call.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user_handle",
     *         in="path",
     *         required=true,
     *         description="User Handle",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="chat_hash",
     *         in="query",
     *         required=true,
     *         description="Unique hash identifier of the chat",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Call Requested Successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Call Requested Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Call Initiated Successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Call Initiated Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="User Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User Not Found!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat Not Found!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat Not Found!")
     *         )
     *     )
     * )
     */

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
            $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => [Chat::CHAT_TYPE_QUOTE, Chat::CHAT_TYPE_SHARE_SAFARI]])->one();
            if (empty($chat_model)) {
                return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
            }
        } else {
            return Yii::$app->api->sendResponse([], ['message' => 'Chat not found'], 400);
        };

        if ($chat_model->chat_type == Chat::CHAT_TYPE_DIRECT) {
            return Yii::$app->api->sendResponse([], ['message' => 'You can not perform this action'], 403);
        }
        if ($chat_model->operator->is_phone_no_verified == 0 || empty($chat_model->operator->phone_no) || $chat_model->user->is_mobile_no_verified == 0 || empty($chat_model->user->mobile_no)) {
            return Yii::$app->api->sendResponse([], ['message' => 'You cannot perform this action, as phone is not available or verified for any of the chat members'], 403);
        }

        // if user is normal user then he only raise call request
        if ($chat_model->user_id == $this->userinfo->id) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // $message = "Call Request raised by " . $this->userinfo->name;
                $message = "Call Requested";
                $chat_message = new ChatMessage();
                $chat_message->chat_id = $chat_model->id;
                $chat_message->message = $message;
                $chat_message->is_call_request = true;
                $chat_message->call_id = null;
                $chat_message->status = 1;
                $chat_message->sender_id = $this->userinfo->id;

                if ($chat_message->save(false)) {
                    $chat = Chat::find()->where(['id' => $chat_model->id])->one();
                    $chat->last_message = \common\models\GeneralModel::strMaxlength($message);
                    $chat->last_message_at = time();
                    $chat->is_call_request = true;
                    $chat->call_id = null;
                    $chat->sender_id = $this->userinfo->id;
                    $chat->is_lead_chat_open_for_user = 1;
                    $chat->status = 1;
                    $chat->is_seen = 0;
                    $chat->created_at = time();
                    $chat->save(false);
                    $transaction->commit();
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Call Requested.']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return Yii::$app->api->sendResponse([], ['message' => 'Failed to initiate the call.'], 400);
            }
        } else {
            // Example parameters
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$chat_model->user->is_mobile_no_verified) {
                    return Yii::$app->api->sendResponse([], ['message' => 'User number is not verified.'], 403);
                }

                $fromCLI = null;
                $has_direct_call = false;
                $chat_id = $chat_model->id;
                $lead_id = $chat_model->lead_id;
                $call_initiated_user_id = $this->userinfo->id; // Example user ID who initiated the call
                $operator_user_id =  $this->userinfo->id; // Example operator user ID
                $call_initiated_partner_id = $chat_model->operator->id; // can be null
                $request_caller_1_no = $chat_model->user->mobile_no;
                $request_caller_1_user_id = $chat_model->user->id;
                $request_caller_2_no = $chat_model->operator->phone_no; // Optional
                $request_caller_2_user_id = $chat_model->operator->user_id; // Optional
                if ($chat_model->operator->has_direct_call == true && !empty($chat_model->operator->direct_call_no)) {
                    $fromCLI = $chat_model->operator->direct_call_no; // Optional
                    $has_direct_call = true;
                }

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
                    $request_caller_2_user_id,
                    $has_direct_call,
                    $fromCLI,
                );

                // Call the callNow method
                $result = $callingService->callNow();
                $transaction->commit();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Call initiated.']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return Yii::$app->api->sendResponse($data = ['status' => 0,], ['message' => 'Failed to initiate the call.']);
            }
        }
    }

    // public function actionMakeCallOnChat($user_handle, $chat_hash)
    // {

    //     $login_user = $this->userinfo;
    //     $individual_user = $this->individualuser($user_handle);
    //     if (!$individual_user) {
    //         // return Yii::$app->api->sendFailedResponse([], 'User not found', 400);
    //         $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'User']);
    //         return Yii::$app->api->sendResponse([], ['message' => $message], 400);
    //     }

    //     if (!empty($chat_hash)) {
    //         // $chat_model = Chat::find()->andWhere(['or', ['user_id' => [$individual_user->id, $this->userinfo->id]], ['recipient_user_id' => [$individual_user->id, $this->userinfo->id]]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
    //         $chat_model = Chat::find()->andWhere(['or', ['user_id' => $this->userinfo->id, 'recipient_user_id' => $individual_user->id], ['user_id' => $individual_user->id, 'recipient_user_id' => $this->userinfo->id]])->andWhere(['chat_hash' => $chat_hash, 'chat_type' => 2])->one();
    //         if (empty($chat_model)) {
    //             $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Chat']);
    //             return Yii::$app->api->sendResponse([], ['message' => $message], 400);
    //         }
    //     } else {
    //         $message = Yii::$app->api->messageManager->getMessage('common.not_found', ['{var}' => 'Chat']);
    //         return Yii::$app->api->sendResponse([], ['message' => $message], 400);
    //     };

    //     if ($chat_model->chat_type == Chat::CHAT_TYPE_DIRECT) {
    //         $message = Yii::$app->api->messageManager->getMessage('common.not_allowed');
    //         return Yii::$app->api->sendResponse([], ['message' => $message], 403);
    //     }
    //     if ($chat_model->operator->is_phone_no_verified == 0 || empty($chat_model->operator->phone_no) || $chat_model->user->is_mobile_no_verified == 0 || empty($chat_model->user->mobile_no)) {
    //         $message = Yii::$app->api->messageManager->getMessage('chat.make_call_on_chat.phone_unavailable_or_unverified');
    //         return Yii::$app->api->sendResponse([], ['message' => $message], 403);
    //     }


    //     // Example parameters
    //     $transaction = Yii::$app->db->beginTransaction();
    //     try {
    //         if (!$chat_model->user->is_mobile_no_verified) {
    //             return Yii::$app->api->sendResponse([], ['message' => 'User number is not verified.'], 403);
    //         }

    //         $chat_id = $chat_model->id;
    //         $lead_id = $chat_model->lead_id;
    //         $call_initiated_user_id = $this->userinfo->id; // Example user ID who initiated the call
    //         $operator_user_id =  $this->userinfo->id; // Example operator user ID
    //         $call_initiated_partner_id = $chat_model->operator->id; // can be null
    //         $request_caller_1_no = $chat_model->user->mobile_no;
    //         $request_caller_1_user_id = $chat_model->user->id;
    //         $request_caller_2_no = $chat_model->operator->phone_no;
    //         $request_caller_2_user_id = $chat_model->operator->user_id;

    //         if ($chat_model->user_id == $this->userinfo->id) {
    //             $request_caller_1_no = $chat_model->operator->phone_no;
    //             $request_caller_1_user_id = $chat_model->operator->user_id;
    //             $request_caller_2_no = $chat_model->user->mobile_no;
    //             $request_caller_2_user_id = $chat_model->user->id;
    //         }



    //         // Instantiate the CallingService
    //         $callingService = new \common\calling\services\CallingService(
    //             $chat_id,
    //             $lead_id,
    //             $operator_user_id,
    //             $call_initiated_user_id,
    //             $call_initiated_partner_id,
    //             $request_caller_1_no,
    //             $request_caller_1_user_id,
    //             $request_caller_2_no,
    //             $request_caller_2_user_id
    //         );

    //         // Call the callNow method
    //         $result = $callingService->callNow();
    //         $transaction->commit();
    //         return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Call initiated.']);
    //     } catch (\Exception $e) {
    //         $transaction->rollBack();
    //         return Yii::$app->api->sendResponse($data = ['status' => 0,], ['message' => 'Failed to initiate the call.']);
    //     }
    // }


    /**
     * Edit Message
     *
     * Allows users to edit message in a chat.
     *
     * @OA\Post(
     *     path="/chat/edit-message",
     *     tags={"Chat"},
     *     summary="Edit Message",
     *     description="Allows users to edit their own message in a chat.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"chat_message_id","message"},
     *                 @OA\Property(
     *                     property="chat_message_id",
     *                     type="integer",
     *                     description="Chat Message Id",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Edit Message",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message Updated successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Message Updated Successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing Parameters",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat message ID and message are required!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="You can only edit messages within 10 minutes!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat message not found or you do not have permission to edit it.")
     *         )
     *     )
     * )
     */
    public function actionEditMessage()
    {
        $chat_message_id = Yii::$app->request->post('chat_message_id');
        $message = Yii::$app->request->post('message');

        if (empty($chat_message_id) || empty($message)) {
            $message = Yii::$app->api->messageManager->getMessage('chat.edit_message.id_message_required');
            return Yii::$app->api->sendResponse([], ['message' => $message], 400);
        }

        $chat_message = ChatMessage::find()->where(['id' => $chat_message_id, 'created_by' => $this->userinfo->id])->one();
        if (!$chat_message) {
            $message = Yii::$app->api->messageManager->getMessage('chat.edit_message.chat_permission_denied');
            return Yii::$app->api->sendResponse([], ['message' => $message], 404);
        }

        // Check if the message was created within the last 10 minutes
        $timeLimit = 10 * 60; // 10 minutes in seconds
        if ((time() - $chat_message->created_at) > $timeLimit) {
            $message = Yii::$app->api->messageManager->getMessage('chat.edit_message.edit_time_limit');
            return Yii::$app->api->sendResponse([], ['message' => $message], 403);
        }

        // $previous_message = $chat_message->message;

        $chat_message->message = $message;
        $chat_message->is_edited = 1; // Mark the message as edited
        if ($chat_message->save()) {
            // Check if the chat message is the last message of the chat
            $chat = Chat::find()->where(['id' => $chat_message->chat_id])->one();
            $last_message = ChatMessage::find()->where(['chat_id' => $chat->id, 'status' => 1])->orderBy(['id' => SORT_DESC])->one();

            if ($chat) {
                Chat::lastMessageUpdate($chat, $last_message);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.updated', ['{var}' => 'Message']);
            return Yii::$app->api->sendResponse(['status' => 1], ['message' => $message]);
        } else {
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed', ['{var}' => 'Message']);
            return Yii::$app->api->sendResponse([], ['message' => $message], 500);
        }
    }

    /**
     * Delete Message
     *
     * Allows users to delete message in a chat.
     *
     * @OA\Post(
     *     path="/chat/delete-message",
     *     tags={"Chat"},
     *     summary="Delete Message (Draft)",
     *     description="Allows users to delete message in a chat.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"chat_message_id"},
     *                 @OA\Property(
     *                     property="chat_message_id",
     *                     type="integer",
     *                     description="Chat Message Id",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message Deleted successfully!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Message Deleted Successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing Parameters",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat message ID and message are required!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="You can not delete messages!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Chat not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Chat message not found or you do not have permission to delete it.")
     *         )
     *     )
     * )
     */
    public function actionDeleteMessage()
    {
        $chat_message_id = Yii::$app->request->post('chat_message_id');

        if (empty($chat_message_id)) {
            $message = Yii::$app->api->messageManager->getMessage('chat.edit_message.id_message_required');
            return Yii::$app->api->sendResponse([], ['message' => $message], 400);
        }

        $chat_message = ChatMessage::find()->where(['id' => $chat_message_id, 'created_by' => $this->userinfo->id])->one();
        if (!$chat_message) {
            $message = Yii::$app->api->messageManager->getMessage('chat.delete_message.chat_permission_denied');
            return Yii::$app->api->sendResponse([], ['message' => $message], 404);
        }

        // Check if the message was created within the last 10 minutes
        $timeLimit = 10 * 60; // 10 minutes in seconds
        if ((time() - $chat_message->created_at) > $timeLimit) {
            $message = Yii::$app->api->messageManager->getMessage('chat.delete_message.can_not_delete');
            return Yii::$app->api->sendResponse([], ['message' => $message], 403);
        }

        // Change the status to 0 instead of deleting
        $chat_message->status = 0;
        $chat_message->message = "This message has been deleted";
        if ($chat_message->save(false)) {
            $chat = Chat::find()->where(['id' => $chat_message->chat_id])->one();
            $last_message = ChatMessage::find()->where(['chat_id' => $chat->id, 'status' => 1])->orderBy(['id' => SORT_DESC])->one();

            if ($chat) {
                Chat::lastMessageUpdate($chat, $last_message);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.deleted', ['{var}' => 'Message']);
            return Yii::$app->api->sendResponse(['status' => 1], ['message' => $message]);
        } else {
            $message = Yii::$app->api->messageManager->getMessage('common.delete_failed');
            return Yii::$app->api->sendResponse([], ['message' => $message], 500);
        }
    }
}
