<?php

namespace common\models\package;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property int $id
 * @property string $package_name
 * @property string $package_slug
 * @property int $no_of_day
 * @property int|null $no_of_night
 * @property int|null $no_of_safari
 * @property int|null $start_location
 * @property int|null $end_location
 * @property string|null $package_image
 * @property int|null $stay_category_id
 * @property float|null $cost_per_person
 * @property string|null $package_description
 * @property string|null $package_inclusion
 * @property string|null $package_exclusion
 * @property string|null $package_terms_condtition
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package';
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
            [['package_name', 'package_slug'], 'required'],
            [['no_of_day', 'no_of_night', 'no_of_safari', 'start_location', 'end_location', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['cost_per_person'], 'number'],
            [['package_description', 'package_inclusion', 'package_exclusion', 'package_terms_condtition'], 'string'],
            [['package_name'], 'string', 'max' => 512],
            [['package_slug'], 'string', 'max' => 720],
            [['package_image'], 'string', 'max' => 255],
            [['package_slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_name' => 'Package Name',
            'package_slug' => 'Package Slug',
            'no_of_day' => 'No Of Day',
            'no_of_night' => 'No Of Night',
            'no_of_safari' => 'No Of Safari',
            'start_location' => 'Start Location',
            'end_location' => 'End Location',
            'package_image' => 'Package Image',
            'stay_category_id' => 'Stay Category ID',
            'cost_per_person' => 'Cost Per Person',
            'package_description' => 'Package Description',
            'package_inclusion' => 'Package Inclusion',
            'package_exclusion' => 'Package Exclusion',
            'package_terms_condtition' => 'Package Terms Condtition',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
