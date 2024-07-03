<?php

namespace common\models\sharesafari;

use Yii;
use common\models\User;
use common\models\park\SafariPark;

/**
 * This is the model class for table "share_safari_history".
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
class ShareSafariHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_history';
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
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['start_date', 'end_date', 'slug'], 'safe'],
            [['safari_plan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
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

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }


    public function getIntrested()
    {
        return $this->hasMany(ShareSafariIntrested::className(), ['share_safari_id' => 'id']);
    }
}
