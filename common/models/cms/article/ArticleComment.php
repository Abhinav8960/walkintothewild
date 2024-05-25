<?php

namespace common\models\cms\article;

use Yii;

/**
 * This is the model class for table "article_comment".
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property string $comment
 * @property string $comment_datetime
 * @property int $is_flag
 * @property int $is_approved
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ArticleComment extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use \common\traits\CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_comment';
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
            [['article_id', 'user_id', 'comment', 'comment_datetime', 'is_flag'], 'required'],
            [['article_id', 'user_id', 'is_flag', 'is_approved', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
            [['comment_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'comment_datetime' => 'Comment Datetime',
            'is_flag' => 'Is Flag',
            'is_approved' => 'Is Approved',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
