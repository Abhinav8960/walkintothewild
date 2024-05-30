<?php

namespace common\models\registration;

use Yii;

/**
 * This is the model class for table "birding_operator_request_activities".
 *
 * @property int $id
 * @property int|null $birding_operator_request_id
 * @property int|null $wildlife_activity_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class BirdingOperatorRequestActivities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'birding_operator_request_activities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birding_operator_request_id', 'wildlife_activity_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'birding_operator_request_id' => 'Birding Operator Request ID',
            'wildlife_activity_id' => 'Wildlife Activity ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
