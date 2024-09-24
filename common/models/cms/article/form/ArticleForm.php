<?php

namespace common\models\cms\article\form;


use common\models\cms\article\Article;
use common\models\cms\article\ArticleAuthor;
use common\models\cms\article\ArticleTag;
use common\models\cms\article\ArticleTopic;
use Yii;
use yii\base\Model;

class ArticleForm extends Model
{
  
    public $title;
    public $slug;
    public $article_tags; //it comes from Backend
    public $description;
    public $article_date;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $status;
    public $banner_image;
    public $article_author_id;
    public $article_topics; //it comes from Backend
    public $article_model;
    public $action_url;
    public $action_validate_url;
    // public $user_status;

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
            $this->slug = $this->article_model->slug;  // It generate when i input title
            $this->description = $this->article_model->description;
            $this->article_date = $this->article_model->article_date;
            $this->article_author_id = $this->article_model->article_author_id;
            $this->status = $this->article_model->status;

            $this->meta_title = $this->article_model->meta_title;
            $this->meta_description = $this->article_model->meta_description;
            $this->meta_keywords = $this->article_model->meta_keywords;

            $this->article_topics = ArticleTopic::find()->select('master_topic_id')->where(['article_id' => $this->article_model->id, 'status' => 1])->column();
            $this->article_tags = ArticleTag::find()->select('master_tag_id')->where(['article_id' => $this->article_model->id, 'status' => 1])->column();
           
            
        }
    }


   

    public function rules()
    {
        return [
            [['title', 'description', 'article_tags', 'article_topics','article_author_id'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['status'], 'integer'],
            [['description', 'meta_description','meta_keywords'], 'string'],
            [['article_topics'], 'safe'],
            [['article_authors'], 'safe'],
            [
                ['banner_image'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 250 * 1024,
                'skipOnEmpty' => true,
            ],
            [['title'], 'string', 'max' => 255],
            [['slug', 'meta_title'], 'string', 'max' => 255],
            [
                'title',
                'unique',
                'when' => function ($model, $attribute) {
                    return strtolower($this->article_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => Article::className(),
                'targetAttribute' => ['title'],
                'message' => 'This Title has already been taken'
            ],
            [['description'], 'string'],
            [['article_date'], 'safe'],
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
            'banner' => 'Banner',
            'banner_image' => 'Banner Image',
            'article_author_id' => 'Author',
            'article_tags' => 'Article Tag',
            'tag_name' => 'Tag Name',
            'view' => 'View',
            'article_date' => 'Article Date',
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
        $this->article_model->slug = $this->slug;
        $this->article_model->description = $this->description;
        $this->article_model->article_date = $this->article_date;
        $this->article_model->article_author_id = $this->article_author_id;
        $this->article_model->meta_title = $this->meta_title;
        $this->article_model->meta_description = $this->meta_description;
        $this->article_model->meta_keywords = $this->meta_keywords;
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
