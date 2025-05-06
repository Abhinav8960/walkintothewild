<?php

namespace common\models\quotations;

use Yii;

/**
 * This is the model class for table "quotations".
 *
 * @property int $id
 * @property string $objective
 * @property int $collection
 * @property int $collection_id
 * @property string $collection_uuid
 * @property int $travelers
 * @property string $start_date
 * @property int $user_id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string $submit_datetime
 * @property int $operator_id
 * @property int $stay_category_id
 * @property int $is_closed
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Quotation extends \yii\db\ActiveRecord
{


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
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'email'], 'default', 'value' => null],
            [['is_closed'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['objective', 'collection', 'collection_id', 'collection_uuid', 'travelers', 'start_date', 'user_id', 'name', 'submit_datetime', 'operator_id', 'stay_category_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['collection', 'collection_id', 'travelers', 'user_id', 'operator_id', 'stay_category_id', 'is_closed', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['start_date', 'submit_datetime'], 'safe'],
            [['objective', 'collection_uuid', 'name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'objective' => 'Objective',
            'collection' => 'Collection',
            'collection_id' => 'Collection ID',
            'collection_uuid' => 'Collection Uuid',
            'travelers' => 'Travelers',
            'start_date' => 'Start Date',
            'user_id' => 'User ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'submit_datetime' => 'Submit Datetime',
            'operator_id' => 'Operator ID',
            'stay_category_id' => 'Stay Category ID',
            'is_closed' => 'Is Closed',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}