<?php

namespace common\Helper;

use Yii;
use Pusher\Pusher;
use yii\helpers\Url;
use common\models\User;
use common\models\chat\Chat;
use common\models\package\Package;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\models\operator\SafariOperatorRating;
use common\models\notification\FrontendNotification;

class FrontendNotificationHelper
{

    /**
     *  New Comment Added into Package
     *
     * @param [type] $package
     * @return void
     */
    public static function packageNewComment(Package $package, User $user)
    {
        if ($package) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_PACKAGE_NEW_COMMENT;
            $model->parent_id = $package->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            if ($package->safarioperator) {
                $model->notification_url = Url::toRoute(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator->slug]);
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
     * Package got new Comment Reply
     *
     * @param [type] $package
     * @return void
     */
    public static function packageCommentReply(Package $package, User $comment_user)
    {
        if ($package) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_PACKAGE_COMMENT_REPLY;
            $model->parent_id = $package->id;
            $model->channel = 'UserNotificationChannel';
            if ($package->safarioperator) {
                $model->notification_url = Url::toRoute(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator->slug]);
            }
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
     * New Quote send to a package
     *
     * @param [type] $package
     * @return void
     */
    public static function packageNewQuote(Package $package, User $user, $chat_url)
    {
        if ($package) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_PACKAGE_NEW_COMMENT;
            // $model->notification_url = Url::toRoute(['/manage/package/view', 'package_id' => $package->id]);
            $model->notification_url = $chat_url;
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


    /**
     * Operator got new Follower
     *
     * @param [type] $operator
     * @return void
     */
    public static function operatorNewFollower(SafariOperator $operator, User $user)
    {
        if ($operator) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_OPERATOR_NEW_FOLLOWER;
            // $model->notification_url = Url::toRoute(['/manage/follower']);
            $model->notification_url = Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]);
            $model->parent_id = $operator->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            $model->user_id = $operator->user_id;
            $model->is_seen = false;
            $model->is_read = False;
            $model->notification_text = "New Follower Recivied From $user->name | " . $operator->business_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }


    /**
     * Operator got new Quote
     *
     * @param [type] $operator
     * @return void
     */
    public static function operatorNewQuote(SafariOperator $operator, OperatorQuote $operator_quote, User $user, $chat_url)
    {
        if ($operator) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_OPERATOR_NEW_QUOTE;
            // $model->notification_url = Url::toRoute(['/manage/quote']);
            $model->notification_url = $chat_url; //Chat URL
            $model->parent_id = $operator->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            $model->user_id = $operator->user_id;
            $model->is_seen = false;
            $model->is_read = False;
            $user_name = $user ? $user->name : $operator_quote->full_name;
            $model->notification_text = "New Quote Recivied From $user_name | " . $operator->business_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }


    /**
     * Operator got new Review
     *
     * @param [type] $operator
     * @return void
     */
    public static function operatorNewReview(SafariOperator $operator, SafariOperatorRating $rating_model, User $user)
    {
        if ($operator) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_OPERATOR_NEW_REVIEW;
            $model->notification_url = Url::toRoute(['/manage/review']);
            $model->parent_id = $operator->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            $model->user_id = $operator->user_id;
            $model->is_seen = false;
            $model->is_read = False;
            $model->notification_text = "New Rating($rating_model->rating) Recivied From $user->name | " . $operator->business_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }


    /**
     * Shared Safari Join by User
     *
     * @param [type] $share_safari
     * @return void
     */
    public static function sharedSafariJoin(ShareSafari $share_safari, User $user)
    {
        if ($share_safari) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_SHARED_SAFARI_JOIN;
            $model->notification_url = Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug]);
            $model->parent_id = $share_safari->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                $model->user_id = $share_safari->host_user_id;
            } else {
                $model->user_id = $share_safari->safarioperator ? $share_safari->safarioperator->user_id : NULL;
            }
            $model->is_seen = false;
            $model->is_read = False;
            $park_name = $share_safari->park ? ' | ' . $share_safari->park->title : '';
            $model->notification_text = "$user->name Joined Shared Safari " . $park_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }

    /**
     * Shared Safari Leave by User
     *
     * @param [type] $share_safari
     * @return void
     */
    public static function sharedSafariLeave(ShareSafari $share_safari, User $user)
    {
        if ($share_safari) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_SHARED_SAFARI_JOIN;
            $model->notification_url = Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug]);
            $model->parent_id = $share_safari->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                $model->user_id = $share_safari->host_user_id;
            } else {
                $model->user_id = $share_safari->safarioperator ? $share_safari->safarioperator->user_id : NULL;
            }
            $model->is_seen = false;
            $model->is_read = False;
            $park_name = $share_safari->park ? ' | ' . $share_safari->park->title : '';
            $model->notification_text = $user->name ." Leaved Shared Safari " . $park_name;
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }



    /**
     * Shared Safari Updated
     *
     * @param [type] $share_safari
     * @return void
     */
    public static function sharedSafariUpdate(ShareSafari $share_safari)
    {
        if ($share_safari) {

            $intrested_users = $share_safari->getIntrested()->where(['status' => 1])->all();
            if ($intrested_users) {
                foreach ($intrested_users as $intrested_user) {
                    $model = new FrontendNotification();
                    $model->action_id = FrontendNotification::ACTION_SHARED_SAFARI_JOIN;
                    $model->notification_url = Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug]);
                    $model->parent_id = $share_safari->id;
                    $model->channel = 'UserNotificationChannel';
                    $model->status = 1;
                    $model->user_id = $intrested_user->user_id;
                    $model->is_seen = false;
                    $model->is_read = False;
                    $park_name = $share_safari->park ? $share_safari->park->title : '';
                    $model->notification_text = "The details of a shared safari you have joined have been updated  | " . $park_name;
                    if ($model->save(false)) {
                        self::eventSendtoPusher($model);
                    }
                }
            }
        }
    }

    public static function fixedDepartureUpdate(ShareSafari $share_safari)
    {
        if ($share_safari) {
            $intrested_users = $share_safari->getIntrested()->where(['status' => 1])->all();
            if ($intrested_users) {
                foreach ($intrested_users as $intrested_user) {
                    $model = new FrontendNotification();
                    $model->action_id = FrontendNotification::ACTION_UPDATE_FIXED_DEPARTURE;
                    $model->notification_url = Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug]);
                    $model->parent_id = $share_safari->id;
                    $model->channel = 'UserNotificationChannel';
                    $model->status = 1;
                    $model->user_id = $intrested_user->user_id;
                    $model->is_seen = false;
                    $model->is_read = False;
                    $park_name = $share_safari->park ? $share_safari->park->title : '';
                    $model->notification_text = "The details of a Fixed Departure you have joined have been updated  | " . $park_name;
                    if ($model->save(false)) {
                        self::eventSendtoPusher($model);
                    }
                }
            }
        }
    }

    public static function sharedSafariComment(ShareSafari $share_safari)
    {
        if ($share_safari) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_SHAREDSAFARI_NEW_COMMENT_TO_HOST;
            $model->notification_url = Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug]);
            $model->parent_id = $share_safari->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                $model->user_id = $share_safari->host_user_id;
            } else {
                $model->user_id = $share_safari->safarioperator ? $share_safari->safarioperator->user_id : NULL;
            }
            $model->is_seen = false;
            $model->is_read = False;
            $park_name = $share_safari->park ? ' | ' . $share_safari->park->title : '';
            $model->notification_text = "New Comment on Shared Safari.";
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }

    public static function sharedSafariReply(ShareSafari $share_safari)
    {
        if ($share_safari) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_SHAREDSAFARI_NEW_REPLY_TO_HOST;
            $model->notification_url = Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug]);
            $model->parent_id = $share_safari->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                $model->user_id = $share_safari->host_user_id;
            } else {
                $model->user_id = $share_safari->safarioperator ? $share_safari->safarioperator->user_id : NULL;
            }
            $model->is_seen = false;
            $model->is_read = False;
            $park_name = $share_safari->park ? ' | ' . $share_safari->park->title : '';
            $model->notification_text = "New Reply on Shared Safari.";
            if ($model->save(false)) {
                self::eventSendtoPusher($model);
            }
        }
    }


    public static function sharedSafariCommentToIntrest(ShareSafari $share_safari)
    {
        if ($share_safari) {

            $intrested_users = $share_safari->getIntrested()->where(['status' => 1])->all();
            if ($intrested_users) {
                foreach ($intrested_users as $intrested_user) {
                    $model = new FrontendNotification();
                    $model->action_id = FrontendNotification::ACTION_SHAREDSAFARI_NEW_COMMENT_TO_INTREST;
                    $model->notification_url = Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug]);
                    $model->parent_id = $share_safari->id;
                    $model->channel = 'UserNotificationChannel';
                    $model->status = 1;
                    $model->user_id = $intrested_user->user_id;
                    $model->is_seen = false;
                    $model->is_read = False;
                    $park_name = $share_safari->park ? $share_safari->park->title : '';
                    $model->notification_text = "New Comment on Shared Safari.";
                    if ($model->save(false)) {
                        self::eventSendtoPusher($model);
                    }
                }
            }
        }
    }

    /**
     *  User got New Followers
     *
     * @param [type] $User
     * @return void
     */
    public static function userNewFollower(User $user, User $follow_by_user)
    {
        if ($user) {
            $model = new FrontendNotification();
            $model->action_id = FrontendNotification::ACTION_USER_NEW_FOLLOWER;
            $model->notification_url = Url::toRoute(['/profile/default/index', 'user_handle' => $follow_by_user->user_handle]);
            $model->parent_id = $user->id;
            $model->channel = 'UserNotificationChannel';
            $model->status = 1;
            $model->user_id = $user->id;
            $model->is_seen = false;
            $model->is_read = False;
            $model->notification_text = $follow_by_user->name . ' started following you!';
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
