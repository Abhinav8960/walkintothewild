<?php

namespace frontend\modules\chat\controllers;

use Yii;
use common\models\User;
use common\models\chat\Chat;
use common\models\chat\ChatMessage;

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
        $user_list = User::find()->where("user_handle IS NOT NULL")->all();
        return $this->render('index', ['user_list' => $user_list]);
    }

    /**
     * Start Chating
     */
    public function actionMessage($user_handle)
    {
        $individual_user = $this->individualuser($user_handle);

        $login_user = Yii::$app->user->identity;
        $active_chat_list = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->orderby(['last_message_at' => SORT_DESC])->all();

        return $this->render('message', [
            'individual_user' => $individual_user,
            'active_chat_list' => $active_chat_list,
            'login_user' => $login_user
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

                $chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->limit(1)->one();
                if (!$chat) {
                    $chat = new Chat();
                }
                $chat->generateChatHash();
                $chat->user_id = $login_user->id;
                $chat->recipient_user_id = $individual_user->id;
                $chat->last_message = $message;
                $chat->last_message_at = time();
                $chat->status = 1;
                if ($chat->save()) {
                    $chat_message = new ChatMessage();
                    $chat_message->chat_id = $chat->id;
                    $chat_message->message = $message;
                    $chat_message->status = 1;
                    if ($chat_message->save()) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ['status' => true, 'message' => 'Message Sent'];
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
