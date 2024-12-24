<?php

namespace api\models\operator;

use api\models\package\Package;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafari;
use api\models\User;
use api\models\UserFollow;
use Yii;
use common\traits\CommanRelationship;

class SafariOperator extends \common\models\operator\SafariOperator
{

    public function fields()
    {

        $fields = parent::fields();
        if (!in_array(\Yii::$app->controller->action->uniqueId, ['operator/default/view'])) {
            $fields[] = 'imagepath';
            $fields[] = 'parkcount';
            $fields[] = 'packagecount';
            $fields[] = 'sharedsafaricount';
            $fields[] = 'witwaveragerating';
            $fields[] = 'witwreviewcount';
            $fields[] = 'followerlistcount';
            $fields[] = 'categorytitle';
            if (in_array(\Yii::$app->controller->action->uniqueId, ['manage/default/index'])) {
                $hold_fields = [
                    'id',
                    'safari_operator_request_id',
                    'gst',
                    'is_highlighted',
                    'http',
                    'has_a_website',
                    'has_cancellation_policy',
                    'wildlife_photographer',
                    'wildlife_influencer',
                    'starting_price',
                    'is_approved',
                    'delete_reason_id',
                    'delete_reason',
                    'total_view',
                    'logo',
                    'status',
                    'created_by',
                    'updated_by',
                    'created_at',
                    'updated_at'
                ];
            } else {
                $hold_fields = [
                    'id',
                    'safari_operator_request_id',
                    'category_id',
                    'address',
                    'gst',
                    'is_highlighted',
                    'about_business',
                    'facebook_url',
                    'http',
                    'youtube_link',
                    'phone_no',
                    'email',
                    'website',
                    'is_register_company',
                    'has_a_website',
                    'has_cancellation_policy',
                    'wildlife_photographer',
                    'wildlife_influencer',
                    'is_offer_premium_budget',
                    'is_offer_standard_budget',
                    'is_offer_economical_budget',
                    'is_wildlife_trekking',
                    'is_wildlife_non_safari_drive',
                    'is_bird_watching',
                    'is_camping',
                    'starting_price',
                    'is_approved',
                    'user_id',
                    'operator_name',
                    'operator_phone_no',
                    'operator_email',
                    'delete_reason_id',
                    'delete_reason',
                    'total_view',
                    'logo',
                    'status',
                    'created_by',
                    'updated_by',
                    'created_at',
                    'updated_at'
                ];
            }
        } else {
            $fields[] = 'imagepath';
            $fields[] = 'parkcount';
            $fields[] = 'packagecount';
            $fields[] = 'sharedsafaricount';
            $fields[] = 'sharedsafari';
            $fields[] = 'packages';
            $fields[] = 'park';
            $fields[] = 'witwaveragerating';
            $fields[] = 'witwreviewcount';
            $fields[] = 'followerlistcount';
            $fields[] = 'isFollowed';
            $hold_fields = [
                'safari_operator_request_id',
                'google_rating',
                'google_review_count',
                'website',
                'gst',
                'google_business_url',
                'google_business_name',
                'is_highlighted',
                'facebook_url',
                'http',
                'is_register_company',
                'has_a_website',
                'has_cancellation_policy',
                'wildlife_photographer',
                'wildlife_influencer',
                'is_offer_premium_budget',
                'is_offer_standard_budget',
                'is_offer_economical_budget',
                'is_wildlife_trekking',
                'is_wildlife_non_safari_drive',
                'is_bird_watching',
                'is_camping',
                'starting_price',
                'is_approved',
                'user_id',
                'operator_name',
                'operator_phone_no',
                'operator_email',
                'delete_reason_id',
                'delete_reason',
                'total_view',
                'logo',
                'status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];
        }

        return array_diff($fields, $hold_fields);
        return $fields;
    }


    public function getPark()
    {
        return $this->hasMany(SafariPark::className(), ['id' => 'park_id'])->via('safaripark');
    }

    public function getSafaripark()
    {
        return $this->hasMany(SafariOperatorPark::className(), ['safari_operator_id' => 'id'])->andWhere(['safari_operator_park.status' => 1]);
    }


    public function getParkcount()
    {
        return SafariOperatorPark::find()->where(['safari_operator_id' => $this->id])->andWhere(['safari_operator_park.status' => 1])->count();
    }

    public function getPackagecount()
    {
        return Package::find()->where(['owned_by_id' => $this->id, 'status' => Package::STATUS_ACTIVE])->count();
    }


    public function getSharedsafaricount()
    {
        return ShareSafari::find()->where([
            'status' => ShareSafari::STATUS_ACTIVE,
            'host_user_id' => $this->id,
            'type' => ShareSafari::TYPE_FIXED_DEPARTURE
        ])->andWhere(['>=', 'start_date', date("Y-m-d")])->count();
    }

    public function getSharedsafari()
    {
        return $this->hasMany(ShareSafari::className(), ['host_user_id' => 'id'])->andWhere(['type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'status' => ShareSafari::STATUS_ACTIVE])->andWhere(['>=', 'start_date', date("Y-m-d")]);
    }

    public function getPackages()
    {
        return $this->hasMany(Package::className(), ['owned_by_id' => 'id'])->andWhere(['status' => Package::STATUS_ACTIVE]);
    }

    public function getsafaricount()
    {
        return ShareSafari::find()->where([
            'status' => ShareSafari::STATUS_ACTIVE,
            'host_user_id' => $this->user_id,
            'type' => ShareSafari::TYPE_SAFARI
        ])->andWhere(['>=', 'start_date', date("Y-m-d")])->count();
    }


    public function getFollowerlist()
    {
        return $this->hasMany(UserFollow::className(), ['follow_user_id' => 'user_id'])->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);
    }

    public function getFollowerlistcount()
    {
        return $this->hasMany(UserFollow::className(), ['follow_user_id' => 'user_id'])->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->count();
    }



    public function getImagepath()
    {
        if ($this->logo != '') {
            return Yii::$app->params['frontend_url_for_api'] . 'storage/safarioperator/' . $this->id . '/' . $this->logo;
        }
    }


    /**
     * Business Name with Type
     */
    public function getBusinessname()
    {
        $name = $this->business_name;

        $category = '';
        // if ($this->category_id = 2) {
        //     $category = ' (Wild Life)';
        // } else if ($this->category_id = 1) {
        //     $category = ' (safari Operator)';
        // }

        return $name . $category;
    }

    public function getCategorytitle()
    {
        $category_list = [
            1 => 'Safari Tour Operator',
            // 2 => 'Wildlife Photographer',
            3 => 'Wildelife Influencer'
        ];

        return isset($category_list[$this->category_id]) ? $category_list[$this->category_id] : $this->category_id;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getWitwaveragerating()
    {
        $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $this->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->average('rating');
        return round($avg, 1);
    }

    public function getWitwreviewcount()
    {
        return SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $this->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->count();
    }

    public function getActiveFollowed()
    {
        return $this->hasOne(UserFollow::className(), ['follow_user_id' => 'user_id'])->where(['user_id' => \Yii::$app->params['active_user_id']])->andWhere(['user_follower.status' => 1]);
    }



    public function getIsFollowed()
    {
        $is_followed = $this->activeFollowed;
        if (!empty($is_followed)) {
            return true;
        }
        return false;
    }

    public function getOperatorparksearch()
    {
        return $this->hasMany(SafariOperatorPark::className(), ['safari_operator_id' => 'id'])->andWhere(['safari_operator_park.status' => 1]);
    }
}
