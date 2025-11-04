<?php

namespace api\models;

use api\models\chat\Chat;
use api\models\compliancedocuments\ComplianceDocuments;
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
        $fields[] = 'is_acknowledged';
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
            // "is_adminstrator",
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
            'is_mobile_no_verified',
            'mobile_no_verified_at'
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
                // "is_adminstrator",
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
            $fields['is_mobile_no_verified'] = function () {
                return (bool) $this->is_mobile_no_verified;
            };
            $fields['is_mobile_verification_mandatory'] = function () {
                return (bool) $this->IsMobileVerificationMandatory();
            };
            $fields['is_blue_badge_verified'] = function () {
                return (bool) $this->is_blue_badge_verified;
            };
            return $fields;
        }
        $fields =  array_diff($fields, $hold_fields);
        $fields['is_safari_operator'] = function () {
            return (bool) $this->is_safari_operator;
        };
        $fields['is_blue_badge_verified'] = function () {
            return (bool) $this->is_blue_badge_verified;
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
            $arr['title'] = $this->partner->categorytitle ?? null;
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
            $joined_by = ShareSafariIntrested::find()->where(['share_safari_intrested.user_id' => $this->id])->joinwith(['sharesafari'])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE])->count();
            return $joined_by;
        } else {
            $joined_by = ShareSafariIntrested::find()->where(['share_safari_intrested.user_id' => $this->id])->joinwith(['sharesafari'])->andWhere(['>=', 'start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE])->count();
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

    public function IsMobileVerificationMandatory()
    {
        $user_ids = [88, 1395, 2431, 2444, 2448, 2463, 2481, 2485, 2489, 2505, 2522, 2568, 2567, 2577, 2580, 2674, 2722, 2727, 2708, 2746, 2586, 2777, 2787, 1031, 2827, 2829, 2828, 1355, 2631, 2868, 2869, 451, 2874, 2893, 2902, 1262, 2911, 2938, 2941, 2942, 2992, 2997, 1346, 309, 3008, 2249, 2909, 3052, 3057, 3072, 3098, 3103, 3138, 3144, 3147, 3263, 3206, 3262, 3284, 3293, 3292, 3307, 1817, 3317, 3194, 1072, 3336, 3337, 3339, 3321, 688, 3360, 3367, 928, 2615, 3376, 2482, 3381, 3382, 3403, 3405, 2401, 3439, 3440, 3465, 3476, 3494, 3524, 3527, 2512, 3539, 3541, 3546, 3519, 3557, 3566, 3573, 203, 3597, 3611, 3618, 3630, 3631, 932, 3640, 3642, 3645, 3663, 3664, 3715, 3734, 3721, 2846, 2490, 3752, 3749, 3756, 3760, 3765, 2432, 3770, 3787, 3594, 3795, 3800, 3801, 3761, 3815, 1055, 3798, 3836, 3845, 3847, 3408, 3859, 3887, 1186, 3926, 3956, 3963, 3964, 3989, 3994, 3997, 3467, 260, 3273, 4018, 4030, 946, 184, 4073, 3551, 4084, 2799, 1030, 4108, 4110, 4116, 4137, 4147, 4154, 3848, 4111, 4220, 4222, 4107, 4234, 3472, 4242, 4250, 4255, 4274, 4282, 4308, 3741, 4315, 4333, 4345, 4353, 4362, 4384, 4404, 2739, 4413, 4427, 4429, 631, 1890, 141, 2774, 4452, 4446, 4464, 4421, 4153, 4499, 4500, 4502, 4521, 4528, 4530, 382, 4537, 4541, 4463, 4549, 4550, 2695, 4563, 4567, 4576, 4582, 4588, 3261, 4592, 4366, 4422, 4605, 4609, 4268, 4632, 4633, 3712, 3478, 4640, 4648, 4654, 3249, 4667, 4670, 4672, 4677, 4679, 4680, 3575, 4689, 4692, 4696, 4699, 4700, 4701, 3983, 4703, 4707, 4709, 4720, 4723, 4727, 4728, 4734, 4742, 4748, 4376, 4751, 4762, 4765, 4767, 4773, 4787, 4788, 3301, 4716, 4799, 1979, 4663, 4809, 4808, 4810, 4621, 4812, 4558, 4820, 1598, 4825, 2487, 4845, 4848, 4852, 4861, 4889, 325, 4946, 4958, 5004, 1629, 5010, 3842, 5018, 204, 5039, 5040, 5067, 5102, 4579, 368, 306, 4251, 5150, 5165, 5129, 5178, 5000, 5188];
        if (in_array($this->id, $user_ids) && $this->is_mobile_no_verified == 0) {
            return true;
        }
        return false;
    }

    public function getIs_acknowledged()
    {
        $current_version = ComplianceDocuments:: find()->select('version')->where(['type'=>ComplianceDocuments::PRIVACY_POLICY])->andWhere(['status'=>ComplianceDocuments::STATUS_ACTIVE])->one();
        $user = UserPrivacyPolicyAcknowledgement::find()->where(['user_id' => $this->id])->andWhere(['document_version'=>$current_version])->one();
        if(!empty($user)){
            return true;
        }
        return false;
    }

}
