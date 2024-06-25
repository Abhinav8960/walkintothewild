<?php

namespace common\models\cms\article;

use Yii;

/**
 * This is the model class for table "article_topic".
 *
 * @property int $id
 * @property int $article_id
 * @property int $master_article_topic_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ArticleTopic extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use \common\traits\CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_topic';
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
            [['article_id', 'master_article_topic_id'], 'required'],
            [['id', 'article_id', 'master_article_topic_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['article_id', 'master_article_topic_id'], 'unique', 'targetAttribute' => ['article_id', 'master_article_topic_id']],
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
            'master_article_topic_id' => 'Master Article Topic ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getArticlename()
    {
        return $this->hasOne(MasterArticleTopic::class, ['id' => 'master_article_topic_id']);
    }
}
