<?php

namespace common\models\cms\article\form;

use Yii;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleTopic;

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
    public $slug;
    public $description;
    public $article_author_id;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $status;
    public $banner_image;
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
            $this->slug = $this->article_model->slug;
            $this->description = $this->article_model->description;
            $this->article_author_id = $this->article_model->article_author_id;
            $this->meta_title = $this->article_model->meta_title;
            $this->meta_description = $this->article_model->meta_description;
            $this->meta_keywords = $this->article_model->meta_keywords;
            $this->status = $this->article_model->status;
            $this->article_topics = ArticleTopic::find()->select('master_article_topic_id')->where(['corporate_id' => $this->article_model->corporate_id, 'master_blog_id' => $this->article_model->id, 'status' => 1])->column();
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'article_author_id', 'description'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['status', 'article_author_id'], 'integer'],
            [['description', 'meta_description'], 'string'],
            [['banner_image', 'article_topics'], 'safe'],
            [['banner_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'], 'maxSize' => 100 * 1024],
            [['title'], 'string', 'max' => 255],
            [['slug', 'meta_title'], 'string', 'max' => 255],
            [
                'title', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->article_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => Article::className(), 'targetAttribute' => ['title'],
                'message' => 'This Title has already been taken'
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
            'title' => 'Title',
            'slug' => 'Slug',
            'article_author_id' => 'Author Name',
            'banner_image' => 'Banner Image',
            'description' => 'Article Description',
            'meta_title' => 'Meta Title Tag',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
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
    public function UploadFiles()
    {
        $article_model = $this->article_model;
        $file_folder = \Yii::$app->params['datapath'];

        if (!file_exists($file_folder)) {
            mkdir($file_folder);
            chmod($file_folder, 0777);
        }
        $fullpath = $file_folder . '/article/' . $article_model->id;
        \yii\helpers\FileHelper::createDirectory($fullpath, $mode = 0777, $recursive = true);
        if ($file = $this->banner_image) {
            $uploadFileName = 'banner_' . time() . '.' .  $file->extension;
            $file->saveAs($fullpath . '/' . $uploadFileName);
            $article_model->banner = $uploadFileName;
            $article_model->save(false);
        }
    }
}
