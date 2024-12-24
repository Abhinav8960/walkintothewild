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
        $user_ids = [$share_safari->organizedId];
        $title = 'Join Safari';
        $message = 'New member alert:' . $user->name . ' has joined your' . $share_safari->share_safari_title . ' Visit the interested member section to review and connect for your trip planning';
        $sent_data = json_encode(['objective' => 'shared_safari', 'name' => $share_safari->share_safari_title, 'slug' => $share_safari->slug], true);
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    public static function safaricommentintrested(ShareSafari $share_safari, User $user)
    {
        /**Firebase Notification start */
        $user_ids = $share_safari->getIntrested()->joinWith('user')->where(['user.status' => 10, 'share_safari_intrested.status' => 1])->where(['!=', 'user.id', $user->id])->select('user_id')->column();
        $title = 'New Comment';
        $message = 'A new comment has been posted in the' . $share_safari->share_safari_title . 'Join the conversation to discuss and finalize the shared safari plans.';
        $sent_data = json_encode(['objective' => 'shared_safari', 'name' => $share_safari->share_safari_title, 'slug' => $share_safari->slug], true);
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    public static function safaricommentorreply(ShareSafari $share_safari, User $user)
    {
        /**Firebase Notification start */
        $user_ids = [$share_safari->organizedId];
        $title = 'New Comment';
        $message = $user->name . ' new comment ' . $share_safari->share_safari_title;
        $sent_data = json_encode(['objective' => 'shared_safari', 'name' => $share_safari->share_safari_title, 'slug' => $share_safari->slug], true);
        $image_url = $share_safari->sharedimagepath;
        FirebaseNotificationLog::setActivity($title, $message, $user_ids, $sent_data, $image_url);
        /**Firebase Notification end */
    }

    public static function profilefollowing(User $to_follow, User $by_follow)
    {
        $user_ids = [$to_follow->id];
        $title = 'New Follower';
        $message = $by_follow->name . 'is now following you!';
        $sent_data = json_encode(['objective' => 'profile', 'name' => $to_follow->name, 'slug' => $to_follow->user_handle], true);
        $image_url = $by_follow->profileimage;
        FirebaseNotificationLog::setActivity($title, $message, $user_ids, $sent_data, $image_url);
    }
}
