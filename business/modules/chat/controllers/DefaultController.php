<?php

namespace business\modules\chat\controllers;

use Yii;
use common\models\User;
use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\chat\ChatSearch;
use common\models\package\PackageVersion;
use common\models\park\SafariPark;
use common\models\MailLog;
use common\models\GeneralModel;
use yii\web\Controller;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends  Controller
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
            $unseen_quote_chat_count = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 2, 'is_seen' => 0])->orderby(['last_message_at' => SORT_DESC])->andWhere('updated_by<>' . Yii::$app->user->id)->count();
        } else {
            $active_chat_list = [];
            $active_quote_chat_list = [];
            $unseen_quote_chat_count = 0;
        }
        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'active_chat_list' => $active_chat_list,
                'active_quote_chat_list' => $active_quote_chat_list,
                'login_user' => $login_user,
                'unseen_quote_chat_count' => $unseen_quote_chat_count,
            ]
        );
    }

    /**
     * Start Chating
     */
    public function actionMessage($user_handle, $chat_id = null)
    {
        $individual_user = $this->individualuser($user_handle);
        $login_user = Yii::$app->user->identity;
        if (!empty($chat_id)) {
            $exist_chat = Chat::find()->where(['id' => base64_decode($chat_id)])->andWhere(['status' => true])->one();
            if (empty($exist_chat)) {
                return Yii::$app->getResponse()->redirect(['chat']);
            } else {
                $chat_id = base64_decode($chat_id);
                if ($exist_chat->chat_type == 2 && $exist_chat->updated_by <> Yii::$app->user->id) {
                    $exist_chat->is_seen = 1;
                    $exist_chat->save(false);
                }
            }
        } else {
            $individual_chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->andWhere(['chat_type' => 1])->limit(1)->one();
            if ($individual_chat) {
                $individual_chat->is_seen = 1;
                $individual_chat->save(false);
            }
        }
        $searchModel = new ChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($login_user) {
            $active_chat_list = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 1])->orderby(['last_message_at' => SORT_DESC])->all();

            $active_quote_chat_list = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->all();
            $unseen_quote_chat_count = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $login_user->id . ' OR recipient_user_id=' . $login_user->id)->andWhere(['chat_type' => 2, 'is_seen' => 0])->orderby(['last_message_at' => SORT_DESC])->andWhere('updated_by<>' . Yii::$app->user->id)->count();
        } else {
            $active_chat_list = [];
            $active_quote_chat_list = [];
            $unseen_quote_chat_count = 0;
        }

        return $this->render('message', [
            'individual_user' => $individual_user,
            'active_chat_list' => $active_chat_list,
            'active_quote_chat_list' => $active_quote_chat_list,
            'login_user' => $login_user,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'chat_id' => $chat_id,
            'unseen_quote_chat_count' => $unseen_quote_chat_count,
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
                        $chat->is_seen = 0;

                        if ($chat->save()) {
                            $chat_message = new ChatMessage();
                            $chat_message->chat_id = $chat->id;
                            $chat_message->message = $message;
                            $chat_message->status = 1;

                            $park_package_name = $to_mail = $chat_url = '';
                            $operator_info = $user_info  = [];

                            $chatuser = User::find()->where(['id' => $chat->user_id])->limit(1)->one();
                            $user_info = [
                                'name' => $chatuser->name,
                                'email' => $chatuser->email,
                                'user_handle' => $chatuser->user_handle,
                            ];

                            if ($chat->package_id) {
                                $park_package = Package::find()->where(['id' => $chat->package_id])->asArray()->one();
                                $chat_message->data = json_encode($park_package);
                                $park_package_name = $park_package['package_name'];

                                $operator_info = [
                                    'name' => $chat->recipient->operator->business_name,
                                    'email' => $chat->recipient->operator->email,
                                    'user_handle' => $chat->recipient->user_handle,
                                ];
                            } else if ($chat->park_id) {
                                $park_package = SafariPark::find()->where(['id' => $chat->park_id])->asArray()->one();
                                $park_package_name = $park_package['title'];

                                $operator_info = [
                                    'name' => $chat->recipient->operator->business_name,
                                    'email' => $chat->recipient->operator->email,
                                    'user_handle' => $chat->recipient->user_handle,
                                ];

                                // Quote Request Price Set if Message is Second
                                if ($chat->is_quote_accept != 1) {
                                    // Set Price is Message is Second
                                    if ($chat->created_by <> $login_user->id) { // Message Send by Operator
                                        if ($chat->quote_price == '') {
                                            $chat->quote_price = $chat_message->message;
                                            $chat_message_text = 'Rs. ' . $chat_message->message;
                                            if (isset($chat_model['quote_price_max'])) {
                                                $chat->quote_price_max = $chat_model['quote_price_max'];
                                                $chat_message_text = 'Rs. ' . $chat_message->message . ' - ' . $chat->quote_price_max;
                                            }
                                            if (isset($chat_model['quote_more_detail']) && $chat_model['quote_more_detail'] == 1) {
                                                $chat->quote_more_detail = 1;
                                                $chat_message_more_detail = new ChatMessage();
                                                $chat_message_more_detail->chat_id = $chat->id;
                                                $chat_message_more_detail->message = $chat_message_text;
                                                $chat_message_more_detail->status = 1;
                                                $chat_message_more_detail->message = 'More details needed; this may affect the quoted price.';
                                            }
                                            $chat_message->message = $chat_message_text;
                                            $chat->save(false);
                                        }
                                    } else {
                                        // Message Send by User to accpect the Quote Request
                                        $chat->is_quote_accept = 1;
                                        $chat->save(false);
                                    }
                                }
                            }

                            if ($chat_message->save()) {
                                if (isset($chat_message_more_detail)) {
                                    $chat_message_more_detail->save(); // Save for More Details Message show to User 
                                }
                                if ($chat_message->created_by == $chat->recipient_user_id) {
                                    //its end operator
                                    $reply_by = $operator_info['name'];
                                    $reply_to = $user_info['name'];
                                    $to_mail = $user_info['email'];
                                    $chat_url = "/chat/message/" . $user_info['user_handle'] . "/" . base64_encode($chat->id);
                                    $req = ['reply_by' => $reply_by, 'reply_to' => $reply_to, 'park_package_name' => $park_package_name, 'chat_url' => $chat_url, 'is_email_sending' => true, 'show_planning_text' => true];
                                    $subject = 'New Response to Your Quote Request for “' . $park_package_name . '”';
                                } else {
                                    //its end user
                                    $reply_by = $user_info['name'];
                                    $reply_to = $operator_info['name'];
                                    $to_mail = $operator_info['email'];
                                    $chat_url = "/chat/message/" . $operator_info['user_handle'] . "/" . base64_encode($chat->id);
                                    $req = ['reply_by' => $reply_by, 'reply_to' => $reply_to, 'park_package_name' => $park_package_name, 'chat_url' => $chat_url, 'is_email_sending' => true, 'show_planning_text' => false];
                                    $subject = 'Quote Request : New Response from ' . $reply_by . ' for “' . $park_package_name . '”';
                                }

                                //send mail to other user
                                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_USER_RECEIVED_REPLY_FREE_QUOTE;
                                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                                }

                                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                                return ['status' => true, 'message' => 'Message Sent'];
                            }
                        } else {
                            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return ['status' => false, 'message' => 'Erros', 'errors' => $chat->errors];
                        }
                    } else {
                        $chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->andWhere(['chat_type' => 1])->limit(1)->one();
                        if (!$chat) {
                            $chat = new Chat();
                        }
                        $chat->generateChatHash();
                        $chat->user_id = $login_user->id;
                        $chat->recipient_user_id = $individual_user->id;
                        $chat->last_message = $message;
                        $chat->last_message_at = time();
                        $chat->status = 1;
                        $chat->is_seen = 0;

                        if ($chat->save(false)) {
                            $chat_message = new ChatMessage();
                            $chat_message->chat_id = $chat->id;
                            $chat_message->message = $message;
                            $chat_message->status = 1;
                            if ($chat_message->save()) {
                                $reply_by = $login_user->name;
                                $reply_to = $individual_user->name;
                                $to_mail = $individual_user->username;
                                $chat_url = Yii::$app->urlManager->createAbsoluteUrl("/chat/message/" . $individual_user['user_handle'] . "/" . base64_encode($chat->id));
                                $req = ['reply_by' => $reply_by, 'reply_to' => $reply_to, 'chat_url' => $chat_url, 'is_email_sending' => true, 'show_planning_text' => false];
                                $subject = 'New Message';
                                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_REPLY_BY_ANYONE_USER;
                                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                                }
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
