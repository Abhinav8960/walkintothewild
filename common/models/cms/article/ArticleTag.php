<?php

namespace common\models\cms\article;

use Yii;

/**
 * This is the model class for table "article_tag".
 *
 * @property int $id
 * @property int $article_id
 * @property int $master_article_tag_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class ArticleTag extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_tag';
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
            [['article_id', 'master_article_tag_id'], 'required'],
            [['article_id', 'master_article_tag_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['article_id', 'master_article_tag_id'], 'unique', 'targetAttribute' => ['article_id', 'master_article_tag_id']],
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
            'master_article_tag_id' => 'Master Article Tag ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getArticletag()
    {
        return $this->hasOne(MasterArticleTag::className(), ['id' => 'master_article_tag_id']);
    }
}
