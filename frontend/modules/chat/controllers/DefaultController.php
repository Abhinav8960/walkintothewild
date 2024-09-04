<?php

namespace frontend\modules\chat\controllers;

use Yii;
use common\models\User;
use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\chat\ChatSearch;
use common\models\package\Package;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ChatSearch();
        $login_user = Yii::$app->user->identity;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($login_user) {
            $active_chat_list = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 1])->orderby(['last_message_at' => SORT_DESC])->all();

            $active_quote_chat_list = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->all();
        } else {
            $active_quote_chat_list = [];
            $active_quote_chat_list = [];
        }

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'active_chat_list' => $active_chat_list,
                'active_quote_chat_list' => $active_quote_chat_list,
                'login_user' => $login_user,
            ]
        );
    }

    /**
     * Start Chating
     */
    public function actionMessage($user_handle, $chat_id = null)
    {
        if (!empty($chat_id)) {
            $exist_chat = Chat::find()->where(['id' => base64_decode($chat_id)])->andWhere(['status' => true])->one();
            if (empty($exist_chat)) {
                return Yii::$app->getResponse()->redirect(['chat']);
            } else {
                $chat_id = base64_decode($chat_id);
            }
        }

        $individual_user = $this->individualuser($user_handle);
        $login_user = Yii::$app->user->identity;
        $searchModel = new ChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($login_user) {
            $active_chat_list = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 1])->orderby(['last_message_at' => SORT_DESC])->all();

            $active_quote_chat_list = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->all();
        } else {
            $active_chat_list = [];
            $active_quote_chat_list = [];
        }

        return $this->render('message', [
            'individual_user' => $individual_user,
            'active_chat_list' => $active_chat_list,
            'active_quote_chat_list' => $active_quote_chat_list,
            'login_user' => $login_user,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'chat_id' => $chat_id
        ]);
    }

    /**
     * Send a Message
     */
    public function actionSendmessage()
    {
        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->post('Chat') !== null) {
                $chat_model = Yii::$app->request->post('Chat');
                $individual_user = $this->individualuser($chat_model['user_handle']);
                $login_user = Yii::$app->user->identity;
                $message = $chat_model['message'];
                $chat_id = $chat_model['chat_id'];

                if ($message <> '') {
                    if (!empty($chat_id)) {
                        $chat = Chat::find()->where(['id' => $chat_id])->limit(1)->one();
                        $chat->last_message_at = time();
                        $chat->status = 1;

                        if ($chat->save()) {
                            $chat_message = new ChatMessage();
                            $chat_message->chat_id = $chat->id;
                            $chat_message->message = $message;
                            $chat_message->status = 1;
                            if ($chat->package_id) {
                                $package_data = Package::find()->where(['id' => $chat->package_id])->asArray()->one();
                                $chat_message->data = json_encode($package_data);
                            }

                            if ($chat_message->save()) {
                                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                                return ['status' => true, 'message' => 'Message Sent'];
                            }
                        } else {
                            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return ['status' => false, 'message' => 'Erros', 'errors' => $chat->errors];
                        }
                    } else {
                        $chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->limit(1)->one();

                        $chat->generateChatHash();
                        $chat->user_id = $login_user->id;
                        $chat->recipient_user_id = $individual_user->id;
                        $chat->last_message = $message;
                        $chat->last_message_at = time();
                        $chat->status = 1;

                        if ($chat->save(false)) {
                            $chat_message = new ChatMessage();
                            $chat_message->chat_id = $chat->id;
                            $chat_message->message = $message;
                            $chat_message->status = 1;
                            if ($chat_message->save()) {
                                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                                return ['status' => true, 'message' => 'Message Sent'];
                            }
                        } else {
                            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return ['status' => false, 'message' => 'Erros', 'errors' => $chat->errors];
                        }
                    }
                }
            }
        }
    }


    /**
     * Induvidual User Model
     */
    protected function individualuser($user_handle)
    {
        return User::find()->where(['user_handle' => $user_handle])->limit(1)->one();
    }
}
