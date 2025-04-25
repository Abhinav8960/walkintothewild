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
use yii\data\ActiveDataProvider;


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
                'only' => ['index', 'direct', 'quatation-chat', 'operator-list', 'user-list'],
                'rules' => [
                    [
                        'actions' => ['index', 'direct', 'quatation-chat', 'operator-list', 'user-list'],
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
        return $this->dataProviderSender($searchModel, $rootIndexName = "operator");
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
            return Yii::$app->api->sendFailedResponse([], 'Chat not found', 400);
        }
        // $dataProvider = new ActiveDataProvider([
        //     'query' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderby(['last_message_at' => SORT_DESC]),
        //     'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        // ]);

        $dataProvider = new ActiveDataProvider([
            'query' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderBy(['created_at' => SORT_ASC]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
            // 'pagination' => [
            //     'pageSize' => 5, // Adjust the page size as needed
            //     'page' => ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->count() / 10 - 1, // Calculate the last page
            // ],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "chat_messages");
    }
}
