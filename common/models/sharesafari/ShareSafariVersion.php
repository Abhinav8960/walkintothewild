<?php

namespace common\models\sharesafari;

use common\models\operator\SafariOperator;
use Yii;
use common\models\User;
use common\models\park\SafariPark;
use common\traits\CommanRelationship;


class ShareSafariVersion extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;

    const NOT_APPROVED_STATUS = 0;
    const APPROVED_AND_LIVE_STATUS = 1;
    const SEND_FOR_APPROVAL_STATUS = 2;
    const EDIATBLE_STATUS = 3;
    const TERMINATED_STATUS = 4;


    const TYPE_SAFARI = 1;
    const TYPE_FIXED_DEPARTURE = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_version';
    }


    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_title'], 'string'],
            [['is_published_on_api', 'is_published_on_web'], 'boolean'],
            [['share_safari_inclusion', 'share_safari_exclusion'], 'string', 'max' => 2000],
            [['image_filepath'], 'string', 'max' => 512],
            [['safari_plan', 'getting_there', 'delete_reason'], 'string'],
            [['start_date', 'end_date', 'cut_off_date', 'gallery_json'], 'safe'],
            [['share_safari_id', 'share_safari_title', 'version'], 'required'],
            [['share_safari_id', 'version', 'type', 'host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'cost_per_person', 'total_seat', 'share_seat', 'tour_duration', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included', 'created_at', 'created_by', 'updated_at', 'updated_by', 'delete_reason_id', 'status', 'is_published_on_api', 'is_published_on_web', 'total_view', 'pined_safari', 'final_approved_at', 'partner_gallery_id'], 'integer'],
            [['host_user_id', 'safari_operator_id', 'user_id'], 'integer'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'version' => 'Version',
            'share_safari_title' => 'Share Safari Title',
            'type' => 'Type',
            'host_user_id' => 'Host User ID',
            'safari_operator_id' => 'Host Partner ID',
            'user_id' => 'User ID',
            'host_type' => 'Host Type',
            'park_id' => 'Park ID',
            'share_safari_agenda_id' => 'Share Safari Agenda ID',
            'no_of_safari' => 'No Of Safari',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'cut_off_date' => 'Cut Off Date',
            'image_filepath' => 'Image Filepath',
            'stay_category_id' => 'Stay Category ID',
            'estimate_price_min' => 'Estimate Price Min',
            'estimate_price_max' => 'Estimate Price Max',
            'cost_per_person' => 'Cost Per Person',
            'safari_plan' => 'Safari Plan',
            'total_seat' => 'Total Seat',
            'share_seat' => 'Share Seat',
            'tour_duration' => 'Tour Duration',
            'share_safari_inclusion' => 'Share Safari Inclusion',
            'share_safari_exclusion' => 'Share Safari Exclusion',
            'getting_there' => 'Getting There',
            'breakfast_included' => 'Breakfast Included',
            'lunch_included' => 'Lunch Included',
            'dinner_included' => 'Dinner Included',
            'meal_not_included' => 'Meal Not Included',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'delete_reason_id' => 'Delete Reason ID',
            'delete_reason' => 'Delete Reason',
            'status' => 'Status',
            'is_published_on_api' => 'Is Published On Api',
            'is_published_on_web' => 'Is Published On Web',
            'total_view' => 'Total View',
            'pined_safari' => 'Pined Safari',
            'final_approved_at' => 'Final Approved At',
            'partner_gallery_id' => 'Partner Gallery ID',
            'gallery_json' => 'Gallery Json',
        ];
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getParklist()
    {
        return $this->hasMany(ShareSafariParklist::className(), ['id' => 'share_safari_id', 'version' => 'version']);
    }


    // public function getUser()
    // {
    //     return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    // }

    public function getHostUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id']);
    }


    // public function getIntrested()
    // {
    //     return $this->hasMany(ShareSafariIntrested::className(), ['share_safari_id' => 'id']);
    // }


    public function getSharedimagepath()
    {

        return isset($this->image_filepath) ? (\Yii::$app->params['s3_endpoint'] . '/' . $this->image_filepath) : (isset($this->park) && isset($this->park->logo) ? $this->park->logoimagepath : '');
    }

    public function getComments()
    {
        return $this->hasMany(ShareSafariComment::class, ['share_safari_id' => 'share_safari_id']);
    }

    /**
     * Get Host Type
     */
    // public function getHosttype()
    // {
    //     $options = [
    //         1 => 'Individual',
    //         2 => 'Wildlife Influencer',
    //         3 => 'Wildlife Influencer',
    //         4 => 'Safari Tour Operator'
    //     ];
    //     return isset($options[$this->host_type]) ? $options[$this->host_type] : $this->host_type;
    // }



    public function getOrganizedbyname()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            // return $this->hostUser ? $this->hostUser->name : 'N/A';
            return $this->hostUser ? $this->hostUser->Safarioperatorname : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->safarioperator) ? $this->safarioperator->businessname : "N/A";
        }
    }

    public function getOrganizedbyuserhandel()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->hostUser ? $this->hostUser->user_handle : 'N/A';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return isset($this->safarioperator) ? $this->safarioperator->businessname : "N/A";
        }
    }
    public function getOrganizedbyimage()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->hostUser ? $this->hostUser->profileimage : '';
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return $this->safarioperator &&  $this->safarioperator->logo  ? $this->safarioperator->imagepath : '';
        }
    }
    public function getOrganizedbyprofileurl()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return \yii\helpers\Url::toRoute(['/profile/default/index', 'user_handle' => $this->hostUser ? $this->hostUser->user_handle : '']);
        } else if ($this->type == ShareSafari::TYPE_FIXED_DEPARTURE) {
            return \yii\helpers\Url::toRoute(['/operator/default/sharedsafari', 'slug' => $this->safarioperator ? $this->safarioperator->slug : '']);
        }
    }

    public function getSharesafariIncludeds()
    {
        return $this->hasMany(ShareSafariIncluded::class, ['share_safari_id' => 'share_safari_id', 'version' => 'version']);
    }

    public function getSharesafaridays()
    {
        return $this->hasMany(ShareSafariDay::class, ['share_safari_id' => 'share_safari_id', 'version' => 'version']);
    }


    public function getOrganizedslug()
    {
        if ($this->type == ShareSafari::TYPE_SAFARI) {
            return $this->hostUser ? $this->hostUser->user_handle : 'N/A';
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


    // public function getSharesafarifollowerlist()
    // {
    //     if ($this->hostUser &&  $this->hostUser->userfollowers) {
    //         return $this->hostUser->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);
    //     }
    // }

    // public function getFixeddeparturefollowerlist()
    // {
    //     if ($this->safarioperator && $this->safarioperator->followerlist) {
    //         return $this->safarioperator->getFollowerlist()->joinWith('user')->where(['user_follower.status' => 1, 'user.status' => User::STATUS_ACTIVE]);
    //     }
    // }


    // public function savehistory()
    // {

    //     $historyModel = new ShareSafariHistory();
    //     $historyModel->attributes = $this->attributes;
    //     $historyModel->parent_id = $this->id;

    //     if (!$historyModel->save(false)) {
    //         Yii::error('Failed to save ShareSafariHistory: ' . print_r($historyModel->errors, true), __METHOD__);
    //     }
    // }

    // public function getSharedSafariHistory()
    // {
    //     $count = ShareSafariHistory::find()->where(['parent_id' => $this->id, 'status' => ShareSafariHistory::STATUS_ACTIVE, 'type' => ShareSafari::TYPE_SAFARI])->count();
    //     if ($count >= 2) {
    //         return true;
    //     }
    //     return false;
    // }

    // public function getFixedDepartureHistory()
    // {
    //     $count = ShareSafariHistory::find()->where(['parent_id' => $this->id, 'status' => ShareSafariHistory::STATUS_ACTIVE, 'type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'mail_sent' => 1])->count();
    //     if ($count >= 2) {
    //         return true;
    //     }
    //     return false;
    // }

    // public function getCommentCount()
    // {
    //     $count = ShareSafariComment::find()->where(['share_safari_id' => $this->id])->andWhere(['status' => 1])->count();
    //     if ($count > 0) {
    //         return $count;
    //     }
    //     return 0;
    // }

    public function getStatustags()
    {
        if ($this->status == ShareSafariVersion::NOT_APPROVED_STATUS) {
            return "<img src='" .  \Yii::$app->view->params['baseurl'] . "/images/terminated.svg'>";
        } else if ($this->status == ShareSafariVersion::APPROVED_AND_LIVE_STATUS) {
            return "<img src='" .  \Yii::$app->view->params['baseurl'] . "/images/live.svg'>";
        } else if ($this->status == ShareSafariVersion::SEND_FOR_APPROVAL_STATUS) {
            return "<img src='" .  \Yii::$app->view->params['baseurl'] . "/images/pending.svg'>";
        } else if ($this->status == ShareSafariVersion::EDIATBLE_STATUS) {
            return "<img src='" .  \Yii::$app->view->params['baseurl'] . "/images/draft.svg'>";
        } else if ($this->status == ShareSafariVersion::TERMINATED_STATUS) {
            return "<img src='" .  \Yii::$app->view->params['baseurl'] . "/images/terminated.svg'>";
        }
    }


    public function getLiveShareSafari()
    {
        return $this->hasOne(ShareSafariVersion::class, ['share_safari_id' => 'share_safari_id'])->andWhere(['status' => ShareSafariVersion::APPROVED_AND_LIVE_STATUS]);
    }

    public function getDisplayShareSafari()
    {
        if (!empty($this->liveShareSafari)) {
            return $this->liveShareSafari;
        }
        return $this;
    }
}
