<?php

namespace common\models\suggestions;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "safari_suggestions".
 *
 * @property int $id
 * @property int|null $park_id
 * @property int|null $master_suggestion_id
 * @property int|null $you_are_id
 * @property string $user_agent
 * @property string $ip_address
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class SafariSuggestions extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_suggestions';
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
            [['park_id', 'master_suggestion_id', 'you_are_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_agent', 'ip_address'], 'required'],
            [['user_agent', 'email', 'name'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'park_id' => 'Park ID',
            'master_suggestion_id' => 'Master Suggestion ID',
            'you_are_id' => 'You Are ID',
            'user_agent' => 'User Agent',
            'ip_address' => 'Ip Address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
