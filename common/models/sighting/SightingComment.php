<?php

namespace common\models\sighting;

use common\models\User;
use Yii;

/**
 * This is the model class for table "sighting_comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_posts_id
 * @property int|null $parent_id
 * @property string $comment
 * @property string $dateTime
 * @property int|null $like_counts
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SightingComment extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    const DELETED_BY_ADMIN = 1;
    const PARENT_DELETED = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sighting_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sighting_id', 'parent_id', 'status', 'created_by', 'created_at', 'updated_at', 'updated_by', 'safari_operator_id'], 'integer'],
            [['comment'], 'string'],
            [['dateTime'], 'safe'],
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
            'sighting_id' => 'Sighting ID',
            'parent_id' => 'Parent ID',
            'comment' => 'Comment',
            'dateTime' => 'Comment Datetime',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getSighting()
    {
        return $this->hasOne(Sighting::className(), ['id' => 'sighting_id']);
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getReplies_count()
    {
        return $this->getReplies()->andWhere(['sighting_comment.status' => 1])->count();
    }

    public function getReports()
    {
        return $this->hasMany(SightingCommentFlag::className(), ['sighting_comment_id' => 'id']);
    }
}
