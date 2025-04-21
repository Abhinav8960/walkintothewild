<?php

namespace common\models\packageapproval;

use Yii;

/**
 * This is the model class for table "package_day".
 *
 * @property int $id
 * @property int $package_id
 * @property int $day
 * @property string|null $day_title
 * @property string|null $day_description
 * @property string|null $start_location
 * @property string|null $end_location
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
class PackageDay extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package_day_approval';
    }

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
            [['package_id', 'day'], 'required'],
            [['package_id', 'day', 'meal_lunch', 'meal_breakfast', 'meal_dinner', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['day_description', 'day_activity', 'day_accommodation', 'day_note'], 'string'],
            [['day_title'], 'string', 'max' => 512],
            [['start_location', 'end_location', 'hotel_name', 'day_image'], 'string', 'max' => 255],
            [['package_id', 'day'], 'unique', 'targetAttribute' => ['package_id', 'day']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_id' => 'Package ID',
            'day' => 'Day',
            'day_title' => 'Day Title',
            'day_description' => 'Day Description',
            'start_location' => 'Start Location',
            'end_location' => 'End Location',
            'hotel_name' => 'Hotel Name',
            'day_image' => 'Day Image',
            'meal_lunch' => 'Meal Lunch',
            'meal_breakfast' => 'Meal Breakfast',
            'meal_dinner' => 'Meal Dinner',
            'day_activity' => 'Day Activity',
            'day_accommodation' => 'Day Accommodation',
            'day_note' => 'Day Note',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getImagepath()
    {
        if ($this->day_image != '') {
            return '/package/day/' . $this->id . '/' . $this->day_image;
        }
    }
}
