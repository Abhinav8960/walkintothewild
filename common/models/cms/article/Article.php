<?php

namespace common\models\cms\article;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $sub_title
 * @property string|null $description
 * @property string|null $banner
 * @property string|null $feature_image
 * @property int|null $article_author_id
 * @property string|null $author_name
 * @property string $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $view
 * @property resource|null $post_body
 * @property int|null $comment_allowed
 * @property int|null $approval_required
 * @property int|null $is_schedule
 * @property string|null $publish_date_time
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Article extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'meta_title'], 'required'],
            [['description', 'meta_description', 'meta_keywords', 'post_body'], 'string'],
            [['article_author_id', 'view', 'comment_allowed', 'approval_required', 'is_schedule', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['publish_date_time', 'article_date'], 'safe'],
            [['title', 'banner_image', 'feature_image', 'author_name', 'meta_title'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 300],
            [['sub_title'], 'string', 'max' => 75],
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
            'sub_title' => 'Sub Title',
            'description' => 'Description',
            'banner_image' => 'Banner Image',
            'feature_image' => 'Feature Image',
            'article_author_id' => 'Article Author ID',
            'author_name' => 'Author Name',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'view' => 'View',
            'post_body' => 'Post Body',
            'comment_allowed' => 'Comment Allowed',
            'approval_required' => 'Approval Required',
            'is_schedule' => 'Is Schedule',
            'publish_date_time' => 'Publish Date Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getArticleAuthor()
    {
        return $this->hasOne(ArticleAuthor::className(), ['id' => 'article_author_id']);
    }
}
