<?php

namespace common\models\article\articleTag\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\article\articleTag\ArticleTag;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Deployment Phase
 */
class ArticleTagForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $article_tag_model;


    public function __construct(ArticleTag $article_tag_model = null)
    {

        $this->article_tag_model = Yii::createObject([
            'class' => ArticleTag::className()
        ]);



        if ($article_tag_model  != '') {
            $this->article_tag_model = $article_tag_model;
            $this->title =  $this->article_tag_model->title;
            $this->status = $this->article_tag_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
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
        $this->article_tag_model->title = $this->title;
        $this->article_tag_model->status = $this->status;
    }
}
