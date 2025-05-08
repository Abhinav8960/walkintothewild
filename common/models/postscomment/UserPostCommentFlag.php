<?php

namespace common\models\postscomment;

use Yii;

/**
 * This is the model class for table "user_post_comment_flag".
 *
 * @property int $id
 * @property int|null $user_posts_id
 * @property int|null $user_post_comment_id
 * @property int|null $flag_reason_id
 * @property string|null $flag_detail
 * @property int|null $user_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserPostCommentFlag extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_post_comment_flag';
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
            [['user_posts_id', 'user_post_comment_id', 'flag_reason_id', 'flag_detail', 'user_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['user_posts_id', 'user_post_comment_id', 'flag_reason_id', 'user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['flag_detail'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_posts_id' => 'User Posts ID',
            'user_post_comment_id' => 'User Post Comment ID',
            'flag_reason_id' => 'Flag Reason ID',
            'flag_detail' => 'Flag Detail',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

}