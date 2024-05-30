<?php

namespace common\models\park;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "birding_park_month".
 *
 * @property int $id
 * @property int|null $birding_park_id
 * @property int|null $month_id
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class BirdingParkMonth extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'birding_park_month';
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
            [['birding_park_id', 'month_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'birding_park_id' => 'Birding Park ID',
            'month_id' => 'Month ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
