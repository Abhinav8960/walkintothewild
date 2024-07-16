<?php

namespace common\models\registration;

use Yii;

/**
 * This is the model class for table "birding_operator_request_park".
 *
 * @property int $id
 * @property int|null $birding_operator_request_id
 * @property int|null $park_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 */
class BirdingOperatorRequestPark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'birding_operator_request_park';
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
            [['birding_operator_request_id', 'park_id', 'status', 'created_at', 'created_by'], 'integer'],
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
            'park_id' => 'Park ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
