<?php

namespace common\models\article\article\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\article\article\Article;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Deployment Phase
 */
class ArticleForm extends model
{

    public $article_title;
    public $writer;
    public $source;
    public $post_date;
    public $key_point;
    public $link;
    public $video;
    public $image;
    public $tag_id = [];
    public $tag_id_options = [];
    public $status;
    public $status_option = [];
    public $article_model;


    public function __construct(Article $article_model = null)
    {

        $this->article_model = Yii::createObject([
            'class' => Article::className()
        ]);



        if ($article_model  != '') {
            $this->article_model = $article_model;
            $this->article_title =  $this->article_model->article_title;
            $this->writer =  $this->article_model->writer;
            $this->source =  $this->article_model->source;
            $this->post_date =  $this->article_model->post_date;
            $this->key_point =  $this->article_model->key_point;
            $this->link =  $this->article_model->link;
            $this->video = $this->article_model->video;
            $this->tag_id = (array) json_decode($this->article_model->tag_id, true);
            $this->image = $this->article_model->image;
            $this->status = $this->article_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
        $this->tag_id_options = GeneralModel::articletagoption() ?: [];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status', 'source'], 'integer'],
            [['article_title', 'writer'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            ['post_date', 'date', 'format' => 'php:Y-m-d'],
            [['link'], 'url'],
            [['tag_id'], 'each', 'rule' => ['integer']],
            [['tag_id'], 'safe'],
            [['key_point'], 'validateMaxWords', 'params' => ['max' => 500]],
            [
                ['image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                // 'minWidth' => 285,
                // 'maxWidth' => 285,
                // 'maxHeight' => 285,
                // 'minHeight' => 285,
                //'maxSize' => 250 * 1024
            ],
            [['video'], 'file', 'extensions' => 'mp4'],
        ];
    }
    public function validateMaxWords($attribute, $params)
    {
        $maxWords = $params['max'];
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount > $maxWords) {
            $this->addError($attribute, "The $attribute must not exceed $maxWords words.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'article_title' => 'Article Title',
            'writer' => 'Writer',
            'link' => 'Link',
            'tag_id' => 'Tag',
            'video' => 'Video (mp4)',
            'image' => 'Image  (JPEG /JPG or PNG )',
            'source' => 'Source',
            'post_date' => 'Post Date',
            'key_point' => 'Abstract',
            'status' => 'Status',
        ];
    }
    /**
     * Initial Form Values  
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->article_model->article_title = $this->article_title;
        $this->article_model->writer = $this->writer;
        $this->article_model->link = $this->link;
        $this->article_model->source = $this->source;
        $this->article_model->tag_id = json_encode($this->tag_id);
        $this->article_model->key_point = $this->key_point;
        $this->article_model->post_date = $this->post_date;
        $this->article_model->status = $this->status;
    }
    public function uploadFile()
    {

        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/article';
            // print_r($storagePath);
            // die;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->article_model->id;
            // print_r($storagePath);
            // die;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'article' . time() . '.' . $this->image->extension;
            //print_r($fileName);
            $filePath = $storagePath . '/' . $fileName;
            // print_r($filePath);
            // die;

            if ($this->image->saveAs($filePath)) {
                $this->article_model->image = $fileName;
                $this->article_model->save(false);
            }
        }

        if ($this->video) {
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

            $fileName = 'article' . time() . '.' . $this->video->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->video->saveAs($filePath)) {
                $this->article_model->video = $fileName;
                $this->article_model->save(false);
            }
        }
    }
}
