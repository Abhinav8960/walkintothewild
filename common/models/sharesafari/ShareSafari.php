<?php

namespace common\models\sharesafari;

use common\models\feeds\Feeds;
use common\models\operator\SafariOperator;
use Yii;
use common\models\User;
use common\models\park\SafariPark;
use common\traits\CommanRelationship;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "share_safari".
 *
 * @property int $id
 * @property int $host_user_id
 * @property int|null $host_type
 * @property int|null $park_id
 * @property int|null $share_safari_agenda_id
 * @property int|null $no_of_safari
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $stay_category_id
 * @property int|null $estimate_price_min
 * @property int|null $estimate_price_max
 * @property string|null $safari_plan
 * @property int|null $total_seat
 * @property int|null $share_seat
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ShareSafari extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;


    // const STATUS_APPROVED = 1;
    // const STATUS_SUSPEND = 2;
    const STATUS_FULL_SEAT = 2;

    const TYPE_SAFARI = 1;
    const TYPE_FIXED_DEPARTURE = 2;

    const STATUS_DELETE_BY_USER = -2;

    const OBJECTIVE = "share_safari";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari';
    }


    public function behaviors()
    {
        return [
            [
                'class' => \common\behaviors\FeedsBehavior::class,
                'objective' => 'share_safari',
                'collection' => Feeds::MODEL_SHARESFARI,
                'date_time' => 'start_date',
            ],
            [
                'class' => \common\behaviors\FootprintsBehavior::class,
                'objective' => self::OBJECTIVE,
                'collection' => \common\models\trackings\Footprints::MODEL_SHARESFARI,
            ],

            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'share_safari_title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
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
            [['safari_operator_id', 'user_id', 'gallery_version'], 'integer'],
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
            'safari_operator_id' => 'Host Partner ID',
            'user_id' => 'User ID',
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

    public function getStatuslabel()
    {

        $options = [ShareSafari::STATUS_ACTIVE => 'Published', ShareSafari::STATUS_SUSPEND => 'Inactive', ShareSafari::STATUS_FULL_SEAT => 'Seat Full', ShareSafari::STATUS_DELETE_BY_USER => 'Delete by User'];
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

    public function getHostUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id']);
    }


    public function getIntrested()
    {
        return $this->hasMany(ShareSafariIntrested::className(), ['share_safari_id' => 'id']);
    }

    // public function getSharedimagepath()
    // {

    //     return isset($this->image) ? (\Yii::$app->params['s3_endpoint'] . '/share_safari/' . $this->id . '/' . $this->image) : (isset($this->park) && isset($this->park->logo) ? $this->park->logoimagepath : '');
    // }

    public function getSharedimagepath()
    {

        return isset($this->image_filepath) ? (\Yii::$app->params['s3_endpoint'] . '/' . $this->image_filepath) : (isset($this->park) && isset($this->park->logo) ? $this->park->logoimagepath : '');
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
            return $this->hostUser ? $this->hostUser->profile_display_image : '';
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
        return $this->hasMany(ShareSafariIncluded::class, ['share_safari_id' => 'id', 'version' => 'live_version']);
    }

    public function getSharesafaridays()
    {
        return $this->hasMany(ShareSafariDay::class, ['share_safari_id' => 'id', 'version' => 'live_version']);
    }

    public function getSharesafarigallery()
    {
        return $this->hasMany(ShareSafariGallery::className(), ['share_safari_id' => 'id']);
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


    public function getSharesafarifollowerlist()
    {
        if ($this->hostUser &&  $this->hostUser->userfollowers) {
            return $this->hostUser->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);
        }
    }

    public function getFixeddeparturefollowerlist()
    {
        if ($this->safarioperator && $this->safarioperator->followerlist) {
            return $this->safarioperator->getFollowerlist()->joinWith('user')->where(['user_follower.status' => 1, 'user.status' => User::STATUS_ACTIVE]);
        }
    }


    public function savehistory()
    {

        $historyModel = new ShareSafariHistory();
        $historyModel->attributes = $this->attributes;
        $historyModel->parent_id = $this->id;

        if (!$historyModel->save(false)) {
            Yii::error('Failed to save ShareSafariHistory: ' . print_r($historyModel->errors, true), __METHOD__);
        }
    }

    public function getSharedSafariHistory()
    {
        $count = ShareSafariHistory::find()->where(['parent_id' => $this->id, 'status' => ShareSafariHistory::STATUS_ACTIVE, 'type' => ShareSafari::TYPE_SAFARI])->count();
        if ($count >= 2) {
            return true;
        }
        return false;
    }

    public function getFixedDepartureHistory()
    {
        $count = ShareSafariHistory::find()->where(['parent_id' => $this->id, 'status' => ShareSafariHistory::STATUS_ACTIVE, 'type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'mail_sent' => 1])->count();
        if ($count >= 2) {
            return true;
        }
        return false;
    }

    public function getCommentCount()
    {
        $count = ShareSafariComment::find()->where(['share_safari_id' => $this->id])->andWhere(['status' => 1])->count();
        if ($count > 0) {
            return $count;
        }
        return 0;
    }

    public static function generateUnqiueSlug($share_safari_title)
    {
        $slug = \yii\helpers\Inflector::slug($share_safari_title);
        $count = 0;
        while (self::find()->where(['slug' => $slug])->exists()) {
            $count++;
            $slug = \yii\helpers\Inflector::slug($share_safari_title) . '-' . $count;
        }
        return $slug;
    }

    public function getEditable_fd()
    {
        return $this->hasOne(ShareSafariVersion::className(), ['share_safari_id' => 'id', 'version' => 'editable_version']);
    }

    public function getLive_fd()
    {
        return $this->hasOne(ShareSafariVersion::className(), ['share_safari_id' => 'id', 'version' => 'live_version']);
    }

    public function getDisplayShareSafari()
    {
        if ($this->live_fd) {
            return $this;
        }
        return $this->editable_fd;
    }
}
