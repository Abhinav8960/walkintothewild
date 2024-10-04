<?php

namespace common\models;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "user_posts".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $type_of_post
 * @property string|null $file
 * @property string|null $caption
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserPosts extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_posts';
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
            [['user_id', 'type_of_post', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['caption'], 'string'],
            [['file'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type_of_post' => 'Type Of Post',
            'file' => 'File',
            'caption' => 'Caption',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getImagepath()
    {
        if ($this->file != '') {
            return '/storage/userpost/' . $this->id . '/' . $this->file;
        }
    }
}
