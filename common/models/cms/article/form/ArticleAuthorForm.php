<?php

namespace common\models\cms\article\form;

use Yii;
use common\models\cms\article\ArticleAuthor;

/**
 * This is the model class for table "article_author".
 *
 * @property int $id
 * @property int|null $status
 */
class ArticleAuthorForm extends \yii\base\Model
{
    public $author_name;
    public $slug;
    public $status;
    public $author_image_file;
    public $article_author_model;
    public $action_url;
    public $action_validate_url;

    /**
     *
     * @param [type] $article_author_model
     */
    public function __construct(ArticleAuthor $article_author_model = null)
    {
        $this->article_author_model = Yii::createObject([
            'class' => ArticleAuthor::className()
        ]);
        if ($article_author_model != null) {
            $this->article_author_model = $article_author_model;
            $this->author_name = $this->article_author_model->author_name;
            $this->slug = $this->article_author_model->slug;
            $this->status = $this->article_author_model->status;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_name'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['status'], 'integer'],
            [['author_name'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 300],
            ['author_image_file', 'safe'],
            [['author_image_file'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'], 'maxSize' => 100 * 1024],
            [
                'author_name', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->article_author_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => ArticleAuthor::className(), 'targetAttribute' => ['author_name'],
                'message' => 'This Author Name has already been taken'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'author_name' => 'Author Name',
            'slug' => 'Slug',
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
        $this->article_author_model->author_name = $this->author_name;
        $this->article_author_model->slug = $this->slug;
        $this->article_author_model->status = $this->status;
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
        if ($file = $this->author_image_file) {
            $uploadFileName = 'banner_' . time() . '.' .  $file->extension;
            $file->saveAs($fullpath . '/' . $uploadFileName);
            $article_model->author_image = $uploadFileName;
            $article_model->save(false);
        }
    }
}
