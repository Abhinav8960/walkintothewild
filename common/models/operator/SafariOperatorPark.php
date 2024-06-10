<?php

namespace common\models\operator;

use common\models\park\SafariPark;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "safari_operator_park".
 *
 * @property int $id
 * @property int|null $safari_operator_id
 * @property int|null $park_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 */
class SafariOperatorPark extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_operator_park';
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
            [['safari_operator_id', 'park_id', 'status', 'created_at', 'created_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_operator_id' => 'Safari Operator ID',
            'park_id' => 'Park ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id'])->andWhere(['safari_park.status' => 1]);
    }
}
