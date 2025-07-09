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
            [['host_user_id', 'share_safari_request_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'tour_duration', 'cost_per_person', 'type'], 'integer'],
            [['start_date', 'end_date', 'slug', 'is_published_on_api', 'is_published_on_web'], 'safe'],
            [['is_published_on_api', 'is_published_on_web'], 'boolean'],
            [['safari_plan'], 'string'],
            [['image', 'filepath'], 'string'],
            [['version', 'share_safari_title', 'share_safari_id'], 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host_user_id' => 'Host User ID',
            'host_type' => 'Host Type',
            'park_id' => 'Park ID',
            'share_safari_agenda_id' => 'Share Safari Agenda ID',
            'no_of_safari' => 'No Of Safari',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'stay_category_id' => 'Stay Category ID',
            'estimate_price_min' => 'Estimate Price Min',
            'estimate_price_max' => 'Estimate Price Max',
            'safari_plan' => 'Safari Plan',
            'total_seat' => 'Total Seat',
            'share_seat' => 'Share Seat',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_published_on_api' => 'Is Published On Api',
            'is_published_on_web' => 'Is Published On Web',
            'status' => 'Status',
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


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'host_user_id']);
    }


    // public function getIntrested()
    // {
    //     return $this->hasMany(ShareSafariIntrested::className(), ['share_safari_id' => 'id']);
    // }


    public function getSharedimagepath()
    {

        return isset($this->filepath) ? (\Yii::$app->params['s3_endpoint'] . '/' . $this->filepath) : (isset($this->park) && isset($this->park->logo) ? $this->park->logoimagepath : '');
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
            // return $this->user ? $this->user->name : 'N/A';
            return $this->user ? $this->user->Safarioperatorname : 'N/A';
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


    // public function getSharesafarifollowerlist()
    // {
    //     if ($this->user &&  $this->user->userfollowers) {
    //         return $this->user->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);
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
}
