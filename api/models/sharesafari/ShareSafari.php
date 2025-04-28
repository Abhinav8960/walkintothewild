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


        $fields = ['id', 'have_you_joined', 'share_safari_title', 'slug', 'no_of_safari', 'start_date', 'end_date', 'cut_off_date', 'total_seat', 'share_seat', 'types', 'organized_by_name', 'organized_by_image', 'organized_slug', 'shared_image_path', 'seat_full_status', 'is_wishlist', 'is_followed', 'interseted_user_count', 'park_title', 'status'];
        $fields[] = 'resource_uri';
        $fields[] = 'can_comment';
        $fields[] = 'can_reply';
        $fields[] = 'is_safari_operator';

        if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            $fields['cost_per_person'] =  function () {
                return (int) ceil($this->cost_per_person);
            };
        } else {
            $fields['estimate_price_min'] = function () {
                return (int) ceil($this->estimate_price_min);
            };
            $fields['estimate_price_max'] = function () {
                return (int) ceil($this->estimate_price_max);
            };
        }

        if (in_array(\Yii::$app->controller->layout, [SELF::SHARE_SAFARI_API_LAYOUT_FULL])) {

            $fields[] = 'website_url';
            $fields[] = 'witw_average_rating';
            $fields[] = 'witw_review_count';
            $fields['breakfast_included'] = function () {
                return (bool) $this->breakfast_included;
            };
            $fields['lunch_included'] = function () {
                return (bool) $this->lunch_included;
            };
            $fields['dinner_included'] = function () {
                return (bool) $this->dinner_included;
            };
            $fields['meal_not_included'] = function () {
                return (bool) $this->meal_not_included;
            };
            $fields[] = 'faqs';
            $fields[] = 'meals_label';

            $fields[] = 'share_safari_inclusion';
            $fields[] = 'share_safari_exclusion';
            $fields[] = 'share_safari_terms_condtition';
            $fields[] = 'date_change_policy';
            $fields[] = 'refund_policy';
            $fields[] = 'getting_there';
            $fields[] = 'includeds';
            $fields[] = 'share_safari_days';
            $fields[] = 'safari_plan';
            $fields[] = 'urls';
            $fields[] = 'types';
            $fields[] = 'share_safari_agenda';
            $fields[] = 'budget';
            $fields[] = 'comments_count';
            $fields[] = 'parks';
            $fields[] = 'share_safari_agenda_id';
            $fields[] = 'status';
        }
        return $fields;
    }



    public function getStatuslabel()
    {

        $options = [ShareSafari::STATUS_ACTIVE => 'Published', ShareSafari::STATUS_SUSPEND => 'Inactive', ShareSafari::STATUS_FULL_SEAT => 'Seat Full'];
        return isset($options[$this->status]) ? $options[$this->status] : '';
    }

    public function getParks()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->hasMany(SafariPark::className(), ['id' => 'park_id']);
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return $this->getFixedDeparturePark();
        }
    }

    public function getPark_title()
    {
        foreach ($this->parks as $park) {
            return $park->title ?? NULL;
        }
    }

    public function getShareSafariParklist()
    {
        return $this->hasMany(ShareSafariParklist::className(), ['share_safari_id' => 'id']);
    }


    public function getFixedDeparturePark()
    {
        return $this->hasMany(SafariPark::className(), ['id' => 'park_id'])->via('shareSafariParklist');
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'host_user_id']);
    }


    public function getIntrested()
    {
        return $this->hasMany(ShareSafariIntrested::className(), ['share_safari_id' => 'id'])->andWhere(['share_safari_intrested.status' => 1]);
    }

    public function getHave_you_joined()
    {
        return $this->getIntrested()->andWhere(['share_safari_intrested.user_id' => \Yii::$app->params['active_user_id']])->joinWith('user')->andWhere(['user.status' => 10])->exists();
    }

    public function getIntrestedUser()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->via('intrested');
    }

    public function getInterseted_user_count()
    {
        return $this->getIntrestedUser()->count();
    }



    public function getShared_image_path()
    {

        return isset($this->image) ? (\Yii::$app->params['frontend_url_for_api'] . 'storage/share_safari/' . $this->id . '/' . $this->image) : (isset($this->park) && isset($this->park->logo) ? $this->park->logoimagepath : '');
    }

    public function getComments()
    {
        return $this->hasMany(ShareSafariComment::class, ['share_safari_id' => 'id']);
    }

    public function getComments_count()
    {
        return $this->getComments()->where(['parent_id' => null])->count();
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



    public function getOrganized_by_name()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->name : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->partner) ? $this->partner->businessname : "N/A";
        }
    }

    public function getOrganized_by_userhandel()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->user_handle : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->partner) ? $this->partner->businessname : "N/A";
        }
    }
    public function getOrganized_by_image()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->profileimage : '';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return $this->partner &&  $this->partner->logo  ? $this->partner->imagepath : '';
        }
    }
    public function getOrganized_by_profileurl()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return \yii\helpers\Url::toRoute(['/profile/default/index', 'user_handle' => $this->user ? $this->user->user_handle : '']);
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return \yii\helpers\Url::toRoute(['/operator/default/sharedsafari', 'slug' => $this->partner ? $this->partner->slug : '']);
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

    public function getShare_safari_days()
    {
        return $this->hasMany(ShareSafariDay::class, ['share_safari_id' => 'id']);
    }

    public function getSharesafarigallery()
    {
        return $this->hasMany(ShareSafariGallery::className(), ['share_safari_id' => 'id']);
    }

    public function getOrganized_slug()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->user ? $this->user->user_handle : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->partner) ? $this->partner->slug : "N/A";
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

    public function getMeals_label()
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

    // public function getShare_safari_agenda()
    // {
    //     return $this->share_safari_agenda_id == 1 ? "Photography" : "Safari Experience";
    // }

    public function getShare_safari_agenda()
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
        return $this->hasMany(ShareSafariFaq::className(), ['share_safari_id' => 'id'])->where(['share_safari_faq.status' => ShareSafariFaq::STATUS_ACTIVE]);
    }

    public function getFaqs()
    {
        if ($this->getSharesafariFaqs()->count() > 0) {
            return $this->sharesafariFaqs;
        }
        return   [
            [
                'question' => "Are meals included in the Fixed Departure?",
                'answer' => $this->meals == 'Included' ? "Yes: Meals are included and will be provided as per the itinerary." : "No: Meals are not included; it will be charged additionally.",
            ],
            [
                'question' => "Does the Fixed Departure include transport to and from the resort?",
                'answer' => $this->getIncludeds()->where(['include_id' => 3, 'selection' => 1, 'status' => 1])->limit(1)->exists() == true ? ">Yes: Transport to and from the resort is included in the Fixed Departure." : "No: Transport is not included; you will need to arrange your own.",
            ],
            [
                'question' => "Are accommodation arrangements included in the Fixed Departure?",
                'answer' => $this->getIncludeds()->where(['include_id' => 1, 'selection' => 1, 'status' => 1])->limit(1)->exists() == true ? "Yes: Accomodation is included." : "No: Accomodation is not included.",
            ],

        ];
    }


    public function getActiveUserWishlist()
    {
        return $this->hasOne(UserWishlist::className(), ['item_id' => 'id'])->where(['user_id' => \Yii::$app->params['active_user_id'], 'item_type_id' => 2])->andWhere(['user_wishlist.status' => 1]);
    }



    public function getIs_wishlist()
    {
        $is_whislist = $this->activeUserWishlist;
        if (!empty($is_whislist)) {
            return true;
        }
        return false;
    }

    public function getWitw_average_rating()
    {
        if (isset($this->partner)) {
            $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $this->partner->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->average('rating');
            return round($avg, 1);
        }
        return 0;
    }

    public function getWitw_review_count()
    {
        if (isset($this->partner)) {
            return SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $this->partner->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->count();
        }
        return 0;
    }

    public function getActiveFollowed()
    {
        if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            if ($this->partner) {
                return UserFollow::find()->where(['follow_user_id' => $this->partner->user_id])->andWhere(['user_id' => \Yii::$app->params['active_user_id']])->andWhere(['user_follower.status' => 1])->limit(1)->one();
            }
        } else if ($this->type == ShareSafari::TYPE_SAFARI) {
            return UserFollow::find()->where(['follow_user_id' => $this->host_user_id])->andWhere(['user_id' => \Yii::$app->params['active_user_id']])->andWhere(['user_follower.status' => 1])->limit(1)->one();
        }
    }

    public function getIs_followed()
    {
        $is_followed = $this->activeFollowed;
        if (!empty($is_followed)) {
            return true;
        }
        return false;
    }

    public function getSeat_full_status()
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
            return isset($this->partner) ? $this->partner->user->id : '';
        }
    }

    public function getUrls()
    {
        return [
            'intrested_users' => Yii::$app->params['api_url'] . '/sharesafari/' . $this->slug . '/intrested-user',
            'comments' => Yii::$app->params['api_url'] . '/sharesafari/' . $this->slug . '/comment-view'
        ];
    }

    public function getResource_uri()
    {
        return Yii::$app->params['frontend_url'] . '/sharedsafari/' . $this->getOrganized_slug() . '/' . $this->slug;
    }


    public function getCan_comment()
    {
        $login_partner = SafariOperator::find()->where(['user_id' => \Yii::$app->params['active_user_id']])->limit(1)->one();
        if ($this->getHave_you_joined() || \Yii::$app->params['active_user_id'] ==  $this->host_user_id || (!empty($login_partner) && $this->host_user_id == $login_partner->id)) {
            return true;
        }
        return false;
    }

    public function getCan_reply()
    {
        $login_partner = SafariOperator::find()->where(['user_id' => \Yii::$app->params['active_user_id']])->limit(1)->one();
        if ($this->getHave_you_joined() || \Yii::$app->params['active_user_id'] ==  $this->host_user_id || (!empty($login_partner) && $this->host_user_id == $login_partner->id)) {
            return true;
        }
        return false;
    }

    public function getIs_safari_operator()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            if ($user = $this->user) {
                return $user->operator ? true : false;
            }
            return false;
        }
        if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return true;
        }
    }
}
