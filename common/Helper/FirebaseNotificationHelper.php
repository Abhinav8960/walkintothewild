<?php

namespace common\Helper;

use common\models\firebasenotification\FirebaseNotificationLog;
use common\models\sharesafari\ShareSafari;
use common\models\User;
use yii\base\BaseObject;

class FirebaseNotificationHelper extends BaseObject
{
    public static function sharedSafariJoin(ShareSafari $share_safari, User $user)
    {
        /**Firebase Notification start */
        $user_ids = $share_safari->getIntrested()->joinWith('user')->where(['user.status' => 10, 'share_safari_intrested.status' => 1])->where(['!=', 'user.id', $user->id])->select('user_id')->column();
        $title = 'Join Safari';
        $message = $user->name . ' join Safari ' . $share_safari->share_safari_title;
        $sent_data = 'Share Safari';
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }


    public static function sharedSafariLeave(ShareSafari $share_safari, User $user)
    {
        /**Firebase Notification start */
        $user_ids = $share_safari->getIntrested()->joinWith('user')->where(['user.status' => 10, 'share_safari_intrested.status' => 1])->where(['!=', 'user.id', $user->id])->select('user_id')->column();
        $title = 'Unjoin Safari';
        $message = $user->name . ' unjoin Safari ' . $share_safari->share_safari_title;
        $sent_data = 'Share Safari';
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }
}
