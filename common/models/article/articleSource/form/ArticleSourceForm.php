<?php

namespace common\models\article\articleSource\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\article\articleSource\ArticleSource;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Deployment Phase
 */
class ArticleSourceForm extends model
{
    public $article_source;
    public $category_id;
    public $publisher;
    public $frequency_id;
    public $web_link;
    public $status;
    public $status_option = [];
    public $article_source_model;


    public function __construct(ArticleSource $article_source_model = null)
    {

        $this->article_source_model = Yii::createObject([
            'class' => ArticleSource::className()
        ]);



        if ($article_source_model  != '') {
            $this->article_source_model = $article_source_model;
            $this->article_source =  $this->article_source_model->article_source;
            $this->category_id = $this->article_source_model->category_id;
            $this->publisher = $this->article_source_model->publisher;
            $this->frequency_id = $this->article_source_model->frequency_id;
            $this->web_link = $this->article_source_model->web_link;
            $this->status = $this->article_source_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_source'], 'required'],
            [['status','category_id','frequency_id'], 'integer'],
            [['article_source','publisher'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['web_link'], 'url'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'article_source' => 'Article Source',
            'category_id' => 'Category',
            'publisher' => 'Publisher',
            'frequency_id' => 'Frequency',
            'web_link' => 'Web Link',
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
        $this->article_source_model->article_source = $this->article_source;
        $this->article_source_model->category_id = $this->category_id;
        $this->article_source_model->publisher = $this->publisher;
        $this->article_source_model->frequency_id = $this->frequency_id;
        $this->article_source_model->web_link = $this->web_link;
        $this->article_source_model->status = $this->status;
    }
}
