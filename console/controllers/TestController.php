<?php

namespace console\controllers;

use common\models\chat\Chat;
use common\models\chat\ChatMessage;
use common\models\cms\banner\Banner;
use common\models\cms\frontendbanner\FrontendBanner;
use common\models\leads\Lead;
use common\models\master\animal\MasterAnimal;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\master\vehicle\MasterVehicle;
use common\models\postscomment\UserPostComment;
use common\models\postscomment\UserPostLike;
use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use common\models\sighting\SightingLike;
use common\models\UserPosts;
use common\models\UserSession;
use Yii;
use yii\console\Controller;

/**
 * TestController implements the CRUD actions for FrontendRequestLog model.
 */
class TestController extends Controller
{


    public function actionLeadDisable()
    {
        $leads = Lead::find()->where(['<', 'created_at', time()])->all();
        foreach ($leads as $lead) {
            $chat = Chat::find()->where(['lead_id' => $lead->id])->one();
            if (!empty($chat)) {
                $chat_messages = ChatMessage::find()->where(['chat_id' => $chat->id])->count();
                if ($chat_messages < 2) {
                    $lead->status = 0;
                } else {
                    $lead->is_chat_started = 1;
                }
                $lead->save(false);
            }
        }
        echo "\n";
        echo "Done";
    }

    public function actionUpdatePostCommentCount()
    {
        $user_posts = UserPosts::find()->all();
        foreach ($user_posts as $post) {
            $comment_count = UserPostComment::find()->where(['user_posts_id' => $post->id])->andWhere(['status' => 1])->count();
            if ($comment_count > 0) {
                $post->comment_count = $comment_count;
                $post->save(false);
            }
        }
        echo "Done";
    }

    public function actionUpdatePostLikeCount()
    {
        $user_posts = UserPosts::find()->all();
        foreach ($user_posts as $post) {
            $like_count = UserPostLike::find()->where(['user_post_id' => $post->id])->andWhere(['status' => 1])->count();
            if ($like_count > 0) {
                $post->like_count = $like_count;
                $post->save(false);
            }
        }
        echo "Done";
    }

    public function actionSightingCommentCount()
    {
        $sightings = Sighting::find()->all();
        foreach ($sightings as $sighting) {
            $comment_count = SightingComment::find()->where(['sighting_id' => $sighting->id])->andWhere(['status' => 1])->count();
            if ($comment_count > 0) {
                $sighting->comment_count = $comment_count;
                $sighting->save(false);
            }
        }
        echo "Done";
    }

    public function actionSightingLikeCount()
    {
        $sightings = Sighting::find()->all();
        foreach ($sightings as $sighting) {
            $like_count = SightingLike::find()->where(['sighting_id' => $sighting->id])->andWhere(['status' => 1])->count();
            if ($like_count > 0) {
                $sighting->like_count = $like_count;
                $sighting->save(false);
            }
        }
        echo "Done";
    }

    public function actionChatSenderId()
    {
        $chats = Chat::find()
            ->where(['sender_id' => null])
            ->all();
        foreach ($chats as $chat) {
            $chatmessage = ChatMessage::find()
                ->where(['chat_id' => $chat->id])
                ->andWhere(['status' => 1])
                ->orderBy(['created_at' => SORT_DESC])
                ->one();
            $chat->sender_id = $chatmessage->created_by == $chat->user_id ? $chat->user_id : $chat->recipient_user_id;
            if ($chat->save(false)) {
                echo "Chat ID {$chat->id} updated with sender_id: {$chat->sender_id}\n";
            } else {
                echo "Failed to update chat ID {$chat->id}\n";
            }
        }

        return true;
    }

    public function actionBannerImage()
    {
        $banner_model = Banner::find()->all();
        foreach ($banner_model as $model) {
            if ($model->image != null) {
                $model->image_path = 'banner/2506/' . $model->image;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionBannerCopy()
    {
        $banner_model = Banner::find()->all();

        foreach ($banner_model as $model) {
            if (!empty($model->image)) {
                $sourcePath = 'banner/' . $model->id . '/' . $model->image;
                $extension = pathinfo($model->image, PATHINFO_EXTENSION);

                $fileName = $model->id . '_banner_' . time() . '.' . $extension;

                $destinationPath = 'banner/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->image = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionFrontendBannerImage()
    {
        $banner_model = FrontendBanner::find()->all();
        foreach ($banner_model as $model) {
            if ($model->frontend_banner != null) {
                $model->frontend_banner_path = 'frontend_banner/2506/' . $model->frontend_banner;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionFrontendBannerCopy()
    {
        $banner_model = FrontendBanner::find()->all();

        foreach ($banner_model as $model) {
            if (!empty($model->frontend_banner)) {
                $sourcePath = 'frontend_banner/' . $model->id . '/' . $model->frontend_banner;
                $extension = pathinfo($model->frontend_banner, PATHINFO_EXTENSION);

                $fileName = $model->id . '_frontend_banner_' . time() . '.' . $extension;

                $destinationPath = 'frontend_banner/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->frontend_banner = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionMasterVehicle()
    {
        $master_model = MasterVehicle::find()->all();
        foreach ($master_model as $model) {
            if ($model->icon != null) {
                $model->icon_path = 'icon/2506/' . $model->icon;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionMasterVehicleCopy()
    {
        $master_model = MasterVehicle::find()->all();

        foreach ($master_model as $model) {
            if (!empty($model->icon)) {
                $sourcePath = 'icon/' . $model->id . '/' . $model->icon;
                $extension = pathinfo($model->icon, PATHINFO_EXTENSION);

                $fileName = $model->id . '_icon_' . time() . '.' . $extension;

                $destinationPath = 'icon/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->icon = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionRareAnimal()
    {
        $master_model = MasterAnimal::find()->all();
        foreach ($master_model as $model) {
            if ($model->banner != null) {
                $model->banner_path = 'rareanimal/2506/' . $model->banner;
                $model->save(false);
            }

            if ($model->feature_image != null) {
                $model->feature_image_path = 'rareanimal/2506/' . $model->feature_image;
                $model->save(false);
            }
        }
        echo "Done";
    }

    public function actionRareAnimalCopy()
    {
        $master_model = MasterAnimal::find()->all();

        foreach ($master_model as $model) {
            if (!empty($model->banner)) {
                $sourcePath = 'rareanimal/' . $model->id . '/' . $model->banner;
                $extension = pathinfo($model->banner, PATHINFO_EXTENSION);

                $fileName = $model->id . '_rareanimal_banner_' . time() . '.' . $extension;

                $destinationPath = 'rareanimal/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->banner = $fileName;
                    $model->save(false);
                }
            }
            if (!empty($model->feature_image)) {
                $sourcePath = 'rareanimal/' . $model->id . '/' . $model->feature_image;
                $extension = pathinfo($model->feature_image, PATHINFO_EXTENSION);

                $fileName = $model->id . '_rareanimal_feature_image_' . time() . '.' . $extension;

                $destinationPath = 'rareanimal/2506/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {
                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $model->feature_image = $fileName;
                    $model->save(false);
                }
            }
        }
        echo "Done";
    }

    public function actionQuoteUserNotify()
    {
        $count = 0;
        $leads = Lead::find()->where(['status' => 1])->all();
        foreach ($leads as $lead) {
            $chats = Chat::find()->where(['status' => 1, 'lead_id' => $lead->id, 'chat_type' => 2])->all();
            foreach ($chats as $chat) {
                // echo "Chat ID: {$chat->id}\n";
                // $chatmessage = ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->andWhere(['>', 'quotation_id', 0])->orderBy(['id' => SORT_DESC])->one();
                // $chatmessage = ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id, 'is_quotation_message' => 1])->orderBy(['id' => SORT_DESC])->one();
                $chatmessage = ChatMessage::find()->where(['status' => 1, 'chat_id' => $chat->id])->orderBy(['id' => SORT_DESC])->one();
                if (!empty($chatmessage)) {
                    // echo "Chat Message ID: {$chatmessage->id}\n";
                    $userMessagesAfterQuotation = ChatMessage::find()
                        ->where(['chat_id' => $chatmessage->chat_id, 'created_by' => $chat->recipient_user_id])
                        ->andWhere(['status' => 1])
                        ->andWhere(['>', 'id', $chatmessage->id])
                        ->count();

                    if ($chatmessage->created_by == $chat->recipient_user_id && $userMessagesAfterQuotation == 0) {
                        echo "No user messages after quotation for Chat ID: {$chat->id}\n";
                        $count++;
                        $master_notification_template = MasterNotificationTemplate::find()->where(['id' => MasterNotificationTemplate::CHAT_MESSAGE_RECEIVED_REGISTRATION_TEMPLATE, 'status' => 1])->limit(1)->one();
                        $title = \Yii::$app->engine->render($master_notification_template->title, ['sender' => $chat->sender->name]);
                        $body = \Yii::$app->engine->render($master_notification_template->message, ['message' => strip_tags($chat->last_message)]);
                        $data = MasterNotificationTemplate::prepareSendData(
                            $title,
                            $body,
                            [
                                'objective' => Chat::OBJECTIVE_QUOTE,
                                'chat_hash' => $chat->chat_hash,
                                'sender_name' => $chat->sender->name,
                                'user_handle' => $chat->sender->user_handle,
                                'lead_id' => $chat->lead_id,
                                'can_call' => $chat->callpossible()
                            ]
                        );
                        $receiver_id = $chat->user_id;
                        $token = $this->firebaseTokens($receiver_id);
                        if ($token) {
                            print_r([
                                "count" => $count,
                                "chat" => $chat->id,
                                "chat_message" => $chatmessage->id,
                                "receiver_id" => $receiver_id,
                                "tokens" => $token,
                                "title" => $title,
                                "body" => $body,
                            ]);
                            // \Yii::$app->firebase->sendMulticastNotification($title, $body, $imageUrl = NULL, $token, $data, $topic = NULL, $condition = NULL);
                        }
                    }
                }
            }
        }
        echo "done";
    }



    private function firebaseTokens($userId)
    {
        $uds =  UserSession::find()
            // ->where(['user_id1' => $userId, 'app_name' => 'Api'])
            ->where(['user_id' => $userId])
            ->andWhere(['not', ['firebase_token' => null]])
            ->andWhere(['!=', 'firebase_token', ''])
            ->andWhere(['is_firebase_token_active' => 1])
            ->all();
        $tokens = [];
        foreach ($uds as $ud) {
            $tokens[] = $ud->firebase_token;
        }
        $array = array_unique($tokens);

        return $array;
    }
}
