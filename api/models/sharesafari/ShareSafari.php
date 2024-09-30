<?php

namespace api\models\sharesafari;

use Yii;
use api\models\User;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafariComment;
// use api\models\sharesafari\ShareSafariDay;
// use api\models\sharesafari\ShareSafariGallery;
// use api\models\sharesafari\ShareSafariIncluded;
use api\models\sharesafari\ShareSafariIntrested;
use api\models\sharesafari\ShareSafariParklist;
use api\models\operator\SafariOperator;

class ShareSafari extends \common\models\sharesafari\ShareSafari
{
    const STATUS_FULL_SEAT = 2;
    const TYPE_SAFARI = 1;
    const TYPE_FIXED_DEPARTURE = 2;

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'types';
        $fields[] = 'park';
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            $hold_fields = [
                'delete_reason_id',
                'delete_reason',
                'cut_off_date',
                'share_safari_request_id',
                'type',
                'cost_per_person',
                'park_id',
                'share_safari_terms_condtition',
                'privacy_policy',
                'change_policy',
                'what_you_must_carry',
                'date_change_policy',
                'refund_policy',
                'getting_there',
                'breakfast_included',
                'lunch_included',
                'dinner_included',
                'meal_not_included',
                'share_safari_inclusion',
                'share_safari_exclusion',
                'total_view',
                'status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];
        } else {
            $hold_fields =
                [
                    'delete_reason_id',
                    'delete_reason',
                    'share_safari_request_id',
                    'type',
                    'estimate_price_min',
                    'estimate_price_max',
                    'park_id',
                    'total_view',
                    'status',
                    'created_by',
                    'updated_by',
                    'created_at',
                    'created_by',
                    'updated_at',
                ];
        }

        return array_diff($fields, $hold_fields);
        return $fields;
    }



    public function getStatuslabel()
    {

        $options = [ShareSafari::STATUS_ACTIVE => 'Published', ShareSafari::STATUS_SUSPEND => 'Inactive', ShareSafari::STATUS_FULL_SEAT => 'Seat Full'];
        return isset($options[$this->status]) ? $options[$this->status] : '';
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getParklist()
    {
        return $this->hasMany(ShareSafariParklist::className(), ['id' => 'share_safari_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'host_user_id']);
    }


    public function getIntrested()
    {
        return $this->hasMany(ShareSafariIntrested::className(), ['share_safari_id' => 'id']);
    }

    public function getSharedimagepath()
    {

        return isset($this->image) ? ('/storage/share_safari/' . $this->id . '/' . $this->image) : (isset($this->park) && isset($this->park->logo) ? $this->park->logoimagepath : '');
    }

    public function getComments()
    {
        return $this->hasMany(ShareSafariComment::class, ['share_safari_id' => 'id']);
    }

    /**
     * Get Host Type
     */
    public function getHosttype()
    {
        $options = [
            1 => 'Individual',
            2 => 'Wildlife Influencer',
            3 => 'Wildlife Influencer',
            4 => 'Safari Tour Operator'
        ];
        return isset($options[$this->host_type]) ? $options[$this->host_type] : $this->host_type;
    }



    public function getOrganizedbyname()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->name : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->safarioperator) ? $this->safarioperator->businessname : "N/A";
        }
    }

    public function getOrganizedbyuserhandel()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->user_handle : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->safarioperator) ? $this->safarioperator->businessname : "N/A";
        }
    }
    public function getOrganizedbyimage()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->profileimage : '';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return $this->safarioperator &&  $this->safarioperator->logo  ? $this->safarioperator->imagepath : '';
        }
    }
    public function getOrganizedbyprofileurl()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return \yii\helpers\Url::toRoute(['/profile/default/index', 'user_handle' => $this->user ? $this->user->user_handle : '']);
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return \yii\helpers\Url::toRoute(['/operator/default/sharedsafari', 'slug' => $this->safarioperator ? $this->safarioperator->slug : '']);
        }
    }

    // public function getSharesafariIncludeds()
    // {
    //     return $this->hasMany(ShareSafariIncluded::class, ['share_safari_id' => 'id']);
    // }

    // public function getSharesafaridays()
    // {
    //     return $this->hasMany(ShareSafariDay::class, ['share_safari_id' => 'id']);
    // }

    // public function getSharesafarigallery()
    // {
    //     return $this->hasMany(ShareSafariGallery::className(), ['share_safari_id' => 'id']);
    // }

    public function getOrganizedslug()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->user_handle : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->safarioperator) ? $this->safarioperator->slug : "N/A";
        }
    }

    public function getMeals()
    {
        $meals_text = '';
        if ($this->breakfast_included == 1 || $this->lunch_included == 1 || $this->dinner_included == 1) {
            $meals_text = 'Included';
        }



        return ($meals_text) ? $meals_text : 'Not Included';
    }

    public function getMealslabel()
    {
        $mealOptions = [];


        if ($this->breakfast_included == 1) {
            $mealOptions[] = 'Breakfast';
        }
        if ($this->lunch_included == 1) {
            $mealOptions[] = 'Lunch';
        }
        if ($this->dinner_included == 1) {
            $mealOptions[] = 'Dinner';
        }
        if ($this->meal_not_included == 1) {
            $mealOptions[] = 'Not Included';
        }

        return $mealOptions ? implode(', ', $mealOptions) : 'Not Included';
    }

    public function getTypes()
    {
        return $this->type = ShareSafari::TYPE_SAFARI ? "Share Safari" : "Fixed Departure";
    }

    public function getNecessaryfields()
    {
        if ($this->type = ShareSafari::TYPE_SAFARI) {
            return [
                'estimate_price_min' => $this->estimate_price_min,
                'estimate_price_max' => $this->estimate_price_max,
            ];
        } else {
            return [
                'cost_per_person' => $this->cost_per_person,
            ];
        }
    }
}
