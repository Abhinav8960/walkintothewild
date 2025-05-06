<?php

namespace common\models\postscomment;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "user_post_comment_like".
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_post_comment_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserPostCommentLike extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_post_comment_like';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_post_comment_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by','safari_operator_id'], 'integer'],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_post_comment_id' => 'User Post Comment ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getUserPostComment()
    {
        return $this->hasOne(UserPostComment::class, ['id' => 'user_post_comment_id']);
    }
}
