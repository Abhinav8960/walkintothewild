<?php

namespace api\models\operator;

use Yii;
use common\models\package\Package;
use common\traits\CommanRelationship;
use common\models\sharesafari\ShareSafari;
use common\models\User;

/**
 * This is the model class for table "safari_operator".
 *
 * @property int $id
 * @property int|null $safari_operator_request_id
 * @property int|null $category_id
 * @property string $business_name
 * @property string|null $register_comapany_name
 * @property string|null $address
 * @property string|null $gst
 * @property string|null $logo
 * @property int $is_highlighted
 * @property float|null $google_rating
 * @property int|null $google_review_count
 * @property string|null $google_business_url
 * @property string|null $google_business_name
 * @property string|null $about_business
 * @property string|null $facebook_url
 * @property string|null $instagram_url
 * @property string|null $youtube_link
 * @property int $phone_no
 * @property string|null $email
 * @property string|null $website
 * @property int $is_register_company
 * @property int $has_a_website
 * @property int $has_cancellation_policy
 * @property int $wildlife_photographer
 * @property int $wildlife_influencer
 * @property int $is_offer_premium_budget
 * @property int $is_offer_standard_budget
 * @property int $is_offer_economical_budget
 * @property int $is_wildlife_trekking
 * @property int $is_wildlife_non_safari_drive
 * @property int $is_bird_watching
 * @property int $is_camping
 * @property float $starting_price
 * @property int $is_approved
 * @property int|null $user_id
 * @property string $operator_name
 * @property string $operator_phone_no
 * @property string $operator_email
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class SafariOperator extends \common\models\operator\SafariOperator
{
    


    public function getPark()
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

    public function getFollowerlist()
    {
        return $this->hasMany(SafariOperatorFollow::className(), ['safari_operator_id' => 'id']);
    }

    public function getImagepath()
    {
        if ($this->logo != '') {
            return '/storage/safarioperator/' . $this->id . '/' . $this->logo;
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
}
