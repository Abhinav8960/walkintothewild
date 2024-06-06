<?php

namespace common\models\cms\article\form;

use Yii;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleTopic;
use common\models\GeneralModel;

/**
 * This is the model class for table "master_blog".
 *
 * @property int $id
 * @property int|null $name
 * @property string|null $color_code
 * @property int|null $description
 * @property int|null $status
 */
class ArticleForm extends \yii\base\Model
{
    public $title;
    public $sub_title;
    public $slug;
    public $article_author_id;
    public $author_name;
    public $article_tag_id;
    public $tag_name;
    public $description;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $view;
    public $post_body;
    public $comment_allowed;
    public $approval_required;
    public $article_date;
    public $is_schedule;
    public $publish_date_time;
    public $status;
    public $banner_image;
    public $feature_image;
    public $article_topics;
    public $article_model;
    public $action_url;
    public $action_validate_url;

    /**
     * @param [type] $article_model
     */
    public function __construct(Article $article_model = null)
    {
        $this->article_model = Yii::createObject([
            'class' => Article::className()
        ]);
        if ($article_model != null) {
            $this->article_model = $article_model;
            $this->title = $this->article_model->title;
            $this->banner_image = $this->article_model->banner_image;
            $this->feature_image = $this->article_model->feature_image;
            $this->sub_title = $this->article_model->sub_title;
            $this->slug = $this->article_model->slug;
            $this->description = $this->article_model->description;
            $this->article_author_id = $this->article_model->article_author_id;
            $this->author_name = $this->article_model->author_name;
            $this->article_tag_id = $this->article_model->article_tag_id;
            $this->tag_name = $this->article_model->tag_name;
            $this->meta_title = $this->article_model->meta_title;
            $this->meta_description = $this->article_model->meta_description;
            $this->meta_keywords = $this->article_model->meta_keywords;
            $this->view = $this->article_model->view;
            $this->article_date = $this->article_model->article_date;
            $this->post_body = $this->article_model->post_body;
            $this->comment_allowed = $this->article_model->comment_allowed;
            $this->approval_required = $this->article_model->approval_required;
            $this->is_schedule = $this->article_model->is_schedule;
            $this->publish_date_time = $this->article_model->publish_date_time;
            $this->status = $this->article_model->status;
            // $this->article_topics = ArticleTopic::find()->select('master_article_topic_id')->where(['corporate_id' => $this->article_model->corporate_id, 'master_blog_id' => $this->article_model->id, 'status' => 1])->column();

            $this->article_topics = ArticleTopic::find()->select('master_article_topic_id')->where(['article_id' => $this->article_model->id, 'status' => 1])->column();
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'slug', 'article_tag_id', 'comment_allowed', 'article_topics'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['status', 'article_author_id', 'article_tag_id'], 'integer'],
            [['description', 'meta_description'], 'string'],
            [['article_topics'], 'safe'],
            [
                ['banner_image', 'feature_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 350,
                'maxWidth' => 350,
                'maxHeight' => 350,
                'minHeight' => 350,
                'maxSize' => 100 * 1024,
                'skipOnEmpty' => true,
            ],
            [['title'], 'string', 'max' => 255],
            [['slug', 'meta_title'], 'string', 'max' => 255],
            [
                'title', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->article_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => Article::className(), 'targetAttribute' => ['title'],
                'message' => 'This Title has already been taken'
            ],
            [['description', 'meta_description', 'meta_keywords', 'post_body'], 'string'],
            [['article_author_id', 'view', 'comment_allowed', 'approval_required', 'is_schedule', 'status'], 'integer'],
            [['publish_date_time', 'article_date'], 'safe'],
            [['title', 'author_name', 'meta_title', 'tag_name'], 'string', 'max' => 255],
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
            'banner' => 'Banner',
            'feature_image' => 'Feature Image',
            'banner_image' => 'Banner Image',
            'article_author_id' => 'Article Author',
            'author_name' => 'Author Name',
            'article_tag_id' => 'Article Tag',
            'tag_name' => 'Tag Name',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'view' => 'View',
            'article_date' => 'Article Date',
            'post_body' => 'Post Body',
            'comment_allowed' => 'Comment Allowed',
            'approval_required' => 'Approval Required',
            'is_schedule' => 'Is Schedule',
            'publish_date_time' => 'Publish Date Time',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->article_model->title = $this->title;
        $this->article_model->sub_title = $this->sub_title;
        $this->article_model->slug = $this->slug;
        $this->article_model->description = $this->description;
        $this->article_model->article_author_id = $this->article_author_id;
        if ($this->article_author_id) {
            $this->article_model->author_name =  GeneralModel::authoroption()[$this->article_author_id];
        }
        $this->article_model->article_tag_id = $this->article_tag_id;
        if ($this->article_tag_id) {
            $this->article_model->tag_name =  GeneralModel::tagoption()[$this->article_tag_id];
        }
        $this->article_model->meta_title = $this->meta_title;
        $this->article_model->meta_description = $this->meta_description;
        $this->article_model->meta_keywords = $this->meta_keywords;
        $this->article_model->view = $this->view;
        $this->article_model->article_date = $this->article_date;
        $this->article_model->post_body = $this->post_body;
        $this->article_model->comment_allowed = $this->comment_allowed;
        $this->article_model->approval_required = $this->approval_required;
        $this->article_model->is_schedule = $this->is_schedule;
        $this->article_model->publish_date_time = $this->publish_date_time;
        $this->article_model->status = $this->status;
    }

    /**
     * Upload Banner image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->banner_image) {
            $storagePath = Yii::$app->params['datapath'] . '/article';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->article_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'article_banner' . time() . '.' . $this->banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->banner_image->saveAs($filePath)) {
                $this->article_model->banner_image = $fileName;
                $this->article_model->save(false);
            }
        }

        if ($this->feature_image) {
            $storagePath = Yii::$app->params['datapath'] . '/article';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->article_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'article_feature' . time() . '.' . $this->feature_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->feature_image->saveAs($filePath)) {
                $this->article_model->feature_image = $fileName;
                $this->article_model->save(false);
            }
        }
    }
}
