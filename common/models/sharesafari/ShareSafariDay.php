<?php

namespace common\models\sharesafari;

use Yii;

/**
 * This is the model class for table "share_safari_day".
 *
 * @property int $id
 * @property int $share_safari_id
 * @property int $day
 * @property string|null $day_title
 * @property string|null $day_description
 * @property string|null $start_location
 * @property string|null $end_location
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $hotel_name
 * @property string|null $day_image
 * @property int|null $meal_lunch
 * @property int|null $meal_breakfast
 * @property int|null $meal_dinner
 * @property string|null $day_activity
 * @property string|null $day_accommodation
 * @property string|null $day_note
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class ShareSafariDay extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_day';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_id', 'day'], 'required'],
            [['share_safari_id', 'day', 'meal_lunch', 'meal_breakfast', 'meal_dinner', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['day_description', 'day_activity', 'day_accommodation', 'day_note'], 'string'],
            [['day_title'], 'string', 'max' => 512],
            [['start_location', 'end_location', 'hotel_name', 'day_image'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'string', 'max' => 50],
            // [['share_safari_id', 'day'], 'unique', 'targetAttribute' => ['share_safari_id', 'day']],
            [['partner_gallery_id', 'version','gallery_version'], 'integer'],
            [['gallery_json'], 'safe'],
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
            'day' => 'Day',
            'day_title' => 'Day Title',
            'day_description' => 'Day Description',
            'start_location' => 'Start Location',
            'end_location' => 'End Location',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'hotel_name' => 'Hotel Name',
            'day_image' => 'Day Image',
            'meal_lunch' => 'Meal Lunch',
            'meal_breakfast' => 'Meal Breakfast',
            'meal_dinner' => 'Meal Dinner',
            'day_activity' => 'Day Activity',
            'day_accommodation' => 'Day Accommodation',
            'day_note' => 'Day Note',
            'status' => 'Status',
            'partner_gallery_id' => 'Partner Gallery Id',
            'gallery_json' => 'Gallery Json',
            'gallery_version' => 'Gallery Version',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getImagepath()
    {
        if ($this->day_image != '') {
            return '/share_safari/day/' . $this->id . '/' . $this->day_image;
        }
    }
}
