<?php

namespace common\Helper;

use Yii;
use Pusher\Pusher;
use yii\helpers\Url;
use common\models\User;
use common\models\package\Package;
use common\models\notification\FrontendNotification;

class FrontendNotificationHelper
{

    /**
     * Order Added Into Queued
     *
     * @param [type] $package
     * @return void
     */
    public static function packageNewComment(Package $package, User $user)
    {
        if ($package) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_PACKAGE_NEW_COMMENT;
            $model->notification_url = Url::toRoute(['/package/default/view', 'slug' => $package->package_slug]);
            $model->parent_id = $package->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            if ($package->safarioperator) {
                $model->user_id = $package->safarioperator->user_id;
            }
            $model->is_seen = false;
            $model->is_read = False;
            $model->notification_text = "New Comment Recivied From $user->name | " . $package->package_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }

    /**
     * Order Added Into Queued
     *
     * @param [type] $package
     * @return void
     */
    public static function packageCommentReply(Package $package, User $comment_user)
    {
        if ($package) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_PACKAGE_COMMENT_REPLY;
            $model->notification_url = Url::toRoute(['/package/default/view', 'slug' => $package->package_slug]);
            $model->parent_id = $package->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            $model->user_id = $comment_user->id;
            $model->is_seen = false;
            $model->is_read = False;
            $model->notification_text = "$comment_user->name reply on your comment | " . $package->package_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }


    /**
     * Order Added Into Queued
     *
     * @param [type] $package
     * @return void
     */
    public static function packageNewQuote(Package $package, User $user)
    {
        if ($package) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_PACKAGE_NEW_COMMENT;
            $model->notification_url = Url::toRoute(['/manage/package/view', 'package_id' => $package->id]);
            $model->parent_id = $package->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            if ($package->safarioperator) {
                $model->user_id = $package->safarioperator->user_id;
            }
            $model->is_seen = false;
            $model->is_read = False;
            $model->notification_text = "New Request Quote Recivied From $user->name | " . $package->package_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }


    public static function eventSendtoPusher($model)
    {
        if (isset(Yii::$app->params['PUSHER_AUTH_KEY']) && Yii::$app->params['PUSHER_AUTH_KEY'] != '') {
            $options = array(
                'cluster' => Yii::$app->params['PUSHER_CLUSTER'],
                'useTLS' => true
            );
            $pusher = new Pusher(
                Yii::$app->params['PUSHER_AUTH_KEY'],
                Yii::$app->params['PUSHER_SECRET_KEY'],
                Yii::$app->params['PUSHER_APP_ID'],
                $options
            );
            $data = [];
            $data['id'] = $model->id;
            $data['notification_url'] = $model->notification_url;
            $data['notification_text'] = $model->notification_text;
            $data['action_id'] = $model->action_id;
            $data['parent_id'] = $model->parent_id;
            $data['chat_id'] = $model->chat_id;
            $data['sent_to_operator_id'] = $model->sent_to_operator_id;
            $data['sent_to_operator_name'] = $model->sent_to_operator_name;
            $data['status'] = $model->status;
            $data['user_id'] = $model->user_id;
            $data['shortmessage'] = $model->shortmessage;
            $data['created_at'] = date("h:i a", strtotime(date('Y-m-d H:i:s', $model->created_at)));
            $pusher->trigger($model->channel, 'UserEvent', $data);
        }
    }
}
