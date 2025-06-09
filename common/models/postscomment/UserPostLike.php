<?php

namespace common\models\postscomment;

use common\models\UserPosts;
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
class UserPostLike extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_post_like';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['user_id', 'user_post_id', 'version'], 'required'],
            [['user_id', 'user_post_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'safari_operator_id'], 'integer'],
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
            'user_post_id' => 'User Post ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updatePostLikeCount();
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $this->updatePostLikeCount();
        parent::afterDelete();
    }

    public function updatePostLikeCount()
    {
        if ($this->user_post_id) {
            $userposts = UserPosts::find()->where(['status' => UserPosts::STATUS_ACTIVE, 'id' => $this->user_post_id])->one();
            $likes_count = UserPostLike::find()->where(['user_post_id' => $this->user_post_id, 'status' => UserPostLike::STATUS_ACTIVE])->count();
            if ($userposts) {
                $userposts->like_count = $likes_count;
                $userposts->save(false);
            }
        }
    }
}
