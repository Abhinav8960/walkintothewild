<?php

namespace common\models\article\frequency;

use common\traits\CommanRelationship;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**

 *
 * @property int $id
 * @property string $frequency
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Frequency extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_frequency';
    }

    public function behaviors()
    {
        return [            
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::class,
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
            [['frequency', 'status'], 'required'],
            [['id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['frequency'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frequency' => 'Frequency',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
