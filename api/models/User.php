<?php

namespace api\models;

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

        $fields[] = 'profileimage';
        $fields[] = 'coverimage';
        $fields[] = 'usename';
        $fields[] = 'loggedinuserfollowed';

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
            "gender",
            "token_key",
            "is_adminstrator",
            "is_admin",
            "is_safari_operator",
            "is_birding_operator",
            "is_cms_manager",
            "is_resort_manager",
            "is_report_manager",
            "is_community_manager",
            "avatar",
            "gmail",
            "google_source_id",
            "blocked_at",
            "account_type",
            "password_updated_at",
            "gender_privacy",
            "email_privacy",
            "photo_privacy",
            "contribution_privacy",
            "can_login",
            "verification_token",
            "status",
            'password_reset_token',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ];
        if (in_array(\Yii::$app->controller->layout, [\common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL])) {
            $fields[] = 'userfollowerscount';
            $fields[] = 'userfollowingscount';
            $fields[] = 'organizedSafariCount';
            $fields[] = 'joinedSafariCount';
            $fields[] = 'parkvisted';
            $fields[] = 'operatortype';
            $fields[] = 'operatorSlug';

            $hold_fields = [
                'id',
                'mobile_no',
                "password_hash",
                "auth_key",
                "user_bio",
                "date_of_birth",
                "gender",
                "token_key",
                "is_adminstrator",
                "is_admin",
                "is_safari_operator",
                "is_birding_operator",
                "is_cms_manager",
                "is_resort_manager",
                "is_report_manager",
                "is_community_manager",
                "avatar",
                "gmail",
                "google_source_id",
                "blocked_at",
                "account_type",
                "password_updated_at",
                "gender_privacy",
                "email_privacy",
                "photo_privacy",
                "contribution_privacy",
                "can_login",
                "verification_token",
                "status",
                'password_reset_token',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];
            return array_diff($fields, $hold_fields);
            return $fields;
        }
        return array_diff($fields, $hold_fields);
        return $fields;

        // if (in_array(\Yii::$app->controller->action->uniqueId, ['sharesafari/default/index', 'sharesafari/default/view', 'package/default/view', 'posts/default/view', 'posts/default/index', 'park/default/reviewlist', 'park/default/view', 'operator/default/reviewlist', 'operator/default/view', 'profile/default/index', 'sharesafari/default/comment-view', 'package/default/comment-view','sharesafari/default/intrested-user'])) {
        //     if (in_array(\Yii::$app->controller->action->uniqueId, ['profile/default/index'])) {
        //         $fields[] = 'userfollowerscount';
        //         $fields[] = 'userfollowingscount';
        //         // $fields[] = 'organizedSafari';
        //         // $fields[] = 'joinedsharesafari';
        //         $fields[] = 'organizedSafariCount';
        //         $fields[] = 'joinedSafariCount';
        //         $fields[] = 'parkvisted';
        //         $fields[] = 'loggedinuserfollowed';
        //     }
        //     $hold_fields = [
        //         'mobile_no',
        //         "password_hash",
        //         "auth_key",
        //         // "facebook_url",
        //         // "whatsapp_url",
        //         // "x_url",
        //         // "insta_url",
        //         // "website_url",
        //         // "youtube_url",
        //         // "about",
        //         "user_bio",
        //         "date_of_birth",
        //         "gender",
        //         "token_key",
        //         "is_adminstrator",
        //         "is_admin",
        //         "is_safari_operator",
        //         "is_birding_operator",
        //         "is_cms_manager",
        //         "is_resort_manager",
        //         "is_report_manager",
        //         "is_community_manager",
        //         "avatar",
        //         "gmail",
        //         "google_source_id",
        //         "profile_image",
        //         "cover_image",
        //         // "user_handle",
        //         "blocked_at",
        //         "account_type",
        //         "password_updated_at",
        //         "gender_privacy",
        //         "email_privacy",
        //         "photo_privacy",
        //         "contribution_privacy",
        //         "can_login",
        //         "verification_token",
        //         "status",
        //         'password_reset_token',
        //         'created_by',
        //         'updated_by',
        //         'created_at',
        //         'updated_at'
        //     ];
        // } else {
        //     if (in_array(\Yii::$app->controller->action->uniqueId, ['site/profile'])) {
        //         $fields[] = 'operatortype';
        //         $fields[] = 'operatorSlug';
        //         $hold_fields = ['id', "token_key", "is_adminstrator", "is_admin", "is_birding_operator", "is_cms_manager", "is_resort_manager", "is_report_manager", "is_community_manager", "avatar", "gmail", "google_source_id", "profile_image", "cover_image",    "blocked_at", "account_type", "password_updated_at", "gender_privacy", "email_privacy", "photo_privacy", "contribution_privacy", "can_login", "status", 'password_reset_token', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        //     } else {

        //         $hold_fields = ['id', "token_key", "is_adminstrator", "is_admin", "is_safari_operator", "is_birding_operator", "is_cms_manager", "is_resort_manager", "is_report_manager", "is_community_manager", "avatar", "gmail", "google_source_id", "profile_image", "cover_image",    "blocked_at", "account_type", "password_updated_at", "gender_privacy", "email_privacy", "photo_privacy", "contribution_privacy", "can_login", "status", 'password_reset_token', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        //     }
        // }
        // return array_diff($fields, $hold_fields);
        // return $fields;
    }

    public function getProfileimage()
    {
        if ($this->profile_image != '') {
            return \Yii::$app->params['frontend_url_for_api'] . 'storage/user/' . $this->id . '/' . $this->profile_image;
        }

        if ($this->avatar != '') {
            return $this->avatar;
        }
    }

    public function getCoverimage()
    {
        if ($this->cover_image != '') {
            return \Yii::$app->params['frontend_url_for_api'] . 'storage/user_cover_image/' . $this->id . '/' . $this->cover_image;
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

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['user_id' => 'id']);
    }

    public function getUsename()
    {
        if ($this->operator && $this->operator->user_id == $this->id) {
            return $this->operator->businessname;
        }
        return $this->name;
    }

    public function getOperatortype()
    {
        $arr = [
            'status' => 0,
        ];
        if (!empty($this->operator)) {
            $arr['status'] = 1;
            $arr['title'] = $this->operator->categorytitle ?? NULL;
        }
        return $arr;
    }

    public function getUserfollowerscount()
    {
        return $this->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->count();
    }

    public function getUserfollowingscount()
    {
        return $this->getUserfollowings()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->count();
    }


    public function getOrganizedSafari()
    {
        if ($this->id == \Yii::$app->params['active_user_id']) {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->all();
            return $organized_by;
        } else {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->all();
            return $organized_by;
        }
    }

    public function getOrganizedSafariCount()
    {
        if ($this->id == \Yii::$app->params['active_user_id']) {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->count();
            return $organized_by;
        } else {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $this->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->count();
            return $organized_by;
        }
    }
    public function getJoinedSafariCount()
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

    public function getParkvisted()
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

    public function getOperatorSlug()
    {
        if ($this->operator && $this->operator->user_id == $this->id) {
            return $this->operator->slug;
        }
        return '';
    }
}
