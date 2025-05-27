<?php

namespace api\models;

use api\models\chat\Chat;
use api\models\feeds\Feeds;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\behaviors\UserHandleBehavior;
use api\models\sharesafari\ShareSafari;
use api\models\operator\SafariOperator;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafariIntrested;

class User extends \common\models\User
{

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'profile_display_image';
        $fields[] = 'cover_display_image';
        $fields[] = 'display_name';
        $fields[] = 'is_followed';
        $fields[] = 'user_activity_count';
        $fields[] = 'operator_slug';
        $fields[] = 'user_followers_count';
        $fields[] = 'user_followings_count';
        // if (in_array(\Yii::$app->controller->action->uniqueId, ['profile/default/followers-list'])) {
        //     $fields[] = 'followed_at';
        // }
        // if (in_array(\Yii::$app->controller->action->uniqueId, ['profile/default/followings-list'])) {
        //     $fields[] = 'following_at';
        // }
        $hold_fields = [
            'id',
            'profile_image',
            'cover_image',
            'facebook_url',
            'whatsapp_url',
            'x_url',
            'insta_url',
            'website_url',
            'youtube_url',
            'about',
            'user_flaged',
            'pop_up_message',
            'mobile_no',
            "password_hash",
            "auth_key",
            "user_bio",
            "date_of_birth",
            "token_key",
            "is_adminstrator",
            "is_admin",
            "is_birding_operator",
            "is_cms_manager",
            "is_resort_manager",
            "is_report_manager",
            "is_community_manager",
            "avatar",
            "gmail",
            "google_source_id",
            "apple_source_id",
            "blocked_at",
            "password_updated_at",
            "photo_privacy",
            "contribution_privacy",
            "can_login",
            "verification_token",
            'password_reset_token',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ];
        if (in_array(\Yii::$app->controller->layout, [\common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL])) {
            // $fields[] = 'user_followers_count';
            // $fields[] = 'user_followings_count';
            $fields[] = 'organized_safari_count';
            $fields[] = 'joined_safari_count';
            $fields[] = 'park_visited';
            $fields[] = 'operator_type';
            $fields[] = 'operator_slug';
            $fields[] = 'operator_status';
            $fields[] = 'urls';

            $hold_fields = [
                'id',
                "password_hash",
                "auth_key",

                "token_key",
                "is_adminstrator",
                "is_admin",
                "is_birding_operator",
                "is_cms_manager",
                "is_resort_manager",
                "is_report_manager",
                "is_community_manager",
                "avatar",
                "gmail",
                "google_source_id",
                "apple_source_id",
                "blocked_at",
                "password_updated_at",

                "photo_privacy",
                "contribution_privacy",
                "can_login",
                "verification_token",
                'password_reset_token',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at',
                'profile_image',
                'cover_image',
            ];
            $fields = array_diff($fields, $hold_fields);
            $fields['is_safari_operator'] = function () {
                return (bool) $this->is_safari_operator;
            };
            return $fields;
        }
        $fields =  array_diff($fields, $hold_fields);
        $fields['is_safari_operator'] = function () {
            return (bool) $this->is_safari_operator;
        };
        return $fields;
    }

    public function getProfile_display_image()
    {
        if ($this->partner && $this->partner->user_id == $this->id) {
            return $this->partner->image_path ? $this->partner->image_path : \Yii::$app->params['frontend_url'] . '/img/operator-placeholder-80.jpg';
        }

        if ($this->profile_image != '') {
            return \Yii::$app->params['s3_endpoint'] . '/user/profile/' . $this->profile_image;
        }

        if ($this->google_avatar_image != '') {
            return \Yii::$app->params['s3_endpoint'] . '/user/profile/' . $this->google_avatar_image;
        }

        if ($this->avatar != '') {
            return $this->avatar;
        }
    }

    public function getCover_display_image()
    {
        if ($this->cover_image != '') {
            return \Yii::$app->params['s3_endpoint'] . '/user/profile/' . $this->cover_image;
        }
    }

    public function getUserfollowers()
    {
        return $this->hasMany(UserFollow::class, ['follow_user_id' => 'id']);
    }

    public function getUserfollowings()
    {
        return $this->hasMany(UserFollow::class, ['user_id' => 'id']);
    }

    public function getSharesafari()
    {
        return $this->hasMany(ShareSafari::class, ['host_user_id' => 'id']);
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['user_id' => 'id']);
    }

    public function getDisplay_name()
    {
        if ($this->partner && $this->partner->user_id == $this->id) {
            return $this->partner->businessname;
        }
        return $this->name;
    }

    public function getOperator_type()
    {
        $arr = [
            'status' => 0,
        ];
        if (!empty($this->partner)) {
            $arr['status'] = $this->partner->status;
            $arr['title'] = $this->partner->categorytitle ?? NULL;
        }
        return $arr;
    }

    public function getUser_followers_count()
    {
        return $this->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->count();
    }

    public function getUser_followings_count()
    {
        return $this->getUserfollowings()->joinWith('follower')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->count();
    }


    public function getOrganized_safari()
    {
        if ($this->id == \Yii::$app->params['active_user_id']) {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->all();
            return $organized_by;
        } else {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->all();
            return $organized_by;
        }
    }

    public function getOrganized_safari_count()
    {
        if ($this->id == \Yii::$app->params['active_user_id']) {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->count();
            return $organized_by;
        } else {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->count();
            return $organized_by;
        }
    }
    public function getJoined_safari_count()
    {
        if ($this->id == \Yii::$app->params['active_user_id']) {
            $joined_by = ShareSafariIntrested::find()->where(['user_id' => $this->id])->joinwith(['sharesafari'])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE])->count();
            return $joined_by;
        } else {
            $joined_by = ShareSafariIntrested::find()->where(['user_id' => $this->id])->joinwith(['sharesafari'])->andWhere(['>=', 'start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE])->count();
            return $joined_by;
        }
    }

    public function getJoinedSafari()
    {
        if ($this->id == \Yii::$app->params['active_user_id']) {
            // $joined_by = ShareSafariIntrested::find()->where(['user_id' => $this->id])->joinwith(['sharesafari'])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE])->all();
            // return $joined_by;
            return $this->hasMany(ShareSafariIntrested::className(), ['user_id' => 'id'])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE]);
        } else {
            // $joined_by = ShareSafariIntrested::find()->where(['user_id' => $this->id])->joinwith(['sharesafari'])->andWhere(['>=', 'start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE]);
            // return $joined_by;
            return $this->hasMany(ShareSafariIntrested::className(), ['user_id' => 'id'])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE]);
        }
    }

    public function getJoinedsharesafari()
    {
        return $this->hasMany(ShareSafari::className(), ['id' => 'share_safari_id'])->via('joinedSafari')->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->andWhere(['share_safari.status' => ShareSafari::STATUS_ACTIVE]);
    }


    public function getUserexperienced()
    {
        return $this->hasMany(UserExperience::className(), ['user_id' => 'id'])->where(['status' => UserExperience::STATUS_ACTIVE]);
    }

    public function getPark_visited()
    {
        return $this->hasMany(SafariPark::className(), ['id' => 'park_id'])->via('userexperienced');
    }

    public function getLoggedinuserfollowed()
    {
        $result = UserFollow::find()->where(['follow_user_id' => $this->id, 'user_id' => \Yii::$app->params['active_user_id']])->andWhere(['user_follower.status' => 1])->limit(1)->one();
        if ($result) {
            return true;
        }
        return false;
    }

    public function getOperator_slug()
    {
        if ($this->partner && $this->partner->user_id == $this->id) {
            return $this->partner->slug;
        }
        return '';
    }

    public function getOperator_status()
    {
        if ($this->partner) {
            return $this->partner->status;
        }
        return 0;
    }

    public function getPartnername()
    {
        if ($this->is_safari_operator == 1) {
            return $this->partner ? $this->partner->businessname : $this->name;
        } else {
            return $this->name;
        }
    }

    public function getIs_followed()
    {
        $is_followed = UserFollow::find()->where(['user_id' => \Yii::$app->params['active_user_id'], 'follow_user_id' => $this->id, 'status' => '1'])->one();
        if ($is_followed) {
            return true;
        }
        return false;
    }

    public function getChatsend()
    {
        return $this->hasMany(Chat::className(), ['user_id' => 'id']);
    }

    public function getChatrecive()
    {
        return $this->hasMany(Chat::className(), ['recipient_user_id' => 'id']);
    }

    public function getChat()
    {
        return $this->hasMany(Chat::className(), [])
            ->onCondition(['or', ['chat.user_id' => new \yii\db\Expression('user.id')], ['chat.recipient_user_id' => new \yii\db\Expression('user.id')]]);
    }

    public function getUser_activity_count()
    {
        $count = Feeds::find()->where(['created_by' => $this->id, 'status' => Feeds::STATUS_ACTIVE])->count();
        if ($count > 0) {
            return $count;
        }
        return 0;
    }

    public function getUrls()
    {
        return [
            'followers_list' => Yii::$app->params['api_url'] . '/profile/' . $this->user_handle . '/followers-list',
            'followings_list' => Yii::$app->params['api_url'] . '/profile/' . $this->user_handle . '/followings-list',
        ];
    }

    // public function getFollowed_at()
    // {
    //     $followed_at = UserFollow::find()->where(['user_id' => $this->id, 'status' => 1])->limit(1)->one();
    //     if ($followed_at) {
    //         return $followed_at->updated_at;
    //     }
    //     return null;
    // }

    // public function getFollowing_at()
    // {
    //     $following_at = UserFollow::find()->where(['follow_user_id' => $this->id,  'status' => 1])->limit(1)->one();
    //     if ($following_at) {
    //         return $following_at->updated_at;
    //     }
    //     return null;
    // }
}
