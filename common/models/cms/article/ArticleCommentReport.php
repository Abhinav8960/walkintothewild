<?php

namespace common\models\cms\article;

use common\models\cms\flagreason\Flagreason;
use common\models\User;
use Yii;

/**
 * This is the model class for table "article_comment_report".
 *
 * @property int $id
 * @property int|null $article_id
 * @property int|null $user_id
 * @property int|null $article_comment_id
 * @property int|null $report_reason_id
 * @property string|null $report_detail
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_browser
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ArticleCommentReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_comment_report';
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
            [['article_id', 'user_id', 'article_comment_id', 'report_reason_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['report_detail'], 'string', 'max' => 512],
            // [['user_device', 'user_platform', 'user_browser'], 'string', 'max' => 50],
            // [['user_ip_address'], 'string', 'max' => 20],
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
            'article_comment_id' => 'Article Comment ID',
            'report_reason_id' => 'Report Reason ID',
            'report_detail' => 'Report Detail',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_browser' => 'User Browser',
            'user_ip_address' => 'User Ip Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'parentname' => 'Article Name',
            'commentname' => 'Comment',
        ];
    }


    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }



    public function getComment()
    {
        return $this->hasOne(ArticleComment::className(), ['id' => 'article_comment_id']);
    }



    public function getReportreason()
    {
        return $this->hasOne(Flagreason::className(), ['id' => 'report_reason_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getParentname()
    {
        return isset($this->article) ? $this->article->title : '';
    }

    public function getCommentname()
    {
        return isset($this->comment) ? $this->comment->comment : '';
    }
}
