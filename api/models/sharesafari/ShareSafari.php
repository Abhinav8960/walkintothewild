<?php

namespace api\models\sharesafari;

use api\models\master\packageinclude\MasterPackageInclude;
use Yii;
use api\models\User;
use api\models\park\SafariPark;
use api\models\sharesafari\ShareSafariComment;
use api\models\sharesafari\ShareSafariDay;
use api\models\sharesafari\ShareSafariGallery;
use api\models\sharesafari\ShareSafariIncluded;
use api\models\sharesafari\ShareSafariIntrested;
use api\models\sharesafari\ShareSafariParklist;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorRating;
use api\models\UserFollow;
use api\models\UserWishlist;

class ShareSafari extends \common\models\sharesafari\ShareSafari
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'types';
        $fields[] = 'organizedbyname';
        $fields[] = 'organizedbyimage';
        $fields[] = 'organizedslug';
        $fields[] = 'hosttype';
        $fields[] = 'sharedimagepath';
        $fields[] = 'seatfullStatus';
        $fields[] = 'isWishlist';
        $fields[] = 'witwaveragerating';
        $fields[] = 'Witwreviewcount';
        $fields[] = 'isFollowed';
        $fields[] = 'urls';

        $hold_fields = [
            'id',
            'safari_plan',
            'website_url',
            'share_safari_inclusion',
            'share_safari_exclusion',
            'share_safari_terms_condtition',
            'date_change_policy',
            'refund_policy',
            'getting_there',
            'breakfast_included',
            'mail_sent',
            'delete_reason_id',
            'delete_reason',
            'share_safari_request_id',
            'share_safari_agenda_id',
            'stay_category_id',
            'type',
            'image',
            'privacy_policy',
            'change_policy',
            'what_you_must_carry',
            'park_id',
            'total_view',
            'host_user_id',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'created_by',
            'updated_at',
            'host_type'
        ];
        if (in_array(\Yii::$app->controller->layout, [SELF::SHARE_SAFARI_API_LAYOUT_FULL])) {
            $fields[] = 'types';
            $fields[] = 'sharesafariagenda';
            $fields[] = 'budget';
            $fields[] = 'park';
            // $fields[] = 'intrestedUser';

            $full_hold_fields = [
                'id',
                'mail_sent',
                'delete_reason_id',
                'delete_reason',
                'share_safari_request_id',
                'share_safari_agenda_id',
                'type',
                'image',
                'privacy_policy',
                'change_policy',
                'what_you_must_carry',
                'park_id',
                'total_view',
                'host_user_id',
                'status',
                'created_by',
                'updated_by',
                'created_at',
                'created_by',
                'updated_at',
                'host_type'
            ];
            $new_fields =  array_intersect($hold_fields, $full_hold_fields);
            return array_diff($fields, $new_fields);
        }
        return array_diff($fields, $hold_fields);
        return $fields;

        // if (!in_array(\Yii::$app->controller->action->uniqueId,  ['park/default/view'])) {
        //     $fields[] = 'types';
        //     $fields[] = 'sharesafariagenda';
        //     $fields[] = 'budget';
        //     $fields[] = 'organizedbyname';
        //     $fields[] = 'hosttype';
        //     $fields[] = 'sharedimagepath';
        //     $fields[] = 'park';
        //     $fields[] = 'includeds';
        //     $fields[] = 'sharesafaridays';
        //     $fields[] = 'sharesafarigallery';
        //     if (!in_array(\Yii::$app->controller->action->uniqueId,  ['profile/default/index'])) {
        //         $fields[] = 'intrestedUser';
        //         // $fields[] = 'comments';
        //     }
        //     $fields[] = 'sharesafariFaqs';
        //     $fields[] = 'isWishlist';
        //     $fields[] = 'organizedbyimage';
        //     $fields[] = 'witwaveragerating';
        //     $fields[] = 'Witwreviewcount';
        //     $fields[] = 'isFollowed';
        //     $fields[] = 'organizedslug';
        //     $fields[] = 'seatfullStatus';

        //     $hold_fields = [
        //         'delete_reason_id',
        //         'delete_reason',
        //         'share_safari_request_id',
        //         'share_safari_agenda_id',
        //         'stay_category_id',
        //         'type',
        //         'image',
        //         'privacy_policy',
        //         'change_policy',
        //         'what_you_must_carry',
        //         'park_id',
        //         'total_view',
        //         'host_user_id',
        //         'status',
        //         'created_by',
        //         'updated_by',
        //         'created_at',
        //         'created_by',
        //         'updated_at',
        //         'host_type'
        //     ];
        // } else {
        //     $fields[] = 'types';
        //     $fields[] = 'sharesafariagenda';
        //     $fields[] = 'budget';
        //     $fields[] = 'organizedbyname';
        //     $fields[] = 'hosttype';
        //     $fields[] = 'sharedimagepath';
        //     $fields[] = 'intrestedUser';
        //     $fields[] = 'organizedbyimage';
        //     $fields[] = 'organizedslug';
        //     $fields[] = 'seatfullStatus';

        //     $hold_fields = [
        //         'delete_reason_id',
        //         'delete_reason',
        //         'share_safari_request_id',
        //         'share_safari_agenda_id',
        //         'stay_category_id',
        //         'type',
        //         'image',
        //         'park',
        //         'privacy_policy',
        //         'change_policy',
        //         'what_you_must_carry',
        //         'park_id',
        //         'total_view',
        //         'host_user_id',
        //         'status',
        //         'created_by',
        //         'updated_by',
        //         'created_at',
        //         'created_by',
        //         'updated_at',
        //         'host_type'
        //     ];
        // }

        // return array_diff($fields, $hold_fields);
        // return $fields;
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
        return $this->hasMany(ShareSafariIntrested::className(), ['share_safari_id' => 'id'])->andWhere(['share_safari_intrested.status' => 1]);
    }

    public function getIntrestedUser()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->via('intrested');
    }

    public function getSharedimagepath()
    {

        return isset($this->image) ? (\Yii::$app->params['frontend_url_for_api'] . 'storage/share_safari/' . $this->id . '/' . $this->image) : (isset($this->park) && isset($this->park->logo) ? $this->park->logoimagepath : '');
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

    public function getIncludeds()
    {
        return $this->hasMany(ShareSafariIncluded::class, ['share_safari_id' => 'id']);

        // return $this->hasMany(MasterPackageInclude::class, ['id' => 'include_id'])->via('sharesafariIncludeds');
    }

    public function getSharesafaridays()
    {
        return $this->hasMany(ShareSafariDay::class, ['share_safari_id' => 'id']);
    }

    public function getSharesafarigallery()
    {
        return $this->hasMany(ShareSafariGallery::className(), ['share_safari_id' => 'id']);
    }

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
        return $this->type == ShareSafari::TYPE_SAFARI ? "Share Safari" : "Fixed Departure";
    }

    // public function getSharesafariagenda()
    // {
    //     return $this->share_safari_agenda_id == 1 ? "Photography" : "Safari Experience";
    // }

    public function getSharesafariagenda()
    {
        $options = [
            '1' => 'Photography',
            // '2' => 'Vlogging',
            '3' => 'Safari Experience'
        ];
        return isset($options[$this->share_safari_agenda_id]) ? $options[$this->share_safari_agenda_id] : $this->share_safari_agenda_id;
    }

    public function getBudget()
    {
        $options = [
            '1' => 'Premium',
            '2' => 'Standard',
            '3' => 'Economical',
            '4' => 'Not Included',

        ];
        return isset($options[$this->stay_category_id]) ? $options[$this->stay_category_id] : $this->stay_category_id;
    }

    public function getSharesafariFaqs()
    {
        return $this->hasMany(ShareSafariFaq::className(), ['share_safari_id' => 'id']);
    }


    public function getActiveUserWishlist()
    {
        return $this->hasOne(UserWishlist::className(), ['item_id' => 'id'])->where(['user_id' => \Yii::$app->params['active_user_id'], 'item_type_id' => 2])->andWhere(['user_wishlist.status' => 1]);
    }



    public function getIsWishlist()
    {
        $is_whislist = $this->activeUserWishlist;
        if (!empty($is_whislist)) {
            return true;
        }
        return false;
    }

    public function getWitwaveragerating()
    {
        if (isset($this->safarioperator)) {
            $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $this->safarioperator->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->average('rating');
            return round($avg, 1);
        }
        return 0;
    }

    public function getWitwreviewcount()
    {
        if (isset($this->safarioperator)) {
            return SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $this->safarioperator->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->count();
        }
        return 0;
    }

    public function getActiveFollowed()
    {
        if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            if ($this->safarioperator) {
                return UserFollow::find()->where(['follow_user_id' => $this->safarioperator->user_id])->andWhere(['user_id' => \Yii::$app->params['active_user_id']])->andWhere(['user_follower.status' => 1])->limit(1)->one();
            }
        } else if ($this->type == ShareSafari::TYPE_SAFARI) {
            return UserFollow::find()->where(['follow_user_id' => $this->host_user_id])->andWhere(['user_id' => \Yii::$app->params['active_user_id']])->andWhere(['user_follower.status' => 1])->limit(1)->one();
        }
    }

    public function getIsFollowed()
    {
        $is_followed = $this->activeFollowed;
        if (!empty($is_followed)) {
            return true;
        }
        return false;
    }

    public function getSeatfullStatus()
    {
        if ($this->status == ShareSafari::STATUS_FULL_SEAT) {
            return true;
        }
        return false;
    }

    public function getOrganizedId()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->id : '';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->safarioperator) ? $this->safarioperator->user->id : '';
        }
    }

    public function getUrls()
    {
        return [
            'intrested_users' => Yii::$app->params['api_url'] . '/sharesafari/' . $this->slug . '/intrested-user'
        ];
    }
}
