<?php

namespace api\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\behaviors\UserHandleBehavior;
use common\models\sharesafari\ShareSafari;
use common\models\operator\SafariOperator;


class User extends \common\models\User
{

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'profileimage';
        $fields[] = 'coverimage';


        if (in_array(\Yii::$app->controller->action->uniqueId, ['sharesafari/default/index', 'sharesafari/default/view','package/default/view', 'posts/default/view', 'posts/default/index', 'park/default/reviewlist'])) {
            $hold_fields = [
                'id',
                "password_hash",
                "auth_key",
                "facebook_url",
                "whatsapp_url",
                "x_url",
                "insta_url",
                "website_url",
                "youtube_url",
                "about",
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
                "profile_image",
                "cover_image",
                "user_handle",
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
        } else {
            $hold_fields = ['id', "token_key", "is_adminstrator", "is_admin", "is_safari_operator", "is_birding_operator", "is_cms_manager", "is_resort_manager", "is_report_manager", "is_community_manager", "avatar", "gmail", "google_source_id", "profile_image", "cover_image", "user_handle",     "blocked_at", "account_type", "password_updated_at", "gender_privacy", "email_privacy", "photo_privacy", "contribution_privacy", "can_login", "status", 'password_reset_token', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        }
        return array_diff($fields, $hold_fields);
        return $fields;
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
}
