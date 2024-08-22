<?php

namespace common\models\sharesafari;

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
class ShareSafari extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;


    const STATUS_APPROVED = 1;
    const STATUS_SUSPEND = 2;
    const STATUS_FULL_SEAT = 3;

    const TYPE_SAFARI = 1;
    const TYPE_FIXED_DEPARTURE = 2;

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
            [['start_date', 'end_date', 'slug'], 'safe'],
            [['safari_plan'], 'string'],
            [['image'], 'string'],
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
            'status' => 'Status',
        ];
    }

    public function getStatuslabel()
    {

        $options = [ShareSafari::STATUS_APPROVED => 'Published', ShareSafari::STATUS_SUSPEND => 'Inactive', ShareSafari::STATUS_FULL_SEAT => 'Seat Full'];
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
        $options = [1 => 'Individual', 2 => 'Wildlife Photographer', 3 => 'Wildlife Influencer', 4 => 'Safari Tour Operator'];
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

    public function getSharesafariIncludeds()
    {
        return $this->hasMany(ShareSafariIncluded::class, ['share_safari_id' => 'id']);
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
        $package_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $this->id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();

        $meals_text = '';
        if ($package_includes) {
            $meals_text = 'Breakfast, ';
        }

        $package_includes_lunch = ShareSafariIncluded::find()->where(['share_safari_id' => $this->id, 'include_id' => 7, 'selection' => 1, 'status' => 1])->limit(1)->one();
        if ($package_includes_lunch) {
            $meals_text .= 'Lunch, ';
        }

        $package_includes_dinner = ShareSafariIncluded::find()->where(['share_safari_id' => $this->id, 'include_id' => 8, 'selection' => 1, 'status' => 1])->limit(1)->one();
        if ($package_includes_dinner) {
            $meals_text .= 'Dinner, ';
        }

        return ($meals_text) ? substr($meals_text, 0, -2) : 'N/A';
    }
}
