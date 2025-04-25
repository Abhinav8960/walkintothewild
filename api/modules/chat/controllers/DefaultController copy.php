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
                'only' => ['index', 'direct', 'quatation-chat', 'operator-list'],
                'rules' => [
                    [
                        'actions' => ['index', 'direct', 'quatation-chat', 'operator-list'],
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
        $chat = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $this->userinfo->id . ' OR recipient_user_id=' . $this->userinfo->id)->andWhere(['chat_type' => 1])->orderby(['last_message_at' => SORT_DESC]);
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel = new User;
        return $this->dataProviderSender($searchModel, $rootIndexName = "operator");
    }



}
