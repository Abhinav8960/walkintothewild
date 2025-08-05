<?php

namespace api\models\operator;

use api\models\meta\MetaOtherWildlifeActivities;
use api\models\package\Package;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafari;
use api\models\User;
use api\models\UserFollow;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorActivities;
use Yii;
use common\traits\CommanRelationship;

class SafariOperator extends \common\models\operator\SafariOperator
{
    public function fields()
    {

        // $fields = ['id', 'business_name', 'phone_no', 'email', 'operator_phone_no', 'operator_email', 'slug', 'register_comapany_name', 'address', 'google_rating' => function () {
        $fields = ['business_name', 'phone_no', 'email', 'operator_phone_no', 'operator_email', 'slug', 'register_comapany_name', 'address', 'google_rating' => function () {
            return (string) ($this->google_rating);
        }, 'google_review_count' => function () {
            return (int) ($this->google_review_count);
        }, 'about_business', 'image_path', 'park_count', 'package_count', 'shared_safari_count', 'follower_list_count', 'category_title', 'is_followed', 'status' => function () {
            return (bool)$this->status;
        },];
        $fields[] = 'review_url';

        if (in_array(\Yii::$app->controller->layout, [self::OPERATOR_API_LAYOUT_FULL])) {
            $fields[] = 'park';
            $fields['is_approved'] = function () {
                return (bool)$this->is_approved;
            };
            $fields['has_cancellation_policy'] = function () {
                return (bool)$this->has_cancellation_policy;
            };
            $fields[] = 'budget';
            $fields[] = 'other_wildlife_activity';
            $fields[] = 'facebook_url';
            $fields[] = 'youtube_link';
            $fields[] = 'instagram_url';
            $fields[] = 'website';
            $fields[] = 'urls';
        }

        if (isset($this->google_rating)) {
            $this->google_rating = round($this->google_rating, 1);
        }
        return $fields;
    }

    public function getUrls()
    {
        return [
            'parks' => Yii::$app->params['api_url'] . '/operator/' . $this->slug . '/operator-park',
            'sharedsafari' => Yii::$app->params['api_url'] . '/operator/' . $this->slug . '/operator-shared-safari',
            'packages' => Yii::$app->params['api_url'] . '/operator/' . $this->slug . '/operator-packages',
            'reviews' => Yii::$app->params['api_url'] . '/operator/' . $this->slug . '/reviewlist?sort_by=highest',

        ];
    }

    public function getReview_url()
    {
        return [
            'reviews' => Yii::$app->params['api_url'] . '/operator/' . $this->slug . '/reviewlist?sort_by=highest',

        ];
    }


    public function getPark()
    {
        return $this->hasMany(SafariPark::className(), ['id' => 'park_id'])->via('safaripark');
    }

    public function getSafaripark()
    {
        return $this->hasMany(SafariOperatorPark::className(), ['safari_operator_id' => 'id'])->andWhere(['safari_operator_park.status' => 1]);
    }


    public function getPark_count()
    {
        return SafariOperatorPark::find()->where(['safari_operator_id' => $this->id])->andWhere(['safari_operator_park.status' => 1])->count();
    }

    public function getPackage_count()
    {
        return Package::find()->where(['safari_operator_id' => $this->id])->andWhere(['not', ['live_version' => null]])->count();
    }


    public function getShared_safari_count()
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
        return $this->hasMany(Package::className(), ['safari_operator_id' => 'id'])->andWhere(['status' => Package::STATUS_ACTIVE]);
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

    public function getFollower_list_count()
    {
        return $this->hasMany(UserFollow::className(), ['follow_user_id' => 'user_id'])->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->count();
    }



    public function getImage_path()
    {
        // if ($this->logo != '') {
        //     return Yii::$app->params['s3_endpoint'] . '/safarioperator/' . $this->id . '/' . $this->logo;
        // }
        if ($this->logo != '') {
            return Yii::$app->params['s3_endpoint'] .'/'.  $this->logo;
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

    public function getCategory_title()
    {
        $category_list = [
            1 => 'Safari Tour Operator',
            // 2 => 'Wildlife Photographer',
            3 => 'Wildelife Influencer'
        ];

        return isset($category_list[$this->category_id]) ? $category_list[$this->category_id] : null;
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



    public function getIs_followed()
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


    public function getBudget()
    {
        $budget = [];
        if ($this->is_offer_premium_budget == 1) {
            $budget[] = "Premium";
        }
        if ($this->is_offer_standard_budget == 1) {
            $budget[] = "Standard";
        }
        if ($this->is_offer_economical_budget == 1) {
            $budget[] = "Economical";
        }

        return implode(', ', $budget);
    }

    public function getOperatorsOtherWildlifeActivity()
    {
        return $this->hasMany(SafariOperatorActivities::className(), ['safari_operator_id' => 'id'])->andWhere(['safari_operator_activities.status' => 1]);
    }

    public function getOther_wildlife_activity()
    {
        return $this->hasMany(MetaOtherWildlifeActivities::className(), ['id' => 'wildlife_activity_id'])->via('operatorsOtherWildlifeActivity');
    }
}
