<?php

namespace common\models\cms\article;

use common\models\cms\mastertag\MasterTag;
use common\models\User;
use Yii;

/**
 * This is the model class for table "article".
 *
 */


class Article extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
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
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug', //The attribute to be generated
                'attribute' => 'title', //The attribute from which will be generated
                'maxLength' => 255,
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true
                ]
            ]
        ];
    }


    public function rules()
    {
        return [
            [['description','meta_description', 'meta_keywords',], 'string'],
            [['status', 'article_author_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['article_date'], 'safe'],
            [['title', 'banner_image', 'meta_title'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'banner_image' => 'Banner Image',
            'article_author_id' => 'Article Author ID',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getArticleAuthor()
    {
        return $this->hasOne(MasterArticleAuthor::className(), ['id' => 'article_author_id']);
    }

    public function getArticletag()
    {
        return $this->hasOne(MasterTag::className(), ['id' => 'article_tag_id']);
    }

    public function getArticletopics()
    {
        return $this->hasMany(ArticleTopic::className(), ['article_id' => 'id'])->andWhere(['article_topic.status' => 1]);
    }

    public function getArticletags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id'])->andWhere(['article_tag.status' => 1]);
    }

    public function getArticlecomments()
    {
        return $this->hasMany(ArticleComment::className(), ['article_id' => 'id'])->andWhere(['is_deleted' => 0, 'article_comment.status' => 1]);
    }
   
    public function getBannerimagepath()
    {
        if ($this->banner_image != '') {
            return '/storage/article/' . $this->id . '/' . $this->banner_image;
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
