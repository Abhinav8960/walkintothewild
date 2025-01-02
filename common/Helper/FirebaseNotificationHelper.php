<?php

namespace common\Helper;

use common\models\firebasenotification\FirebaseNotificationLog;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use common\models\User;
use Yii;
use yii\base\BaseObject;

class FirebaseNotificationHelper extends BaseObject
{
    /**
     * To creator
     *  */
    public static function sharedSafariJoin(ShareSafari $share_safari, User $user)
    {
        $engine = Yii::$app->engine;
        $template = MasterNotificationTemplate::find()->where(['id' => 1])->limit(1)->one();
        $master_notification_template_id = $template->id;
        /**Firebase Notification start */
        $user_ids = [$share_safari->organizedId];
        $title = $template->title;
        $html = $template->message;
        $values = [
            'var1' => $user->name,
            'var2' => $share_safari->share_safari_title
        ];
        $message = $engine->render($html, $values);
        $sent_data = json_encode(['objective' => 'shared_safari', 'name' => $share_safari->share_safari_title, 'slug' => $share_safari->slug], true);
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($master_notification_template_id, $title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    /**
     * Shared safari comment (for all joinees) 
     */
    public static function safaricommentintrested(ShareSafari $share_safari, User $user)
    {
        $engine = Yii::$app->engine;
        $template = MasterNotificationTemplate::find()->where(['id' => 2])->limit(1)->one();
        $master_notification_template_id = $template->id;
        /**Firebase Notification start */
        $user_ids = $share_safari->getIntrested()->joinWith('user')->where(['user.status' => 10, 'share_safari_intrested.status' => 1])->where(['!=', 'user.id', $user->id])->select('user_id')->column();
        $title = $template->title;
        $html = $template->message;
        $values = [
            'var1' => $share_safari->share_safari_title
        ];
        $message = $engine->render($html, $values);
        $sent_data = json_encode(['objective' => 'shared_safari', 'name' => $share_safari->share_safari_title, 'slug' => $share_safari->slug], true);
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($master_notification_template_id, $title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    /**
     * To creator
     * Shared safari comment or reply (only to the creator)
     * */
    public static function safaricommentorreply(ShareSafari $share_safari, User $user)
    {
        $engine = Yii::$app->engine;
        $template = MasterNotificationTemplate::find()->where(['id' => 3])->limit(1)->one();
        $master_notification_template_id = $template->id;
        /**Firebase Notification start */
        $user_ids = [$share_safari->organizedId];
        $title = $template->title;
        $html = $template->message;
        $values = [
            'var1' => $user->name,
            'var2' => $share_safari->share_safari_title,
        ];
        $message = $engine->render($html, $values);
        $sent_data = json_encode(['objective' => 'shared_safari', 'name' => $share_safari->share_safari_title, 'slug' => $share_safari->slug], true);
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($master_notification_template_id, $title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    /**
     * When someone follows someone
     */
    public static function profilefollowing(User $to_follow, User $by_follow)
    {
        $engine = Yii::$app->engine;
        $template = MasterNotificationTemplate::find()->where(['id' => 4])->limit(1)->one();
        $master_notification_template_id = $template->id;
        /**Firebase Notification start */
        $user_ids = [$to_follow->id];
        $title = $template->title;
        $html = $template->message;
        $values = [
            'var1' => $by_follow->name,
        ];
        $message = $engine->render($html, $values);
        $sent_data = json_encode(['objective' => 'profile', 'name' => $to_follow->name, 'slug' => $to_follow->user_handle], true);
        $image_url = $by_follow->profileimage;
        FirebaseNotificationLog::setActivity($master_notification_template_id, $title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    /**
     * Package Intrest
     */
    public static function packageintrest(Package $package, User $user)
    {
        $engine = Yii::$app->engine;
        $template = MasterNotificationTemplate::find()->where(['id' => 5])->limit(1)->one();
        $master_notification_template_id = $template->id;
        /**Firebase Notification start */
        $user_ids = [$package->user->id];
        $title = $template->title;
        $html = $template->message;
        $values = [
            'var1' => $user->name,
        ];
        $message = $engine->render($html, $values);
        $sent_data = json_encode(['objective' => 'package', 'name' => $package->name, 'slug' => $package->package_slug], true);
        $image_url = $package->imagepath;
        FirebaseNotificationLog::setActivity($master_notification_template_id, $title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    /**
     * Quote Request
     */
    public static function operatorquoterequest(SafariOperator $operator, User $user)
    {
        $engine = Yii::$app->engine;
        $template = MasterNotificationTemplate::find()->where(['id' => 6])->limit(1)->one();
        $master_notification_template_id = $template->id;
        /**Firebase Notification start */
        $user_ids = [$operator->user_id];
        $title = $template->title;
        $html = $template->message;
        $values = [
            'var1' => $user->name,
        ];
        $message = $engine->render($html, $values);
        $sent_data = json_encode(['objective' => 'operator', 'name' => $operator->business_name, 'slug' => $operator->slug], true);
        $image_url = $operator->imagepath;
        FirebaseNotificationLog::setActivity($master_notification_template_id, $title, $message, $user_ids, $sent_data, $image_url);
         /**Firebase Notification end */
    }

    /**
     * Review to influencer or operator
     */
    public static function newreview(SafariOperator $operator, User $user)
    {
        $engine = Yii::$app->engine;
        $template = MasterNotificationTemplate::find()->where(['id' => 7])->limit(1)->one();
        $master_notification_template_id = $template->id;
        /**Firebase Notification start */
        $user_ids = [$operator->user_id];
        $title = $template->title;
        $html = $template->message;
        $values = [
            'var1' => $user->name,
        ];
        $message = $engine->render($html, $values);
        $sent_data = json_encode(['objective' => 'operator', 'name' => $operator->business_name, 'slug' => $operator->slug], true);
        $image_url = $operator->imagepath;
        FirebaseNotificationLog::setActivity($master_notification_template_id, $title, $message, $user_ids, $sent_data, $image_url);
         /**Firebase Notification end */
    }
}
