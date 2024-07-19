<?php

namespace frontend\models\article;


use common\models\cms\article\Article;
use common\models\cms\article\ArticleTag;
use common\models\cms\article\ArticleTopic;
use common\models\GeneralModel;
use Yii;
use yii\base\Model;

class ArticleForm extends Model
{
    public $user_id;
    public $title;
    public $sub_title;
    public $slug;
    public $article_author_id;
    public $author_name;
    public $article_tags; //it comes from Backend
    public $tag_name;  //it comes from Backend
    public $description;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $view;
    public $post_body;
    public $comment_allowed;
    public $is_approved;
    public $article_date;
    public $is_schedule;
    public $publish_date_time;
    public $status;
    public $banner_image;
    public $feature_image;
    public $article_topics; //it comes from Backend
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
            // $this->feature_image = $this->article_model->feature_image; //Not in use
            $this->sub_title = $this->article_model->sub_title; // I have not input field for it
            $this->slug = $this->article_model->slug;  // It generate when i input title
            $this->description = $this->article_model->description;
            // $this->article_author_id = $this->article_model->article_author_id;  //Not necessary when create article form frontend
            // $this->author_name = $this->article_model->author_name;
            $this->meta_title = $this->article_model->meta_title;
            $this->meta_description = $this->article_model->meta_description;
            $this->meta_keywords = $this->article_model->meta_keywords;
            $this->view = $this->article_model->view;  // Extra Not in use
            $this->article_date = $this->article_model->article_date;
            $this->post_body = $this->article_model->post_body;
            $this->comment_allowed = $this->article_model->comment_allowed;
            $this->is_approved = $this->article_model->is_approved;
            $this->is_schedule = $this->article_model->is_schedule;
            $this->publish_date_time = $this->article_model->publish_date_time;
            $this->status = $this->article_model->status;

            $this->article_topics = ArticleTopic::find()->select('master_article_topic_id')->where(['article_id' => $this->article_model->id, 'status' => 1])->column();
            $this->article_tags = ArticleTag::find()->select('master_article_tag_id')->where(['article_id' => $this->article_model->id, 'status' => 1])->column();
        }
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'user_id', 'title', 'sub_title', 'description', 'article_tags', 'tag_name', 'feature_image', 'banner_image', 'status', 'slug',
            'article_date', 'long_description', 'meta_title', 'meta_description', 'comment_allowed',
            'is_approved', 'is_schedule', 'publish_date_time', 'sequence', 'view', 'post_body', 'meta_keywords', 'article_topics'
        ];
        $scenarios['update'] = [
            'title', 'sub_title', 'description', 'article_tags', 'tag_name', 'status', 'slug', 'banner_image',
            'article_date', 'long_description', 'meta_title', 'meta_description', 'comment_allowed',
            'is_approved', 'is_schedule', 'publish_date_time', 'sequence', 'view', 'post_body', 'meta_keywords', 'article_topics'
        ];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'article_tags', 'comment_allowed', 'article_topics'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['is_approved'], 'default', 'value' => 0],
            [['status', 'article_author_id'], 'integer'],
            [['description', 'meta_description'], 'string'],
            [['article_topics'], 'safe'],
            [
                ['banner_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 940,
                'maxWidth' => 940,
                'maxHeight' => 430,
                'minHeight' => 430,
                'maxSize' => 250 * 1024,
                'skipOnEmpty' => true,
            ],

            // [
            //     ['feature_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
            //     'minWidth' => 350,
            //     'maxWidth' => 350,
            //     'maxHeight' => 350,
            //     'minHeight' => 350,
            //     'maxSize' => 250 * 1024,
            //     'skipOnEmpty' => true,
            // ],
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
            [['article_author_id', 'view', 'comment_allowed', 'is_approved', 'is_schedule', 'status'], 'integer'],
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
            'user_id' => 'User ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'sub_title' => 'Sub Title',
            'description' => 'Description',
            'banner' => 'Banner',
            'feature_image' => 'Feature Image',
            'banner_image' => 'Banner Image',
            'article_author_id' => 'Article Author',
            'author_name' => 'Author Name',
            'article_tags' => 'Article Tag',
            'tag_name' => 'Tag Name',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'view' => 'View',
            'article_date' => 'Article Date',
            'post_body' => 'Post Body',
            'comment_allowed' => 'Comment Allowed',
            'is_approved' => 'Approval Required',
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
        $this->article_model->user_id = Yii::$app->user->identity->id;
        $this->article_model->title = $this->title;
        $this->article_model->sub_title = $this->sub_title;
        $this->article_model->slug = $this->slug;
        $this->article_model->description = $this->description;
        $this->article_model->meta_title = $this->meta_title;
        $this->article_model->meta_description = $this->meta_description;
        $this->article_model->meta_keywords = $this->meta_keywords;
        $this->article_model->view = $this->view;
        $this->article_model->article_date = $this->article_date;
        $this->article_model->post_body = $this->post_body;
        $this->article_model->comment_allowed = $this->comment_allowed;
        $this->article_model->is_approved = $this->is_approved;
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

            $fileName = 'article_banner' . '-' . time() . '.' . $this->banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->banner_image->saveAs($filePath)) {
                $this->article_model->banner_image = $fileName;
                $this->article_model->save(false);
            }
        }

    }
}
